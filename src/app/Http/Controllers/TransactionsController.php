<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\UserBalances;
use App\Models\UserBalancesHistorical;
use App\Models\Users;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class TransactionsController extends Controller
{
    public function __construct(Request $request)
    {
        // Método contrutor para receber as requisições
        $this->request = $request;
    }

    public function create()
    {
        // Define quais campos são obrigatórios
        $this->validate($this->request, [
            'payer' => 'required',
            'payee' => 'required',
            'value' => 'required',
        ]);

        // Formata valores da requisição
        $data = \Sanitizer::make($this->request->all(), Transactions::getRules())->sanitize();

        // Verifica se o Payer existe
        $payerBalance = UserBalances::find($data['payer']);
        if (empty($payerBalance))
            return ResponseHelper::exception('Payer not found', 404, true);

        // Verifica se o Payer é 'Lojista'
        $payer = Users::find($data['payer']);
        if ($payer->fk_type == 2)
            return ResponseHelper::exception('Payer cannot be Lojista', 404, true);

        // Verifica se o Payee existe
        $payeeBalance = UserBalances::find($data['payee']);
        if (empty($payeeBalance))
            return ResponseHelper::exception('Payee not found', 404, true);

        // Salva os saldos atuais em variáveis
        $currentPayerBalance = $payerBalance->balance;
        $currentPayeeBalance = $payeeBalance->balance;

        // Verifica se o Payer possui saldo para transferir
        if ($data['value'] > $currentPayerBalance)
            return ResponseHelper::exception('Payer-Balance insufficient for transaction', 404, true);

        // Executa o serviço autorizador externo
        $externalUrl = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';
        $ch = curl_init(); // Inicia o recurso cURL
        curl_setopt($ch, CURLOPT_URL, $externalUrl); // Define a URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Retorna o transfer como string
        $response = curl_exec($ch); // Executa a URL e retorna como string
        $response_json = json_decode($response, true); // Converte string em json
        curl_close($ch); // Encerra o recurso cURL para liberar os recursos do sistema

        if ($response_json['message'] != 'Autorizado')
            return ResponseHelper::exception('Unauthorized transaction', 404, true);

        // Retira valor do saldo do Payer
        $payerBalance->balance = $currentPayerBalance - $data['value'];
        $payerBalance->save();

        // Cria o registro no histórico de saldo do Payer
        UserBalancesHistorical::create([
            'fk_user' => $data['payer'],
            'fk_balance' => $payerBalance->id,
            'balance' => $payerBalance->balance,
        ]);

        // Adiciona valor no saldo do Payee
        $payeeBalance->balance = $currentPayeeBalance + $data['value'];
        $payeeBalance->save();

        // Cria o registro no histórico de saldo do Payee
        UserBalancesHistorical::create([
            'fk_user' => $data['payee'],
            'fk_balance' => $payeeBalance->id,
            'balance' => $payeeBalance->balance,
        ]);

        // Simulação envio de email/sms notificando o Payee saobre recebimento
        $externalUrl = 'http://o4d9z.mocklab.io/notify';
        $ch = curl_init(); // Inicia o recurso cURL
        curl_setopt($ch, CURLOPT_URL, $externalUrl); // Define a URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Retorna o transfer como string
        $response = curl_exec($ch); // Executa a URL e retorna como string
        $response_json = json_decode($response, true); // Converte string em json
        curl_close($ch); // Encerra o recurso cURL para liberar os recursos do sistema

        if ($response_json['message'] != 'Success')
            return ResponseHelper::exception('Email-SMS not sended', 404, true);

        // Cria o registro da Transação
        Transactions::create($data);

        return ResponseHelper::success('Transaction created');
    }

    public function update($typeId, $id)
    {
        // Busca a Transferência
        $transaction = $this->searchOne($typeId, $id);

        // Verifica se o Tipo de ID é válido
        if ($transaction == 'invalid')
            return ResponseHelper::exception('Type not available', 404, true);

        // Verifica se a Transferência existe
        if (empty($transaction))
            return ResponseHelper::exception('Transaction not found', 404, true);

        // Busca o Saldo do Payer e verifica se existe
        $payerBalance = UserBalances::where(['fk_user' => $transaction->payer])->first();
        if (empty($payerBalance))
            return ResponseHelper::exception('Payer not found', 404, true);

        // Busca o Saldo do Payee e verifica se existe
        $payeeBalance = UserBalances::where('fk_user', $transaction->payee)->first();
        if (empty($payeeBalance))
            return ResponseHelper::exception('Payee not found', 404, true);

        // Salva os saldos atuais em variáveis
        $currentPayerBalance = $payerBalance->balance;
        $currentPayeeBalance = $payeeBalance->balance;

        // Formata valores da requisição
        $data = \Sanitizer::make(Transactions::attributesToUpdate($this->request->all()), Transactions::getRules())->sanitize();

        // Convert string em float e verifica se o valor é zero
        if (floatval($data['value']) == 0)
            return ResponseHelper::exception('Value invalid', 404, true);

        // Calcula a diferença entre o novo valor e o valor atual da transação
        $valueDiff = $data['value'] - $transaction->value;

        // Verifica se a diferença é positiva (retirada de mais valor do saldo do Payer)
        if ($valueDiff > 0) {

            // Verifica se o Payer possui saldo para transferir
            if ($data['value'] > $currentPayerBalance)
                return ResponseHelper::exception('Payer-Balance insufficient for transaction', 404, true);

            // Retira valor da diferença do saldo do Payer
            $payerBalance->balance = $currentPayerBalance - $valueDiff;
            $payerBalance->save();

            // Cria o registro no histórico de saldo do Payer
            UserBalancesHistorical::create([
                'fk_user' => $payerBalance->fk_user,
                'fk_balance' => $payerBalance->id,
                'balance' => $payerBalance->balance,
            ]);

            // Adiciona valor da diferença no saldo do Payee
            $payeeBalance->balance = $currentPayeeBalance + $valueDiff;
            $payeeBalance->save();

            // Cria o registro no histórico de saldo do Payee
            UserBalancesHistorical::create([
                'fk_user' => $payeeBalance->fk_user,
                'fk_balance' => $payeeBalance->id,
                'balance' => $payeeBalance->balance,
            ]);

            // Simulação envio de email/sms notificando o Payee saobre recebimento
            $externalUrl = 'http://o4d9z.mocklab.io/notify';
            $ch = curl_init(); // Inicia o recurso cURL
            curl_setopt($ch, CURLOPT_URL, $externalUrl); // Define a URL
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Retorna o transfer como string
            $response = curl_exec($ch); // Executa a URL e retorna como string
            $response_json = json_decode($response, true); // Converte string em json
            curl_close($ch); // Encerra o recurso cURL para liberar os recursos do sistema

            if ($response_json['message'] != 'Success')
                return ResponseHelper::exception('Email-SMS not sended', 404, true);

        } else {
            // Senão, a diferença é negativa (entrada de dinheiro no saldo do Payer)

            // Adiciona valor da diferença no saldo do Payer
            $payerBalance->balance = $currentPayerBalance + abs($valueDiff);
            $payerBalance->save();

            // Cria o registro no histórico de saldo do Payer
            UserBalancesHistorical::create([
                'fk_user' => $payerBalance->fk_user,
                'fk_balance' => $payerBalance->id,
                'balance' => $payerBalance->balance,
            ]);

            // Simulação envio de email/sms notificando o Payer saobre recebimento
            $externalUrl = 'http://o4d9z.mocklab.io/notify';
            $ch = curl_init(); // Inicia o recurso cURL
            curl_setopt($ch, CURLOPT_URL, $externalUrl); // Define a URL
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Retorna o transfer como string
            $response = curl_exec($ch); // Executa a URL e retorna como string
            $response_json = json_decode($response, true); // Converte string em json
            curl_close($ch); // Encerra o recurso cURL para liberar os recursos do sistema

            // Retira valor da diferença do saldo do Payee
            $payeeBalance->balance = $currentPayeeBalance - abs($valueDiff);
            $payeeBalance->save();

            // Cria o registro no histórico de saldo do Payee
            UserBalancesHistorical::create([
                'fk_user' => $payeeBalance->fk_user,
                'fk_balance' => $payeeBalance->id,
                'balance' => $payeeBalance->balance,
            ]);

        }

        // Salva as atualizações recebidas
        $transaction->fill($data);
        $transaction->save();

        return ResponseHelper::success('Transaction updated');
    }

    public function show($typeId, $id)
    {
        // Busca a Transferência
        $transaction = $this->search($typeId, $id);

        // Verifica se o Tipo de ID é válido
        if ($transaction == 'invalid')
            return ResponseHelper::exception('Type not available', 404, true);

        // Verifica se a Transferência existe
        if (empty($transaction))
            return ResponseHelper::exception('Transaction not found', 404, true);

        // Retorna o registro da Transação
        return ResponseHelper::success('Transaction to show', $transaction->toArray());
    }

    public function getAll()
    {
        // Retorna todos os registros
        $transactions = Transactions::all()->toArray();

        return ResponseHelper::success('All transactions', $transactions);
    }

    public function delete($typeId, $id)
    {
        // Busca a Transferência
        $transaction = $this->searchOne($typeId, $id);

        // Verifica se o Tipo de ID é válido
        if ($transaction == 'invalid')
            return ResponseHelper::exception('Type not available', 404, true);

        // Verifica se a Transferência existe
        if (empty($transaction))
            return ResponseHelper::exception('Transaction not found', 404, true);

        // Realiza soft delete da Transação
        $removed = Transactions::destroy($transaction->id);

        // Verifica se a Transação foi deletada
        if ($removed == 0)
            return ResponseHelper::exception('Transaction not deleted', 402, true);

        return ResponseHelper::success('Transaction deleted');
    }

    public function search($typeId, $id)
    {
        $transaction = '';
        $available_types = ['id', 'payer', 'payee', 'value'];

        // Verifica se o Tipo de ID confere com os tipos disponíveis
        if (!in_array($typeId, $available_types))
            return 'invalid';

        // Busca Transação por ID
        if ($typeId == 'id')
            $transaction = Transactions::find($id);

        // Busca Transação por ID do Payer
        if ($typeId == 'payer')
            $transaction = Transactions::where('payer', $id)->get();

        // Busca Transação por ID do Payee
        if ($typeId == 'payee')
            $transaction = Transactions::where('payee', $id)->get();

        // Busca Transação por Valor
        if ($typeId == 'value')
            $transaction = Transactions::where('value', $id)->get();

        return $transaction;
    }

    public function searchOne($typeId, $id)
    {
        // Busca Transação por ID
        ($typeId == 'id') ? $transaction = Transactions::find($id) : $transaction = 'invalid';

        return $transaction;
    }
}

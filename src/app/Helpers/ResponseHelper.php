<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function formatResponse(&$message, $format)
    {
        // Formata as mensagens de Resposta
        if (!$format) {
            $message = strtolower($message);
            $message = preg_replace('/ /i', '-', $message);
            $message = preg_replace('/\./i', '', $message);
            return $message;
        }

        $message = strtolower($message);
        $arr = explode(' ', $message);
        $response = "";

        foreach ($arr as $key => $value) {
            if ($key > 0) {
                $response .= $value;
                $response .= array_key_last($arr) == $key ? "" : "-";
            }
        }

        return $arr[0] . "." . $response;
    }

    public static function success($message, $params = [], $code = null)
    {
        // Estrutura o retorno Success
        $response = [
            'success' => true,
            'response' => [
                'code' => (isset($code)) ? $code : 200,
                'message' => self::formatResponse($message, true)
            ],
            'params' => $params
        ];

        return response()
            ->json($response, (isset($code)) ? $code : 200);
    }

    public static function exception($message, $code, $format = false, $params = [])
    {
        // Estrutura o retorno Exception
        $response = [
            'success' => false,
            'response' => [
                'code' => $code,
                'message' => self::formatResponse($message, $format),
            ],
            'params' => $params
        ];

        return response()
            ->json($response, ($code) ? $code : 500);
    }

    public static function postman($data, $type = 'json', $die = true)
    {
        // Formata o retorno para debug no postman
        if ($type == 'json') {

            header("Access-Control-Allow-Origin: *");
            header('Content-Type: application/json');
            echo json_encode($data);

        } else if ($type == 'var_dump') {

            var_dump($data);
            echo '<br/><br/><br/>';

        } else if ($type == 'string') {

            echo $data.'<br/><br/><br/>';

        } else {

            var_dump($data);

        }

        if ($die) die;
    }

}

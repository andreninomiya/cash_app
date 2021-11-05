<?php

namespace App\Helpers;

class ResponseHelper
{

    public static function success(string $message, array $params = [], int $code = null)
    {

        $response = [
            'success' => true,
            'response' => [
                'code' => (isset($code)) ? $code : 200,
                'message' => self::formatResponseMessage($message, true)
            ],
            'params' => $params
        ];

        return response()
            ->json($response, (isset($code)) ? $code : 200);
    }

    public static function exception(string $message, int $code, bool $format = false, array $params = [])
    {
        $response = [
            'success' => false,
            'response' => [
                'code' => $code,
                'message' => self::formatResponseMessage($message, $format),
            ],
            'params' => $params
        ];

        return response()
            ->json($response, ($code) ? $code : 500);
    }

    public static function formatResponseMessage(&$message, $format)
    {

        if (!$format){
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

    public static function postman($data, $type='json', $die=true)
    {

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

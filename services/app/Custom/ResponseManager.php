<?php

namespace App\Custom;

use Illuminate\Support\Facades\Log;

class ResponseManager {
    public static function setSuccessResponse($HttpCode = 200, $message = '', $data = '') {
        if (empty($data)) return response([
            "status"    => true,
            "message"   => $message,
        ], $HttpCode);

        return response([
            "status"    => true,
            "message"   => $message,
            "data"      => $data,
        ], $HttpCode);
    }

    public static function setCrudErrors($CodHttp = 400, $message = '', $data = '') {
        return response([
            "status"    => true,
            "message"   => $message,
            "data"      => $data,
        ], $CodHttp);
    }

    /**
     * Función setErrorServerResponse
     * Método para responder en estatus HTTP 500, para indicar por medio de api que ha ocurrido un error interno de servidor,
     * asi mismo genera un archivo log, con el contenido del error generado para poder visualizar lo ocurrido.
     * @param string $error Recibe la excepción obtenida en el catch de Exception
     * @param string $location Recibe el nombre del archivo donde se originó el error
     * @param string $keyError Recibe el nombre de la función, sección u otro dato relevante para identificar más preciso el origen del error
     * @param boolean $viewError Determina si en el objeto response, se mostrará o no el mensaje de resumen del error.
     *
     * */
    public static function setErrorServerResponse($error = '', $location = '', $keyError = '', $viewError = false) {

        self::createLog($error, $location, $keyError);

        return response([
            "status"    => false,
            "message"   => "Internal_error!",
            "error"     => ($viewError ? $error->getMessage() : ''),
        ], 500);
    }

    public static function createLog($error = '', $location = '', $keyError = '') {
        $currentDate    = date('Y-m-d-H-i-s');
        $completePath   = "logs/" . $currentDate . "_" . $keyError . "_" . $location . ".log";

        Log::build([
            'driver'    => 'single',
            'path'      => storage_path($completePath),
        ])->info($error);
    }
}

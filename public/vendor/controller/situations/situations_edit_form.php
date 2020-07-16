<?php
/**
 * Created by MyCode
 * user: KEVEN
 * Date: 04/06/2020
 * Time: 10:49
 *
 */

/** Importo as classes que irei utilizar **/
use \vendor\model\Main;
use \vendor\model\Situation;
use \vendor\model\ArrayUtf8Encode;

/** Instânciamento das classes **/
$main = new Main();
$situation = new Situation();
$arrayUtf8Encode = new ArrayUtf8Encode();

try {

    if ($main->verifySession()){

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        /** Parâmetros de entrada  **/
        $situation_id = isset($inputs['inputs']['situation_id']) ? (int)$main->antiInjection($inputs['inputs']['situation_id']) : 0;

        /** Controle de erros **/
        $message = array();

        /** Verifico se o campo é válido **/
        if ($situation_id <= 0) {
            array_push($message, 'O campo "$situation_id", deve ser preenchido');
        }

        /** Verifico se existem erros **/
        if (count($message) > 0) {

            /** Retorno **/
            $result = array(
                "cod" => 0,
                "result" => $message
            );
        } else {

            /** Retorno **/
            $result = array(
                "cod" => 1,
                "result" => $arrayUtf8Encode->utf8Converter($situation->editForm($situation_id))
            );
        }

    }else{

        /** Preparo o formulario para retorno **/
        $result = array(
            "cod" => 404,
            "message" => "Usuário não autenticado",
        );

    }

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;
} catch (Exception $e) {

    /** Preparo o formulario para retorno **/
    $result = array(
        "cod" => 0,
        "message" => $e->getMessage()
    );

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;
}

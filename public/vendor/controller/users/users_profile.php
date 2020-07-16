<?php
/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 **/

/** Importo as classes que irei utilizar **/
use \vendor\model\Main;
use \vendor\model\User;
use \vendor\model\ArrayUtf8Encode;

/** Instânciamento das classes importadas **/
$main = new Main();
$user = new User();
$arrayUtf8Encode = new ArrayUtf8Encode();

try {

    if ($main->verifySession()){

        /** Parâmetros de entrada  **/
        $user_id = isset($inputs['inputs']['user_id']) ? (int)$main->antiInjection($inputs['inputs']['user_id']) : 0;

        /** Controle de erros **/
        $message = array();

        /** Verifico se o campo é válido **/
        if ($user_id <= 0) {
            array_push($message, "O campo 'UserId', deve ser preenchido");
        }

        /** Verifico se existem erros **/
        if (count($message) > 0) {

            /** Result **/
            $result = array(

                "cod" => 0,
                "result" => $message

            );
        } else {

            /** Result **/
            $result = array(

                "cod" => 1,
                "result" => $arrayUtf8Encode->utf8Converter($user->getUserProfile($user_id))

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
        "message" => $e->getMessage(),

    );

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;
}

<?php
/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 *
 */

/** Importo as classes que irei utilizar **/
use \vendor\model\Main;
use \vendor\model\Methods;
use \vendor\model\ArrayUtf8Encode;

/** Instânciamento das classes **/
$main = new Main();
$methods = new Methods();
$arrayUtf8Encode = new ArrayUtf8Encode();

try {

    if ($main->verifySession()){

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        /** Parâmetros de entrada **/
        $class_id = isset($inputs['inputs']['class_id']) ? (int)$main->antiInjection($inputs['inputs']['class_id']) : 0;

        /** Controle de erros **/
        $message = array();

        /** Validação de campos obrigatórios **/
        /** Verifico se o campo class_id foi preenchido **/
        if ($class_id <= 0) {
            array_push($message, '$class_id - O seguinte campo deve ser preenchido/selecionado');
        }

        /** Verifico se existem erros **/
        if (count($message) > 0) {

            /** Preparo o formulario para retorno **/
            $result = array(

                "cod" => 0,
                "message" => $message

            );

        } else {

            /** Result **/
            $result = array(
                "result" => $arrayUtf8Encode->utf8Converter($methods->methodsInClass($class_id))
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

<?php
/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 *
 */

/** Realizo a importação de classes **/
use \vendor\model\Main;
use \vendor\model\Methods;

/** Instânciamento das classes importadas **/
$main = new Main();
$methods = new Methods();

try {

    if ($main->verifySession()){

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        /** Parâmetros de entrada **/
        $method_id     = isset($inputs['inputs']['method_id'])     ? (int)$main->antiInjection($inputs['inputs']['method_id'])          : 0;
        $situation_id  = isset($inputs['inputs']['situation_id'])  ? (int)$main->antiInjection($inputs['inputs']['situation_id'])       : 0;
        $user_id       = isset($inputs['inputs']['user_id'])       ? (int)$main->antiInjection($inputs['inputs']['user_id'])            : $_SESSION['MYCODE-USER-ID'];
        $class_id      = isset($inputs['inputs']['class_id'])      ? (int)$main->antiInjection($inputs['inputs']['class_id'])           : 0;
        $name          = isset($inputs['inputs']['name'])          ? (string)$main->antiInjection($inputs['inputs']['name'])            : '';
        $description   = isset($inputs['inputs']['description'])   ? (string)$main->antiInjection($inputs['inputs']['description'])     : '';
        $type          = isset($inputs['inputs']['type'])          ? (string)$main->antiInjection($inputs['inputs']['type'])            : '';
        $code          = isset($inputs['inputs']['code'])          ? (string)$main->antiInjection($inputs['inputs']['code'], 'S') : '';
        $version       = isset($inputs['inputs']['version'])       ? (string)$main->antiInjection($inputs['inputs']['version'])         : '';
        $release       = isset($inputs['inputs']['release'])       ? (string)$main->antiInjection($inputs['inputs']['release'])         : '';
        $date_register = isset($inputs['inputs']['date_register']) ? (string)$main->antiInjection($inputs['inputs']['date_register'])   : date("y-m-d h:m:s");
        $date_update   = isset($inputs['inputs']['date_update'])   ? (string)$main->antiInjection($inputs['inputs']['date_update'])     : date("y-m-d h:m:s");

        /** Controle de Erros **/
        $message = array();

        /** Validação de campos obrigatórios **/
        /** Verifico se o campo situation_id foi preenchido **/
        if ($method_id < 0) {
            array_push($message, '$situation_id - O seguinte campo deve ser preenchido/selecionado');
        }
        if ($situation_id <= 0) {
            array_push($message, '$situation_id - O seguinte campo deve ser preenchido/selecionado');
        }
        if ($user_id <= 0) {
            array_push($message, '$situation_id - O seguinte campo deve ser preenchido/selecionado');
        }
        if ($class_id <= 0) {
            array_push($message, '$situation_id - O seguinte campo deve ser preenchido/selecionado');
        }
        /** Verifico se o campo name foi preenchido **/
        if (empty($name)) {
            array_push($message, '$name - O seguinte campo deve ser preenchido/selecionado');
        }
        /** Verifico se o campo date_register foi preenchido **/
        if (empty($description)) {
            array_push($message, '$description - O seguinte campo deve ser preenchido/selecionado');
        }
        /** Verifico se o campo date_update foi preenchido **/
        if (empty($type)) {
            array_push($message, '$type - O seguinte campo deve ser preenchido/selecionado');
        }
        /** Verifico se o campo name foi preenchido **/
        if (empty($code)) {
            array_push($message, '$code - O seguinte campo deve ser preenchido/selecionado');
        }
        /** Verifico se o campo date_register foi preenchido **/
        if (empty($version)) {
            array_push($message, '$version - O seguinte campo deve ser preenchido/selecionado');
        }
        /** Verifico se o campo date_update foi preenchido **/
        if (empty($release)) {
            array_push($message, '$release - O seguinte campo deve ser preenchido/selecionado');
        }

        /** Verifico a existência de erros **/
        if (count($message) > 0) {

            /** Preparo o formulario para retorno **/
            $result = array(
                "cod" => 0,
                "message" => $message
            );
        } else {

            $methods->save($method_id, $situation_id, $user_id, $class_id, $name, $description, $type, $code, $version, $release, $date_register, $date_update);

            /** Result **/
            $result = array(
                "cod" => 1,
                "message" => "Informações atualizadas com sucesso!"
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

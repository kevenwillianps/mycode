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
use \vendor\model\Classes;

/** Instânciamento das classes importadas **/
$main = new Main();
$classes = new Classes();

try {

    if ($main->verifySession()){

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        $class_id      = isset($inputs['inputs']['class_id'])      ? (int)$main->antiInjection($inputs['inputs']['class_id'])         : 0;
        $situation_id  = isset($inputs['inputs']['situation_id'])  ? (int)$main->antiInjection($inputs['inputs']['situation_id'])     : 0;
        $user_id       = isset($inputs['inputs']['user_id'])       ? (int)$main->antiInjection($inputs['inputs']['user_id'])          : $_SESSION['MYCODE-USER-ID'];
        $project_id    = isset($inputs['inputs']['project_id'])    ? (int)$main->antiInjection($inputs['inputs']['project_id'])       : 0;
        $folder_id     = isset($inputs['inputs']['folder_id'])     ? (int)$main->antiInjection($inputs['inputs']['folder_id'])        : 1;
        $name          = isset($inputs['inputs']['name'])          ? (string)$main->antiInjection($inputs['inputs']['name'])          : '';
        $description   = isset($inputs['inputs']['description'])   ? (string)$main->antiInjection($inputs['inputs']['description'])   : '';
        $version       = isset($inputs['inputs']['version'])       ? (string)$main->antiInjection($inputs['inputs']['version'])       : '';
        $release       = isset($inputs['inputs']['release'])       ? (string)$main->antiInjection($inputs['inputs']['release'])       : '';
        $date_register = isset($inputs['inputs']['date_register']) ? (string)$main->antiInjection($inputs['inputs']['date_register']) : date("y-m-d h:m:s");
        $date_update   = isset($inputs['inputs']['date_update'])   ? (string)$main->antiInjection($inputs['inputs']['date_update'])   : date("y-m-d h:m:s");

        /** Controle de Erros **/
        $message = array();

        /** Validação de campos obrigatórios **/
        /** Verifico se o campo situation_id foi preenchido **/
        if ($class_id < 0) {
            array_push($message, 'O campo "$class_id", deve ser preenchido');
        }
        if ($situation_id < 0) {
            array_push($message, 'O campo "$situation_id", deve ser preenchido');
        }
        if ($user_id < 0) {
            array_push($message, 'O campo "$user_id", deve ser preenchido');
        }
        if ($project_id < 0) {
            array_push($message, 'O campo "$project_id", deve ser preenchido');
        }
        if ($folder_id < 0) {
            array_push($message, 'O campo "$folder_id", deve ser preenchido');
        }
        if (empty($name)) {
            array_push($message, 'O campo "$name", deve ser preenchido');
        }
        if (empty($description)) {
            array_push($message, 'O campo "$description", deve ser preenchido');
        }
        if (empty($version)) {
            array_push($message, 'O campo "$version", deve ser preenchido');
        }
        if (empty($release)) {
            array_push($message, 'O campo "$release", deve ser preenchido');
        }
        if (empty($date_register)) {
            array_push($message, 'O campo "$date_register", deve ser preenchido');
        }
        if (empty($date_update)) {
            array_push($message, 'O campo "$date_update", deve ser preenchido');
        }

        /** Verifico a existência de erros **/
        if (count($message) > 0) {

            /** Preparo o formulario para retorno **/
            $result = array(
                "cod" => 0,
                "result" => $message
            );
        } else {

            $classes->save($class_id, $situation_id, $user_id, $project_id, $folder_id, $name, $description, $version, $release, $date_register, $date_update);

            /** Result **/
            $result = array(
                "cod" => 1,
                "result" => "Informações atualizadas com sucesso!"
            );
        }

    }else{

        /** Preparo o formulario para retorno **/
        $result = array(
            "cod" => 404,
            "result" => "Usuário não autenticado",
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

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
use \vendor\model\Projects;

/** Instânciamento das classes importadas **/
$main = new Main();
$projects = new Projects();

try {

    /** Verifico se existe usuário logado */
    if ($main->verifySession()){

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        $project_id        = isset($inputs['inputs']['project_id'])        ? (int)$main->antiInjection($inputs['inputs']['project_id'])           : 0;
        $situation_id      = isset($inputs['inputs']['situation_id'])      ? (int)$main->antiInjection($inputs['inputs']['situation_id'])         : 0;
        $user_id           = isset($inputs['inputs']['user_id'])           ? (int)$main->antiInjection($inputs['inputs']['user_id'])              : $_SESSION['MYCODE-USER-ID'];
        $name              = isset($inputs['inputs']['name'])              ? (string)$main->antiInjection($inputs['inputs']['name'])              : '';
        $description       = isset($inputs['inputs']['description'])       ? (string)$main->antiInjection($inputs['inputs']['description'])       : '';
        $version           = isset($inputs['inputs']['version'])           ? (string)$main->antiInjection($inputs['inputs']['version'])           : '';
        $release           = isset($inputs['inputs']['release'])           ? (string)$main->antiInjection($inputs['inputs']['release'])           : '';
        $database_local    = isset($inputs['inputs']['database_local'])    ? (string)$main->antiInjection($inputs['inputs']['database_local'])    : '';
        $database_name     = isset($inputs['inputs']['database_name'])     ? (string)$main->antiInjection($inputs['inputs']['database_name'])     : '';
        $database_user     = isset($inputs['inputs']['database_user'])     ? (string)$main->antiInjection($inputs['inputs']['database_user'])     : '';
        $database_password = isset($inputs['inputs']['database_password']) ? (string)$main->antiInjection($inputs['inputs']['database_password']) : '';
        $path              = isset($inputs['inputs']['path'])              ? (string)$main->antiInjection($inputs['inputs']['path'])              : '';
        $date_register     = isset($inputs['inputs']['date_register'])     ? (string)$main->antiInjection($inputs['inputs']['date_register'])     : date("y-m-d h:m:s");
        $date_update       = isset($inputs['inputs']['date_update'])       ? (string)$main->antiInjection($inputs['inputs']['date_update'])       : date("y-m-d h:m:s");

        /** Controle de Erros **/
        $message = array();

        /** Validação de campos obrigatórios **/
        /** Verifico se o campo situation_id foi preenchido **/
        if ($project_id < 0) {
            array_push($message, 'O campo "ProjetoId", deve ser preenchido');
        }
        if ($situation_id < 0) {
            array_push($message, 'O campo "Situação", deve ser preenchido');
        }
        if ($user_id < 0) {
            array_push($message, 'O campo "Usuário", deve ser preenchido');
        }
        /** Verifico se o campo name foi preenchido **/
        if (empty($name)) {
            array_push($message, 'O campo "Nome", deve ser preenchido');
        }
        /** Verifico se o campo description foi preenchido **/
        if (empty($description)) {
            array_push($message, 'O campo "Descrição", deve ser preenchido');
        }
        /** Verifico se o campo date_register foi preenchido **/
        if (empty($version)) {
            array_push($message, 'O campo "Versão", deve ser preenchido');
        }
        /** Verifico se o campo date_update foi preenchido **/
        if (empty($release)) {
            array_push($message, 'O campo "Release", deve ser preenchido');
        }
        /** Verifico se o campo name foi preenchido **/
        if (empty($database_local)) {
            array_push($message, 'O campo "Caminho do Banco de Dados", deve ser preenchido');
        }
        /** Verifico se o campo description foi preenchido **/
        if (empty($database_name))
        {
            array_push($message, 'O campo "Nome do Banco de Dados", deve ser preenchido');
        }
        /** Verifico se o campo date_register foi preenchido **/
        if (empty($database_user)) {
            array_push($message, 'O campo "Usuário do Banco de Dados", deve ser preenchido');
        }
        /** Verifico se o campo description foi preenchido **/
        if (empty($path)) {
            array_push($message, 'O campo "Caminho", deve ser preenchido');
        }
        /** Verifico se o campo date_register foi preenchido **/
        if (empty($date_register)) {
            array_push($message, 'O campo "DataDeRegistro", deve ser preenchido');
        }
        /** Verifico se o campo date_update foi preenchido **/
        if (empty($date_update)) {
            array_push($message, 'O campo "DataDeAtualização", deve ser preenchido');
        }

        /** Verifico a existência de erros **/
        if (count($message) > 0) {

            /** Preparo o formulario para retorno **/
            $result = array(

                "cod" => 0,
                "result" => $message

            );

        } else {

            /** Executo o método */
            $projects->save($project_id, $situation_id, $user_id, $name, $description, $version, $release, $database_local, $database_name, $database_user, $database_password, $path, $date_register, $date_update);

            /** Result **/
            $result = array(

                "cod" => 1,
                "project_id" => $projects->getLast()->project_id,
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

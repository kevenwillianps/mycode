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
use \vendor\model\Projects;

/** Instânciamento das classes importadas **/
$main = new Main();
$classes = new Classes();
$projects = new Projects();

try {

    if ($main->verifySession()){

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        $class_id      = isset($inputs['inputs']['class_id'])      ? (int)$main->antiInjection($inputs['inputs']['class_id'])         : 0;
        $situation_id  = isset($inputs['inputs']['situation_id'])  ? (int)$main->antiInjection($inputs['inputs']['situation_id'])     : 1;
        $user_id       = isset($inputs['inputs']['user_id'])       ? (int)$main->antiInjection($inputs['inputs']['user_id'])          : $_SESSION['MYCODE-USER-ID'];
        $project_id    = isset($inputs['inputs']['project_id'])    ? (int)$main->antiInjection($inputs['inputs']['project_id'])       : 0;
        $folder_id     = isset($inputs['inputs']['folder_id'])     ? (int)$main->antiInjection($inputs['inputs']['folder_id'])        : 0;
        $name          = isset($inputs['inputs']['name'])          ? (string)$main->antiInjection($inputs['inputs']['name'])          : '';
        $description   = isset($inputs['inputs']['description'])   ? (string)$main->antiInjection($inputs['inputs']['description'])   : '';
        $version       = isset($inputs['inputs']['version'])       ? (int)$main->antiInjection($inputs['inputs']['version'])          : 1;
        $release       = isset($inputs['inputs']['release'])       ? (int)$main->antiInjection($inputs['inputs']['release'])          : 1;
        $date_register = isset($inputs['inputs']['date_register']) ? (string)$main->antiInjection($inputs['inputs']['date_register']) : date("y-m-d h:m:s");
        $date_update   = isset($inputs['inputs']['date_update'])   ? (string)$main->antiInjection($inputs['inputs']['date_update'])   : date("y-m-d h:m:s");
        $database_name = isset($inputs['inputs']['database_name']) ? (string)$main->antiInjection($inputs['inputs']['database_name']) : '';

        /** Controle de Erros **/
        $message = array();

        /** Verifico se é um campo válido **/
        if ($project_id < 0) {

            array_push($message, 'O campo "$project_id", deve ser preenchido');

        }

        /** Verifico se é um campo válido **/
        if (empty($database_name)) {

            array_push($message, 'O campo "$database_name", deve ser preenchido');

        }

        /** Verifico a existência de erros **/
        if (count($message) > 0) {

            /** Preparo o formulario para retorno **/
            $result = array(

                "cod" => 0,
                "result" => $message

            );

        }
        else
        {

            /** Busco o registro solicitado **/
            $row = $projects->get($project_id);

            /** Verifico se existe o registro **/
            if (isset($row))
            {

                /** Verfico se o registro é válido **/
                if ($row->project_id > 0)
                {

                    /** Localizo as classes **/
                    foreach($classes->findClasses($database_name) as $key => $result){

                        /** Salvo as classes **/
                        $classes->save($class_id, $situation_id, $user_id, $project_id, $folder_id, $main->nameClass($result['table_name']), $main->descriptionClass($result['table_name']), $version, $release, $date_register, $date_update);

                    }

                    /** Result **/
                    $result = array(

                        "cod" => 1,
                        "result" => "Informações atualizadas com sucesso!",
                        "classes" => $classes->all($project_id),
                        "tables" => $classes->findClasses($database_name),

                    );

                }
                else
                {

                    array_push($message, "Registro inválido");

                    /** Preparo o formulario para retorno **/
                    $result = array(

                        "cod" => 0,
                        "result" => $message,

                    );

                }

            }
            else
            {

                array_push($message, "Registro não localizado");

                /** Preparo o formulario para retorno **/
                $result = array(

                    "cod" => 0,
                    "result" => $message,

                );

            }

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

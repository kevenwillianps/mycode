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
use \vendor\model\Classes;
use \vendor\model\Projects;
use \vendor\model\ArrayUtf8Encode;

/** Instânciamento das classes **/
$main = new Main();
$classes = new Classes();
$projects = new Projects();
$arrayUtf8Encode = new ArrayUtf8Encode();

try {

    if ($main->verifySession()){

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        /** Parâmetros de entrada  **/
        $project_id = isset($inputs['inputs']['project_id']) ? (int)$main->antiInjection($inputs['inputs']['project_id']) : 0;
        $database_name = isset($inputs['inputs']['database_name']) ? (string)$main->antiInjection($inputs['inputs']['database_name']) : '';

        /** Controle de erros **/
        $message = array();

        /** Verifico se o campo é válido **/
        if (($project_id <= 0) || (empty($database_name)))
        {

            /** Preencho a array de erros */
            array_push($message, 'O campo "$project_id" ou "$database_name", deve ser preenchido');

        }

        /** Verifico se existem erros **/
        if (count($message) > 0) {

            /** Retorno **/
            $result = array(

                "cod" => 0,
                "result" => $message

            );

        } else {

            /** Verifico se irei verificar pelo ID do projeto */
            if ($project_id > 0){

                /** Pego o projeto */
                $rowProject = $projects->get($project_id);

                /** Verifico se foi localizdo o projeto */
                if (isset($rowProject))
                {

                    /** Verifico se é um registro válido */
                    if ($rowProject->project_id > 0)
                    {

                        /** Retorno **/
                        $result = array(

                            "cod" => 1,
                            "result" => $arrayUtf8Encode->utf8Converter($classes->findClasses($rowProject->database_name))

                        );

                    }
                    else
                    {

                        /** Preencho a array de erros */
                        array_push($message, 'Registro inválido');

                        /** Retorno **/
                        $result = array(

                            "cod" => 0,
                            "result" => $message

                        );

                    }

                }
                else
                {

                    /** Preencho a array de erros */
                    array_push($message, 'Registro não localizado');

                    /** Retorno **/
                    $result = array(

                        "cod" => 0,
                        "result" => $message

                    );

                }

            }
            elseif (!empty($database_name)) /** Verifico se irei gerar pelo nome do banco de dados */
            {

                /** Retorno **/
                $result = array(

                    "cod" => 1,
                    "result" => $arrayUtf8Encode->utf8Converter($classes->findClasses($database_name))

                );

            }

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

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
use \vendor\model\ProjectLogs;

/** Instânciamento das classes importadas **/
$main = new Main();
$projects = new Projects();
$projectLogs = new ProjectLogs();

/** Verifico se existe sessão */
if ($main->verifySession())
{

    try
    {

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input') , true);

        /** Parâmetros de Entrada */
        $project_id = isset($inputs['inputs']['project_id']) ? (int)$main->antiInjection($inputs['inputs']['project_id']) : 0;
        $project_log_id = isset($inputs['inputs']['project_log_id']) ? (int)$main->antiInjection($inputs['inputs']['project_log_id']) : 0;

        /** Controle de Erros **/
        $message = array();

        /** Validação de campos obrigatórios **/
        /** Verifico se o campo situation_id foi preenchido **/
        if ($project_id < 0)
        {
            array_push($message, 'O campo "ProjetoId", deve ser preenchido');
        }

        if ($project_log_id < 0)
        {
            array_push($message, 'O campo "ProjetoLogId", deve ser preenchido');
        }

        /** Verifico a existência de erros **/
        if (count($message) > 0)
        {

            /** Preparo o formulario para retorno **/
            $result = array(

                "cod" => 0,
                "result" => $message

            );

        }
        else
        {

            /** Busco um histórico */
            $resultProjectLog = $projectLogs->get($project_log_id);

            /** Verifico se vou salvar o log */
            if (isset($resultProjectLog))
            {

                /** Busco um histórico */
                $resultProjects = $projects->get($project_id);

                /** Verifico se existe o registro **/
                if (isset($resultProjects))
                {

                    /** Salvo o log */
                    if ($projectLogs->save(0, $resultProjects->project_id, $resultProjects->user_id, $resultProjects->name, $resultProjects->description, $resultProjects->version, $resultProjects->release, $resultProjects->database_local, $resultProjects->database_name, $resultProjects->database_user, $resultProjects->database_password, $resultProjects->path, $resultProjects->date_register, $resultProjects->date_update))
                    {

                        /** Executo o método */
                        $projects->save($resultProjects->project_id, 1, $resultProjectLog->user_id, $resultProjectLog->name, $resultProjectLog->description, $resultProjectLog->version, $resultProjectLog->release, $resultProjectLog->database_local, $resultProjectLog->database_name, $resultProjectLog->database_user, $resultProjectLog->database_password, $resultProjectLog->path, $resultProjects->date_register, $resultProjects->date_update);

                        /** Result **/
                        $result = array(

                            "cod" => 1,
                            "project_id" => $projects->getLast()->project_id,
                            "result" => "Informações atualizadas com sucesso!"

                        );

                    }
                    else
                    {

                        /** Adiciono a mensagem de sucesso */
                        array_push($message, "Não foi possivel salvar o log");

                        /** Result **/
                        $result = array(

                            "cod" => 0,
                            "message" => $message

                        );

                    }

                } else {

                    /** Adiciono a mensagem de erro */
                    array_push($message, "Projeto não Localizado");

                    /** Result **/
                    $result = array(

                        "cod" => 0,
                        "message" => $message

                    );

                }

            }
            else
            {

                /** Adiciono a mensagem de erro */
                array_push($message, "Histórico Não Localizado");

                /** Result **/
                $result = array(

                    "cod" => 1,
                    "project_id" => $projects->getLast()->project_id,
                    "result" => "Informações atualizadas com sucesso!"

                );

            }

        }

    }
    catch(Exception $e)
    {
        /** Preparo o formulario para retorno **/
        $result = array(

            "cod" => 0,
            "result" => $e->getMessage()

        );

    }
    finally
    {

        /** Envio **/
        echo json_encode($result);

        /** Paro o procedimento **/
        exit;

    }

}
else
{

    /** Preparo o formulario para retorno **/
    $result = array(

        "cod" => 404,
        "message" => "Usuário não autenticado",

    );

    /** Envio **/
    echo json_encode($result);
    /** Paro o procedimento **/
    exit;

}
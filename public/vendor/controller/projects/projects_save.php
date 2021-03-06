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
        $project_id = isset($inputs['inputs']['project_id']) ? (int)$main->antiInjection($inputs['inputs']['project_id']) : 0;
        $situation_id = isset($inputs['inputs']['situation_id']) ? (int)$main->antiInjection($inputs['inputs']['situation_id']) : 0;
        $user_id = isset($inputs['inputs']['user_id']) ? (int)$main->antiInjection($inputs['inputs']['user_id']) : $_SESSION['MYCODE-USER-ID'];
        $name = isset($inputs['inputs']['name']) ? (string)$main->antiInjection($inputs['inputs']['name']) : '';
        $description = isset($inputs['inputs']['description']) ? (string)$main->antiInjection($inputs['inputs']['description']) : '';
        $version = isset($inputs['inputs']['version']) ? (string)$main->antiInjection(date('Y') . '.' . date('m')) : date('Y') . '.' . date('m');
        $release = isset($inputs['inputs']['release']) ? (string)$main->antiInjection((int)$inputs['inputs']['release'] + 1) : ((int)$inputs['inputs']['release'] + 1);
        $database_local = isset($inputs['inputs']['database_local']) ? (string)$main->antiInjection($inputs['inputs']['database_local']) : '';
        $database_name = isset($inputs['inputs']['database_name']) ? (string)$main->antiInjection($inputs['inputs']['database_name']) : '';
        $database_user = isset($inputs['inputs']['database_user']) ? (string)$main->antiInjection($inputs['inputs']['database_user']) : '';
        $database_password = isset($inputs['inputs']['database_password']) ? (string)$main->antiInjection($inputs['inputs']['database_password']) : '';
        $path = isset($inputs['inputs']['path']) ? (string)$main->antiInjection($inputs['inputs']['path']) : '';
        $date_register = isset($inputs['inputs']['date_register']) ? (string)$main->antiInjection($inputs['inputs']['date_register']) : date("y-m-d h:m:s");
        $date_update = isset($inputs['inputs']['date_update']) ? (string)$main->antiInjection($inputs['inputs']['date_update']) : date("y-m-d h:m:s");

        /** Controle de Erros **/
        $message = array();

        /** Validação de campos obrigatórios **/
        /** Verifico se o campo situation_id foi preenchido **/
        if ($project_id < 0)
        {
            array_push($message, 'O campo "ProjetoId", deve ser preenchido');
        }
        if ($situation_id < 0)
        {
            array_push($message, 'O campo "Situação", deve ser preenchido');
        }
        if ($user_id < 0)
        {
            array_push($message, 'O campo "Usuário", deve ser preenchido');
        }
        /** Verifico se o campo name foi preenchido **/
        if (empty($name))
        {
            array_push($message, 'O campo "Nome", deve ser preenchido');
        }
        /** Verifico se o campo description foi preenchido **/
        if (empty($description))
        {
            array_push($message, 'O campo "Descrição", deve ser preenchido');
        }
        /** Verifico se o campo date_register foi preenchido **/
        if (empty($version))
        {
            array_push($message, 'O campo "Versão", deve ser preenchido');
        }
        /** Verifico se o campo date_update foi preenchido **/
        if (empty($release))
        {
            array_push($message, 'O campo "Release", deve ser preenchido');
        }
        /** Verifico se o campo name foi preenchido **/
        if (empty($database_local))
        {
            array_push($message, 'O campo "Caminho do Banco de Dados", deve ser preenchido');
        }
        /** Verifico se o campo description foi preenchido **/
        if (empty($database_name))
        {
            array_push($message, 'O campo "Nome do Banco de Dados", deve ser preenchido');
        }
        /** Verifico se o campo date_register foi preenchido **/
        if (empty($database_user))
        {
            array_push($message, 'O campo "Usuário do Banco de Dados", deve ser preenchido');
        }
        /** Verifico se o campo description foi preenchido **/
        if (empty($path))
        {
            array_push($message, 'O campo "Caminho", deve ser preenchido');
        }
        /** Verifico se o campo date_register foi preenchido **/
        if (empty($date_register))
        {
            array_push($message, 'O campo "DataDeRegistro", deve ser preenchido');
        }
        /** Verifico se o campo date_update foi preenchido **/
        if (empty($date_update))
        {
            array_push($message, 'O campo "DataDeAtualização", deve ser preenchido');
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

            /** Verifico se vou salvar o log */
            if ($project_id > 0)
            {

                /** Busco o registro solicitado **/
                $row = $projects->get($project_id);

                /** Verifico se existe o registro **/
                if (isset($row))
                {

                    /** Verfico se o registro é válido **/
                    if ($row->project_id > 0)
                    {

                        /** Salvo o log */
                        if ($projectLogs->save(0, $row->project_id, $row->user_id, $row->name, $row->description, $row->version, $row->release, $row->database_local, $row->database_name, $row->database_user, $row->database_password, $row->path, $row->date_register, $row->date_update))
                        {

                            /** Executo o método */
                            $projects->save($project_id, $situation_id, $user_id, $name, $description, $version, $release, $database_local, $database_name, $database_user, $database_password, $path, $date_register, $date_update);

                            /** Result **/
                            $result = array(

                                "cod" => 1,
                                "project_id" => $projects->getLast()->project_id,
                                "result" => "Informações atualizadas com sucesso!"

                            );

                        } else {

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
                        array_push($message, "Registro inválido");

                        /** Result **/
                        $result = array(

                            "cod" => 0,
                            "message" => $message

                        );

                    }

                } else {

                    /** Adiciono a mensagem de erro */
                    array_push($message, "Não foi possível localizar o registro");

                    /** Result **/
                    $result = array(

                        "cod" => 0,
                        "message" => $message

                    );

                }

            }
            else
            {

                /** Executo o método */
                $projects->save($project_id, $situation_id, $user_id, $name, $description, $version, $release, $database_local, $database_name, $database_user, $database_password, $path, $date_register, $date_update);

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
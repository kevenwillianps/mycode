<?php
/**
 *
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 *
 */

/** Realizo a importação de classes **/
use \vendor\model\Main;
use \vendor\model\Classes;
use \vendor\model\ClassLogs;

/** Instânciamento das classes importadas **/
$main = new Main();
$class = new Classes();
$classLogs = new ClassLogs();

/** Verifico se existe sessão */
if ($main->verifySession())
{

    try
    {

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input') , true);

        /** Parâmetros de Entrada */
        $class_id = isset($inputs['inputs']['class_id']) ? (int)$main->antiInjection($inputs['inputs']['class_id']) : 0;
        $class_log_id = isset($inputs['inputs']['class_log_id']) ? (int)$main->antiInjection($inputs['inputs']['class_log_id']) : 0;

        /** Controle de Erros **/
        $message = array();

        /** Validação de campos obrigatórios **/
        /** Verifico se o campo situation_id foi preenchido **/
        if ($class_id < 0)
        {
            array_push($message, 'O campo "ProjetoId", deve ser preenchido');
        }

        if ($class_log_id < 0)
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
            $resultClassLog = $classLogs->get($class_log_id);

            /** Verifico se vou salvar o log */
            if (isset($resultClassLog))
            {

                /** Busco um histórico */
                $resultClass = $class->get($class_id);

                /** Verifico se existe o registro **/
                if (isset($resultClass))
                {

                    /** Salvo o log */
                    if ($classLogs->save(0, $resultClass->class_id, $resultClass->user_id, $resultClass->project_id, $resultClass->folder_id, $resultClass->name, $resultClass->name_space, $resultClass->description, $resultClass->version, $resultClass->release, $resultClass->table_name, $resultClass->date_register, $resultClass->date_update))
                    {

                        /** Executo o método */
                        $class->save($resultClassLog->class_id, 1, $resultClassLog->user_id, $resultClassLog->project_id, $resultClassLog->folder_id, $resultClassLog->name, $resultClassLog->name_space, $resultClassLog->description, $resultClassLog->version, $resultClassLog->release, $resultClassLog->table_name, $resultClassLog->date_register, $resultClassLog->date_update);

                        /** Adiciono a mensagem de sucesso */
                        array_push($message, "Informações Atualizadas");

                        /** Result **/
                        $result = array(

                            "cod" => 0,
                            "message" => $message

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
                array_push($message, "Histórico não Localizado");

                /** Result **/
                $result = array(

                    "cod" => 0,
                    "message" => $message

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
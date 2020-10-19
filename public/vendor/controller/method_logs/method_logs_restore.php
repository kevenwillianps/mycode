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
use \vendor\model\Methods;
use \vendor\model\MethodLogs;

/** Instânciamento das classes importadas **/
$main = new Main();
$methods = new Methods();
$methodLogs = new MethodLogs();

/** Verifico se existe sessão */
if ($main->verifySession())
{

    try
    {

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input') , true);

        /** Parâmetros de Entrada */
        $method_id = isset($inputs['inputs']['method_id']) ? (int)$main->antiInjection($inputs['inputs']['method_id']) : 0;
        $method_log_id = isset($inputs['inputs']['method_log_id']) ? (int)$main->antiInjection($inputs['inputs']['method_log_id']) : 0;

        /** Controle de Erros **/
        $message = array();

        /** Validação de campos obrigatórios **/
        /** Verifico se o campo situation_id foi preenchido **/
        if ($method_id < 0)
        {
            array_push($message, 'O campo "$method_id", deve ser preenchido');
        }

        if ($method_log_id < 0)
        {
            array_push($message, 'O campo "$method_log_id", deve ser preenchido');
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
            $resultMethodLog = $methodLogs->get($method_log_id);

            /** Verifico se vou salvar o log */
            if (isset($resultMethodLog))
            {

                /** Busco um histórico */
                $resultMethod = $methods->get($method_id);

                /** Verifico se existe o registro **/
                if (isset($resultMethod))
                {

                    /** Salvo o log */
                    if ($methodLogs->save(0, $resultMethod->method_id,$resultMethod->user_id,$resultMethod->class_id,$resultMethod->name,$resultMethod->description,$resultMethod->type,$resultMethod->code,$resultMethod->version,$resultMethod->release,$resultMethod->date_register,$resultMethod->date_update))
                    {

                        /** Executo o método */
                        $methods->save($resultMethodLog->method_id, 1, $resultMethodLog->user_id, $resultMethodLog->class_id, $resultMethodLog->name, $resultMethodLog->description, $resultMethodLog->type, $resultMethodLog->code, $resultMethodLog->version, $resultMethodLog->release, $resultMethodLog->date_register, $resultMethodLog->date_update);

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
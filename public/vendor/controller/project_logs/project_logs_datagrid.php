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
use \vendor\model\ProjectLogs;
use \vendor\model\ArrayUtf8Encode;

/** Instânciamento das classes **/
$main = new Main();
$projectLogs = new ProjectLogs();
$arrayUtf8Encode = new ArrayUtf8Encode();

/** Verifico se existe sessão */
if ($main->verifySession())
{

    /** Capturo meus campos envios por json **/
    $inputs = json_decode(file_get_contents('php://input') , true);

    /** Parâmetros de Entrada */
    $project_id = isset($inputs['inputs']['project_id']) ? (int)$main->antiInjection($inputs['inputs']['project_id']) : 0;

    /** Controle de Erros **/
    $message = array();

    /** Validação de campos obrigatórios **/
    /** Verifico se o campo situation_id foi preenchido **/
    if ($project_id < 0)
    {
        array_push($message, 'O campo "ProjetoId", deve ser preenchido');
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

        try
        {

            /** Result **/
            $result = array(

                'cod' => 1,
                'result' => $arrayUtf8Encode->utf8Converter($projectLogs->all($project_id))

            );

        }
        catch(Exception $e)
        {
            /** Preparo o formulario para retorno **/
            $result = array(

                'cod' => 0,
                'message' => $e->getMessage()

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


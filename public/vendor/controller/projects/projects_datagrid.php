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
use \vendor\model\Projects;
use \vendor\model\ArrayUtf8Encode;

/** Instânciamento das classes **/
$main = new Main();
$projects = new Projects();
$arrayUtf8Encode = new ArrayUtf8Encode();

/** Verifico se existe sessão */
if ($main->verifySession())
{

    try
    {

        /** Result **/
        $result = array(

            'cod' => 1,
            'result' => $arrayUtf8Encode->utf8Converter($projects->all())

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


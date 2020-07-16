<?php
/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 17:29
 *
 */

/** Importo as classes que irei utilizar **/
use \vendor\model\Main;

/** Instâncio as classes importadas **/
$main = new Main();

try {

    if ($main->verifySession()){

        /** Result **/
        $result = array(

            "cod" => 1,
            "message" => session_destroy(),

        );

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

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
    if ($main->verifySession())
    {

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        $database_local    = isset($inputs['inputs']['database_local'])    ? (string)$main->antiInjection($inputs['inputs']['database_local'])    : '';
        $database_name     = isset($inputs['inputs']['database_name'])     ? (string)$main->antiInjection($inputs['inputs']['database_name'])     : '';
        $database_user     = isset($inputs['inputs']['database_user'])     ? (string)$main->antiInjection($inputs['inputs']['database_user'])     : '';
        $database_password = isset($inputs['inputs']['database_password']) ? (string)$main->antiInjection($inputs['inputs']['database_password']) : '';

        /** Controle de Erros **/
        $message = array();

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

        /** Verifico a existência de erros **/
        if (count($message) > 0) {

            /** Preparo o formulario para retorno **/
            $result = array(

                "cod" => 0,
                "result" => $message

            );

        } else {

            try
            {

                $projects->findDatabase($database_name);

            }
            catch (\PDOException $PDOException)
            {

                if ($PDOException->getCode() == '42S02')
                {

                    echo $PDOException->getMessage();

                    array_push($message, 'Banco de dados "' . $database_name . '" não localizados');

                    /** Result **/
                    $result = array(

                        "cod" => 0,
                        "result" => $message,

                    );

                }

            }

            if (count($message) <= 0)
            {

                /** Preparo o formulario para retorno **/
                $result = array(

                    "cod" => 1,
                    "result" => "Banco de dados localizado",

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

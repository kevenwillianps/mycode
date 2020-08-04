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
use \vendor\model\Folder;

/** Instânciamento das classes importadas **/
$main = new Main();
$folder = new Folder();

try {

    if ($main->verifySession()){

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        /** Parâmetros de entrada **/
        $folder_id = isset($inputs['inputs']['folder_id']) ? (int)$main->antiInjection($inputs['inputs']['folder_id']) : 0;

        /** Controle de erros **/
        $message = array();

        /** Validação de campos obrigatórios **/
        /** Verifico se o campo class_id foi preenchido **/
        if ($folder_id <= 0) {
            array_push($message, '$folder_id - O seguinte campo deve ser preenchido/selecionado');
        }

        /** Verifico se existem erros **/
        if (count($message) > 0) {

            /** Preparo o formulario para retorno **/
            $result = array(

                "cod" => 0,
                "message" => $message

            );
        } else {

            /** Busco o registro solicitado **/
            $row = $folder->get($folder_id);

            /** Verifico se existe o registro **/
            if (isset($row)) {

                /** Verfico se o registro é válido **/
                if ($row->folder_id > 0) {

                    /** Executo o método de exclusão **/
                    if ($folder->delete($row->folder_id)) {
                        array_push($message, "Registro Excluído com Sucesso!");

                        /** Result **/
                        $result = array(

                            "cod" => 1,
                            "message" => $message

                        );
                    } else {
                        array_push($message, "Erro ao executar método");

                        /** Result **/
                        $result = array(

                            "cod" => 0,
                            "message" => $message

                        );
                    }
                } else {
                    array_push($message, "Registro inválido");

                    /** Result **/
                    $result = array(

                        "cod" => 0,
                        "message" => $message

                    );
                }
            } else {
                array_push($message, "Não foi possível localizar o registro");

                /** Result **/
                $result = array(

                    "cod" => 0,
                    "message" => $message

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
        "message" => $e->getMessage(),

    );

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;
}

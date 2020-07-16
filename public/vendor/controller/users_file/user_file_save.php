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
use \vendor\model\File;
use \vendor\model\UserFile;

/** Instânciamento das classes **/
$main = new Main();
$file = new File();
$userFile = new UserFile();

try {

    /** Capturo meus campos envios por json **/
    $inputs = json_decode(file_get_contents('php://input'), true);

    /** Parâmetros de entrada - Controle de Arquivo **/
    $pointer   = isset($inputs['inputs']['pointer'])   ? (int)$main->antiInjection($inputs['inputs']['pointer'])      : 0;
    $part      = isset($inputs['inputs']['part'])      ? (string)$main->antiInjection($inputs['inputs']['part'])      : '';
    $length    = isset($inputs['inputs']['length'])    ? (int)$main->antiInjection($inputs['inputs']['length'])       : 0;
    $extension = isset($inputs['inputs']['extension']) ? (string)$main->antiInjection($inputs['inputs']['extension']) : '';

    /** Parâmetros de entrada **/
    $user_file_id    = isset($inputs['inputs']['user_file_id'])    ? (int)$main->antiInjection($inputs['inputs']['user_file_id'])     : 0;
    $user_id         = isset($inputs['inputs']['user_id'])         ? (int)$main->antiInjection($inputs['inputs']['user_id'])          : $_SESSION['MYSUPPORT-USER-ID'];
    $situation_id    = isset($inputs['inputs']['situation_id'])    ? (int)$main->antiInjection($inputs['inputs']['situation_id'])     : 1;
    $name            = isset($inputs['inputs']['name'])            ? (string)$main->antiInjection($inputs['inputs']['name'])          : 'name_' . rand(1, 15);
    $description     = isset($inputs['inputs']['description'])     ? (string)$main->antiInjection($inputs['inputs']['description'])   : 'description_' . rand(5, 15);
    $base64          = isset($inputs['inputs']['base64'])          ? (string)$main->antiInjection($inputs['inputs']['base64'])        : 'base64_' . rand(5, 15);
    $file_type       = isset($inputs['inputs']['file_type'])       ? (string)$main->antiInjection($inputs['inputs']['file_type'])     : $extension;
    $date_register   = isset($inputs['inputs']['date_register'])   ? (string)$main->antiInjection($inputs['inputs']['date_register']) : date("y-m-d h:m:s");
    $date_update     = isset($inputs['inputs']['date_update'])     ? (string)$main->antiInjection($inputs['inputs']['date_update'])   : date("y-m-d h:m:s");

    /** Pego o ano atual **/
    $year = date('Y');
    /** Pego o mês atual **/
    $month = date('m');
    /** Pego o dia atual **/
    $day = date('d');
    /** Caminho raiz dos documentos **/
    $path = "document/user/{$user_id}/{$user_file_id}/{$year}/{$month}/{$day}/{$extension}";

    /** Controle de erros **/
    $message = array();

    /** Validação de campos obrigatórios **/
    /** Verifico se o campo file_id foi preenchido **/
    if ($user_file_id < 0) {
        array_push($message, '$content_file_id - O seguinte campo deve ser preenchido/selecionado');
    }
    /** Verifico se o campo name foi preenchido **/
    if (empty($name)) {
        array_push($message, '$name - O seguinte campo deve ser preenchido/selecionado');
    }
    /** Verifico se o campo path foi preenchido **/
    if ($pointer < 0) {
        array_push($message, '$pointer - O seguinte campo deve ser preenchido/selecionado');
    }
    /** Verifico se o campo path foi preenchido **/
    if (empty($part)) {
        array_push($message, '$part - O seguinte campo deve ser preenchido/selecionado');
    }
    /** Verifico se o campo path foi preenchido **/
    if ($length < 0) {
        array_push($message, '$length - O seguinte campo deve ser preenchido/selecionado');
    }
    /** Verifico se o campo path foi preenchido **/
    if (empty($extension)) {
        array_push($message, '$extension - O seguinte campo deve ser preenchido/selecionado');
    }

    if (count($message) > 0) {

        /** Preparo o formulario para retorno **/
        $result = array(

            "cod" => 0,
            "message" => $message

        );
    } else {

        /** Verifico se existe o caminho **/
        if (is_dir($path)) {
            if ($pointer == ($length - 1)) {

                /** Crio meu arquivo e escrevo dentro dele **/
                $document = fopen($path . '/' . $name, "a+");

                /** Escrevo dentro do arquivo **/
                fwrite($document, base64_decode($part));

                /** Encerro a escrita do arquivo **/
                fclose($document);

                if (is_file($path . '/' . $name)) {
                    if ($file->handling($path, $name)) {

                        /** Método para salvar o registro **/
                        $userFile->save($user_file_id, $user_id, $situation_id, $name, $description, $base64, $file_type, $path, $date_register, $date_update);

                        /** Result **/
                        $result = array(

                            "cod" => 99,
                            "message" => "Arquivo salvo com sucesso!",
                            "user_file_id" => $userFile->getLast()->user_file_id

                        );
                    } else {

                        /** Result **/
                        $result = array(

                            "cod" => 0,
                            "message" => "Não foi tratar os arquivo"

                        );
                    }
                } else {

                    /** Result **/
                    $result = array(

                        "cod" => 0,
                        "message" => "Não foi localizado o arquivo"

                    );
                }
            } else {

                /** Crio meu arquivo e escrevo dentro dele **/
                $document = fopen($path . '/' . $name, "a+");

                /** Escrevo dentro do arquivo **/
                fwrite($document, base64_decode($part));

                /** Encerro a escrita do arquivo **/
                fclose($document);

                if (is_file($path . '/' . $name)) {

                    /** Result **/
                    $result = array(

                        "cod" => 1,
                        "message" => "Arquivo criado com sucesso"

                    );
                } else {

                    /** Result **/
                    $result = array(

                        "cod" => 0,
                        "message" => "Não foi possível criar o arquivo"

                    );
                }
            }
        } else {

            /** Crio o caminho **/
            mkdir($path, 0777, true);
            mkdir($path . '/crop', 0777, true);
            mkdir($path . '/resize', 0777, true);
            mkdir($path . '/thumbnail', 0777, true);
            mkdir($path . '/filter_gray_scale', 0777, true);

            /** Verifico se existe o caminho **/
            if (is_dir($path)) {
                if ($pointer == ($length - 1)) {

                    /** Crio meu arquivo e escrevo dentro dele **/
                    $document = fopen($path . '/' . $name, "a+");

                    /** Escrevo dentro do arquivo **/
                    fwrite($document, base64_decode($part));

                    /** Encerro a escrita do arquivo **/
                    fclose($document);

                    if (is_file($path . '/' . $name)) {
                        if ($file->handling($path, $name)) {

                            /** Método para salvar o registro **/
                            $userFile->save($user_file_id, $user_id, $situation_id, $name, $description, $base64, $file_type, $path, $date_register, $date_update);

                            /** Result **/
                            $result = array(

                                "cod" => 99,
                                "message" => "Arquivo salvo com sucesso!",
                                "user_file_id" => $userFile->getLast()->user_file_id

                            );
                        } else {

                            /** Result **/
                            $result = array(

                                "cod" => 0,
                                "message" => "Não foi tratar os arquivo"

                            );
                        }
                    } else {

                        /** Result **/
                        $result = array(

                            "cod" => 0,
                            "message" => "Não foi localizado o arquivo"

                        );
                    }
                } else {

                    /** Crio meu arquivo e escrevo dentro dele **/
                    $document = fopen($path . '/' . $name, "a+");

                    /** Escrevo dentro do arquivo **/
                    fwrite($document, base64_decode($part));

                    /** Encerro a escrita do arquivo **/
                    fclose($document);

                    if (is_file($path . '/' . $name)) {

                        /** Result **/
                        $result = array(

                            "cod" => 1,
                            "message" => "Arquivo criado com sucesso"

                        );
                    } else {

                        /** Result **/
                        $result = array(
                            "cod" => 0,
                            "message" => "Não foi possível criar o arquivo"
                        );
                    }
                }
            }
        }
    }

    /**Envio*/
    echo json_encode($result);

    /**Para o procedimento*/
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

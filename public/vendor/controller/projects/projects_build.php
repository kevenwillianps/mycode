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
use \vendor\model\Classes;
use \vendor\model\Methods;
use \vendor\model\Projects;

/** Instânciamento das classes importadas **/
$main = new Main();
$folder = new Folder();
$classes = new Classes();
$methods = new Methods();
$projects = new Projects();

try {

    if ($main->verifySession()){

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        /** Parâmetros de entrada **/
        $project_id = isset($inputs['inputs']['project_id']) ? (int)$main->antiInjection($inputs['inputs']['project_id']) : 0;

        /** Pego o ano atual **/
        $year = date('Y');
        /** Pego o mês atual **/
        $month = date('m');
        /** Pego o dia atual **/
        $day = date('d');
        /** Caminho raiz dos documentos **/
        $path = "document/{$project_id}/{$year}/{$month}/{$day}";

        /** Controle de erros **/
        $message = array();

        /** Validação de campos obrigatórios **/
        /** Verifico se o campo class_id foi preenchido **/
        if ($project_id <= 0) {
            array_push($message, '$project_id - O seguinte campo deve ser preenchido/selecionado');
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
            $row = $projects->get($project_id);

            /** Verifico se existe o registro **/
            if (isset($row)) {

                /** Verfico se o registro é válido **/
                if ($row->project_id > 0) {

                    if (is_dir($path)){

                        /** Crio os arquivos de classes **/
                        foreach ($classes->allBuild($project_id) as $keyClasses => $resultClasses){

                            if (empty($resultClasses['folder_name'])){

                                /** Crio meu arquivo e escrevo dentro dele **/
                                $document = fopen($path . '/' . $resultClasses['class_name'] . '.class.php', "a+");

                            }else{

                                /** Crio o caminho **/
                                mkdir($path . '/' . $resultClasses['folder_name'], 0777, true);

                                /** Crio meu arquivo e escrevo dentro dele **/
                                $document = fopen($path . '/' . $resultClasses['folder_name'] . '/' . $resultClasses['class_name'] . '.class.php', "a+");

                            }

                            /** Preenchos os arquivos de classes **/
                            foreach ($methods->all($resultClasses['class_id']) as $keyMethods => $resultMethods){

                                /** Escrevo dentro do arquivo **/
                                fwrite($document, $main->internalCode($resultMethods['code']));

                            }

                            /** Encerro a escrita do arquivo **/
                            fclose($document);

                        }

                        /** Result **/
                        $result = array(

                            "message" => "Arquivos criados com sucesso"

                        );

                    }else{

                        /** Crio o caminho **/
                        mkdir($path, 0777, true);

                        if (is_dir($path)){

                            /** Crio os arquivos de classes **/
                            foreach ($classes->allBuild($project_id) as $keyClasses => $resultClasses){

                                if (empty($resultClasses['folder_name'])){

                                    /** Crio meu arquivo e escrevo dentro dele **/
                                    $document = fopen($path . '/' . $resultClasses['class_name'] . '.class.php', "a+");

                                }else{

                                    /** Crio o caminho **/
                                    mkdir($path . '/' . $resultClasses['folder_name'], 0777, true);

                                    /** Crio meu arquivo e escrevo dentro dele **/
                                    $document = fopen($path . '/' . $resultClasses['folder_name'] . '/' . $resultClasses['class_name'] . '.class.php', "a+");

                                }

                                /** Preenchos os arquivos de classes **/
                                foreach ($methods->all($resultClasses['class_id']) as $keyMethods => $resultMethods){

                                    /** Escrevo dentro do arquivo **/
                                    fwrite($document, $main->internalCode($resultMethods['code']));

                                }

                                /** Encerro a escrita do arquivo **/
                                fclose($document);

                            }

                            /** Result **/
                            $result = array(

                                "message" => "Arquivos criados com sucesso"

                            );

                        }

                    }

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

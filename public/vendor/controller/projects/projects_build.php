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

    /** Verifico se existe sessão do usuário **/
    if ($main->verifySession()){

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        /** Parâmetros de entrada **/
        $project_id = isset($inputs['inputs']['project_id']) ? (int)$main->antiInjection($inputs['inputs']['project_id']) : 0;
        $user_name = isset($inputs['inputs']['user_name']) ? (string)$main->antiInjection($inputs['inputs']['user_name']) : $_SESSION['MYCODE-USER-NAME'];

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

        /** Verifico se o campo class_id foi preenchido **/
        if ($project_id <= 0) {

            array_push($message, '$project_id - O seguinte campo deve ser preenchido/selecionado');

        }

        /** Verifico se existem erros **/
        if (count($message) > 0) {

            /** Preparo o formulario para retorno **/
            $result = array(

                "cod" => 0,
                "result" => $message

            );

        } else {

            /** Busco o registro solicitado **/
            $row = $projects->get($project_id);

            /** Verifico se existe o registro **/
            if (isset($row))
            {

                /** Verfico se o registro é válido **/
                if ($row->project_id > 0)
                {

                    /** Crio a pasta do projeto **/
                    if (mkdir($path, 0777, true))
                    {

                        /** Crio os arquivos de classes **/
                        foreach ($classes->allBuild($row->project_id) as $keyClasses => $resultClasses)
                        {

                            /** Verifico se a classe irá ficar dentro de alguma pasta **/
                            if (empty($resultClasses['folder_name'])){

                                /** Crio meu arquivo e escrevo dentro dele **/
                                $document = fopen($path . '/' . $resultClasses['class_name'] . '.class.php', "a+");

                                /** Preencho o arquivo **/
                                $main->fillClass($path, $resultClasses['class_name'], $main->headerClass($resultClasses['class_name'], $user_name));

                                /** Preencho o arquivo com os parâmetros padrão **/
                                $main->fillClass($path, $resultClasses['class_name'], $main->defaultParametersClass());

                                /** Localizo as classes **/
                                foreach($classes->findClasses($row->database_name) as $keyTables => $resultTables){

                                    /** Verifico se os parâmetros é da classe atual **/
                                    if($main->nameClass($resultTables['table_name']) == $resultClasses['class_name'])
                                    {

                                        /** Localizo os campos da tabela **/
                                        foreach ($classes->findParameters($row->database_name, $resultTables['table_name']) as $keyParameter => $resultParameters)
                                        {

                                            /** Preencho o arquivo **/
                                            $main->fillClass($path, $resultClasses['class_name'], $main->parametersClass($resultParameters['COLUMN_NAME']));

                                        }

                                    }

                                }

                                /** Preencho o arquivo com método construtor **/
                                $main->fillClass($path, $resultClasses['class_name'], $main->methodConstruct());

                                /** Localizo as classes **/
                                foreach($classes->findClasses($row->database_name) as $keyTables => $resultTables)
                                {

                                    /** Verifico se os parâmetros é da classe atual **/
                                    if($main->nameClass($resultTables['table_name']) == $resultClasses['class_name'])
                                    {

                                        /** Localizo os campos da tabela **/
                                        foreach ($classes->findPrimaryKey($row->database_name, $resultTables['table_name']) as $keyPrimaryKey => $resultPrimaryKey)
                                        {

                                            /** Preencho o arquivo com método destrutor **/
                                            $main->fillClass($path, $resultClasses['class_name'], $main->methodAll($resultTables['table_name']));
                                            $main->fillClass($path, $resultClasses['class_name'], $main->methodSave($resultTables['table_name'], $classes->findParameters($row->database_name, $resultTables['table_name'])));
                                            $main->fillClass($path, $resultClasses['class_name'], $main->methodGet($resultPrimaryKey['COLUMN_NAME'], $resultTables['table_name']));
                                            $main->fillClass($path, $resultClasses['class_name'], $main->methodDelete($resultPrimaryKey['COLUMN_NAME'], $resultTables['table_name']));

                                        }

                                    }

                                }

                                /** Preencho o arquivo com método destrutor **/
                                $main->fillClass($path, $resultClasses['class_name'], $main->methodDestruct());

                                /** Preencho o arquivo **/
                                $main->fillClass($path, $resultClasses['class_name'], $main->footerClass());

                            }else{

                                /** Crio o caminho da pasta **/
                                mkdir($path . '/' . $resultClasses['folder_name'], 0777, true);

                                /** Preencho o arquivo o método construtor **/
                                $main->fillClass($path . '/' . $resultClasses['folder_name'], $resultClasses['class_name'], $main->headerClass($resultClasses['class_name'], $user_name));

                                /** Preencho o arquivo */
                                $main->fillClass($path . '/' . $resultClasses['folder_name'], $resultClasses['class_name'], $main->defaultParametersClass());

                                /** Localizo as classes **/
                                foreach($classes->findClasses($row->database_name) as $keyTables => $resultTables)
                                {

                                    /** Verifico se os parâmetros é da classe atual **/
                                    if($main->nameClass($resultTables['table_name']) == $resultClasses['class_name'])
                                    {

                                        /** Localizo os campos da tabela **/
                                        foreach ($classes->findParameters($row->database_name, $resultTables['table_name']) as $keyParameter => $resultParameters)
                                        {

                                            /** Preencho o arquivo **/
                                            $main->fillClass($path . '/' . $resultClasses['folder_name'], $resultClasses['class_name'], $main->parametersClass($resultParameters['COLUMN_NAME']));

                                        }

                                    }

                                }

                                /** Preencho o arquivo */
                                $main->fillClass($path . '/' . $resultClasses['folder_name'], $resultClasses['class_name'], $main->methodConstruct());

                                /** Localizo as classes **/
                                foreach($classes->findClasses($row->database_name) as $keyTables => $resultTables)
                                {

                                    /** Verifico se os parâmetros é da classe atual **/
                                    if($main->nameClass($resultTables['table_name']) == $resultClasses['class_name'])
                                    {

                                        /** Localizo os campos da tabela **/
                                        foreach ($classes->findPrimaryKey($row->database_name, $resultTables['table_name']) as $keyPrimaryKey => $resultPrimaryKey)
                                        {

                                            /** Preencho o arquivo com método destrutor **/
                                            $main->fillClass($path . '/' . $resultClasses['folder_name'], $resultClasses['class_name'], $main->methodAll($resultTables['table_name']));
                                            $main->fillClass($path . '/' . $resultClasses['folder_name'], $resultClasses['class_name'], $main->methodSave($resultTables['table_name'], $classes->findParameters($row->database_name, $resultTables['table_name'])));
                                            $main->fillClass($path . '/' . $resultClasses['folder_name'], $resultClasses['class_name'], $main->methodGet($resultPrimaryKey['COLUMN_NAME'], $resultTables['table_name']));
                                            $main->fillClass($path . '/' . $resultClasses['folder_name'], $resultClasses['class_name'], $main->methodDelete($resultPrimaryKey['COLUMN_NAME'], $resultTables['table_name']));

                                        }

                                    }

                                }

                                /** Preencho o arquivo com método destrutor **/
                                $main->fillClass($path . '/' . $resultClasses['folder_name'], $resultClasses['class_name'], $main->methodDestruct());

                                /** Preencho o arquivo **/
                                $main->fillClass($path . '/' . $resultClasses['folder_name'], $resultClasses['class_name'], $main->footerClass());

                            }

                        }

                        /** Result **/
                        $result = array(

                            "result" => "Arquivos criados com sucesso"

                        );

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

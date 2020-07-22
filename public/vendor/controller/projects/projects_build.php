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
        $path = "document/{$project_id}/";

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

                        /** Monto o arquivo de autoload */
                        $main->fileAutoload($path,  'autoload.php');

                        /** Criação do arquivo de rotas */
                        $main->fileRouter($path,  'router.php');

                        /** Listo todas as classes */
                        foreach ($classes->all($row->project_id) as $keyClasses => $rowClasses)
                        {

                            /** Crio o arquivo **/
                            $document = fopen($path . '/' . $rowClasses['name'] . '.class.php', "a+");

                            /** Monto o cabeçalho da classe*/
                            fwrite($document, $main->headerClass($rowClasses['name'], $user_name, $rowClasses['version']));

                            /** Monto os parâmetros padrões da classe */
                            fwrite($document, $main->defaultParametersClass());

                            /** Localizo todas as classes */
                            foreach($classes->findClasses($row->database_name) as $keyTables => $resultTables)
                            {

                                /** Verifico se os parâmetros é da classe atual **/
                                if($main->nameClass($resultTables['table_name']) == $rowClasses['name'])
                                {

                                    /** Localizo os campos da tabela **/
                                    foreach ($classes->findParameters($row->database_name, $resultTables['table_name']) as $keyParameter => $resultParameters)
                                    {

                                        /** Monto os parâmetros dinâmicos da classe */
                                        fwrite($document, $main->parametersClass($resultParameters['COLUMN_NAME']));

                                    }

                                }

                            }

                            /*** Listo todos os métodos de uma classe*/
                            foreach ($methods->all($rowClasses['class_id']) as $keyMethods => $rowMethods){

                                /** Escrevo dentro do arquivo **/
                                fwrite($document, base64_decode($rowMethods['code']));

                            }

                            /** Monto o rodapé da classe*/
                            fwrite($document, $main->footerClass());

                            /** Encerro a escrita do arquivo **/
                            fclose($document);

                        }

                        /** Result **/
                        $result = array(

                            "cod" => 1,
                            "result" => 'Arquivos criados com sucesso',

                        );

                    }

                }
                else
                {

                    array_push($message, "Registro inválido");

                    /** Result **/
                    $result = array(

                        "cod" => 0,
                        "message" => $message

                    );

                }

            }
            else
            {

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

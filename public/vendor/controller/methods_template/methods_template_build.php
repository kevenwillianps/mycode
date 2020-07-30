<?php
/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 */

/** Realizo a importação de classes */
use \vendor\model\Main;
use \vendor\model\Marking;
use \vendor\model\Folder;
use \vendor\model\Classes;
use \vendor\model\Methods;
use \vendor\model\MethodsTemplates;
use \vendor\model\Projects;

/** Instânciamento das classes importadas */
$main = new Main();
$marking = new Marking();
$folder = new Folder();
$classes = new Classes();
$methods = new Methods();
$methodsTemplates = new MethodsTemplates();
$projects = new Projects();

try {

    /** Verifico se existe sessão do usuário */
    if ($main->verifySession()){

        /** Capturo meus campos envios por json */
        $inputs = json_decode(file_get_contents('php://input'), true);

        /** Parâmetros de entrada */
        $database_name = isset($inputs['inputs']['database_name']) ? (string)$main->antiInjection($inputs['inputs']['database_name']) : '';
        $method_template_id = isset($inputs['inputs']['method_template_id']) ? (int)$main->antiInjection($inputs['inputs']['method_template_id']) : 0;

        /** Pego o ano atual */
        $year = date('Y');
        /** Pego o mês atual */
        $month = date('m');
        /** Pego o dia atual */
        $day = date('d');
        /** Caminho raiz dos documentos */
        $path = "document/{$database_name}/";

        /** Controle de erros */
        $message = array();

        /** Verifico se o campo class_id foi preenchido */
        if (empty($database_name)) {

            array_push($message, 'database_name - O seguinte campo deve ser preenchido/selecionado');

        }

        /** Verifico se o campo class_id foi preenchido */
        if ($method_template_id <= 0) {

            array_push($message, 'method_template_id - O seguinte campo deve ser preenchido/selecionado');

        }

        /** Verifico se existem erros */
        if (count($message) > 0) {

            /** Preparo o formulario para retorno */
            $result = array(

                "cod" => 0,
                "result" => $message

            );

        } else {

            /** Busco o registro solicitado */
            $row = $methodsTemplates->get($method_template_id);

            /** Verifico se existe o registro */
            if (isset($row))
            {

                /** Verfico se o registro é válido */
                if ($row->method_template_id > 0)
                {

                    /** Crio a pasta do projeto */
                    if (mkdir($path, 0777, true))
                    {

                        foreach ($classes->findClasses($database_name) as $keyClasses => $resultClasses)
                        {

                            /** Crio o arquivo */
                            $document = fopen($path . '/' . $main->nameClass($resultClasses['table_name']) . '.class.php', "a+");

                            /** Decodifico minha strign */
                            $str = base64_decode($row->code);

                            /** Marco a Chave Primária */
                            $str = str_replace('[primary_key]', $marking->markingPrimaryKey($classes->findPrimaryKey($database_name, $resultClasses['table_name'])->COLUMN_NAME), $str);

                            /** Marco os parâmetros de entrada **/
                            $str = str_replace('[inputs_parameters_method]', $marking->markingParametersMethod($classes->findParameters($database_name, $resultClasses['table_name'])), $str);

                            /** Marco os parâmetros de entrada **/
                            $str = str_replace('[sql_insert]', $marking->markingSqlInsert($classes->findParameters($database_name, $resultClasses['table_name']), $database_name), $str);

                            /** Marco os parâmetros de entrada **/
                            $str = str_replace('[sql_update]', $marking->markingSqlUpdate($classes->findParameters($database_name, $resultClasses['table_name']), $database_name), $str);

                            /** Marco o Sql de pesquisa */
                            $str = str_replace('[sql_select]', $marking->markingSqlSelect($database_name), $str);

                            /** Marco o Sql de exclusão */
                            $str = str_replace('[sql_delete]', $marking->markingSqlDelete($classes->findPrimaryKey($database_name, $resultClasses['table_name'])->COLUMN_NAME, $database_name), $str);

                            /** Marco o Sql de exclusão */
                            $str = str_replace('[inputs_parameters]', $marking->markingParameters($classes->findParameters($database_name, $resultClasses['table_name'])), $str);

                            /** Marco os Parâmetros padrões */
                            $str = str_replace('[default_parameters_class]', $marking->markingDefaultParameters(), $str);

                            /** Marco os Parâmetros padrões */
                            $str = str_replace('[bind_param]', $marking->markingBindParams($classes->findParameters($database_name, $resultClasses['table_name'])), $str);

                            /** Monto os parâmetros padrões da classe */
                            fwrite($document, utf8_encode($str));

                            /** Encerro a escrita do arquivo */
                            fclose($document);

                        }

                    }

                }

            }

            /** Preparo o formulario para retorno */
            $result = array(

                "cod" => 1,
                "result" => "Arquivos Criados Com Sucesso",

            );

        }

    }else{

        /** Preparo o formulario para retorno */
        $result = array(

            "cod" => 404,
            "result" => "Usuário não autenticado",

        );

    }

    /** Envio */
    echo json_encode($result);

    /** Paro o procedimento */
    exit;

} catch (Exception $e) {

    /** Preparo o formulario para retorno */
    $result = array(

        "cod" => 0,
        "result" => $e->getMessage(),

    );

    /** Envio */
    echo json_encode($result);

    /** Paro o procedimento */
    exit;
}

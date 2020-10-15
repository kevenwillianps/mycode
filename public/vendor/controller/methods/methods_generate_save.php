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
use \vendor\model\Methods;
use \vendor\model\Marking;
use \vendor\model\MethodsTemplates;
use \vendor\model\Classes;
use \vendor\model\Projects;

/** Instânciamento das classes importadas **/
$main = new Main();
$methods = new Methods();
$marking = new Marking();
$methodTemplate = new MethodsTemplates;
$classes = new Classes();
$projects = new Projects();

try {

    if ($main->verifySession()){

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        /** Parâmetros de entrada **/
        $project_id     = isset($inputs['inputs']['project_id'])      ? (int)$main->antiInjection($inputs['inputs']['project_id'])         : 0;
        $database_name  = isset($inputs['inputs']['database_name'])   ? (string)$main->antiInjection($inputs['inputs']['database_name'])   : '';
        $tables_result  = isset($inputs['inputs']['tables'])          ? (array)$main->antiInjection($inputs['inputs']['tables'])           : '';
        $classes_result = isset($inputs['inputs']['classes'])         ? (array)$main->antiInjection($inputs['inputs']['classes'])          : '';
        $method_template_id = isset($inputs['method_template']['id']) ? (array)$main->antiInjection($inputs['method_template']['id'])      : '';

        $method_id     = isset($inputs['inputs']['method_id'])     ? (int)$main->antiInjection($inputs['inputs']['method_id'])          : 0;
        $situation_id  = isset($inputs['inputs']['situation_id'])  ? (int)$main->antiInjection($inputs['inputs']['situation_id'])       : 1;
        $user_id       = isset($inputs['inputs']['user_id'])       ? (int)$main->antiInjection($inputs['inputs']['user_id'])            : $_SESSION['MYCODE-USER-ID'];
        $class_id      = isset($inputs['inputs']['class_id'])      ? (int)$main->antiInjection($inputs['inputs']['class_id'])           : 77;
        $name          = isset($inputs['inputs']['name'])          ? (string)$main->antiInjection($inputs['inputs']['name'])            : 'Teste';
        $description   = isset($inputs['inputs']['description'])   ? (string)$main->antiInjection($inputs['inputs']['description'])     : 'Método Gerado Automaticamente';
        $type          = isset($inputs['inputs']['type'])          ? (string)$main->antiInjection($inputs['inputs']['type'])            : 'public';
        $code          = isset($inputs['inputs']['code'])          ? (string)$main->antiInjection($inputs['inputs']['code'], 'S') : '1';
        $version       = isset($inputs['inputs']['version'])       ? (string)$main->antiInjection($inputs['inputs']['version'])         : '1';
        $release       = isset($inputs['inputs']['release'])       ? (string)$main->antiInjection($inputs['inputs']['release'])         : '1';
        $date_register = isset($inputs['inputs']['date_register']) ? (string)$main->antiInjection($inputs['inputs']['date_register'])   : date("y-m-d h:m:s");
        $date_update   = isset($inputs['inputs']['date_update'])   ? (string)$main->antiInjection($inputs['inputs']['date_update'])     : date("y-m-d h:m:s");

        /** Controle de Erros **/
        $message = array();

        /** Verifico se é um campo válido **/
        if ($project_id < 0) {

            array_push($message, 'O campo "$project_id", deve ser preenchido');

        }

        /** Verifico a existência de erros **/
        if (count($message) > 0)
        {

            /** Preparo o formulario para retorno **/
            $result = array(

                "cod" => 0,
                "message" => $message

            );

        }
        else
        {

            /** Busco o registro solicitado **/
            $row = $projects->get($project_id);

            /** Verifico se existe o registro **/
            if (isset($row))
            {

                /** Verfico se o registro é válido **/
                if ($row->project_id > 0)
                {

                    /** Localizo as classes **/
                    foreach($method_template_id as $keyMethodTemplateId => $resultMethodTemplateId)
                    {

                        /** Busco o método desejado */
                        $resultMethodTemplate = $methodTemplate->get($resultMethodTemplateId);

                        /** Verifico se o registro foi localizado */
                        if (isset($resultMethodTemplate))
                        {

                            /** Localizo as classes **/
                            foreach($classes_result as $keyClasses => $resultClasses)
                            {

                                /** Decodifico minha strign */
                                $str = base64_decode($resultMethodTemplate->code);

                                /** Marco a Chave Primária */
                                $str = str_replace('[primary_key]', $marking->markingPrimaryKey($classes->findPrimaryKey($database_name, $resultClasses['table_name'])->COLUMN_NAME), $str);

                                /** Marco os parâmetros de entrada **/
                                $str = str_replace('[inputs_parameters_method]', $marking->markingParametersMethod($classes->findParameters($database_name, $resultClasses['table_name'])), $str);

                                /** Marco os parâmetros de entrada **/
                                $str = str_replace('[sql_insert]', $marking->markingSqlInsert($classes->findParameters($database_name, $resultClasses['table_name']), $database_name), $str);

                                /** Marco os parâmetros de entrada **/
                                $str = str_replace('[sql_update]', $marking->markingSqlUpdate($classes->findParameters($database_name, $resultClasses['table_name']), $database_name), $str);

                                /** Marco o Sql de pesquisa */
                                $str = str_replace('[sql_select]', $marking->markingSqlSelect($resultClasses['table_name']), $str);

                                /** Marco o Sql de exclusão */
                                $str = str_replace('[sql_delete]', $marking->markingSqlDelete($classes->findPrimaryKey($database_name, $resultClasses['table_name'])->COLUMN_NAME, $database_name), $str);

                                /** Marco o Sql de exclusão */
                                $str = str_replace('[inputs_parameters]', $marking->markingParameters($classes->findParameters($database_name, $resultClasses['table_name'])), $str);

                                /** Marco os Parâmetros padrões */
                                $str = str_replace('[default_parameters_class]', $marking->markingDefaultParameters(), $str);

                                /** Marco os Parâmetros padrões */
                                $str = str_replace('[bind_param]', $marking->markingBindParams($classes->findParameters($database_name, $resultClasses['table_name'])), $str);

                                /** Codifico para base64 */
                                $str = base64_encode($str);

                                /** Salvo o método */
                                $methods->save($method_id, $situation_id, $user_id, $resultClasses['class_id'], $resultMethodTemplate->name, $resultMethodTemplate->description, $resultMethodTemplate->type, $str, $resultMethodTemplate->version, $resultMethodTemplate->release, $date_register, $date_update);

                                /** Result **/
                                $result = array(

                                    "cod" => 1,
                                    "result" => "Informações atualizadas com sucesso!",

                                );

                            }

                        }
                        else
                        {

                            array_push($message, "Não foi possivél localizar o método");

                            /** Preparo o formulario para retorno **/
                            $result = array(

                                "cod" => 0,
                                "result" => $message,

                            );

                        }

                    }

                }
                else
                {

                    array_push($message, "Registro inválido");

                    /** Preparo o formulario para retorno **/
                    $result = array(

                        "cod" => 0,
                        "result" => $message,

                    );

                }

            }
            else
            {

                array_push($message, "Registro não localizado");

                /** Preparo o formulario para retorno **/
                $result = array(

                    "cod" => 0,
                    "result" => $message,

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
        "message" => $e->getMessage()

    );

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

}

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
use \vendor\model\Classes;
use \vendor\model\Methods;
use \vendor\model\Marking;
use \vendor\model\MethodsTemplates;

/** Instânciamento das classes importadas **/
$main = new Main();
$projects = new Projects();
$classes = new Classes();
$methods = new Methods();
$marking = new Marking();
$methodsTemplate = new MethodsTemplates();

try {

    /** Verifico se existe sessão */
    if ($main->verifySession())
    {

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        /** Capturo os métodos para gerar **/
        $project_id         = isset($inputs['inputs']['project_id'])         ? (int)$main->antiInjection($inputs['inputs']['project_id'])           : 0;
        $class_id           = isset($inputs['inputs']['class_id'])           ? (int)$main->antiInjection($inputs['inputs']['class_id'])             : 0;
        $method_template_id = isset($inputs['inputs']['method_template_id']) ? (array)$main->antiInjection($inputs['inputs']['method_template_id']) : '';

        /** Controle de Erros **/
        $message = array();

        /** Validação de campos obrigatórios **/
        /** Verifico se o campo situation_id foi preenchido **/
        if ($project_id < 0)
        {

            array_push($message, '$project_id - O seguinte campo deve ser preenchido/selecionado');

        }

        if ($class_id < 0)
        {

            array_push($message, '$class_id - O seguinte campo deve ser preenchido/selecionado');

        }

        if (count($method_template_id) <= 0)
        {

            array_push($message, '$method_template_id - O seguinte campo deve ser preenchido/selecionado');

        }

        /** Verifico se existe template */
        if (count($message) > 0)
        {

            /** Preparo o formulario para retorno **/
            $result = array(

                "cod" => 0,
                "result" => $message

            );

        }
        else
        {

            foreach ($method_template_id as $keyMethodTemplateId => $resultMethodTemplateId)
            {

                /** Pego o Registros */
                $rowMethod = $methodsTemplate->get($resultMethodTemplateId);
                $rowProject = $projects->get($project_id);
                $rowClass = $classes->get($class_id);

                /** Verifico se existe o registros */
                if (isset($rowMethod))
                {

                    /** Parâmetros de entrada **/
                    $method_id     = isset($inputs['inputs']['method_id'])     ? (int)$main->antiInjection($inputs['inputs']['method_id'])          : 0;
                    $situation_id  = isset($inputs['inputs']['situation_id'])  ? (int)$main->antiInjection($inputs['inputs']['situation_id'])       : $rowMethod->situation_id;
                    $user_id       = isset($inputs['inputs']['user_id'])       ? (int)$main->antiInjection($inputs['inputs']['user_id'])            : $_SESSION['MYCODE-USER-ID'];
                    $class_id      = isset($inputs['inputs']['class_id'])      ? (int)$main->antiInjection($inputs['inputs']['class_id'])           : $class_id;
                    $name          = isset($inputs['inputs']['name'])          ? (string)$main->antiInjection($inputs['inputs']['name'])            : $rowMethod->name;
                    $description   = isset($inputs['inputs']['description'])   ? (string)$main->antiInjection($inputs['inputs']['description'])     : $rowMethod->description;
                    $type          = isset($inputs['inputs']['type'])          ? (string)$main->antiInjection($inputs['inputs']['type'])            : $rowMethod->type;
                    $code          = isset($inputs['inputs']['code'])          ? (string)$main->antiInjection($inputs['inputs']['code'], 'S') : $rowMethod->code;
                    $version       = isset($inputs['inputs']['version'])       ? (string)$main->antiInjection($inputs['inputs']['version'])         : $rowMethod->version;
                    $release       = isset($inputs['inputs']['release'])       ? (string)$main->antiInjection($inputs['inputs']['release'])         : $rowMethod->release;
                    $date_register = isset($inputs['inputs']['date_register']) ? (string)$main->antiInjection($inputs['inputs']['date_register'])   : date("y-m-d h:m:s");
                    $date_update   = isset($inputs['inputs']['date_update'])   ? (string)$main->antiInjection($inputs['inputs']['date_update'])     : date("y-m-d h:m:s");

                    /** Controle de Erros **/
                    $message = array();

                    /** Validação de campos obrigatórios **/
                    /** Verifico se o campo situation_id foi preenchido **/
                    if ($method_id < 0)
                    {

                        array_push($message, '$situation_id - O seguinte campo deve ser preenchido/selecionado');

                    }

                    if ($situation_id <= 0)
                    {

                        array_push($message, '$situation_id - O seguinte campo deve ser preenchido/selecionado');

                    }

                    if ($user_id <= 0)
                    {

                        array_push($message, '$situation_id - O seguinte campo deve ser preenchido/selecionado');

                    }

                    if ($class_id <= 0)
                    {

                        array_push($message, '$situation_id - O seguinte campo deve ser preenchido/selecionado');

                    }

                    /** Verifico se o campo name foi preenchido **/
                    if (empty($name))
                    {

                        array_push($message, '$name - O seguinte campo deve ser preenchido/selecionado');

                    }

                    /** Verifico se o campo date_register foi preenchido **/
                    if (empty($description))
                    {

                        array_push($message, '$description - O seguinte campo deve ser preenchido/selecionado');

                    }

                    /** Verifico se o campo date_update foi preenchido **/
                    if (empty($type))
                    {

                        array_push($message, '$type - O seguinte campo deve ser preenchido/selecionado');

                    }
                    /** Verifico se o campo name foi preenchido **/
                    if (empty($code))
                    {

                        array_push($message, '$code - O seguinte campo deve ser preenchido/selecionado');

                    }

                    /** Verifico se o campo date_register foi preenchido **/
                    if (empty($version))
                    {

                        array_push($message, '$version - O seguinte campo deve ser preenchido/selecionado');

                    }
                    /** Verifico se o campo date_update foi preenchido **/
                    if (empty($release))
                    {

                        array_push($message, '$release - O seguinte campo deve ser preenchido/selecionado');

                    }

                    /** Verifico a existência de erros **/
                    if (count($message) > 0) {

                        /** Preparo o formulario para retorno **/
                        $result = array(

                            "cod" => 0,
                            "result" => $message

                        );

                    }
                    else
                    {

                        /** Decodifico minha strign */
                        $code = base64_decode($code);

                        /** Marco a Chave Primária */
                        $code = str_replace('[primary_key]', $marking->markingPrimaryKey($classes->findPrimaryKey($rowProject->database_name, $rowClass->table_name)->COLUMN_NAME), $code);

                        /** Marco os parâmetros de entrada **/
                        $code = str_replace('[inputs_parameters_method]', $marking->markingParametersMethod($classes->findParameters($rowProject->database_name, $rowClass->table_name)), $code);

                        /** Marco os parâmetros de entrada **/
                        $code = str_replace('[sql_insert]', $marking->markingSqlInsert($classes->findParameters($rowProject->database_name, $rowClass->table_name), $rowProject->database_name), $code);

                        /** Marco os parâmetros de entrada **/
                        $code = str_replace('[sql_update]', $marking->markingSqlUpdate($classes->findParameters($rowProject->database_name, $rowClass->table_name), $rowProject->database_name), $code);

                        /** Marco o Sql de pesquisa */
                        $code = str_replace('[sql_select]', $marking->markingSqlSelect($rowProject->database_name), $code);

                        /** Marco o Sql de exclusão */
                        $code = str_replace('[sql_delete]', $marking->markingSqlDelete($classes->findPrimaryKey($rowProject->database_name, $rowClass->table_name)->COLUMN_NAME, $rowProject->database_name), $code);

                        /** Marco o Sql de exclusão */
                        $code = str_replace('[inputs_parameters]', $marking->markingParameters($classes->findParameters($rowProject->database_name, $rowClass->table_name)), $code);

                        /** Marco os Parâmetros padrões */
                        $code = str_replace('[default_parameters_class]', $marking->markingDefaultParameters(), $code);

                        /** Marco os Parâmetros padrões */
                        $code = str_replace('[bind_param]', $marking->markingBindParams($classes->findParameters($rowProject->database_name, $rowClass->table_name)), $code);

                        /** Decodifico minha strign */
                        $code = base64_encode($code);

                        /** Executo o método */
                        $methods->save($method_id, $situation_id, $user_id, $class_id, $name, $description, $type, $code, $version, $release, $date_register, $date_update);

                        /** Result **/
                        $result = array(

                            "cod" => 1,
                            "result" => "Informações atualizadas com sucesso!"

                        );

                    }

                }
                else
                {

                    /** Preparo o formulario para retorno **/
                    $result = array(

                        "cod" => 0,
                        "result" => "Registro não localizado",

                    );

                }

            }

        }

    }
    else
    {

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

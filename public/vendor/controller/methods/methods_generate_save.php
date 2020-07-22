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
use \vendor\model\Classes;
use \vendor\model\Projects;

/** Instânciamento das classes importadas **/
$main = new Main();
$methods = new Methods();
$classes = new Classes();
$projects = new Projects();

try {

    if ($main->verifySession()){

        /** Capturo meus campos envios por json **/
        $inputs = json_decode(file_get_contents('php://input'), true);

        /** Parâmetros de entrada **/
        $project_id     = isset($inputs['inputs']['project_id'])    ? (int)$main->antiInjection($inputs['inputs']['project_id'])         : 0;
        $database_name  = isset($inputs['inputs']['database_name']) ? (string)$main->antiInjection($inputs['inputs']['database_name'])   : '';
        $tables_result  = isset($inputs['inputs']['tables'])        ? (array)$main->antiInjection($inputs['inputs']['tables'])           : '';
        $classes_result = isset($inputs['inputs']['classes'])       ? (array)$main->antiInjection($inputs['inputs']['classes'])          : '';

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
            if (isset($row)) {

                /** Verfico se o registro é válido **/
                if ($row->project_id > 0) {

                    /** Localizo as classes **/
                    foreach($classes_result as $keyClasses => $resultClasses)
                    {

                        /** Monto uma array com os métodos padrões */
                        $defaultMethods = array();

                        /** Monto uma array com os métodos padrões */
                        $arrayConstruct = array(

                            'name' => 'Construct',
                            'description' => 'Método gerado automaticamente',
                            'code' => $main->methodConstruct(),

                        );
                        array_push($defaultMethods, $arrayConstruct);
                        /** Monto uma array com os métodos padrões */
                        $arraySave = array(

                            'name' => 'Save',
                            'description' => 'Método gerado automaticamente',
                            'code' => $main->methodSave($tables_result[$keyClasses]['table_name'], $classes->findParameters($database_name, $tables_result[$keyClasses]['table_name'])),

                        );
                        array_push($defaultMethods, $arraySave); /** Monto uma array com os métodos padrões */
                        $arrayAll = array(

                            'name' => 'All',
                            'description' => 'Método gerado automaticamente',
                            'code' => $main->methodAll($tables_result[$keyClasses]['table_name']),

                        );
                        array_push($defaultMethods, $arrayAll);
                        /** Monto uma array com os métodos padrões */
                        $arrayGet = array(

                            'name' => 'Get',
                            'description' => 'Método gerado automaticamente',
                            'code' => $main->methodGet($classes->findPrimaryKey($database_name, $tables_result[$keyClasses]['table_name'])->COLUMN_NAME, $tables_result[$keyClasses]['table_name']),

                        );
                        array_push($defaultMethods, $arrayGet);
                        /** Monto uma array com os métodos padrões */
                        $arrayDelete = array(

                            'name' => 'Delete',
                            'description' => 'Método gerado automaticamente',
                            'code' => $main->methodDelete($classes->findPrimaryKey($database_name, $tables_result[$keyClasses]['table_name'])->COLUMN_NAME, $tables_result[$keyClasses]['table_name']),

                        );
                        array_push($defaultMethods, $arrayDelete);
                        /** Monto uma array com os métodos padrões */
                        $arrayDestruct = array(

                            'name' => 'Destruct',
                            'description' => 'Método gerado automaticamente',
                            'code' => $main->methodDestruct(),

                        );
                        array_push($defaultMethods, $arrayDestruct);

                        foreach ($defaultMethods as $keyDefaultMethods => $resultDefaultMethods){

                            /** Salvo ps método **/
                            $methods->save($method_id, $situation_id, $user_id, $resultClasses['class_id'], utf8_encode($defaultMethods[$keyDefaultMethods]['name']), utf8_encode($defaultMethods[$keyDefaultMethods]['description']), $type, utf8_encode(base64_encode($defaultMethods[$keyDefaultMethods]['code'])), $version, $release, $date_register, $date_update);

                        }

                        /** Result **/
                        $result = array(

                            "cod" => 1,
                            "result" => "Informações atualizadas com sucesso!",

                        );

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

<?php
/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 */

/** Realizo a importação de classes */
use \vendor\model\Main;
use \vendor\model\Folder;
use \vendor\model\FoldersAuxiliary;
use \vendor\model\Classes;
use \vendor\model\Methods;
use \vendor\model\Projects;

/** Instânciamento das classes importadas */
$main = new Main();
$folder = new Folder();
$foldersAuxiliary = new FoldersAuxiliary();
$classes = new Classes();
$methods = new Methods();
$projects = new Projects();

try {

    /** Verifico se existe sessão do usuário */
    if ($main->verifySession()){

        /** Capturo meus campos envios por json */
        $inputs = json_decode(file_get_contents('php://input'), true);

        /** Parâmetros de entrada */
        $project_id = isset($inputs['inputs']['project_id']) ? (int)$main->antiInjection($inputs['inputs']['project_id']) : 0;
        $user_name = isset($inputs['inputs']['user_name']) ? (string)$main->antiInjection($inputs['inputs']['user_name']) : $_SESSION['MYCODE-USER-NAME'];

        /** Pego o ano atual */
        $year = date('Y');
        /** Pego o mês atual */
        $month = date('m');
        /** Pego o dia atual */
        $day = date('d');
        /** Caminho raiz dos documentos */
        $path = "document/{$project_id}/";

        /** Controle de erros */
        $message = array();

        /** Verifico se o campo class_id foi preenchido */
        if ($project_id <= 0)
        {

            array_push($message, '$project_id - O seguinte campo deve ser preenchido/selecionado');

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
            $row = $projects->get($project_id);

            /** Verifico se existe o registro */
            if (isset($row))
            {

                /** Verfico se o registro é válido */
                if ($row->project_id > 0)
                {

                    /** Crio a pasta do projeto */
                    if (mkdir($path, 0777, true))
                    {

                        /** Verifico a Existência de pastas */
                        foreach ($folder->all($row->project_id) as $keyFolders => $resultFolders)
                        {

                            /** Crio as pastas do projeto */
                            mkdir($path . $resultFolders['name'], 0777, true);

                            /** Verifico a Existência de pastas */
                            foreach ($foldersAuxiliary->all($row->project_id, $resultFolders['folder_id']) as $keyFoldersAuxiliary => $resultFoldersAuxiliary)
                            {

                                /** Crio as pastas do projeto */
                                mkdir($path . $resultFolders['name'] . '/' . $resultFoldersAuxiliary['name'], 0777, true);

                            }

                        }

                        /** Monto o arquivo de autoload */
                        $main->fileAutoload($path,  'autoload.php');

                        /** Criação do arquivo de rotas */
                        $main->fileRouter($path,  'router.php');

                        /** Criação do arquivo de conexão com o banco de dados */
                        $main->fileMySql($path,  'MySql.class.php');

                        /** Criação do arquivo que contêm os dados do banco de dados */
                        $main->fileHost($path,  'Host.php', $row->database_name, $row->database_user, $row->database_password, $row->database_local);

                        /** Listo todas as classes */
                        foreach ($classes->allBuild($row->project_id) as $keyClasses => $rowClasses)
                        {

                            /** Verifico a qual pasta a classe pertence */
                            if (!empty($rowClasses['folder_name']))
                            {

                                /** Crio o arquivo */
                                $document = fopen($path . '/' . $rowClasses['folder_name'] . '/' . $rowClasses['class_name'] . '.class.php', "a+");

                            }
                            else
                            {

                                /** Crio o arquivo */
                                $document = fopen($path . '/' . $rowClasses['class_name'] . '.class.php', "a+");

                            }

                            /** Monto o cabeçalho da classe*/
                            fwrite($document, $main->headerClass($rowClasses['class_name'], $user_name, $rowClasses['class_version'], $rowClasses['class_description'], $rowClasses['name_space']));

                            /** Monto os parâmetros padrões da classe */
                            fwrite($document, $main->defaultParametersClass());

                            /** Localizo os campos da tabela */
                            foreach ($classes->findParameters($row->database_name, $rowClasses['table_name']) as $keyParameter => $resultParameters)
                            {

                                /** Monto os parâmetros dinâmicos da classe */
                                fwrite($document, $main->parametersClass($resultParameters['COLUMN_NAME']));

                            }

                            /** Listo todos os métodos de uma classe */
                            foreach ($methods->all($rowClasses['class_id']) as $keyMethods => $rowMethods){

                                /** Escrevo Cabeçalho do Método */
                                fwrite($document, $main->descriptionMethod($rowMethods['name'], $rowMethods['description'], $rowMethods['version'], $rowMethods['release']));

                                /** Escrevo o Método */
                                fwrite($document, base64_decode($rowMethods['code']));

                            }

                            /** Monto o rodapé da classe*/
                            fwrite($document, $main->footerClass());

                            /** Encerro a escrita do arquivo */
                            fclose($document);

                        }

                        /** Result */
                        $result = array(

                            "cod" => 1,
                            "result" => 'Arquivos criados com sucesso',

                        );

                    }

                }
                else
                {

                    array_push($message, "Registro inválido");

                    /** Result */
                    $result = array(

                        "cod" => 0,
                        "result" => $message

                    );

                }

            }
            else
            {

                array_push($message, "Não foi possível localizar o registro");

                /** Result */
                $result = array(

                    "cod" => 0,
                    "result" => $message

                );

            }

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

<?php
/**
 * Classe Lista.class.php
 * @filesource
 * @autor		Kenio de Souza
 * @copyright	Copyright 2016 Serenity Informatica
 * @package		class
 * @subpackage	class.class
 * @version		1.0
 * Total de campos para essa classe [8]
 */

/** Defino o local onde a classe esta localizada **/
namespace vendor\model;

class Main
{

    /** Declaro as variaveis que irei utilizar na classe **/
    private $user_id = 0;
    private $string = null;
    private $database_name = null;
    private $table_name = null;
    private $userName = null;

    private $document = null;
    private $name = null;
    private $path = null;
    private $content = null;

    private $primary_key = null;
    private $inputs = null;
    private $parameters = null;
    private $bindParameters = null;
    private $inputsInsert = null;
    private $inputsUpdate = null;

    private $className = null;
    private $version = null;

    private $methodName = null;
    private $methodDescription = null;
    private $methodCode = null;
    private $methodVersion = null;
    private $methodRelease = null;

    public function __construct()
    {

        /** Inicializo a sessão **/
        session_start();
    }

    //ANTIINJECTION
    public function antiInjection($str, $long = '')
    {
        //Check
        if ((!is_array($str)) && $long != 'S') {
            $badchar[1] = " drop ";
            $badchar[2] = " select ";
            $badchar[3] = " delete ";
            $badchar[4] = " update ";
            $badchar[5] = " insert ";
            $badchar[6] = " alter ";
            $badchar[7] = " destroy ";
            $badchar[8] = ' * ';
            $badchar[9] = " database ";
            $badchar[10] = " drop ";
            $badchar[11] = " union ";
            $badchar[12] = " TABLE_NAME ";
            $badchar[13] = " 1=1 ";
            $badchar[14] = ' or 1 ';
            $badchar[15] = ' exec ';
            $badchar[16] = ' INFORMATION_SCHEMA ';
            $badchar[17] = ' TABLE_NAME ';
            $badchar[18] = ' like ';
            $badchar[19] = ' COLUMNS ';
            $badchar[20] = ' into ';
            $badchar[21] = ' VALUES ';
            $badchar[22] = ' from ';
            $badchar[23] = ' From ';
            $badchar[24] = ' undefined ';

            $y = 1;
            $x = sizeof($badchar);
            while ($y <= $x) {
                $pos = strpos(strtolower($str), strtolower($badchar[$y]));
                if ($pos !== false) {
                    $str = str_replace(strtolower($badchar[$y]), "", strtolower($str));
                }

                $y++;
            }

            $str = trim($str); //limpa espaços vazio
            $str = strip_tags($str); //tira tags html e php
            $str = addslashes($str); //Adiciona barras invertidas a uma string
            $str = htmlspecialchars($str); //Evita ataques XSS
            return utf8_decode($str);
        } elseif ((!is_array($str)) && $long == 'S') {
            return utf8_decode($str);
        } else {
            return $str;
        }
    }

    public function verifySession(){

        /** Guardo o Id do usuário **/
        $this->user_id = @(int)$_SESSION['MYCODE-USER-ID'];

        /** Verifico se existe sessão **/
        if ($this->user_id > 0){

            return true;

        }else{

            return false;

        }

    }

    /** Trato o Código Interno da Aplicação **/
    public function internalCode($string){

        /** Parâmetros de entrada **/
        $this->string = (string)$string;

        return utf8_encode(trim(base64_decode($string)));

    }

    /** Classe para deixar somente o nome com as primeiras letras maiúsculas **/
    public function nameClass($string){

        /** Parâmetros de entrada **/
        $this->string = $string;

        /** Troco o "_" por " " **/
        $this->string = str_replace('_', ' ', $this->string);

        /** Coloco as primeiras letras em maiúsculo **/
        $this->string = ucwords($this->string);

        /** Troco o " " por "" **/
        $this->string = str_replace(' ', '', $this->string);

        return $this->string;

    }

    /** Classe para deixar somente o nome com as primeiras letras maiúsculas **/
    public function descriptionClass($string){

        /** Parâmetros de entrada **/
        $this->string = $string;

        /** Tratamento do Texto **/
        $this->string = trim($this->string);

        /** Texto Fixo **/
        $this->string = 'Classe utilizada para manipular os dados da tabela"' . $this->string . '"';

        return $this->string;

    }

    /** Gero os arquivos de classes **/
    public function fileClass($path, $name)
    {

        /** Parâmetros de entrada **/
        $this->path = (string)$path;
        $this->name = (string)$name;

        /** Verifico se o caminho informado existe **/
        if(!is_dir($this->path . '/' . $this->name))
        {

            /** Crio o caminho **/
            mkdir($this->path . '/' . $this->name, 0777, true);

        }

        /** Crio o arquivo **/
        $this->document = fopen($this->path . '/' . $this->name . '.class.php', "a+");

        /** Encerro a escrita do arquivo **/
        fclose($this->document);

        /** Verifico se o arquivo existe **/
        if (is_file($this->path . '/' . $this->name . '.class.php')){

            return true;

        }else{

            return false;

        }

    }

    /** Preencho a classe **/
    public function fillClass($path, $name, $content)
    {

        /** Parâmetros de entrada **/
        $this->path = (string)$path;
        $this->name = (string)$name;
        $this->content = (string)$content;

        /** Crio o arquivo **/
        $this->document = fopen($this->path . '/' . $this->name . '.class.php', "a+");

        /** Escrevo dentro do arquivo **/
        fwrite($this->document, $this->content);

        /** Encerro a escrita do arquivo **/
        fclose($this->document);

        return true;

    }

    /** Classe para deixar somente o nome com as primeiras letras maiúsculas **/
    public function headerClass($className, $userName, $version){

        /** Parâmetros de entrada **/
        $this->className = (string)$className;
        $this->userName  = (string)$userName;
        $this->version   = (string)$version;

        /** Escrita do código **/
        $this->string  = "<?php\r\n";
        $this->string .= "\r\n";
        $this->string .= "/**\r\n";
        $this->string .= " * Comentário de cabeçalho de arquivo\r\n";
        $this->string .= " * Classe '" . utf8_encode($this->className) . "'\r\n";
        $this->string .= " *\r\n";
        $this->string .= " * @author " . utf8_encode($this->userName) . "\r\n";
        $this->string .= " * @version " . utf8_encode($this->version) . "\r\n";
        $this->string .= " * @copyright Souza Consultoria Tecnlogica\r\n";
        $this->string .= " * @access public\r\n";
        $this->string .= "*/\r\n";
        $this->string .= "\r\n";
        $this->string .= "class " . $this->className . "\r\n";
        $this->string .= "{";
        $this->string .= "\r\n";
        $this->string .= "  /**\r\n";
        $this->string .= "  *Comentário das variáveis\r\n";
        $this->string .= "  *Variavéis usadas internamente na classe\r\n";
        $this->string .= "  *@access private\r\n";
        $this->string .= "  */\r\n";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Classe para deixar somente o nome com as primeiras letras maiúsculas **/
    public function headerMethod($methodName, $methodDescription, $methodVersion, $methodRelease){

        /** Parâmetros de entrada **/
        $this->methodName        = (string)$methodName;
        $this->methodDescription = (string)$methodDescription;
        $this->methodVersion     = (string)$methodVersion;
        $this->methodRelease     = (string)$methodRelease;

        /** Escrita do código **/
        $this->string  = "\r\n";
        $this->string .= "   /**\r\n";
        $this->string .= "   * Método '" . utf8_encode($this->methodName) . "'\r\n";
        $this->string .= "   * " . utf8_encode($this->methodDescription) . "\r\n";
        $this->string .= "   * @access public\r\n";
        $this->string .= "   * @version " . utf8_encode($this->methodVersion) . "\r\n";
        $this->string .= "   * @release " . utf8_encode($this->methodRelease) . "\r\n";
        $this->string .= "   */\r\n";
        $this->string .= "   public function " . $this->methodName . "()\r\n";
        $this->string .= "   {\r\n";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Classe para deixar somente o nome com as primeiras letras maiúsculas **/
    public function bodyMethod($methodCode){

        /** Parâmetros de entrada **/
        $this->methodCode = (string)$methodCode;

        /** Escrita do código **/
        $this->string  = "\r\n";
        $this->string .= "       " . utf8_encode(base64_decode($this->methodCode)) . "\r\n";
        $this->string .= "\r\n";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Classe para deixar somente o nome com as primeiras letras maiúsculas **/
    public function footerMethod(){

        /** Escrita do código **/
        $this->string  = "   }";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Classe para deixar somente o nome com as primeiras letras maiúsculas **/
    public function footerClass(){

        /** Escrita do código **/
        $this->string = "}";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Classe para deixar somente o nome com as primeiras letras maiúsculas **/
    public function defaultParametersClass()
    {

        /** Escrita do código **/
        $this->string  = "   private $" . "connection; \r\n";
        $this->string .= "   private $" . "sql; \r\n";
        $this->string .= "   private $" . "stmt; \r\n";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Classe para deixar somente o nome com as primeiras letras maiúsculas **/
    public function parametersClass($string){

        /** Parâmetros de entrada **/
        $this->string = (string)$string;

        /** Escrita do código **/
        $this->string = "   private $" . $this->string . ";\r\n";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Escrevo o método construtor */
    public function fileAutoload($path, $name)
    {

        /** Parâmetros de entrada **/
        $this->path = (string)$path;
        $this->name = (string)$name;

        /** Crio o arquivo **/
        $this->document = fopen($this->path . '/' . $this->name, "a+");

        /** Escrita do código **/
        $this->string  = "<?php\r\n";
        $this->string .= "\r\n";
        $this->string .= "   spl_autoload_register(function ($"."className){\r\n";
        $this->string .= "\r\n";
        $this->string .= "      $"."filePath = str_replace('\\\', DIRECTORY_SEPARATOR, $"."className);\r\n";
        $this->string .= "      require_once($"."filePath . '.class.php');\r\n";
        $this->string .= "\r\n";
        $this->string .= "   });\r\n";
        $this->string .= "\r\n";

        /** Escrevo dentro do arquivo **/
        fwrite($this->document, $this->string);

        /** Encerro a escrita do arquivo **/
        fclose($this->document);

        /** Retorno o código gerado **/
        return true;

    }

    /** Escrevo o método construtor */
    public function fileRouter($path, $name)
    {

        /** Parâmetros de entrada **/
        $this->path = (string)$path;
        $this->name = (string)$name;

        /** Crio o arquivo **/
        $this->document = fopen($this->path . '/' . $this->name, "a+");

        /** Escrita do código **/
        $this->string  = "<?php\r\n";
        $this->string .= "\r\n";
        $this->string .= "   /**\r\n";
        $this->string .= "   * Arquivo que direciona as requisições\r\n";
        $this->string .= "   * @access public\r\n";
        $this->string .= "   */\r\n";
        $this->string .= "\r\n";
        $this->string .= "   /** Instânciamento de classes */\r\n";
        $this->string .= "   include_once './vendor/autoload.php';\r\n";
        $this->string .= "\r\n";
        $this->string .= "   /** Parâmetros de entrada **/\r\n";
        $this->string .= "   $" . "table = strtolower(isset($"."_REQUEST['TABLE']) ? htmlspecialchars($"."_REQUEST['TABLE']) : '');\r\n";
        $this->string .= "   $" . "table = strtolower(isset($"."_REQUEST['ACTION']) ? htmlspecialchars($"."_REQUEST['ACTION']) : '');\r\n";
        $this->string .= "\r\n";
        $this->string .= "   try\r\n";
        $this->string .= "   {\r\n";
        $this->string .= "\r\n";
        $this->string .= "      /** Verifico se a tabela foi preenchida */\r\n";
        $this->string .= "      if (!empty($"."table))\r\n";
        $this->string .= "      {\r\n";
        $this->string .= "\r\n";
        $this->string .= "          /** Verifico se a ação foi preenchida */\r\n";
        $this->string .= "          if (!empty($"."action))\r\n";
        $this->string .= "          {\r\n";
        $this->string .= " \r\n";
        $this->string .= "              /** Verifico se o arquivo de ação existe */\r\n";
        $this->string .= "              if (is_file('vendor/controller/' . $"."table . '/' . $"."action . '.php'))\r\n";
        $this->string .= "              {\r\n";
        $this->string .= " \r\n";
        $this->string .= "                  include_once 'vendor/controller/' . $"."table . '/' . $"."action . '.php';\r\n";
        $this->string .= " \r\n";
        $this->string .= "              }\r\n";
        $this->string .= "              else\r\n";
        $this->string .= "              {\r\n";
        $this->string .= " \r\n";
        $this->string .= "                  /** Mensagem de erro */\r\n";
        $this->string .= "                  throw new Exception('Error :: There is no file for informed action.');\r\n";
        $this->string .= " \r\n";
        $this->string .= "              }\r\n";
        $this->string .= " \r\n";
        $this->string .= "          }\r\n";
        $this->string .= "          else\r\n";
        $this->string .= "          {\r\n";
        $this->string .= " \r\n";
        $this->string .= "                  /** Mensagem de erro */\r\n";
        $this->string .= "                  throw new Exception('Error :: action do not informed.');\r\n";
        $this->string .= " \r\n";
        $this->string .= "          }\r\n";
        $this->string .= " \r\n";
        $this->string .= "      }\r\n";
        $this->string .= "      else\r\n";
        $this->string .= "      {\r\n";
        $this->string .= " \r\n";
        $this->string .= "                  /** Mensagem de erro */\r\n";
        $this->string .= "                  throw new Exception('Error :: table do not informed.');\r\n";
        $this->string .= " \r\n";
        $this->string .= "      }\r\n";
        $this->string .= " \r\n";
        $this->string .= "   }\r\n";
        $this->string .= "   catch(Exception $"."e)\r\n";
        $this->string .= "   {\r\n";
        $this->string .= "\r\n";
        $this->string .= "       /** Retorno de parâmetros */\r\n";
        $this->string .= "       $"."result = array(\r\n";
        $this->string .= "\r\n";
        $this->string .= "          'cod' => 0, \r\n";
        $this->string .= "          'message' => $"."e->getMessage(), \r\n";
        $this->string .= "\r\n";
        $this->string .= "       );";
        $this->string .= "\r\n";
        $this->string .= "      /** Informações */\r\n";
        $this->string .= "      echo json_encode($"."result);\r\n";
        $this->string .= "      exit;\r\n";
        $this->string .= "\r\n";
        $this->string .= "   }\r\n";

        /** Escrevo dentro do arquivo **/
        fwrite($this->document, $this->string);

        /** Encerro a escrita do arquivo **/
        fclose($this->document);

        /** Retorno o código gerado **/
        return true;

    }

    /** Escrevo o método construtor */
    public function methodConstruct(){

        /** Escrita do código **/
        $this->string  = "\r\n";
        $this->string .= "   /**\r\n";
        $this->string .= "   * Função para iniciar a conexão com o banco de dados\r\n";
        $this->string .= "   * @access public\r\n";
        $this->string .= "   */\r\n";
        $this->string .= "   public function __construct()\r\n";
        $this->string .= "   {\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Cria o objeto de conexão com o banco de dados */\r\n";
        $this->string .= "       $" . "this->connection" . "= new MySql();\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Inicio a conexão com o banco de dados */\r\n";
        $this->string .= "       $" . "this->connection->connect();\r\n";
        $this->string .= "   \r\n";
        $this->string .= "   }\r\n";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Escrevo o método destrutor */
    public function methodDestruct(){

        /** Escrita do código **/
        $this->string  = "\r\n";
        $this->string .= "   /**\r\n";
        $this->string .= "   * Função para encerrar a conexão com o banco de dados\r\n";
        $this->string .= "   * @access public\r\n";
        $this->string .= "   */\r\n";
        $this->string .= "   public function __destruct()\r\n";
        $this->string .= "   {\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Cria o objeto de conexão com o banco de dados */\r\n";
        $this->string .= "       $" . "this->connection = null;\r\n";
        $this->string .= "   \r\n";
        $this->string .= "   }\r\n";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Escrevo o método delete */
    public function methodAll($table_name)
    {

        /** Parâmetros de entrada */
        $this->table_name = (string)$table_name;

        /** Escrita do código **/
        $this->string  = "\r\n";
        $this->string .= "   /**\r\n";
        $this->string .= "   * Função para listar todos os registros\r\n";
        $this->string .= "   * @access public\r\n";
        $this->string .= "   */\r\n";
        $this->string .= "   public function all()\r\n";
        $this->string .= "   {\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Crio o sql */\r\n";
        $this->string .= "       $" . "this->sql" . " = 'SELECT * FROM `" . $this->table_name . "`';\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Preparo o sql */\r\n";
        $this->string .= "       $" . "this->stmt = $" . "this->connection->connect()->prepare($" . "this->sql);\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Execução do Sql */\r\n";
        $this->string .= "       $" . "this->stmt->execute();\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Retorno um objeto */\r\n";
        $this->string .= "       return $" . "this->stmt->fetchAll(\PDO::FETCH_ASSOC);\r\n";
        $this->string .= "   \r\n";
        $this->string .= "   }\r\n";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Escrevo o método delete */
    public function methodSave($table_name, $inputs)
    {

        /** Parâmetros de entrada */
        $this->table_name = (string)$table_name;
        $this->inputs = (array)$inputs;

        $this->parameters = null;
        $this->bindParameters = null;
        $this->inputsInsert = null;
        $this->inputsUpdate = null;
        $this->primary_key = null;

        /** Preparação dos campos */
        foreach ($this->inputs as $key => $input){

            $this->parameters     .= "$" . $input['COLUMN_NAME'] . ", ";
            $this->bindParameters .= ":" . $input['COLUMN_NAME'] . ", ";
            $this->inputsInsert   .= "`" . $input['COLUMN_NAME'] . "`" . ", ";
            $this->inputsUpdate   .= "`" . $input['COLUMN_NAME'] . "`" . " = " . ":" .$input['COLUMN_NAME'] . ", ";
            /** Verificação de chave primária */
            if ($input['COLUMN_KEY'] == 'PRI'){

                $this->primary_key = $input['COLUMN_NAME'];

            }

        }

        /** Escrita do código **/
        $this->string  = "\r\n";
        $this->string .= "   /**\r\n";
        $this->string .= "   * Função para listar todos os registros\r\n";
        $this->string .= "   * @access public\r\n";
        /** Escrevo a documentação de parâmetros */
        foreach ($inputs as $key => $input){

            /** Escrita do código **/
            $this->string .= "   * @param $" . $input['COLUMN_NAME'] . "\r\n";


        }
        $this->string .= "   */\r\n";
        $this->string .= "   public function save(" . $this->parameters . ")\r\n";
        $this->string .= "   {\r\n";
        $this->string .= "\r\n";
        $this->string .= "       /** Parâmetros de entrada */\r\n";
        /** Escrevo os parâmetros de entrada */
        foreach ($inputs as $key => $input){

            $this->string .= "       $" . "this->" . $input['COLUMN_NAME'] . " = $" . $input['COLUMN_NAME']. ";\r\n";

        }
        $this->string .= "\r\n";
        $this->string .= "       /** Verifico se é inserção ou atualização */\r\n";
        $this->string .= "       if ($" . "this->" . $this->primary_key . " == 0)\r\n";
        $this->string .= "       {\r\n";
        $this->string .= "\r\n";
        $this->string .= "          /** Consulta SQL */\r\n";
        $this->string .= "          $". "this->sql = 'INSERT INTO " . $this->table_name . "(". $this->inputsInsert . ")VALUES(" . $this->bindParameters . ")';\r\n";
        $this->string .= "\r\n";
        $this->string .= "       } else {\r\n";
        $this->string .= "\r\n";
        $this->string .= "          /** Consulta SQL */\r\n";
        $this->string .= "          $". "this->sql = 'UPDATE " . $this->table_name . " SET " . $this->inputsUpdate . " WHERE `" . $this->primary_key . "` = :" . $this->primary_key . "';\r\n";
        $this->string .= "\r\n";
        $this->string .= "       }\r\n";
        $this->string .= "       /** Preparo o SQL */\r\n";
        $this->string .= "       $". "this->stmt = $" . "this->connection->connect()->prepare($". "this->sql);\r\n";
        $this->string .= " \r\n";
        $this->string .= "       /** Preencho os parâmetros do sql **/\r\n";
        /** Escrevo os BindParams */
        foreach ($this->inputs as $key => $input){

            $this->string .= "       $" . "this->stmt->bindParam(':" . $input['COLUMN_NAME'] . "', $" . "this->" . $input['COLUMN_NAME'] . ");\r\n";

        }
        $this->string .= "   \r\n";
        $this->string .= "       /** Execução do Sql */\r\n";
        $this->string .= "       return $" . "this->stmt->execute();\r\n";
        $this->string .= "   }\r\n";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Escrevo o método delete */
    public function methodGet($primary_key, $table_name)
    {

        /** Parâmetros de entrada */
        $this->primary_key = (string)$primary_key;
        $this->table_name = (string)$table_name;

        /** Escrita do código **/
        $this->string  = "\r\n";
        $this->string .= "   /**\r\n";
        $this->string .= "   * Função para remover um registro especifico\r\n";
        $this->string .= "   * @access public\r\n";
        $this->string .= "   * @param int $" . $this->primary_key . "\r\n";
        $this->string .= "   */\r\n";
        $this->string .= "   public function get($" . $this->primary_key . ")\r\n";
        $this->string .= "   {\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Parâmetros de entrada */\r\n";
        $this->string .= "       $" . "this->" . $this->primary_key . " = $" . $this->primary_key .";\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Crio o sql */\r\n";
        $this->string .= "       $" . "this->sql" . " = 'SELECT * FROM `" . $this->table_name . "` WHERE `" . $this->primary_key . "` = :" . $this->primary_key . "';\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Preparo o sql */\r\n";
        $this->string .= "       $" . "this->stmt = $" . "this->connection->connect()->prepare($" . "this->sql);\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Preencho os parâmetros do sql */\r\n";
        $this->string .= "       $" . "this->stmt->bindParam(':" . $this->primary_key . "', $" . "this->" . $this->primary_key . ");\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Execução do Sql */\r\n";
        $this->string .= "       $" . "this->stmt->execute();\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Retorno um objeto */\r\n";
        $this->string .= "       return $" . "this->stmt->fetchObject();\r\n";
        $this->string .= "   \r\n";
        $this->string .= "   }\r\n";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Escrevo o método delete */
    public function methodDelete($primary_key, $table_name)
    {

        /** Parâmetros de entrada */
        $this->primary_key = (string)$primary_key;
        $this->table_name = (string)$table_name;

        /** Escrita do código **/
        $this->string  = "\r\n";
        $this->string .= "   /**\r\n";
        $this->string .= "   * Função para remover um registro especifico\r\n";
        $this->string .= "   * @access public\r\n";
        $this->string .= "   * @param int $" . $this->primary_key . "\r\n";
        $this->string .= "   */\r\n";
        $this->string .= "   public function delete($" . $this->primary_key . ")\r\n";
        $this->string .= "   {\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Parâmetros de entrada */\r\n";
        $this->string .= "       $" . "this->" . $this->primary_key . " = $" . $this->primary_key .";\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Crio o sql */\r\n";
        $this->string .= "       $" . "this->sql" . " = 'DELETE FROM `" . $this->table_name . "` WHERE `" . $this->primary_key . "` = :" . $this->primary_key . "';\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Preparo o sql */\r\n";
        $this->string .= "       $" . "this->stmt = $" . "this->connection->connect()->prepare($" . "this->sql);\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Preencho os parâmetros do sql */\r\n";
        $this->string .= "       $" . "this->stmt->bindParam(':" . $this->primary_key . "', $" . "this->" . $this->primary_key . ");\r\n";
        $this->string .= "   \r\n";
        $this->string .= "       /** Retorno a execução do sql */\r\n";
        $this->string .= "       return $" . "this->stmt->execute();\r\n";
        $this->string .= "   \r\n";
        $this->string .= "   }\r\n";

        /** Retorno o código gerado **/
        return $this->string;

    }

}
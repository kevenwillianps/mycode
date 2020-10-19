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
    private $database_user = null;
    private $database_password = null;
    private $database_path = null;

    private $userName = null;

    private $document = null;
    private $name = null;
    private $path = null;

    private $className = null;
    private $classNameSpace = null;
    private $description = null;
    private $version = null;

    private $methodName = null;
    private $methodDescription = null;
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
            return $str;
        } elseif ((!is_array($str)) && $long == 'S') {
            return $str;
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
        $this->string = 'Classe utilizada para manipular os dados da tabela "' . $this->string . '"';

        return $this->string;

    }

    /** Classe para deixar somente o nome com as primeiras letras maiúsculas **/
    public function headerClass($className, $userName, $version, $description, $nameSpace){

        /** Parâmetros de entrada **/
        $this->className      = (string)$className;
        $this->classNameSpace = (string)$nameSpace;
        $this->userName       = (string)$userName;
        $this->version        = (string)$version;
        $this->description    = (string)$description;

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
        $this->string .= " * @description $this->description\r\n";
        $this->string .= " * @access public\r\n";
        $this->string .= "*/\r\n";

        /** Verifico se existe NameSpace */
        if (!empty($this->classNameSpace))
        {

            $this->string .= "\r\n";
            /** Escrevo o NameSpace */
            $this->string .= "/** NameSpace da minha classe */\r\n";
            $this->string .= "namespace " . $this->classNameSpace . ";\r\n";
            $this->string .= "\r\n";

        }

        $this->string .= "\r\n";
        $this->string .= "class " . $this->className . "\r\n";
        $this->string .= "{";
        $this->string .= "\r\n";
        $this->string .= "  /**\r\n";
        $this->string .= "  * Comentário das variáveis\r\n";
        $this->string .= "  * Variavéis usadas internamente na classe\r\n";
        $this->string .= "  * @access private\r\n";
        $this->string .= "  */\r\n";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Classe para deixar somente o nome com as primeiras letras maiúsculas **/
    public function descriptionMethod($methodName, $methodDescription, $methodVersion, $methodRelease){

        /** Parâmetros de entrada **/
        $this->methodName        = (string)$methodName;
        $this->methodDescription = (string)$methodDescription;
        $this->methodVersion     = (string)$methodVersion;
        $this->methodRelease     = (string)$methodRelease;

        /** Escrita do código **/
        $this->string  = "\r\n";
        $this->string .= "   /**\r\n";
        $this->string .= "   * Método '" . utf8_encode($this->methodName) . "'\r\n";
        $this->string .= "   * @description " . utf8_encode($this->methodDescription) . "\r\n";
        $this->string .= "   * @access public\r\n";
        $this->string .= "   * @version " . utf8_encode($this->methodVersion) . "\r\n";
        $this->string .= "   * @release " . utf8_encode($this->methodRelease) . "\r\n";
        $this->string .= "   */\r\n";

        /** Retorno o código gerado **/
        return $this->string;

    }

    /** Classe para deixar somente o nome com as primeiras letras maiúsculas **/
    public function footerClass(){

        /** Escrita do código **/
        $this->string  = "\r\n";
        $this->string .= "}\r\n";
        $this->string .= "\r\n";

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
    public function fileMySql($path, $name)
    {

        /** Parâmetros de entrada **/
        $this->path = (string)$path;
        $this->name = (string)$name;

        /** Crio o arquivo **/
        $this->document = fopen($this->path . '/' . $this->name, "a+");

        /** Escrita do código **/
        $this->string  = "<?php\r\n";
        $this->string .= "\r\n";
        $this->string .= "class MySql\r\n";
        $this->string .= "{\r\n";
        $this->string .= "\r\n";
        $this->string .= "    /** Declaro as variaveis que irei utilizar na classe */\r\n";
        $this->string .= "    public static $" . "pdo;\r\n";
        $this->string .= "\r\n";
        $this->string .= "    /** Método para conectar ao banco de dados */\r\n";
        $this->string .= "    public static function connect()\r\n";
        $this->string .= "    {\r\n";
        $this->string .= "\r\n";
        $this->string .= "      /**\r\n";
        $this->string .= "      * Instânciamento de classe\r\n";
        $this->string .= "      * Pelo fato de estarem no mesmo lugar ambas as classes, não é necessário informar o 'use'\r\n";
        $this->string .= "      */\r\n";
        $this->string .= "\r\n";
        $this->string .= "      $" . "host = new Host();\r\n";
        $this->string .= "\r\n";
        $this->string .= "      if (!isset(self::$" . "pdo))\r\n";
        $this->string .= "      {\r\n";
        $this->string .= "\r\n";
        $this->string .= "          /** Inicio a conexão com o banco de dados */\r\n";
        $this->string .= "          self::$". "pdo = new \PDO($" . "host->getDsn(), $" . "host->getUser(), $" . "host->getPassword());\r\n";
        $this->string .= "\r\n";
        $this->string .= "          /** Habilito a listagem de erros ao executar o sql **/\r\n";
        $this->string .= "          self::$" . "pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);\r\n";
        $this->string .= "\r\n";
        $this->string .= "      }\r\n";
        $this->string .= "\r\n";
        $this->string .= "      /** Retorno minha conexão */\r\n";
        $this->string .= "      return self::$" . "pdo;\r\n";
        $this->string .= "\r\n";
        $this->string .= "      }\r\n";
        $this->string .= "\r\n";
        $this->string .= "}\r\n";
        $this->string .= "\r\n";

        /** Escrevo dentro do arquivo **/
        fwrite($this->document, $this->string);

        /** Encerro a escrita do arquivo **/
        fclose($this->document);

        /** Retorno o código gerado **/
        return true;

    }

    /** Escrevo o método construtor */
    public function fileHost($path, $name, $database_name, $database_user, $database_password, $database_path)
    {

        /** Parâmetros de entrada **/
        $this->path              = (string)$path;
        $this->name              = (string)$name;
        $this->database_name     = (string)$database_name;
        $this->database_user     = (string)$database_user;
        $this->database_password = (string)$database_password;
        $this->database_path     = (string)$database_path;

        /** Crio o arquivo **/
        $this->document = fopen($this->path . '/' . $this->name, "a+");

        /** Escrita do código **/
        $this->string  = "<?php\r\n";
        $this->string .= "\r\n";
        $this->string .= "class Host\r\n";
        $this->string .= "{\r\n";
        $this->string .= "\r\n";
        $this->string .= "    /** Pego a localização do banco de dados */\r\n";
        $this->string .= "    public function getDsn()\r\n";
        $this->string .= "    {\r\n";
        $this->string .= "\r\n";
        $this->string .= "        return $" . "dsn = (string)'mysql:host=" . $this->database_path . ";dbname=" . $this->database_name. "';\r\n";
        $this->string .= "\r\n";
        $this->string .= "    }\r\n";
        $this->string .= "\r\n";
        $this->string .= "    /** Pego o usuário de acesso */\r\n";
        $this->string .= "    public function getUser()\r\n";
        $this->string .= "    {\r\n";
        $this->string .= "\r\n";
        $this->string .= "        return $" . "user = (string)'" . $this->database_user . "';\r\n";
        $this->string .= "\r\n";
        $this->string .= "    }\r\n";
        $this->string .= "\r\n";
        $this->string .= "    /** Pego a senha de acesso */\r\n";
        $this->string .= "    public function getPassword()\r\n";
        $this->string .= "    {\r\n";
        $this->string .= "\r\n";
        $this->string .= "        return $" . "password = (string)'" . $this->database_password . "';\r\n";
        $this->string .= "\r\n";
        $this->string .= "    }\r\n";
        $this->string .= "\r\n";
        $this->string .= "    /** Pego o charset de acesso */\r\n";
        $this->string .= "    public function getCharset()\r\n";
        $this->string .= "    {\r\n";
        $this->string .= "\r\n";
        $this->string .= "        return $" . "charset = (string)'charset=utf8';\r\n";
        $this->string .= "\r\n";
        $this->string .= "    }\r\n";
        $this->string .= "\r\n";
        $this->string .= "}\r\n";
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

}
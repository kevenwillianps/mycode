<?php

/**
 * Comentário de cabeçalho de arquivo
 * Classe 'MethodsTemplates'
 *
 * @author Keven Willian
 * @version 1
 * @copyright Souza Consultoria Tecnlogica
 * @description Classe utilizada para manipular os dados da tabela "methods_templates"
 * @access public
*/

namespace vendor\model;

class MethodsTemplates
{
  /**
  * Comentário das variáveis
  * Variavéis usadas internamente na classe
  * @access private
  */
   private $connection; 
   private $sql; 
   private $stmt; 
   private $method_template_id;
   private $situation_id;
   private $user_id;
   private $name;
   private $description;
   private $type;
   private $code;
   private $version;
   private $release;
   private $date_register;
   private $date_update;

   /**
   * Método 'Construct'
   * @description MÃ©todo utilizado na construÃ§Ã£o da classe
   * @access public
   * @version 1
   * @release 1
   */

   public function __construct()
   {
   
       /** Cria o objeto de conexão com o banco de dados */
       $this->connection= new MySql();
   
       /** Inicio a conexão com o banco de dados */
       $this->connection->connect();
   
   }

   /**
   * Método 'Save'
   * @description MÃ©todo utilizado para salvar os registros
   * @access public
   * @version 1
   * @release 1
   */

   /**
   * @param $method_template_id
   * @param $situation_id
   * @param $user_id
   * @param $name
   * @param $description
   * @param $type
   * @param $code
   * @param $version
   * @param $release
   * @param $date_register
   * @param $date_update
   */
   public function save($method_template_id, $situation_id, $user_id, $name, $description, $type, $code, $version, $release, $date_register, $date_update)
   {

       /** Parâmetros de entrada */
       $this->method_template_id = (int)$method_template_id;
       $this->situation_id       = (int)$situation_id;
       $this->user_id            = (int)$user_id;
       $this->name               = (string)$name;
       $this->description        = (string)$description;
       $this->type               = (string)$type;
       $this->code               = (string)$code;
       $this->version            = (string)$version;
       $this->release            = (string)$release;
       $this->date_register      = (string)$date_register;
       $this->date_update        = (string)$date_update;

       /** Verifico se é inserção ou atualização */
       if ($this->method_template_id == 0)
       {

          /** Consulta SQL */
          $this->sql = 'INSERT INTO methods_templates(`method_template_id`, `situation_id`, `user_id`, `name`, `description`, `type`, `code`, `version`, `release`, `date_register`, `date_update`)VALUES(:method_template_id, :situation_id, :user_id, :name, :description, :type, :code, :version, :release, :date_register, :date_update)';

       } else {

          /** Consulta SQL */
          $this->sql = 'UPDATE methods_templates SET `method_template_id` = :method_template_id, `situation_id` = :situation_id, `user_id` = :user_id, `name` = :name, `description` = :description, `type` = :type, `code` = :code, `version` = :version, `release` = :release, `date_register` = :date_register, `date_update` = :date_update WHERE `method_template_id` = :method_template_id';

       }

       /** Preparo o SQL */
       $this->stmt = $this->connection->connect()->prepare($this->sql);
 
       /** Preencho os parâmetros do sql **/
       $this->stmt->bindParam(':method_template_id', $this->method_template_id);
       $this->stmt->bindParam(':situation_id', $this->situation_id);
       $this->stmt->bindParam(':user_id', $this->user_id);
       $this->stmt->bindParam(':name', $this->name);
       $this->stmt->bindParam(':description', $this->description);
       $this->stmt->bindParam(':type', $this->type);
       $this->stmt->bindParam(':code', $this->code);
       $this->stmt->bindParam(':version', $this->version);
       $this->stmt->bindParam(':release', $this->release);
       $this->stmt->bindParam(':date_register', $this->date_register);
       $this->stmt->bindParam(':date_update', $this->date_update);
   
       /** Execução do Sql */
       return $this->stmt->execute();

   }

   /**
   * Método 'All'
   * @description MÃ©todo utilizado para listar todos os registros
   * @access public
   * @version 1
   * @release 1
   */

   public function all()
   {
   
       /** Crio o sql */
       $this->sql = 'SELECT * FROM `methods_templates`';
   
       /** Preparo o sql */
       $this->stmt = $this->connection->connect()->prepare($this->sql);
   
       /** Execução do Sql */
       $this->stmt->execute();
   
       /** Retorno um objeto */
       return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
   
   }

   /**
   * Método 'Get'
   * @description MÃ©todo utilizado para pegar um registro em especifÃ­co
   * @access public
   * @version 1
   * @release 1
   */

   public function get($method_template_id)
   {
   
       /** Parâmetros de entrada */
       $this->method_template_id = $method_template_id;
   
       /** Crio o sql */
       $this->sql = 'SELECT * FROM `methods_templates` WHERE `method_template_id` = :method_template_id';
   
       /** Preparo o sql */
       $this->stmt = $this->connection->connect()->prepare($this->sql);
   
       /** Preencho os parâmetros do sql */
       $this->stmt->bindParam(':method_template_id', $this->method_template_id);
   
       /** Execução do Sql */
       $this->stmt->execute();
   
       /** Retorno um objeto */
       return $this->stmt->fetchObject();
   
   }

    /**
     * Método 'EditForm'
     * @description MÃ©todo utilizado para pegar um registro em especifÃ­co
     * @access public
     * @version 1
     * @release 1
     */

    public function editForm($method_template_id)
    {

        /** Parâmetros de entrada */
        $this->method_template_id = $method_template_id;

        /** Crio o sql */
        $this->sql = 'SELECT * FROM `methods_templates` WHERE `method_template_id` = :method_template_id';

        /** Preparo o sql */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do sql */
        $this->stmt->bindParam(':method_template_id', $this->method_template_id);

        /** Execução do Sql */
        $this->stmt->execute();

        /** Retorno um objeto */
        return $this->stmt->fetchObject();

    }

   /**
   * Método 'Delete'
   * @description MÃ©todo para excluir um registro
   * @access public
   * @version 1
   * @release 1
   */

   public function delete($method_template_id)
   {
   
       /** Parâmetros de entrada */
       $this->method_template_id = $method_template_id;
   
       /** Crio o sql */
       $this->sql = 'DELETE FROM `methods_templates` WHERE `method_template_id` = :method_template_id';
   
       /** Preparo o sql */
       $this->stmt = $this->connection->connect()->prepare($this->sql);
   
       /** Preencho os parâmetros do sql */
       $this->stmt->bindParam(':method_template_id', $this->method_template_id);
   
       /** Retorno a execução do sql */
       return $this->stmt->execute();
   
   }

   /**
   * Método 'Destruct'
   * @description MÃ©todo utilizado quando chegar ao final da classe
   * @access public
   * @version 1
   * @release 1
   */

   public function __destruct()
   {
   
       /** Cria o objeto de conexão com o banco de dados */
       $this->connection = null;
   
   }
}
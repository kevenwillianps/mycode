<?php

/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 **/

/** Defino o local onde a classe esta localizada **/
namespace vendor\model;

class ClassLogs
{

    /** Variaveis que irei utilizar na classe **/
    private $connection = null;
    private $sql = null;
    private $stmt = null;
    private $class_log_id = null;
    private $class_id = null;
    private $user_id = null;
    private $project_id = null;
    private $folder_id = null;
    private $name = null;
    private $name_space = null;
    private $description = null;
    private $version = null;
    private $release = null;
    private $table_name = null;
    private $date_register = null;
    private $date_update = null;

    /** Construtor da classe **/
    public function __construct()
    {

        /** Cria o objeto de conexão com o banco de dados **/
        $this->connection = new MySql();

        /** Inicio uma conexão com o banco de dados **/
        $this->connection->connect();

    }

    /** Lista todos os registros **/
    public function all($class_id)
    {

        /** Parâmetros de Entrada */
        $this->class_id = (int)$class_id;

        /** Consulta SQL **/
        $this->sql = "SELECT * FROM class_logs WHERE class_id = :class_id";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do Sql */
        $this->stmt->bindParam(':class_id', $this->class_id);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /** Lista todos os registros **/
    public function get($class_log_id)
    {

        /** Parâmetros de Entrada */
        $this->class_log_id = (int)$class_log_id;

        /** Consulta SQL **/
        $this->sql = "SELECT * FROM class_logs WHERE class_log_id = :class_log_id";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do Sql */
        $this->stmt->bindParam(':class_log_id', $this->class_log_id);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchObject();
    }

    /** Insere/autualiza um registro no banco de dados **/
    public function save($class_log_id, $class_id, $user_id, $project_id, $folder_id, $name, $name_space, $description, $version, $release, $table_name, $date_register, $date_update)
    {

        /** Parâmetros de entrada **/
        $this->class_log_id  = (int)$class_log_id;
        $this->class_id      = (int)$class_id;
        $this->user_id       = (int)$user_id;
        $this->project_id    = (int)$project_id;
        $this->folder_id     = (int)$folder_id;
        $this->name          = (string)$name;
        $this->name_space    = (string)$name_space;
        $this->description   = (string)$description;
        $this->version       = (string)$version;
        $this->release       = (string)$release;
        $this->table_name    = (string)$table_name;
        $this->date_register = (string)$date_register;
        $this->date_update   = (string)$date_update;

        /** Verifico se é inserção ou atualização **/
        if (($this->class_log_id == 0) || ($this->class_log_id > 0)) {

            /** Consulta SQL **/
            $this->sql = "INSERT INTO class_logs(`class_log_id`, `class_id`, `user_id`, `project_id`, `folder_id`, `name`, `name_space`, `description`, `version`, `release`, `table_name`, `date_register`, `date_update`)VALUES(:class_log_id, :class_id, :user_id, :project_id, :folder_id, :name, :name_space, :description, :version, :release, :table_name, :date_register, :date_update)";

        }

        /** Preparo o SQL **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do sql **/
        $this->stmt->bindParam(':class_log_id', $this->class_log_id);
        $this->stmt->bindParam(':class_id', $this->class_id);
        $this->stmt->bindParam(':user_id', $this->user_id);
        $this->stmt->bindParam(':project_id', $this->project_id);
        if ($this->folder_id > 0){
            $this->stmt->bindParam(':folder_id', $this->folder_id);
        }else{
            $this->stmt->bindParam(':folder_id', $this->folder_id, \PDO::PARAM_NULL);
        }
        $this->stmt->bindParam(':name', $this->name);
        $this->stmt->bindParam(':name_space', $this->name_space);
        $this->stmt->bindParam(':description', $this->description);
        $this->stmt->bindParam(':version', $this->version);
        $this->stmt->bindParam(':release', $this->release);
        $this->stmt->bindParam(':table_name', $this->table_name);
        $this->stmt->bindParam(':date_register', $this->date_register);
        $this->stmt->bindParam(':date_update', $this->date_update);

        /** Executo o Sql **/
        return $this->stmt->execute();
    }

    public function __destruct()
    {

        $this->connection = null;

    }
}

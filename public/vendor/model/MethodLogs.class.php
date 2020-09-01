<?php

/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 **/

/** Defino o local onde a classe esta localizada **/
namespace vendor\model;

class MethodLogs
{

    /** Variaveis que irei utilizar na classe **/
    private $connection = null;
    private $sql = null;
    private $stmt = null;
    private $method_log_id = null;
    private $method_id = null;
    private $user_id = null;
    private $class_id = null;
    private $name = null;
    private $description = null;
    private $type = null;
    private $code = null;
    private $version = null;
    private $release = null;
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

    /** Insere/autualiza um registro no banco de dados **/
    public function save($method_log_id, $method_id, $user_id, $class_id, $name, $description, $type, $code, $version, $release, $date_register, $date_update)
    {

        /** Parâmetros de entrada **/
        $this->method_log_id = (int)$method_log_id;
        $this->method_id = (int)$method_id;
        $this->user_id = (int)$user_id;
        $this->class_id = (int)$class_id;
        $this->name = (string)$name;
        $this->description = (string)$description;
        $this->type = (string)$type;
        $this->code = (string)$code;
        $this->version = (string)$version;
        $this->release = (string)$release;
        $this->date_register = (string)$date_register;
        $this->date_update = (string)$date_update;

        /** Verifico se é inserção ou atualização **/
        if (($this->method_id == 0) || ($this->method_id > 0)) {

            /** Consulta SQL **/
            $this->sql = "INSERT INTO method_logs(`method_log_id`, `method_id`, `user_id`, `class_id`, `name`, `description`, `type`, `code`, `version`, `release`, `date_register`, `date_update`)VALUES(:method_log_id, :method_id, :user_id, :class_id, :name, :description, :type, :code, :version, :release, :date_register, :date_update)";

        }

        /** Preparo o SQL **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do sql **/
        $this->stmt->bindParam('method_log_id', $this->method_log_id);
        $this->stmt->bindParam('method_id', $this->method_id);
        $this->stmt->bindParam('user_id', $this->user_id);
        $this->stmt->bindParam('class_id', $this->class_id);
        $this->stmt->bindParam('name', $this->name);
        $this->stmt->bindParam('description', $this->description);
        $this->stmt->bindParam('type', $this->type);
        $this->stmt->bindParam('code', $this->code);
        $this->stmt->bindParam('version', $this->version);
        $this->stmt->bindParam('release', $this->release);
        $this->stmt->bindParam('date_register', $this->date_register);
        $this->stmt->bindParam('date_update', $this->date_update);

        /** Executo o Sql **/
        return $this->stmt->execute();
    }

}

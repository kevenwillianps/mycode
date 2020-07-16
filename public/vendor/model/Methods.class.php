<?php

/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 **/

/** Defino o local onde a classe esta localizada **/
namespace vendor\model;

class Methods
{

    /** Variaveis que irei utilizar na classe **/
    private $connection = null;
    private $sql = null;
    private $stmt = null;
    private $method_id = null;
    private $situation_id = null;
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

    /** Listo a quantidade total de registros **/
    public function editForm($method_id)
    {

        /** Parâmetro de entrada **/
        $this->method_id = (int)$method_id;

        /** Consulta SQL **/
        $this->sql = "select * from methods where method_id = :method_id";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindValue(':method_id', $this->method_id);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchObject();
    }

    /** Listo a quantidade total de registros **/
    public function get($method_id)
    {

        /** Parâmetro de entrada **/
        $this->method_id = (int)$method_id;

        /** Consulta SQL **/
        $this->sql = "select * from methods where method_id = :method_id";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindValue(':method_id', $this->method_id);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchObject();
    }

    /** Lista todos os registros **/
    public function all($class_id)
    {

        /** Parâmetro de entrada **/
        $this->class_id = (int)$class_id;

        /** Consulta SQL **/
        $this->sql = "select * from methods where class_id = :class_id";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindValue(':class_id', $this->class_id);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /** Insere/autualiza um registro no banco de dados **/
    public function save($method_id, $situation_id, $user_id, $class_id, $name, $description, $type, $code, $version, $release, $date_register, $date_update)
    {

        /** Parâmetros de entrada **/
        $this->method_id     = (int)$method_id;
        $this->situation_id  = (int)$situation_id;
        $this->user_id       = (int)$user_id;
        $this->class_id      = (int)$class_id;
        $this->name          = (string)$name;
        $this->description   = (string)$description;
        $this->type          = (string)$type;
        $this->code          = (string)$code;
        $this->version       = (string)$version;
        $this->release       = (string)$release;
        $this->date_register = (string)$date_register;
        $this->date_update   = (string)$date_update;

        /** Verifico se é inserção ou atualização **/
        if ($this->method_id == 0) {

            /** Consulta SQL **/
            $this->sql = "INSERT INTO methods(`method_id`, `situation_id`, `user_id`, `class_id`, `name`, `description`, `type`, `code`, `version`, `release`, `date_register`, `date_update`)VALUES(:method_id, :situation_id, :user_id, :class_id, :name, :description, :type, :code, :version, :release, :date_register, :date_update)";
        } else {

            /** Consulta SQL **/
            $this->sql = "UPDATE methods set `method_id` = :method_id, `situation_id` = :situation_id, `user_id` = :user_id, `class_id` = :class_id, `name` = :name, `description` = :description, `type` = :type, `code` = :code, `version` = :version, `release` = :release, `date_register` = :date_register, `date_update` = :date_update WHERE `method_id` = :method_id";
        }

        /** Preparo o SQL **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do sql **/
        $this->stmt->bindParam(':method_id', $this->method_id);
        $this->stmt->bindParam(':situation_id', $this->situation_id);
        $this->stmt->bindParam(':user_id', $this->user_id);
        $this->stmt->bindParam(':class_id', $this->class_id);
        $this->stmt->bindParam(':name', $this->name);
        $this->stmt->bindParam(':description', $this->description);
        $this->stmt->bindParam(':type', $this->type);
        $this->stmt->bindParam(':code', $this->code);
        $this->stmt->bindParam(':version', $this->version);
        $this->stmt->bindParam(':release', $this->release);
        $this->stmt->bindParam(':date_register', $this->date_register);
        $this->stmt->bindParam(':date_update', $this->date_update);

        /** Executo o Sql **/
        return $this->stmt->execute();
    }

    /** Excluo um registro específico **/
    public function delete($method_id)
    {

        /** Parâmetro de entrada **/
        $this->method_id = (int)$method_id;

        /** Consulta SQL **/
        $this->sql = "DELETE FROM methods WHERE method_id = :method_id";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindValue(':method_id', $this->method_id);

        /** Retorno um objeto **/
        return $this->stmt->execute();
    }
}

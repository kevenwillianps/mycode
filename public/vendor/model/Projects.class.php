<?php

/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 **/

/** Defino o local onde a classe esta localizada **/
namespace vendor\model;

class Projects
{

    /** Variaveis que irei utilizar na classe **/
    private $connection = null;
    private $sql = null;
    private $stmt = null;
    private $project_id = null;
    private $situation_id = null;
    private $user_id = null;
    private $name = null;
    private $description = null;
    private $version = null;
    private $release = null;
    private $database_local = null;
    private $database_name = null;
    private $database_user = null;
    private $database_password = null;
    private $path = null;
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
    public function editForm($project_id)
    {

        /** Parâmetro de entrada **/
        $this->project_id = (int)$project_id;

        /** Consulta SQL **/
        $this->sql = "select * from projects where project_id = :project_id";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':project_id', $this->project_id);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchObject();
    }

    /** Listo a quantidade total de registros **/
    public function get($project_id)
    {

        /** Parâmetro de entrada **/
        $this->project_id = (int)$project_id;

        /** Consulta SQL **/
        $this->sql = "select * from projects where project_id = :project_id";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':project_id', $this->project_id);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchObject();
    }

    /** Listo a quantidade total de registros **/
    public function getLast()
    {

        /** Consulta SQL **/
        $this->sql = "select * from projects order by project_id desc";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchObject();
    }

    /** Localizo o banco de dados **/
    public function findDatabase($database_name){

        /** Parâmetro de entrada **/
        $this->database_name = (string)$database_name;

        /** Consulta SQL **/
        $this->sql = "SELECT * FROM information_schema." . $this->database_name . ";";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':database_name', $this->database_name);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    /** Testo a conexão com o banco de dados **/
    public function FindUserAndPassword($database_user, $database_password){

        /** Parâmetro de entrada **/
        $this->database_user     = (string)$database_user;
        $this->database_password = (string)$database_password;

        /** Consulta SQL **/
        $this->sql = "SELECT * FROM mysql.user mysql_user WHERE mysql_user.user = :user";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':user', $this->database_user);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchObject();

    }

    /** Lista todos os registros **/
    public function all()
    {

        /** Consulta SQL **/
        $sql = "select * from projects";

        /** Preparo o Sql **/
        $stmt = $this->connection->connect()->prepare($sql);

        /** Executo o SQl **/
        $stmt->execute();

        /** Retorno um objeto **/
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /** Insere/autualiza um registro no banco de dados **/
    public function save($project_id, $situation_id, $user_id, $name, $description, $version, $release, $database_local, $database_name, $database_user, $database_password, $path, $date_register, $date_update)
    {

        /** Parâmetros de entrada **/
        $this->project_id        = (int)$project_id;
        $this->situation_id      = (int)$situation_id;
        $this->user_id           = (int)$user_id;
        $this->name              = (string)$name;
        $this->description       = (string)$description;
        $this->version           = (string)$version;
        $this->release           = (string)$release;
        $this->database_local    = (string)$database_local;
        $this->database_name     = (string)$database_name;
        $this->database_user     = (string)$database_user;
        $this->database_password = (string)$database_password;
        $this->path              = (string)$path;
        $this->date_register     = (string)$date_register;
        $this->date_update       = (string)$date_update;

        /** Verifico se é inserção ou atualização **/
        if ($this->project_id == 0) {

            /** Consulta SQL **/
            $this->sql = "INSERT INTO projects(`project_id`, `situation_id`, `user_id`, `name`, `description`, `version`, `release`, `database_local`, `database_name`, `database_user`, `database_password`, `path`, `date_register`, `date_update`)VALUES(:project_id, :situation_id, :user_id, :name, :description, :version, :release, :database_local, :database_name, :database_user, :database_password, :path, :date_register, :date_update)";

        } else {

            /** Consulta SQL **/
            $this->sql = "UPDATE projects set `project_id` = :project_id, `situation_id` = :situation_id, `user_id` = :user_id, `name` = :name, `description` = :description, `version` = :version, `release` = :release, `database_local` = :database_local, `database_name` = :database_name, `database_user` = :database_user, `database_password` = :database_password, `path` = :path, `date_register` = :date_register, `date_update` = :date_update WHERE `project_id` = :project_id";
        }

        /** Preparo o SQL **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do sql **/
        $this->stmt->bindParam(':project_id', $this->project_id);
        $this->stmt->bindParam(':situation_id', $this->situation_id);
        $this->stmt->bindParam(':user_id', $this->user_id);
        $this->stmt->bindParam(':name', $this->name);
        $this->stmt->bindParam(':description', $this->description);
        $this->stmt->bindParam(':version', $this->version);
        $this->stmt->bindParam(':release', $this->release);
        $this->stmt->bindParam(':database_local', $this->database_local);
        $this->stmt->bindParam(':database_name', $this->database_name);
        $this->stmt->bindParam(':database_user', $this->database_user);
        $this->stmt->bindParam(':database_password', $this->database_password);
        $this->stmt->bindParam(':path', $this->path);
        $this->stmt->bindParam(':date_register', $this->date_register);
        $this->stmt->bindParam(':date_update', $this->date_update);

        /** Executo o Sql **/
        return $this->stmt->execute();
    }

    /** Excluo um registro específico **/
    public function delete($project_id)
    {

        /** Parâmetro de entrada **/
        $this->project_id = (int)$project_id;

        /** Consulta SQL **/
        $this->sql = "DELETE FROM projects WHERE project_id = :project_id";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':project_id', $this->project_id);

        /** Retorno um objeto **/
        return $this->stmt->execute();

    }

    public function __destruct()
    {

        $this->connection = null;

    }
}

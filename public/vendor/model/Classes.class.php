<?php

/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 **/

/** Defino o local onde a classe esta localizada **/
namespace vendor\model;

class Classes
{

    /** Variaveis que irei utilizar na classe **/
    private $connection = null;
    private $sql = null;
    private $stmt = null;
    private $database_name = null;
    private $class_id = null;
    private $situation_id = null;
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

    /** Listo a quantidade total de registros **/
    public function editForm($class_id)
    {

        /** Parâmetro de entrada **/
        $this->class_id = (int)$class_id;

        /** Consulta SQL **/
        $this->sql = "select * from classes where class_id = :class_id";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':class_id', $this->class_id);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchObject();
    }

    /** Listo a quantidade total de registros **/
    public function get($class_id)
    {

        /** Parâmetro de entrada **/
        $this->class_id = (int)$class_id;

        /** Consulta SQL **/
        $this->sql = "select * from classes where class_id = :class_id";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':class_id', $this->class_id);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchObject();
    }

    /** Lista todos os registros **/
    public function all($project_id)
    {

        /** Parâmetro de entrada **/
        $this->project_id = (int)$project_id;

        /** Consulta SQL **/
        $this->sql = "select * from classes where project_id = :project_id and folder_id is null";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':project_id', $this->project_id);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /** Lista todos os registros **/
    public function allBuild($project_id)
    {

        /** Parâmetro de entrada **/
        $this->project_id = (int)$project_id;

        /** Consulta SQL **/
        $this->sql = "select 
                        c.class_id,
                        c.name as class_name, 
                        c.description as class_description, 
                        c.version as class_version, 
                        c.release as class_release, 
                        c.name_space as name_space, 
                        f.name as folder_name 
                        from classes c
                        left join folders f on c.folder_id = f.folder_id
                        where c.project_id = :project_id ";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':project_id', $this->project_id);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    /** Lista todos os registros **/
    public function filesInFolder($folder_id)
    {

        /** Parâmetro de entrada **/
        $this->folder_id = (int)$folder_id;

        /** Consulta SQL **/
        $this->sql = "select * from classes where folder_id = :folder_id";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':folder_id', $this->folder_id);

        /** Executo o SQl **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /** Insere/autualiza um registro no banco de dados **/
    public function save($class_id, $situation_id, $user_id, $project_id, $folder_id, $name, $name_space, $description, $version, $release, $table_name, $date_register, $date_update)
    {

        /** Parâmetros de entrada **/
        $this->class_id      = (int)$class_id;
        $this->situation_id  = (int)$situation_id;
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
        if ($this->class_id == 0) {

            /** Consulta SQL **/
            $this->sql = "INSERT INTO classes(`class_id`, `situation_id`, `user_id`, `project_id`, `folder_id`, `name`, `name_space`, `description`, `version`, `release`, `table_name`, `date_register`, `date_update`)VALUES(:class_id, :situation_id, :user_id, :project_id, :folder_id, :name, :name_space, :description, :version, :release, :table_name, :date_register, :date_update)";

        } else {

            /** Consulta SQL **/
            $this->sql = "UPDATE classes set `class_id` = :class_id, `situation_id` = :situation_id, `user_id` = :user_id, `project_id` = :project_id, `folder_id` = :folder_id, `name` = :name, `name_space` = :name_space, `description` = :description, `version` = :version, `release` = :release, `table_name` = :table_name, `date_register` = :date_register, `date_update` = :date_update WHERE `class_id` = :class_id";
        }

        /** Preparo o SQL **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do sql **/
        $this->stmt->bindParam(':class_id', $this->class_id);
        $this->stmt->bindParam(':situation_id', $this->situation_id);
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

    /** Excluo um registro específico **/
    public function delete($class_id)
    {

        /** Parâmetro de entrada **/
        $this->class_id = (int)$class_id;

        /** Consulta SQL **/
        $this->sql = "DELETE FROM classes WHERE class_id = :class_id";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':class_id', $this->class_id);

        /** Retorno um objeto **/
        return $this->stmt->execute();

    }

    /** Método que salva as classes automaticamente quando o projeto for criado **/
    public function findClasses($database_name)
    {

        /** Parâmetro de entrada **/
        $this->database_name = (string)$database_name;

        /** Consulta SQL **/
        $this->sql = "SELECT table_schema, table_name, table_type FROM information_schema.tables WHERE table_schema = :database_name";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':database_name', $this->database_name);

        /** Retorno um objeto **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function findParameters($database_name, $table_name)
    {

        /** Parâmetro de entrada **/
        $this->database_name = (string)$database_name;
        $this->table_name    = (string)$table_name;

        /** Consulta SQL **/
        $this->sql = "SELECT COLUMN_NAME, COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = :database_name AND TABLE_NAME = :table_name;";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':database_name', $this->database_name);
        $this->stmt->bindParam(':table_name', $this->table_name);

        /** Retorno um objeto **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function findPrimaryKey($database_name, $table_name)
    {

        /** Parâmetro de entrada **/
        $this->database_name = (string)$database_name;
        $this->table_name    = (string)$table_name;

        /** Consulta SQL **/
        $this->sql = "SELECT COLUMN_NAME, COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = :database_name AND TABLE_NAME = :table_name AND COLUMN_KEY = 'PRI';";

        /** Preparo o Sql **/
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQl **/
        $this->stmt->bindParam(':database_name', $this->database_name);
        $this->stmt->bindParam(':table_name', $this->table_name);

        /** Retorno um objeto **/
        $this->stmt->execute();

        /** Retorno um objeto **/
        return $this->stmt->fetchObject();

    }

    public function __destruct()
    {

        $this->connection = null;

    }
}

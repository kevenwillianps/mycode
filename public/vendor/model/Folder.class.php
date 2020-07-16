<?php

/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 **/

/** Defino o local onde a classe esta localizada **/
namespace vendor\model;

class Folder
{

    /** Variaveis que irei utilizar na classe **/
    private $connection = null;
    private $situation_id = 0;
    private $folder_id = 0;
    private $name = null;
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
    public function editForm($folder_id)
    {

        /** Parâmetro de entrada **/
        $this->folder_id = (int)$folder_id;

        /** Consulta SQL **/
        $sql = "select * from folders where folder_id = :folder_id";

        /** Preparo o Sql **/
        $stmt = $this->connection->connect()->prepare($sql);

        /** Preencho os parâmetros do SQl **/
        $stmt->bindValue(':$folder_id', $this->$folder_id);

        /** Executo o SQl **/
        $stmt->execute();

        /** Retorno um objeto **/
        return $stmt->fetchObject();
    }

    /** Listo a quantidade total de registros **/
    public function get($folder_id)
    {

        /** Parâmetro de entrada **/
        $this->folder_id = (int)$folder_id;

        /** Consulta SQL **/
        $sql = "select * from folders where folder_id = :folder_id";

        /** Preparo o Sql **/
        $stmt = $this->connection->connect()->prepare($sql);

        /** Preencho os parâmetros do SQl **/
        $stmt->bindValue(':folder_id', $this->folder_id);

        /** Executo o SQl **/
        $stmt->execute();

        /** Retorno um objeto **/
        return $stmt->fetchObject();
    }

    /** Lista todos os registros **/
    public function all()
    {

        /** Consulta SQL **/
        $sql = "select * from folders";

        /** Preparo o Sql **/
        $stmt = $this->connection->connect()->prepare($sql);

        /** Executo o SQl **/
        $stmt->execute();

        /** Retorno um objeto **/
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    /** Insere/autualiza um registro no banco de dados **/
    public function save($folder_id, $name, $date_register, $date_update)
    {

        /** Parâmetros de entrada **/
        $this->folder_id     = (string)$folder_id;
        $this->name          = (string)$name;
        $this->date_register = (string)$date_register;
        $this->date_update   = (string)$date_update;

        /** Verifico se é inserção ou atualização **/
        if ($this->folder_id == 0) {

            /** Consulta SQL **/
            $sql = "INSERT INTO folders(folder_id, name, date_register, date_update)VALUES(:folder_id, :name, :date_register, :date_update)";
        } else {

            /** Consulta SQL **/
            $sql = "UPDATE folders set folder_id = :folder_id, name = :name, date_register = :date_register, date_update = :date_update WHERE folder_id = :folder_id";
        }

        /** Preparo o SQL **/
        $stmt = $this->connection->connect()->prepare($sql);

        /** Preencho os parâmetros do sql **/
        $stmt->bindValue(':folder_id', $this->folder_id);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':date_register', $this->date_register);
        $stmt->bindValue(':date_update', $this->date_update);

        /** Executo o Sql **/
        return $stmt->execute();
    }

    /** Excluo um registro específico **/
    public function delete($folder_id)
    {

        /** Parâmetro de entrada **/
        $this->folder_id = (int)$folder_id;

        /** Consulta SQL **/
        $sql = "DELETE FROM folders WHERE folder_id = :folder_id";

        /** Preparo o Sql **/
        $stmt = $this->connection->connect()->prepare($sql);

        /** Preencho os parâmetros do SQl **/
        $stmt->bindValue(':folder_id', $this->folder_id);

        /** Retorno um objeto **/
        return $stmt->execute();
    }
}

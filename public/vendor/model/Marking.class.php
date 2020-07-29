<?php
/**
 * Created by PhpStorm.
 * User: KEVEN
 * Date: 28/07/2020
 * Time: 15:34
 */

namespace vendor\model;

class Marking
{

    /** Inicio os parâmetros */
    private $string;
    private $inputs;
    private $databaseName;
    private $parameters;
    private $inputsInsert;
    private $inputsUpdate;
    private $primaryKey;

    public function __construct()
    {

        /** Limpo as variaveis */
        $this->string = null;
        $this->inputs = null;
        $this->databaseName = null;
        $this->parameters = null;
        $this->inputsInsert = null;
        $this->inputsUpdate = null;
        $this->primaryKey = null;

    }

    /** Gerenciamento de marcações **/
    public function markingPrimaryKey($string)
    {

        /** Parâmetros de Entrada **/
        $this->string = (string) $string;

        /** Retorno o texto formatado */
        return $this->string = '$' . $this->string;

    }

    /** Gero os parâmetros de entrada */
    public function markingParametersMethod($inputs){

        /** Parâmetros de entrada **/
        $this->inputs = (array)$inputs;
        $this->string = null;

        /** Gero os campos */
        foreach ($this->inputs as $keyInputs => $resultInputs)
        {

            /** Escrita do código **/
            $this->string .= "$" . "this->" . $resultInputs['COLUMN_NAME'] . " = $" . $resultInputs['COLUMN_NAME'] . ";\r\n";

        }

        /** Retorno o resultado */
        return $this->string;

    }

    /** Gero os parâmetros de entrada */
    public function markingParameters($inputs){

        /** Parâmetros de entrada **/
        $this->inputs = (array)$inputs;
        $this->string = null;

        /** Gero os campos */
        foreach ($this->inputs as $keyInputs => $resultInputs)
        {

            /** Escrita do código **/
            $this->string .= "$" . $resultInputs['COLUMN_NAME'] . ", ";

        }

        /** Limpo virgulas que esta sobrando */
        $this->string = substr($this->string, 0, -2);

        /** Retorno o resultado */
        return $this->string;

    }

    /** Crio o Sql para Select */
    public function markingSqlSelect($databaseName)
    {

        /** Parâmetros de entrada **/
        $this->databaseName = (string)$databaseName;

        /** Retorno o resultado */
        return 'SELECT * FROM ' . $this->databaseName . ';';

    }

    /** Crio o Sql para delete */
    public function markingSqlDelete($primary_key, $databaseName)
    {

        /** Parâmetros de entrada **/
        $this->primaryKey = (string)$primary_key;
        $this->databaseName = (string)$databaseName;

        /** Retorno o resultado */
        return 'DELETE FROM ' . $this->databaseName . ' WHERE `' . $this->primaryKey . '` = :' . $this->primaryKey . ';';

    }

    /** Crio o Sql para insert */
    public function markingSqlInsert($inputs, $databaseName)
    {

        /** Parâmetros de entrada **/
        $this->inputs       = (array)$inputs;
        $this->databaseName = (string)$databaseName;

        /** Limpo as variaveis */
        $this->parameters = null;
        $this->inputsInsert = null;

        /** Preparação dos campos */
        foreach ($this->inputs as $keyInputs => $resultInput){

            /** Parâmetros */
            $this->parameters .= ":" . $resultInput['COLUMN_NAME'] . ", ";

            /** Campos da tabela */
            $this->inputsInsert .= "`" . $resultInput['COLUMN_NAME'] . "`, ";

        }

        /** Retorno o resultado */
        return 'INSERT INTO ' . $this->databaseName . '(' . substr($this->inputsInsert, 0, -2) . ') VALUES (' . substr($this->parameters, 0, -2) . ');';

    }

    /** Crio o Sql para update */
    public function markingSqlUpdate($inputs, $databaseName)
    {

        /** Parâmetros de entrada **/
        $this->inputs       = (array)$inputs;
        $this->databaseName = (string)$databaseName;

        /** Limpo as variaveis */
        $this->inputsUpdate = null;
        $this->primaryKey = null;

        /** Preparação dos campos */
        foreach ($this->inputs as $keyInputs => $resultInput){

            /** Parâmetros */
            $this->inputsUpdate .= "`" . $resultInput['COLUMN_NAME'] . "`" . " = " . ":" .$resultInput['COLUMN_NAME'] . ", ";

            /** Verificação de chave primária */
            if ($resultInput['COLUMN_KEY'] == 'PRI'){

                $this->primaryKey = $resultInput['COLUMN_NAME'];

            }

        }

        /** Retorno o resultado */
        return "UPDATE " . $this->databaseName . " SET " . substr($this->inputsUpdate, 0, -2) . " WHERE `" . $this->primaryKey . "` = :" . $this->primaryKey . ";";

    }

    /** Limpo minhas variáveis */
    public function __destruct()
    {

        /** Limpo as variaveis */
        $this->string = null;
        $this->inputs = null;
        $this->databaseName = null;
        $this->parameters = null;
        $this->inputsInsert = null;
        $this->inputsUpdate = null;
        $this->primaryKey = null;

    }

}
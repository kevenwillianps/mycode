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

}

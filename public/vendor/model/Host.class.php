<?php
/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 *
 */

/** Defino o local onde a classe esta localizada **/
namespace vendor\model;

class Host
{

    /** Pego a localização do banco de dados **/
    public function getDsn()
    {
        return $dsn = (string)"mysql:host=localhost;dbname=mycode3";
    }

    /** Pego o usuário de acesso **/
    public function getUser()
    {
        return $user = (string)"root";
    }

    /** Pego a senha de acesso **/
    public function getPassword()
    {
        return $password = (string)"";
    }

    /** Pego o charset de acesso **/
    public function getCharset()
    {
        return $charset = (string)"charset=utf8";
    }

}

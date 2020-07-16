<?php
/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 17:29
 *
 */

session_start();

try {

    $result = array(

        'user_id'          => @$_SESSION['MYCODE-USER-ID'],
        'user_name'        => @$_SESSION['MYCODE-USER-NAME'],
        'email'            => @$_SESSION['MYCODE-EMAIL'],
        'access_first'     => @$_SESSION['MYCODE-ACCESS-FIRST'],
        'access_last'      => @$_SESSION['MYCODE-ACCESS-LAST'],
        'date_register'    => @$_SESSION['MYCODE-DATE-REGISTER'],
        'date_update'      => @$_SESSION['MYCODE-DATE-UPDATE'],
        'user_function_id' => @$_SESSION['MYCODE-USER-FUNCTION-ID'],
        'function_name'    => @$_SESSION['MYCODE-FUNCTION-NAME'],
        'c_execute'        => @$_SESSION['MYCODE-C-EXECUTE'],
        'r_execute'        => @$_SESSION['MYCODE-R-EXECUTE'],
        'u_execute'        => @$_SESSION['MYCODE-U-EXECUTE'],
        'd_execute'        => @$_SESSION['MYCODE-D-EXECUTE'],

    );

    /** Result **/
    $result = array(

        "cod" => 1,
        "result" => $result

    );

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;
} catch (Exception $e) {

    /** Preparo o formulario para retorno **/
    $result = array(

        "cod" => 0,
        "message" => $e->getMessage(),

    );

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;
}

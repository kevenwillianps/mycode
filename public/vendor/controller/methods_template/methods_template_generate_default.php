<?php
/**
 * Created by MyCode
 * user: KEVEN
 * Date: 01/06/2020
 * Time: 13:20
 *
 */

/** Realizo a importação de classes **/
use \vendor\model\Main;
use \vendor\model\MethodsTemplates;

/** Instânciamento das classes importadas **/
$main = new Main();
$methodsTemplates = new MethodsTemplates();

try {

    /** Verifico se o usuário esta autenticado */
    if ($main->verifySession())
    {

        /** Array de Métodos */
        $default = array(

            /** Método '__construct' */
            array(

                'method_template_id' => 0,
                'situation_id' => 1,
                'user_id' => $_SESSION['MYCODE-USER-ID'],
                'name' => '__construct',
                'description' => 'Método utilizado na construção da classe',
                'type' => 'public',
                'code' => 'LyoqIENvbnN0cnV0b3IgZGEgY2xhc3NlICoqLwpwdWJsaWMgZnVuY3Rpb24gX19jb25zdHJ1Y3QoKQp7CgoJLyoqIENyaWEgbyBvYmpldG8gZGUgY29uZXjDo28gY29tIG8gYmFuY28gZGUgZGFkb3MgKiovCgkkdGhpcy0+Y29ubmVjdGlvbiA9IG5ldyBNeVNxbCgpOwoKCS8qKiBJbmljaW8gdW1hIGNvbmV4w6NvIGNvbSBvIGJhbmNvIGRlIGRhZG9zICoqLwoJJHRoaXMtPmNvbm5lY3Rpb24tPmNvbm5lY3QoKTsKCQp9',
                'version' => date('Y') . '.' . date('m'),
                'release' => ((int)$inputs['inputs']['release'] + 1),
                'date_register' => date("y-m-d h:m:s"),
                'date_update' => date("y-m-d h:m:s")

            ),

            /** Método '__destruct' */
            array(

                'method_template_id' => 0,
                'situation_id' => 1,
                'user_id' => $_SESSION['MYCODE-USER-ID'],
                'name' => '__destruct',
                'description' => 'Método utilizado na finalização da classe',
                'type' => 'public',
                'code' => 'LyoqIENvbnN0cnV0b3IgZGEgY2xhc3NlICoqLwpwdWJsaWMgZnVuY3Rpb24gX19kZXN0cnVjdCgpCnsKCgkvKiogRmluYWxpem8gYSBjb25leMOjbyBjb20gbyBiYW5jbyBkZSBkYWRvcyAqKi8KCSR0aGlzLT5jb25uZWN0aW9uID0gbnVsbDsKfQ==',
                'version' => date('Y') . '.' . date('m'),
                'release' => ((int)$inputs['inputs']['release'] + 1),
                'date_register' => date("y-m-d h:m:s"),
                'date_update' => date("y-m-d h:m:s")

            ),

            /** Método 'All' */
            array(

                'method_template_id' => 0,
                'situation_id' => 1,
                'user_id' => $_SESSION['MYCODE-USER-ID'],
                'name' => 'All',
                'description' => 'Método Utilizado para Listar Todos Registro',
                'type' => 'public',
                'code' => 'LyoqIExpc3RhIHRvZG9zIG9zIHJlZ2lzdHJvcyAqKi8KcHVibGljIGZ1bmN0aW9uIGFsbCgpCnsKCgkvKiogQ29uc3VsdGEgU1FMICoqLwoJJHRoaXMtPnNxbCA9IFtzcWxfc2VsZWN0XTsKCgkvKiogUHJlcGFybyBvIFNxbCAqKi8KCSR0aGlzLT5zdG10ID0gJHRoaXMtPmNvbm5lY3Rpb24tPmNvbm5lY3QoKS0+cHJlcGFyZSgkdGhpcy0+c3FsKTsKCgkvKiogRXhlY3V0byBvIFNRbCAqKi8KCSR0aGlzLT5zdG10LT5leGVjdXRlKCk7CgoJLyoqIFJldG9ybm8gdW0gb2JqZXRvICoqLwoJcmV0dXJuICR0aGlzLT5zdG10LT5mZXRjaEFsbChcUERPOjpGRVRDSF9BU1NPQyk7Cgp9',
                'version' => date('Y') . '.' . date('m'),
                'release' => ((int)$inputs['inputs']['release'] + 1),
                'date_register' => date("y-m-d h:m:s"),
                'date_update' => date("y-m-d h:m:s")

            ),

            /** Método 'Get' */
            array(

                'method_template_id' => 0,
                'situation_id' => 1,
                'user_id' => $_SESSION['MYCODE-USER-ID'],
                'name' => 'Get',
                'description' => 'Método Utilizado para Listar um Registro Especifico',
                'type' => 'public',
                'code' => 'LyoqIExpc3RvIGEgcXVhbnRpZGFkZSB0b3RhbCBkZSByZWdpc3Ryb3MgKiovCnB1YmxpYyBmdW5jdGlvbiBnZXQoW3ByaW1hcnlfa2V5XSkKewoKCS8qKiBQYXLDom1ldHJvIGRlIGVudHJhZGEgKiovCgkkdGhpcy0+W3ByaW1hcnlfa2V5XSA9IChpbnQpW3ByaW1hcnlfa2V5XTsKCgkvKiogQ29uc3VsdGEgU1FMICoqLwoJJHRoaXMtPnNxbCA9ICJzZWxlY3QgKiBmcm9tIG1ldGhvZHMgd2hlcmUgbWV0aG9kX2lkID0gOm1ldGhvZF9pZCI7CgoJLyoqIFByZXBhcm8gbyBTcWwgKiovCgkkdGhpcy0+c3RtdCA9ICR0aGlzLT5jb25uZWN0aW9uLT5jb25uZWN0KCktPnByZXBhcmUoJHRoaXMtPnNxbCk7CgoJLyoqIFByZWVuY2hvIG9zIHBhcsOibWV0cm9zIGRvIFNRbCAqKi8KCSR0aGlzLT5zdG10LT5iaW5kVmFsdWUoJzptZXRob2RfaWQnLCAkdGhpcy0+bWV0aG9kX2lkKTsKCgkvKiogRXhlY3V0byBvIFNRbCAqKi8KCSR0aGlzLT5zdG10LT5leGVjdXRlKCk7CgoJLyoqIFJldG9ybm8gdW0gb2JqZXRvICoqLwoJcmV0dXJuICR0aGlzLT5zdG10LT5mZXRjaE9iamVjdCgpOwp9',
                'version' => date('Y') . '.' . date('m'),
                'release' => ((int)$inputs['inputs']['release'] + 1),
                'date_register' => date("y-m-d h:m:s"),
                'date_update' => date("y-m-d h:m:s")

            ),

            /** Método 'Save' */
            array(

                'method_template_id' => 0,
                'situation_id' => 1,
                'user_id' => $_SESSION['MYCODE-USER-ID'],
                'name' => 'Save',
                'description' => 'Método Utilizado para Salvar o Registro',
                'type' => 'public',
                'code' => 'PD9waHAKCiAgICBwdWJsaWMgZnVuY3Rpb24gc2F2ZShbaW5wdXRzX3BhcmFtZXRlcnNdKQogICAgewoKICAgICAgICBbaW5wdXRzX3BhcmFtZXRlcnNfbWV0aG9kXQoKICAgICAgICBpZiAoW3ByaW1hcnlfa2V5XSkgewoKICAgICAgICAgICAgLyoqIENvbnN1bHRhIFNRTCAqKi8KICAgICAgICAgICAgJHRoaXMtPnNxbCA9IFtzcWxfaW5zZXJ0XTsKCQkJCiAgICAgICAgfSBlbHNlIHsKCiAgICAgICAgICAgIC8qKiBDb25zdWx0YSBTUUwgKiovCiAgICAgICAgICAgICR0aGlzLT5zcWwgPSBbc3FsX3VwZGF0ZV07CiAgICAgICAgfQoKICAgICAgICAvKiogUHJlcGFybyBvIFNRTCAqKi8KICAgICAgICAkdGhpcy0+c3RtdCA9ICR0aGlzLT5jb25uZWN0aW9uLT5jb25uZWN0KCktPnByZXBhcmUoJHRoaXMtPnNxbCk7CgogICAgICAgIC8qKiBQcmVlbmNobyBvcyBwYXLDom1ldHJvcyBkbyBzcWwgKiovCgkJW2JpbmRfcGFyYW1dOwoKICAgICAgICAvKiogRXhlY3V0byBvIFNxbCAqKi8KICAgICAgICByZXR1cm4gJHRoaXMtPnN0bXQtPmV4ZWN1dGUoKTsKICAgIH0KCj8+',
                'version' => date('Y') . '.' . date('m'),
                'release' => ((int)$inputs['inputs']['release'] + 1),
                'date_register' => date("y-m-d h:m:s"),
                'date_update' => date("y-m-d h:m:s")

            ),

            /** Método 'Delete' */
            array(

                'method_template_id' => 0,
                'situation_id' => 1,
                'user_id' => $_SESSION['MYCODE-USER-ID'],
                'name' => 'Delete',
                'description' => 'Método Utilizado para Excluir o Registro',
                'type' => 'public',
                'code' => 'LyoqIEV4Y2x1byB1bSByZWdpc3RybyBlc3BlY8OtZmljbyAqKi8KcHVibGljIGZ1bmN0aW9uIGRlbGV0ZShbcHJpbWFyeV9rZXldKQp7CgoJLyoqIFBhcsOibWV0cm8gZGUgZW50cmFkYSAqKi8KCSR0aGlzLT5tZXRob2RfaWQgPSBbcHJpbWFyeV9rZXldOwoKCS8qKiBDb25zdWx0YSBTUUwgKiovCgkkdGhpcy0+c3FsID0gW3NxbF9kZWxldGVdOwoKCS8qKiBQcmVwYXJvIG8gU3FsICoqLwoJJHRoaXMtPnN0bXQgPSAkdGhpcy0+Y29ubmVjdGlvbi0+Y29ubmVjdCgpLT5wcmVwYXJlKCR0aGlzLT5zcWwpOwoKCS8qKiBQcmVlbmNobyBvcyBwYXLDom1ldHJvcyBkbyBTUWwgKiovCglbYmluZF9wYXJhbV0KCgkvKiogUmV0b3JubyB1bSBvYmpldG8gKiovCglyZXR1cm4gJHRoaXMtPnN0bXQtPmV4ZWN1dGUoKTsKCQp9',
                'version' => date('Y') . '.' . date('m'),
                'release' => ((int)$inputs['inputs']['release'] + 1),
                'date_register' => date("y-m-d h:m:s"),
                'date_update' => date("y-m-d h:m:s")

            ),

        );

        /** Executo a array de métodos */
        for ($key = 0; $key < count($default); $key++){

            /** Execução do Método */
            $methodsTemplates->save($default[$key]['method_template_id'], $default[$key]['situation_id'], $default[$key]['user_id'], $default[$key]['name'], $default[$key]['description'], $default[$key]['type'], $default[$key]['code'], $default[$key]['version'], $default[$key]['release'], $default[$key]['date_register'], $default[$key]['date_update']);

        }

        /** Result **/
        $result = array(

            "cod" => 1,
            "result" => "Informações atualizadas com sucesso!"

        );

    }else{

        /** Preparo o formulario para retorno **/
        $result = array(

            "cod" => 404,
            "result" => "Usuário não autenticado",

        );

    }

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

} catch (Exception $e) {

    /** Preparo o formulario para retorno **/
    $result = array(

        "cod" => 0,
        "message" => $e->getMessage()

    );

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

}

<?php

/**
 *
 */
class Responseapi
{

    public function __construct()
    {
        //echo "This is main view <br>";
    }

    public function response($viewFile, $requireFile = false)
    {
        if ($requireFile == true) {
            require 'responses/' . $viewFile . '.php';
        } else {
            require 'responses/header.php';
            require 'responses/' . $viewFile . '.php';
        }
    }

    public  function return_success($msg, $data = array(), $rows = null, $jwt = null)
    {
        $return_obj['status'] = true;
        $return_obj['msg'] = $msg;
        $return_obj['data'] = $data;

        if ($rows !== null) {
            $return_obj['rows'] = $rows;
        }

        if ($rows !== null) {
            $return_obj['jwt'] = $jwt;
        }

        return json_encode($return_obj);
    }

    public function return_fail($msg, $data = array())
    {
        $return_obj['status'] = false;
        $return_obj['msg'] = $msg;
        $return_obj['data'] = $data;

        return json_encode($return_obj);
    }

    public function header($statuscode)
    {
        http_response_code($statuscode);
    }
}

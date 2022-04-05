<?php

/**
 * Apiheader class for checking http header
 * @param  [string]   page name
 * @return [object]   view object
 */
class Api
{

    private $reqmethod;
    public function __construct()
    {
        $this->reqmethod = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Creating requierd model object
     * @param  [string]   model name
     * @return [object]   required model object
     */
    public function accept_header($method)
    {
       
        switch ($method) {
            case 'POST':
                header("Access-Control-Allow-Origin: *");
                header("Content-Type: application/json; charset=UTF-8");
                header("Access-Control-Allow-Methods: POST");
                header("Access-Control-Max-Age: 3600");
                header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
                break;
            case 'GET':
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Headers: access");
                header("Access-Control-Allow-Methods: GET");
                header("Access-Control-Allow-Credentials: true");
                header('Content-Type: application/json');
                break;
            case 'PUT':
                header("Access-Control-Allow-Origin: *");
                header("Content-Type: application/json; charset=UTF-8");
                header("Access-Control-Allow-Methods: PUT");
                header("Access-Control-Max-Age: 3600");
                header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
                break;
            case 'PATCH':
                
                header("Access-Control-Allow-Origin: *");
                header("Content-Type: application/json; charset=UTF-8");
                header("Access-Control-Allow-Methods: PATCH");
                header("Access-Control-Max-Age: 3600");
                header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
                break;
            case 'DELETE':
               
                header("Access-Control-Allow-Origin: *");
                header("Content-Type: application/json; charset=UTF-8");
                header("Access-Control-Allow-Methods: DELETE");
                header("Access-Control-Max-Age: 3600");
                header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
                break;

            default:
               
                http_response_code(500);
                $return_obj['status'] = false;
                $return_obj['msg'] = 'unaccepted header';
                $return_obj['data'] = $method;
                exit;
                break;
        }
    }

    public function check_method($method)
    {
        
        if($this->reqmethod===$method){
            return true;
        }else{
            http_response_code(500);

            $return_obj['status'] = false;
            $return_obj['msg'] = 'unaccepted method';
            $return_obj['data'] = $this->reqmethod;
            echo json_encode($return_obj);
           
            exit;
        }
        
    }

    
}

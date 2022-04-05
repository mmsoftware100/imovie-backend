<?php

use \Firebase\JWT\JWT; // declaring class
/**
 * 
 */
class User extends Controller
{
    private $jwt_password = HS_REKEY;
    private $auth;

    function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
    }

    public function index()
    {
        $this->responseapi->data = 'something went wrong ..... !';
        $this->responseapi->response('error/index', true);
    }

    public function insert()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $jwt_data = empty($_POST['jwt']) ? null : $_POST['jwt'];

        $check = ($this->auth->middleware_user($jwt_data, $this->jwt_password));

        //echo "check is ";
        //echo json_encode($check);

        if ($check == false) {
            $this->responseapi->data = "jwt does not have sufficient data";
            $this->responseapi->response('user/insert_user', false);
        } else {


            //$json_data = json_decode(file_get_contents("php://input"),true);


            $data = array();
            $data['role'] = $_POST['role'];
            $data['name'] = $_POST['name'];
            $data['password'] = $_POST['password']; //Hash::Create('md5', $_POST['password'], HSKEY);
            $data['personal_data'] = $_POST['personal_data'];
            $data['created_datetime'] = date('y-m-d h:m:s');

            //print_r($data);
            //exit;



            $this->responseapi->data = $this->model->insert($data);
            $this->responseapi->rows = $this->model->rows();

            $this->responseapi->response('user/insert_user', true);
        }
    }

    public function select()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $jwt_data = empty($_POST['jwt']) ? null : $_POST['jwt'];

        $check = ($this->auth->middleware_user($jwt_data, $this->jwt_password));

        if ($check == false) {
            $this->responseapi->data = false;
        } else {



            $limit = empty($_POST['limit']) ? null : $_POST['limit'];
            $current = empty($_POST['current']) ? null : $_POST['current'];
            $where = empty($_POST['id']) ? null : $_POST['id'];


            $this->responseapi->data = $this->model->read($where, $current, $limit);
            $this->responseapi->rows = $this->model->rows();
        }

        $this->responseapi->response('user/get_user', true);
    }

    public function update()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');
        //$json_data = json_decode(file_get_contents("php://input"),true);
        $jwt_data = empty($_POST['jwt']) ? null : $_POST['jwt'];

        $check = ($this->auth->middleware_user($jwt_data, $this->jwt_password));

        if ($check == false) {
            $this->responseapi->data = false;
        } else {

            $data['role'] = $_POST['role'];
            $data['name'] = $_POST['name'];
            $data['password'] = $_POST['password']; //Hash::Create('md5', $_POST['password'], HSKEY);
            $data['personal_data'] = $_POST['personal_data'];
            $data['modified_datetime'] = date('y-m-d h:m:s');
            $where['id'] = $_POST['id'];


            $this->responseapi->data = $this->model->update($data, $where);
            $this->responseapi->rows = $this->model->rows();
        }
        $this->responseapi->response('user/update_user', true);
    }

    public function delete()
    {

        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');


        $jwt_data = empty($_POST['jwt']) ? null : $_POST['jwt'];

        $check = ($this->auth->middleware_user($jwt_data, $this->jwt_password));

        if ($check == false) {
            $this->responseapi->data = false;
        } else {
            $data['id'] = $_POST['id'];
            $deletecheck = $this->model->delete($data);
            if ($deletecheck) {

                $this->responseapi->data = $this->model->read();
                $this->responseapi->rows = $this->model->rows();
            } else {

                $this->responseapi->data = false;
            }
        }
        $this->responseapi->response('user/delete_user', true);
    }

    public function login()
    {

        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $data['name'] = $_POST['name'];
        $data['password'] = $_POST['password']; // Hash::Create('md5', $_POST['password'], HSKEY);
        // we didn't post ROLE data in Login Form.
        //$data['role'] = $_POST['role'];

        //echo "hello";

        $check = $this->model->check($data);
        // echo $check;
        if ($check) {

            $user = $check;
            $jwt = JWT::encode($user, $this->jwt_password);


            $this->responseapi->data = $user;
            $this->responseapi->jwt = $jwt;
        } else {

            $this->responseapi->data = false;
        }

        $this->responseapi->response('user/check_user', true);
    }
}

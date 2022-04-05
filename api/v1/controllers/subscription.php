<?php

/**
 * 
 */
class subscription extends Controller
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

        //$json_data = json_decode(file_get_contents("php://input"),true);
        $jwt_data = empty($_POST['jwt']) ? null : $_POST['jwt'];

        $check = ($this->auth->middleware_user($jwt_data, $this->jwt_password));

        if ($check == false) {
            $this->responseapi->data = 'unauthorized access';
        } else {

            $data['user_id'] = $_POST['user_id'];
            $data['user_name'] = $_POST['user_name'];
            $data['user_type'] = $_POST['user_type'];
            $data['exp_date'] = $_POST['exp_date'];
            $data['created_datetime'] = date('y-m-d h:m:s');


            $this->responseapi->data = $this->model->insert($data);
            $this->responseapi->rows = $this->model->rows();
        }
        $this->responseapi->response('sub/insert_sub', true);
    }

    public function select()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $jwt_data = empty($_POST['jwt']) ? null : $_POST['jwt'];

        $check = ($this->auth->middleware_user($jwt_data, $this->jwt_password));

        if ($check == false) {
            $this->responseapi->data = 'unauthorized access';
        } else {
            $limit = empty($_POST['limit']) ? null : $_POST['limit'];
            $current = empty($_POST['current']) ? null : $_POST['current'];
            $where = empty($_POST['id']) ? null : $_POST['id'];


            $this->responseapi->data = $this->model->read($where, $current, $limit);
            $this->responseapi->rows = $this->model->rows();
        }
        $this->responseapi->response('sub/get_sub', true);
    }

    public function update()
    {

        //$json_data = json_decode(file_get_contents("php://input"),true);
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $jwt_data = empty($_POST['jwt']) ? null : $_POST['jwt'];

        $check = ($this->auth->middleware_user($jwt_data, $this->jwt_password));

        if ($check == false) {
            $this->responseapi->data = 'unauthorized access';
        } else {

            $data['user_id'] = $_POST['user_id'];
            $data['user_name'] = $_POST['user_name'];
            $data['user_type'] = $_POST['user_type'];
            $data['exp_date'] = $_POST['exp_date'];
            $data['modified_datetime'] = date('y-m-d h:m:s');
            $where['id'] = $_POST['id'];


            $this->responseapi->data = $this->model->update($data, $where);
            $this->responseapi->rows = $this->model->rows();
        }
        $this->responseapi->response('sub/update_sub', true);
    }

    public function delete()
    {

        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $jwt_data = empty($_POST['jwt']) ? null : $_POST['jwt'];

        $check = ($this->auth->middleware_user($jwt_data, $this->jwt_password));

        if ($check == false) {
            $this->responseapi->data = 'unauthorized access';
        } else {

            $data['id'] = $_POST['id'];

            $check = $this->model->delete($data);
            if ($check) {

                $this->responseapi->data = $this->model->read();
                $this->responseapi->rows = $this->model->rows();
            } else {

                $this->responseapi->data = false;
            }
        }
        $this->responseapi->response('sub/delete_sub', true);
    }
}

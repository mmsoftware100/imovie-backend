<?php

/**
 * 
 */
class Resolution extends Controller
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
        $this->responseapi->errormsg = 'something want wrong ..... !';
        $this->responseapi->response('error/index', true);
    }

    public function insert()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');


        $jwt_data = empty($_POST['jwt']) ? null : $_POST['jwt'];

        $check = ($this->auth->middleware_user($jwt_data, $this->jwt_password));

        if ($check == false) {
            $this->responseapi->data = false;
        } else {
            //$json_data = json_decode(file_get_contents("php://input"),true);

            $data['name'] = $_POST['name'];
            $data['created_datetime'] = date('y-m-d h:m:s');

            $this->responseapi->data = $this->model->insert($data);
            $this->responseapi->rows = $this->model->rows();
        }
        $this->responseapi->response('resolution/insert_resolution', true);
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
        $this->responseapi->response('resolution/get_resolution', true);
    }

    public function update()
    {

        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');


        $jwt_data = empty($_POST['jwt']) ? null : $_POST['jwt'];

        $check = ($this->auth->middleware_user($jwt_data, $this->jwt_password));

        if ($check == false) {
            $this->responseapi->data = false;
        } else {

            //$json_data = json_decode(file_get_contents("php://input"),true);

            $data['name'] = $_POST['name'];
            $data['modified_datetime'] = date('y-m-d h:m:s');
            $where['id'] = $_POST['id'];

            $this->responseapi->data = $this->model->update($data, $where);
            $this->responseapi->rows = $this->model->rows();
        }
        $this->responseapi->response('resolution/update_resolution', true);
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

            $where['id'] = $_POST['id'];

            $this->responseapi->data = $this->model->delete($where);
            $this->responseapi->rows = $this->model->rows();
        }
        $this->responseapi->response('resolution/delete_resolution', true);
    }
}

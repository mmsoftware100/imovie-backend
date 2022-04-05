<?php

/**
 * 
 */
class Ads extends Controller
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


        $data['description'] = $_POST['description'];
        $data['name'] = $_POST['name'];
        $data['ads_type'] = $_POST['ads_type'];
        $data['media_url'] = $_POST['media_url'];
        $data['ads_status'] = $_POST['ads_status'];
        $data['url'] = $_POST['url'];
        $data['created_datetime'] = date('y-m-d h:m:s');


        $this->responseapi->data = $this->model->insert($data);
        $this->responseapi->rows = $this->model->rows();
        $this->responseapi->response('ads/insert_ads', true);
    }

    public function select()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $limit = empty($_POST['limit']) ? null : $_POST['limit'];
        $current = empty($_POST['current']) ? null : $_POST['current'];
        $where = empty($_POST['id']) ? null : $_POST['id'];


        $this->responseapi->data = $this->model->read($where, $current, $limit);
        $this->responseapi->rows = $this->model->rows();
        $this->responseapi->response('ads/get_ads', true);
    }

    public function update()
    {

        //$json_data = json_decode(file_get_contents("php://input"),true);

        $data['description'] = $_POST['description'];
        $data['name'] = $_POST['name'];
        $data['ads_type'] = $_POST['ads_type'];
        $data['media_url'] = $_POST['media_url'];
        $data['ads_status'] = $_POST['ads_status'];
        $data['url'] = $_POST['url'];
        $data['modified_datetime'] = date('y-m-d h:m:s');
        $where['id'] = $_POST['id'];


        $this->responseapi->data = $this->model->update($data, $where);
        $this->responseapi->rows = $this->model->rows();
        $this->responseapi->response('ads/update_ads', true);
    }

    public function delete()
    {

        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $data['id'] = $_POST['id'];

        $check = $this->model->delete($data);
        if ($check) {

            $this->responseapi->data = $this->model->read();
            $this->responseapi->rows = $this->model->rows();
        } else {

            $this->responseapi->data = false;
        }
        $this->responseapi->response('ads/delete_ads', true);
    }
}

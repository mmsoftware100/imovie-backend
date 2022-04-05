<?php

/**
 * 
 */
class Movie_season extends Controller
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
        $this->responseapi->errormsg = 'something went wrong ..... !';
        $this->responseapi->response('error/index', true);
    }

    public function insert()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        //$json_data = json_decode(file_get_contents("php://input"),true);

        $data['name'] = $_POST['name'];
        $data['movie_id'] = $_POST['movie'];
        $data['season_id'] = $_POST['season'];
        $data['created_datetime'] = date('y-m-d h:m:s');

        $this->responseapi->data = $this->model->insertreturnid($data);
        $this->responseapi->rows = $this->model->rows();
        $this->responseapi->response('movieseason/insert_movieseason', true);
    }

    public function select()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');
        // $this->model->insert();
        $this->responseapi->data = $this->model->read();
        $this->responseapi->rows = $this->model->rows();
        $this->responseapi->response('movieseason/get_movieseason', true);
    }

    public function update()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        //$json_data = json_decode(file_get_contents("php://input"),true);

        $data['name'] = $_POST['name'];
        $data['movie_id'] = $_POST['movie'];
        $data['season_id'] = $_POST['season'];
        $data['modified_datetime'] = date('y-m-d h:m:s');
        $where['id'] = $_POST['id'];

        $this->responseapi->data = $this->model->update($data, $where);
        $this->responseapi->rows = $this->model->rows();
        $this->responseapi->response('movieseason/update_movieseason', true);
    }

    public function delete()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');
        // $this->model->insert();
        $this->responseapi->data = $this->model->delete();
        $this->responseapi->rows = $this->model->rows();
        $this->responseapi->response('movieseason/de,ete_movieseason', true);
    }
}

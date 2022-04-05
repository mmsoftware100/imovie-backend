<?php
/**
 * 
 */
class Season_episode extends Controller
{

    private $jwt_password = HS_REKEY;
    private $auth;

    function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
    }

    public function index(){
        $this->responseapi->data='need required uri';
        $this->responseapi->response('error/index',true);
    }

    public function insert(){
        $api=new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        //$json_data = json_decode(file_get_contents("php://input"),true);
        
        $data['name'] = $_POST['name'];
        $data['duration'] = $_POST['duration'];
        $data['movie_season_id'] = $_POST['movie_season'];
        $data['episode_id'] = $_POST['episode'];
        $data['created_datetime']=date('y-m-d h:m:s');

        $this->responseapi->data= $this->model->insert($data);
        $this->responseapi->rows= $this->model->rows();
        $this->responseapi->response('seasonepisode/insert_seasonepisode',true);

    }

    public function select(){
        $api=new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $limit = empty($_POST['limit'])?null:$_POST['limit'];
        $current = empty($_POST['current'])?null:$_POST['current'];
        $where = empty($_POST['id'])?null:$_POST['id'];
        
       
        $this->responseapi->data= $this->model->read($where,$current,$limit);
        $this->responseapi->rows= $this->model->rows();
        $this->responseapi->response('seasonepisode/get_seasonepisode',true);

    }

    public function update(){
       
        $api=new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        //$json_data = json_decode(file_get_contents("php://input"),true);

        $data['name'] = $_POST['name'];
        $data['duration'] = $_POST['duration'];
        $data['movie_season_id'] = $_POST['movie_season'];
        $data['episode_id'] = $_POST['episode'];
        $data['modified_datetime']=date('y-m-d h:m:s');
        $where['id'] = $_POST['id'];

        $this->responseapi->data= $this->model->update($data,$where);
        $this->responseapi->rows= $this->model->rows();
        $this->responseapi->response('seasonepisode/update_seasonepisode',true);

    }
    
    public function delete(){
        
        $api=new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $where['id'] = $_POST['id'];

        $this->responseapi->data= $this->model->delete($where);
        $this->responseapi->rows= $this->model->rows();
        $this->responseapi->response('seasonepisode/delete_seasonepisode',true);

    }
}

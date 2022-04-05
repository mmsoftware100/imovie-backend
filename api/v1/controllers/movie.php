<?php

/**
 * 
 */
class Movie extends Controller
{

    function __construct()
    {
        parent::__construct();
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
        $json_data = json_decode($_POST['data'], true);
        //print_r($_POST);
        //print_r($json_data);
        //exit;

        $file_one      = 'poster_landscape';
        $file_two  = 'poster_portrait';
        $dir       = '../../uploads/';
        $file_one_check = File::uploadFile($file_one, $dir, true);
        $file_two_check = File::uploadFile($file_two, $dir, true);

        // $file_one_check ='photo_one';
        // $file_two_check = 'photo_two';

        if ($file_one_check !== false && $file_two_check !== false) {

            $data['name'] = $json_data['name'];
            $data['release_year'] = $json_data['release_year'];
            $data['description'] = $json_data['description'];
            $data['movie_type_id'] = $json_data['movie_type'];
            $data['poster_landscape']     = $file_one_check;
            $data['poster_portrait']     = $file_two_check;
            $data['category'] = $json_data['category'];
            $data['season_list'] = $json_data['season_list'];

            $this->responseapi->data = $this->model->insert_old($data);
            $this->responseapi->rows = $this->model->rows();
            $this->responseapi->response('movie/insert_movie', true);
        } else {

            $this->responseapi->data = false;
            $this->responseapi->response('movie/insert_movie', true);
        }
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
        $this->responseapi->response('movie/get_movie', true);
    }

    public function selectbycategory()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $category = empty($_POST['category']) ? null : $_POST['category'];
        $limit = empty($_POST['limit']) ? null : $_POST['limit'];
        $current = empty($_POST['current']) ? null : $_POST['current'];


        $this->responseapi->data = $this->model->readbycategory($category, $current, $limit);
        $this->responseapi->rows = $this->model->rows();
        $this->responseapi->response('movie/get_movie', true);
    }

    public function selectbytype()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $type = empty($_POST['type']) ? null : $_POST['type'];
        $limit = empty($_POST['limit']) ? null : $_POST['limit'];
        $current = empty($_POST['current']) ? null : $_POST['current'];


        $this->responseapi->data = $this->model->readbytype($type, $current, $limit);
        $this->responseapi->rows = $this->model->rows();
        $this->responseapi->response('movie/get_movie', true);
    }

    public function selectbyreleaseyear()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $releaseyear = empty($_POST['releaseyear']) ? null : $_POST['releaseyear'];
        $limit = empty($_POST['limit']) ? null : $_POST['limit'];
        $current = empty($_POST['current']) ? null : $_POST['current'];


        $this->responseapi->data = $this->model->readbyreleaseyear($releaseyear, $current, $limit);
        $this->responseapi->rows = $this->model->rows();
        $this->responseapi->response('movie/get_movie', true);
    }

    public function selectbyname()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $name = empty($_POST['name']) ? null : $_POST['name'];
        $limit = empty($_POST['limit']) ? null : $_POST['limit'];
        $current = empty($_POST['current']) ? null : $_POST['current'];



        $this->responseapi->data = $this->model->readbyname($name, $current, $limit);
        $this->responseapi->rows = $this->model->rows();
        $this->responseapi->response('movie/get_movie', true);
    }

    public function update()
    {

        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');
        //$json_data = json_decode(file_get_contents("php://input"),true);
        $json_data = json_decode($_POST['data'], true);
        //print_r($_POST);
        //print_r($json_data);
        //exit;

        $file_one      = 'poster_landscape';
        $file_two  = 'poster_portrait';
        //$dir       = 'private/movie/images/';
        $dir       = '../../uploads/';

        $where = $json_data['id'];
        $movie_data = $this->model->readone_old($where);

        $poster_portrait = $movie_data['poster_portrait'];
        $poster_landscape = $movie_data['poster_landscape'];

        if (isset($_FILES['poster_landscape']) && $_FILES['poster_landscape']['size'] != 0) {

            $file_one_check = File::uploadFile($file_one, $dir, true);
            $checkdeletefile = File::deleteFile($poster_landscape, $dir);
        } else {
            $file_one_check = $poster_landscape;
        }

        if (isset($_FILES['poster_portrait']) && $_FILES['poster_portrait']['size'] != 0) {

            $file_two_check = File::uploadFile($file_two, $dir, true);
            $checkdeletefile = File::deleteFile($poster_portrait, $dir);
        } else {
            $file_two_check = $poster_portrait;
        }





        // $file_one_check ='photo_one';
        // $file_two_check = 'photo_two';

        if ($file_one_check !== false && $file_two_check !== false) {

            $data['id'] = $json_data['id'];
            $data['name'] = $json_data['name'];
            $data['release_year'] = $json_data['release_year'];
            $data['description'] = $json_data['description'];
            $data['movie_type_id'] = $json_data['movie_type'];
            $data['poster_landscape']     = $file_one_check;
            $data['poster_portrait']     = $file_two_check;
            $data['category'] = $json_data['category'];
            $data['season_list'] = $json_data['season_list'];

            $this->responseapi->data = $this->model->update($data);
            $this->responseapi->rows = $this->model->rows();
            $this->responseapi->response('movie/update_movie', true);
        } else {

            $this->responseapi->data = false;
            $this->responseapi->response('movie/update_movie', true);
        }
    }

    public function delete()
    {

        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        $where = $_POST['id'];

        $movie_data = $this->model->readone_old($where);
        $photodata[] = $movie_data['poster_portrait'];
        $photodata[] = $movie_data['poster_landscape'];

        if (!empty($photodata)) {

            foreach ($photodata as  $value) {

                $filename       = $value;
                $dir       = '../../uploads/';
                $checkdeletefile = File::deleteFile($filename, $dir);

                if (!$checkdeletefile) {
                    exit;
                }
            }
        }

        if ($this->model->delete($where)) {

            $this->responseapi->data = true;
            $this->responseapi->rows = $this->model->rows();
            $this->responseapi->response('movie/delete_movie', true);
        } else {
            $this->responseapi->data = false;
            $this->responseapi->rows = $this->model->rows();
            $this->responseapi->response('movie/delete_movie', true);
        }
    }
}

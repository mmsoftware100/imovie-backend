<?php

/**
 * \
 */
class Index extends Controller
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
        $this->responseapi->data = 'need required url';
        $this->responseapi->response('index/index', true);
    }
}

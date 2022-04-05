<?php
/**
 * 
 */
class Eroor extends Controller
{
	private $msg;
	function __construct($msg){
		parent::__construct();
		$this->msg=$msg;
		
		
	}

	public function index(){
		if(empty($this->msg)){
			$this->responseapi->errormsg='need required uri';
		}else{
			$this->responseapi->errormsg=$this->msg;
		}
		
		$this->responseapi->response('error/index',true);
	}
}
?>
<?php
class Index_Model extends Model
{
	
	function __construct()
	{
		 parent::__construct();
		 
	}

	public function index(){
        
        //$query=$this->db->prepare('SELECT * FROM news');
        //$query->setFetchMode(PDO::FETCH_ASSOC);
        //$query->execute();
        //$data=$query->fetchAll();
        //echo json_encode($data);
    }
}
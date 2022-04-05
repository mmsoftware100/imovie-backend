<?php
/**
 * 
 */
class Mvtype_Model extends Model
{
	
    function __construct(){
         parent::__construct();
		 
    }

    public function rows(){
        
        $query = "SELECT id FROM mvtypes";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        return $num;
    }

    public function insert($data){
        $lastid= $this->db->insertlastid($data,'mvtypes',true);

        if($lastid){
            return $this->read($lastid);
        }else{
            return false;
        }
    }
    
    public function insertreturnid($data){
        $lastid= $this->db->insertlastid($data,'mvtypes',true);
        return $lastid;
    }

   
    public function readone($where){

        $query = "SELECT  * FROM mvtypes WHERE mvtypes.id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);
        
        $stmt->execute();

        $num = $stmt->rowCount();
        
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $mvtypes = array(
                    "id" => (int)$id,
                    "name" => $name                   
                );
                
            }
            return $mvtypes;
        } else {
            return false;
        }
    }

    public function read($where = null, $current = null, $limit = null){

        $limit=($limit>20) ? 20: $limit;

        if ($limit !== null && $current !== null) {

           
            $firstlimit = $current;
            $secondlimit = $firstlimit + $limit;
            $query = "SELECT  id FROM mvtypes ORDER BY id ASC LIMIT $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        } 
        if ($limit !== null && $current == null) {

           
            $query = "SELECT  id FROM mvtypes ORDER BY id ASC LIMIT $limit";
            $stmt = $this->db->prepare($query);
        } 
        elseif ($current !== null) {

            $firstlimit = $current;
            $secondlimit = (int)$firstlimit + 20;
            $query = "SELECT  id FROM mvtypes ORDER BY id ASC LIMIT  $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        } elseif ($where !== null) {

            $query = "SELECT  id FROM mvtypes WHERE mvtypes.id=?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $where);
        } else {

            $query = "SELECT  id FROM mvtypes ORDER BY id ASC LIMIT 20";
            $stmt = $this->db->prepare($query);
        }



        $stmt->execute();

        $num = $stmt->rowCount();
        $mvtypes_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $mvtypes = $this->readone($id);
                array_push($mvtypes_arr, $mvtypes);
            }
            return $mvtypes_arr;
        } else {
            return false;
        }
    }

    public function update($data,$where){
        $check= $this->db->update($data,'mvtypes',$where);
        if($check==true){
            return $this->read($where['id']);
        }else{
            return false;
        }
    }

    public function delete($where){
        $check=  $this->db->delete($where, 'mvtypes');
        if($check==true){
            return $this->read();
        }else{
            return false;
        }
    }
}
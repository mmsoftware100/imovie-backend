<?php
/**
 * 
 */
class Season_Episode_Model extends Model
{
	
    function __construct(){
         parent::__construct();
         $this->loadOtherModel('episode_file');
        
		 
    }

    public function rows(){
        
        $query = "SELECT id FROM season_episode";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        return $num;
    }

    public function insert($data)
    {
        $lastid= $this->db->insertlastid($data,'season_episode',true);

        if($lastid){
            return $this->read($lastid);
        }else{
            return false;
        }

    }

    public function insertreturnid($data){
        $lastid= $this->db->insertlastid($data,'season_episode',true);
        return $lastid;
    }

    public function read($where = null, $current = null, $limit = null){

        $limit=($limit>20) ? 20: $limit;

        if ($limit !== null && $current !== null) {

           
            $firstlimit = $current;
            $secondlimit = $firstlimit + $limit;
            $query = "SELECT  se.id as id FROM season_episode as se ORDER BY se.id ASC LIMIT $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        } 
        elseif ($limit !== null && $current == null) {

           
            $query = "SELECT  se.id as id FROM season_episode as se ORDER BY se.id ASC LIMIT $limit";
            $stmt = $this->db->prepare($query);
        } 
        elseif ($current !== null) {

            $firstlimit = $current;
            $secondlimit = (int)$firstlimit + 20;
            $query = "SELECT  se.id as id FROM season_episode as se ORDER BY se.id ASC LIMIT  $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        } elseif ($where !== null) {

            $query = "SELECT  se.id as id FROM season_episode as se ORDER BY se.id WHERE se.id=?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $where);
        } else {

            $query = "SELECT  se.id as id FROM season_episode as se ORDER BY se.id ORDER BY se.id ASC LIMIT 20";
            $stmt = $this->db->prepare($query);
        }



        $stmt->execute();

        $num = $stmt->rowCount();
        $season_episode_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $episode_arr = $this->db->readone($id);
                array_push($season_episode_arr, $episode_arr);
            }
            return $season_episode_arr;
        } else {
            return false;
        }
    }

    public function readone($where)
    {

        $query = "SELECT  se.id as id, se.name as description ,se.duration as duration,e.name as name,se.episode_id as episodeid,episode.file_id as file_id FROM season_episode as se 
        LEFT JOIN  episodes as e ON se.episode_id=e.id
        LEFT JOIN (SELECT GROUP_CONCAT(id) as file_id , season_episode_id FROM episode_file GROUP BY season_episode_id) as episode ON se.id=episode.season_episode_id
        WHERE se.id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);

        $stmt->execute();

        $num = $stmt->rowCount();

    
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $file_id = explode(",", $file_id);
                $file_arr = array();
                foreach ($file_id as  $value) {
                    $filewhere = $value;
                    $filedata = $this->episode_filemodel->readone($filewhere);
                    $file_arr[] = $filedata;
                }
                
                $episode_data=array(
                    "id" => (int)$episodeid,
                    "name" => $name
                );

                $episode_arr = array(
                    "id" => (int)$id,
                    "episode" => $episode_data,
                    // "episode" => (int)$name,
                    "duration"=>(int)$duration,
                    "episode_description" => $description,
                    "file_model_list"=>$file_arr
                );
               
            }
            return $episode_arr;
        } else {
            return false;
        }
    }

    public function update($data,$where){
        $check= $this->db->update($data,'season_episode',$where);
        if($check==true){
            return $this->read($where['id']);
        }else{
            return false;
        }
    }

    public function delete($where){
        $check=  $this->db->delete($where, 'season_episode');
        if($check==true){
            return $this->read();
        }else{
            return false;
        }
    }

    public function file_id($where){
        $query = "SELECT  se.id as id, se.name as description ,se.duration as duration,e.name as name,episode.file_id as file_id FROM season_episode as se 
        LEFT JOIN  episodes as e ON se.episode_id=e.id
        LEFT JOIN (SELECT GROUP_CONCAT(id) as file_id , season_episode_id FROM episode_file GROUP BY season_episode_id) as episode ON se.id=episode.season_episode_id
        WHERE se.id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);

        $stmt->execute();

        $num = $stmt->rowCount();

    
        if ($num > 0) {
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $file_id = $file_id;
               
            }
            return $file_id;
        } else {
            return false;
        }

    }
}
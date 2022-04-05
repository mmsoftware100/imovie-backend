<?php

/**
 * 
 */
class Movie_season_Model extends Model
{

    function __construct()
    {
        parent::__construct();
        $this->loadOtherModel('season_episode');
        
    }

    public function rows()
    {

        $query = "SELECT id FROM movie_season";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        return $num;
    }

    public function insert($data)
    {
        $lastid = $this->db->insertlastid($data, 'movie_season', true);

        if ($lastid) {
            return $this->read($lastid);
        } else {
            return false;
        }
        
    }

    public function insertreturnid($data)
    {
        echo "movie_season_model->insertreturnid";
        $lastid = $this->db->insertlastid($data, 'movie_season', true);

        echo "movie_season_model->insertreturnid->lastId ".$lastid;
        return $lastid;
    }

    public function readone($where)
    {


        $query = "SELECT  ms.id as id,ms.name as description , s.name as name ,s.id as seasonid, season.episode_id FROM movie_season as ms 
        LEFT JOIN  seasons as s ON ms.season_id=s.id
        LEFT JOIN (SELECT GROUP_CONCAT(id) as episode_id , movie_season_id FROM season_episode GROUP BY movie_season_id) as season ON ms.id=season.movie_season_id
        WHERE ms.id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);

        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $episode_id = explode(",", $episode_id);
                $episode_arr = array();
                foreach ($episode_id as  $value) {
                    $episodewhere = $value;
                    $episodedata = $this->season_episodemodel->readone($episodewhere);
                    $episode_arr[] = $episodedata;
                }
                $season_data=array(
                    "id"=>(int)$seasonid,
                    "name"=>$name
                );


                $movie_season = array(
                    "id" => (int)$id,
                    //"season" => (int)$name,
                    "season" => $season_data,
                    "season_description" => $description,
                    "episode_list" => $episode_arr
                );
            }
            return $movie_season;
        } else {
            return false;
        }
    }

    public function read($where = null, $current = null, $limit = null)
    {

        $limit = ($limit > 20) ? 20 : $limit;

        if ($limit !== null && $current !== null) {

            $firstlimit = $current;
            $secondlimit = $firstlimit + $limit;
            $query = "SELECT  ms.id as id FROM movie_season as ms ORDER BY ms.movie_id  ASC LIMIT $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        }
        if ($limit !== null && $current == null) {

            $query = "SELECT  ms.id as id FROM movie_season as ms ORDER BY ms.movie_id  ASC LIMIT $limit";
            $stmt = $this->db->prepare($query);
        } elseif ($current !== null) {

            $firstlimit = $current;
            $secondlimit = (int)$firstlimit + 20;
            $query = "SELECT  ms.id as id FROM movie_season as ms ORDER BY ms.movie_id  ASC LIMIT  $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        } elseif ($where !== null) {

            $query = "SELECT  ms.id as id FROM movie_season as ms WHERE ms.id=?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $where);
        } else {

            $query = "SELECT  ms.id as id FROM movie_season as ms ORDER BY ms.movie_id ASC LIMIT 20";
            $stmt = $this->db->prepare($query);
        }



        $stmt->execute();

        $num = $stmt->rowCount();
        $movie_season_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $movie_season =$this-> readone($id);
                array_push($movie_season_arr, $movie_season);
            }
            return $movie_season_arr;
        } else {
            return false;
        }
    }


    public function update($data, $where)
    {
        $check = $this->db->update($data, 'movie_season', $where);
        if ($check == true) {
            return $this->read($where['id']);
        } else {
            return false;
        }
    }

    public function delete($where)
    {
        $check =  $this->db->delete($where, 'movie_season');
        if ($check == true) {
            return $this->read();
        } else {
            return false;
        }
    }

    public function deleteby($where)
    {
        $query = 'DELETE FROM movie_season WHERE goods=:goods AND size_code=:size_code';
        $check =  $this->db->selectdelete($query, $where);
        if ($check == true) {
            return true;
        } else {
            return false;
        }
    }

    public function search($where)
    {
        $data = $this->db->retrieveAll('movie_season', null, $where);
        return $data;
    }

    public function episode_id($where){
        $query = "SELECT  ms.id as id,ms.name as description , s.name as name , season.episode_id FROM movie_season as ms 
        LEFT JOIN  seasons as s ON ms.season_id=s.id
        LEFT JOIN (SELECT GROUP_CONCAT(id) as episode_id , movie_season_id FROM season_episode GROUP BY movie_season_id) as season ON ms.id=season.movie_season_id
        WHERE ms.id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);

        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $episode_id =$episode_id;
            
            }
            return $episode_id;
        } else {
            return false;
        }
    }
}

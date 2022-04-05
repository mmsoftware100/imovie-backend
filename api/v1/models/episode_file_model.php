<?php

/**
 * 
 */
class Episode_File_Model extends Model
{

    function __construct()
    {
        parent::__construct();
        $this->loadOtherModel('resolution');
    }

    public function rows()
    {

        $query = "SELECT id FROM episode_file";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        return (int)$num;
        
    }

    public function insert($data)
    {
        $lastid = $this->db->insertlastid($data, 'episode_file', true);

        if ($lastid) {
            return $this->read($lastid);
        } else {
            return false;
        }

    }

    public function insertreturnid($data)
    {
        $lastid = $this->db->insertlastid($data, 'episode_file', true);

        return $lastid;
    }

    public function read($where = null, $current = null, $limit = null)
    {

        //$limit = ($limit > 20) ? 20 : $limit;

        if ($limit !== null && $current !== null) {


            $firstlimit = $current;
            $secondlimit = $firstlimit + $limit;
            $query = "SELECT  ef.id as id FROM episode_file as ef ORDER BY ef.id ASC LIMIT $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        }
        if ($limit !== null && $current == null) {


            $query = "SELECT  ef.id as id FROM episode_file as ef ORDER BY ef.id ASC LIMIT $limit";
            $stmt = $this->db->prepare($query);
        } elseif ($current !== null) {

            $firstlimit = $current;
            $secondlimit = (int)$firstlimit + 20;
            $query = "SELECT  ef.id as id FROM episode_file as ef ORDER BY ef.id ASC LIMIT  $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        } elseif ($where !== null) {
            $query = "SELECT  ef.id as id FROM episode_file as ef WHERE ef.id=?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $where);
        } else {

            $query = "SELECT  ef.id as id FROM episode_file as ef ORDER BY ef.id ASC LIMIT 20";
            $stmt = $this->db->prepare($query);
        }



        $stmt->execute();

        $num = $stmt->rowCount();
        $episode_file_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $episode_file = $this->readone($id);
                array_push($episode_file_arr, $episode_file);
            }
            return $episode_file_arr;
        } else {
            return false;
        }
    }

    public function readone($where)
    {


        $query = "SELECT  ef.id as id,mf.name as filename,mf.file_size as size,mf.resolution_id as resolution FROM episode_file as ef
        LEFT JOIN  mvfiles as mf ON ef.file_id=mf.id WHERE mf.id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $file_arr = array(
                    "id" => (int)$id,
                    "name" => $filename,
                    "file_size" => (int) $size,
                    'resolution'=>$this->resolutionmodel->readone($resolution)
                );
            }
            return $file_arr;
        } else {
            return false;
        }
    }

    public function update($data, $where)
    {
        $check = $this->db->update($data, 'episode_file', $where);
        if ($check == true) {
            return $this->readone($where['id']);
        } else {
            return false;
        }
    }

    public function delete($where)
    {
        $check =  $this->db->delete($where, 'episode_file');
        if ($check == true) {
            return $this->read();
        } else {
            return false;
        }
    }

    public function deleteby($where)
    {
        $query = 'DELETE FROM episode_file WHERE goods=:goods AND category=:category ';
        $check =  $this->db->selectdelete($query, $where);
        if ($check == true) {
            return true;
        } else {
            return false;
        }
    }

    public function search($where)
    {
        $data = $this->db->retrieveAll('episode_file', null, $where);
        return $data;
    }

    public function episode_fileid($where){
        $query = "SELECT  ef.file_id FROM episode_file as ef WHERE ef.season_episode_id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);
        $stmt->execute();

        $num = $stmt->rowCount();
        

        if ($num > 0) {
            $file_id_arr=[];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $file_id = (int)$id;
                $file_id_arr[]=$file_id;
            }
            return $file_id_arr;
        } else {
            return false;
        }

    }

}

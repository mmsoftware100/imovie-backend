<?php

/**
 * 
 */
class Ads_Model extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function rows()
    {

        $query = "SELECT id FROM ads";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        return $num;
    }

    public function insert($data)
    {
        $lastid = $this->db->insertlastid($data, 'ads', true);

        if ($lastid) {
            return $this->read($lastid);
        } else {
            return false;
        }
    }

    public function readone($where)
    {

        $query = "SELECT  * FROM ads WHERE ads.id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);

        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $ads = array(
                    "id" => (int)$id,
                    "name" => $name,
                    "description" => $description,
                    "ads_type" => $ads_type,
                    "media_url" => $media_url,
                    "ads_status" => $ads_status,
                    "url" => $url
                );
            }
            return $ads;
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
            $query = "SELECT  * FROM ads ORDER BY id ASC LIMIT $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        }
        if ($limit !== null && $current == null) {


            $query = "SELECT  * FROM ads ORDER BY id ASC LIMIT $limit";
            $stmt = $this->db->prepare($query);
        } elseif ($current !== null) {

            $firstlimit = $current;
            $secondlimit = (int)$firstlimit + 20;
            $query = "SELECT  * FROM ads ORDER BY id ASC LIMIT  $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        } elseif ($where !== null) {

            $query = "SELECT  * FROM ads WHERE ads.id=?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $where);
        } else {

            $query = "SELECT  * FROM ads ORDER BY id ASC LIMIT 20";
            $stmt = $this->db->prepare($query);
        }



        $stmt->execute();

        $num = $stmt->rowCount();
        $ads_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $ads = $this->readone($id);
                array_push($ads_arr, $ads);
            }
            return $ads_arr;
        } else {
            return false;
        }
    }

    public function update($data, $where)
    {
        $check = $this->db->update($data, 'ads', $where);
        if ($check == true) {
            return $this->read($where['id']);
        } else {
            return false;
        }
    }

    public function delete($where)
    {
        $check =  $this->db->delete($where, 'ads');
        if ($check == true) {
            return $this->read();
        } else {
            return false;
        }
    }
}

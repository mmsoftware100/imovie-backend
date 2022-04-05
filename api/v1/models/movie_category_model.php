<?php

/**
 * 
 */
class Movie_Category_Model extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function rows()
    {

        $query = "SELECT id FROM movie_category";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        return $num;
    }

    public function insert($data)
    {
        $lastid = $this->db->insertlastid($data, 'movie_category', true);

        if ($lastid) {
            return $this->read($lastid);
        } else {
            return false;
        }
    }

    public function insertreturnid($data)
    {
        $lastid = $this->db->insertlastid($data, 'movie_category', true);

        return $lastid;
    }

    public function readone($where)
    {

        $query = "SELECT  * FROM movie_category WHERE movie_category.id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);

        $stmt->execute();

        $num = $stmt->rowCount();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $movie_category = array(
                    "id" => (int)$id,
                    "movie_id" => $movie_id,
                    "category_id" => $category_id,
                );
            }
            return $movie_category;
        } else {
            return false;
        }
    }

    public function read($where = null, $current = null, $limit = null)
    {

        //$limit = ($limit > 20) ? 20 : $limit;

        if ($limit !== null && $current !== null) {


            $firstlimit = $current;
            $secondlimit = $firstlimit + $limit;
            $query = "SELECT  id FROM movie_category ORDER BY id ASC LIMIT $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        }
        if ($limit !== null && $current == null) {


            $query = "SELECT  id FROM movie_category ORDER BY id ASC LIMIT $limit";
            $stmt = $this->db->prepare($query);
        } elseif ($current !== null) {

            $firstlimit = $current;
            $secondlimit = (int)$firstlimit + 20;
            $query = "SELECT  id FROM movie_category ORDER BY id ASC LIMIT  $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        } elseif ($where !== null) {

            $query = "SELECT  id FROM movie_category WHERE movie_category.id=?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $where);
        } else {

            $query = "SELECT  id FROM movie_category ORDER BY id ASC LIMIT 20";
            $stmt = $this->db->prepare($query);
        }



        $stmt->execute();

        $num = $stmt->rowCount();
        $movie_category_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $movie_category = $this->readone($id);
                array_push($movie_category_arr, $movie_category);
            }
            return $movie_category_arr;
        } else {
            return false;
        }
    }
    
   

    public function update($data, $where)
    {
        $check = $this->db->update($data, 'movie_category', $where);
        if ($check == true) {
            return $this->read($where['id']);
        } else {
            return false;
        }
    }

    public function delete($where)
    {
        $check =  $this->db->delete($where, 'movie_category');
        if ($check == true) {
            return $this->read();
        } else {
            return false;
        }
    }

    public function deleteby($where)
    {
        $query = 'DELETE FROM movie_category WHERE goods=:goods AND color_code=:color_code';
        $check =  $this->db->selectdelete($query, $where);
        if ($check == true) {
            return true;
        } else {
            return false;
        }
    }

    public function search($where)
    {
        $data = $this->db->retrieveAll('movie_category', null, $where);
        return $data;
    }

    public function movie_categoryid($where){   
        $query = "SELECT  category_id FROM movie_category WHERE movie_category.movie_id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);

        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            $category_id_arr=[];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $category_id = (int)$category_id;
                $category_id_arr[]=$category_id;
            }
            return $category_id_arr;
        } else {
            return false;
        }

    }
}

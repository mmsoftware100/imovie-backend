<?php

/**
 * 
 */
class User_Model extends Model
{

    function __construct()
    {
        parent::__construct();
        $this->loadOtherModel('subscription');
    }

    public function rows()
    {

        $query = "SELECT id FROM user";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        return $num;
    }

    public function insert($data)
    {
        $lastid = $this->db->insertlastid($data, 'user', true);

        if ($lastid) {
            return $this->read($lastid);
        } else {
            return false;
        }
    }

    public function readone($where)
    {

        $query = "SELECT  * FROM user WHERE user.id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);

        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $user = array(
                    "id" => (int)$id,
                    "name" => $name,
                    "role" => $role,
                    // "password" => $password,
                    "personal_data" => $personal_data,
                    "subscription" => $this->subscriptionmodel->readsub($id)
                );
            }
            return $user;
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
            $query = "SELECT  * FROM user ORDER BY id ASC LIMIT $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        }
        if ($limit !== null && $current == null) {


            $query = "SELECT  * FROM user ORDER BY id ASC LIMIT $limit";
            $stmt = $this->db->prepare($query);
        } elseif ($current !== null) {

            $firstlimit = $current;
            $secondlimit = (int)$firstlimit + 20;
            $query = "SELECT  * FROM user ORDER BY id ASC LIMIT  $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        } elseif ($where !== null) {

            $query = "SELECT  * FROM user WHERE user.id=?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $where);
        } else {

            $query = "SELECT  * FROM user ORDER BY id ASC LIMIT 20";
            $stmt = $this->db->prepare($query);
        }



        $stmt->execute();

        $num = $stmt->rowCount();
        $user_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $user = $this->readone($id);
                array_push($user_arr, $user);
            }
            return $user_arr;
        } else {
            return false;
        }
    }

    public function update($data, $where)
    {
        $check = $this->db->update($data, 'user', $where);
        if ($check == true) {
            return $this->read($where['id']);
        } else {
            return false;
        }
    }

    public function delete($where)
    {
        $check =  $this->db->delete($where, 'user');
        if ($check == true) {
            return $this->read();
        } else {
            return false;
        }
    }

    public function check($where)
    {

        // we only check with user name and password
        //$query = "SELECT  * FROM user WHERE user.name=? AND user.password=? AND user.role=?";
        $query = "SELECT  * FROM user WHERE user.name=? AND user.password=?";
        //echo $query;
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where['name']);
        $stmt->bindParam(2, $where['password']);
        /*
        $username = "admin";
        $password = "password";
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $password);
        */
        //$stmt->bindParam(3, $where['role']);

        //echo "execte";
        $stmt->execute();

        $num = $stmt->rowCount();

        //echo $num;

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $user = array(
                    "id" => (int)$id,
                    "name" => $name,
                    "role" => $role,
                    // "password" => $password,
                    "personal_data" => $personal_data,
                    "subscription" => $this->subscriptionmodel->readsub($id)
                );
            }
            return $user;
        } else {
            return false;
        }
    }
}

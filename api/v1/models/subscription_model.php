<?php

/**
 * 
 */
class subscription_Model extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function rows()
    {

        $query = "SELECT id FROM subscription";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        return $num;
    }

    public function insert($data)
    {
        $lastid = $this->db->insertlastid($data, 'subscription', true);

        if ($lastid) {
            return $this->read($lastid);
        } else {
            return false;
        }
    }

    public function readone($where)
    {

        $query = "SELECT  * FROM subscription WHERE subscription.id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);

        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $subscription = array(
                    "id" => (int)$id,
                    "user_id" => (int)$user_id,
                    "user_name" => $user_name,
                    "user_type" => $user_type,
                    "exp_date" => $exp_date,

                );
            }
            return $subscription;
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
            $query = "SELECT  * FROM subscription ORDER BY id ASC LIMIT $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        }
        if ($limit !== null && $current == null) {


            $query = "SELECT  * FROM subscription ORDER BY id ASC LIMIT $limit";
            $stmt = $this->db->prepare($query);
        } elseif ($current !== null) {

            $firstlimit = $current;
            $secondlimit = (int)$firstlimit + 20;
            $query = "SELECT  * FROM subscription ORDER BY id ASC LIMIT  $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        } elseif ($where !== null) {

            $query = "SELECT  * FROM subscription WHERE subscription.id=?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $where);
        } else {

            $query = "SELECT  * FROM subscription ORDER BY id ASC LIMIT 20";
            $stmt = $this->db->prepare($query);
        }



        $stmt->execute();

        $num = $stmt->rowCount();
        $subscription_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $subscription = $this->readone($id);
                array_push($subscription_arr, $subscription);
            }
            return $subscription_arr;
        } else {
            return false;
        }
    }

    public function readsub($where)
    {

        $query = "SELECT  * FROM subscription WHERE subscription.user_id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);

        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $subscription = array(
                    "id" => (int)$id,
                    "user_id" => (int)$user_id,
                    "user_name" => $user_name,
                    "user_type" => $user_type,
                    "exp_date" => $exp_date,

                );
            }
            return $subscription;
        } else {
            return false;
        }
    }

    public function update($data, $where)
    {
        $check = $this->db->update($data, 'subscription', $where);
        if ($check == true) {
            return $this->read($where['id']);
        } else {
            return false;
        }
    }

    public function delete($where)
    {
        $check =  $this->db->delete($where, 'subscription');
        if ($check == true) {
            return $this->read();
        } else {
            return false;
        }
    }
}

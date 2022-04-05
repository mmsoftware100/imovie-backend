<?php

/**
 * Database class
 * @param  extend PDO
 */
class Database extends PDO
{

    public function __construct($DBTYPE, $DBHOST, $DBNAME, $DBUSER, $DBPWS)
    {
        parent::__construct('mysql:host=localhost;dbname=datshin_nptstream','aungkoman','@ungkom@n55');
        //parent::__construct($DBTYPE . ':host=' . $DBHOST . ';dbname=' . $DBNAME, $DBUSER, $DBPWS);
        date_default_timezone_set("Asia/Yangon");
    }

    /**
     * Create function
     * @param  [array]   $data -> insert data
     * @param  [string]   $table -> table name
     * @return [boolean]   true /false ->success/fail
     */
    public function insertlastid($data, $table, $lastid = false)
    {

        $check = false;


        $attribute = '`' . implode('`,`', array_keys($data)) . '`';
        $param     = ' :' . implode(',:', array_keys($data));

        // echo $attribute;
        // echo $param;

        $query = "INSERT INTO $table ($attribute) VALUES ($param)";

        $insert = $this->prepare($query);

        foreach ($data as $key => $value) {
            $insert->bindValue(":$key", $value);
            // echo ($key . '=>' . $value);
        }

        if ($insert->execute()) {

            $id = $this->lastInsertId();

            if ($lastid == false) {

                $check = true;
            } else {

                $check = $id;
            }
        }

        return $check;
    }


    public function insert($data, $table)
    {

        $check = false;

        // date value should be true or false
        if (isset($data['date'])) {
            $date         = date("Y-m-d h:i:s");
            $data['date'] = $date;

        }

        $attribute = '`' . implode('`,`', array_keys($data)) . '`';
        $param     = ' :' . implode(',:', array_keys($data));

        // echo $attribute;
        // echo $param;

        $query = "INSERT INTO $table ($attribute) VALUES ($param)";

        $insert = $this->prepare($query);

        foreach ($data as $key => $value) {
            $insert->bindValue(":$key", $value);
            // echo ($key . '=>' . $value);
        }

        if ($insert->execute()) {
            $check = true;
        }

        return $check;

    }

    public function multiInsert2($data,$tableName){

        $check = false;
        
        //Will contain SQL snippets.
        $rowsSQL = array();
     
        //Will contain the values that we need to bind.
        $toBind = array();
        
        //Get a list of column names to use in the SQL statement.
        $columnNames = array_keys($data);
     
        //Loop through our $data array.
        //print_r($data);

        foreach($data as $columnName=> $row){

            //echo $columnName;
            //print_r($row);
            $params = array();

            if (is_array($row) || is_object($row))
                
                {  
                    foreach($row as $arrayIndex  => $columnValue){
                    $param = ":" . $columnName . $arrayIndex;
                    $params[] = $param;
                    $toBind[$param] = $columnValue; 
                    }
                    $rowsSQL[]=$params;
                    
                    
                }
                // $rowsSQL[] = "(" . implode(", ", $params) . ")";
                // print_r($params);    
           
        }
        
        //print_r($rowsSQL);
        $SQL=[];
        $countdata = count($rowsSQL);
        $countdata2 = count($rowsSQL[0]);
        // echo $countdata;
        // echo $countdata2;

       
        for ($i=0; $i < $countdata2 ; $i++) {
            $b=[];
            for ($j=0; $j <$countdata ; $j++) { 
               $b[]=$rowsSQL[$j][$i];
            }
            //$a[]=$b;
            $SQL[]= "(" . implode(", ", $b) . ")";
        }
       
        // try{
            
        //     $this->beginTransaction();
            // print_r($SQL);
            //Construct our SQL statement
            $query= "INSERT INTO `$tableName` (" . implode(", ", $columnNames) . ") VALUES " . implode(", ", $SQL);
        
            //Prepare our PDO statement.
            $insert = $this->prepare($query);
        
            //Bind our values.
            foreach($toBind as $param => $val){
                $insert->bindValue($param, $val);
            }
        //     $insert->execute();

        //     $this->commit();
           
        //     return true;
        // }
        // catch(Exception $e){
        //     $this->rollBack();
        //     return false;
        // }

        //echo $query;
        //print_r($toBind);

        // try {
        //   $insert->execute();
        //   //If the exception is thrown, this text will not be shown
        //   echo 'Success';
        // }

        //catch exception
        // catch(Exception $e) {
        //   echo 'Message: ' .$e->getMessage();
        // }
        
        //Execute our statement (i.e. insert the data).
        if ($insert->execute()) {
                $check = true;
            }

        return $check;
       
    }

    /**
     * Read function
     * @param  [array/null]   $data -> require data
     * @param  [string]   $table -> table name
     * @param  [array/null]   $where -> predicate
     * @return [array]   data from table
     */

    public function retrieveAll($table, $data = null, $where = null)
    {

        $check      = false;
        $attribute  = ''; //data
        $prediciate = ''; //where
        if ($data != null && $where != null) {

            foreach ($data as $key => $value) {
                $attribute = '`' . implode('`,`', array_values($data)) . '`';
            }

            $tempattr = [];
            foreach ($where as $key => $value) {
                $tempattr[] = '`' . $key . '`' . '=:' . $key;
            }

            $predicate = implode(" AND ", $tempattr);
            //echo "SELECT {$attribute} FROM {$table} WHERE {$predicate}";
            $query    = "SELECT {$attribute} FROM {$table} WHERE {$predicate}";
            $retrieve = $this->prepare($query);
            foreach ($where as $key => $value) {
                $retrieve->bindValue(":$key", $value);
                //echo ($key . '=>' . $value);
            }

        } elseif ($where != null) {

            $tempattr = [];
            foreach ($where as $key => $value) {
                $tempattr[] = '`' . $key . '`' . '=:' . $key;
            }

            $predicate = implode(" AND ", $tempattr);
            //echo "SELECT * FROM {$table} WHERE {$predicate}";
            $query    = "SELECT * FROM {$table} WHERE {$predicate}";
            $retrieve = $this->prepare($query);
            foreach ($where as $key => $value) {
                $retrieve->bindValue(":$key", $value);
                //echo ($key . '=>' . $value);
            }

        } elseif ($data != null) {

            foreach ($data as $key => $value) {
                $attribute = '`' . implode('`,`', array_values($data)) . '`';
            }
            //echo "SELECT {$attribute} FROM $table";
            $query    = "SELECT {$attribute} FROM $table";
            $retrieve = $this->prepare($query);

        } else {
            //echo "SELECT * FROM $table";
            $query    = "SELECT * FROM $table";
            $retrieve = $this->prepare($query);

        }

        $retrieve->execute();
        $result = $retrieve->fetchAll();
        if ($result) {
            return $result;
        } else {
            return $check;
        }

    }

    public function retrieve($table, $data = null, $where = null)
    {

        $check      = false;
        $attribute  = ''; //data
        $prediciate = ''; //where
        if ($data != null && $where != null) {

            foreach ($data as $key => $value) {
                $attribute = '`' . implode('`,`', array_values($data)) . '`';
            }

            $tempattr = [];
            foreach ($where as $key => $value) {
                $tempattr[] = '`' . $key . '`' . '=:' . $key;
            }

            $predicate = implode(" AND ", $tempattr);
            //echo "SELECT {$attribute} FROM {$table} WHERE {$predicate}";
            $query    = "SELECT {$attribute} FROM {$table} WHERE {$predicate}";
            $retrieve = $this->prepare($query);
            foreach ($where as $key => $value) {
                $retrieve->bindValue(":$key", $value);
                //echo ($key . '=>' . $value);
            }

        } elseif ($where != null) {

            $tempattr = [];
            foreach ($where as $key => $value) {
                $tempattr[] = '`' . $key . '`' . '=:' . $key;
            }

            $predicate = implode(" AND ", $tempattr);
            //echo "SELECT * FROM {$table} WHERE {$predicate}";
            $query    = "SELECT * FROM {$table} WHERE {$predicate}";
            $retrieve = $this->prepare($query);
            foreach ($where as $key => $value) {
                $retrieve->bindValue(":$key", $value);
                //echo ($key . '=>' . $value);
            }

        } elseif ($data != null) {

            foreach ($data as $key => $value) {
                $attribute = '`' . implode('`,`', array_values($data)) . '`';
            }
            //echo "SELECT {$attribute} FROM $table";
            $query    = "SELECT {$attribute} FROM $table";
            $retrieve = $this->prepare($query);

        } else {
            //echo "SELECT * FROM $table";
            $query    = "SELECT * FROM $table";
            $retrieve = $this->prepare($query);

        }

        $retrieve->execute();
        $result = $retrieve->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        } else {
            return $check;
        }

    }

    /**
     * Update function
     * @param  [array-]   $data -> update data
     * @param  [string]   $table -> table name
     * @param  [array/null]   $where -> predicate
     * @return [boolean]   true/false -> success/fail
     */

    public function update($data, $table, $where)
    {

        $check = false;

        if (isset($data['date'])) {
            $date         = date("Y-m-d h:i:s");
            $data['date'] = $date;

        }

        $attrParam = '';
        foreach ($data as $key => $value) {
            $attrParam .= "`$key`=:$key,";
        }
        $attrParam = rtrim($attrParam, ',');
        

        $tempattr = [];
        foreach ($where as $key => $value) {
            $tempattr[] = '`' . $key . '`' . '=:' . $key;
        }
        $predicate = '';
        $predicate = implode(" AND ", $tempattr);

        $query = "UPDATE $table SET $attrParam WHERE $predicate";

        $update = $this->prepare($query);

        foreach ($data as $key => $value) {
            $update->bindValue(":$key", $value);

        }
        foreach ($where as $key => $value) {
            $update->bindValue(":$key", $value);

        }

        if ($update->execute()) {
            $check = true;
        }

        return $check;

    }

    /**
     * Delete function
     * @param  [array]   $id -> predicate
     * @param  [string]   $table -> table name
     * @return [boolean]   true/false -> success/fail
     */

    public function delete($id, $table, $limit = 1)
    {

        $check = false;

        $prediciate = '`' . implode('`,`', array_keys($id)) . '`' . '=:' . implode(',:', array_keys($id));

        $param = ':' . implode(',:', array_keys($id));
        $value = implode('', array_values($id));

        $query  = "DELETE FROM $table WHERE $prediciate LIMIT $limit";
        $delete = $this->prepare($query);
        $delete->bindValue($param, $value);
        if ($delete->execute()) {
            $check = true;
        }

        return $check;

    }

    /**
     * Read function(need query for what you want to get data from table)
     * @param  [string]   $query -> query string
     * @param  [array/null]   $where -> predicate
     * @param  [pdo::method]   $fetchmode -> fetch mode from pdo
     * @return [array]   data from table
     */

    public function select($query, $where = [], $fetchMode = PDO::FETCH_ASSOC)
    {

        $check  = false;
        $select = $this->prepare($query);
        //echo $query;
        //print_r($where);
        foreach ($where as $key => $value) {
            $select->bindValue(":$key", $value);
        }
        $select->execute();
        $result = $select->fetchAll($fetchMode);
        if ($result) {
            return $result;
        } else {
            return $check;
        }

    }

    public function selectdelete($query, $where = [])
    {

        $check     = false;
        $selectdel = $this->prepare($query);
        //echo $query;
        //print_r($where);
        foreach ($where as $key => $value) {
            $selectdel->bindValue(":$key", $value);
        }

        if ($selectdel->execute()) {
            $check = true;
        }
        return $check;

    }

    // $data=['rank','country','pol','est','world'];
    // excelInsert('excel',$data,'file',true);

    public function excelInsert($filename,$data, $table, $allsheet = false)
    {
        $check     = false;
        $attribute = '`' . implode('`,`', array_values($data)) . '`';
        $param     = ' :' . implode(',:', array_values($data));

        // echo $attribute;
        // echo $param;

        $query  = "INSERT INTO $table ($attribute) VALUES ($param)";
        $insert = $this->prepare($query);

        if ($xlsx = SimpleXLSX::parse($_FILES[$filename]['tmp_name'])) {

            if ($allsheet == false) {

                $dim        = $xlsx->dimension();
                $cols       = $dim[0];
                $insertData = $xlsx->rows();
                unset($insertData[0]);
                foreach ($insertData as $fields) {
                    foreach ($fields as $key => $value) {
                        $insert->bindValue(":$data[$key]", $value);
                        // echo ($key . '=>' . $value);
                    }

                    if ($insert->execute()) {
                        $check = true;
                    } else {
                        $check = false;
                        exit;
                    }

                }

            } else {

                $page  = count($xlsx->sheetNames());
                $count = 1;
                for ($a = 0; $a < $page; $a++) {
                    $dim        = $xlsx->dimension($a);
                    $cols       = $dim[0];
                    $insertData = $xlsx->rows($a);
                    unset($insertData[0]);
                    foreach ($insertData as $fields) {
                        foreach ($fields as $key => $value) {
                            $insert->bindValue(":$data[$key]", $value);
                            // echo ($key . '=>' . $value);
                        }

                        if ($insert->execute()) {
                            $check = true;
                        } else {
                            $check = false;
                            exit;
                        }

                    }

                }

            }

        } else {
            $check = SimpleXLSX::parseError();
        }

        return $check;
    }


    public function excelMultiInsert($filename,$data, $table, $allsheet = false)
    {
        $check     = false;
    
        if ($xlsx = SimpleXLSX::parse($_FILES[$filename]['tmp_name'])) {
            //Will contain SQL snippets.
            $rowsSQL = array();
         
            //Will contain the values that we need to bind.
            $toBind = array();


            if ($allsheet == false) {

                $dim        = $xlsx->dimension();
                $cols       = $dim[0];
                $insertData = $xlsx->rows();
                unset($insertData[0]);

                //Loop through our $data array.
                foreach($insertData as $arrayIndex => $row){
                    $params = array();
                    foreach($row as $key => $columnValue){
                        $param = ":" . $data[$key] . $arrayIndex;
                        $params[] = $param;
                        $toBind[$param] = $columnValue; 
                    }
                    $rowsSQL[] = "(" . implode(", ", $params) . ")";
                }

                // print_r($attributes);
                // print_r($rowsSQL);

                //Construct our SQL statement
                $query= "INSERT INTO `$table` (" . implode(", ", $data) . ") VALUES " . implode(", ", $rowsSQL);
                // echo $query;
                 
                //Prepare our PDO statement.
                $insert = $this->prepare($query);
                 
                //Bind our values.
                foreach($toBind as $param => $val){
                    $insert->bindValue($param, $val);
                }
                    
                //Execute our statement (i.e. insert the data).
                if ($insert->execute()) {
                    $check = true;
                }

            } else {

                $page  = count($xlsx->sheetNames());
                $count = 1;
                for ($a = 0; $a < $page; $a++) {
                    $dim        = $xlsx->dimension($a);
                    $cols       = $dim[0];
                    $insertData = $xlsx->rows($a);
                    unset($insertData[0]);

                    //Loop through our $data array.
                    foreach($insertData as $arrayIndex => $row){
                        $params = array();
                        foreach($row as $key => $columnValue){
                            $param = ":" . $data[$key] . $arrayIndex;
                            $params[] = $param;
                            $toBind[$param] = $columnValue; 
                        }
                        $rowsSQL[] = "(" . implode(", ", $params) . ")";
                    }
                
                    //Construct our SQL statement
                    $query= "INSERT INTO `$table` (" . implode(", ", $data) . ") VALUES " . implode(", ", $rowsSQL);
                 
                    //Prepare our PDO statement.
                    $insert = $this->prepare($query);
                 
                    //Bind our values.
                    foreach($toBind as $param => $val){
                        $insert->bindValue($param, $val);
                    }
                    
                    //Execute our statement (i.e. insert the data).
                    if ($insert->execute()) {
                        $check = true;
                    }

                }

            }

        } else {
            $check = SimpleXLSX::parseError();
        }

        return $check;
        
    }

    // $data=['rank','country','pol','est','world'];
    // csvInsert('excel',$data,'file');
    public function csvInsert($filename,$data, $table)
    {
        $check     = false;
        $attribute = '`' . implode('`,`', array_values($data)) . '`';
        $param     = ' :' . implode(',:', array_values($data));

        // echo $attribute;
        // echo $param;

        $query  = "INSERT INTO $table ($attribute) VALUES ($param)";
        $insert = $this->prepare($query);

        $fileName = $_FILES[$filename]["tmp_name"];

        if (($handle = fopen($fileName, "r")) !== false) {

            while (($column = fgetcsv($handle, 1000, ",")) !== false) {
                // $num  = count($column);
                // $keys = count($data);

                foreach ($column as $key => $value) {
                    $insert->bindValue(":$data[$key]", $value);
                    // echo ($data[$key] . '=>' . $value);
                }

                if ($insert->execute()) {
                    $check = true;
                } else {
                    $check = false;
                    exit;
                }

            }

            fclose($handle);
        }

        return $check;
    }

    // $data['id']= array("1", "2", "3", "4");
    // $table =table name
    public function selectedData($table, $reqdata)
    {
        $check      = false;
        $prediciate = '';
        $tempattr   = [];
        $result     = [];
        foreach ($reqdata as $key => $value) {
            $tempattr[] = '`' . $key . '`' . '=:' . $key;
            $predicate  = implode("", $tempattr);
            foreach ($value as $keyvalue) {
                $query    = "SELECT * FROM {$table} WHERE {$predicate}";
                $retrieve = $this->prepare($query);
                $retrieve->bindValue(":$key", $keyvalue);
                if ($retrieve->execute()) {
                    //$result[] = $retrieve->fetch();
                    $result[] = $retrieve->fetch(PDO::FETCH_ASSOC);//excel
                } else {
                    return $check;
                    exit();
                }

            }
        }

        return $result;
    }

    // $data['id']= array("1", "2", "3", "4");
    // $table =table name
    public function deleteData($table, $reqdata, $limit = 1)
    {
        $check     = false;
        $predicate = '';
        $tempattr  = [];

        foreach ($reqdata as $key => $value) {
            $tempattr[] = '`' . $key . '`' . '=:' . $key;
            $predicate  = implode("", $tempattr);
            foreach ($value as $keyvalue) {
                $query  = "DELETE FROM {$table} WHERE {$predicate} LIMIT $limit";
                $delete = $this->prepare($query);
                $delete->bindValue(":$key", $keyvalue);
                if ($delete->execute()) {
                    $check = true;
                } else {

                    $check = false;
                    return $check;
                    exit();
                }

            }
        }

        return $check;
    }

}



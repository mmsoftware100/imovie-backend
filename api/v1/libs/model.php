<?php
/**
 *
 */
class Model
{

    public function __construct()
    {
        $this->db = new Database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPWS);

    }

    public function loadOtherModel($name)
    {
        $path = 'models/' . $name . '_model.php';
        if (file_exists($path)) {
            require $path;
            $modelName   = $name . '_Model';
            $othermodel=$name.'model';
            $this->$othermodel = new $modelName();
            
        } else {
            return false;
        }
    }

    public function exportExcel($data, $name)
    {
        $timestamp = time();
        $filename  = $name . $timestamp . '.xls';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        $isPrintHeader = false;
        foreach ($data as $row) {
            if (!$isPrintHeader) {
                echo implode("\t", array_keys($row)) . "\n";
                $isPrintHeader = true;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
        exit();
    }

    public function exportCVS($data, $name)
    {
        $timestamp = time();
        $filename  = $name . $timestamp . '.cvs';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        $isPrintHeader = false;
        foreach ($data as $row) {
            if (!$isPrintHeader) {
                echo implode("\t", array_keys($row)) . "\n";
                $isPrintHeader = true;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
        exit();
    }

    public function expexcel($array, $name)
    {
        $filename  = $name . '.xls';
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel;");
        header("Pragma: no-cache");
        header("Expires: 0");
        $out = fopen("php://output", 'w');
        foreach ($array as $data) {
            fputcsv($out, $data, "\t");
        }
        fclose($out);
    }

    public function checkResult($variable,$on=false){
        if(is_array($variable)){
            print_r($variable);

        }else{
            echo ($variable);
           
        }
        
        if($on==true){
            
            exit;

        }
        
    }

}

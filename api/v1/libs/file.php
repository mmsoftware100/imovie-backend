<?php

/**
 *
 */
class File
{

    public static function uploadFile($filename, $dir, $uniqname = false)
    {
        //$dir    = "uploads/";
        $target_file = '';
        $temp_path   = $_FILES[$filename]["tmp_name"];
        if ($uniqname) {
            //$uniquesavename= uniqid();
            $uniquesavename = time() . uniqid(rand());
            $fname          = $_FILES[$filename]['name'];
            $ext            = pathinfo($fname, PATHINFO_EXTENSION);
            $new_name       = $uniquesavename . '.' . $ext;
            $target_file    = $dir . $new_name;
        } else {
            $new_name    = basename($_FILES[$filename]["name"]);
            $target_file = $dir . $new_name;
        }

        if (move_uploaded_file($temp_path, $target_file)) {
            return $new_name;
        } else {
            return false;
        }

    }

    public static function uploadFiles($filename, $dir, $uniqname = false)
    {
        //$dir    = "uploads/";
        $total       = count($_FILES[$filename]["name"]);
        $total_files = [];
        for ($i = 0; $i < $total; $i++) {
            $target_file = '';
            if ($uniqname) {
                $uniquesavename = time() . uniqid(rand());
                $fname          = $_FILES[$filename]['name'][$i];
                $ext            = pathinfo($fname, PATHINFO_EXTENSION);
                $new_name       = $uniquesavename . '.' . $ext;
                $target_file    = $dir . $new_name;
            } else {
                $new_name    = basename($_FILES[$filename]["name"][$i]);
                $target_file = $dir . $new_name;
            } // name conditon end

            $temp_path = $_FILES[$filename]["tmp_name"][$i];

            if ($temp_path != '') {
                if (move_uploaded_file($temp_path, $target_file)) {
                    $total_files[] = $new_name;
                } else {
                    $total_files = false;
                    return $total_files;
                    exit;
                }

            } //upload condition end

        } //forloop end

        return $total_files;
    }

    public static function upload($filename, $dir, $uniqname = false)
    {
        if (is_array($_FILES[$filename]["name"])) {

            $total       = count($_FILES[$filename]["name"]);
            $total_files = [];
            for ($i = 0; $i < $total; $i++) {
                $target_file = '';
                if ($uniqname) {
                    $uniquesavename = time() . uniqid(rand());
                    $fname          = $_FILES[$filename]['name'][$i];
                    $ext            = pathinfo($fname, PATHINFO_EXTENSION);
                    $new_name       = $uniquesavename . '.' . $ext;
                    $target_file    = $dir . $new_name;
                } else {
                    $new_name    = basename($_FILES[$filename]["name"][$i]);
                    $target_file = $dir . $new_name;
                } // name conditon end

                $temp_path = $_FILES[$filename]["tmp_name"][$i];

                if ($temp_path != '') {
                    if (move_uploaded_file($temp_path, $target_file)) {
                        $total_files[] = $new_name;
                    } else {
                        $total_files = false;
                        return $total_files;
                        exit;
                    }

                } //upload condition end

            } //forloop end

            return $total_files;

        } else {

            $target_file = '';
            $temp_path   = $_FILES[$filename]["tmp_name"];
            if ($uniqname) {
                //$uniquesavename= uniqid();
                $uniquesavename = time() . uniqid(rand());
                $fname          = $_FILES[$filename]['name'];
                $ext            = pathinfo($fname, PATHINFO_EXTENSION);
                $new_name       = $uniquesavename . '.' . $ext;
                $target_file    = $dir . $new_name;
            } else {
                $new_name    = basename($_FILES[$filename]["name"]);
                $target_file = $dir . $new_name;
            }

            if (move_uploaded_file($temp_path, $target_file)) {
                return $new_name;
            } else {
                return false;
            }

        }
    }

    public static function deleteFile($filename, $directory)
    {
        $result = false;
        
            $path = $directory . $filename;
            if (is_file($path)) {
                if (unlink($path)) {
                    $result = true;
                }else{
                    $result = false;
                }

            } else {
                $result = false;
            
            }
        
        
        
        return $result;
    }

// $files = ['./first.jpg','./second.jpg','./third.jpg'];
    public static function deletefiles($files , $directory)
    {
        $result = true;
        foreach ($files as $filename) {
            $path = $directory . $filename;
            if (file_exists($path)) {
                if (!unlink($path)) {
                    $result = false;
                }

            } else {
                $result = false;
                return $result;
                exit;
            }
        }
        return $result;
    }

    // $directory = "Articles/";
    public static function alldelete($directory)
    {

        $files = glob($directory . '/*'); // get all file names
        //$files = glob($directory.'/{,.}*, GLOB_BRACE'); // get all file names including hidden files
        foreach ($files as $file) {
            // iterate files
            if (is_file($file)) {
                unlink($file);
            } else {
                return false;
                exit;
            }
            // delete file
        }
        return true;
    }

    public function changeCVS($filename, $csv)
    {
        $xlsx = new SimpleXLSX($filename);
        $fp   = fopen($csv, 'w');
        foreach ($xlsx->rows() as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);
    }

}


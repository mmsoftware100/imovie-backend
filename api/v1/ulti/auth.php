<?php

use \Firebase\JWT\JWT; // declaring class
/**
 *
 */
class Auth
{

    static function middleware_user($jwt_data, $jwt_password)
    {

        try {
            $decoded = JWT::decode($jwt_data, $jwt_password, array('HS256'));
            $decoded_array = (array) $decoded;

            // print_r($decoded_array[0]->id);
            // exit;

            if ($decoded_array['role'] == 2) {
                return true;
            } else if ($decoded_array['role'] == 1) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $str = 'Caught exception in JWT::decode : ' .  $e->getMessage() . "\n";
            return false;
        }
    }

    // check jwt to make sure this is admin
    static function middleware_admin($jwt_data, $jwt_password)
    {
        try {
            $decoded = JWT::decode($jwt_data, $jwt_password, array('HS256'));
            $decoded_array = (array) $decoded;

            // print_r($decoded_array);
            // exit;

            if ($decoded_array['role'] == 1) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $str = 'Caught exception in JWT::decode : ' .  $e->getMessage() . "\n";
            return false;
        }
    }

    public function loginAuth()
    {
        Session::Init();
        $check = Session::Get('loginvalue');
        $admin = Session::Get('role'); {
            if ($check == false) {
                Session::Destory();
                header('location:http://localhost/toxic/login');
                exit;
            }
        }
    }



    public function doLog($text, $filename)
    {
        // open log file
        //$filename = "ulti/log.txt";
        $fh       = fopen($filename, "a") or die("Could not open log file.");
        fwrite($fh, date("d-m-Y, H:i") . " - $text\n") or die("Could not write file!");
        fclose($fh);
    }

    public function getIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ipAddr = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipAddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ipAddr = $_SERVER['REMOTE_ADDR'];
        }
        return $ipAddr;
    }
}

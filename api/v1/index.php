<?php
//echo "hello";
// Report all PHP errors
error_reporting(E_ALL);

//error_reporting(E_ALL);
ini_set('display_errors', 'On');
// ulti
require 'ulti/validate.php';
require 'ulti/auth.php';
require 'ulti/hash.php';

// config
require 'config/paths.php';
require 'config/dbconfig.php';
require 'config/hashconfig.php';


//libs
require 'libs/file.php';
require 'libs/form.php';
require 'libs/loader.php';
require 'libs/controller.php';
require 'libs/model.php';
require 'libs/responseapi.php';
require 'libs/api.php';

require 'libs/database.php';
require 'libs/session.php';

require './vendor/autoload.php'; // initialize composer library




$app = new loader();
$app->init();
//$app->showUrl();
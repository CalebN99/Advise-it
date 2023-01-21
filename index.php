<?php

// Error Reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);


//Require the autoload file
require_once('vendor/autoload.php');

session_start();

//Create an instance of the Base class (Fat-Free)
$f3 = Base::instance();

// Instantiate Global Objects
$con = new Controller($f3);
$valid = new Validation();
$datalayer = new DataLayer();


//Define a default route
$f3->route('GET|POST /', function() {

    $GLOBALS['con']->home();
});

//Define schedule route
$f3->route('GET|POST /schedule/@token', function($f3) {

    $GLOBALS['con']->saveSchedule($f3->get('PARAMS.token'));
});

//Define admin route
$f3->route('GET|POST /admin', function() {

    $GLOBALS['con']->admin();
});


//Run f3
$f3->run();
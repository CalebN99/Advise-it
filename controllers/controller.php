<?php

class Controller
{

    private $_f3;

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    /**
     * Method to load home view
     * @return void
     */
    function home()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $token = random_bytes(15);
            $token = bin2hex($token);
            header('location: new_schedule/' . $token);
        }
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function saveSchedule($token)
    {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo $_POST['fall'];
            echo $_POST['winter'];
            echo $_POST['spring'];
            echo $_POST['summer'];

        }

        $this->_f3->set('token', $token);
        $view = new Template();
        echo $view->render('views/new_schedule.html');
    }

}
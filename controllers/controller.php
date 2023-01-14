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
        $token = "";
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $token = random_bytes(15);
            $token = bin2hex($token);
            while ($GLOBALS['datalayer']->checkToken($token)) {
                $token = random_bytes(15);
                $token = bin2hex($token);
            }

            header('location: new_schedule/' . $token);

        }

        $view = new Template();
        echo $view->render('views/home.html');
    }

    function saveSchedule($token)
    {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $fall = "";
            $winter = "";
            $spring = "";
            $summer = "";

            if ($_POST['fall']) {
                $fall = $_POST['fall'];
            }
            if ($_POST['winter']) {
                $winter = $_POST['winter'];
            }
            if ($_POST['spring']) {
                $spring = $_POST['spring'];
            }
            if ($_POST['summer']) {
                $summer = $_POST['summer'];
            }

            if (!$GLOBALS['datalayer']->checkToken($token)) {
                $success = $GLOBALS['datalayer']->saveSchedule($token, $fall, $winter, $spring, $summer);

                if($success == 1) {
                    echo '<h1> Success! </h1>';
                }
            } else {
                echo '<h1> Token arleady exists </h1>';
            }

        }



        $this->_f3->set('token', $token);
        $view = new Template();
        echo $view->render('views/new_schedule.html');
    }

}
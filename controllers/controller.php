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
            $token = random_bytes(3);
            $token = bin2hex($token);
            while ($GLOBALS['datalayer']->checkToken($token)) {
                $token = random_bytes(3);
                $token = bin2hex($token);
            }

            header('location: schedule/' . $token);

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
                    $this->_f3->set('queryStatus', "Successfully created!");
                } else {
                    $this->_f3->set('queryStatus', "Failed to create new schedule...");
                }
            } else {
                $success = $GLOBALS['datalayer']->updateSchedule($token, $fall, $winter, $spring, $summer);
                if($success == 1) {
                    $this->_f3->set('queryStatus', "Updated Successfully!");
                } else {
                    $this->_f3->set('queryStatus', "Update Failed...");
                }
            }

        }

        if ($GLOBALS['datalayer']->checkToken($token)) {
            $user = $GLOBALS['datalayer']->getSchedule($token);
            $this->_f3->set('user', $user);
        }



        $this->_f3->set('token', $token);
        $view = new Template();
        echo $view->render('views/new_schedule.html');
    }

}
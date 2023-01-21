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
            $token = "";
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($username && $password) {
                if ($username == "admin" && $password == '@dm1n') {
                    echo $username . " " . $password;
                    header("location: admin");
                } else {
                    $this->_f3->set('loginErr', "Username/Password incorrect");
                }
            } else {
                $token = random_bytes(3);
                $token = bin2hex($token);
                while ($GLOBALS['datalayer']->checkToken($token)) {
                    $token = random_bytes(3);
                    $token = bin2hex($token);
                }

                header('location: schedule/' . $token);

            }

        }

        $view = new Template();
        echo $view->render('views/home.html');
    }

    function admin() {
        $users = $GLOBALS['datalayer']->getAllSchedules();

        $this->_f3->set('users', $users);

        $view = new Template();
        echo $view->render('views/schedules.html');
    }

    function saveSchedule($token)
    {


        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $fall = "";
            $winter = "";
            $spring = "";
            $summer = "";
            $advisor = "";

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
            if ($_POST['advisor']) {
                $advisor = $_POST['advisor'];
            }


            if (!$GLOBALS['datalayer']->checkToken($token)) {
                $success = $GLOBALS['datalayer']->saveSchedule($token, $fall, $winter, $spring, $summer, $advisor);
                if($success == 1) {
                    $this->_f3->set('queryStatus', "Successfully created!");
                } else {
                    $this->_f3->set('queryStatus', "Failed to create new schedule...");
                }
            } else {
                $success = $GLOBALS['datalayer']->updateSchedule($token, $fall, $winter, $spring, $summer, $advisor);
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
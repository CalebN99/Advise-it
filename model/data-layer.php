<?php
/**
 * DataLayer class
 */
class DataLayer
{

    /**
     * @var PDO
     *
     */
    private $_dbh;

    // DataLayer constructor

    /**
     * Constructor for DataLayer
     * @return void
     */
    function __construct()
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
        $this->_dbh = $dbh;
        $this->_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    function saveSchedule($token, $fall, $winter, $spring, $summer) {

        $sql = "INSERT INTO schedules (token, fall, winter, spring, summer, updated) 
        VALUES (:token, :fall, :winter, :spring, :summer, :updated)";


        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('America/Los_Angeles'));
        $updated = $date->format('m-d-20y h:ia');
        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':token', $token, PDO::PARAM_STR);
        $statement->bindParam(':fall', $fall, PDO::PARAM_STR);
        $statement->bindParam(':winter', $winter, PDO::PARAM_STR);
        $statement->bindParam(':spring', $spring, PDO::PARAM_STR);
        $statement->bindParam(':summer', $summer, PDO::PARAM_STR);
        $statement->bindParam(':updated', $updated, PDO::PARAM_STR);


        return $statement->execute();
    }

    function updateSchedule($token, $fall, $winter, $spring, $summer) {

        $sql = "UPDATE schedules SET fall = :fall, winter = :winter, spring = :spring, summer = :summer, updated = :updated WHERE token = :token";

        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('America/Los_Angeles'));
        $updated = $date->format('m-d-20y h:ia');
        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':token', $token, PDO::PARAM_STR);
        $statement->bindParam(':fall', $fall, PDO::PARAM_STR);
        $statement->bindParam(':winter', $winter, PDO::PARAM_STR);
        $statement->bindParam(':spring', $spring, PDO::PARAM_STR);
        $statement->bindParam(':summer', $summer, PDO::PARAM_STR);
        $statement->bindParam(':updated', $updated, PDO::PARAM_STR);

        return $statement->execute();
    }

    function checkToken($token) {

        $sql = "SELECT * FROM schedules WHERE token = :token LIMIT 1";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':token', $token, PDO::PARAM_STR);

        $statement->execute();

        $user = $statement->fetch();

        if ($user) {
            return true;
        } else {
            return false;
        }


    }

    function getSchedule($token) {
        $sql = "SELECT * FROM schedules WHERE token = :token LIMIT 1";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':token', $token, PDO::PARAM_STR);

        $statement->execute();

        $user = $statement->fetch();

        if ($user) {
            return $user;
        } else {
            return false;
        }
    }



    /**
     * Method uses PDO to insert into userAccounts database table
     * @return void
     */
    function createAccount()
    {

        $sql = "INSERT INTO userAccounts (fname, lname, email, password, street, address2, city, zip, state, cardNum, cardExpMonth, cardExpYear, cvv) 
        VALUES (:fname, :lname, :email, :password, :street, :address2, :city, :zip, :state, :cardNum, :cardExpMonth, :cardExpYear, :cvv)";

        $statement = $this->_dbh->prepare($sql);


        $statement->bindParam(':fname', $_SESSION['fname'], PDO::PARAM_STR);
        $statement->bindParam(':lname', $_SESSION['lname'], PDO::PARAM_STR);
        $statement->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);
        $statement->bindParam(':password', $_SESSION['password'], PDO::PARAM_STR);
        $statement->bindParam(':street', $_SESSION['street'], PDO::PARAM_STR);
        $statement->bindParam(':address2', $_SESSION['address2'], PDO::PARAM_STR);
        $statement->bindParam(':city', $_SESSION['city'], PDO::PARAM_STR);
        $statement->bindParam(':zip', $_SESSION['zip'], PDO::PARAM_INT);
        $statement->bindParam(':state', $_SESSION['state'], PDO::PARAM_STR);
        $statement->bindParam(':cardNum', $_SESSION['cardNum'], PDO::PARAM_STR);
        $statement->bindParam(':cardExpMonth', $_SESSION['expMonth'], PDO::PARAM_INT);
        $statement->bindParam(':cardExpYear', $_SESSION['expYear'], PDO::PARAM_STR);
        $statement->bindParam(':cvv', $_SESSION['cvv'], PDO::PARAM_STR);

        $statement->execute();
    }
}

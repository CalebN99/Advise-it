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

    function saveSchedule($token, $fall, $winter, $spring, $summer, $advisor) {

        $sql = "INSERT INTO schedules (token, fall, winter, spring, summer, updated, advisor) 
        VALUES (:token, :fall, :winter, :spring, :summer, :updated, :advisor)";


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
        $statement->bindParam(':advisor', $advisor, PDO::PARAM_STR);


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

    function getAllSchedules() {
        $sql = "SELECT * FROM schedules";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($users) {
            return $users;
        } else {
            return false;
        }
    }



}

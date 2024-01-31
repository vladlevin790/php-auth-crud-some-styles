<?php

namespace src\classes;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("Database.php");

class GetUserInfo extends Database
{

    public function __construct()
    {
        parent::__construct("localhost:3308", "root", "", "AutorizationTest");
    }

    function getUserInfo()
    {
        try {
            if (empty($_SESSION['user_id'])) {
                throw new Exception('');
            }

            $userId = $_SESSION['user_id'];
            $query = "SELECT name, birth_day FROM users WHERE id = ?";
            $statement = $this->mysqli->prepare($query);
            $statement->bind_param("i", $userId);
            $statement->execute();
            $result = $statement->get_result();

            if ($result->num_rows === 1) {
                return $result->fetch_assoc();
            }
            return null;
        } catch (Exception $e) {
            echo "";
        }
    }
}

?>
<?php

namespace src\classes;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("Database.php");

class Autorization extends Database
{
    public $login;
    public $password;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
        parent::__construct("localhost:3308", "root", "", "AutorizationTest");
    }

    public function loginUser()
    {
        $query = "SELECT id, password FROM users WHERE login = ?";
        $statement = $this->mysqli->prepare($query);
        $statement->bind_param("s", $this->login);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($this->password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                return true;
            }
        }
        return false;
    }
}

?>
<?php

namespace src\classes;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("Database.php");

class Registration extends Database
{
    private $name;
    private $login;
    private $password;
    private $birth_day;

    public function __construct(string $name, string $login, string $password, $birth_day)
    {
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
        $this->birth_day = $birth_day;
        parent::__construct("localhost:3308", "root", "", "AutorizationTest");
    }

    public function registerUser()
    {
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (name, login, password, birth_day) VALUES (?, ?, ?, ?)";
        $statement = $this->mysqli->prepare($query);

        if ($statement) {
            $statement->bind_param("ssss", $this->name, $this->login, $hashedPassword, $this->birth_day);
            if ($statement->execute()) {
                return true;
            }
        }
        return false;
    }
}

?>
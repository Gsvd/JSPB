<?php


class Database
{

    private $dsn;
    private $user;
    private $password;

    public function __construct()
    {
        $this->user = "root";
        $this->password = "root";
        $this->dsn = "mysql:dbname=JSPB;host=127.0.0.1;charset=UTF8";
    }

    public function connect() {
        try {
            return new PDO($this->dsn, $this->user, $this->password);
        } catch (PDOException $e) {
            return null;
        }
    }

}

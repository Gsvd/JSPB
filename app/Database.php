<?php


class Database
{

    private $dsn;
    private $user;
    private $password;

    public function __construct()
    {
        $this->user = "Velkow";
        $this->password = "phBsMZbq6aBfyHDuHqb8tY4VEB4xjXXh";
        $this->dsn = "mysql:dbname=jspb;host=dbinstance.cwbjsngo15qh.eu-west-3.rds.amazonaws.com;charset=UTF8";
    }

    public function connect() {
        try {
            return new PDO($this->dsn, $this->user, $this->password);
        } catch (PDOException $e) {
            return null;
        }
    }

}

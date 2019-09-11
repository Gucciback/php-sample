<?php

namespace some;


class Mysql extends \PDO
{
    public function __construct($db, $engine = 'mysql', $host = 'localhost', $user = 'root', $pswd = '')
    {
        parent::__construct($engine.':dbname='.$db.";host=".$host, $user, $pswd);
    }
}
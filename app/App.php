<?php

namespace App;

class App
{
    private static DB $db;

    public function __construct(private Session $session)
    {
        $this->session->start();

        static::$db = new DB();
    }

    public static function getDb(): DB
    {
        return static::$db;
    }
}
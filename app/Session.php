<?php

namespace App;

class Session
{

    public function isActive(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }


    public function start(): bool
    {
        if ($this->isActive()){
            throw new \Exception('A session already started');
        }

        return session_start();
    }

    public function set(string $key, mixed $value = null): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function regenerate(): bool
    {
        return session_regenerate_id();
    }

    public function forget(array|string $keys): void
    {
        unset($_SESSION[$keys]);
    }




}
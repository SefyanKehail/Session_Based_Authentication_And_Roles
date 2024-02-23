<?php

namespace App\Services;

use App\App;
use App\DB;

class UserService
{
    private DB $db;

    public function __construct()
    {
        $this->db = App::getDb();
    }

    public function add(array $user): array
    {
        $query = "INSERT INTO users VALUES (NULL, :email, :password, :role)";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':email', $user['email']);
        $stmt->bindValue(':password', $user['password']);
        $stmt->bindValue(':role', $user['role']);

        $stmt->execute();
        return $user;
    }

    public function getById(int $id): ?array
    {
        $query = "SELECT * FROM users WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $id);

        $stmt->execute();

        return $stmt->fetchAll()[0] ?? null;
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM users WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $id);

        $stmt->execute();
    }

    public function getUsers(array $loggedUser): array
    {
        $role = $loggedUser['role'];

        if (in_array($role, ['admin', 'author', 'editor'])) {
            $query = "SELECT * FROM users";
            $stmt  = $this->db->query($query);
            return $stmt->fetchAll();
        } else {
            return [$this->getById((int) $loggedUser['id'])];
        }

    }

    public function update(array $user): array
    {
        $query = "UPDATE users SET email = :email, password = :password, role = :role WHERE id = :id" ;

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $user['id']);
        $stmt->bindValue(':email', $user['email']);
        $stmt->bindValue(':password', $user['password']);
        $stmt->bindValue(':role', $user['role']);

        $stmt->execute();

        return $user;
    }

    public function getByCredentials(array $credentials): ?array
    {
        $query = "SELECT * FROM users WHERE email = :email";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':email', $credentials['email']);

        $stmt->execute();

        return $stmt->fetchAll()[0] ?? null;
    }

    public function canEdit(array $loggedUser, array $userToEdit): bool
    {
        if ($loggedUser['role'] === 'admin'){
            return true;
        } elseif ($this->getById($loggedUser['id']) === $this->getById($userToEdit['id'])) {
            return true;
        }

        return false;
    }

    public function canDelete(array $loggedUser, array $userToDelete): bool
    {
        if ($loggedUser['role'] === 'admin'){
            return true;
        } elseif ($this->getById($loggedUser['id']) === $this->getById($userToDelete['id'])) {
            return true;
        }

        return false;
    }
}
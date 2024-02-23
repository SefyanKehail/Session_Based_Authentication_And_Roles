<?php

namespace App;

use App\Services\UserService;

class Auth
{
    private ?array $user = null;

    public function __construct(private Session $session, private UserService $userService)
    {
    }

    // set/get user to be available
    public function user(): ?array
    {
        if ($this->user !== null){
            return $this->user;
        }

        $userId = $this->session->get('userId');

        if (! $userId){
            return null;
        }

        return $this->userService->getById((int) $userId);
    }

    public function login(array $credentials): array
    {
        // get the user by credentials
        $user = $this->userService->getByCredentials($credentials);

        // if everything is alright save the user in the auth
        if (!$user || ! $this->checkCredentials($credentials, $user)){
            throw new \Exception("Wrong credentials");
        }

        // make the user available as an array
        $this->user = $user;

        // regenerate
        $this->session->regenerate();

        // set in the new session
        $this->session->set('userId', $user['id']);

        return $user;
    }


    public function logout(): void
    {
        $this->session->forget('user');

        $this->user = null;

        session_destroy();
    }


    public function checkCredentials(array $credentials, array $user): bool
    {
        return password_verify($credentials['password'], $user['password']);
    }
}
<?php

/*
 * this is the file that bootstraps my app, im redirecting all traffic here while using a query param action
 * the action query param contains route names
 * App class starts the session and provides the PDO class as a static property
 * Auth contains authentication related methods which is session based
 * Session is a wrapper around the $_SESSION super global
 * View is a primitive templating engine that allows me to pass views to this file along with custom params
*/


// auto loading

use App\App;
use App\Auth;
use App\Services\HashService;
use App\Services\UserService;
use App\Session;
use App\View;

define('VIEWS_PATH', __DIR__ . '/views/');


spl_autoload_register(function ($class) {
    $path = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($path)) {
        require $path;
    }
}
);


// Session
$session = new Session();

// start the app
$app = new App($session);

// services
$userService = new UserService();
$hashService = new HashService();

// Authentication
$auth = new Auth($session, $userService);

// query param that used for routing, each route has a specific action
$action = $_GET['action'] ?? '';


// check if the user requested a login or register
if ($action === 'login') {

    // If the user is already authenticated, show the index page
    if ($user = $auth->user()) {
        $users = $userService->getUsers($user);

        return (new View())->render('index.php', [
            'user'  => $user,
            'users' => $users

        ]);
    }

    // If not authenticated, attempt login with provided credentials
    $credentials = [
        'email'    => $_POST['email'],
        'password' => $_POST['password']
    ];

    try {
        $user = $auth->login($credentials);
    } catch (\Exception $exception) {
        echo "<h3 style='color: red'>Invalid credentials</h3>";
        return (new View())->render('loginOrRegister.php', []);
    }

    $users = $userService->getUsers($user);


    // Show the index page after successful login
    return (new View())->render('index.php', [
        'user'  => $user,
        'users' => $users

    ]);
} elseif ($action === 'register') {

    // If the user is already authenticated, show the index page
    if ($user = $auth->user()) {
        $users = $userService->getUsers($user);

        return (new View())->render('index.php', [
            'user'  => $user,
            'users' => $users
        ]);
    }

    // If not authenticated, attempt user registration
    $user = [
        'email'    => $_POST['email'],
        'password' => $hashService->passwordHash($_POST['password']),
        'role'     => $_POST['role']
    ];

    try {
        $user = $userService->add($user);
    } catch (PDOException $exception) {
        echo "<h3 style='color: red'>User with this email already exists</h3>";
    }

    // regenerate
    $session->regenerate();

    $user = $userService->getByCredentials($user);

    // set in the new session
    $session->set('userId', $user['id']);

    $users = $userService->getUsers($user);

    // Show the index page after successful registration
    return (new View())->render('index.php', [
        'user'  => $user,
        'users' => $users
    ]);

}


// then check if the user is not authenticated/ is already authenticated
if (! $user = $auth->user()) {
    $action = 'notAuthenticated';
}


if ($action === 'getEdit') {
    // Handle the case where the user wants to edit a profile
    $userId     = (int)$_GET['id'] ?? null;
    $userToEdit = $userService->getById($userId);
    $loggedUser = $auth->user();

    // Check if the logged-in user has the permission to edit the specified user
    if ($userToEdit !== null && ! $userService->canEdit($loggedUser, $userToEdit)) {
        header("Location: /index.php?flag=unauthorized");
        exit();
    }

    // Throw an exception if the user ID is not provided or if the logged user is not found
    if (! $userId || ! $userToEdit) {
        echo "<h3 style='color: red'>User was not found</h3>";
        return (new View())->render("error.php", ['loggedUser' => $loggedUser]);
    }

    // Render the edit.php view with user details
    return (new View())->render('edit.php', [
        'userToEdit' => $userToEdit,
        'loggedUser' => $loggedUser
    ]);
} elseif ($action === 'saveEdit') {

    // Handle the case where the user wants to save the edited profile
    $user = [
        'email'    => $_POST['email'],
        'password' => $hashService->passwordHash($_POST['password']),
        'role'     => $_POST['role'],
        'id'       => $_POST['userId']
    ];

    try {
        $user = $userService->update($user);
    } catch (PDOException $exception) {
        echo "<h3 style='color: red'>User with this email already exists</h3>";
    }

    // Get the authenticated user and render the index.php view

    $user = $auth->user();

    $users = $userService->getUsers($user);

    return (new View())->render('index.php', [
        'user'  => $user,
        'users' => $users

    ]);


} elseif ($action === 'delete') {

    // Handle the case where the user wants to delete a profile
    $userId     = (int)$_GET['id'] ?? null;
    $userToDelete = $userService->getById($userId);
    $loggedUser = $auth->user();

    // Check if the logged-in user has the permission to delete the specified user
    if ($userToDelete !== null && ! $userService->canDelete($loggedUser, $userToDelete)) {
        header("Location: /index.php?flag=unauthorized");
        exit();
    }

    // Throw an exception if the user ID is not provided or if the logged user is not found
    if (! $userId || ! $userToDelete) {
        echo "<h3 style='color: red'>User was not found</h3>";
        return (new View())->render("error.php", ['loggedUser' => $loggedUser]);
    }

    $userService->delete($userId);

    // logout if they delete their account

    if ((int) $loggedUser['id'] === $userId){
        $auth->logout();

        return (new View())->render('loginOrRegister.php', []);
    }


    $users = $userService->getUsers($user);

    return (new View())->render('index.php', [
        'user'  => $user,
        'users' => $users

    ]);
} elseif ($action === 'logout') {
    // Handle the case where the user wants to log out


    $auth->logout();
    return (new View())->render('loginOrRegister.php', []);


} elseif ($action === 'notAuthenticated') {
    // Check if authenticated for an action, if not redirect to login page

    return (new View())->render('loginOrRegister.php', []);


} elseif ($action === '') {
    // Handle the case of unauthorized access along with default action

    $users = $userService->getUsers($user);

    if (isset($_GET['flag']) && $_GET['flag'] === 'unauthorized') {
        echo "<h3 style='color: red'>User is not authorized to perform this action</h3>";
    }
        return (new View())->render('index.php', [
            'user'  => $user,
            'users' => $users
        ]);

} else {
    // Redirect to default
    header("Location: /index.php");
    exit();
}



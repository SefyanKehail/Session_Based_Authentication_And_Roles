<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Manager - Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
<span class="navbar-brand">
    <a href="/index.php" class="text-decoration-none text-reset">
        <i class="bi bi-gear-fill"></i>
        Go back home
    </a>
</span>

        <div class="dropdown">
            <span class="navbar-text dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                <i class="bi bi-person-fill"></i> <?= $loggedUser['email'] . ' (' . $loggedUser['role'] . ')' ?>
            </span>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="index.php?action=logout">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="alert alert-danger" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-circle-fill" style="font-size: 2rem; margin-right: 10px;"></i>
            <div>
                <h4 class="alert-heading">Oops! Something went wrong.</h4>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>

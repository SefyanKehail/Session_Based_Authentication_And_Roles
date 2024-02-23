<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Manager - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">
            <a href="/index.php" class="text-decoration-none text-reset">
        <i class="bi bi-gear-fill"></i>
        User Manager
    </a>
</span>

        <div class="dropdown">
            <span class="navbar-text dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                <i class="bi bi-person-fill"></i> <?= $user['email'] . ' (' . $user['role'] . ')' ?>
            </span>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="/index.php?action=logout">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <table class="table table-stripped table-bordered align-middle">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>MAIL</th>
            <th>PASSWORD</th>
            <th>ROLE</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (! $users): ?>
            <tr>
                <td>Couldn't fetch users</td>
            </tr>
        <?php
        endif; ?>
        <?php
        foreach ($users as $user): ?>
            <?php
            if (true) : ?>
                <tr>
                    <td class="text-center">
                        <?= $user['id'] ?>
                    </td>
                    <td>
                        <?= $user['email'] ?>
                    </td>
                    <td>
                        <?= $user['password'] ?>
                    </td>
                    <td>
                        <?= $user['role'] ?>
                    </td>
                    <td class="text-center">
                        <a href="/index.php?action=delete&id=<?= $user['id'] ?>"
                           class="btn btn-outline-danger text-center"><i class="bi bi-trash"></i></a>
                    </td>
                    <td class="text-center">
                        <a href="/index.php?action=getEdit&id=<?= $user['id'] ?>"
                           class="btn btn-outline-primary text-center"><i class="bi bi-pencil"></i></a>
                    </td>
                </tr>
            <?php
            endif ?>
        <?php
        endforeach ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
    function valider(evt)
    {
        evt.preventDefault();
        if (confirm('Etes-cous sûr de .....')) {
            location.href = evt.target.href
        }

    }
</script>
</body>
</html>

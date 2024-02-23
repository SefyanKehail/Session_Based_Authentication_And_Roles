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
    <h2>Edit User</h2>
    <form action="/index.php?action=saveEdit" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email"
                   value="<?= htmlspecialchars($userToEdit['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Enter a new password"
                   required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="" selected disabled>Select a role</option>
                <?php if ($loggedUser['role'] === 'guest'): ?>
                    <option value="admin" disabled>Admin</option>
                    <option value="author" disabled>Author</option>
                    <option value="editor" disabled>Editor</option>
                    <option value="guest" selected>Guest</option>
                <?php elseif ($loggedUser['role'] === 'admin'): ?>
                    <option value="admin" <?= $userToEdit['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="author" <?= $userToEdit['role'] === 'author' ? 'selected' : '' ?>>Author</option>
                    <option value="editor" <?= $userToEdit['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
                    <option value="guest" <?= $userToEdit['role'] === 'guest' ? 'selected' : '' ?>>Guest</option>
                <?php else: ?>
                    <option value="admin" disabled>Admin</option>
                    <option value="author" <?= $userToEdit['role'] === 'author' ? 'selected' : '' ?>>Author</option>
                    <option value="editor" <?= $userToEdit['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
                    <option value="guest" <?= $userToEdit['role'] === 'guest' ? 'selected' : '' ?>>Guest</option>
                <?php endif; ?>
            </select>
        </div>
        <input type="hidden" name="userId" value="<?= $userToEdit['id'] ?>">
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="/index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>

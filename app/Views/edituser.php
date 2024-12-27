<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Operations</a></li>
            <li class="breadcrumb-item"><a href="/users">Users</a></li>
            <li class="breadcrumb-item"><a href="#">Edit</a></li>
        </ol>
    </nav>
    <div>
    <h3>Edit User</h3>
    <form action="/updateuser/<?= $user['user_id'] ?>" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control-sm" name="username" value="<?= $user['username'] ?>" placeholder="Enter Username">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control-sm" name="email" value="<?= $user['email'] ?>" placeholder="Enter Email">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select-sm" name="role">
                <option selected>Select Access Level</option>
                <?php foreach($accesslevels as $accesslevel) { ?>
                <option value="<?= $accesslevel['access_id'] ?>"> <?= $accesslevel['access_level'] ?> </option>
                <?php } ?>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Edit User</button>
    </form>
    </div>
</body>
</html>
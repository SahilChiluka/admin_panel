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
            <li class="breadcrumb-item"><a href="<?= base_url('Home/userpage') ?>">Users</a></li>
            <li class="breadcrumb-item"><a href="#">+</a></li>
        </ol>
    </nav>
    <div>
    <h3>Create User</h3>
    <form action="<?= base_url('Home/adduser') ?>" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control-sm" name="username" placeholder="Enter Username">
            <p><?= session()->getFlashData('username') ?></p>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control-sm" name="email" placeholder="Enter Email">
            <p><?= session()->getFlashData('email') ?></p>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control-sm" name="password" placeholder="Enter Password">
        </div>
        <div class="mb-3">  
            <label for="confirmpassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control-sm" name="confirmpassword" placeholder="Enter Password Again">
            <p><?= session()->getFlashData('password') ?></p>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select-sm" name="role" required>
                <option selected>Select Access Level</option>
                <?php foreach($accesslevels as $accesslevel) { ?>
                <option value="<?= $accesslevel['access_id'] ?>"> <?= $accesslevel['access_level'] ?> </option>
                <?php } ?>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Add User</button>
    </form>
    </div>
</body>
</html>
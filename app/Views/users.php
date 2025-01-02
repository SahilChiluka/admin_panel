<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>
<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Operations</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('Home/userpage') ?>">Users</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('Home/createuserpage'); ?>">+</a></li>
        </ol>
    </nav>
    <div class="container mt-5">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
        Filter
    </button>
        <h4>Users List</h4>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user) { ?>
                    <tr>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>  
                        <td><?php echo $accessname[$user['role']-1]['access_level']?></td>
                        <td>
                            <a href="<?= base_url('Home/editpage/').$user['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="#" delete_id="<?php echo $user['user_id']; ?>" class="deleteUser btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
        <?= $pager->links() ?>
        </div>
    </div>

    
<!-- Filter -->

<!-- // bs 5 modal  -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Filter</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
            <form action="<?= base_url('Home/userpage') ?>">
                <input type="search" name="searchName" placeholder="Search By Name">
                <br>
                <br>
                <input type="search" name="searchEmail" placeholder="Search By Email">
                <br>
                <br>
                <select name="filterRole">
                    <option value="">Select Role</option>
                    <?php foreach($filteraccess as $filters) { ?>
                    <option value="<?= $filters['access_id'] ?>"><?= $filters['access_level'] ?></option>
                    <?php } ?>
                </select>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
      </form>
    </div>
    </div>
  </div>
</div>

<script>
    const deleteButtons = document.querySelectorAll('.deleteUser');
    deleteButtons.forEach(delbutton => {
        delbutton.addEventListener('click', function() {
            const delete_id = delbutton.getAttribute('delete_id');
            console.log(delete_id);
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = `<?= base_url('Home/delete/').$user['user_id']; ?>`; 
            }
        });
    });

    // $(document).ready(function() {
    //     $('.js-example-basic-single').select2();
    // });

</script>


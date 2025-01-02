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
            <li class="breadcrumb-item"><a href="<?= base_url('Campaign/index') ?>">Campaign</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('Campaign/createcampaign') ?>">+</a></li>
        </ol>
    </nav>
    <div class="container mt-5">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
        Filter
    </button>
        <h4>Campaign List</h4>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Campaign Name</th>
                    <th>Description</th>
                    <th>Client</th>
                    <th>Supervisor Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($campaigns as $campaign) { ?>
                    <tr>
                        <td><?php echo ($campaign['campaign_name']); ?></td>
                        <td><?php echo ($campaign['description']); ?></td>
                        <td><?php echo ($campaign['client']); ?></td>
                        <td><?php echo ($campaign['supervisor']); ?></td>
                        <td>
                            <a href="/geteditcampaign/<?php echo $campaign['camp_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="#" delete_id="<?php echo $campaign['camp_id']; ?>" class="deleteCampaign btn btn-danger btn-sm">Delete</a>
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
      <form action="<?= base_url('Campaign/index') ?>">
        <input type="search" name="searchCampaignName" placeholder="Search By Campaign Name" size="50" value="<?php isset($campaign['campaign_name']) ?>">
        <br>
        <br>
        <input type="search" name="searchClient" placeholder="Search By Client">
        <br>
        <br>
        <select name="filterSupervisor">
            <option value="">Select Supervisor</option>
            <?php foreach($filteraccess as $filters) { ?>
            <option value="<?= $filters['username'] ?>"><?= $filters['username'] ?></option>
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
    const deleteButtons = document.querySelectorAll('.deleteCampaign');
    deleteButtons.forEach(delbutton => {
        delbutton.addEventListener('click', function() {
            const delete_id = delbutton.getAttribute('delete_id');
            console.log(delete_id);
            if (confirm('Are you sure you want to delete this campaign?')) {
                window.location.href = `/deletecampaign/${delete_id}`; 
            }
        });
    });
</script>
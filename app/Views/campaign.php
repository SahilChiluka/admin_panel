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
            <li class="breadcrumb-item"><a href="/campaign">Campaign</a></li>
            <li class="breadcrumb-item"><a href="/createcampaignpage">+</a></li>
        </ol>
    </nav>
    <div class="container mt-5">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="/campaign">
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
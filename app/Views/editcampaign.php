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
            <li class="breadcrumb-item"><a href="#">Edit</a></li>
        </ol>
    </nav>
    <div>
    <h3>Edit Campaign</h3>
    <form action="<?= base_url('Campaign/editcampaign/').$supervisors['camp_id'] ?>" method="post">
    <div class="mb-3">
            <label for="campaignname" class="form-label">Campaign Name</label>
            <input type="text" class="form-control-sm" name="campaignname" value="<?= $supervisors['campaign_name']?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control-sm" name="description" value="<?= $supervisors['description']?>">
        </div>
        <div class="mb-3">
            <label for="client" class="form-label">Client</label>
            <input type="text" class="form-control-sm" name="client" value="<?= $supervisors['client']?>">
        </div>
        <div class="mb-3">
            <label for="supervisor" class="form-label">Supervisor</label>
            <select class="form-select-sm" name="supervisor">
                <option selected>Select Supervisor</option>
                <?php foreach ($campaigns as $campaign) { ?>
                <option value="<?= $campaign['username'] ?>"><?= $campaign['username'] ?></option>
            <?php } ?>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Edit Campaign</button>
    </form>
    </div>
</body>
</html>


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
            <li class="breadcrumb-item"><a href="#">Create</a></li>
        </ol>
    </nav>
    <div>
    <h3>Create Campaign</h3>
    <form action="/addcampaign" method="post">
    <div class="mb-3">
            <label for="campaignname" class="form-label">Campaign Name</label>
            <input type="text" class="form-control-sm" name="campaignname">
            <p style="color: red;"><?= session()->getFlashData('error') ?></p>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control-sm" name="description">
        </div>
        <div class="mb-3">
            <label for="client" class="form-label">Client</label>
            <input type="text" class="form-control-sm" name="client">
        </div>
        <div class="mb-3">
            <label for="supervisor" class="form-label">Supervisor</label>
            <select class="form-select-sm" name="supervisor">
                <option selected>Select Supervisor</option>
                <?php foreach ($supervisors as $supervisor) { ?>
                <option value="<?= $supervisor['username'] ?>"><?= $supervisor['username'] ?></option>
            <?php } ?>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Create Campaign</button>
    </form>
    </div>
</body>
</html>
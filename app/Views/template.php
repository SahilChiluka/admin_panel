<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php echo view('hf/header') ?>
    <?php echo view($page, $data) ?>
    <?php echo view('hf/footer') ?>
</body>
</html>
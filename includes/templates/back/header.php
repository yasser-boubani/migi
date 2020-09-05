<!DOCTYPE html>
<html dir="<?= $_dir ?>" lang="<?= $_lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?></title>
    <?php
    foreach($header_resources as $resource) {
        echo $resource . PHP_EOL;
    }
    ?>
</head>
<body>
    <!-- ############### -->
    <!-- Start Work Area -->

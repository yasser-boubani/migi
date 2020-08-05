<?php

$_lang = (isset($_COOKIE["lang"])) ? $_COOKIE["lang"] : DEF_LANG;
$_dir = ($_lang == "ar") ? "rtl" : "ltr";
$_title = trans("HOME");

$header_resources = [
    '<!-- Main Style -->',
    '<link rel="stylesheet" href="' . FRONT_CSS . 'style.css">',
];

$footer_resources = [
    '<!-- Main Scripts -->',
    '<script>console.log("Hello, Migi!")</script>',
];

include _TEMPLATES_ . "header.php";
?>

<div class="container">
    <div class="intro">
        <h1><?= trans("HOME") ?></h1>
        <?php Workers\Helper::inc_comp("mrq.demo", ["behavior" => "scroll", "direction" => "left"]) ?>
    </div>
</div>

<?php include _TEMPLATES_ . "footer.php"; ?>

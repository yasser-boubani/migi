<?php
$behavior = "scroll";
$direction = null;

if (isset($data["behavior"])) {
    $behavior = $data["behavior"];
}

if (isset($data["direction"])) {
    $direction = $data["direction"];
}
?>
<marquee behavior="<?= $behavior ?>" direction="<?= $direction ?>"><?= trans("WELCOME") ?></marquee>

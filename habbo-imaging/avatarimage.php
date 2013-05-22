<?php

$get = $_GET;

header('Content-Type: image/png');
exit(file_get_contents("http://www.habbo.it/habbo-imaging/avatarimage?figure=" . $get['figure'] . "&size=" . $get['size'] . "&direction=" . $get['direction'] . "&head_direction=" . $get['head_direction'] . "&gesture=" . $get['gesture'] . "&action=" . $get['action'] . ""));
?>

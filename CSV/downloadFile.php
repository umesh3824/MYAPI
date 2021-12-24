<?php

$url = $_GET['file'];
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename=download.csv');
header('Pragma: no-cache');
readfile($url);
?>

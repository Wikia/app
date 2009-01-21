<?php
/* Simple JSON interface to the super deduper for type-ahead completion */
header('Content-Type: text/plain');
require '/usr/wikia/source//answers/SuperDeduper.php';
$SuperDeduper = new SuperDeduper();
echo json_encode($SuperDeduper->getRankedmatches(@$_GET['q']));
?>

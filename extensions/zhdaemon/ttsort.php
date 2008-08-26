<?php
/* sort a dictionary file in an order that ensure a 
   balanced trie when inserted in that order*/
$buf = file_get_contents('php://stdin');

$lines = explode("\n", $buf);
sort($lines, SORT_STRING);
$c = sizeof($lines);

printlines($lines, 0, $c-1);

function printlines($lines, $start, $end) {
	$mid = ($start + $end) / 2;
	print $lines[$mid]; print "\n";
	if($start<$mid)
		printlines($lines, $start, $mid-1);
	if($end>$mid)
		printlines($lines, $mid+1, $end);
}

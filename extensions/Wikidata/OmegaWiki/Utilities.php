<?php

require_once("Wikidata.php");

function implodeFixed($values, $separator = ", ", $prefix = '"', $suffix = '"') {
	$result = $prefix . $values[0] . $suffix;
	
	for ($i = 1; $i < count($values); $i++)
		$result .= $separator . $prefix . $values[$i] . $suffix;
		
	return $result;
}


/**
 * @deprecated, use normal wfMsg stuff instead
 */
function wfMsgSc($message) {
	$args=func_get_args();
	array_shift($args);
	# this is now hardcoded. We can next refactor out wfMsgSc everywhere.
	return wfMsgReal("ow_${message}", $args, true);
}


?>

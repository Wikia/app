<?php

function sarray($key,$value=null) {
	static $foo=array();
	if (is_null($value)) 
		return $foo[$key];
	$foo[$key]=$value;
	return $foo[$key];
}



sarray("bla","blie");
sarray("ready","aim");
sarray("fie","fie");
sarray("aim","fire");
sarray("ready","teddy"); // ready twice
print sarray("ready")." ".sarray("aim");

?>

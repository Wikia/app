<?php
if( php_sapi_name() != 'cli' ) {
	die("Not an entry point.");
}
require_once("ISO_639_1.php");
var_dump(get3to1());
var_dump(get1to3());

?>

<?php
/**
 *
 */
 
 
 
class ErrorPage {

	function showError($args){
	
ob_start();
		print "YAY! We were able to get to showError() with these args:";
		var_dump($args);

		
return ob_get_clean();
	
	
	} // end showError()


} // end class ErrorPage

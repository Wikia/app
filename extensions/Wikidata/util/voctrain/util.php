<?php


/** useful generic utility functions 
 * (will probably move some stuff from functions.php here, and tidy up in general)
 */
class Util {

	/** trim() all the strings in an array */
	public static function array_trim($array) {
		$trimmed=array();
		foreach ($array as $string) {
			$trimmed[]=trim($string);
		}
		return $trimmed;
	}

}

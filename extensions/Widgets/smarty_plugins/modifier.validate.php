<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.validate.php
 * Type:     modifier
 * Name:     validate
 * Purpose:  Validates parameter format ('url' by default).
 *           Useful when you need to validate but not escape.
 * -------------------------------------------------------------
 */
function smarty_modifier_validate($string, $type='url')
{
	// mapping for PHP filters (http://us2.php.net/manual/en/filter.constants.php)
	$filters = array(
		'url' => FILTER_VALIDATE_URL,
		'int' => FILTER_VALIDATE_INT,
		'boolean' => FILTER_VALIDATE_BOOLEAN,
		'float' => FILTER_VALIDATE_FLOAT,
		'email' => FILTER_VALIDATE_EMAIL,
		'ip' => FILTER_VALIDATE_IP
	);

	if (array_key_exists($type, $filters) && filter_var($string, $filters[$type]) !== FALSE)
	{
		return $string;
	}

	// unless it matched some validation rule, it's not valid
	return '';
}

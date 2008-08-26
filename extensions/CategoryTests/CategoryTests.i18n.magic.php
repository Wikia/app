<?php
/**
 * Magic word localization for the CategoryTests extension
*/

$words = array();

/** English
 * @author Ryan Schmidt
*/
$words['en'] = array(
	'ifcategory'     => array( 0, 'ifcategory' ),
	'ifnocategories' => array( 0, 'ifnocategories' ),
	'switchcategory' => array( 0, 'switchcategory' ),
	'default'        => array( 0, '#default' ),
	'page'           => array( 0, '#page' )
);

/**
 * Note for non-English translations
 * Unlike the English one above where the array has two values, all translations must have THREE values, like so:
 * 'ifcategory' => array( 0, 'translation_goes_here', 'ifcategory' )
 * The third value should be the same as the name of the key string you are translating for
*/
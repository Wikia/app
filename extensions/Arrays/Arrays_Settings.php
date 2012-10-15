<?php

/**
 * File defining the settings for the 'Arrays' extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Arrays#Configuration
 *
 * NOTICE:
 * =======
 * Changing one of these settings can be done by copying and placing
 * it in LocalSettings.php, AFTER the inclusion of 'Arrays'.
 *
 * @file Arrays_Settings.php
 * @ingroup Arrays
 * @since 2.0
 *
 * @author Daniel Werner
 */

/**
 * Set to false by default since version 2.0.
 *
 * @since 2.0 (as '$egArrayExtensionCompatbilityMode' in 1.4 alpha)
 *
 * @var boolean
 */
$egArraysCompatibilityMode = false;

/**
 * Contains a key-value pair list of characters that should be replaced by a template or parser function
 * call within array values included into an '#arrayprint'. By replacing these special characters before
 * including the values into the string which is being expanded afterwards, array values can't distract
 * the surounding MW code. Otherwise the array values themselves would be parsed as well.
 *
 * This has no effect in case $egArraysCompatibilityMode is set to false! If set to null, Arrays will
 * jump to compatbility mode behavior on this, independently from $egArraysCompatibilityMode.
 * 
 * @since 2.0
 *
 * @var array|null
 */
$egArraysExpansionEscapeTemplates = array(
	'='  => '{{=}}',
	'|'  => '{{!}}',
	'{{' => '{{((}}',
	'}}' => '{{))}}'
);
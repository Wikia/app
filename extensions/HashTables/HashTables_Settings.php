<?php

/**
 * File defining the settings for the 'HashTables' extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:HashTables#Configuration
 *
 * NOTICE:
 * =======
 * Changing one of these settings can be done by copying and placing
 * it in LocalSettings.php, AFTER the inclusion of 'HashTables'.
 *
 * @file HashTables_Settings.php
 * @ingroup HashTables
 * @since 1.0
 *
 * @author Daniel Werner
 */

/**
 * Contains a key-value pair list of characters that should be replaced by a template or parser function
 * call within hash values included into an '#hashprint'. By replacing these special characters before
 * including the values into the string which is being expanded afterwards, hash values can't distract
 * the surounding MW code. Otherwise the array values themselves would be parsed as well.
 *
 * If set to null, 'HashTables' will jump into some kind of compatibility mode where it switches back to
 * old behavior on this matter.
 * 
 * In case 'Arrays' extension is included, this should get the value of '$egArraysExpansionEscapeTemplates'
 * which is the equivalent within 'Arrays' extension.
 * 
 * @example $egHashTablesExpansionEscapeTemplates = $egArraysExpansionEscapeTemplates
 * 
 * @since 1.0
 *
 * @var array|null
 */
$egHashTablesExpansionEscapeTemplates = array(
	'='  => '{{=}}',
	'|'  => '{{!}}',
	'{{' => '{{((}}',
	'}}' => '{{))}}'
);

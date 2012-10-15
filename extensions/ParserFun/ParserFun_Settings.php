<?php

/**
 * File defining the settings for the 'Parser Fun' extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Parser_Fun#Configuration
 *
 * NOTICE:
 * =======
 * Changing one of these settings can be done by copying and placing
 * it in LocalSettings.php, AFTER the inclusion of 'Parser Fun'.
 *
 * @file ParserFun_Settings.php
 * @ingroup ParserFun
 * @since 0.1
 *
 * @author Daniel Werner
 */

/**
 * Allows to define which functionalities provided by 'Parser Fun' should be enabled within the wiki.
 * By default all functionality is enabled.
 * 
 * @example
 * # Only enable 'THIS' prefix functionality:
 * $egParserFunEnabledFunctions = array( 'this' );
 * # Only enable '#parse' parser function:
 * $egParserFunEnabledFunctions = array( 'parse' );
 * 
 * @since 0.1
 * @var array
 */
$egParserFunEnabledFunctions = array( 'this', 'parse', 'caller' );

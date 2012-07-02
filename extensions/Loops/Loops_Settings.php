<?php

/**
 * File defining the settings for the 'Loops' extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Loops#Configuration
 *
 * NOTICE:
 * =======
 * Changing one of these settings can be done by copying and placing
 * it in LocalSettings.php, AFTER the inclusion of 'Loops'.
 *
 * @file Loops_Settings.php
 * @ingroup Loops
 * @since 0.4
 *
 * @author Daniel Werner
 */

/**
 * Allows to define which functionalities provided by 'Loops' should be enabled for the wiki.
 * If extension 'Variables' is not installed, '#loop', '#forargs' and '#fornumargs' will be
 * disabled automatically.
 * 
 * @example
 * # enable '#while' and '#dowhile' parser functions only:
 * egLoopsEnabledFunctions = array( 'while', 'dowhile' );
 * 
 * @since 0.4
 * @var array
 */
$egLoopsEnabledFunctions = array( 'while', 'dowhile', 'loop', 'forargs', 'fornumargs' );

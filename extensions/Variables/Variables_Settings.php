<?php

/**
 * File defining the settings for the 'Variables' extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Variables#Configuration
 *
 * NOTICE:
 * =======
 * Changing one of these settings can be done by copying and placing
 * it in LocalSettings.php, AFTER the inclusion of 'Variables'.
 *
 * @file Variables_Settings.php
 * @ingroup Variables
 * @since 2.0
 *
 * @author Daniel Werner
 */

/**
 * Allows to define functions which should not be available within the wiki.
 * 
 * @example
 * # disable '#var_final' and '#vardefineecho' functions:
 * $egVariablesDisabledFunctions = array( 'var_final', 'vardefineecho' );
 * 
 * @since 2.0
 * @var array
 */
$egVariablesDisabledFunctions = array();

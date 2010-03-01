<?php

/**
 * Initialization file for the Validator extension.
 * Extension documentation: http://www.mediawiki.org/wiki/Extension:Validator
 *
 * You will be validated. Resistance is futile.
 *
 * @file Validator.php
 * @ingroup Validator
 *
 * @author Jeroen De Dauw
 */

/**
 * This documenation group collects source code files belonging to Validator.
 *
 * Please do not use this group name for other code.
 *
 * @defgroup Validator Validator
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'Validator_VERSION', '0.2.2 rc1' );

// Constants indicating the strictness of the parameter validation.
define( 'Validator_ERRORS_NONE', 0 );
define( 'Validator_ERRORS_MINIMAL', 1 );
define( 'Validator_ERRORS_WARN', 2 );
define( 'Validator_ERRORS_SHOW', 3 );
define( 'Validator_ERRORS_STRICT', 4 );

$egValidatorDir = dirname( __FILE__ ) . '/';

// Include the settings file.
require_once( $egValidatorDir . 'Validator_Settings.php' );

// Put the initalization function into the MW extension hook.
$wgExtensionFunctions[] = 'efValidatorSetup';

// Register the internationalization file.
$wgExtensionMessagesFiles['Validator'] = $egValidatorDir . 'Validator.i18n.php';

// Autoload the general classes
$wgAutoloadClasses['Validator'] 			= $egValidatorDir . 'Validator.class.php';
$wgAutoloadClasses['ValidatorFunctions'] 	= $egValidatorDir . 'Validator_Functions.php';
$wgAutoloadClasses['ValidatorFormats'] 		= $egValidatorDir . 'Validator_Formats.php';
$wgAutoloadClasses['ValidatorManager'] 		= $egValidatorDir . 'Validator_Manager.php';

/**
 * Initialization function for the Validator extension.
 */
function efValidatorSetup() {
	global $wgExtensionCredits;

	wfLoadExtensionMessages( 'Validator' );

	$wgExtensionCredits['other'][] = array(
		'path' => __FILE__,
		'name' => wfMsg( 'validator_name' ),
		'version' => Validator_VERSION,
		'author' => array( '[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]' ),
		'url' => 'http://www.mediawiki.org/wiki/Extension:Validator',
		'descriptionmsg' => 'validator-desc',
	);
}

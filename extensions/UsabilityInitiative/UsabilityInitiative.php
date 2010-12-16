<?php
/**
 * Usability Initiative extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the main include file for the UsabilityInitiative
 * extension of MediaWiki.
 *
 * Usage: Include the modules you want to use specifically by adding a line in
 * LocalSettings.php for each of them like this:
 * require_once( "$IP/extensions/UsabilityInitiative/Vector/Vector.php" );
 *
 * @author Trevor Parscal <tparscal@wikimedia.org>
 * Allow "or a later version" here?
 * @license GPL v2
 * @version 0.1.1
 */

/* Configuration */

// Set this to 'raw' to include all plugins individually
$wgUsabilityInitiativeResourceMode = 'minified';

/* Setup */

// Sets Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'UsabilityInitiative',
	'author' => 'Trevor Parscal',
	'version' => '0.1.1',
	'url' => 'http://www.mediawiki.org/wiki/Extension:UsabilityInitiative',
	'descriptionmsg' => 'usabilityinitiative-desc',
);

// Adds Autoload Classes
$wgAutoloadClasses['UsabilityInitiativeHooks'] =
	dirname( __FILE__ ) . "/UsabilityInitiative.hooks.php";

// Adds Internationalized Messages
$wgExtensionMessagesFiles['UsabilityInitiative'] =
	dirname( __FILE__ ) . "/UsabilityInitiative.i18n.php";

// Registers Hooks
$wgHooks['BeforePageDisplay'][] = 'UsabilityInitiativeHooks::addResources';
$wgHooks['MakeGlobalVariablesScript'][] = 'UsabilityInitiativeHooks::addJSVars';

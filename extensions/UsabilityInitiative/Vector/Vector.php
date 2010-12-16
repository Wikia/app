<?php
/**
 * Usability Initiative Vector extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the include file for the Vector portion of the UsabilityInitiative extension of MediaWiki.
 *
 * Usage: Include the following line in your LocalSettings.php
 * require_once( "$IP/extensions/UsabilityInitiative/Vector/Vector.php" );
 *
 * @author Trevor Parscal <trevor@wikimedia.org>, Roan Kattouw <roan.kattouw@gmail.com>,
 *         Nimish Gautam <nimish@wikimedia.org>, Adam Miller <amiller@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.2.0
 */

/* Configuration */

// Each module may be configured individually to be globally on/off or user preference based
$wgVectorModules = array(
	'collapsiblenav' => array( 'global' => true, 'user' => false ),
	'collapsibletabs' => array( 'global' => true, 'user' => false ),
	'editwarning' => array( 'global' => false, 'user' => true ),
	'footercleanup' => array( 'global' => false, 'user' => false ),
	'simplesearch' => array( 'global' => true, 'user' => false ),
);

/* Setup */

// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Vector',
	'author' => array( 'Trevor Parscal', 'Roan Kattouw', 'Nimish Gautam', 'Adam Miller' ),
	'version' => '0.2.0',
	'url' => 'http://www.mediawiki.org/wiki/Extension:UsabilityInitiative',
	'descriptionmsg' => 'vector-desc',
);

// Include parent extension
require_once( dirname( dirname( __FILE__ ) ) . "/UsabilityInitiative.php" );

// Add Autoload Classes
$wgAutoloadClasses['VectorHooks'] = dirname( __FILE__ ) . '/Vector.hooks.php';

// Add Internationalized Messages
$wgExtensionMessagesFiles['Vector'] = dirname( __FILE__ ) . '/Vector.i18n.php';
$wgExtensionMessagesFiles['VectorEditWarning'] = dirname( __FILE__ ) . '/Modules/EditWarning/EditWarning.i18n.php';
$wgExtensionMessagesFiles['VectorSimpleSearch'] = dirname( __FILE__ ) . '/Modules/SimpleSearch/SimpleSearch.i18n.php';

// Register Hooks
$wgHooks['UsabilityInitiativeLoadModules'][] = 'VectorHooks::addModules';
$wgHooks['GetPreferences'][] = 'VectorHooks::addPreferences';

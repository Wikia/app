<?php
/**
 * Add Media Wizard extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the include file for the Add Media Wizard support
 * The addMediaWizard is dependent on MwEmbedSupport extension
 *
 * @author Michael Dale <mdale@wikimedia.org> and others
 * @license GPL v2 or later
 * @version 0.1.1
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is the AddMediaWizard extension. Please see the README file for installation instructions.\n";
	exit( 1 );
}

if( !class_exists( 'MwEmbedResourceManager' ) ){
	echo "AddMediaWizard requires the MwEmbedSupport extension.\n";
	exit( 1 );
}

/* Configuration */

// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Add Media Wizard',
	'author' => array( 'Michael Dale' ),
	'version' => '0.2',
	'descriptionmsg' => 'addmediawizard-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Add_Media_Wizard'
);

$AMWdir = dirname(__FILE__) . '/';

$wgAutoloadClasses['AddMediaWizardHooks'] = "$AMWdir/AddMediaWizard.hooks.php";

$wgExtensionMessagesFiles['AddMediaWizard'] = $AMWdir . 'AddMediaWizard.i18n.php';

// Register all AddMediaWizard hooks: 
AddMediaWizardHooks::register();

// Register the MwEmbed AddMedia Module:
MwEmbedResourceManager::register( 'extensions/AddMediaWizard/MwEmbedModules/AddMedia' );

// Register the MwEmbed ClipEdit Module
MwEmbedResourceManager::register( 'extensions/AddMediaWizard/MwEmbedModules/ClipEdit' );

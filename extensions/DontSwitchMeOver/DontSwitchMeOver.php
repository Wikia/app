<?php
/**
 * "Don't switch me over" extension
 * 
 * @file
 * @ingroup Extensions
 * 
 * This allows users to indicate that they don't want to be affected by a default preference change.
 * 
 * @author Roan Kattouw <roan.kattouw@gmail.com>
 * @author Nimish Gautam <ngautam@wikimedia.org>
 * @author Trevor Parscal <tparscal@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.2.0
 */

/* Configuration */

// Preferences to switch back to. This has to be set because the old default skin isn't remembered after a switchover.
// You can also add more preferences here, and on wikis with PrefSwitch running, adding...
// 		$wgDontSwitchMeOverPrefs = $wgPrefSwitchPrefs['off'];
// to your LocalSettings.php file is probably wise.
$wgDontSwitchMeOverPrefs = array(
	'skin' => 'monobook'
);
// Set default preference value
$wgDefaultUserOptions['dontswitchmeover'] = 0;

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => "Don't Switch Me Over",
	'author' => array( 'Roan Kattouw', 'Nimish Gautam', 'Trevor Parscal' ),
	'version' => '0.2.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:UsabilityInitiative',
	'descriptionmsg' => 'dontswitchmeover-desc',
);
$wgAutoloadClasses['DontSwitchMeOverHooks'] = dirname( __FILE__ ) . '/DontSwitchMeOver.hooks.php';
$wgExtensionMessagesFiles['DontSwitchMeOver'] = dirname( __FILE__ ) . '/DontSwitchMeOver.i18n.php';
$wgHooks['GetPreferences'][] = 'DontSwitchMeOverHooks::getPreferences';

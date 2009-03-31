<?php
/**
 * Web interface for various maintenance scripts
 *
 * @file
 * @ingroup Extensions
 * @version 1.0.1
 * @author Ryan Schmidt
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:Maintenance Documentation
 */

if( !defined('MEDIAWIKI') ) {
	echo("This file is an extension to the MediaWiki software and is not a valid access point");
	die(1);
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Maintenance',
	'author' => 'Ryan Schmidt',
	'version' => '1.0.3',
	'description' => '[[Special:Maintenance|Web interface]] for various maintenance scripts',
	'descriptionmsg' => 'maintenance-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Maintenance',
);

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Maintenance'] = $dir . 'Maintenance.i18n.php';
$wgExtensionAliasesFiles['Maintenance'] = $dir . 'Maintenance.alias.php';
$wgAutoloadClasses['Maintenance'] = $dir . 'Maintenance_body.php';
$wgSpecialPages['Maintenance'] = 'Maintenance';
// Special page group for MW 1.13+
$wgSpecialPageGroups['Maintenance'] = 'wiki';

// New user right - required to access Special:Maintenance
$wgAvailableRights[] = 'maintenance';
<?php
/**
 * Web interface for various maintenance scripts
 *
 * @file
 * @ingroup Extensions
 * @version 2.0.0
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
	'path' => __FILE__,
	'name' => 'Maintenance',
	'author' => 'Ryan Schmidt',
	'version' => '2.0.0',
	'descriptionmsg' => 'maintenance-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Maintenance',
);

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Maintenance'] = $dir . 'Maintenance.i18n.php';
$wgExtensionMessagesFiles['MaintenanceAlias'] = $dir . 'Maintenance.alias.php';
$wgAutoloadClasses['SpecialMaintenance'] = $dir . 'Maintenance_body.php';
$wgSpecialPages['Maintenance'] = 'SpecialMaintenance';
// Special page group for MW 1.13+
$wgSpecialPageGroups['Maintenance'] = 'wiki';

// New user right - required to access Special:Maintenance
$wgAvailableRights[] = 'maintenance';

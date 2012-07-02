<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
/**
 * Allow users in the Bot group to edit many articles in one go by applying
 * regular expressions to a list of pages.
 *
 * @file
 * @ingroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:MassEditRegex Documentation
 *
 * @author Adam Nielsen <malvineous@shikadi.net>
 * @copyright Copyright © 2009 Adam Nielsen
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Mass Edit via Regular Expressions',
	'version' => 'r4',
	'author' => 'Adam Nielsen',
	'url' => 'https://www.mediawiki.org/wiki/Extension:MassEditRegex',
	'descriptionmsg' => 'masseditregex-desc'
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['MassEditRegex'] = $dir . 'MassEditRegex.i18n.php';
$wgExtensionMessagesFiles['MassEditRegexAlias'] = $dir . 'MassEditRegex.alias.php';
$wgAutoloadClasses['MassEditRegex'] = $dir . 'MassEditRegex.class.php';
$wgSpecialPages['MassEditRegex'] = 'MassEditRegex';
$wgSpecialPageGroups['MassEditRegex'] = 'pagetools';

// Required permission to use Special:MassEditRegex
$wgAvailableRights[] = 'masseditregex';

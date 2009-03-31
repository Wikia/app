<?php
if (!defined('MEDIAWIKI')) die();
/**
 * An extension to show a nice compact changes list and few extra filters for
 * Special:RecentChanges.php
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */


/* Set up messages and includes */
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['CleanChanges'] = $dir . 'CleanChanges.i18n.php';
$wgAutoloadClasses['NCL'] =  $dir . 'CleanChanges_body.php';

/* Hook into code */
$wgHooks['FetchChangesList'][] = 'NCL::hook' ;

/* Extension information */
$wgExtensionCredits['other'][] = array(
	'name' => 'Clean Changes',
	'version' => '2008-10-16',
	'author' => 'Niklas Laxström',
	'descriptionmsg' => 'cleanchanges-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:CleanChanges',
);

$wgCCUserFilter = true;
$wgCCTrailerFilter = false;

$wgExtensionFunctions[] = 'ccSetupFilters';
$wgAutoloadClasses['CCFilters'] = $dir . 'Filters.php';

function ccSetupFilters() {
	global $wgCCUserFilter, $wgCCTrailerFilter, $wgHooks;

	if ( $wgCCUserFilter ) {
		$wgHooks['SpecialRecentChangesQuery'][] = 'CCFilters::user';
		$wgHooks['SpecialRecentChangesPanel'][] = 'CCFilters::userForm';
	}
	if ( $wgCCTrailerFilter ) {
		$wgHooks['SpecialRecentChangesQuery'][] = 'CCFilters::trailer';
		$wgHooks['SpecialRecentChangesPanel'][] = 'CCFilters::trailerForm';
	}
}

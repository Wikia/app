<?php
/**
 * @package MediaWiki
 * @subpackage WidgetsSpecialPage
 *
 * @author Maciej Brencz <macbre@wikia.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	exit( 1 );
}
$wgSpecialPages['Widgets'] = 'WidgetsSpecialPage';
$wgExtensionFunctions[] = 'wfWidgetsSpecialPage';

// setup special page
function wfWidgetsSpecialPage() {
	require_once( dirname(__FILE__) . '/WidgetsSpecialPage_body.php' );
}


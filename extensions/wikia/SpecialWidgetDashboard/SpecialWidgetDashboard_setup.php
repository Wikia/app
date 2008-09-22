<?php
/**
 * @package MediaWiki
 * @subpackage SpecialWidgetDashboard
 *
 * @author Inez Korczynski
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgAutoloadClasses['SpecialWidgetDashboard'] = dirname(__FILE__).'/SpecialWidgetDashboard_body.php';
$wgSpecialPages['WidgetDashboard'] = 'SpecialWidgetDashboard';
$wgSpecialPageGroups['WidgetDashboard'] = 'wikia';

<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */
if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named TagsReport.\n";
    exit( 1 ) ;
}
$wgExtensionCredits['specialpage'][] = array(
    "name" => "Tags report",
    "description" => "List of articles which use special tags in text (like 'dpl', 'youtube')",
    "author" => "Piotr Molski"
);

$wgExtensionMessagesFiles["TagsReport"] = dirname(__FILE__) . '/SpecialTagsReport.i18n.php';

$wgAvailableRights[] = 'tagsreport';
$wgGroupPermissions['staff']['tagsreport'] = true;
$wgGroupPermissions['sysop']['tagsreport'] = true;
$wgGroupPermissions['helper']['tagsreport'] = true;

extAddSpecialPage( dirname(__FILE__) . '/SpecialTagsReport_body.php', 'TagsReport', 'TagsReportPage' );
$wgSpecialPageGroups['TagsReport'] = 'maintenance';

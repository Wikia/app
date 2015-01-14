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
    "descriptionmsg" => "tagsreport-desc",
    "author" => "Piotr Molski",
	"url" => "https://github.com/Wikia/app/tree/dev/extensions/wikia/TagsReport"
);

$wgExtensionMessagesFiles["TagsReport"] = dirname(__FILE__) . '/SpecialTagsReport.i18n.php';
$wgExtensionMessagesFiles['TagsReportAliases'] = __DIR__ . '/SpecialTagsReport.aliases.php';

$wgAvailableRights[] = 'tagsreport';
$wgGroupPermissions['*']['tagsreport'] = true;

extAddSpecialPage( dirname(__FILE__) . '/SpecialTagsReport_body.php', 'TagsReport', 'TagsReportPage' );
$wgSpecialPageGroups['TagsReport'] = 'maintenance';

<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A special page querypage extension (the first querypage extension) that
 * lists cross-namespace links that shouldn't exist on Wikimedia projects.
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Cross-namespace links',
	'svn-date' => '$LastChangedDate: 2008-07-09 18:34:20 +0200 (śro, 09 lip 2008) $',
	'svn-revision' => '$LastChangedRevision: 37404 $',
	'description' => 'lists links across namespaces that shouldn\'t exist on Wikimedia projects',
	'descriptionmsg' => 'crossnamespacelinks-desc',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'url' => 'http://www.mediawiki.org/wiki/Extension:CrossNamespaceLinks',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['CrossNamespaceLinks'] = $dir . 'SpecialCrossNamespaceLinks.i18n.php';
$wgExtensionAliasesFiles['CrossNameSpaceLinks'] = $dir . 'SpecialCrossNamespaceLinks.alias.php';
$wgAutoloadClasses['CrossNamespaceLinks'] = $dir . 'SpecialCrossNamespaceLinks_body.php';
$wgHooks['wgQueryPages'][] = 'wfSpecialCrossNamespaceLinksHook';
$wgSpecialPages['CrossNamespaceLinks'] = 'CrossNamespaceLinks';
$wgSpecialPageGroups['CrossNamespaceLinks'] = 'maintenance';

function wfSpecialCrossNamespaceLinksHook( &$QueryPages ) {
	$QueryPages[] = array(
		'CrossNamespaceLinksPage',
		'CrossNamespaceLinks',
		// Would probably be slow on large wikis -ævar
		//false
	);

	return true;
}

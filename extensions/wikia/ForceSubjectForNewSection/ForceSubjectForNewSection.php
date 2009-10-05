<?php

/**
 * ForceSubjectForNewSection
 *
 * A ForceSubjectForNewSection extension for MediaWiki
 * Force subject on adding new section to talk page
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2009-06-09
 * @copyright Copyright (C) 2009 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/ForceSubjectForNewSection/ForceSubjectForNewSection.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named ForceSubjectForNewSection.\n";
	exit(1) ;
}

$wgExtensionCredits['other'][] = array(
	'name' => 'ForceSubjectForNewSection',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
	'description' => 'Force subject on adding new section to talk page.'
);

$wgExtensionFunctions[] = 'ForceSubjectForNewSectionInit';
$wgExtensionMessagesFiles['ForceSubjectForNewSection'] = dirname(__FILE__) . '/ForceSubjectForNewSection.i18n.php';

/**
 * Initialize hooks
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function ForceSubjectForNewSectionInit() {
	global $wgHooks;
	$wgHooks['EditPage::showEditForm:initial'][] = 'ForceSubjectForNewSectionAddJS';
}

/**
 * add JavaScript to force subject
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function ForceSubjectForNewSectionAddJS(&$editPage) {
	global $wgOut;
	if ($editPage->section == 'new') {
		wfLoadExtensionMessages('ForceSubjectForNewSection');
		$message = wfMsg('force-subject-for-new-section-message');
		$wgOut->addInlineScript(<<<END
/* ForceSubjectForNewSection */
function checkSubject(ev) {
	var summary = \$G('wpSummaryEnhanced') || \$G('wpSummary');
	if (!summary) {
		return true;
	}
	if (summary.value.replace(/^\s+/, '').replace(/\s+$/, '') == '') {
		ev.preventDefault();
		alert('$message');
		summary.focus();
		return false;
	}
	return true;
}
wgAfterContentAndJS.push(function() {
	addHandler(\$G('wpSave'), 'click', checkSubject);
});
END
		);
	}

	return true;
}
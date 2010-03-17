<?php

/**
 * AddNewTalkSection
 *
 * A AddNewTalkSection extension for MediaWiki
 * Make long talk pages easier to use, by adding an "add new section" link to the page end.
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2009-05-19
 * @copyright Copyright (C) 2009 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/AddNewTalkSection/AddNewTalkSection.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named AddNewTalkSection.\n";
	exit(1) ;
}

$wgExtensionCredits['other'][] = array(
	'name' => 'AddNewTalkSection',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
	'description' => 'Make long talk pages easier to use, by adding an "add new section" link to the page end.'
);

$wgExtensionFunctions[] = 'AddNewTalkSectionInit';
//in AddNewTalkSectionInit() it's too late...
$wgHooks['LanguageGetMagic'][] = 'AddNewTalkSectionGetMagic';

/**
 * Initialize hooks
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function AddNewTalkSectionInit() {
	global $wgHooks;
	$wgHooks['AddNewTalkSection'][] = 'AddNewTalkSectionAddFooter';
	$wgHooks['EditPage::importFormData::finished'][] = 'AddNewTalkSectionImportFormData';
	$wgHooks['InternalParseBeforeLinks'][] = 'AddNewTalkSectionRemoveMagicWord';
}

/**
 * add magic word
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function AddNewTalkSectionGetMagic(&$magicWords, $langCode) {
	$magicWords['MAG_NONEWSECTIONLINK'] = array(0, '__NONEWSECTIONLINK__');
	return true;
}

/**
 * remove magic word from content
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function AddNewTalkSectionRemoveMagicWord(&$parser, &$text, &$strip_state) {
	MagicWord::get('MAG_NONEWSECTIONLINK')->matchAndRemove($text);
	return true;
}

/**
 * add link to the bottom of the article
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function AddNewTalkSectionAddFooter(&$skin, &$tpl, &$custom_article_footer) {
	global $wgTitle, $wgRequest, $wgUser;

	if (!$wgTitle->isTalkPage()) {
		return true;
	}

	$action = $wgRequest->getVal('action', 'view');
	//do not show link when anon sees 'pres ok to purge the page'
	if ($action == 'purge' && $wgUser->isAnon() && !$wgRequest->wasPosted()) {
		return true;
	}

	$rev = Revision::newFromTitle($wgTitle);
	if ($rev && MagicWord::get('MAG_NONEWSECTIONLINK')->match($rev->getText())) {
		return true;
	}

	global $wgBlankImgUrl;
	if (in_array($action, array('view', 'purge'))) {
		$text = wfMsg('addnewtalksection-link');
		$url = $wgTitle->getLocalURL('action=edit&section=new');

		$custom_article_footer = '<li id="fe_newsection"><a rel="nofollow" id="fe_newsection_icon" href="' . $url . '"><img src="'. $wgBlankImgUrl .'" id="fe_newsection_img" class="sprite talk" alt="' . $text . '" /></a> <div><a id="fe_newsection_link" rel="nofollow" href="' . $url . '">' . $text . '</a></div></li>';
	}
	return true;
}

/**
 * handle adding new section as a first one on EditPage POST
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function AddNewTalkSectionImportFormData($editPage, $request) {
	global $wgAddNewTalkSectionOnTop;
	if (!empty($wgAddNewTalkSectionOnTop) && $request->wasPosted() && $editPage->mTitle->exists() && $editPage->section == 'new') {
		if (!($editPage->preview || $editPage->diff)) {
			global $wgParser;
			//grab section 0 (from the begining to the first heading)
			$section0 = $wgParser->getSection($editPage->mArticle->getContent(), '0');
			//format heading subject -> == subject ==
			$subject = $editPage->summary ? wfMsgForContent('newsectionheaderdefaultlevel', $editPage->summary) . "\n\n" : '';
			//append user content to the section 0
			$text = strlen( trim( $section0 ) ) > 0
					? "{$section0}\n\n{$subject}{$editPage->textbox1}"
					: "{$subject}{$editPage->textbox1}";
			//replace section 0 with new content
			$text = $editPage->mArticle->replaceSection('0', $text, $editPage->summary);
			//as we are in 'add new section' mode, change it so MW will replace whole article (with our changes) - not add new text at the bottom
			$editPage->section = '';
			$editPage->textbox1 = $text;
		}
	}
	return true;
}

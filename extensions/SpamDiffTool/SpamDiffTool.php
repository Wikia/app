<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
    
/**#@+
 * An extension that allows users to rate articles.
 * 
 * @file
 * @ingroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:SpamDiffTool Documentation
 *
 *
 * @author Travis Derouin <travis@wikihow.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits[version_compare($wgVersion, '1.17alpha', '>=') ? 'antispam' : 'other'][] = array(
	'path' => __FILE__,
	'name' => 'SpamDiffTool',
	'author' => 'Travis Derouin',
	'descriptionmsg' => 'spamdifftool-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SpamDiffTool',
);

$wgSpamBlacklistArticle = "Project:Spam-Blacklist";

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['SpamDiffTool'] = $dir . 'SpamDiffTool.i18n.php';
$wgExtensionMessagesFiles['SpamDiffToolAlias'] = $dir . 'SpamDiffTool.alias.php';

$wgAutoloadClasses['SpecialSpamDiffTool'] = $dir . 'SpamDiffTool_body.php';
$wgSpecialPages['SpamDiffTool'] = 'SpecialSpamDiffTool';

$wgHooks['DiffViewHeader'][] = 'wfSpamDiffToolOnDiffView';

function wfSpamDiffToolOnDiffView( $diffEngine, $oldRev, $newRev ) {
	global $wgOut, $wgUser, $wgSpamBlacklistArticle;

	$sb = Title::newFromDBKey( $wgSpamBlacklistArticle );
	if ( !$sb->userCan( 'edit' ) ) {
		return true;
	}

	if ( !$oldRev || !$newRev ) {
		return true;
	}

	$wgOut->addHTML(
		'<table style="width:100%"><tr><td style="width:50%"></td><td style="width:50%">
		<div style="text-align:center">[' . $wgUser->getSkin()->link(
			SpecialPage::getTitleFor( 'SpamDiffTool' ),
			wfMsgHtml( 'spamdifftool_spam_link_text' ),
			array(),
			array(
				'target' => $diffEngine->getTitle()->getPrefixedDBkey(),
				'oldid2' => $oldRev->getId(),
				'diff2' => $newRev->getId(),
				'returnto' => $_SERVER['QUERY_STRING']
			) ) .
		']</div></td></tr></table>' );

	return true;
}

function wfSpamDiffLink( $title ) {
	global $wgUser, $wgRequest, $wgSpamBlacklistArticle;
	$sk = $wgUser->getSkin();
	$sb = Title::newFromDBKey( $wgSpamBlacklistArticle );
	if ( !$sb->userCan( 'edit' ) ) {
		return '';
	}
	$link = '[' . $sk->makeKnownLinkObj( SpecialPage::getTitleFor( 'SpamDiffTool' ),
		wfMsg( 'spamdifftool_spam_link_text' ),
		'target=' . $title->getPrefixedURL().
		'&oldid2=' . $wgRequest->getVal( 'oldid' ) .
		'&rcid='. $wgRequest->getVal( 'rcid' ) .
		'&diff2='. $wgRequest->getVal( 'diff' )  .
		'&returnto=' . urlencode( $_SERVER['QUERY_STRING'] )
		) .
		']';

	return $link;
}


<?php
/**
 * Automatically creates talk pages on a help wiki
 * when a new article is created.
 *
 * @author Lucas Garczewski <tor@wikia-inc.com>
 */

if(!defined('MEDIAWIKI')) {
	exit( 1 );
}

$wgHooks['ArticleSaveComplete'][] = 'efSharedHelpArticleCreation';

function efSharedHelpArticleCreation( &$article, &$user, $text, $summary, $minoredit, &$watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId, &$redirect ) {
	if ( wfReadOnly() ) {
		// not likely if we got here, but... healthy paranoia ;)
		return true;
	}

	if ( !$article->mTitle->isNewPage() ) {
		return true;
	}

	if ( $article->mTitle->getNamespace() !== NS_HELP ) {
		return true;
	}

	if ( empty( $status ) ) { // @TODO check for correct status here
		return true;
	}

	$talkTitle = Title::newFromText( $article->mTitle->getText(), NS_HELP_TALK );
	$talkArticle = new Article( $talkTitle );

	if ( $article->mTitle->isRedirect() ) {
		// @TODO if a redirect was created, create a redirect to the talk page instead
		// $talkArticle->doEdit( '{{talkheader}}', wfMsgForContent( 'sharedhelp-autotalkcreate-summary' ) );
	} else {
		$talkArticle->doEdit( '{{talkheader}}', wfMsgForContent( 'sharedhelp-autotalkcreate-summary' ) );
	}

	return true;
}

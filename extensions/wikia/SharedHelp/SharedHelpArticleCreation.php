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

/**
 * @param WikiPage $article
 * @param $user
 * @param $text
 * @param $summary
 * @param $minoredit
 * @param $watchthis
 * @param $sectionanchor
 * @param $flags
 * @param $revision
 * @param Status $status
 * @param $baseRevId
 * @return bool
 */
function efSharedHelpArticleCreation( WikiPage $article, User $user, $text, $summary, $minoredit, $watchthis, $sectionanchor, $flags, $revision, Status &$status, $baseRevId ): bool {
	global $wgCityId, $wgHelpWikiId;

	// only run on help wikis
	if ( $wgCityId !== $wgHelpWikiId ) {
		return true;
	}

	// not likely if we got here, but... healthy paranoia ;)
	if ( wfReadOnly() ) {
		return true;
	}

	if ( $article->mTitle->getNamespace() !== NS_HELP ) {
		return true;
	}

        if ( !$status->isOK() ) {
                return true;
        }

        if ( !( $flags & EDIT_NEW ) ) {
                return true;
        }

	$talkTitle = Title::newFromText( $article->mTitle->getText(), NS_HELP_TALK );

	if ( $talkTitle->exists() ) {
		return true;
	}

	$talkArticle = new Article( $talkTitle );

	$redir = $article->getRedirectTarget();
	$editSummary = wfMessage( 'sharedhelp-autotalkcreate-summary' )->inContentLanguage()->text();

	if ( $redir ) {
		$target = $redir->getTalkNsText() . ':' . $redir->getText();
		$talkArticle->doEdit( "#REDIRECT [[$target]]", $editSummary );
	} else {
		$talkArticle->doEdit( '{{talkheader}}', $editSummary );
	}

	return true;
}

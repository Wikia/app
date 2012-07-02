<?php
if ( !defined( 'MEDIAWIKI' ) )
	die( 1 );

// Hooks registration:
global $wgHooks;

$wgHooks['ArticleSaveComplete'][] = 'wfAjaxShowEditorsCleanup';
$wgHooks['BeforePageDisplay'][] = 'wfAjaxShowEditorsAddCSS';
$wgHooks['AjaxAddScript'][] = 'wfAjaxShowEditorsAddJS';
$wgHooks['EditPage::showEditForm:initial'][] = 'wfAjaxShowEditorsShowBox';

/**
	$article: the article (object) saved
	$user: the user (object) who saved the article
	$text: the new article text
	$summary: the article summary (comment)
	$isminor: minor flag
	$iswatch: watch flag
	$section: section #
*/
function wfAjaxShowEditorsCleanup( $article, $user ) {
	global $wgCommandLineMode;

	if ( $wgCommandLineMode ) {
		return true;
	}
	$articleId = $article->getID();
	$userId = $user->getName();

	$dbw = wfGetDB( DB_MASTER );
	$dbw->delete( 'editings',
		array(
			'editings_page' => $articleId,
			'editings_user' => $userId,
		),
		__METHOD__
	);
	return true;
}

// Only when editing a page
function wfAjaxShowEditorsAddCSS( $out ) {
	global $wgRequest, $wgExtensionAssetsPath;

	if ( $wgRequest->getVal( 'action' ) == 'edit' ) {
		$out->addStyle( "$wgExtensionAssetsPath/AjaxShowEditors/AjaxShowEditors.css" );
	}
	return true;
}

function wfAjaxShowEditorsAddJS( $out ) {
	global $wgExtensionAssetsPath;

	$out->addScriptFile( "$wgExtensionAssetsPath/AjaxShowEditors/AjaxShowEditors.js" );
	return true;
}

// Show the box before the textarea
function wfAjaxShowEditorsShowBox( ) {
	global $wgOut;

	$wgOut->addWikiText(
		'<div id="ajax-se"><p id="ajax-se-title">' . wfMsg( 'ajax-se-title' ) . '</p>'
		. '<p id="ajax-se-editors">' . wfMsg( 'ajax-se-pending' ) . '</p>'
		. '</div>'
		);
	return true;
}

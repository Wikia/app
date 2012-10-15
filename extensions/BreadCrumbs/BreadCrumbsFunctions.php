<?php
/* The BreadCrumbs extension, an extension for providing an breadcrumbs
 * navigation to users.
 *
 * @file
 * @ingroup Extensions
 * @author Manuel Schneider <manuel.schneider@wikimedia.ch>
 * @copyright © 2007 by Manuel Schneider
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die();
}

function fnBreadCrumbsShowHook( &$article ) {
	global $wgOut, $wgUser;
	global $wgBreadCrumbsDelimiter, $wgBreadCrumbsCount, $wgBreadCrumbsShowAnons;

	if ( !$wgBreadCrumbsShowAnons && $wgUser->isAnon() )
		return true;

	# deserialize data from session into array:
	$m_BreadCrumbs = array();
	if ( isset( $_SESSION['BreadCrumbs'] ) ) $m_BreadCrumbs = $_SESSION['BreadCrumbs'];
	# cache index of last element:
	$m_count = count( $m_BreadCrumbs ) - 1;
	# Title object for the page we're viewing
	$title = $article->getTitle();

	# check for doubles:
	if ( $m_count < 1 || $m_BreadCrumbs[ $m_count ] != $title->getPrefixedText() ) {
		if ( $m_count >= 1 ) {
			# reduce the array set, remove older elements:
			$m_BreadCrumbs = array_slice( $m_BreadCrumbs, ( 1 - $wgBreadCrumbsCount ) );
		}
		# add new page:
		array_push( $m_BreadCrumbs, $title->getPrefixedText() );
	}
	# serialize data from array to session:
	$_SESSION['BreadCrumbs'] = $m_BreadCrumbs;
	# update cache:
	$m_count = count( $m_BreadCrumbs ) - 1;

	# build the breadcrumbs trail:
	$m_trail = '<div id="BreadCrumbsTrail">';
	for ( $i = 0; $i <= $m_count; $i++ ) {
		$title = Title::newFromText( $m_BreadCrumbs[$i] );
		$m_trail .= Linker::link( $title, $m_BreadCrumbs[$i] );
		if ( $i < $m_count ) $m_trail .= $wgBreadCrumbsDelimiter;
	}
	$m_trail .= '</div>';
	$wgOut->addHTML( $m_trail );

	# invalidate internal MediaWiki cache:
	$title->invalidateCache();
	$wgUser->invalidateCache();

	# Return true to let the rest work:
	return true;
}

# Entry point for the hook for printing the CSS:
function fnBreadCrumbsOutputHook( &$outputPage, $parserOutput ) {
	global $wgBreadCrumbsShowAnons;

	if ( $wgBreadCrumbsShowAnons || $outputPage->getUser()->isLoggedIn() ) {
		$outputPage->addModules( 'ext.breadCrumbs' );
	}

	# Be nice:
	return true;
}

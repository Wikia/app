<?php
if ( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 * Ajax responder entry point
 */
function wfAjaxQueryPages( $specialpagename, $offset, $limit, $dir = false ) {
	global $wgRequest, $wgOut;

	// Make sure we requested an existing special page
	if ( !$spObj = SpecialPage::getPageByAlias( $specialpagename ) ) {
		return null;
	}

	// Alter the GET request.
	$wgRequest->setVal( 'offset', $offset );
	$wgRequest->setVal( 'limit', $limit );

	if ( $dir == 'prev' || $dir == 'next' ) {
		$wgRequest->setVal( 'dir', $dir );
	}

	$spObj->execute( null );

	return $wgOut->getHTML();
}

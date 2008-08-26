<?php
if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

// Ajax actions registration
$wgAjaxExportList[] = "wfAjaxQueryPages";

/**
 * Ajax responder entry point
 */
function wfAjaxQueryPages( $specialpagename, $offset, $limit ) {

	// Make sure we requested an existing special page
	if( !$spObj = SpecialPage::getPageByAlias( $specialpagename ) ) {
		return null;
	}

	// Alter the GET request.
	$_GET['offset'] = (int) $offset;
	$_GET['limit'] = (int) $limit;

	// HACK : rebuild the webrequest object so it knows about offset & limit
	global $wgRequest ;
	$wgRequest->__construct();
	
	$spObj->execute( null );

	global $wgOut;
	return $wgOut->getHTML();
}


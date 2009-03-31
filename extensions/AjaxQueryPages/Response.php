<?php
if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

// Ajax actions registration
$wgAjaxExportList[] = "wfAjaxQueryPages";

/**
 * Ajax responder entry point
 */
function wfAjaxQueryPages( $specialpagename, $offset, $limit, $dir = false ) {

	// Make sure we requested an existing special page
	if( !$spObj = SpecialPage::getPageByAlias( $specialpagename ) ) {
		return null;
	}

	// Alter the GET request.
	$_GET['offset'] = $offset;
	$_GET['limit'] = (int) $limit;

	if( $dir=='prev' || $dir=='next' ) { 
		$_GET['dir'] = $dir ;
	} else {
		unset( $_GET['dir'] );
	}
	// HACK : rebuild the webrequest object so it knows about offset & limit
	global $wgRequest ;
	$wgRequest->__construct();
	
	$spObj->execute( null );

	global $wgOut;
	return $wgOut->getHTML();
}


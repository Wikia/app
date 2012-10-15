<?php
/**
 * AJAX functions used by LinkFilter extension.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

$wgAjaxExportList[] = 'wfLinkFilterStatus';
function wfLinkFilterStatus( $id, $status ) {
	// Check permissions
	if( !Link::canAdmin() ) {
		return '';
	}

	$dbw = wfGetDB( DB_MASTER );
	$dbw->update(
		'link',
		/* SET */array( 'link_status' => intval( $status ) ),
		/* WHERE */array( 'link_id' => intval( $id ) ),
		__METHOD__
	);
	$dbw->commit();

	if( $status == 1 ) {
		$l = new Link();
		$l->approveLink( $id );
	}

	return 'ok';
}
<?php

$wgAjaxExportList [] = 'wfLinkFilterStatus';
function wfLinkFilterStatus($id, $status){
	global $wgUser, $IP;
	
	if( !Link::canAdmin() ){
		return "";
	}
	
	$dbw =& wfGetDB( DB_MASTER );
	$dbw->update( '`link`',
		array( /* SET */
		'link_status' => $status
		), array( /* WHERE */
		'link_id' => $id
		), ""
	);
	
	if( $status == 1 ) {
		$l = new Link();
		$l->approveLink($id);
		$ll = new LinkList();
		$ll->updateRSS(40);
	}
	
	return "ok";
}

?>
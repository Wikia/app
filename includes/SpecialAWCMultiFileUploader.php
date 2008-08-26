<?PHP

function wfspecialawcmultifileuploader() {
	global $wgUser, $wgOut;	
	
	# Permission check
        if( !$wgUser->isAllowed( 'MultiFileUploader' ) ) {
	    $wgOut->permissionRequired( 'MultiFileUploader' );
	    return;
	}
						    
	require_once('extensions/awc/multi_file_uploader/work.php');
	new working(); 
}

?>
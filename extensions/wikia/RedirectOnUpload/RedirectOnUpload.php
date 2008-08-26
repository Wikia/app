<?php
//$wgHooks['UploadComplete'][] = 'fnRedirectOnUpload';
//$wgHooks['UploadForm:initial'][] = 'fnAddRedirectForm';

function fnAddRedirectForm($uploadFormObj) {
	global $wgRequest, $wgOut;
	
	$uploadFormObj->uploadFormTextAfterSummary .=  "<input type=\"hidden\" name=\"wpRedirect\" value=\"" . $wgRequest->getVal("wpRedirect") . "\" />";
	
	return $uploadFormObj;
}

function fnRedirectOnUpload( &$image ){
	global $wgUser, $wgRequest, $wgOut;

	$to = $wgRequest->getVal("wpRedirect");
	
	//skip if no category is passed
	if( !$to ){
		return true;
	}
	
	$page_title = Title::newFromDBkey($to);
	$redirect_url = $page_title->getFullURL();
	
	$wgOut->redirect( $redirect_url );

	return true;
	 
}
?>

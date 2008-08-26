<?php
/*
 * Ajax Functions used by Wikia extensions
 */
 
$wgAjaxExportList [] = 'wfDeleteProfileImage';
function wfDeleteProfileImage($image_name){
	global $wgUser, $wgOut, $IP, $wgMemc; 
	
	$dbr =& wfGetDB( DB_MASTER );
	
	$image_title = Title::makeTitle(NS_IMAGE, $image_name);
	$image_page_id = $image_title->getArticleID();
	
	$row = $dbr->selectRow( 'revision', 
				"rev_user_text", 
				array( 'rev_page' => $image_page_id  ), __METHOD__,
				array( "LIMIT" => 1, "ORDER BY" => "rev_id")
				);
				
	if($row->rev_user_text == $wgUser->getName() ){
		//delete
		$article = new Article($image_title);
		$article->doDeleteArticle( "delete profile image");
		$key = wfMemcKey( 'user', 'profile', 'pictures', $wgUser->getID() );
		$wgMemc->delete( $key );
	}
					
	return "ok";
}



?>

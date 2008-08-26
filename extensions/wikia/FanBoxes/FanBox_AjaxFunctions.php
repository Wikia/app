<?php
/*
 * Ajax Functions used by Wikia extensions
 */
 
$wgAjaxExportList [] = 'wfFanBoxShowaddRemoveMessage';
function wfFanBoxShowaddRemoveMessage($addremove, $title, $individual_fantag_id){
	global $wgUser, $wgOut, $IP, $wgMessageCache, $wgFanBoxDirectory; 
	$out = "";
	
	require_once ( "{$wgFanBoxDirectory}/FanBox.i18n.php" );
	foreach( efWikiaFantag() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}

	
	$fanbox = FanBox::newFromName( $title);
	
	if ($addremove==1){
	$fanbox->changeCount($individual_fantag_id, +1);
	$fanbox->addUserFan($individual_fantag_id);
					
	if($wgUser->isLoggedIn()){
			$check = $fanbox->checkIfUserHasFanBox();
			if ($check == 0){
				$out .= $fanbox->outputIfUserDoesntHaveFanBox();

			}
			else $out .= $fanbox->outputIfUserHasFanBox();
		}
	else {
			$out .= $fanbox->outputIfUserNotLoggedIn();
	}


	$out.= "<div class=\"show-individual-addremove-message\">
	". wfMsgForContent( 'fanbox_successful_add' ) ."
	</div>";

	}

	if ($addremove==2){	
	$fanbox->changeCount($individual_fantag_id, -1);
	$fanbox->removeUserFanBox($individual_fantag_id);
					
	if($wgUser->isLoggedIn()){
			$check = $fanbox->checkIfUserHasFanBox();
			if ($check == 0){
				$out .= $fanbox->outputIfUserDoesntHaveFanBox();

			}
			else $out .= $fanbox->outputIfUserHasFanBox();
		}
	else {
			$out .= $fanbox->outputIfUserNotLoggedIn();
	}


	$out.= "<div class=\"show-individual-addremove-message\">
	". wfMsgForContent( 'fanbox_successful_remove' ) ."
	</div>";
	}



	return $out;

}


$wgAjaxExportList [] = 'wfMessageAddRemoveUserPage';
function wfMessageAddRemoveUserPage($addremove, $id, $style){
	global $wgUser, $wgOut, $IP, $wgMessageCache, $wgFanBoxDirectory; 
	$out = "";

	require_once ( "{$wgFanBoxDirectory}/FanBox.i18n.php" );
	foreach( efWikiaFantag() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}

	
	if ($addremove==1){
		
	$Number=+1;
		
	$dbr = wfGetDB( DB_MASTER );
	$dbr->insert( '`user_fantag`',
		array(
			'userft_fantag_id' => $id,
			'userft_user_id' => $wgUser->getID(),
			'userft_user_name' => $wgUser->getName(),
			'userft_date' => date("Y-m-d H:i:s"),
			), __METHOD__
		);	
	
	
	$out.= "<div class=\"$style\">". wfMsgForContent( 'fanbox_successful_add' ) ."</div>";
		
	}

	if ($addremove==2){
	$Number=-1;
	
	$dbr =& wfGetDB( DB_MASTER );
	$sql = "DELETE FROM user_fantag WHERE userft_user_name = '{$wgUser->getName()}' && userft_fantag_id = {$id}";
	$res = $dbr->query($sql);

	$out.= "<div class=\"$style\">". wfMsgForContent( 'fanbox_successful_remove' ) ."</div>";
	}


	$sql = "SELECT fantag_count FROM fantag WHERE fantag_id= {$id}";		
	$res = $dbr->query($sql);
	$row = $dbr->fetchObject( $res );
	$count=$row->fantag_count;
	$sql2 = "UPDATE fantag SET fantag_count={$count}+{$Number} WHERE fantag_id= {$id}";
	$res2 = $dbr->query($sql2);
	
	

	return $out;

}


$wgAjaxExportList [] = 'wfFanBoxesTitleExists';
function wfFanBoxesTitleExists($page_name){ 
	
	//construct page title object to convert to Database Key
	$page_title =  Title::makeTitle( NS_MAIN  , urldecode($page_name) );
	$db_key = $page_title->getDBKey();
	
	//Database key would be in page title if the page already exists
	$dbr =& wfGetDB( DB_MASTER );
	$s = $dbr->selectRow( 'page', array( 'page_id' ), array( 'page_title' => $db_key , 'page_namespace'=>NS_FANTAG),"" );
	if ( $s !== false ) {
		return "Page exists";
	} else {
		return "OK";
	}
}


?>
<?php

$wgExtensionFunctions[] = 'wfSpecialPopulateAwards';

function wfSpecialPopulateAwards(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class PopulateAwards extends UnlistedSpecialPage {
	
		function PopulateAwards(){
			UnlistedSpecialPage::UnlistedSpecialPage("PopulateAwards");
		}
	
		function execute( $gift_category){
			global $wgUser, $wgOut, $wgMemc; 
			$dbr =& wfGetDB( DB_MASTER );
		
			if( !in_array('staff',($wgUser->getGroups())) ){
				$wgOut->errorpage( "error", "badaccess" );
				return false;
			}
		  
			global $wgUserLevels;
			$wgUserLevels = "";

			$g = new SystemGifts();
			$g->update_system_gifts();
			 
		
		}
	
	}

	SpecialPage::addPage( new PopulateAwards );
}
 


?>
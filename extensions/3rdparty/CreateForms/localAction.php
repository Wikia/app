<?php

$wgExtensionFunctions[] = 'wfSpeciallocalAction';


function wfSpeciallocalAction(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class LocalAction extends SpecialPage {

  function LocalAction(){
    UnlistedSpecialPage::UnlistedSpecialPage("LocalAction");
  }

  function execute(){
    global $wgUser, $wgOut; 

	if($_GET["action"] == 1 && $_GET["state"]){
		$output = "";
		$dbr =& wfGetDB( DB_MASTER );
		
		$res = $dbr->query("SELECT city_name from cities_us where state = '" . $_GET["state"] . "' order by city_name");
		while ($row = $dbr->fetchObject( $res ) ) {
			if($output)$output .= "|";
			$output .=   $row->city_name  ;
		}
		$wgOut->addHTML( $output);
	}

	 
	// This line removes the navigation and everything else from the
 	// page, if you don't set it, you get what looks like a regular wiki
 	// page, with the body you defined above.
 	$wgOut->setArticleBodyOnly(true);
  }

}

 SpecialPage::addPage( new LocalAction );
 global $wgMessageCache,$wgOut;
 $wgMessageCache->addMessage( 'localaction', 'just a test extension' );
 


}

?>
<?php

$wgExtensionFunctions[] = 'wfSpecialRandomPoll';

function wfSpecialRandomPoll(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class RandomPoll extends SpecialPage {

	
	function RandomPoll(){
		UnlistedSpecialPage::UnlistedSpecialPage("RandomPoll");
	}
	
	function execute(){
		global $wgRequest, $IP, $wgOut, $wgUser;
	 
		$p = new Poll();
		
		$poll_page = $p->get_random_poll_url( $wgUser->getName() );
		if($poll_page=="error"){
			$wgOut->setPagetitle( wfMsgForContent( 'poll_no_more_title' ) );
			$create_title = Title::makeTitle(NS_SPECIAL,"CreatePoll");
			$out = "<p>
					" . wfMsgForContent( 'poll_no_more_message' )  . "
					<a href=\"{$create_title->getFullURL()}\">" . wfMsgForContent( 'poll_no_more_create_link' ) . "</a>
				</p>";
			$wgOut->addHTML($out);
		}else{
			$poll_title = Title::newFromText($poll_page);
			$wgOut->redirect( $poll_title->getFullURL() );
		}
		return $poll_page;
	
	}
  
}

SpecialPage::addPage( new RandomPoll );

}

?>
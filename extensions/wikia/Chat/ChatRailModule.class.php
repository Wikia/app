<?php
class ChatRailModule extends Module {
	var $showButton;
	var $linkToSpecialChat;
	var $windowFeatures;

	/**
	 * Rail module that contains a button which instructs the user to click it to
	 * open a chat window.  This rail module does not contain any actual chat content.
	 */
	public function executeButtonToOpenChat(){
		global $wgUser;
		wfProfileIn( __METHOD__ );

		// For now, this button will only show up to logged-in users.
		$this->showButton = false;
		if($wgUser->isLoggedIn()){
			$this->showButton = true;

			$this->linkToSpecialChat = SpecialPage::getTitleFor("Chat")->escapeLocalUrl();

			$width = 600;
			$height = 600;
			$this->windowFeatures = 'width='.$width.',height='.$height;
			$this->windowFeatures.= ',menubar=no,status=no,location=no,toolbar=no';
			$this->windowFeatures.= ',scrollbars=no,resizable=yes';
		}

		wfProfileOut( __METHOD__ );
	}

}

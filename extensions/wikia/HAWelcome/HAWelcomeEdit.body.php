<?php

class HAWelcomeEdit extends UnlistedSpecialPage {

	private	$mTitle;

	public function __construct() {
		wfLoadExtensionMessages('HAWelcome');
		parent::__construct( 'HAWelcomeEdit', 'HAWelcomeEdit', null, false );
	}

	public function execute( $subpage ) {
		global $wgOut, $wgUser;

		wfProfileIn( __METHOD__ );

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor( 'HAWelcomeEdit' );

		if( $this->isRestricted() && !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}
		
		$this->showCurrent();
		
		wfProfileOut( __METHOD__ );
	}
	
	private function showCurrent(){
		global $wgOut, $wgMemc;

		$wgOut->addHTML("<fieldset>\n");
		$wgOut->addHTML("<legend>CurrentValue</legend>\n");
		$sysopId = $wgMemc->get( wfMemcKey( "last-sysop-id" ) );
			if( $sysopId ) {
				$this->mSysop = User::newFromId( $sysopId );
				$sysopName = wfEscapeWikiText( $this->mSysop->getName() );
				$wgOut->addHTML("ID: <code>".$sysopId."</code><br/>");
				$wgOut->addHTML("Name: <code>".$sysopName."</code><br/>");
			}
			else
			{
				$wgOut->addHTML("<i>n/a</i>");
			}
		$wgOut->addHTML("</fieldset>\n");
	}
}

<?php
class WikiaWidget extends SpecialPage {
	function __construct() {
		parent::__construct( 'WikiaWidget' );
		//wfLoadExtensionMessages('WikiaWidget');
	}
 
	function execute( $par ) {
		global $wgUser, $wgRequest, $wgOut;
 
		$this->setHeaders();
 		$wgOut->setPageTitle('Configure a Wikia Widget');
		# Get request data from, e.g.
		$param = $wgRequest->getText('param');
 
		# Do stuff
		# ...

		if( !$wgUser->isAllowed( 'wikiawidget' ) ) {
   			$wgOut->addHTML( 'Sorry, this feature is hidden away for staff only. Once we get it working really nicely, we\'ll open it up for everyone.' );
			return;
      		}
		
		$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$output = $tmpl->execute('main'); 

		# Output
		$wgOut->addHTML( $output );
	}
}


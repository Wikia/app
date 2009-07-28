<?php
class NewWikiBuilder extends SpecialPage {
	function __construct() {
		parent::__construct( 'NewWikiBuilder' , 'newwikibuilder');
		wfLoadExtensionMessages('NewWikiBuilder');
	}
 
	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

		global $wgUser;
		if ( !$this->userCanExecute($wgUser) ) {
			$this->displayRestrictionError();
			return;
		}
 
		$this->setHeaders();
 
		// output only template content
		$wgOut->setArticleBodyOnly(true);
	
		// Put the html in a separate file 
		ob_start();
		include dirname(__FILE__) . '/NewWikiBuilder.html.php';
 
		// Output
		$wgOut->addHTML( ob_get_clean() );

	}
}

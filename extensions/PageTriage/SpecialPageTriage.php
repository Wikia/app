<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "PageTriage extension\n";
	exit( 1 );
}

class SpecialPageTriage extends SpecialPage {

	public function __construct() {
		// Register special page
		parent::__construct( 'PageTriage' );
	}

	public function execute( $sub ) {
		global $wgOut;

		// Begin output
		$this->setHeaders();
		
		// Output ResourceLoader module for styling and javascript functions
		$wgOut->addModules( 'ext.pageTriage.core' );
		
		$wgOut->addHTML( Xml::openElement( 'div', array( 'id' => 'ptr-stuff' ) ) );
		$wgOut->addHTML( "Hello World" );
		$wgOut->addHTML( Xml::closeElement( 'div' ) );
		
	}

}

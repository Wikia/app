<?php
/**
 * Special Page for Contribution statistics extension
 *
 * @file
 * @ingroup Extensions
 */

class DisabledNotice extends SpecialPage {

	/* Functions */

	public function __construct() {
		parent::__construct( 'DisabledNotice' );
	}

	public function execute( $sub ) {
		global $wgOut, $wgScriptPath;

		/* Setup */

		$this->setHeaders();
		$wgOut->addModules( 'ext.disablednotice' );
		
		/* Display */

		$wgOut->addWikiMsg( 'contribstats-header' );
		
		$wgOut->addHTML( Xml::openElement( 'div', array( 'id' => 'cr-disablednotice' ) ) );
		$wgOut->addWikiMsg( 'disablednotice-disabled' );
		$wgOut->addHTML( Xml::closeElement( 'div' ) );
		
		$wgOut->addWikiMsg( 'contribstats-footer' );
	}

}

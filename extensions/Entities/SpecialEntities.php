<?php
/**
 * Special:Entities
 *
 * @file
 * @ingroup Extensions
 */

class SpecialEntities extends SpecialPage {
	
	/* Methods */
	
	function __construct() {
		parent::__construct( 'Entities' );
	}
	
	function execute( $par ) {
		global $wgOut;

		$this->setHeaders();

		$wgOut->setPageTitle( wfMsg( 'entities-title' ) );

		$wgOut->addHtml( '<p>Hello special page!</p>' );
	}
}

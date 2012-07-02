<?php

/**
 * A special page that serves as dashboard for administrative tasks related to deployment.
 * 
 * @file SpecialDashboard.php
 * @ingroup Deployment
 * @ingroup SpecialPage
 * 
 * @author Jeroen De Dauw
 */
class SpecialDashboard extends SpecialPage {

	/**
	 * Constructor.
	 * 
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'Dashboard', 'siteadmin' );
	}
	
	/**
	 * @see SpecialPage::getDescription
	 */
	public function getDescription() {
		return wfMsg( 'special-' . strtolower( $this->getName() ) );
	}	

	/**
	 * Main method.
	 * 
	 * @since 0.1 
	 * 
	 * @param $arg String
	 */
	public function execute( $arg ) {
		global $wgOut, $wgUser;
		
		$wgOut->setPageTitle( wfMsg( 'dashboard-title' ) );
		
		// If the user is authorized, display the page, if not, show an error.
		if ( $this->userCanExecute( $wgUser ) ) {
			
		} else {
			$this->displayRestrictionError();
		}			
	}
	
}

<?php

/**
 * Shows the info for a single campus ambassador.
 *
 * @since 0.1
 *
 * @file SpecialCA.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialCA extends SpecialEPPage {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'CampusAmbassador', '', false );
	}

	/**
	 * Main method.
	 *
	 * @since 0.1
	 *
	 * @param string $subPage
	 */
	public function execute( $subPage ) {
		parent::execute( $subPage );

		$out = $this->getOutput();

		if ( trim( $subPage ) === '' ) {
			$this->getOutput()->redirect( SpecialPage::getTitleFor( 'CampusAmbassadors' )->getLocalURL() );
		}
		else {
			$out->setPageTitle( wfMsgExt( 'ep-ca-title', 'parsemag', $this->subPage ) );

			$this->displayNavigation();

			$ca = false; // TODO

			if ( $ca === false ) {
				$this->showWarning( wfMessage( 'ep-ca-does-not-exist', $this->subPage ) );
			}
			else {
				$this->displaySummary( $ca );
			}
		}
	}

	/**
	 * Gets the summary data.
	 *
	 * @since 0.1
	 *
	 * @param EPCA $ca
	 *
	 * @return array
	 */
	protected function getSummaryData( EPDBObject $ca ) {
		$stats = array();

		return $stats;
	}

}

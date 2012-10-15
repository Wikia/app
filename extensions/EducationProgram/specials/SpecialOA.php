<?php

/**
 * Shows the info for a single online ambassador.
 *
 * @since 0.1
 *
 * @file SpecialOA.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialOA extends SpecialEPPage {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'OnlineAmbassador', '', false );
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
			$this->getOutput()->redirect( SpecialPage::getTitleFor( 'OnlineAmbassadors' )->getLocalURL() );
		}
		else {
			$out->setPageTitle( wfMsgExt( 'ep-oa-title', 'parsemag', $this->subPage ) );

			$this->displayNavigation();

			$oa = false; // TODO

			if ( $oa === false ) {
				$this->showWarning( wfMessage( 'ep-oa-does-not-exist', $this->subPage ) );
			}
			else {
				$this->displaySummary( $oa );
			}
		}
	}

	/**
	 * Gets the summary data.
	 *
	 * @since 0.1
	 *
	 * @param EPOA $ca
	 *
	 * @return array
	 */
	protected function getSummaryData( EPDBObject $oa ) {
		$stats = array();

		return $stats;
	}

}

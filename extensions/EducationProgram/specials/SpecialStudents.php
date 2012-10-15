<?php

/**
 * Page listing all students in a pager with filter control.
 *
 * @since 0.1
 *
 * @file SpecialStudents.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialStudents extends SpecialEPPage {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'Students' );
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

		if ( $this->subPage === '' ) {
			$this->displayNavigation();
			EPStudent::displayPager( $this->getContext() );
		}
		else {
			$this->getOutput()->redirect( SpecialPage::getTitleFor( 'Student', $this->subPage )->getLocalURL() );
		}
	}

}

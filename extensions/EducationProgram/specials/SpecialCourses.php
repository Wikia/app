<?php

/**
 * Page listing all courses in a pager with filter control.
 * Also has a form for adding new items for those with matching privileges.
 *
 * @since 0.1
 *
 * @file SpecialCourses.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialCourses extends SpecialEPPage {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'Courses' );
	}

	/**
	 * Main method.
	 *
	 * @since 0.1
	 *
	 * @param string|null $subPage
	 */
	public function execute( $subPage ) {
		parent::execute( $subPage );

		if ( $this->subPage === '' ) {
			$this->displayNavigation();
			EPCourse::displayAddNewRegion( $this->getContext() );
			EPCourse::displayPager( $this->getContext() );
		}
		else {
			$this->getOutput()->redirect( Title::newFromText( $this->subPage, EP_NS_COURSE )->getLocalURL() );
		}
	}

}

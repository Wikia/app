<?php

/**
 * Action to view the history of courses.
 *
 * @since 0.1
 *
 * @file CourseHistoryAction.php
 * @ingroup EducationProgram
 * @ingroup Action
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class CourseHistoryAction extends EPHistoryAction {
	
	
	public function getName() {
		return 'coursehistory';
	}

	protected function getDescription() {
		return Linker::linkKnown(
			SpecialPage::getTitleFor( 'Log' ),
			$this->msg( 'ep-course-history' )->escaped(),
			array(),
			array( 'page' => $this->getTitle()->getPrefixedText() )
		);
	}

	protected function getItemClass() {
		return 'EPCourse';
	}
	
}
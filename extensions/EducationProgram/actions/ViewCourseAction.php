<?php

/**
 * Action for viewing a course.
 *
 * @since 0.1
 *
 * @file ViewCourseAction.php
 * @ingroup EducationProgram
 * @ingroup Action
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ViewCourseAction extends EPViewAction {
	
	public function getName() {
		return 'viewcourse';
	}

	protected function getItemClass() {
		return 'EPCourse';
	}

	protected function displayPage( EPDBObject $course ) {
		parent::displayPage( $course );

		$out = $this->getOutput();

		$out->addElement( 'h2', array(), wfMsg( 'ep-course-description' ) );

		$out->addHTML( $this->getOutput()->parse( $course->getField( 'description' ) ) );

		$studentIds = array_map(
			function( EPStudent $student ) {
				return $student->getId();
			},
			$course->getStudents( 'id' )
		);

		if ( count( $studentIds ) > 0 ) {
			$out->addElement( 'h2', array(), wfMsg( 'ep-course-articles' ) );
			EPArticle::displayPager( $this->getContext(), array( 'course_id' => $course->getId() ) );

			$out->addElement( 'h2', array(), wfMsg( 'ep-course-students' ) );
			EPStudent::displayPager( $this->getContext(), array( 'id' => $studentIds ) );
		}
		else {
			// TODO
		}
	}

	/**
	 * Gets the summary data.
	 *
	 * @since 0.1
	 *
	 * @param EPCourse $course
	 *
	 * @return array
	 */
	protected function getSummaryData( EPDBObject $course ) {
		$stats = array();

		$orgName = EPOrg::selectFieldsRow( 'name', array( 'id' => $course->getField( 'org_id' ) ) );
		$stats['org'] = EPOrg::getLinkFor( $orgName );

		$lang = $this->getLanguage();

		$stats['term'] = htmlspecialchars( $course->getField( 'term' ) );
		$stats['start'] = htmlspecialchars( $lang->timeanddate( $course->getField( 'start' ), true ) );
		$stats['end'] = htmlspecialchars( $lang->timeanddate( $course->getField( 'end' ), true ) );

		$stats['students'] = htmlspecialchars( $lang->formatNum( $course->getField( 'students' ) ) );

		$stats['status'] = htmlspecialchars( EPCourse::getStatusMessage( $course->getStatus() ) );

		if ( $this->getUser()->isAllowed( 'ep-token' ) ) {
			$stats['token'] = Linker::linkKnown(
				SpecialPage::getTitleFor( 'Enroll', $course->getId() . '/' . $course->getField( 'token' ) ),
				htmlspecialchars( $course->getField( 'token' ) )
			);
		}

		$stats['instructors'] = $this->getRoleList( $course, 'instructor' ) . $this->getRoleControls( $course, 'instructor' );
		$stats['online'] = $this->getRoleList( $course, 'online' ) . $this->getRoleControls( $course, 'online' );
		$stats['campus'] = $this->getRoleList( $course, 'campus' ) . $this->getRoleControls( $course, 'campus' );

		return $stats;
	}

	/**
	 * Returns a list with the users that the specified role for the provided course
	 * or a message indicating there are none.
	 *
	 * @since 0.1
	 *
	 * @param EPCourse $course
	 * @param string $roleName
	 *
	 * @return string
	 */
	protected function getRoleList( EPCourse $course, $roleName ) {
		$users = $course->getUserWithRole( $roleName );

		if ( count( $users ) > 0 ) {
			$instList = array();

			foreach ( $users as /* EPIRole */ $user ) {
				$instList[] = $user->getUserLink() . $user->getToolLinks( $this->getContext(), $course );
			}

			if ( false ) { // count( $instructors ) == 1
				$html = $instList[0];
			}
			else {
				$html = '<ul><li>' . implode( '</li><li>', $instList ) . '</li></ul>';
			}
		}
		else {
			$html = wfMsgHtml( 'ep-course-no-' . $roleName );
		}

		return Html::rawElement(
			'div',
			array( 'id' => 'ep-course-' . $roleName ),
			$html
		);
	}

	/**
	 * Returns role a controls for the course if the
	 * current user has the right permissions.
	 *
	 * @since 0.1
	 *
	 * @param EPCourse $course
	 * @param string $roleName
	 *
	 * @return string
	 */
	protected function getRoleControls( EPCourse $course, $roleName ) {
		$user = $this->getUser();
		$links = array();

		$field = $roleName === 'instructor' ? 'instructors' : $roleName . '_ambs';
		
		if ( ( $user->isAllowed( 'ep-' . $roleName ) || $user->isAllowed( 'ep-be' . $roleName ) )
			&& !in_array( $user->getId(), $course->getField( $field ) )
		) {
			$links[] = Html::element(
				'a',
				array(
					'href' => '#',
					'class' => 'ep-add-role',
					'data-role' => $roleName,
					'data-courseid' => $course->getId(),
					'data-coursename' => $course->getField( 'name' ),
					'data-mode' => 'self',
				),
				wfMsg( 'ep-course-become-' . $roleName )
			);
		}

		if ( $user->isAllowed( 'ep-' . $roleName ) ) {
			$links[] = Html::element(
				'a',
				array(
					'href' => '#',
					'class' => 'ep-add-role',
					'data-role' => $roleName,
					'data-courseid' => $course->getId(),
					'data-coursename' => $course->getField( 'name' ),
				),
				wfMsg( 'ep-course-add-' . $roleName )
			);
		}

		if ( count( $links ) > 0 ) {
			$this->getOutput()->addModules( 'ep.enlist' );
			return '<br />' . $this->getLanguage()->pipeList( $links );
		}
		else {
			return '';
		}
	}
	
}
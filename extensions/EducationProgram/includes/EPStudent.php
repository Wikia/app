<?php

/**
 * Class representing a single student.
 *
 * @since 0.1
 *
 * @file EPStudent.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EPStudent extends EPRoleObject {

	/**
	 * @see parent::getFieldTypes
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected static function getFieldTypes() {
		return array(
			'id' => 'id',

			'user_id' => 'int',
			'first_enroll' => 'str', // TS_MW

			'last_active' => 'str', // TS_MW
			'active_enroll' => 'bool',
		);
	}

	/**
	 * Display a pager with students.
	 *
	 * @since 0.1
	 *
	 * @param IContextSource $context
	 * @param array $conditions
	 */
	public static function displayPager( IContextSource $context, array $conditions = array() ) {
		$pager = new EPStudentPager( $context, $conditions );

		if ( $pager->getNumRows() ) {
			$context->getOutput()->addHTML(
				$pager->getFilterControl() .
					$pager->getNavigationBar() .
					$pager->getBody() .
					$pager->getNavigationBar() .
					$pager->getMultipleItemControl()
			);
		}
		else {
			$context->getOutput()->addHTML( $pager->getFilterControl( true ) );
			$context->getOutput()->addWikiMsg( 'ep-students-noresults' );
		}
	}

	/**
	 * @since 0.1
	 * @see EPIRole::getRoleName
	 */
	public function getRoleName() {
		return 'student';
	}

	/**
	 * Returns the courses this student is enrolled in.
	 *
	 * @since 0.1
	 *
	 * @param string|array|null $fields
	 * @param array $conditions
	 *
	 * @return array of EPCourse
	 */
	protected function doGetCourses( $fields, array $conditions ) {
		$conditions[] = array( array( 'ep_students', 'id' ), $this->getId() );

		return EPCourse::select(
			$fields,
			$conditions,
			array(),
			array(
				'ep_students_per_course' => array( 'INNER JOIN', array( array( array( 'ep_students_per_course', 'course_id' ), array( 'ep_courses', 'id' ) ) ) ),
				'ep_students' => array( 'INNER JOIN', array( array( array( 'ep_students_per_course', 'student_id' ), array( 'ep_students', 'id' ) ) ) )
			)
		);
	}
	
}

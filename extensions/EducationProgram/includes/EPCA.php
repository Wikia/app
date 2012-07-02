<?php

/**
 * Class representing a single campus ambassador.
 *
 * @since 0.1
 *
 * @file EPCA.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EPCA extends EPRoleObject implements EPIRole {

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
			'bio' => 'str',
			'photo' => 'str',
		);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see EPDBObject::getDefaults()
	 */
	public static function getDefaults() {
		return array(
			'bio' => '',
			'photo' => '',
		);
	}

	/**
	 * Display a pager with campus ambassadors.
	 *
	 * @since 0.1
	 *
	 * @param IContextSource $context
	 * @param array $conditions
	 */
	public static function displayPager( IContextSource $context, array $conditions = array() ) {
		$pager = new EPCAPager( $context, $conditions );

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
			$context->getOutput()->addWikiMsg( 'ep-ca-noresults' );
		}
	}
	
	/**
	 * @since 0.1
	 * @see EPIRole::getRoleName
	 */
	public function getRoleName() {
		return 'campus';
	}
	
	/**
	 * Returns the courses this campus ambassdor is associated with.
	 *
	 * @since 0.1
	 *
	 * @param string|array|null $fields
	 * @param array $conditions
	 *
	 * @return array of EPCourse
	 */
	protected function doGetCourses( $fields, array $conditions ) {
		$conditions[] = array( array( 'ep_cas_per_course', 'user_id' ), $this->getField( 'user_id' ) );

		return EPCourse::select(
			$fields,
			$conditions,
			array(),
			array(
				'ep_cas_per_course' => array( 'INNER JOIN', array( array( array( 'ep_cas_per_course', 'course_id' ), array( 'ep_courses', 'id' ) ) ) ),
			)
		);
	}
	
}

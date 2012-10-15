<?php

/**
 * Class representing a single course.
 *
 * @since 0.1
 *
 * @file EPCourse.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EPCourse extends EPPageObject {

	/**
	 * Field for caching the linked org.
	 *
	 * @since 0.1
	 * @var EPOrg|false
	 */
	protected $org = false;

	/**
	 * Cached array of the linked EPStudent objects.
	 *
	 * @since 0.1
	 * @var array|false
	 */
	protected $students = false;

	/**
	 * Field for caching the instructors.
	 *
	 * @since 0.1
	 * @var {array of EPInstructor}|false
	 */
	protected $instructors = false;
	
	/**
	 * Field for caching the online ambassaords.
	 *
	 * @since 0.1
	 * @var {array of EPOA}|false
	 */
	protected $oas = false;
	
		/**
	 * Field for caching the campus ambassaords.
	 *
	 * @since 0.1
	 * @var {array of EPCA}|false
	 */
	protected $cas = false;

	/**
	 * Returns a list of statuses a term can have.
	 * Keys are messages, values are identifiers.
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public static function getStatuses() {
		return array(
			wfMsg( 'ep-course-status-passed' ) => 'passed',
			wfMsg( 'ep-course-status-current' ) => 'current',
			wfMsg( 'ep-course-status-planned' ) => 'planned',
		);
	}

	/**
	 * Returns the message for the provided status identifier.
	 *
	 * @since 0.1
	 *
	 * @param string $status
	 *
	 * @return string
	 */
	public static function getStatusMessage( $status ) {
		static $map = null;

		if ( is_null( $map ) ) {
			$map = array_flip( self::getStatuses() );
		}

		return $map[$status];
	}

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

			'org_id' => 'int',
			'name' => 'str',
			'start' => 'str', // TS_MW
			'end' => 'str', // TS_MW
			'description' => 'str',
			'token' => 'str',
			'instructors' => 'array',
			'online_ambs' => 'array',
			'campus_ambs' => 'array',
			'field' => 'str',
			'level' => 'str',
			'term' => 'str',
			'lang' => 'str',
			'mc' => 'str',
		
			'students' => 'int',
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see EPDBObject::getDefaults()
	 */
	public static function getDefaults() {
		return array(
			'name' => '',
			'start' => wfTimestamp( TS_MW ),
			'end' => wfTimestamp( TS_MW ),
			'description' => '',
			'token' => '',
			'instructors' => array(),
			'online_ambs' => array(),
			'campus_ambs' => array(),
			'field' => '',
			'level' => '',
			'term' => '',
			'lang' => '',
			'mc' => '',

			'students' => 0,
		);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see EPDBObject::getSummaryFields()
	 */
	public static function getSummaryFields() {
		return array(
			'students',
		);
	}

	/**
	 * Returns the students enrolled in this course.
	 *
	 * @since 0.1
	 *
	 * @param string|array|null $fields
	 * @param array $conditions
	 *
	 * @return array of EPStudent
	 */
	protected function doGetStudents( $fields, array $conditions ) {
		$conditions[] = array( array( 'ep_courses', 'id' ), $this->getId() );

		return EPStudent::select(
			$fields,
			$conditions,
			array(),
			array(
				'ep_students_per_course' => array( 'INNER JOIN', array( array( array( 'ep_students_per_course', 'student_id' ), array( 'ep_students', 'id' ) ) ) ),
				'ep_courses' => array( 'INNER JOIN', array( array( array( 'ep_students_per_course', 'course_id' ), array( 'ep_courses', 'id' ) ) ) )
			)
		);
	}

	/**
	 * Returns the students enrolled in this course.
	 * Caches the result when no conditions are provided and all fields are selected.
	 *
	 * @since 0.1
	 *
	 * @param string|array|null $fields
	 * @param array $conditions
	 *
	 * @return array of EPStudent
	 */
	public function getStudents( $fields = null, array $conditions = array() ) {
		if ( count( $conditions ) !== 0 ) {
			return $this->doGetStudents( $fields, $conditions );
		}

		if ( $this->students === false ) {
			$students = $this->doGetStudents( $fields, $conditions );

			if ( is_null( $fields ) ) {
				$this->students = $students;
			}

			return $students;
		}
		else {
			return $this->students;
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see EPDBObject::loadSummaryFields()
	 */
	public function loadSummaryFields( $summaryFields = null ) {
		if ( is_null( $summaryFields ) ) {
			$summaryFields = array( 'org_id', 'students' );
		}
		else {
			$summaryFields = (array)$summaryFields;
		}

		$fields = array();

		if ( in_array( 'org_id', $summaryFields ) ) {
			$fields['org_id'] = $this->getCourse( 'org_id' )->getField( 'org_id' );
		}
		
		if ( in_array( 'students', $summaryFields ) ) {
			$fields['students'] = wfGetDB( DB_SLAVE )->select(
				'ep_students_per_course',
				'COUNT(*) AS rowcount',
				array( 'spc_course_id' => $this->getId() )
			);

			$fields['students'] = $fields['students']->fetchObject()->rowcount;
		}

		$this->setFields( $fields );
	}

	/**
	 * (non-PHPdoc)
	 * @see EPDBObject::insert()
	 */
	protected function insert() {
		$success = parent::insert();

		if ( $success && $this->updateSummaries ) {
			EPOrg::updateSummaryFields( array( 'courses', 'active' ), array( 'id' => $this->getField( 'org_id' ) ) );
		}

		return $success;
	}

	/**
	 * (non-PHPdoc)
	 * @see EPDBObject::remove()
	 */
	public function remove() {
		$id = $this->getId();

		if ( $this->updateSummaries ) {
			$this->loadFields( array( 'org_id' ) );
			$orgId = $this->getField( 'org_id' );
		}

		$success = parent::remove();

		if ( $success && $this->updateSummaries ) {
			EPOrg::updateSummaryFields( array( 'courses', 'students', 'active', 'instructors', 'oas', 'cas' ), array( 'id' => $orgId ) );
		}

		if ( $success ) {
			$success = wfGetDB( DB_MASTER )->delete( 'ep_students_per_course', array( 'spc_course_id' => $id ) ) && $success;
			$success = wfGetDB( DB_MASTER )->delete( 'ep_cas_per_course', array( 'cpc_course_id' => $id ) ) && $success;
			$success = wfGetDB( DB_MASTER )->delete( 'ep_oas_per_course', array( 'opc_course_id' => $id ) ) && $success;
		}

		return $success;
	}

	/**
	 * (non-PHPdoc)
	 * @see EPDBObject::saveExisting()
	 */
	protected function saveExisting() {
		if ( $this->updateSummaries ) {
			$currentCourse = false;
			$currentFields = array( 'id' );
			
			foreach ( array( 'org_id', 'online_ambs', 'campus_ambs' ) as $field ) {
				if ( $this->hasField( $field ) ) {
					$currentFields[] = $field;
				}
			}
			
			if ( count( $currentFields ) > 1 ) {
				$currentCourse = self::selectRow( $currentFields, array( 'id' => $this->getId() ) );
			}
		}

		$success = parent::saveExisting();

		if ( $this->updateSummaries && $currentCourse !== false && $success ) {
			if ( $currentCourse->hasField( 'org_id' )  && $currentCourse->getField( 'org_id' )  !== $this->getField( 'org_id' ) ) {
				$conds = array( 'id' => array( $currentCourse->getField( 'org_id' ), $this->getField( 'org_id' ) ) );
				EPOrg::updateSummaryFields( array( 'courses', 'students', 'active', 'instructors', 'oas', 'cas' ), $conds );
			}
			
			foreach ( array( 'oas', 'cas' ) as $ambs ) {
				$field = $ambs === 'oas' ? 'online_ambs' : 'campus_ambs';
				
				if ( $currentCourse->hasField( $field )  && $currentCourse->getField( $field ) !== $this->getField( $field ) ) {
					$courseField = $ambs === 'oas' ? 'opc_course_id' : 'cpc_course_id';
					$userField = $ambs === 'oas' ? 'opc_user_id' : 'cpc_user_id';
					$table = 'ep_' . $ambs . '_per_course';
					
					$addedIds = array_diff( $this->getField( $field ), $currentCourse->getField( $field ) );
					$removedIds = array_diff( $currentCourse->getField( $field ), $this->getField( $field ) );

					$dbw = wfGetDB( DB_MASTER );
					
					if ( count( $removedIds ) > 0 ) {
						$dbw->delete( $table, array(
							$courseField => $this->getId(),
							$userField => $removedIds
						) );
					}
					
					$dbw->begin();

					foreach ( $addedIds as $ambassadorId ) {
						$dbw->insert( $table, array(
							$courseField => $this->getId(),
							$userField => $ambassadorId
						) );
					}
					
					$dbw->commit();
				}
			}
		}

		return $success;
	}

	/**
	 * (non-PHPdoc)
	 * @see EPDBObject::save()
	 */
	public function save() {
		if ( $this->hasField( 'name' ) ) {
			$this->setField( 'name', $GLOBALS['wgLang']->ucfirst( $this->getField( 'name' ) ) );
		}

		return parent::save();
	}

	/**
	 * Returns the org associated with this term.
	 *
	 * @since 0.1
	 *
	 * @param string|array|null $fields
	 *
	 * @return EPOrg
	 */
	public function getOrg( $fields = null ) {
		if ( $this->org === false ) {
			$this->org = EPOrg::selectRow( $fields, array( 'id' => $this->loadAndGetField( 'org_id' ) ) );
		}

		return $this->org;
	}

	/**
	 * Display a pager with terms.
	 *
	 * @since 0.1
	 *
	 * @param IContextSource $context
	 * @param array $conditions
	 * @param boolean $readOnlyMode
	 * @param string|false $filterPrefix
	 */
	public static function displayPager( IContextSource $context, array $conditions = array(), $readOnlyMode = false, $filterPrefix = false ) {
		$pager = new EPCoursePager( $context, $conditions, $readOnlyMode );

		if ( $filterPrefix !== false ) {
			$pager->setFilterPrefix( $filterPrefix );
		}
		
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
			$context->getOutput()->addWikiMsg( 'ep-courses-noresults' );
		}
	}

	/**
	 * Adds a control to add a term org to the provided context.
	 * Additional arguments can be provided to set the default values for the control fields.
	 *
	 * @since 0.1
	 *
	 * @param IContextSource $context
	 * @param array $args
	 *
	 * @return boolean
	 */
	public static function displayAddNewControl( IContextSource $context, array $args ) {
		if ( !$context->getUser()->isAllowed( 'ep-course' ) ) {
			return false;
		}

		$out = $context->getOutput();
		
		$out->addModules( 'ep.addcourse' );

		$out->addHTML( Html::openElement(
			'form',
			array(
				'method' => 'post',
				'action' => self::getTitleFor( 'NAME_PLACEHOLDER' )->getLocalURL( array( 'action' => 'edit' ) ),
			)
		) );

		$out->addHTML( '<fieldset>' );

		$out->addHTML( '<legend>' . wfMsgHtml( 'ep-courses-addnew' ) . '</legend>' );

		$out->addElement( 'p', array(), wfMsg( 'ep-courses-namedoc' ) );

		$out->addElement( 'label', array( 'for' => 'neworg' ), wfMsg( 'ep-courses-neworg' ) );

		$select = new XmlSelect(
			'neworg',
			'neworg',
			array_key_exists( 'org', $args ) ? $args['org'] : false
		);

		$select->addOptions( EPOrg::getOrgOptions() );
		$out->addHTML( $select->getHTML() );

		$out->addHTML( '&#160;' . Xml::inputLabel(
			wfMsg( 'ep-courses-newname' ),
			'newname',
			'newname',
			20,
			array_key_exists( 'name', $args ) ? $args['name'] : false
		) );

		$out->addHTML( '&#160;' . Xml::inputLabel(
			wfMsg( 'ep-courses-newterm' ),
			'newterm',
			'newterm',
			10,
			array_key_exists( 'term', $args ) ? $args['term'] : false
		) );

		$out->addHTML( '&#160;' . Html::input(
			'addnewcourse',
			wfMsg( 'ep-courses-add' ),
			'submit',
			array(
				'disabled' => 'disabled',
				'class' => 'ep-course-add',
			)
		) );

		$out->addHTML( Html::hidden( 'isnew', 1 ) );

		$out->addHTML( '</fieldset></form>' );

		return true;
	}

	/**
	 * Adds a control to add a new term to the provided context
	 * or show a message if this is not possible for some reason.
	 *
	 * @since 0.1
	 *
	 * @param IContextSource $context
	 * @param array $args
	 */
	public static function displayAddNewRegion( IContextSource $context, array $args = array() ) {
		if ( EPOrg::has() ) {
			EPCourse::displayAddNewControl( $context, $args );
		}
		elseif ( $context->getUser()->isAllowed( 'ep-course' ) ) {
			$context->getOutput()->addWikiMsg( 'ep-courses-addorgfirst' );
		}
	}

	/**
	 * Gets the amount of days left, rounded up to the nearest integer.
	 *
	 * @since 0.1
	 *
	 * @return integer
	 */
	public function getDaysLeft() {
		$timeLeft = (int)wfTimestamp( TS_UNIX, $this->getField( 'end' ) ) - time();
		return (int)ceil( $timeLeft / ( 60 * 60 * 24 ) );
	}

	/**
	 * Gets the amount of days since term start, rounded up to the nearest integer.
	 *
	 * @since 0.1
	 *
	 * @return integer
	 */
	public function getDaysPassed() {
		$daysPassed = time() - (int)wfTimestamp( TS_UNIX, $this->getField( 'start' ) );
		return (int)ceil( $daysPassed / ( 60 * 60 * 24 ) );
	}

	/**
	 * Returns the status of the course.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getStatus() {
		if ( $this->getDaysLeft() <= 0 ) {
			$status = 'passed';
		}
		elseif ( $this->getDaysPassed() <= 0 ) {
			$status = 'planned';
		}
		else {
			$status = 'current';
		}

		return $status;
	}

	/**
	 * Returns the instructors as a list of EPInstructor objects.
	 *
	 * @since 0.1
	 *
	 * @return array of EPInstructor
	 */
	public function getInstructors() {
		if ( $this->instructors === false ) {
			$this->instructors = array();

			foreach ( $this->getField( 'instructors' ) as $userId ) {
				$this->instructors[] = EPInstructor::newFromUserId( $userId );
			}
		}

		return $this->instructors;
	}
	
	/**
	 * Returns the campus ambassadors as a list of EPCA objects.
	 *
	 * @since 0.1
	 *
	 * @return array of EPCA
	 */
	public function getCampusAmbassadors() {
		if ( $this->cas === false ) {
			$this->cas = array();

			foreach ( $this->getField( 'campus_ambs' ) as $userId ) {
				$this->cas[] = EPCA::newFromUserId( $userId );
			}
		}

		return $this->cas;
	}
	
	/**
	 * Returns the online ambassadors as a list of EPOA objects.
	 *
	 * @since 0.1
	 *
	 * @return array of EPOA
	 */
	public function getOnlineAmbassadors() {
		if ( $this->oas === false ) {
			$this->oas = array();

			foreach ( $this->getField( 'online_ambs' ) as $userId ) {
				$this->oas[] = EPOA::newFromUserId( $userId );
			}
		}

		return $this->oas;
	}
	
	/**
	 * Returns the users that have a certain role as list of EPIRole objects.
	 * 
	 * @since 0.1
	 * 
	 * @param string $roleName
	 * 
	 * @return array of EPIRole
	 * @throws MWException
	 */
	public function getUserWithRole( $roleName ) {
		switch ( $roleName ) {
			case 'instructor':
				return $this->getInstructors();
				break;
			case 'online':
				return $this->getOnlineAmbassadors();
				break;
			case 'campus':
				return $this->getCampusAmbassadors();
				break;
		}
		
		throw new MWException( 'Invalid role name: ' . $roleName );
	}

	/**
	 * (non-PHPdoc)
	 * @see EPDBObject::setField()
	 */
	public function setField( $name, $value ) {
		if ( $name === 'instructors' ) {
			$this->instructors = false;
		}

		parent::setField( $name, $value );
	}

	/**
	 * Adds a role for a number of users to this course,
	 * by default also saving the course and only
	 * logging the adittion of the users/roles.
	 *
	 * @since 0.1
	 *
	 * @param array|integer $newUsers
	 * @param string $role
	 * @param string $message
	 * @param boolean $save
	 * @param boolean $log
	 *
	 * @return boolean Success indicator
	 */
	public function enlistUsers( $newUsers, $role, $message = '', $save = true, $log = true ) {
		$field = $role === 'instructor' ? 'instructors' : $role . '_ambs'; 
		$users = $this->getField( $field );
		$addedUsers = array();

		foreach ( (array)$newUsers as $userId ) {
			if ( !is_integer( $userId ) ) {
				throw new MWException( 'Provided user id is not an integer' );
			}
			
			if ( !in_array( $userId, $users ) ) {
				$users[] = $userId;
				$addedUsers[] = $userId;
			}
		}

		if ( count( $addedUsers ) > 0 ) {
			$this->setField( $field, $users );

			$success = true;

			if ( $save ) {
				$this->disableLogging();
				$success = $this->save();
				$this->enableLogging();
			}

			if ( $success && $log ) {
				$this->logRoleChange( 'add', $role, $addedUsers, $message );
			}

			return $success;
		}
		else {
			return true;
		}
	}

	/**
	 * Remove the role for a number of users for this course,
	 * by default also saving the course and only
	 * logging the role changes.
	 *
	 * @since 0.1
	 *
	 * @param array|integer $sadUsers
	 * @param string $role
	 * @param string $message
	 * @param boolean $save
	 * @param boolean $log
	 *
	 * @return boolean Success indicator
	 */
	public function unenlistUsers( $sadUsers, $role, $message = '', $save = true, $log = true ) {
		$removedUser = array();
		$remaimingUsers = array();
		$sadUsers = (array)$sadUsers;

		$field = $role === 'instructor' ? 'instructors' : $role . '_ambs'; 
		
		foreach ( $this->getField( $field ) as $userId ) {
			if ( in_array( $userId, $sadUsers ) ) {
				$removedUser[] = $userId;
			}
			else {
				$remaimingUsers[] = $userId;
			}
		}

		if ( count( $removedUser ) > 0 ) {
			$this->setField( $field, $remaimingUsers );

			$success = true;

			if ( $save ) {
				$this->disableLogging();
				$success = $this->save();
				$this->enableLogging();
			}

			if ( $success && $log ) {
				$this->logRoleChange( 'remove', $role, $removedUser, $message );
			}

			return $success;
		}
		else {
			return true;
		}
	}

	/**
	 * Log a change of the instructors of the course.
	 *
	 * @since 0.1
	 *
	 * @param string $action
	 * @param string $role
	 * @param array $users
	 * @param string $message
	 */
	protected function logRoleChange( $action, $role, array $users, $message ) {
		$names = array();

		$classes = array(
			'instructor' => 'EPInstructor',
			'campus' => 'EPCA',
			'online' => 'EPOA',
		);
		
		$class = $classes[$role];
		
		foreach ( $users as $userId ) {
			$names[] = $class::newFromUserId( $userId )->getName();
		}

		$info = array(
			'type' => $role,
			'subtype' => $action,
			'title' => $this->getTitle(),
			'parameters' => array(
				'4::instructorcount' => count( $names ),
				'5::instructors' => $GLOBALS['wgLang']->listToText( $names )
			),
		);

		if ( $message !== '' ) {
			$info['comment'] = $message;
		}

		EPUtils::log( $info );
	}
	
}

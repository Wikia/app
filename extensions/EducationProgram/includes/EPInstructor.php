<?php

/**
 * Class representing a single instructor.
 *
 * @since 0.1
 *
 * @file EPInstructor.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EPInstructor extends EPRoleObject implements EPIRole {

	/**
	 * Field for caching the linked user.
	 *
	 * @since 0.1
	 * @var User|false
	 */
	protected $user = false;

	/**
	 * Holds the user id if only an id was provided.
	 * 
	 * @since 0.1
	 * @var integer
	 */
	protected $userId;
	
	/**
	 * Create a new instructor object from a user id.
	 * 
	 * @since 0.1
	 * 
	 * @param integer $userId
	 * @param null|array|string $fields
	 * 
	 * @return EPInstructor
	 */
	public static function newFromUserId( $userId, $fields = null ) {
		return new self( $userId );
	}
	
	/**
	 * Create a new instructor object from a User object.
	 * 
	 * @since 0.1
	 * 
	 * @param User $user
	 * @param null|array|string $fields
	 * 
	 * @return EPInstructor
	 */
	public static function newFromUser( User $user, $fields = null ) {
		return new self( $user );
	}
	
	/**
	 * Constructor.
	 * 
	 * @since 0.1
	 * 
	 * @param User|integer $user
	 */
	public function __construct( $user ) {
		if ( is_integer( $user ) ) {
			$this->userId = $user;
		}
		elseif ( $user instanceof User ) {
			$this->user = $user;
		}
		else {
			throw new MWException( 'Instructors can only be constructed from an user id or an User object.' );
		}
	}
	
	/**
	 * Returns the user that this instructor is.
	 * 
	 * @since 0.1
	 * 
	 * @return User
	 */
	public function getUser() {
		if ( $this->user === false ) {
			$this->user = User::newFromId( $this->userId );
		}
		
		return $this->user;
	}
	
	/**
	 * Returns the name of the instroctor, using their real name when available.
	 * 
	 * @since 0.1
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->getUser()->getRealName() === '' ? $this->getUser()->getName() : $this->getUser()->getRealName();
	}
	
	/**
	 * Retruns the user link for this instructor, using their real name when available.
	 * 
	 * @since 0.1
	 * 
	 * @return string
	 */
	public function getUserLink() {
		return Linker::userLink(
			$this->getUser()->getId(),
			$this->getUser()->getName(),
			$this->getName()
		);
	}
	
	/**
	 * Returns the tool links for this mentor.
	 * 
	 * @since 0.1
	 * 
	 * @param IContextSource $context
	 * @param EPCourse|null $course
	 * 
	 * @return string
	 */
	public function getToolLinks( IContextSource $context, EPCourse $course = null ) {
		return EPUtils::getRoleToolLinks( $this, $context, $course );
	}
	
	/**
	 * @since 0.1
	 * @see EPIRole::getRoleName
	 */
	public function getRoleName() {
		return 'instructor';
	}

	/**
	 * Not implemented as we do not need this, so no need for having it in the
	 * db in a way we can efficiently query this. If needed at some point,
	 * most stuff is in place already since the ambassador stuff is similar.
	 *
	 * @since 0.1
	 *
	 * @param string|array|null $fields
	 * @param array $conditions
	 *
	 * @return array of EPCourse
	 */
	protected function doGetCourses( $fields, array $conditions ) {
		throw new MWException( 'doGetCourses is not implemented by EPInstructor' );
	}
	
}

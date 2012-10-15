<?php

/**
 * Class representing a single revision.
 *
 * @since 0.1
 *
 * @file EPRevision.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EPRevision extends EPDBObject {

	/**
	 * Cached user object for this revision.
	 *
	 * @since 0.1
	 * @var User|false
	 */
	protected $user = false;


	/**
	 * @see parent::__construct
	 *
	 * @since 0.1
	 *
	 * @param array|null $fields
	 * @param bool $loadDefaults
	 */
	public function __construct( $fields = null, $loadDefaults = false ) {
		parent::__construct( $fields, $loadDefaults );
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

			'object_id' => 'int',
			'object_identifier' => 'str',
			'user_id' => 'int',
			'type' => 'str',
			'comment' => 'str',
			'user_text' => 'str',
			'minor_edit' => 'bool',
			'time' => 'str', // TS_MW
			'deleted' => 'bool',
			'data' => 'blob',
		);
	}

	/**
	 * Create a new revision object for the provided EPRevisionedObject.
	 * The EPRevisionedObject should have all it's fields loaded.
	 *
	 * @since 0.1
	 *
	 * @param EPDBObject $object
	 * @param EPRevisionAction $revAction
	 *
	 * @return EPRevision
	 */
	public static function newFromObject( EPRevisionedObject $object, EPRevisionAction $revAction ) {
		$fields = array(
			'object_id' => $object->getId(),
			'user_id' => $revAction->getUser()->getID(),
			'user_text' => $revAction->getUser()->getName(),
			'type' => get_class( $object ),
			'comment' => $revAction->getComment(),
			'minor_edit' => $revAction->isMinor(),
			'time' => $revAction->getTime(),
			'deleted' => $revAction->isDelete(),
			'data' => serialize( $object->toArray() )
		);
		
		$identifier = $object->getIdentifier();
		
		if ( !is_null( $identifier ) ) {
			$fields['object_identifier'] = $identifier;
		}

		return new static( $fields );
	}

	/**
	 * Return the object as it was at this revision.
	 *
	 * @since 0,1
	 *
	 * @return EPRevisionedObject
	 */
	public function getObject() {
		$class = $this->getField( 'type' );
		return $class::newFromArray( $this->getField( 'data' ), true );
	}

	/**
	 * Returns the the object stored in the revision with the provided id,
	 * or false if there is no matching object.
	 *
	 * @since 0.1
	 *
	 * @param integer $revId
	 * @param integer|null $objectId
	 *
	 * @return EPRevisionedObject|false
	 */
	public static function getObjectFromRevId( $revId, $objectId = null ) {
		$conditions = array(
			'id' => $revId
		);

		if ( !is_null( $objectId ) ) {
			$conditions['object_id'] = $objectId;
		}

		$rev = EPRevision::selectRow( array( 'type', 'data' ), $conditions );

		if ( $rev === false ) {
			return false;
		}
		else {
			return $rev->getDataObject();
		}
	}

	/**
	 * Returns the user that authored this revision.
	 *
	 * @since 0.1
	 *
	 * @return User
	 */
	public function getUser() {
		if ( $this->user === false ) {
			$this->user = User::newFromId( $this->loadAndGetField( 'user_id' ) );
		}

		return $this->user;
	}

}

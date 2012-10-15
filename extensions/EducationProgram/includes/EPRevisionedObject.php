<?php

/**
 * Abstract base class for EPDBObjects with revision history and logging support.
 *
 * @since 0.1
 *
 * @file EPRevisionedObject.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class EPRevisionedObject extends EPDBObject {
	
	/**
	 * If the object should log changes.
	 * Can be changed via disableLogging and enableLogging.
	 *
	 * @since 0.1
	 * @var bool
	 */
	protected $log = true;

	/**
	 * If the object should store old revisions.
	 *
	 * @since 0.1
	 * @var bool
	 */
	protected $storeRevisions = true;

	/**
	 *
	 * @since 0.1
	 * @var EPRevisionAction|false
	 */
	protected $revAction = false;

	/**
	 * Sets the revision action.
	 *
	 * @since 0.1
	 *
	 * @param EPRevisionAction|false $revAction
	 */
	protected function setRevisionAction( $revAction ) {
		$this->revAction = $revAction;
	}

	/**
	 * Sets the value for the @see $storeRevisions field.
	 *
	 * @since 0.1
	 *
	 * @param boolean $store
	 */
	public function setStoreRevisions( $store ) {
		$this->storeRevisions = $store;
	}

	/**
	 * Sets the value for the @see $log field.
	 *
	 * @since 0.1
	 */
	public function enableLogging() {
		$this->log = true;
	}

	/**
	 * Sets the value for the @see $log field.
	 *
	 * @since 0.1
	 */
	public function disableLogging() {
		$this->log = false;
	}
	
	/**
	 * Returns the info for the log entry or false if no entry should be created.
	 *
	 * @since 0.1
	 *
	 * @param string $subType
	 *
	 * @return array|false
	 */
	protected function getLogInfo( $subType ) {
		return false;
	}
	
	/**
	 * Store the current version of the object in the revisions table.
	 *
	 * @since 0.1
	 *
	 * @param EPRevisionedObject $object
	 *
	 * @return boolean Success indicator
	 */
	protected function storeRevision( EPRevisionedObject $object ) {
		if ( $this->storeRevisions && $this->revAction !== false ) {
			return EPRevision::newFromObject( $object, $this->revAction )->save();
		}

		return true;
	}
	
	/**
	 * Log an action.
	 *
	 * @since 0.1
	 *
	 * @param string $subType
	 */
	protected function log( $subType ) {
		if ( $this->log ) {
			$info = $this->getLogInfo( $subType );

			if ( $info !== false ) {
				if ( $this->revAction !== false ) {
					$info['user'] = $this->revAction->getUser();
					$info['comment'] = $this->revAction->getComment();
				}

				$info['subtype'] = $subType;
				EPUtils::log( $info );
			}
		}
	}
	
	/**
	 * Return if any fields got changed.
	 * 
	 * @since 0.1
	 * 
	 * @param EPRevisionedObject $revision
	 * @param boolean $excludeSummaryFields When set to true, summaty field changes are ignored.
	 * 
	 * @return boolean
	 */
	protected function fieldsChanged( EPRevisionedObject $revision, $excludeSummaryFields = false ) {
		foreach ( $this->fields as $name => $value ) {
			$excluded = $excludeSummaryFields && in_array( $name, $this->getSummaryFields() );
			
			if ( !$excluded && $revision->getField( $name ) !== $value ) {
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see EPDBObject::saveExisting()
	 */
	protected function saveExisting() {
		if ( !$this->inSummaryMode ) {
			static::setReadDb( DB_MASTER );
			$currentObject = static::selectRow( null, array( 'id' => $this->getId() ) );
			static::setReadDb( DB_SLAVE );
		}
		
		$success = parent::saveExisting();

		if ( $success && !$this->inSummaryMode ) {
			if ( $this->fieldsChanged( $currentObject, true ) ) {
				$this->storeRevision( $currentObject );
				$this->log( 'update' );
			}
		}

		return $success;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see EPDBObject::insert()
	 */
	protected function insert() {
		$result = parent::insert();

		if ( $result ) {
			$this->storeRevision( $this );
			$this->log( 'add' );
		}

		return $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see EPDBObject::remove()
	 */
	public function remove() {
		$object = clone $this;
		$object->loadFields();
		
		$success = parent::remove();

		if ( $success ) {
			$object->onRemoved();
		}

		return $success;
	}

	/**
	 * @since 0.1
	 * 
	 * @param EPRevisionAction $revAction
	 */
	public function handleRemoved( EPRevisionAction $revAction ) {
		$this->setRevisionAction( $revAction );
		$this->onRemoved();
	}
	
	/**
	 * Do logging and revision storage after a removal.
	 * The object needs to have all it's fields loaded.
	 * 
	 * @since 0.1
	 */
	protected function onRemoved() {
		$this->storeRevision( $this );
		$this->log( 'remove' );
	}
	
	public function getIdentifier() {
		return null;
	}
	
	/**
	 * Save the object using the provided revision action info for logging and revision storage.
	 * PHP does not support method overloading, else this would be just "save" :/
	 * 
	 * @since 0.1
	 * 
	 * @param EPRevisionAction $revAction
	 * 
	 * @return boolean Success indicator
	 */
	public function revisionedSave( EPRevisionAction $revAction ) {
		$this->setRevisionAction( $revAction );
		$success = $this->save();
		$this->setRevisionAction( false );
		return $success;
	}
	
	/**
	 * Remove the object using the provided revision action info for logging and revision storage.
	 * PHP does not support method overloading, else this would be just "remove" :/
	 * 
	 * @since 0.1
	 * 
	 * @param EPRevisionAction $revAction
	 * 
	 * @return boolean Success indicator
	 */
	public function revisionedRemove( EPRevisionAction $revAction ) {
		$this->setRevisionAction( $revAction );
		$success =  $this->remove();
		$this->setRevisionAction( false );
		return $success;
	}
	
}
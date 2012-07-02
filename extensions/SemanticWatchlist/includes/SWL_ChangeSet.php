<?php

/**
 * 
 * 
 * @since 0.1
 * 
 * @file SWL_ChangeSet.php
 * @ingroup SemanticWatchlist
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SWLChangeSet {
	
	/**
	 * The subject the changes apply to.
	 * 
	 * @var SMWDIWikiPage
	 */
	protected $subject;
	
	/**
	 * Object holding semantic data that got inserted.
	 * 
	 * @var SMWSemanticData
	 */
	protected $insertions;
	
	/**
	 * Object holding semantic data that got deleted.
	 * 
	 * @var SMWSemanticData
	 */	
	protected $deletions;
	
	/**
	 * List of all changes(, not including insertions and deletions).
	 * 
	 * @var SWLPropertyChanges
	 */
	protected $changes;
	
	/**
	 * DB ID of the change set (swl_sets.set_id).
	 * 
	 * @var integer
	 */
	protected $id;
	
	/**
	 * The title of the page the changeset holds changes for.
	 * The title will be constructed from the subject of the SMWChangeSet
	 * the first time getTitle is called, so it should be accessed via this
	 * method.
	 * 
	 * @var Title or false
	 */
	protected $title = false;
	
	/**
	 * The edit this set of changes belongs to.
	 * 
	 * @var SWLEdit
	 */
	protected $edit;
	
	/**
	 * Creates and returns a new SWLChangeSet instance from a database result
	 * obtained by doing a select on swl_sets. 
	 * 
	 * @since 0.1
	 * 
	 * @param $set
	 * 
	 * @return SWLChangeSet
	 */
	public static function newFromDBResult( $set ) {
		$changeSet = new SWLChangeSet(
			SMWDIWikiPage::newFromTitle( Title::newFromID( $set->edit_page_id ) ),
			null,
			null,
			null,
			$set->spe_set_id,
			new SWLEdit(
				$set->edit_page_id,
				$set->edit_user_name,
				$set->edit_time,
				$set->edit_id
			)
		);
		
		$dbr = wfGetDb( DB_SLAVE );
		
		$changes = $dbr->select(
			'swl_changes',
			array(
				'change_id',
				'change_property',
				'change_old_value',
				'change_new_value'
			),
			array(
				'change_set_id' => $set->spe_set_id
			)
		);
		
		foreach ( $changes as $change ) {
			$property = SMWDIProperty::doUnserialize( $change->change_property, '__pro' );
			
			$changeSet->addChange(
				$property,
				SWLPropertyChange::newFromSerialization( $property, $change->change_old_value, $change->change_new_value )
			);
		}	
		
		return $changeSet;
	}
	
	/**
	 * Creates and returns a new SWLChangeSet instance from a database result
	 * obtained by doing a select on swl_sets. 
	 * 
	 * @since 0.1
	 * 
	 * @param array $changeSetArray
	 * 
	 * @return SWLChangeSet
	 */
	public static function newFromArray( array $changeSetArray ) {
		$changeSet = new SWLChangeSet(
			SMWDIWikiPage::newFromTitle( Title::newFromID( $changeSetArray['page_id'] ) ),
			null,
			null,
			null,
			$changeSetArray['id'],
			new SWLEdit(
				$changeSetArray['page_id'],
				$changeSetArray['user_name'],
				$changeSetArray['time'],
				$changeSetArray['editid']
			)
		);

		foreach ( $changeSetArray['changes'] as $propName => $changes ) {
			$property = SMWDIProperty::doUnserialize( $propName, '__pro' );

			foreach ( $changes as $change ) {
				$changeSet->addChange(
					$property,
					SWLPropertyChange::newFromSerialization(
						$property,
						array_key_exists( 'old', $change ) ? $change['old'] : null,
						array_key_exists( 'new', $change ) ? $change['new'] : null
					)
				);					
			}
		}		

		return $changeSet;
	}
	
	/**
	 * Creates and returns a new SMWChangeSet from 2 SMWSemanticData objects.
	 * 
	 * @param SMWSemanticData $old
	 * @param SMWSemanticData $new
	 * @param array $filterProperties Optional list of properties (string serializations) to filter on. Null for no filtering.
	 * 
	 * @return SMWChangeSet
	 */
	public static function newFromSemanticData( SMWSemanticData $old, SMWSemanticData $new, array $filterProperties = null ) {
		$subject = $old->getSubject();
		
		if ( $subject != $new->getSubject() ) {
			return new self( $subject );
		}
		
		$changes = new SWLPropertyChanges();
		$insertions = new SMWSemanticData( $subject );
		$deletions = new SMWSemanticData( $subject );
		
		$oldProperties = array();
		$newProperties = array();
		
		foreach ( $old->getProperties() as $property ) {
			if ( is_null( $filterProperties ) || in_array( $property->getLabel(), $filterProperties ) ) {
				$oldProperties[] = $property;
			}
		}
		
		foreach ( $new->getProperties() as $property ) {
			if ( is_null( $filterProperties ) || in_array( $property->getLabel(), $filterProperties ) ) {
				$newProperties[] = $property;
			}
		}
		
		// Find the deletions.
		self::findSingleDirectionChanges( $deletions, $oldProperties, $old, $newProperties, $filterProperties );
		
		// Find the insertions.
		self::findSingleDirectionChanges( $insertions, $newProperties, $new, $oldProperties, $filterProperties );
		
		foreach ( $oldProperties as $propertyKey => /* SMWDIProperty */ $diProperty ) {
			$oldDataItems = array();
			$newDataItems = array();
			
			// Populate the data item arrays using keys that are their hash, so matches can be found.
			// Note: this code assumes there are no duplicates.
			foreach ( $old->getPropertyValues( $diProperty ) as /* SMWDataItem */ $dataItem ) {
				$oldDataItems[$dataItem->getHash()] = $dataItem;
			}
			foreach ( $new->getPropertyValues( $diProperty ) as /* SMWDataItem */ $dataItem ) {
				$newDataItems[$dataItem->getHash()] = $dataItem;
			}			
			
			$foundMatches = array();
			
			// Find values that are both in the old and new version.
			foreach ( array_keys( $oldDataItems ) as $hash ) {
				if ( array_key_exists( $hash, $newDataItems ) ) {
					$foundMatches[] = $hash;
				}
			}
			
			// Remove the values occuring in both sets, so only changes remain.
			foreach ( $foundMatches as $foundMatch ) {
				unset( $oldDataItems[$foundMatch] );
				unset( $newDataItems[$foundMatch] );
			}
			
			// Find which group is biggest, so it's easy to loop over all values of the smallest.
			$oldIsBigger = count( $oldDataItems ) > count ( $newDataItems );
			$bigGroup = $oldIsBigger ? $oldDataItems : $newDataItems;
			$smallGroup = $oldIsBigger ? $newDataItems : $oldDataItems;
			
			// Add all one-to-one changes.
			while ( $dataItem = array_shift( $smallGroup ) ) {
				$changes->addPropertyObjectChange( $diProperty, new SWLPropertyChange( $dataItem, array_shift( $bigGroup ) ) );
			}
			
			// If the bigger group is not-equal to the smaller one, items will be left,
			// that are either insertions or deletions, depending on the group.
			if ( count( $bigGroup > 0 ) ) {
				$semanticData = $oldIsBigger ? $deletions : $insertions;
				
				foreach ( $bigGroup as /* SMWDataItem */ $dataItem ) {
					$semanticData->addPropertyObjectValue( $diProperty, $dataItem );
				}				
			}
		}
		
		return new self( $subject, $changes, $insertions, $deletions );
	}
	
	/**
	 * Finds the inserts or deletions and adds them to the passed SMWSemanticData object.
	 * These values will also be removed from the first list of properties and their values,
	 * so it can be used for one-to-one change finding later on.  
	 * 
	 * @param SMWSemanticData $changeSet
	 * @param array $oldProperties
	 * @param SMWSemanticData $oldData
	 * @param array $newProperties
	 */
	protected static function findSingleDirectionChanges( SMWSemanticData &$changeSet,
		array &$oldProperties, SMWSemanticData $oldData, array $newProperties ) {
		
		$deletionKeys = array();
		
		foreach ( $oldProperties as $propertyKey => /* SMWDIProperty */ $diProperty ) {
			if ( !array_key_exists( $propertyKey, $newProperties ) ) {
				foreach ( $oldData->getPropertyValues( $diProperty ) as /* SMWDataItem */ $dataItem ) {
					$changeSet->addPropertyObjectValue( $diProperty, $dataItem );
				}
				$deletionKeys[] = $propertyKey;
			}
		}
		
		foreach ( $deletionKeys as $key ) {
			unset( $oldProperties[$propertyKey] );
		}
	}
	
	/**
	 * Create a new instance of a change set.
	 * 
	 * @param SMWDIWikiPage $subject
	 * @param SWLPropertyChanges $changes Can be null
	 * @param SMWSemanticData $insertions Can be null
	 * @param SMWSemanticData $deletions Can be null
	 * @param integer $id Can be null
	 * @param SWLEdit $edit Can be null
	 */
	public function __construct( SMWDIWikiPage $subject, /* SWLPropertyChanges */ $changes = null,
		/* SMWSemanticData */ $insertions = null, /* SMWSemanticData */ $deletions = null,
		$id = null, /* SWLEdit */ $edit = null ) {
	
		$this->subject = $subject;
		$this->changes = is_null( $changes ) ? new SWLPropertyChanges() : $changes;
		$this->insertions = is_null( $insertions ) ? new SMWSemanticData( $subject ): $insertions;
		$this->deletions = is_null( $deletions ) ? new SMWSemanticData( $subject ): $deletions;
		
		$this->id = $id;
		$this->edit = $edit;
	}
	
	/**
	 * Rteurns if the change set contains (changes for) user defined properties.
	 * 
	 * @since 0.1
	 * 
	 * @return boolean
	 */
	public function hasUserDefinedProperties() {
		$properties = array();
		
		foreach ( $this->getAllProperties() as /* SMWDIProperty */ $property ) {
			if ( $property->isUserDefined() ) {
				$properties[] = $property;
			}
		}
		
		return count( $properties ) != 0;
	}
	
	/**
	 * Returns whether the set contains any changes.
	 * 
	 * @since 0.1
	 * 
	 * @return boolean
	 */
	public function hasChanges() {
		return $this->changes->hasChanges()
			|| $this->insertions->hasVisibleProperties()
			|| $this->deletions->hasVisibleProperties();
	}
	
	/**
	 * Returns a SMWSemanticData object holding all inserted SMWDataItem objects.
	 * 
	 * @return SMWSemanticData
	 */
	public function getInsertions() {
		return $this->insertions;
	}
	
	/**
	 * Returns a SMWSemanticData object holding all deleted SMWDataItem objects.
	 * 
	 * @return SMWSemanticData
	 */
	public function getDeletions() {
		return $this->deletions;
	}
	
	/**
	 * Returns a SWLPropertyChanges object holding all SWLPropertyChange objects.
	 * 
	 * @return SWLPropertyChanges
	 */	
	public function getChanges() {
		return $this->changes;
	}
	
	/**
	 * Returns the subject these changes apply to.
	 * 
	 * @return SMWDIWikiPage
	 */
	public function getSubject() {
		return $this->subject;		
	}
	
	/**
	 * Adds a SWLPropertyChange to the set for the specified SMWDIProperty.
	 * 
	 * @since 0.1
	 * 
	 * @param SMWDIProperty $property
	 * @param SWLPropertyChange $change
	 */
	public function addChange( SMWDIProperty $property, SWLPropertyChange $change ) {
		switch ( $change->getType() ) {
			case SWLPropertyChange::TYPE_UPDATE:
				$this->changes->addPropertyObjectChange( $property, $change );
				break;
			case SWLPropertyChange::TYPE_INSERT:
				$this->addInsertion( $property, $change->getNewValue() );
				break;
			case SWLPropertyChange::TYPE_DELETE:
				$this->addDeletion(  $property, $change->getOldValue()  );
				break;
		}
	}
	
	/**
	 * Adds a SMWDataItem representing an insertion to the set for the specified SMWDIProperty.
	 * 
	 * @since 0.1
	 * 
	 * @param SMWDIProperty $property
	 * @param SMWDataItem $dataItem
	 */
	public function addInsertion( SMWDIProperty $property, SMWDataItem $dataItem ) {
		$this->insertions->addPropertyObjectValue( $property, $dataItem );
	}
	
	/**
	 * Adds a SMWDataItem representing a deletion to the set for the specified SMWDIProperty.
	 * 
	 * @since 0.1
	 * 
	 * @param SMWDIProperty $property
	 * @param SMWDataItem $dataItem
	 */
	public function addDeletion( SMWDIProperty $property, SMWDataItem $dataItem ) {
		$this->deletions->addPropertyObjectValue( $property, $dataItem );
	}
	
	/**
	 * Returns a list of all properties.
	 * 
	 * @return array of SMWDIProperty
	 */
	public function getAllProperties() {
		return array_merge(
			$this->getChanges()->getProperties(),
			$this->getInsertions()->getProperties(),
			$this->getDeletions()->getProperties()
		);
	}
	
	/**
	 * Removes all changes for a certian property.
	 * 
	 * @param SMWDIProperty $property
	 */
	public function removeChangesForProperty( SMWDIProperty $property ) {
		$this->getChanges()->removeChangesForProperty( $property );
		$this->getInsertions()->removeDataForProperty( $property );
		$this->getDeletions()->removeDataForProperty( $property );
	}
	
	/**
	 * Returns a list of ALL changes, including isertions and deletions.
	 * 
	 * @param SMWDIProperty $proprety
	 * 
	 * @return array of SWLPropertyChange
	 */
	public function getAllPropertyChanges( SMWDIProperty $property ) {
		$changes = array();
		
		foreach ( $this->changes->getPropertyChanges( $property ) as /* SWLPropertyChange */ $change ) {
			$changes[] = $change;
		}
		
		foreach ( $this->insertions->getPropertyValues( $property ) as /* SMWDataItem */ $dataItem ) {
			$changes[] = new SWLPropertyChange( null, $dataItem );
		}

		foreach ( $this->deletions->getPropertyValues( $property ) as /* SMWDataItem */ $dataItem ) {
			$changes[] = new SWLPropertyChange( $dataItem, null );
		}			
		
		return $changes;
	}
	
	/**
	 * Serializes the object as an associative array, which can be passed
	 * to newFromArray to create a new instance.
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */
	public function toArray() {
 		$changeSet = array(
			'id' => $this->id,
			'user_name' => $this->edit->getUserName(),
			'page_id' => $this->edit->getPageID(),
			'time' => $this->edit->getTime(),
 			'editid' => $this->edit->getId(),
 			'changes' => array()
		);
		
		foreach ( $this->getAllProperties() as /* SMWDIProperty */ $property ) {
			$propChanges = array();
			
			foreach ( $this->getAllPropertyChanges( $property ) as /* SWLPropertyChange */ $change ) {
				$propChange = array();
				
				if ( is_object( $change->getOldValue() ) ) {
					$propChange['old'] = $change->getOldValue()->getSerialization();
				}
				
				if ( is_object( $change->getNewValue() ) ) {
					$propChange['new'] = $change->getNewValue()->getSerialization();
				}

				$propChanges[] = $propChange;
			}
			
			$changeSet['changes'][$property->getSerialization()] = $propChanges;
		}
		
		return $changeSet;
	}
	
	/**
	 * Save the change set to the database.
	 * 
	 * @since 0.1
	 * 
	 * @param array of SWLGroup
	 * @param integer $editId
	 * 
	 * @return integer ID of the inserted row (0 if nothing was inserted).
	 */
	public function writeToStore( array $groupsToAssociate, $editId ) {
		if ( !$this->hasUserDefinedProperties() ) {
			return 0;
		}
		
		wfRunHooks( 'SWLBeforeChangeSetInsert', array( &$this, &$groupsToAssociate, &$editId ) );
		
		$dbw = wfGetDB( DB_MASTER );
		
		$dbw->insert(
			'swl_sets',
			array( 'set_id' => null )
		);
		
		$id = $dbw->insertId();
		
		$dbw->insert(
			'swl_sets_per_edit',
			array(
				'spe_set_id' => $id,
				'spe_edit_id' => $editId
			)
		);
		
		$changes = array();
		
		foreach ( $this->getAllProperties() as /* SMWDIProperty */ $property ) {
			if ( $property->isUserDefined() ) {
				$propSerialization = $property->getSerialization();
			
				foreach ( $this->getChanges()->getPropertyChanges( $property ) as /* SWLPropertyChange */ $change ) {
					$changes[] = array(
						'property' => $propSerialization,
						'old' => $change->getOldValue()->getSerialization(),
						'new' => $change->getNewValue()->getSerialization()
					);
				}

				foreach ( $this->getInsertions()->getPropertyValues( $property ) as /* SMWDataItem */ $dataItem ) {
					$changes[] = array(
						'property' => $propSerialization,
						'old' => null,
						'new' => $dataItem->getSerialization()
					);
				}

				foreach ( $this->getDeletions()->getPropertyValues( $property ) as /* SMWDataItem */ $dataItem ) {
					$changes[] = array(
						'property' => $propSerialization,
						'old' => $dataItem->getSerialization(),
						'new' => null
					);
				}				
			}
		}
		
		$dbw->begin();
		
		foreach ( $changes as $change ) {
			if ( $change['property'] == '' ) {
				// When removing the last value for a property of a page,
				// for some reason it gets inserted for a property without
				// name, so skip that. Better to fix higher up though.
				continue;
			}
			
			$dbw->insert(
				'swl_changes',
				array(
					'change_set_id' => $id,
					'change_property' => $change['property'],
					'change_old_value' => $change['old'],
					'change_new_value' => $change['new']
				)
			);			
		}
		
		foreach ( $groupsToAssociate as /* SWLGroup */ $group ) {
			$dbw->insert(
				'swl_sets_per_group',
				array(
					'spg_group_id' => $group->getId(),
					'spg_set_id' => $id
				)
			);
		}
		
		$dbw->commit();
		
		wfRunHooks( 'SWLAfterChangeSetInsert', array( &$this, $groupsToAssociate, $editId ) );
		
		return $id;
	}
	
	/**
	 * Gets the title of the page these changes belong to.
	 * 
	 * @since 0.1
	 * 
	 * @return Title
	 */
	public function getTitle() {
		if ( $this->title === false ) {
			$this->title = Title::makeTitle( $this->getSubject()->getNamespace(), $this->getSubject()->getDBkey() );
		}
		
		return $this->title;
	}
	
	/**
	 * Gets the edit this set of changes belong to.
	 * 
	 * @since 0.1
	 * 
	 * @return SWLEdit
	 */
	public function getEdit() {
		return $this->edit;
	}
	
	/**
	 * Sets the edit this set of changes belong to.
	 * 
	 * @since 0.1
	 * 
	 * @param SWLEdit $edit
	 */
	public function setEdit( SWLEdit $edit ) {
		$this->edit = $edit;
	}
	
	/**
	 * Returns if a certain insertion is present in the set of changes.
	 * 
	 * @since 0.1
	 * 
	 * @param SMWDIProperty $property
	 * @param string $value
	 * 
	 * @return boolean
	 */
	public function hasInsertion( SMWDIProperty $property, $value ) {
		$has = false;
		
		foreach ( $this->insertions->getPropertyValues( $property ) as /* SMWDataItem */ $insertion ) {
			if ( $insertion->getSerialization() == $value ) {
				$has = true;
				break;
			}
		}
		
		return $has;
	}
	
	/**
	 * Returns if a certain insertion is present in the set of changes.
	 * 
	 * @since 0.1
	 * 
	 * @param SMWDIProperty $property
	 * @param string $value
	 * 
	 * @return boolean
	 */
	public function hasDeletion( SMWDIProperty $property, $value ) {
		$has = false;
		
		foreach ( $this->deletions->getPropertyValues( $property ) as /* SMWDataItem */ $deletion ) {
			if ( $deletion->getSerialization() == $value ) {
				$has = true;
				break;
			}
		}
		
		return $has;		
	}
	
	/**
	 * Returns if a certain change is present in the set of changes.
	 * 
	 * @since 0.1
	 * 
	 * @param SMWDIProperty $property
	 * @param SWLPropertyChange $change
	 * 
	 * @return boolean
	 */
	public function hasChange( SMWDIProperty $property, SWLPropertyChange $change ) {
		$has = false;
		
		foreach ( $this->changes->getPropertyChanges( $property ) as /* SWLPropertyChange */ $propChange ) {
			if ( $propChange->getSerialization() == $change->getSerialization() ) {
				$has = true;
				break;
			}
		}
		
		return $has;			
	}
	
	/**
	 * Merges in the changes of another change set.
	 * Duplicate changes are detected and only kept as a single change.
	 * This is usefull for merging sets with (possibly overlapping) changes belonging to a single edit.
	 * 
	 * @since 0.1
	 * 
	 * @param SWLChangeSet $set
	 */
	public function mergeInChangeSet( SWLChangeSet $set ) {
		foreach ( $set->getAllProperties() as $property ) {
			foreach ( $set->getChanges()->getPropertyChanges( $property ) as /* SWLPropertyChange */ $change ) {
				if ( !$this->hasChange( $property, $change ) ) {
					$this->addChange( $property, $change );
				}
			}
			
			foreach ( $set->getInsertions()->getPropertyValues( $property ) as /* SMWDataItem */ $dataItem ) {
				if ( !$this->hasInsertion( $property, $dataItem ) ) {
					$this->addInsertion( $property, $dataItem );
				}
			}
	
			foreach ( $set->getDeletions()->getPropertyValues( $property ) as /* SMWDataItem */ $dataItem ) {
				if ( !$this->hasInsertion( $property, $dataItem ) ) {
					$this->addDeletion( $property, $dataItem );
				}
			}		
		}
	}
	
}
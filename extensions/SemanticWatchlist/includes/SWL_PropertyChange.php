<?php

/**
 * Represents a change to a semantic property.
 *
 * @since 0.1
 *
 * @file SWL_PropertyChange.php
 * @ingroup SemanticWatchlist
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SWLPropertyChange {

	const TYPE_INSERT = 0;
	const TYPE_UPDATE = 1;
	const TYPE_DELETE = 2;

	/**
	 * The old value.
	 *
	 * @var SMWDataItem or null
	 */
	protected $oldValue;

	/**
	 * The new value.
	 *
	 * @var SMWDataItem or null
	 */
	protected $newValue;

	/**
	 * Creates and returns a new SWLPropertyChange instance from a serialization.
	 *
	 * @param string|null $oldValue
	 * @param string|null $newValue
	 *
	 * @return SWLPropertyChange
	 */
	public static function newFromSerialization( SMWDIProperty $property, $oldValue, $newValue ) {
		$diType = SMWDataValueFactory::getDataItemId( $property->findPropertyTypeID() );
		//var_dump($property);
		//if($diType!=7) {throw new Exception();exit;}
		return new self(
			is_null( $oldValue ) ? null : SMWDataItem::newFromSerialization( $diType, $oldValue ),
			is_null( $newValue ) ? null : SMWDataItem::newFromSerialization( $diType, $newValue )
		);
	}

	/**
	 * Create a new SWLPropertyChange.
	 *
	 * @param SMWDataItem $oldValue
	 * @param SMWDataItem $newValue
	 */
	public function __construct( /* SMWDataItem */ $oldValue, /* SMWDataItem */ $newValue ) {
		$this->oldValue = $oldValue;
		$this->newValue = $newValue;
	}

	/**
	 * Retruns the old value, or null if there is none.
	 *
	 * @return SMWDataItem or null
	 */
	public function getOldValue() {
		return $this->oldValue;
	}


	/**
	 * returns the new value, or null if there is none.
	 *
	 * @return SMWDataItem or null
	 */
	public function getNewValue() {
		return $this->newValue;
	}

	/**
	 * Returns the type of the change.
	 *
	 * @return element of the SWLPropertyChange::TYPE_ enum
	 */
	public function getType() {
		if ( is_null( $this->oldValue ) ) {
			return self::TYPE_INSERT;
		}
		elseif ( is_null( $this->newValue ) ) {
			return self::TYPE_DELETE;
		}
		else {
			return self::TYPE_UPDATE;
		}
	}

	/**
	 * Returns a serialized version of the change, suitable to
	 * do equal comparisions but not to unserialize.
	 *
	 * @return string
	 */
	public function getSerialization() {
		return is_null( $this->oldValue ) ? '' : $this->oldValue->getSerialization() . '|' .
			is_null( $this->newValue ) ? '' : $this->newValue->getSerialization();
	}

}

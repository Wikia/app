<?php

/**
 * This class represents a single piece of MoodBar feedback.
 */
class MBFeedbackItem {
	/** Container for the data **/
	protected $data;
	/** Valid data keys **/
	protected $validMembers = array(
			// Feedback essentials
			'id', // ID in the database
			'comment', // The feedback itself
			'page', // The page where it was submitted
			'type',

			// Housekeeping
			'timestamp',
			'user', // User object who submitted the feedback
			'anonymize',
			'hidden-state',

			// Statistics
			'useragent',
			'system',
			'locale',
			'editmode',
			'bucket',
			'user-editcount',
		);

	/** Valid values for the 'type' parameter. **/
	protected static $validTypes = array( 'happy', 'sad', 'confused' );

	/**
	 * Default constructor.
	 * Don't use this, use either MBFeedbackItem::newFromRow or MBFeedbackItem::create
	 */
	protected function __construct() {
		$this->data = array_fill_keys( $this->validMembers, null );

		// Non-nullable boolean fields
		$this->setProperty('anonymize', false);
		$this->setProperty('editmode', false);
		$this->setProperty('hidden-state', 0 );
	}

	/**
	 * Factory function to create a new MBFeedbackItem
	 * @param $info Associative array of values
	 * Valid keys: type, user, comment, page, flags, timestamp,
	 *             useragent, system, locale, bucket, anonymize, hidden-state
	 * @return MBFeedbackItem object.
	 */
	public static function create( $info ) {
		$newObject = new self();
		$newObject->initialiseNew( $info );
		return $newObject;
	}

	/**
	 * Initialiser for new MBFeedbackItems
	 * @param $info Associative array of values
	 * @see MBFeedbackItem::create
	 */
	protected function initialiseNew( $info ) {
		global $wgUser;

		$template = array(
			'user' => $wgUser,
			'timestamp' => wfTimestampNow(),
		);

		$this->setProperties( $template );
		$this->setProperties( $info );
	}

	/**
	 * Factory function to load an MBFeedbackItem from a DB row.
	 * @param $row A row, from DatabaseBase::fetchObject
	 * @return MBFeedback object.
	 */
	public static function load( $row ) {
		$newObject = new self();
		$newObject->initialiseFromRow( $row );
		return $newObject;
	}

	/**
	 * Initialiser for MBFeedbackItems loaded from the database
	 * @param $row A row object from DatabaseBase::fetchObject
	 * @see MBFeedbackItem::load
	 */
	protected function initialiseFromRow( $row ) {
		static $propMappings = array(
			'id' => 'mbf_id',
			'type' => 'mbf_type',
			'comment' => 'mbf_comment',
			'timestamp' => 'mbf_timestamp',
			'anonymize' => 'mbf_anonymous',
			'useragent' => 'mbf_user_agent',
			'system' => 'mbf_system_type',
			'locale' => 'mbf_locale',
			'bucket' => 'mbf_bucket',
			'editmode' => 'mbf_editing',
			'user-editcount' => 'mbf_user_editcount',
			'hidden-state' => 'mbf_hidden_state',
		);
		
		$properties = array();
		
		foreach( $propMappings as $property => $field ) {
			if ( isset( $row->$field ) ) {
				$properties[$property] = $row->$field;
			}
		}

		if ( isset( $row->mbf_namespace ) && isset( $row->mbf_title ) ) {
			$properties['page'] = Title::makeTitleSafe( $row->mbf_namespace, $row->mbf_title );
		}

		if ( !empty($row->user_id) ) {
			$properties['user'] = User::newFromRow( $row );
		} elseif ( $row->mbf_user_id > 0 ) {
			$properties['user'] = User::newFromId( $row->mbf_user_id );
		} elseif ( $row->mbf_user_ip ) {
			$properties['user'] = User::newFromName( $row->mbf_user_ip );
		}

		$this->setProperties( $properties , true );
	}

	/**
	 * Set a group of properties. Throws an exception on invalid property.
	 * @param $values An associative array of properties to set.
	 * @param $initialise_from_row bool if record is loaded from DB row
	 */
	public function setProperties( $values , $initialise_from_row = false) {
		foreach( $values as $key => $value ) {
			if ( ! $this->isValidKey($key) ) {
				throw new MWException( "Attempt to set invalid property $key" );
			}

			if ( ! $this->validatePropertyValue($key, $value, $initialise_from_row) ) {
				throw new MWException( "Attempt to set invalid value for $key" );
			}

			$this->data[$key] = $value;
		}
	}

	/**
	 * Set a group of values.
	 * @param $key The property to set.
	 * @param $value The value to give it.
	 */
	public function setProperty( $key, $value ) {
		$this->setProperties( array( $key => $value ) );
	}

	/**
	 * Get a property.
	 * @param $key The property to get
	 * @return The property value.
	 */
	public function getProperty( $key ) {
		if ( ! $this->isValidKey($key) ) {
			throw new MWException( "Attempt to get invalid property $key" );
		}

		return $this->data[$key];
	}

	/**
	 * Check a property key for validity.
	 * If a property key is valid, it will be prefilled to NULL.
	 * @param $key The property key to check.
	 */
	public function isValidKey( $key ) {
		return in_array( $key, $this->validMembers );
	}

	/**
	 * Check if a property value is valid for that property
	 * @param $key The key of the property to check.
	 * @param $value The value to check
	 * @param $initialise_from_row bool if record is loaded from DB row
	 * @return Boolean
	 */
	public function validatePropertyValue( $key, $value , $initialise_from_row = false ) {
		if ( $key == 'user' ) {
			return $value instanceof User;
		} elseif ( $key == 'page' ) {
			return $value instanceof Title;
		} elseif ( $key == 'type' ) {
			return in_array( $value, self::$validTypes );
		} elseif ( $key == 'comment' ) {
			$comment_len = mb_strlen( $value );
			//existing empty comment from database should be considered as valid
			if($initialise_from_row) {
				return $comment_len <= 140;
			}
			else {
				return $comment_len > 0 && $comment_len <= 140;	
			}
		}

		return true;
	}

	/**
	 * Writes this MBFeedbackItem to the database.
	 * Throws an exception if this it is already in the database.
	 * @return The MBFeedbackItem's new ID.
	 */
	public function save() {
		// Add edit count if necessary
		if ( $this->getProperty('user-editcount') === null &&
			$this->getProperty('user') )
		{
			$value = $this->getProperty('user');

			if ( $value->isAnon() ) {
				$this->setProperty( 'user-editcount', 0 );
			} else {
				$this->setProperty( 'user-editcount', $value->getEditCount() );
			}
		}

		$dbw = wfGetDB( DB_MASTER );

		$row = array(
			'mbf_type' => $this->getProperty('type'),
			'mbf_comment' => $this->getProperty('comment'),
			'mbf_timestamp' => $dbw->timestamp($this->getProperty('timestamp')),
			'mbf_anonymous' => $this->getProperty('anonymize'),
			'mbf_user_agent' => $this->getProperty('useragent'),
			'mbf_system_type' => $this->getProperty('system'),
			'mbf_locale' => $this->getProperty('locale'),
			'mbf_bucket' => $this->getProperty('bucket'),
			'mbf_editing' => $this->getProperty('editmode'),
			'mbf_user_editcount' => $this->getProperty('user-editcount'),
			'mbf_hidden_state' => $this->getProperty('hidden-state'),
		);

		$user = $this->getProperty('user');
		if ( $user->isAnon() ) {
			$row['mbf_user_id'] = 0;
			$row['mbf_user_ip'] = $user->getName();
		} else {
			$row['mbf_user_id'] = $user->getId();
		}

		$page = $this->getProperty('page');
		if ( $page ) {
			$row['mbf_namespace'] = $page->getNamespace();
			$row['mbf_title'] = $page->getDBkey();
		}

		if ( $this->getProperty('id') ) {
			$row['mbf_id'] = $this->getProperty('id');
			$dbw->replace( 'moodbar_feedback', array('mbf_id'), $row, __METHOD__ );
		} else {
			$row['mbf_id'] = $dbw->nextSequenceValue( 'moodbar_feedback_mbf_id' );
			$dbw->insert( 'moodbar_feedback', $row, __METHOD__ );
			$this->setProperty( 'id', $dbw->insertId() );
		}

		return $this->getProperty('id');
	}

	/**
	 * Gets the valid types of a feedback item.
	 */
	public static function getValidTypes() {
		return self::$validTypes;
	}
	
	/**
	 * Update feedback item based on the primary key $mbf_id
	 * @param $mbf_id int - id representing a unique feedback item
	 * @param $values array - key -> database field, value -> the new value
	 */
	public static function update( $mbf_id, $values ) {

		if ( !$values ) {
			return;
		}
		
		$dbw = wfGetDB( DB_MASTER );

		$dbw->update( 'moodbar_feedback', 
				$values,
				array( 'mbf_id' => intval( $mbf_id ) ),
				__METHOD__ );
	}

}

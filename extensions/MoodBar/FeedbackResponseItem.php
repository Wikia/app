<?php

/**
 * This class represents a single piece of MoodBar feedback response
 * @Todo: Make a base class for both MBFeedbackItem and MBFeedbackResponseItem
 *        so common functions can be re-used
 */
class MBFeedbackResponseItem {
	/** Container for the data **/
	protected $data;
	/** Valid data keys **/
	protected $validMembers = array(
			// Feedback response essentials
			'id', // ID in the database for response
			'feedback', // ID in the database for moodbar_feedback
			'feedbackitem', // the feedback that the user responds to
			'user', // user object
			'anonymize',
			'commenter-editcount', // Number of edit for the user writes the feedback
			'user-editcount', // Number of edit for the responder
			'response', // The response itself
			'timestamp', // When response was received
			'system', // Operating System
			'useragent' , // User-Agent header
			'locale', // The locale of the user's browser
			'editmode' // Whether or not the user was editing
		);
	/**
	 * Default constructor.
	 * Don't use this, use MBFeedbackResponseItem::create
	 */
	protected function __construct() {
		$this->data = array_fill_keys( $this->validMembers, null );

		// Non-nullable boolean fields
		$this->setProperty('anonymize', false);
		$this->setProperty('editmode', false);
	}

	/**
	 * Factory function to create a new MBFeedbackResponseItem
	 * @param $info Associative array of values
	 * Valid keys: feedbackitem, user, response-text, timestamp,
	 *             useragent, system, locale
	 * @return MBFeedbackItem object.
	 */
	public static function create( $info ) {
		$newObject = new self();
		$newObject->initialiseNew( $info );
		return $newObject;
	}

	/**
	 * Initialiser for new MBFeedbackResponseItem
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
	 * Factory function to load an MBFeedbackResponseItem from a DB row.
	 * @param $row A row, from DatabaseBase::fetchObject
	 * @return MBFeedResponseback object.
	 */
	public static function load( $row ) {
		$newObject = new self();
		$newObject->initialiseFromRow( $row );
		return $newObject;
	}

	/**
	 * Initialiser for MBFeedbackResponseItems loaded from the database
	 * @param $row A row object from DatabaseBase::fetchObject
	 * @see MBFeedbackItem::load
	 */
	protected function initialiseFromRow( $row ) {
		static $propMappings = array(
			'id' => 'mbfr_id',
			'feedback' => 'mbfr_mbf_id',
			'response' => 'mbfr_response_text',
			'timestamp' => 'mbfr_timestamp',
			'anonymize' => 'mbfr_anonymous',
			'useragent' => 'mbfr_user_agent',
			'system' => 'mbfr_system_type',
			'locale' => 'mbfr_locale',
			'editmode' => 'mbfr_editing',
			'commenter-editcount',
			'user-editcount'
		);

		$properties = array();

		foreach( $propMappings as $property => $field ) {
			if ( isset( $row->$field ) ) {
				$properties[$property] = $row->$field;
			}
		}

		if ( $row->mbfr_user_id > 0 ) {
			$properties['user'] = User::newFromId( $row->mbfr_user_id );
		} elseif ( $row->mbfr_user_ip ) {
			$properties['user'] = User::newFromName( $row->mbfr_user_ip );
		}
		else {
			//Error
			$properties['user'] = '';
		}

		$this->setProperties( $properties );

	}

	/**
	 * Set a group of properties. Throws an exception on invalid property.
	 * @param $values An associative array of properties to set.
	 * @throws MWFeedbackResponseItemPropertyException
	 */
	public function setProperties( $values ) {

		foreach( $values as $key => $value ) {
			if ( ! $this->isValidKey($key) ) {
				throw new MWFeedbackResponseItemPropertyException( "Attempt to set invalid property $key" );
			}

			if ( ! $this->validatePropertyValue($key, $value) ) {
				throw new MWFeedbackResponseItemPropertyException( "Attempt to set invalid value for $key" );
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
	 * @throws MWFeedbackResponseItemPropertyException
	 */
	public function getProperty( $key ) {
		if ( ! $this->isValidKey($key) ) {
			throw new MWFeedbackResponseItemPropertyException( "Attempt to get invalid property $key" );
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
	 * @return Boolean
	 */
	public function validatePropertyValue( $key, $value ) {
		if ( $key == 'user' ) {
			return $value instanceof User;
		} elseif ( $key == 'feedback' ) {
			if( $value <= 0 ) {
				return false;
			}
			if( !$this->setFeedbackItem($value) ) {
				return false;
			}
			return true;
		} elseif ( $key == 'feedbackitem' ) {
			return $value instanceof MBFeedbackItem;
		} elseif ( $key == 'response' ) {
			$comment_len = mb_strlen( $value );
			return $comment_len > 0 && $comment_len <= 5000;
		}

		return true;
	}

	/**
	 * Writes this MBFeedbackItem to the database.
	 * Throws an exception if this it is already in the database.
	 * @return The MBFeedbackItem's new ID.
	 */
	public function save() {

		$user = $this->getProperty('user');

		// Add edit count if necessary
		if ( $this->getProperty('user-editcount') === null && $user !== null ) {
			$this->setProperty( 'user-editcount', $user->isAnon() ? 0 : $user->getEditCount() );
		}

		if($this->getProperty('commenter-editcount') === null) {
			$commenter =  $this->getProperty('feedbackitem')->getProperty('user');
			$this->setProperty( 'commenter-editcount', $commenter->isAnon() ? 0 :  $commenter->getEditCount() );
		}

		$dbw = wfGetDB( DB_MASTER );

		$row = array(
			'mbfr_mbf_id' => $this->getProperty('feedback'),
			'mbfr_commenter_editcount' => $this->getProperty('commenter-editcount'),
			'mbfr_user_editcount' => $this->getProperty('user-editcount'),
			'mbfr_response_text' => $this->getProperty('response'),
			'mbfr_timestamp' => $dbw->timestamp($this->getProperty('timestamp')),
			'mbfr_system_type' => $this->getProperty('system'),
			'mbfr_user_agent' => $this->getProperty('useragent'),
			'mbfr_locale' => $this->getProperty('locale'),
			'mbfr_editing' => $this->getProperty('editmode')
		);

		if($user->isAnon()) {
			$row['mbfr_user_id'] = 0;
			$row['mbfr_user_ip'] = $user->getName();
		} else {
			$row['mbfr_user_id'] = $user->getId();
		}

		$dbw->begin();

		if ( $this->getProperty('id') ) {
			$row['mbfr_id'] = $this->getProperty('id');
			$dbw->replace( 'moodbar_feedback_response', array('mbfr_id'), $row, __METHOD__ );
		} else {
			$row['mbfr_id'] = $dbw->nextSequenceValue( 'moodbar_feedback_response_mbfr_id' );
			$dbw->insert( 'moodbar_feedback_response', $row, __METHOD__ );
			$this->setProperty( 'id', $dbw->insertId() );
		}
		
		$id = $this->getProperty('id');

		// Update feedback with the latest response id
		MBFeedbackItem::update( $this->getProperty('feedback'), array( 'mbf_latest_response' => $id ) );
		
		$dbw->commit();
		
		return $id;
	}

	/**
	 * Gets the valid types of a feedback item.
	 */
	public static function getValidTypes() {
		return self::$validTypes;
	}

	/**
	 * Set the Feedback Item this Response is associated to
	 * @param $mbf_id mbfr_mbf_id in moodbar_feedback_response table
	 * @return bool
	 */
	protected function setFeedbackItem($mbf_id) {
		$dbr = wfGetDB( DB_SLAVE );

		$row = $dbr->selectRow( 'moodbar_feedback', '*',
			array( 'mbf_id' => $mbf_id ), __METHOD__ );

		if( $row !== false ) {
			$this->setProperties( array ( 'feedbackitem' => MBFeedbackItem::load( $row ) ) );
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Update response item based on the primary key $mbfr_id
	 * @param $mbfr_id int - id representing a unique response item
	 * @param $values array - key -> database field, value -> the new value
	 */
	public static function update( $mbfr_id, $values ) {

		if ( !$values ) {
			return;
		}
		
		$dbw = wfGetDB( DB_MASTER );

		$dbw->update( 'moodbar_feedback_response', 
				$values,
				array( 'mbfr_id' => intval( $mbfr_id ) ),
				__METHOD__ );
	}
	
}

class MWFeedbackResponseItemPropertyException extends MWException {};

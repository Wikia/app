<?php

/**
 * Class representing a single contest challenge object.
 * Each contest (can) has a list of associated challenges.
 *
 * @since 0.1
 *
 * @file ContestChallenge.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ContestChallenge extends ContestDBObject {

	/**
	 * Method to get an instance so methods that ought to be static,
	 * but can't be due to PHP 5.2 not having LSB, can be called on
	 * it. This also allows easy identifying of code that needs to
	 * be changed once PHP 5.3 becomes an acceptable requirement.
	 *
	 * @since 0.1
	 *
	 * @return ContestDBObject
	 */
	public static function s() {
		static $instance = false;

		if ( $instance === false ) {
			$instance = new self( array() );
		}

		return $instance;
	}

	/**
	 * Get a new instance of the class from an array.
	 * This method ought to be in the basic class and
	 * return a new static(), but this requires LSB/PHP>=5.3.
	 *
	 * @since 0.1
	 *
	 * @param array $data
	 * @param boolean $loadDefaults
	 *
	 * @return ContestDBObject
	 */
	public function newFromArray( array $data, $loadDefaults = false ) {
		return new self( $data, $loadDefaults );
	}

	/**
	 * @see parent::getFieldTypes
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getDBTable() {
		return 'contest_challenges';
	}

	/**
	 * @see parent::getFieldTypes
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected function getFieldPrefix() {
		return 'challenge_';
	}

	/**
	 * @see parent::getFieldTypes
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected function getFieldTypes() {
		return array(
			'id' => 'id',
			'contest_id' => 'id',
			'text' => 'str',
			'title' => 'str',
			'oneline' => 'str',
		);
	}

	/**
	 * @see parent::getDefaults
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public function getDefaults() {
		return array(
			'text' => '',
			'title' => '',
			'oneline' => '',
		);
	}

	/**
	 * Returns an array with challenge IDs (keys) and their associated titles (values)
	 * for the provided list of IDs.
	 *
	 * @param array|integer $ids
	 *
	 * @return array( id => title )
	 */
	public static function getTitlesForIds( $ids ) {
		$challenges = self::s()->select( array( 'id', 'title' ), array( 'id' => $ids ) );
		$results = array();

		foreach ( $challenges as /* ContestChallenge */ $challenge ) {
			$results[$challenge->getId()] = $challenge->getField( 'title' );
		}

		return $results;
	}

}

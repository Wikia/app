<?php
/**
 * Frequent Pattern Tag Cloud Plug-in
 * Search checks, whether the attribute is available in the database.
 *
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 * @version 1.0
 */
include_once( "exceptions/InvalidAttributeException.php" );

// @todo FIXME: this is a bit too generic class name...
class Search {
	/**
	* Attribute name for search
	*
	* @var string
	*/
	private $_attribute;

	/**
	 * Constructor
	 *
	 * @param $attribute String: attribute name for search
	 * @throws InvalidAttributeException If attribute is not valid, i.e. present in database
	 */
	public function __construct( $attribute ) {
		if ( !$this->attributeAvailable( $attribute ) ) {
			// Check if attribute is available
			throw new InvalidAttributeException( $attribute );
		}
	}

	/**
	 * Checks whether attribute is correct, i.e. it exists in database; if yes,
	 * it fetches the name of the attribute
	 *
	 * @param $attribute String: attribute
	 * @return bool
	 */
	private function attributeAvailable( $attribute ) {
		// Category
		if ( wfMsg( 'fptc-categoryname' ) == $attribute ) {
			return true;
		}

		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			'smw_ids',
			'smw_title',
			array(
				'smw_namespace' => 102,
				'LENGTH(smw_iw) = 0',
				'smw_title' => $attribute
			),
			__METHOD__
		);

		if ( $res->numRows() == 0 ) {
			// Attribute not found
			return false;
		}

		$row = $res->fetchRow();

		// Assign name
		$this->_attribute = $row[0];

		return true;
	}

	/**
	 * Gets the available Attribute
	 *
	 * @return attribute
	 */
	public function getAvailableAttribute() {
		return $this->_attribute;
	}
}

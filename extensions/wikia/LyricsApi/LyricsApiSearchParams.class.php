<?php

/**
 * Class LyricsApiSearchParams
 */
class LyricsApiSearchParams {

	private $limit = 0;
	private $offset = 0;
	private $fields = [];

	/**
	 * @param int $limit
	 */
	public function setLimit($limit) {
		$this->limit = $limit;
	}

	/**
	 * @return int
	 */
	public function getLimit() {
		return $this->limit;
	}

	/**
	 * @param int $offset
	 */
	public function setOffset($offset) {
		$this->offset = $offset;
	}

	/**
	 * @return int
	 */
	public function getOffset() {
		return $this->offset;
	}

	/**
	 * @desc Adds field with value to the list
	 *
	 * @param $fieldName
	 * @param $value
	 */
	public function addField( $fieldName, $value ) {
		$this->fields[$fieldName] = $value;
	}

	/**
	 * @desc Returns field value by name or throws an exception if field not found
	 * @param $fieldName
	 * @return mixed
	 * @throws InvalidParameterApiException
	 */
	public function getField( $fieldName ) {
		if ( $this->fields[$fieldName] ) {
			return $this->fields[$fieldName];
		} else {
			throw new InvalidParameterApiException( $fieldName );
		}
	}

	/**
	 * @desc Returns lower cased value of field
	 * @param $fieldName
	 * @return string
	 */
	public function getLowerCaseField( $fieldName ) {
		return LyricsUtils::lowercase( $this->getField( $fieldName ) );
	}

}

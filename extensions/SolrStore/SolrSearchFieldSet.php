<?php

/**
 * File holding the SolrSearchFieldSet class
 *
 * @ingroup SolrStore
 * @file
 * @author Simon Bachenberg
 */

/**
 * TODO: Insert class description
 *
 * To create a SearchSet for your Wiki add the Following Lines to you LocalSettings.php
 * $wgSolrFields = array(
 *   new SolrSearchFieldSet('<Name of the SearchSet>', '<Semicolon Seperated List of your Semantic Propertys>', ''<Semicolon Seperated List of the Lable for your Fields>', '<Extra Query Parameters>'),
 *   new SolrSearchFieldSet('Institution', 'has_name; has_country', 'Name, Country', ' AND category:Event')
 *   );
 *
 * @ingroup SolrStore
 */
class SolrSearchFieldSet {

	var $mName;
	var $mFields;
	var $mLable;
	var $mQuery;
	var $mFieldSeperator;

	public function __construct( $name, $fields = 'search', $lable = 'Alles', $query = null, $fieldSeperator = null ) {
		$this->mName = $name;
		$this->mFields = explode( ';', $fields );
		$this->mLable = explode( ';', $lable );
		$this->mQuery = $query;
		$this->mFieldSeperator = $fieldSeperator;

		if ( !isset( $this->mFieldSeperator ) ) {
			$this->mFieldSeperator = '';
		}
	}

	public function getName() {
		return $this->mName;
	}

	public function getFields() {
		return $this->mFields;
	}

	public function getLable() {
		return $this->mLable;
	}

	public function getQuery() {
		return $this->mQuery;
	}

	public function getFieldSeperator() {
		return $this->mFieldSeperator;
	}

	public function setName( $value ) {
		$this->mName = $value;
	}

	public function setFields( $value ) {
		$this->mFields = $value;
	}

	public function setLable( $value ) {
		$this->mLable = $value;
	}

	public function setQuery( $value ) {
		$this->mQuery = $value;
	}

	public function setFieldSeperator( $value ) {
		$this->mFieldSeperator = $value;
	}

}

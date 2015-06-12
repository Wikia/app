<?php

/**
 * File holding the SRF_Filtered_View class
 *
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticResultFormats
 */

/**
 * The SRF_Filtered_View class.
 *
 * @ingroup SemanticResultFormats
 */
abstract class SRF_Filtered_View {

	private $mId;
	private $mResults;
	private $mParameters;
	private $mQueryPrinter;

	/**
	 * Constructor for the view.
	 *
	 * @param $id the view id
	 * @param $results array of SRF_Filtered_Item containing the query results
	 * @param $params array of parameter values given as key-value-pairs
	 */
	public function __construct( $id, &$results, &$params, SRFFiltered &$queryPrinter ) {
		$this->mId = $id;
		$this->mResults = $results;
		$this->mParameters = $params;
		$this->mQueryPrinter = $queryPrinter;
	}

	public function getId() { return $this->mId; }
	public function &getQueryResults() { return $this->mResults; }
	public function &getActualParameters() { return $this->mParameters; }
	public function &getQueryPrinter() { return $this->mQueryPrinter; }

	/**
	 * Returns the name (string) or names (array of strings) of the resource
	 * modules to load.
	 *
	 * @return string|array
	 */
	public function getResourceModules() {
		return null;
	}

	/**
	 * A function to describe the allowed parameters of a query for this view.
	 *
	 * @return array of Parameter
	 */
	public static function getParameters() {
		return array();
	}

	/**
	 * Returns the HTML text that is to be included for this view.
	 *
	 * This text will appear on the page in a div that has the view's id set as
	 * class.
	 *
	 * @return string
	 */
	public function getResultText() {
		return '';
	}

	/**
	 * Returns an array of config data for this filter to be stored in the JS
	 * @return null
	 */
	public function getJsData() {
		return null;
	}

	/**
	 * Returns the label of the selector for this view.
	 * @return String the selector label
	 */
	public function getSelectorLabel() {
		return '';
	}

}

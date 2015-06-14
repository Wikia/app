<?php

/**
 * File holding the SRF_Filtered_Filter class
 *
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticResultFormats
 */

/**
 * The SRF_Filtered_Filter class.
 *
 * @ingroup SemanticResultFormats
 */
abstract class SRF_Filtered_Filter {

	private $mResults = null;
	private $mPrintRequest = null;
	private $mQueryPrinter = null;

	public function __construct( &$results, SMWPrintRequest $printRequest, SRFFiltered &$queryPrinter ) {
		$this->mResults = $results;
		$this->mPrintRequest = $printRequest;
		$this->mQueryPrinter = $queryPrinter;
	}

	public function &getQueryResults() { return $this->mResults; }
	public function &getPrintRequest() { return $this->mPrintRequest; }
	public function &getQueryPrinter() { return $this->mQueryPrinter; }


	public function getActualParameters() {

		return $this->mPrintRequest->getParameters();

	}

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
	 * Returns the HTML text that is to be included for this filter.
	 *
	 * This text will appear on the page in a div that has the filter's id set
	 * as class.
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

}

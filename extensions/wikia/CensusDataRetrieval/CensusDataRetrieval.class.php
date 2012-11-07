<?php

class CensusDataRetrieval {
	var $name = '';
	var $data = array();

	var $supportedTypes = array( 'vehicle' );

	/**
	 * entry point
	 * called by hook 'onEditFormPreloadText'
	 * @return true
	 */
	public static function retrieveFromName( &$text, &$title ) {
		// @TODO check if namespace is correct

		$cdr = new self();

		$text = $cdr->execute( $title );

		return true;
	}

	/**
	 * main method, handles flow and sequence, decides when to give up
	 */
	public function execute( $title ) {
		$this->name = $title->getText();

		if ( !$this->fetchData() ) {
			// no data in Census or something went wrong, quit
			return true;
		}

		if ( !$this->isSupportedType() ) {
			return true;
		}

		$infoboxText = $this->parseData();

		$typeLayout = $this->getLayout();

		$text = $infoboxText . $typeLayout;

		return $text;
	}

	/**
	 * gets data from the Census API and returns the part we care about
	 * @return boolean true on success, false on failed connection or empty result
	 */
	private function fetchData() {
		/* fetch data from API based on $this->query */

		$this->data = array( 'foo' => 'bar' );

		return true;
	}

	/**
	 * constructs the infobox text based on type and data
	 * @return string
	 */
	private function parseData() {
		$type = $this->getType();
		$output = 'test text';

		/* do stuff */

		return $output;
	}

	/**
 	 * getType
	 * determines type based on fetched data
	 *
	 * @return string
	 */
	private function getType() {
		return 'vehicle';
	}

	/**
	 * isSupportedType
	 * @return Boolean
	 */
	private function isSupportedType() {
		return in_array( $this->getType(), $this->supportedTypes );
	}

	/**
	 * gets the layout (preloaded text other than the infobox) based on type
	 *
	 * @return string
	 */
	private function getLayout() {
		return '';
	}
}

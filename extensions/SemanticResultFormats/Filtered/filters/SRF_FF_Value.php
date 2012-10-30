<?php

/**
 * File holding the SRF_FF_Value class
 *
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticResultFormats
 */

/**
 * The SRF_FF_Value class.
 *
 * Available parameters for this filter:
 *   value filter switches: switches to be shown for this filter; currently only 'and or' supported
 *
 * @ingroup SemanticResultFormats
 */
class SRF_FF_Value extends SRF_Filtered_Filter {

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
	 * Returns the name (string) or names (array of strings) of the resource
	 * modules to load.
	 *
	 * @return string|array
	 */
	public function getResourceModules() {
		return 'ext.srf.filtered.value-filter';
	}

	/**
	 * Returns an array of config data for this filter to be stored in the JS
	 * @return null
	 */
	public function getJsData() {
		$params = $this->getActualParameters();

		if (  array_key_exists( 'value filter switches', $params ) ) {
			$switches = explode( ',', $params['value filter switches'] );
			$switches = array_map( 'trim', $switches );

			return array( 'switches' => $switches );
		}

		return null;
	}

}

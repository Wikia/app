<?php
/**
 * File holding the SolrDoc class
 *
 * @ingroup SolrStore
 * @file
 * @author Simon Bachenberg
 */

/**
 * Class for saving Documents for sending to Solr
 *
 * @ingroup SolrStore
 */
class SolrDoc {
	private $output;
	private $min = array();
	private $max = array();

	/**
	 * Add a field to the SolrDoc
	 *
	 * @param $name String: name of the field
	 * @param $value String: value of the field
	 */
	public function addField( $name, $value ) {
		$this->output .= '<field name="' . $name . '">' . $value . '</field>';
	}

	/**
	 * This function gets a multivalued field and splits it into a max and a
	 * min value for sorting
	 *
	 * @param $name String: name of the field
	 * @param $value Mixed: value of the field
	 */
	public function addSortField( $name, $value ) {
		// Does a min/max field with this name exist?
		if ( isset( $this->min[$name] ) && isset( $this->max[$name] ) ) {
			if ( strcasecmp( $this->min[$name], $value ) > 0 ) {
				// If the new string is less the old one, replace them
				$this->min[$name] = $value;
			}
			if ( strcasecmp( $this->max[$name], $value ) < 0 ) {
				// If the new string is bigger than old one, replace them
				$this->max[$name] = $value;
			}
		} else {
			$this->min[$name] = $value;
			$this->max[$name] = $value;
		}
	}

	public function printFields() {
		$all = $this->output;

		foreach ( $this->min as $name => $value ) {
			$all .= '<field name="' . $name . 'min">' . $value . '</field>';
		}
		foreach ( $this->max as $name => $value ) {
			$all .= '<field name="' . $name . 'max">' . $value . '</field>';
		}

		return $all;
	}
}

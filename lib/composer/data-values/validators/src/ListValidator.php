<?php

namespace ValueValidators;

/**
 * ValueValidator that validates a list of values.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ListValidator extends ValueValidatorObject {

	/**
	 * @see ValueValidatorObject::doValidation
	 *
	 * @since 0.1
	 *
	 * @param mixed $value
	 */
	public function doValidation( $value ) {
		if ( !is_array( $value ) ) {
			$this->addErrorMessage( 'Not an array' );
			return;
		}

		$optionMap = array(
			'elementcount' => 'range',
			'maxelements' => 'upperbound',
			'minelements' => 'lowerbound',
		);

		$this->runSubValidator( count( $value ), new RangeValidator(), 'length', $optionMap );
	}

	/**
	 * @see ValueValidatorObject::enableWhitelistRestrictions
	 *
	 * @since 0.1
	 *
	 * @return boolean
	 */
	protected function enableWhitelistRestrictions() {
		return false;
	}

}

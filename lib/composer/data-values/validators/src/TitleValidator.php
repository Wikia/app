<?php

namespace ValueValidators;

use Title;

/**
 * ValueValidator that validates a Title object.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class TitleValidator extends ValueValidatorObject {

	/**
	 * @since 0.1
	 * @var boolean
	 */
	protected $hasToExist = true;

	/**
	 * @since 0.1
	 * @param boolean $hasToExist
	 */
	public function setHasToExist( $hasToExist ) {
		$this->hasToExist = $hasToExist;
	}

	/**
	 * @see ValueValidatorObject::doValidation
	 *
	 * @since 0.1
	 *
	 * @param mixed $value
	 */
	public function doValidation( $value ) {
		/**
		 * @var Title $value
		 */
		if ( !$value instanceof Title ) {
			$this->addErrorMessage( 'Not a title' );
		}
		elseif( $this->hasToExist && !$value->exists() ) {
			$this->addErrorMessage( 'Title does not exist' );
		}
	}

	/**
	 * @see ValueValidator::setOptions
	 *
	 * @since 0.1
	 *
	 * @param array $options
	 */
	public function setOptions( array $options ) {
		parent::setOptions( $options );

		if ( array_key_exists( 'hastoexist', $options ) ) {
			$this->setHasToExist( $options['hastoexist'] );
		}
	}

}

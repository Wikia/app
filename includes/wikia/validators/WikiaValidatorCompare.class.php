<?php

class WikiaValidatorCompare extends WikiaValidator {
	const EQUAL      = '==';
	const NOT_EQUAL  = '!=';
	const LESS_THAN  = '<';
	const LESS_THAN_EQUAL    = '<=';
	const GREATER_THAN       = '>';
	const GREATER_THAN_EQUAL = '>=';

	protected function configMsgs( array $msgs = array() ) {
		$this->setMsg( 'compare_fail', 'wikia-validator-compare-fail' );
	}

	protected function config( array $options = array() ) {
		$this->setOption( 'expression', '==' );
	//	$this->setOption( 'required', true );
	}

	public function isValidInternal($value = null) {
		$expression = $this->getOption( 'expression' );

		$value = array_values( $value );

		if (is_array( $value ) && count( $value ) != 2 ) {
			$this->throwException( 'WikiaValidatorCompare: value need to be array with two elements' );
		}

		$valid = $this->doCompare( $expression, $value[0], $value[1] );

		if(!$valid) {
			$this->createError( 'compare_fail' );
			return false;
		}

		return true;
	}

	protected function doCompare( $expression, $leftValue, $rightValue ) {
		switch ($expression)
		{
			case self::GREATER_THAN:
				return $leftValue > $rightValue;

			case self::GREATER_THAN_EQUAL:
				return $leftValue >= $rightValue;

			case self::LESS_THAN:
				return $leftValue < $rightValue;

			case self::LESS_THAN_EQUAL:
				return $leftValue <= $rightValue;

			case self::NOT_EQUAL:
				return $leftValue != $rightValue;

			case self::EQUAL:
				return $leftValue == $rightValue;

			default:
				$this->throwException( 'WikiaValidatorCompare: no expression ' . $this->getOption('expression') );
		}
	}

}
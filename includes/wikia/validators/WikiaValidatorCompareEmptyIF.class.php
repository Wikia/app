<?php
/**
 * Let's use a validator only if one value is or is not empty
 *
 * @author Andrzej 'nAndy' Łukaszewski
 */
class WikiaValidatorCompareEmptyIF extends WikiaValidatorCompareValueIF {
	const EMPTY_VALUE = 'empty';
	const NOT_EMPTY_VALUE = 'not_empty';

	/**
	 * Overwritten method; sets default values for new options
	 *
	 * @param array $options options that will be set
	 */
	protected function config( array $options = array() ) {
		$this->setOption( 'condition', self::EMPTY_VALUE );
		$this->setOption( 'validator', false );
		return parent::config();
	}

	protected function configMsgs( array $msgs = array() ) {
		$this->setMsg( 'compare_fail', 'wikia-validator-compare-emty-if-fail' );
	}

	/**
	 * Overwritten method;
	 *
	 * First element should be for example a textarea name, second
	 * a validator which will proceed if the first is empty or is not empty
	 * (depends on condition).
	 *
	 * @param array $value array with two elements (field and validator)
	 */
	public function isValidInternal($value = null) {
		$condition = $this->getOption( 'condition' );

		$value = array_values($value);

		if( is_array($value) && count($value) != 2 ) {
			$this->throwException( 'WikiaValidatorCompareEmptyIF: passed value need to be an array with two elements' );
		}

		$valid = $this->doCompare($condition, $value[0]);
		$validator =  $this->getOption( 'validator' );

		if( ($valid) && $validator !== false ) {
			if( !$validator->isValid($value[1]) ) {
				$this->setError( $validator->getError() );
				return false;
			}
		}

		return true;
	}

	/**
	 * Overwritten method; Depending on condition returns true or false
	 *
	 * @param string $condition one of two WikiaValidatorCompareEmptyIF::EMPTY_VALUE, WikiaValidatorCompareEmptyIF::NOT_EMPTY_VALUE
	 * @param string $value the value which will be checked
	 *
	 * @return boolean
	 * @throws WikiaValidatorCompareEmptyIF: no expression exception
	 */
	protected function doCompare($condition, $value) {
		switch($condition)
		{
			case self::EMPTY_VALUE:
				return empty($value);

			case self::NOT_EMPTY_VALUE:
				return !empty($value);

			default:
				$this->throwException( 'WikiaValidatorCompareEmptyIF: no expression ' . $this->getOption('condition') );
		}
	}

}
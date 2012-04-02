<?php

class WikiaValidatorsGroups extends  WikiaValidator
{
	function __construct(array $options = array(), array $msg = array()) {
		$this->msg = array(
			'no_element'  => wfMsg("wikia-validator-array-no-element"),
		);
		$this->options = array(
			'validators' => array()
		);
		parent::__construct($options, $msg);
	}

	public function isValid($value = null) {
		$this->error = array();
		if(!is_array($value)) {
			throw new Exception('WikiaValidatorArray: $value is not array' );
		}

		foreach($this->options['validators'] as $key => $validator) {
			if(!is_object($validator) || !is_a ( $validator , 'WikiaValidator' )) {
				throw new Exception('WikiaValidatorArray: one of validators is not implements of WikiaValidator' );
			}

			$validator_value = isset($value[$key]) ? $value[$key]:'';
			if(!$validator->isValid($validator_value)) {
				$this->error[$key] = $validator->getErrors($validator_value);
			}
		}
		return empty($this->error);
	}
}
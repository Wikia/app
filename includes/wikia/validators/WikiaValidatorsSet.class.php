<?php

class WikiaValidatorsSet extends  WikiaValidatorListBase
{
	protected function config( array $options = array() ) {

		if(isset($options['validators'])) {
			throw new Exception( 'WikiaValidatorsSet: to add validators use addValidator' );
		}

		$this->setOption( 'validators' , array());
		$this->setOption( 'required', true );
	}

	protected function configMsgs( array $msgs = array() ) {

	}

	public function isValidInternal($value = null) {
		$this->error = array();

		if(!is_array($value)) {
			throw new Exception( 'WikiaValidatorsSet: $value is not array' );
		}

		foreach( $this->getOption('validators') as $key => $validators ) {
			foreach($validators as $validator ) {
				$data =  $this->prepareField($value, $validator['passFields'] );

				$this->validator = $validator['validator'];

				if( !$this->isWikiaValidator($this->validator) ) {
					throw new Exception( 'WikiaValidatorArray: one of validators is not implements of WikiaValidator' );
				}

				$this->isValidListElement($key, $data);
			}
		}

		return empty($this->error);
	}

	protected function isValidListElement($key, $value) {
		if(!$this->validator->isValid( $value )) {
			$this->addError($key, $this->validator->getError());
		}
	}

	protected function prepareField($value, $passFields) {

		if( count($passFields) == 1 ) {
			return isset($value[$passFields[0]]) ? $value[$passFields[0]]:"";
		}

		$out =  array();
		foreach($value as $key => $subvalue) {
			if(in_array( $key, $passFields )) {
				$out[$key] = $subvalue;
			}
		}

		return $out;
	}

	public function addValidator($field, WikiaValidator $validator, array $passFields = array() ) {
		if(empty($passFields)) {
			$passFields[] = $field;
		}

		$this->options['validators'][$field][] = array(
			'validator' =>  $validator,
			"passFields" => $passFields
		);
	}

	public function addValidatorsFromHTMLformFields( $fields ) {
		foreach($fields as $key => $value ) {
			if(!empty($value['validator'])) {
				$this->addValidator($key, $value['validator']);
			}
		}
	}

	public function isValid($value = null) {
		if(is_a($value, 'HTMLForm') ) {
			$value = $value->mFieldData;
		}
		return parent::isValid($value);
	}

	static public  function arrayWalk($val, $key, Array &$obj) {
		array_push($obj, $val);
	}

	public function getErrors() {
		return $this->getError();
	}

	public function getErrorsFlat(){
		$output = array();
		$input = $this->getError();
		array_walk_recursive($input, 'WikiaValidatorsSet::arrayWalk', $output);
		return $output;
	}
}

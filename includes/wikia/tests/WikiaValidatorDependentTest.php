<?php
class WikiaValidatorDependentTest extends WikiaBaseTest {
	
	public function testIsValidInternalWithInvalidDependentField() {
		$validator= new WikiaValidatorDependent(array(
			'required' => false,
			'ownValidator' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 1
				)
			),
			'dependentFieldCondition' => WikiaValidatorDependent::CONDITION_NOT_EMPTY
		));

		$this->setExpectedException('Exception');
		
		$validator->isValid('testValue');
	}

	public function testIsValidInternalWithInvalidOwnValidator() {
		$validator= new WikiaValidatorDependent(array(
			'required' => false,
			'dependentField' => 'aFormFieldName',
			'dependentFieldCondition' => WikiaValidatorDependent::CONDITION_NOT_EMPTY
		));

		$this->setExpectedException('Exception');

		$validator->isValid('testValue');
	}
	
}
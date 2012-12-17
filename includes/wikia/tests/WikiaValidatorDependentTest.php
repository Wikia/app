<?php
class WikiaValidatorDependentTest extends WikiaBaseTest {
	
	public function testIsValidWithInvalidConfigParams() {
		$wikiaValidatorStringStub = $this->getMock('WikiaValidatorString');
		
		//no dependentField passed
		$validator = new WikiaValidatorDependent(array(
			'required' => false,
			'ownValidator' => $wikiaValidatorStringStub,
			'dependentFieldCondition' => WikiaValidatorDependent::CONDITION_NOT_EMPTY
		));
		$this->setExpectedException('Exception');
		$validator->isValid('testValue');

		//no ownValidator passed
		$validator = new WikiaValidatorDependent(array(
			'required' => false,
			'dependentField' => 'aFormFieldName',
			'dependentFieldCondition' => WikiaValidatorDependent::CONDITION_NOT_EMPTY
		));
		$this->setExpectedException('Exception');
		$validator->isValid('testValue');

		//invalid ownValidator passed
		$validator = new WikiaValidatorDependent(array(
			'required' => false,
			'ownValidator' => new stdClass(),
			'dependentField' => 'aFormFieldName',
			'dependentFieldCondition' => WikiaValidatorDependent::CONDITION_NOT_EMPTY
		));
		$this->setExpectedException('Exception');
		$validator->isValid('testValue');
	}

	public function testIsValid() {
		$wikiaValidatorStringStub = $this->getMock('WikiaValidatorString');
		$wikiaValidatorStringStub->expects($this->any())->method('isValid')->will($this->returnValue(true));

		//validate the field only if "aFormFieldName" value is not empty ('dependentFieldCondition' => WikiaValidatorDependent::CONDITION_NOT_EMPTY) 
		$validator = new WikiaValidatorDependent(array(
			'required' => false,
			'ownValidator' => $wikiaValidatorStringStub,
			'dependentField' => 'aFormFieldName',
			'dependentFieldCondition' => WikiaValidatorDependent::CONDITION_NOT_EMPTY
		));

		//CORRECT dependent field not empty, so we validate & own validator's method isValid() returns true
		$validator->setFormData(array(
			'aFormFieldName' => 'aFormFieldValue'
		));
		$this->assertEquals(true, $validator->isValid('aValue'));

		//CORRECT -- dependent field empty, so we won't validate -- no error
		$validator->setFormData(array(
			'aFormFieldName' => ''
		));
		$this->assertEquals(true, $validator->isValid('aValue'));

		//FAILED -- dependent field not empty but own validator's method isValid() returns false
		$wikiaValidatorStringStub = $this->getMock('WikiaValidatorString');
		$wikiaValidatorStringStub->expects($this->any())->method('isValid')->will($this->returnValue(false));
		$validator = new WikiaValidatorDependent(array(
			'required' => false,
			'ownValidator' => $wikiaValidatorStringStub,
			'dependentField' => 'aFormFieldName',
			'dependentFieldCondition' => WikiaValidatorDependent::CONDITION_NOT_EMPTY
		));
		$validator->setFormData(array(
			'aFormFieldName' => 'aFormFieldValue'
		));
		$this->assertEquals(false, $validator->isValid('aValue'));
	}
	
}
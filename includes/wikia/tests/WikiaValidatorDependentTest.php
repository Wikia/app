<?php
class WikiaValidatorDependentTest extends WikiaBaseTest {

	/**
	 * @dataProvider dataProviderWithInvalidConfigParams
	 */
	public function testIsValidWithInvalidConfigParams($validator, $exceptionName) {
		$this->setExpectedException($exceptionName);
		$validator->isValid('testValue');
	}
	
	public function dataProviderWithInvalidConfigParams() {
		$wikiaValidatorStringStub = $this->getMock('WikiaValidatorString');
		
		return array(
			//no ownValidator passed
			array(
				new WikiaValidatorDependent(array(
					'required' => false,
					'dependentFields' => array(
						'fieldName' => $wikiaValidatorStringStub
					)
				)),
				'WikiaValidatorGivenObjectIsNotWikiaValidator',
			),
			//invalid ownValidator passed
			array(
				new WikiaValidatorDependent(array(
					'required' => false,
					'ownValidator' => new stdClass(),
					'dependentFields' => array(
						'fieldName' => $wikiaValidatorStringStub
					)
				)),
				'WikiaValidatorGivenObjectIsNotWikiaValidator'
			),
			//no dependentField passed
			array(
				new WikiaValidatorDependent(array(
					'required' => false,
					'ownValidator' => $wikiaValidatorStringStub
				)),
				'WikiaValidatorDependentFieldEmptyException'
			),
		);
	}

	public function testIsValid() {
		$wikiaValidatorStringStub = $this->getMock('WikiaValidatorString');
		$wikiaValidatorStringStub->expects($this->any())->method('isValid')->will($this->returnValue(true));

		//validate the field only if "aFormFieldName" value is not empty
		$validator = new WikiaValidatorDependent(array(
			'required' => false,
			'ownValidator' => $wikiaValidatorStringStub,
			'dependentFields' => array(
				'aFormFieldName' => $wikiaValidatorStringStub
			)
		));

		//CORRECT dependent field not empty, so we validate & own validator's method isValid() returns true
		$validator->setFormData(array(
			'aFormFieldName' => 'aFormFieldValue'
		));
		$this->assertTrue($validator->isValid('aValue'));

		$wikiaValidatorStringStub = $this->getMock('WikiaValidatorString');
		$wikiaValidatorStringStub->expects($this->any())->method('isValid')->will($this->returnValue(false));

		//CORRECT -- dependent field empty, so we won't validate -- no error
		$validator->setFormData(array(
			'aFormFieldName' => ''
		));
		$this->assertTrue($validator->isValid('aValue'));

		//FAILED -- dependent field not empty but own validator's method isValid() returns false
		$wikiaValidatorUrlStub = $this->getMock('WikiaValidatorUrl');
		$wikiaValidatorUrlStub->expects($this->any())->method('isValid')->will($this->returnValue(true));

		$validator = new WikiaValidatorDependent(array(
			'required' => false,
			'ownValidator' => $wikiaValidatorStringStub,
			'dependentFields' => array(
				'aFormFieldName' => $wikiaValidatorUrlStub
			)
		));
		$validator->setFormData(array(
			'aFormFieldName' => 'aFormFieldValue'
		));
		$this->assertFalse($validator->isValid('aValue'));
	}
	
}

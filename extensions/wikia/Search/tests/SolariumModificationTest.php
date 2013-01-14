<?php

require_once( 'WikiaSearchBaseTest.php' );

class SolariumModificationTest extends WikiaSearchBaseTest
{

	//@todo write tests to handle the nested query capability we added
	/**
	 * @covers Solarium_Document_AtomicUpdate::addField
	 * @covers Solarium_Document_AtomicUpdate::getModifierForField
	 * @covers Solarium_Document_AtomicUpdate::setModifierForField
	 */
	public function testAtomicUpdateStoresModifier() {

		$doc = new Solarium_Document_AtomicUpdate();
		$doc->addField( 'foo', 'bar' );

		$modifiers = new ReflectionProperty( 'Solarium_Document_AtomicUpdate', '_modifiers' );
		$modifiers->setAccessible( true );
		$modifierArray = $modifiers->getValue( $doc );

		$this->assertEquals(
				Solarium_Document_AtomicUpdate::MODIFIER_SET,
				$modifierArray['foo'],
				'Solarium_Document_AtomicUpdate should set any added field to modify as a setter by default'
		);

		$this->assertNull(
				$doc->getModifierForField( 'baz' ),
				'Solarium_Document_AtomicUpdate::getModifierForField should return the modifier string for the field provided, if not set'
		);

		try {
			$doc->addField('test', 'breaks', null, 'not a real modifier');
		} catch ( Exception $e ) { }

		$this->assertInstanceOf(
				'Exception',
				$e,
				'Solarium_Document_AtomicUpdate::setModifierForField should throw an exception if not passed a legal modifier'
		);

		$doc->addField( 'baz', 'qux', null, Solarium_Document_AtomicUpdate::MODIFIER_ADD );

		$this->assertEquals(
				Solarium_Document_AtomicUpdate::MODIFIER_ADD,
				$doc->getModifierForField( 'baz' ),
				'Solarium_Document_AtomicUpdate::getModifierForField should return the modifier string for the field provided, if set'
		);
	}

	/**
	 * @covers Solarium_Document_AtomicUpdate::setKey
	 * @covers Solarium_Document_AtomicUpdate::getFields
	 */
	public function testAtomicUpdateStoresKey() {

		$doc = new Solarium_Document_AtomicUpdate();

		try {
			$doc->getFields();
		} catch ( Exception $e1 ) { }

		$this->assertInstanceOf(
				'Exception',
				$e1,
				'Solarium_Document_AtomicUpdate should throw an exception if getFields() is called before a key is set to prevent malformed requests'
		);

		$doc->setKey('id', '123_456');

		$e2 = null;
		try {
			$doc->getFields();
		} catch ( Exception $e2 ) { }

		$this->assertNull(
				$e2,
				'Solarium_Document_AtomicUpdate should not throw an exception if getFields() is called after a key is set'
		);

		$modifiers = new ReflectionProperty( 'Solarium_Document_AtomicUpdate', '_modifiers' );
		$modifiers->setAccessible( true );
		$modifierArray = $modifiers->getValue( $doc );

		$this->assertEmpty(
				$modifierArray,
				'Solarium_Document_AtomicUpdate::setKey should not store a modifier for the unique key'
		);

		$keyRefl = new ReflectionProperty( 'Solarium_Document_AtomicUpdate', 'key' );
		$keyRefl->setAccessible( true );

		$this->assertEquals(
				'id',
				$keyRefl->getValue( $doc ),
				'Solarium_Document_AtomicUpdate::setKey should set the "key" member variable to the name of the field'
		);
	}

	/**
	 * @covers Solarium_Client_RequestBuilder_Update::buildAddXml
	 */
	public function testUpdateRequestBuilderAccommodatesAtomicUpdatesSingleValue() {

		$mockUpdate = $this->getMockBuilder( 'Solarium_Client_RequestBuilder_Update' )
							->disableOriginalConstructor()
							->setMethods( array( 'attrib', '_buildFieldXml', 'boolAttrib' ) )
							->getMock();

		$mockDocument = $this->getMock( 'Solarium_Document_AtomicUpdate', array( 'getBoost', 'getFieldBoost', 'getFields', 'getFieldModifier' ) );

		$mockCommand = $this->getMockBuilder( 'Solarium_Query_Update_Command_Add' )
							->disableOriginalConstructor()
							->setMethods( array( 'getOverwrite', 'getCommitWithin', 'getDocuments' ) )
							->getMock();

		$mockCommand
			->expects	( $this->at( 0 ) )
			->method	( 'getOverwrite' )
			->will		( $this->returnValue( true ) )
		;
		$mockUpdate
			->expects	( $this->at( 0 ) )
			->method	( 'boolAttrib' )
			->with		( 'overwrite', true )
			->will		( $this->returnValue( ' overwrite="true"' ) )
		;
		$mockCommand
			->expects	( $this->at( 1 ) )
			->method	( 'getCommitWithin' )
			->will		( $this->returnValue( 100) )
		;
		$mockUpdate
			->expects	( $this->at( 1 ) )
			->method	( 'attrib' )
			->with		( 'commitWithin', 100 )
			->will		( $this->returnValue( ' commitWithin="100"' ) )
		;
		$mockCommand
			->expects	( $this->at( 2 ) )
			->method	( 'getDocuments' )
			->will		( $this->returnValue( array( $mockDocument ) ) )
		;
		$mockDocument
			->expects	( $this->at( 0 ) )
			->method	( 'getBoost' )
			->will		( $this->returnValue( null ) )
		;
		$mockUpdate
			->expects	( $this->at( 2 ) )
			->method	( 'attrib' )
			->with		( 'boost', null )
			->will		( $this->returnValue( '' ) )
		;
		$mockDocument
			->expects	( $this->at( 1 ) )
			->method	( 'getFields' )
			->will		( $this->returnValue( array( 'id' => '123_456', 'views' => 100 ) ) )
		;
		$mockDocument
			->expects	( $this->at( 2 ) )
			->method	( 'getFieldBoost' )
			->with		( 'id' )
			->will		( $this->returnValue( null ) )
		;
		$mockDocument
			->expects	( $this->at( 3 ) )
			->method	( 'getFieldModifier' )
			->with		( 'id' )
			->will		( $this->returnValue( null ) )
		;
		$mockUpdate
			->expects	( $this->at( 3 ) )
			->method	( '_buildFieldXml' )
			->with		( 'id', null, '123_456', null )
			->will		( $this->returnValue( '<field name="id">123_456</field>' ) )
		;
		$mockDocument
			->expects	( $this->at( 4 ) )
			->method	( 'getFieldBoost' )
			->with		( 'views' )
			->will		( $this->returnValue( null ) )
		;
		$mockDocument
			->expects	( $this->at( 5 ) )
			->method	( 'getFieldModifier' )
			->with		( 'views' )
			->will		( $this->returnValue( Solarium_Document_AtomicUpdate::MODIFIER_SET ) )
		;
		$mockUpdate
			->expects	( $this->at( 4 ) )
			->method	( '_buildFieldXml' )
			->with		( 'views', null, '100', 'set' )
			->will		( $this->returnValue( '<field name="views" update="set">100</field>' ) )
		;

		$expected = <<<END
<add overwrite="true" commitWithin="100"><doc><field name="id">123_456</field><field name="views" update="set">100</field></doc></add>
END;

		$this->assertEquals(
				$expected,
				$mockUpdate->buildAddXml( $mockCommand ),
				'Solarium_Client_RequestBuilder_Update::buildAddXml should pass the appropriate values to _buildFieldXml to accommodate atomic updates'
		);
	}

	/**
	 * @covers Solarium_Client_RequestBuilder_Update::buildAddXml
	 */
	public function testUpdateRequestBuilderAccommodatesAtomicUpdatesMultiValue() {

		$mockUpdate = $this->getMockBuilder( 'Solarium_Client_RequestBuilder_Update' )
							->disableOriginalConstructor()
							->setMethods( array( 'attrib', '_buildFieldXml', 'boolAttrib' ) )
							->getMock();

		$mockDocument = $this->getMock( 'Solarium_Document_AtomicUpdate', array( 'getBoost', 'getFieldBoost', 'getFields', 'getFieldModifier' ) );

		$mockCommand = $this->getMockBuilder( 'Solarium_Query_Update_Command_Add' )
							->disableOriginalConstructor()
							->setMethods( array( 'getOverwrite', 'getCommitWithin', 'getDocuments' ) )
							->getMock();

		$mockCommand
			->expects	( $this->at( 0 ) )
			->method	( 'getOverwrite' )
			->will		( $this->returnValue( true ) )
		;
		$mockUpdate
			->expects	( $this->at( 0 ) )
			->method	( 'boolAttrib' )
			->with		( 'overwrite', true )
			->will		( $this->returnValue( ' overwrite="true"' ) )
		;
		$mockCommand
			->expects	( $this->at( 1 ) )
			->method	( 'getCommitWithin' )
			->will		( $this->returnValue( 100) )
		;
		$mockUpdate
			->expects	( $this->at( 1 ) )
			->method	( 'attrib' )
			->with		( 'commitWithin', 100 )
			->will		( $this->returnValue( ' commitWithin="100"' ) )
		;
		$mockCommand
			->expects	( $this->at( 2 ) )
			->method	( 'getDocuments' )
			->will		( $this->returnValue( array( $mockDocument ) ) )
		;
		$mockDocument
			->expects	( $this->at( 0 ) )
			->method	( 'getBoost' )
			->will		( $this->returnValue( null ) )
		;
		$mockUpdate
			->expects	( $this->at( 2 ) )
			->method	( 'attrib' )
			->with		( 'boost', null )
			->will		( $this->returnValue( '' ) )
		;
		$mockDocument
			->expects	( $this->at( 1 ) )
			->method	( 'getFields' )
			->will		( $this->returnValue( array( 'id' => '123_456', 'redirect_titles' => array( 'stuff', 'things' ) ) ) )
		;
		$mockDocument
			->expects	( $this->at( 2 ) )
			->method	( 'getFieldBoost' )
			->with		( 'id' )
			->will		( $this->returnValue( null ) )
		;
		$mockDocument
			->expects	( $this->at( 3 ) )
			->method	( 'getFieldModifier' )
			->with		( 'id' )
			->will		( $this->returnValue( null ) )
		;
		$mockUpdate
			->expects	( $this->at( 3 ) )
			->method	( '_buildFieldXml' )
			->with		( 'id', null, '123_456', null )
			->will		( $this->returnValue( '<field name="id">123_456</field>' ) )
		;
		$mockDocument
			->expects	( $this->at( 4 ) )
			->method	( 'getFieldBoost' )
			->with		( 'redirect_titles' )
			->will		( $this->returnValue( null ) )
		;
		$mockDocument
			->expects	( $this->at( 5 ) )
			->method	( 'getFieldModifier' )
			->with		( 'redirect_titles' )
			->will		( $this->returnValue( Solarium_Document_AtomicUpdate::MODIFIER_ADD ) )
		;
		$mockUpdate
			->expects	( $this->at( 4 ) )
			->method	( '_buildFieldXml' )
			->with		( 'redirect_titles', null, 'stuff', 'add' )
			->will		( $this->returnValue( '<field name="redirect_titles" update="add">stuff</field>' ) )
		;
		$mockUpdate
			->expects	( $this->at( 5 ) )
			->method	( '_buildFieldXml' )
			->with		( 'redirect_titles', null, 'things', 'add' )
			->will		( $this->returnValue( '<field name="redirect_titles" update="add">things</field>' ) )
		;

		$expected = <<<END
<add overwrite="true" commitWithin="100"><doc><field name="id">123_456</field><field name="redirect_titles" update="add">stuff</field><field name="redirect_titles" update="add">things</field></doc></add>
END;

		$this->assertEquals(
				$expected,
				$mockUpdate->buildAddXml( $mockCommand ),
				'Solarium_Client_RequestBuilder_Update::buildAddXml should pass the appropriate values to _buildFieldXml to accommodate atomic updates'
		);
	}

	/**
	 * @covers Solarium_Client_RequestBuilder_Update::_buildFieldXml
	 */
	public function testBuildFieldXmlWithModifier() {
		$mockUpdate = $this->getMockBuilder( 'Solarium_Client_RequestBuilder_Update' )
							->disableOriginalConstructor()
							->setMethods( array( 'attrib' ) )
							->getMock();

		$mockUpdate
			->expects	( $this->at( 0 ) )
			->method	( 'attrib' )
			->with		( 'boost', null )
			->will		( $this->returnValue( '' ) )
		;
		$mockUpdate
			->expects	( $this->at( 1 ) )
			->method	( 'attrib' )
			->with		( 'update', 'set' )
			->will		( $this->returnValue( ' update="set"' ) )
		;

		$buildFieldXml = new ReflectionMethod( 'Solarium_Client_RequestBuilder_Update', '_buildFieldXml' );
		$buildFieldXml->setAccessible( true );

		$expected = <<<END
<field name="foo" update="set">bar</field>
END;

		$this->assertEquals(
				$expected,
				$buildFieldXml->invoke( $mockUpdate, 'foo', null, 'bar', 'set' )
		);
	}

}

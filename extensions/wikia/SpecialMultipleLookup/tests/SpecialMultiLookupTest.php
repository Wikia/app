<?php

class SpecialMultiLookupTest extends WikiaBaseTest {
	/** @var SpecialMultiLookup $specialMultiLookup */
	private $specialMultiLookup;

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../SpecialMultipleLookup.php';
		parent::setUp();

		/** @var IContextSource|PHPUnit_Framework_MockObject_MockObject $context */
		$context = $this->createMock( RequestContext::class );

		$context->expects( $this->any() )
			->method( 'msg' )
			->willReturnCallback( function ( $key ) {
				return new RawMessage( $key );
			} );

		$this->specialMultiLookup = new SpecialMultiLookup();
		$this->specialMultiLookup->setContext( $context );
	}

	public function testSubmitProcessing() {
		$result = $this->specialMultiLookup->onSubmit( [] );

		$this->assertFalse( $result );

		$result = $this->specialMultiLookup->onSubmit( [ 'target' => 'karamba' ] );

		$this->assertEquals( 'multilookupinvaliduser', $result );
	}
}

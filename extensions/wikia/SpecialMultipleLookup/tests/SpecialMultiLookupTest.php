<?php

class SpecialMultiLookupTest extends WikiaBaseTest {
	/** @var SpecialMultiLookup $specialMultiLookup */
	private $specialMultiLookup;
	/** @var User|PHPUnit_Framework_MockObject_MockObject $user */
	private $user;

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../SpecialMultipleLookup.php';
		parent::setUp();

		$this->user = $this->createMock( User::class );
		/** @var IContextSource|PHPUnit_Framework_MockObject_MockObject $context */
		$context = $this->createMock( RequestContext::class );

		$context->expects( $this->any() )
			->method( 'msg' )
			->willReturnCallback( function ( $key ) {
				return new RawMessage( $key );
			} );
		$context->expects( $this->any() )
			->method( 'getUser' )
			->willReturn( $this->user );

		$this->specialMultiLookup = new SpecialMultiLookup();
		$this->specialMultiLookup->setContext( $context );
	}

	public function testRestrictionsAreApplied() {
		$this->expectException( PermissionsError::class );

		$this->specialMultiLookup->execute( '' );
	}

	public function testSubmitProcessing() {
		$result = $this->specialMultiLookup->onSubmit( [] );

		$this->assertFalse( $result );

		$result = $this->specialMultiLookup->onSubmit( [ 'target' => 'karamba' ] );

		$this->assertEquals( 'multilookupinvaliduser', $result );
	}
}

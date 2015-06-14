<?php
class PiggybackTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile =  __DIR__ . '/../Piggyback.php';
		parent::setUp();
	}

	public function testEfPiggybackRequestContextOverrideUserOverride() {
		$originalUser = 'OriginalUser';
		$newUser = 'NewUser';

		$this->mockStaticMethod( 'PBLoginForm', 'isPiggyback', true );
		$this->mockStaticMethod( 'User', 'newFromSession', $newUser );

		$testUser = $originalUser;
		$result = efPiggybackRequestContextOverrideUser( $testUser, null );

		$this->assertEquals( $testUser, $newUser );
		$this->assertFalse( $result );
	}

	public function testEfPiggybackRequestContextOverrideUserDoNotOverride() {
		$originalUser = 'OriginalUser';
		$newUser = 'NewUser';

		$this->mockStaticMethod( 'PBLoginForm', 'isPiggyback', false );

		$testUser = $originalUser;
		$result = efPiggybackRequestContextOverrideUser( $testUser, null );

		$this->assertEquals( $testUser, $originalUser );
		$this->assertTrue( $result );
	}
}

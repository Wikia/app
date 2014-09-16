<?php

/**
 * "Set" of unit tests for CreateWiki class
 *
 * @author Michał Roszka <michal@wikia-inc.com>
 *
 * @category Wikia
 * @group Integration
 */
class CreateWikiTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../CreateNewWiki_setup.php';
		parent::setUp();
		$this->mockGlobalVariable( 'wgMemc', new EmptyBagOStuff() );
	}

	public function testWgUploadDirectoryExistsAssertion() {
		$this->setExpectedException('\Wikia\Util\AssertionException');
		$this->mockStaticMethod( 'WikiFactory', 'getVarIdByName', null);
		CreateWiki::wgUploadDirectoryExists( 'whatever-input' );
	}
	
	public function testWgUploadDirectoryExists() {
		$this->mockStaticMethod( 'WikiFactory', 'getVarIdByName', 17 );

		$this->mockStaticMethod( 'WikiFactory', 'getCityIDsFromVarValue', [] );
		$this->assertFalse( CreateWiki::wgUploadDirectoryExists( 'a-directory-that-does-not-exist' ) );

		$this->mockStaticMethod( 'WikiFactory', 'getCityIDsFromVarValue', [ 1, 2, 3, 5, 8, 12 ] );
		$this->assertTrue( CreateWiki::wgUploadDirectoryExists( 'a-directory-that-does-exist' ) );
	}
}

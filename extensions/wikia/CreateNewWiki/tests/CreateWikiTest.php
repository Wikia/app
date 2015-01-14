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
	}

	public function testWgUploadDirectoryExistsAssertion() {
		$this->setExpectedException('\Wikia\Util\AssertionException');
		$this->mockStaticMethod( 'WikiFactory', 'getVarIdByName', false);
		CreateWiki::wgUploadDirectoryExists( 'whatever-input' );
	}
	
	public function testWgUploadDirectoryExists() {
		$this->mockStaticMethod( 'WikiFactory', 'getVarIdByName', 17 );

		$this->mockStaticMethod( 'WikiFactory', 'getCityIDsFromVarValue', [] );
		$this->assertFalse( CreateWiki::wgUploadDirectoryExists( 'a-directory-that-does-not-exist' ) );

		$this->mockStaticMethod( 'WikiFactory', 'getCityIDsFromVarValue', [ 1, 2, 3, 5, 8, 12 ] );
		$this->assertTrue( CreateWiki::wgUploadDirectoryExists( 'a-directory-that-does-exist' ) );
	}

	/**
	 * @dataProvider provideSanitizeS3BucketName
	 */
	public function testSanitizeS3BucketName( $in, $out ) {
		$method = new ReflectionMethod('CreateWiki','sanitizeS3BucketName');
		$method->setAccessible(true);

		$this->assertEquals($out, $method->invokeArgs(null,[$in]));
	}

	public function provideSanitizeS3BucketName() {
		return [
			'0' => [ '0', '0' ],
			'muppet' => [ 'muppet', 'muppet' ],
			'with trailing underscores' => [ 'x__', 'x__0' ],
			'with dots' => [ 'ru.google', 'ru_google' ],
			'with spaces' => [ 'save earth save life', 'save_earth_save_life' ],
			'with parenthesis' => [ 'roman_empire_(the rebirth of rome)', 'roman_empire__the_rebirth_of_rome_0' ],
			'long' => [ '012345678901234567890123456789012345678901234567890123456789', '0123456789012345678901234567890123456789012345678901234' ],
			'capital' => [ 'ABC', 'abc' ],
			'invalid-chars' => [ '@HF(^&HG@$OGH', '40hf285e26hg4024ogh' ],
			'polish' => [ 'ąćśę', 'c485c487c59bc499' ],
			'long-polish' => [ '012345678901234567890123456789012345678901234567890123ą', '012345678901234567890123456789012345678901234567890123c' ],
			'chinese' => [ '不論支持與否', 'e4b88de8ab96e694afe68c81e88887e590a6' ],
		];
	}

}

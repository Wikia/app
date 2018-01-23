<?php

use PHPUnit\Framework\TestCase;

class SkinChooserTest extends TestCase {
	/** @var IContextSource $context */
	private $context;
	/** @var FauxRequest $request */
	private $request;

	protected function setUp() {
		parent::setUp();

		$this->request = new FauxRequest();

		$this->context = new RequestContext();
		$this->context->setRequest( $this->request );
	}

	/**
	 * @dataProvider xSkinHeaderProvider
	 * @param string $headerValue
	 * @param string $expectedParamValue
	 */
	public function testXSkinHeaderIsMappedToRequestParam( string $headerValue, string $expectedParamValue ) {
		$this->request->setHeader( 'X-Skin', $headerValue );

		SkinChooser::onGetSkin( $this->context );

		$this->assertEquals( $expectedParamValue, $this->request->getVal( 'useskin' ) );
	}

	public function xSkinHeaderProvider(): Traversable {
		yield 'X-Skin: mercury is mapped to wikiamobile' => [ 'mercury', 'wikiamobile' ];

		foreach ( array_keys( Skin::SKINS ) as $skinName ) {
			yield "X-Skin: $skinName is supported" => [ $skinName, $skinName ];
		}
	}

	public function testXSkinHeaderHasNoEffectForInvalidSkin() {
		$this->request->setHeader( 'X-Skin', 'karamba' );

		SkinChooser::onGetSkin( $this->context );

		$this->assertNull( $this->request->getVal( 'useskin' ) );
	}

	public function testValidXSkinHeaderOverridesRequestParam() {
		$this->request->setVal( 'useskin', 'monobook' );
		$this->request->setHeader( 'X-Skin', 'oasis' );

		SkinChooser::onGetSkin( $this->context );

		$this->assertEquals( 'oasis', $this->request->getVal( 'useskin' ) );
	}

	/**
	 * @dataProvider legacySkinProvider
	 * @param string $rawValue
	 * @param string $mappedParamValue
	 */
	public function testLegacySkinNamesProvidedInRequestParamAreMapped( string $rawValue, string $mappedParamValue ) {
		$this->request->setVal( 'useskin', $rawValue );

		SkinChooser::onGetSkin( $this->context );

		$this->assertEquals( $mappedParamValue, $this->request->getVal( 'useskin' ) );
	}

	public function legacySkinProvider(): Traversable {
		yield 'mercury is mapped to wikiamobile' => [ 'mercury', 'wikiamobile' ];
		yield 'wikia is mapped to oasis' => [ 'wikia', 'oasis' ];
	}
}

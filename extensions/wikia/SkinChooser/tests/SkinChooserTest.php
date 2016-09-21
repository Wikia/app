<?php

class SkinChooserTest extends WikiaBaseTest {

	function setUp() {
		parent::setUp();
		$this->mockGlobalVariable('wgDefaultSkin', 'oasis');
	}

	/**
	 * @param string||false $headerValue
	 * @param string $expectedSkinClass
	 *
	 * @dataProvider onGetSkinProvider
	 */
	function testOnGetSkin( $headerValue, $expectedSkinClass ) {
		$context = $this->mockClassWithMethods( 'RequestContext', [
			'getRequest' => $this->mockClassWithMethods( 'WebRequest', [
				'getHeader' => $headerValue
			] ),
			'getUser' => $this->mockClassWithMethods( 'User', [
				'isLoggedIn' => false
			] )
		] );

		SkinChooser::onGetSkin( $context, $skin );

		if ($expectedSkinClass !== null) {
			$this->assertInstanceOf( $expectedSkinClass, $skin );
		}
		else {
			$this->assertNull( $skin );
		}
	}

	function onGetSkinProvider() {
		return [
			[ 'dynks', null ], # SkinChooser logic leaves early when X-Skin is set to an unknown skin (and returns no skin instance)
			[ false, SkinOasis::class ], # use $wgDefaultSkin (for anons)
			[ 'monobook', SkinMonoBook::class ],
			[ 'oasis', SkinOasis::class ],
			[ 'wikia', SkinOasis::class ],
			[ 'uncyclopedia', SkinUncyclopedia::class ],
			[ 'mercury', SkinWikiaMobile::class ],
		];
	}
}

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
		/** @var WebRequest $requestMock */
		$requestMock = $this->createConfiguredMock( WebRequest::class, [
			'getHeader' => $headerValue
		] );

		/** @var User $userMock */
		$userMock = $this->createConfiguredMock( User::class, [
			'isLoggedIn' => false
		] );

		$this->mockGlobalVariable('wgDefaultSkin', 'oasis');

		$context = new RequestContext();
		$context->setRequest( $requestMock );
		$context->setUser( $userMock );

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
			[ 'oasis', SkinOasis::class ],
			[ 'wikia', SkinOasis::class ],
			[ 'mercury', SkinWikiaMobile::class ],
			// legacy skins - fallback to oasis
			[ 'uncyclopedia', null ],
			[ 'monobook', null ],
		];
	}


	/**
	 * @param string||false $paramValue
	 * @param string $expectedSkinClass
	 *
	 * @dataProvider useSkinProvider
	 */
	function testUseSkin( $paramValue, $expectedSkinClass ) {
		/** @var WebRequest $requestMock */
		$requestMock = $this->createConfiguredMock( WebRequest::class, [
			'getVal' => $paramValue
		] );

		/** @var User $userMock */
		$userMock = $this->createConfiguredMock( User::class, [
			'isLoggedIn' => false
		] );

		/** @var Title $titleMock */
		$titleMock = $this->createConfiguredMock( Title::class, [] );

		$this->mockGlobalVariable('wgDefaultSkin', 'oasis');

		$context = new RequestContext();
		$context->setRequest( $requestMock );
		$context->setUser( $userMock );
		$context->setTitle( $titleMock );

		SkinChooser::onGetSkin( $context, $skin );

		if ($expectedSkinClass !== null) {
			$this->assertInstanceOf( $expectedSkinClass, $skin );
		}
		else {
			$this->assertNull( $skin );
		}
	}

	function useSkinProvider() {
		yield [ 'dynks', SkinOasis::class ];
		yield [ false, SkinOasis::class ]; # use $wgDefaultSkin (for anons)
		yield [ 'oasis', SkinOasis::class ];
		yield [ 'wikia', SkinOasis::class ];
		yield [ 'wikiamobile', SkinWikiaMobile::class ];
		yield [ 'mercury', SkinWikiaMobile::class ];

		// legacy skins - fallback to oasis
		yield [ 'uncyclopedia', SkinOasis::class ];
		yield [ 'monobook', SkinOasis::class ];
		yield [ 'vector', SkinOasis::class ];
	}
}

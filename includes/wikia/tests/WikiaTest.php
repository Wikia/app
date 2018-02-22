<?php

/**
 * @group WikiaTest
 */
class WikiaTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/includes/wikia/Wikia.php";
		parent::setUp();
	}

	/**
	 * @param array $fileMockData
	 * @param string $expectedUrl
	 * @param string $expectedSize
	 *
	 * @dataProvider getWikiLogoMetadataDataProvider
	 */
	public function testGetWikiLogoMetadata( $fileMockData, $expectedUrl, $expectedSize ) {
		$fileMock = $this->createConfiguredMock( LocalFile::class, $fileMockData );

		$this->mockGlobalFunction( 'wfLocalFile', $fileMock );
		$this->mockGlobalVariable( 'wgResourceBasePath', 'http://wikia.net/__cb123' );

		$logoData = Wikia::getWikiLogoMetadata();

		$this->assertEquals( $expectedUrl, $logoData['url'] );
		$this->assertEquals( $expectedSize, $logoData['size'] );
	}

	public function getWikiLogoMetadataDataProvider() {
		return [
			[
				'fileMockData' => [
					'exists' => false,
				],
				// see wgResourceBasePath mock above
				'expectedUrl' => 'http://wikia.net/__cb123/skins/common/images/wiki.png',
				'expectedSize' => '155x155',
			],
			[
				'fileMockData' => [
					'exists' => true,
					'getUrl' => '/foo.png',
					'getWidth' => 42,
					'getHeight' => 32,
				],
				'expectedUrl' => '/foo.png',
				'expectedSize' => '42x32',
			],
		];
	}

	public function testOnSkinTemplateOutputPageBeforeExec_setsNoIndexNoFollowBecauseHeaders() {
		$this->mockProdEnv();

		$request = new FauxRequest();
		$request->setHeader( 'X-Staging', 'externaltest' );

		$context = new RequestContext();
		$context->setTitle( new Title() );
		$context->setRequest( $request );

		$skinTemplate = new SkinTemplate();
		$quickTemplate = new OasisTemplate();

		$skinTemplate->thisquery = 'foo';
		$skinTemplate->setContext( $context );

		Wikia::onSkinTemplateOutputPageBeforeExec( $skinTemplate, $quickTemplate );

		$this->assertContains(
			'<meta name="robots" content="noindex,nofollow" />',
			$context->getOutput()->getHeadLinks()
		);
		$this->assertEquals( 'foo', $quickTemplate->get( 'thisquery' ) );
	}

	public function testOnSkinTemplateOutputPageBeforeExec_setsNoIndexNoFollowBecauseDevbox() {
		$this->mockDevEnv();

		$context = new RequestContext();
		$context->setTitle( new Title() );
		$context->setRequest( new FauxRequest() );

		$skinTemplate = new SkinTemplate();
		$quickTemplate = new OasisTemplate();

		$skinTemplate->thisquery = 'foo';
		$skinTemplate->setContext( $context );

		Wikia::onSkinTemplateOutputPageBeforeExec( $skinTemplate, $quickTemplate );

		$this->assertContains(
			'<meta name="robots" content="noindex,nofollow" />',
			$context->getOutput()->getHeadLinks()
		);
		$this->assertEquals( 'foo', $quickTemplate->get( 'thisquery' ) );
	}

	public function testOnSkinTemplateOutputPageBeforeExec_setsNoIndexNoFollowBecauseStaging() {
		$this->mockStagingEnv();

		$context = new RequestContext();
		$context->setTitle( new Title() );
		$context->setRequest( new FauxRequest() );

		$skinTemplate = new SkinTemplate();
		$quickTemplate = new OasisTemplate();

		$skinTemplate->thisquery = 'foo';
		$skinTemplate->setContext( $context );

		Wikia::onSkinTemplateOutputPageBeforeExec( $skinTemplate, $quickTemplate );

		$this->assertContains(
			'<meta name="robots" content="noindex,nofollow" />',
			$context->getOutput()->getHeadLinks()
		);
	}

	public function testOnSkinTemplateOutputPageBeforeExec_doesNotSetNoIndexNoFollow() {
		$this->mockProdEnv();

		$context = new RequestContext();
		$context->setTitle( new Title() );
		$context->setRequest( new FauxRequest() );

		$skinTemplate = new SkinTemplate();
		$quickTemplate = new OasisTemplate();

		$skinTemplate->thisquery = 'foo';
		$skinTemplate->setContext( $context );

		Wikia::onSkinTemplateOutputPageBeforeExec( $skinTemplate, $quickTemplate );

		$this->assertNotContains(
			'<meta name="robots" content="noindex,nofollow" />',
			$context->getOutput()->getHeadLinks()
		);
		$this->assertEquals( 'foo', $quickTemplate->get( 'thisquery' ) );
	}
}

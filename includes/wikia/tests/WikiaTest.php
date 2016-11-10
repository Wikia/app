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
	 * @param LocalFile $fileMock
	 * @param string $expectedUrl
	 * @param string $expectedSize
	 *
	 * @dataProvider getWikiLogoMetadataDataProvider
	 */
	public function testGetWikiLogoMetadata( $fileMockData, $expectedUrl, $expectedSize ) {
		$fileMock = $this->mockClassWithMethods( 'stdClass', $fileMockData );

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
		$this->mockGlobalVariable('wgDevelEnvironment', false);
		$this->mockGlobalVariable('wgStagingEnvironment', false);

		$requestMock = $this->getRequestMock( 'externaltest' );
		$outMock = $this->getOutputpageMock( 'once' );
		$skinMock = $this->getSkinTemplateMock( $requestMock, $outMock );
		$templateMock = $this->getTemplateMock();

		Wikia::onSkinTemplateOutputPageBeforeExec( $skinMock, $templateMock );
	}

	public function testOnSkinTemplateOutputPageBeforeExec_setsNoIndexNoFollowBecauseDevbox() {
		$this->mockGlobalVariable('wgDevelEnvironment', true);
		$this->mockGlobalVariable('wgStagingEnvironment', false);

		$requestMock = $this->getRequestMock( '' );
		$outMock = $this->getOutputpageMock( 'once' );
		$skinMock = $this->getSkinTemplateMock( $requestMock, $outMock );
		$templateMock = $this->getTemplateMock();

		Wikia::onSkinTemplateOutputPageBeforeExec( $skinMock, $templateMock );
	}

	public function testOnSkinTemplateOutputPageBeforeExec_setsNoIndexNoFollowBecauseStaging() {
		$this->mockGlobalVariable('wgDevelEnvironment', false);
		$this->mockGlobalVariable('wgStagingEnvironment', true);

		$requestMock = $this->getRequestMock( '' );
		$outMock = $this->getOutputpageMock( 'once' );
		$skinMock = $this->getSkinTemplateMock( $requestMock, $outMock );
		$templateMock = $this->getTemplateMock();

		Wikia::onSkinTemplateOutputPageBeforeExec( $skinMock, $templateMock );
	}

	public function testOnSkinTemplateOutputPageBeforeExec_doesNotSetNoIndexNoFollow() {
		$this->mockGlobalVariable('wgDevelEnvironment', false);
		$this->mockGlobalVariable('wgStagingEnvironment', false);
		$requestMock = $this->getRequestMock( '' );
		$outMock = $this->getOutputpageMock( 'never' );
		$skinMock = $this->getSkinTemplateMock( $requestMock, $outMock );
		$templateMock = $this->getTemplateMock();

		Wikia::onSkinTemplateOutputPageBeforeExec( $skinMock, $templateMock );
	}

	private function getSkinTemplateMock( $request, $output ) {
		$skinMock = $this->getMockBuilder( 'SkinTemplate' )
			->disableOriginalConstructor()
			->setMethods( [ 'getRequest', 'getOutput', 'getTitle', 'outputPage', 'setupSkinUserCss' ] )
			->getMock();
		$skinMock->expects( $this->once() )
			->method('getRequest')
			->willReturn( $request );
		$skinMock->expects( $this->any() )
			->method('getOutput')
			->willReturn( $output );
		$skinMock->expects( $this->once() )
			->method('getTitle')
			->willReturn(
				$this->getMockBuilder('Title')
					->disableOriginalConstructor()
					->getMock()
			);

		$skinMock->expects( $this->any() )
			->method('outputPage');
		$skinMock->expects( $this->any() )
			->method('setupSkinUserCss');

		return $skinMock;
	}

	private function getRequestMock( $headerValue ) {
		$requestMock = $this->getMockBuilder( 'WebRequest' )
			->disableOriginalConstructor()
			->setMethods( [ 'getHeader' ] )
			->getMock();
		$requestMock->expects( $this->once() )
			->method( 'getHeader' )
			->willReturn( $headerValue );

		return $requestMock;
	}

	private function getOutputpageMock( $expects ) {
		$outMock = $this->getMockBuilder('OutputPage')
			->disableOriginalConstructor()
			->setMethods( [ 'setRobotPolicy' ] )
			->getMock();
		$outMock->expects( $this->$expects() )
			->method( 'setRobotPolicy' );

		return $outMock;
	}

	private function getTemplateMock() {
		return $this->getMockBuilder( 'QuickTemplate' )
			->disableOriginalConstructor()
			->getMock();
	}
}

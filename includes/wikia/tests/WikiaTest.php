<?php

class WikiaTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/includes/wikia/Wikia.php";
		parent::setUp();
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

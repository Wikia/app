<?php
class AdEngine2HooksTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/AdEngine/AdEngine2Hooks.class.php";
		parent::setUp();
	}

	public function testOnSkinTemplateOutputPageBeforeExec_setsNoIndexNoFollow() {
		$requestMock = $this->getRequestMock( 'externaltest' );
		$outMock = $this->getOutputpageMock( 'once' );
		$skinMock = $this->getSkinMock( $requestMock, $outMock );
		$templateMock = '';

		AdEngine2Hooks::onSkinTemplateOutputPageBeforeExec( $skinMock, $templateMock );
	}

	public function testOnSkinTemplateOutputPageBeforeExec_doesNotSetNoIndexNoFollow() {
		$requestMock = $this->getRequestMock( '' );
		$outMock = $this->getOutputpageMock( 'never' );
		$skinMock = $this->getSkinMock( $requestMock, $outMock );
		$templateMock = '';

		AdEngine2Hooks::onSkinTemplateOutputPageBeforeExec( $skinMock, $templateMock );
	}

	private function getSkinMock( $request, $output ) {
		$skinMock = $this->getMockBuilder( 'Skin' )
			->disableOriginalConstructor()
			->setMethods( [ 'getRequest', 'getOutput', 'outputPage', 'setupSkinUserCss' ] )
			->getMock();
		$skinMock->expects( $this->once() )
			->method('getRequest')
			->willReturn( $request );
		$skinMock->expects( $this->any() )
			->method('getOutput')
			->willReturn( $output );

		$skinMock->expects( $this->any() )
			->method('outputPage');
		$skinMock->expects( $this->any() )
			->method('setupSkinUserCss');

		return $skinMock;
	}

	private function getRequestMock( $headerValue ) {
		$requestMock = $this->getMockBuilder( 'Request' )
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

}

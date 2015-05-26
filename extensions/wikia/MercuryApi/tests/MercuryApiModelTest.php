<?php
class MercuryApiModelTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/MercuryApi/MercuryApi.setup.php";
		parent::setUp();
	}

	/**
	* @dataProvider getSiteMessageDataProvider
	*/
	public function testGetSiteMessage( $expected, $isDisabled, $siteMessageMock, $wgSitenameMock ) {
		$messageMock = $this->getMockBuilder( 'Message' )
			->disableOriginalConstructor()
			->setMethods( [ 'inContentLanguage', 'isDisabled', 'text' ] )
			->getMock();

		$messageMock->expects( $this->once() )
			->method( 'isDisabled' )
			->willReturn( $isDisabled );

		$messageMock->expects( $this->any() )
			->method( 'text' )
			->willReturn( $siteMessageMock );

		$messageMock->expects( $this->once() )
			->method( 'inContentLanguage' )
			->willReturn( $messageMock );

		$this->mockGlobalVariable( 'wgSitename', $wgSitenameMock );
		$this->mockGlobalFunction( 'wfMessage', $messageMock );

		$mercuryApi = new MercuryApi();
		$this->assertEquals( $expected, $mercuryApi->getSiteMessage() );
	}

	public function getSiteMessageDataProvider() {
		return [
			[
				'$expected' => 'Test Wiki',
				'$isDisabled' => false,
				'$siteMessageMock' => 'Test Wiki'
			], [
				'$expected' => false,
				'$isDisabled' => true,
				'$siteMessageMock' => 'Test Wiki',
			], [
				'$expected' => false,
				'$isDisabled' => false,
				'$siteMessageMock' => '',
			]
		];
	}
}

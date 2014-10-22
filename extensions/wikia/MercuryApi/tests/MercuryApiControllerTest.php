<?php
class MercuryApiHooksTest  extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/MercuryApi/MercuryApi.setup.php";
		parent::setUp();
	}

	/**
	 * Once Mercury supports other context namespaces than NS_MAIN we can remove this test
	 */
	public function testGetRandomArticle_sets_namespace_to_main() {
		$mercuryControllerMock = $this->getMockBuilder( 'MercuryApiController' )
			->disableOriginalConstructor()
			->setMethods( ['getRandomPage', 'getArticle'] )
			->getMock();

		$requestMock = $this->getMockBuilder( 'WikiaRequest' )
			->disableOriginalConstructor()
			->setMethods( ['setVal'] )
			->getMock();

		$mercuryControllerMock->request = $requestMock;

		$randomPageMock = $this->getMockBuilder( 'RandomPage' )
			->disableOriginalConstructor()
			->setMethods( ['setNamespace', 'getRandomTitle'] )
			->getMock();

		$randomPageMock->expects( $this->once() )
			->method( 'setNamespace' )
			->with( NS_MAIN );

		$titleMock = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( ['getText'] )
			->getMock();

		$randomPageMock->expects( $this->once() )
			->method( 'getRandomTitle' )
			->willReturn( $titleMock );

		$mercuryControllerMock->expects( $this->once() )
			->method( 'getRandomPage' )
			->willReturn( $randomPageMock );

		/** @var MercuryApiController $mercuryControllerMock */
		$mercuryControllerMock->getRandomArticle();
	}

}
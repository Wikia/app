<?php
/**
 * Created by JetBrains PhpStorm.
 * User: krzychu
 * Date: 30.10.13
 * Time: 10:47
 * To change this template use File | Settings | File Templates.
 */

namespace Wikia\api;


class TvApiControllerTest extends \WikiaBaseTest {

	private $mockGlobalTitle;
	private $responseValues;

	/**
	 * @var Boolean
	 */
	private $org_wgDevelEnvironment;

	public function setUp() {
		global $wgDevelEnvironment;
		$this->org_wgDevelEnvironment = $wgDevelEnvironment;
		$wgDevelEnvironment = true;
		parent::setUp();
	}

	public function tearDown() {
		global $wgDevelEnvironment;
		$wgDevelEnvironment = $this->org_wgDevelEnvironment;
		parent::tearDown();
	}

	public function testGetArticleQuality() {
		$mock = $this->getMockBuilder( "\TvApiController" )
			->disableOriginalConstructor()
			->setMethods( [ '__construct', 'getQualityFromSolr' ] )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'getQualityFromSolr' )
			->will( $this->returnValue( [ [ 'quality' => 10 ] ] ) );

		$refl = new \ReflectionMethod( $mock, 'getArticleQuality' );

		$refl->setAccessible( true );

		$this->assertEquals( 10, $refl->invoke( $mock, 88, 0 ) );
	}

	public function testGetArticleQualityNotFound() {
		$mock = $this->getMockBuilder( "\TvApiController" )
			->disableOriginalConstructor()
			->setMethods( [ '__construct', 'getQualityFromSolr' ] )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'getQualityFromSolr' )
			->will( $this->returnValue( null ) );

		$refl = new \ReflectionMethod( $mock, 'getArticleQuality' );

		$refl->setAccessible( true );

		$this->assertEquals( null, $refl->invoke( $mock, 88, 0 ) );

	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.03134 ms
	 */
	public function testGetEpisodeUrlDevOrSandbox() {

		$mock = $this->getMockBuilder( "\TvApiController" )
			->disableOriginalConstructor()
			->setMethods( ['__construct', 'getExactMatch','getResponse','setWikiVariables','getApiVersion','checkArticleByQuality','getConfigFromRequest','getResponseFromConfig'] )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'getExactMatch' )
			->will( $this->returnValue(['url'=>'http://unittest.wikia.com/url', 'contentUrl'=>'http://unittest.wikia.com/contentUrl', 'articleId' => 8888]) );

		$mock->expects( $this->any() )
			->method( 'setWikiVariables' )
			->will( $this->returnValue(true));

		$mock->expects( $this->any() )
			->method( 'getApiVersion' )
			->will( $this->returnValue('test'));

		$mock->expects( $this->any() )
			->method( 'checkArticleByQuality' )
			->will( $this->returnCallback( [ $this, 'mock_checkArticleByQuality' ] ) );

		$this->getStaticMethodMock( '\WikiFactory', 'getCurrentStagingHost' )
			->expects( $this->any() )
			->method( 'getCurrentStagingHost' )
			->will( $this->returnCallback( [ $this, 'mock_getCurrentStagingHost' ] ) );

		$mockRequest = $this->getMockBuilder( "\WikiaRequest" )
			->disableOriginalConstructor()
			->setMethods( [ '__construct', 'getInt' ] )
			->getMock();

		$mockRequest->expects( $this->any() )
			->method( 'getInt' )
			->will( $this->returnValue( 0 ) );

		$mockResponse = $this->getMockBuilder( "\WikiaResponse" )
			->disableOriginalConstructor()
			->setMethods( [ '__construct', 'setValues', 'setCacheValidity' ] )
			->getMock();

		$mockResponse->expects( $this->any() )
			->method( 'setValues' )
			->will( $this->returnCallback( [ $this, 'mock_setValues' ] ) );

		$mock->expects( $this->any() )
			->method( 'getResponse' )
			->will( $this->returnValue($mockResponse));

		$this->responseValues = null;
		$mock->request = $mockRequest;
		$mock->wikis = [[1]];
		$mock->getEpisode();

		$this->assertArrayHasKey('url',$this->responseValues);
		$this->assertEquals( 'http://newhost/url',  $this->responseValues['url'] );

		$this->assertArrayHasKey('contentUrl',$this->responseValues);
		$this->assertEquals( 'http://newhost/contentUrl',  $this->responseValues['contentUrl'] );

	}

	public function mock_getCurrentStagingHost($arg1, $arg2)
	{
		return 'newhost';
	}

	public function mock_setValues($values)
	{
		$this->responseValues = $values;
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.02327 ms
	 */
	public function mock_checkArticleByQuality($arg1, $arg2)
	{
		return $arg1;
	}

	public function testGetTitle() {

		$mock = $this->getMockBuilder( '\TvApiController' )
			->disableOriginalConstructor()
			->setMethods( ['__construct', 'createTitle', 'getArticleQuality'] )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'createTitle' )
			->will( $this->returnCallback( [$this, 'mock_createTitle'] ) );

		$mock->expects( $this->any() )
			->method( 'getArticleQuality' )
			->will( $this->returnValue( 13 ) );

		$refl = new \ReflectionMethod($mock, 'getTitle');

		$refl->setAccessible( true );

		$this->setMockVariables( false, 0, 'a0', 'b0', 'c0', false );

		$this->assertEquals( ['articleId' => 1, 'title' => 'a1', 'url' => 'b1', 'quality' => 13 ], $refl->invoke( $mock, 'test number one', 1 ) );
		$this->assertEquals( ['articleId' => 2, 'title' => 'a2', 'url' => 'b2', 'quality' => 13 ], $refl->invoke( $mock, 'test number two', 1) );
		$this->assertEquals( ['articleId' => 30, 'title' => 'a3', 'url' => 'b3', 'quality' => 13 ], $refl->invoke( $mock, 'test_redirect', 1 ) );

	}

	public function mock_createTitle( $title ) {
		switch ( $title ) {
			case 'Test_Number_One':
				$this->setMockVariables( true, 1, 'a1', 'b1', 'c1', false );
				break;

			case 'test_number_two':
				$this->setMockVariables( true, 2, 'a2', 'b2', 'c2', false );
				break;

			case 'test_redirect':
				$this->setMockVariables( true, 3, 'a3', 'b3', 'c3', true );
				break;

			default:
				$this->setMockVariables( false, 4, 'a4', 'b4', 'c4', true );
		}

		return $this->mockGlobalTitle;
	}

	private function setMockVariables( $exists, $id, $title, $url, $ns, $redirect ) {
		$this->mockGlobalTitle = $this->getMockBuilder( '\GlobalTitle' )
			->disableOriginalConstructor()
			->setMethods( ['newFromText', 'exists', 'isRedirect', 'getRedirectTarget', 'getArticleID', 'getText', 'getFullURL', 'getNamespace'] )
			->getMock();

		if ( $redirect ) {
			$this->mockGlobalTitle->expects( $this->any() )
				->method( 'getRedirectTarget' )
				->will( $this->returnValue( $this->mockGlobalTitle ) );

			$this->mockGlobalTitle->expects( $this->any() )
				->method( 'isRedirect' )
				->will( $this->returnValue( true ) );

			$id = $id * 10;
		}

		$this->mockGlobalTitle->expects( $this->any() )
			->method( 'exists' )
			->will( $this->returnValue( $exists ) );

		$this->mockGlobalTitle->expects( $this->any() )
			->method( 'getArticleID' )
			->will( $this->returnValue( $id ) );

		$this->mockGlobalTitle->expects( $this->any() )
			->method( 'getText' )
			->will( $this->returnValue( $title ) );

		$this->mockGlobalTitle->expects( $this->any() )
			->method( 'getFullURL' )
			->will( $this->returnValue( $url ) );

		$this->mockGlobalTitle->expects( $this->any() )
			->method( 'getNamespace' )
			->will( $this->returnValue( $ns ) );

	}

}


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

	public function testCreateOutput() {
		$this->getStaticMethodMock( '\WikiFactory', 'getCurrentStagingHost' )
			->expects( $this->any() )
			->method( 'getCurrentStagingHost' )
			->will( $this->returnCallback( [ $this, 'mock_getCurrentStagingHost' ] ) );
		$api = new \TvApiController();
		$data = [
			'wikiId' => 1,
			'wikiHost' => 'unittest.wikia.com/url',
			'articleId' => 2,
			'title' => 'fake title',
			'url' => 'http://unittest.wikia.com/contentUrl',
			'quality' => 10
		];

		$method = new \ReflectionMethod( 'TvApiController', 'createOutput' );
		$method->setAccessible( true );
		$result = $method->invoke( $api, $data );

		$this->assertEquals(
			[
				'wikiId' =>1,
				'articleId' => 2,
				'title' => 'fake title',
				'url' => 'http://newhost/contentUrl',
				'quality' => 10,
				'contentUrl' => 'http://newhost/url/api/v1/Articles/AsSimpleJson?id=2'
			],
			$result );
	}

	public function mock_getCurrentStagingHost($arg1, $arg2)
	{
		return 'newhost';
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


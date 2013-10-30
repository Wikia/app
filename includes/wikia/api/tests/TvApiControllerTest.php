<?php
/**
 * Created by JetBrains PhpStorm.
 * User: krzychu
 * Date: 30.10.13
 * Time: 10:47
 * To change this template use File | Settings | File Templates.
 */

namespace Wikia\api;


class TvApiControllerTest extends  \WikiaBaseTest{


	public function testGetTitle(){

		$mock = $this->getMockBuilder( "\TvApiController" )
					->disableOriginalConstructor()
					->setMethods(['__construct'])
					->getMock();


	/*	$mockGlobalTitle = $this->getMockBuilder( '\GlobalTitle' )
			->disableOriginalConstructor()
			->setMethods( ['newFromText'] )
			->getMock();*/
		$mockGlobalTitle = $this->getMockClass('GlobalTitle');

		//$this->mockClass( '\GlobalTitle', $mockGlobalTitle );

		$mockGlobalTitle::staticExpects($this->any())
				->method('newFromText')
				->will($this->returnCallback('Wikia\api\TvApiControllerTest::mock_newFromText'));
//var_dump(\GlobalTitle::newFromText('aa',0,0));
/*
		$refl = new \ReflectionMethod($mock, 'getTitle');
		$refl->setAccessible(true);

		$refl->invoke($mock, 'test number one');
*/

	}

	public static function mock_newFromText($title, $ns, $wikiId)
	{
		echo "++++++++++++++++++++++++++++++++MAM: $title";
	}

}
<?php

class WikiServiceTests extends WikiaBaseTest {

	public function testGetWikiDescription () {
		$ids = array( 13, 42 );
		$description13 = 'wiki13 Description';
		$description42 = 'wiki42 Description';
		$image13 = 'image13';
		$image42 = 'image42';
		$image13Url = 'http://img13';
		$image42Url = 'http://img42';
		$imgSize = 123;

		$this->getGlobalFunctionMock( 'wfMessage' )
			->expects( $this->never() )
			->method( 'wfMessage' );

		$wikiService = $this->getMock('WikiService', array( 'getWikiDetails', 'getImageSrcByTitle' ));
		$wikiService->expects($this->exactly(1))
			->method('getWikiDetails')
			->with($ids)
			->will($this->returnValue( [
				13 => [
					'name' => 'wiki13',
					'url' => 'dummyurl',
					'lang' => 'dummyLang',
					'hubId' => 1,
					'headline' => 'dummy headline',
					'desc' => $description13,
					'image' => $image13],
				42 => [
					'name' => 'wiki42',
					'url' => 'dummyurl',
					'lang' => 'dummyLang',
					'hubId' => 1,
					'headline' => 'dummy headline',
					'desc' => $description42,
					'image' => $image42]
			] ));

		$wikiService->expects($this->exactly(2))
			->method('getImageSrcByTitle')
			->will($this->returnValueMap([
				[ 69, $image13, $imgSize, null, $image13Url ],
				[ 69, $image42, $imgSize. null, $image42Url ]]));
		$wikiService->setCityVisualizationObject($this->mockCityVisualisationObject( 69, 2 ));

		$result = $wikiService->getWikiDescription( $ids, $imgSize );

		$this->assertEquals( $description13, $result[13]['desc'] );
		$this->assertEquals( $description42, $result[42]['desc'] );
		$this->assertEquals( $image13Url, $result[13]['image_url'] );
		$this->assertEquals( $image42Url, $result[42]['image_url'] );
	}

	public function testGetWikiDescription2 () {
		$ids = array( 13, 42 );
		$description13 = 'wiki13 Description';
		$description42 = 'wiki42 Description';
		$image13 = '';
		$image42 = 'image42';
		$image13Url = '';
		$image42Url = 'http://img42';
		$imgSize = 123;

		$this->getGlobalFunctionMock( 'wfMessage' )
			->expects( $this->exactly( 1 ) )
			->method( 'wfMessage' )
			->with( 'wikiasearch2-crosswiki-description', 'wiki42' )
			->will( $this->returnValue( $description42 ) );

		$wikiService = $this->getMock('WikiService', array( 'getWikiDetails','getImageSrcByTitle' ));
		$wikiService->expects($this->exactly(1))
			->method('getWikiDetails')
			->with($ids)
			->will($this->returnValue( [
				13 => [
					'name' => 'wiki13',
					'url' => 'dummyurl',
					'lang' => 'dummyLang',
					'hubId' => 1,
					'headline' => 'dummy headline',
					'desc' => $description13,
					'image' => $image13],
				42 => [
					'name' => 'wiki42',
					'url' => 'dummyurl',
					'lang' => 'dummyLang2',
					'hubId' => 1,
					'headline' => 'dummy headline',
					'desc' => null,
					'image' => $image42]
			] ));

		$wikiService->expects($this->exactly(1))
			->method('getImageSrcByTitle')
			->will($this->returnValueMap([
				[ 69, $image42, $imgSize, null, $image42Url ]]));
		$wikiService->setCityVisualizationObject($this->mockCityVisualisationObject( 69, 1 ));

		$result = $wikiService->getWikiDescription( $ids, $imgSize );

		$this->assertEquals( $description13, $result[13]['desc'] );
		$this->assertEquals( $description42, $result[42]['desc'] );
		$this->assertEquals( $image13Url, $result[13]['image_url'] );
		$this->assertEquals( $image42Url, $result[42]['image_url'] );
	}

	protected function mockMessage( $text, $callCount = 1 ) {
		$message = $this->getMock('Message', array('text'), array(), '', false);
		$message->expects($this->exactly($callCount))
			->method('text')
			->will($this->returnValue($text));
		return $message;
	}

	protected function mockCityVisualisationObject( $returnedWikiId, $times ) {
		$cityVisualisationObject = $this->getMock('CityVisualisationObject', array('__construct', 'getTargetWikiId'));
		$cityVisualisationObject->expects($this->exactly($times))
			->method('getTargetWikiId')
			->will( $this->returnValue($returnedWikiId) );
		return $cityVisualisationObject;
	}
}

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

		$wikiService = $this->getMock('WikiService', array( 'getDetails', 'getImageSrcByTitle' ));
		$wikiService->expects($this->exactly(1))
			->method('getDetails')
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
				[ 69, $image42, $imgSize, null, $image42Url ]]));
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

		$MessageMock = $this->getMock('Message', array('text'));
		$MessageMock->expects($this->any())->method('text')->will($this->returnValue($description42));

		$this->getGlobalFunctionMock( 'wfMessage' )
			->expects( $this->exactly( 1 ) )
			->method( 'wfMessage' )
			->with( 'wikiasearch2-crosswiki-description', 'wiki42' )
			->will( $this->returnValue( $MessageMock ) );

		$wikiService = $this->getMock('WikiService', array( 'getDetails','getImageSrcByTitle' ));
		$wikiService->expects($this->exactly(1))
			->method('getDetails')
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

	/**
	 * @covers WikiService::getMostLinkedPages
	 */
	public function testGetMostLinkedPages() {

		/* mocking MemCache */
		$mockCache = $this->getMock( 'MemCachedClientforWiki', array( 'get', 'set' ), array( array() ) );

		$mockCache->expects( $this->any() )
			->method( 'get' )
			->will( $this->returnValue( false ) );

		$mockCache->expects( $this->any() )
			->method( 'set' )
			->will( $this->returnValue( false ) );

		$this->mockGlobalVariable( 'wgMemc', $mockCache );

		/* Mocking DB response */
		$row1 = new stdClass();
		$row1->page_id = 100;
		$row1->page_title = "Abc Page 1";
		$row1->backlink_cnt = 10;

		$row2 = new stdClass();
		$row2->page_id = 200;
		$row2->page_title = "Abc Page 2";
		$row2->backlink_cnt = 6;

		$mockDb = $this->getDatabaseMock(array('select','fetchObject'));
		$mockDb->expects($this->any())->method('select')->will($this->returnValue(false));

		$mockDb->expects($this->at(1))
				->method('fetchObject')
				->will($this->returnValue( $row1 ));

		$mockDb->expects($this->at(2))
			->method('fetchObject')
			->will($this->returnValue( $row2 ));

		$mockDb->expects($this->at(3))
			->method('fetchObject')
			->will($this->returnValue( null ));

		$this->mockGlobalFunction('wfGetDb', $mockDb);

		$wikiService = new WikiService();
		$result = $wikiService->getMostLinkedPages();
		$keys = array_keys( $result );
		$this->assertEquals( count($keys), 2 );
		foreach ( $keys as $key ) {
			$this->assertEquals( $key, $result[$key]['page_id'] );
		}
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

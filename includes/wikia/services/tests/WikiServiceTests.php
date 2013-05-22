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

		$this->mockGlobalFunction( "Message", null, 0 );
		$this->mockApp();

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
				[ [13, $image13, $imgSize], $image13Url ],
				[ [42, $image42, $imgSize], $image42Url ]]));

		$result = $wikiService->getWikiDescription( $ids );

		$this->assertEquals( $description13, $result[13]['desc'] );
		$this->assertEquals( $description42, $result[42]['desc'] );
	}

	public function testGetWikiDescription2 () {
		$ids = array( 13, 42 );
		$description13 = 'wiki13 Description';
		$description42 = 'wiki42 Description';
		$image13 = 'image13';
		$image42 = 'image42';

		$this->mockGlobalFunction( "message", $this->mockMessage($description42), 1, ['wikiasearch2-crosswiki-description', 'wiki42'] );
		$this->mockApp();

		$wikiService = $this->getMock('WikiService', array( 'getWikiDetails' ));
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
					'desc' => null,
					'image' => $image42]
			] ));

		$result = $wikiService->getWikiDescription( $ids );

		$this->assertEquals( $description13, $result[13]['desc'] );
		$this->assertEquals( $description42, $result[42]['desc'] );
	}

	protected function mockMessage( $text, $callCount = 1 ) {
		$message = $this->getMock('Message', array('text'));
		$message->expects($this->exactly($callCount))
			->method('text')
			->will($this->returnValue($text));
		return $message;
	}
}

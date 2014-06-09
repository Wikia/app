<?php

use Wikia\Search\IndexService\ArticleType;
use Wikia\Search\MediaWikiService;
use Wikia\Search\Test\BaseTest;

class ArticleTypeTest extends BaseTest {

	/** @test */
	public function shouldReturnEmptyResponseForNonEnglishWiki() {
		$articleTypeService = $this->mockArticleTypeService();
		$articleTypeService->expects($this->never())->method('getArticleType');
		$articleTypeIndexerService = new ArticleType([123, 234]);
		$articleTypeIndexerService->setService($this->mockMediaWikiService("de"));

		$response = $articleTypeIndexerService->getResponseForPageIds();

		$this->assertEquals([ "contents" => [ ], "errors" => [ ] ], $response);
	}

	/** @test */
	public function shouldReturnTypesForEnglishWiki() {
		$articleTypeService = $this->mockArticleTypeService();
		$articleTypeService->expects($this->any())->method('getArticleType')->will($this->returnValueMap([ [123, "movie"], [234, "other"] ]));
		$articleTypeIndexerService = new ArticleType([123, 234]);
		$articleTypeIndexerService->setService($this->mockMediaWikiService("en"));

		$response = $articleTypeIndexerService->getResponseForPageIds();

		$this->assertEquals([ "contents" => [
			[ "id" => "13_123", "article_type_s" => [ "set" => "movie" ] ],
			[ "id" => "13_234", "article_type_s" => [ "set" => "other" ] ],
		], "errors" => [ ] ], $response);
	}

	/**
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	private function mockArticleTypeService() {
		$articleTypeService = $this->getMockBuilder("ArticleTypeService")->disableOriginalConstructor()->getMock();
		$this->mockClass("ArticleTypeService", $articleTypeService);
		return $articleTypeService;
	}

	/**
	 * @param $lang
	 * @return MediaWikiService
	 */
	private function mockMediaWikiService($lang) {
		$mediaWikiService = $this->getMock('\Wikia\Search\MediaWikiService');
		$mediaWikiService->expects($this->any())->method("getWikiId")->will($this->returnValue(13));
		$mediaWikiService->expects($this->any())->method("getLanguageCode")->will($this->returnValue($lang));
		$mediaWikiService->expects($this->any())->method("pageIdExists")->will($this->returnValue(true));
		$mediaWikiService->expects($this->any())->method("getCanonicalPageIdFromPageId")->will($this->returnArgument(0));
		return $mediaWikiService;
	}
} 

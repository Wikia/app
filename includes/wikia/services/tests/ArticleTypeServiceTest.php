<?php


class ArticleTypeServiceTest extends WikiaBaseTest {
	
	private function getArticleTypeService() {
		return new ArticleTypeService("http://fake-endpoint/");
	}

	public function testShouldReturnArticleType() {
		$this->mockArticle(132, "Foo title", "Foo wiki text");

		$httpPostMock = $this->getStaticMethodMock("Http", "post");
		$httpPostMock->expects($this->once())
			->method("post")
			->will($this->returnValue('{"classes":{"mini_game":0.26,"tv_episode":0.022},"class":"tv_episode"}'));

		$type = $this->getArticleTypeService()->getArticleType(132);

		$this->assertEquals($type, "tv_episode");
	}

	public function testShouldReturnNullForNonExistingArticle() {
		$articleFactoryMock = $this->getStaticMethodMock("Article", "newFromID");
		$articleFactoryMock->expects($this->once())
			->method("newFromID")
			->with(132)
			->will($this->returnValue(null));

		$httpPostMock = $this->getStaticMethodMock("Http", "post");
		$httpPostMock->expects($this->never())
			->method("post");

		$type = $this->getArticleTypeService()->getArticleType(132);

		$this->assertEquals($type, null);
	}

	public function testShouldThrowOnEmptyResponse() {
		$this->mockArticle(132, "Foo title", "Foo wiki text");

		$httpPostMock = $this->getStaticMethodMock("Http", "post");
		$httpPostMock->expects($this->once())
			->method("post")
			->will($this->returnValue(''));

		try {
			$type = $this->getArticleTypeService()->getArticleType(132);
			$this->assertEquals("Should", "throw exception");
		} catch (ServiceUnavailableException $ex) {
		}
	}

	public function testShouldThrowOnEmptyTimeout() {
		$this->mockArticle(132, "Foo title", "Foo wiki text");

		$httpPostMock = $this->getStaticMethodMock("Http", "post");
		$httpPostMock->expects($this->once())
			->method("post")
			->will($this->returnValue(false));

		try {
			$type = $this->getArticleTypeService()->getArticleType(132);
			$this->assertEquals("Should", "throw exception");
		} catch (ServiceUnavailableException $ex) {
		}
	}

	private function mockArticle($articleId, $articleTitle, $articleWikiText) {
		$title = $this->getMockBuilder("Title")->disableOriginalConstructor()->getMock();
		$title->expects($this->once())
			->method("getText")->will($this->returnValue($articleTitle));

		$page = $this->getMockBuilder("WikiPage")->disableOriginalConstructor()->getMock();
		$page->expects($this->once())
			->method("getRawText")->will($this->returnValue($articleWikiText));

		$article = $this->getMockBuilder("Article")->disableOriginalConstructor()->getMock();
		$article->expects($this->once())
			->method("getTitle")->will($this->returnValue($title));
		$article->expects($this->once())
			->method("getPage")->will($this->returnValue($page));

		$articleFactoryMock = $this->getStaticMethodMock("Article", "newFromID");
		$articleFactoryMock->expects($this->once())
			->method("newFromID")
			->with($articleId)
			->will($this->returnValue($article));
	}
}

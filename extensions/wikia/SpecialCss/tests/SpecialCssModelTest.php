<?php
class SpecialCssModelTest extends WikiaBaseTest {
	const FULL_URL_EXAMPLE = 'http://www.wikia.com/wiki/Special:CSS';
	const LOCAL_URL_EXAMPLE = '/wiki/Special:CSS';
	
	protected function setUp () {
		require_once( dirname(__FILE__) . '/../SpecialCssModel.class.php');
	}

	/**
	 * @dataProvider testGetSpecialCssDataProvider
	 */
	public function testGetSpecialCssUrl($fullUrl, $expected) {
		$titleMock = $this->getMock('Title', array('getLocalURL', 'getFullUrl'));
		$titleMock->expects($this->any())
			->method('getLocalURL')
			->will($this->returnValue(self::LOCAL_URL_EXAMPLE));
		$titleMock->expects($this->any())
			->method('getFullUrl')
			->will($this->returnValue(self::FULL_URL_EXAMPLE));
		
		$specialCssModelMock = $this->getMock('SpecialCssModel', array('getSpecialCssTitle'));
		$specialCssModelMock->expects($this->once())
			->method('getSpecialCssTitle')
			->will($this->returnValue($titleMock));

		$result = $specialCssModelMock->getSpecialCssUrl($fullUrl);
		$this->assertEquals($expected, $result);
	}

	public function testGetSpecialCssDataProvider() {
		return [
			[true, self::FULL_URL_EXAMPLE],
			[false, self::LOCAL_URL_EXAMPLE]
		];
	}

	/**
	 * @dataProvider testGetCssFileContentDataProvider
	 */
	public function testGetCssFileContent($expected, $articleContent) {
		if (isset($articleContent)) {
			$fileArticle = $this->getMock('Article', array('getContent'), [new Title()]);
			$fileArticle->expects($this->any())
				->method('getContent')
				->will($this->returnValue($articleContent));
		} else {
			$fileArticle = null;
		}

		$specialCssModelMock = $this->getMock('SpecialCssModel', array('getCssFileArticle'));
		$specialCssModelMock->expects($this->any())
			->method('getCssFileArticle')
			->will($this->returnValue($fileArticle));

		$this->assertEquals($expected, $specialCssModelMock->getCssFileContent());
	}

	public function testGetCssFileContentDataProvider() {
		return [
			['', null],
			['test content', 'test content']
		];
	}
}

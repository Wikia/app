<?php
use PHPUnit\Framework\TestCase;

class ArticleExporterTest extends TestCase {
	public $articleExporter;
	public $parseResponse;

	public function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../ArticleExporter.class.php';

		$this->articleExporter = new ArticleExporter();
		$this->parseResponse = ['parse' => [
			'title' => 'lorem',
			'revid' => 123,
			'text' => ['*' => '<div class=\"lorem\">Lorem ipsum</div>'],
			'categories' => [['*' => 'Character'], ['*' => 'Cast']],
			'links' => [['*' => 'Jon Snow'], ['*' => 'Ghost']],
			'displaytitle' => 'lorem'
		]];
	}

	public function testSingleArticle() {
		$jonSnow = $this->buildMockTitle( 'https://community.fandom/wiki/Jon_Snow' );
		$articleExporter = $this->buildMockArticleExporter();

		$articleExporter->expects($this->once())
			->method('getArticle')
			->will($this->returnValue( $this->parseResponse ));

		$articleExporter->expects($this->once())
			->method('loadTitle')
			->will($this->returnValue( $jonSnow ));

		$articles = $articleExporter->build('1', ['1']);

		$this->assertEquals(1, sizeof($articles));
	}

	public function testMultipleArticles() {
		$jonSnow = $this->buildMockTitle( 'https://community.fandom/wiki/Jon_Snow' );
		$articleExporter = $this->buildMockArticleExporter();

		$articleExporter->expects($this->exactly(2))
			->method('getArticle')
			->will($this->returnValue( $this->parseResponse ));

		$articleExporter->expects($this->exactly(2))
			->method('loadTitle')
			->will($this->returnValue($jonSnow));

		$articles = $articleExporter->build('1', ['1', '2']);

		$this->assertEquals(2, sizeof($articles));
	}

	public function testGetPlaintext() {
		$plaintext = $this->articleExporter->getPlaintext($this->parseResponse['parse']['text']['*']);
		$this->assertEquals('Lorem ipsum', $plaintext);
	}

	public function testGetCategories() {
		$categories = $this->articleExporter->getCategories($this->parseResponse['parse']['categories']);
		$this->assertEquals(['Character', 'Cast'], $categories);
	}

	public function testGetPageTitles() {
		$titles = $this->articleExporter->getPageTitles($this->parseResponse['parse']['links']);
		$this->assertEquals(['Jon Snow', 'Ghost'], $titles);
	}

	public function testGetUpdated() {
		$updated = $this->articleExporter->getUpdated(0);
		$expected = wfTimestamp( TS_ISO_8601, 0);
		$this->assertEquals($expected, $updated);
	}

	private function buildMockArticleExporter() {
		$mockArticleExporter = $this->getMockBuilder('ArticleExporter')
			->setMethods( [ 'getArticle', 'loadTitle', 'getContentLang' ] )
			->getMock();
		$mockArticleExporter->expects($this->any())
			->method('getContentLang')
			->will($this->returnValue('en'));

		return $mockArticleExporter;
	}

	private function buildMockTitle( $url ) {
		$mockTitle = $this->getMockBuilder('Title')
			->setMethods([ 'getFullUrl', 'getNamespace' ])
			->getMock();
		$mockTitle->expects($this->any())
			->method('getFullUrl')
			->will($this->returnValue( $url ));
		$mockTitle->expects($this->any())
			->method('getNamespace')
			->will($this->returnValue(NS_MAIN));

		return $mockTitle;
	}
}

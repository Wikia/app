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
        $mockArticleExporter = $this->getMockBuilder('ArticleExporter')
            ->setMethods( [ 'getArticle', 'getPageUrl' ] )
            ->getMock();

        $mockArticleExporter->expects($this->once())
            ->method('getArticle')
            ->will($this->returnValue( $this->parseResponse ));

        $mockArticleExporter->expects($this->once())
            ->method('getPageUrl')
            ->will($this->returnValue( 'https://community.fandom/wiki/Jon_Snow' ));

        $articles = $mockArticleExporter->build('1', ['1']);

        $this->assertEquals(1, sizeof($articles));
    }

    public function testMultipleArticles() {
        $mockArticleExporter = $this->getMockBuilder('ArticleExporter')
            ->setMethods( [ 'getArticle', 'getPageUrl' ] )
            ->getMock();

        $mockArticleExporter->expects($this->exactly(2))
            ->method('getArticle')
            ->will($this->returnValue( $this->parseResponse ));

        $mockArticleExporter->expects($this->exactly(2))
            ->method('getPageUrl')
            ->will($this->returnValue( 'https://community.fandom/wiki/Jon_Snow' ));

        $articles = $mockArticleExporter->build('1', ['1', '2']);

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
}
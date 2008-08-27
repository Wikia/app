<?php
/* Call this file directly to run a set of tests against ArticleAdLogic.php */

require dirname(__FILE__) . '/../ArticleAdLogic.php';

require 'PHPUnit.php';
// Note that this is PEARs pattern of building TestCases, not necessarily ours.
// See PHPUnit.php for more info
class ArticleAdLogicTest extends PHPUnit_TestCase {

	function __construct($name) {
		// New test cases are constructed here based on the argument.
		$this->PHPUnit_TestCase($name);
	}

	function setUp() {
		// Put common stuff here, will be called for each test case
	}

	function testIsShort() {
		// These should fail the short test. Note that medium should fail too, because it's not short nor long.
		$this->assertFalse(ArticleAdLogic::isShortArticle(file_get_contents('./longArticleWithImagesNoCollision.html')));
		$this->assertFalse(ArticleAdLogic::isShortArticle(file_get_contents('./longArticleWithWideTable.html')));
		$this->assertFalse(ArticleAdLogic::isShortArticle(file_get_contents('./mediumArticlePlainText.html')));

		// These are the true short articles
		$this->assertTrue(ArticleAdLogic::isShortArticle(file_get_contents('./shortArticleWithImagesNoCollision.html')));
		$this->assertTrue(ArticleAdLogic::isShortArticle(file_get_contents('./shortArticle.html')));
	}

	function testIsLong() {
		// These are the true long articles
		$this->assertTrue(ArticleAdLogic::isLongArticle(file_get_contents('./longArticleWithImagesNoCollision.html')));
		$this->assertTrue(ArticleAdLogic::isLongArticle(file_get_contents('./longArticleWithWideTable.html')));

		// These should fail the long test, including the medium, because it's not long enough
		$this->assertFalse(ArticleAdLogic::isLongArticle(file_get_contents('./mediumArticlePlainText.html')));
		$this->assertFalse(ArticleAdLogic::isLongArticle(file_get_contents('./shortArticleWithImagesNoCollision.html')));
		$this->assertFalse(ArticleAdLogic::isLongArticle(file_get_contents('./shortArticle.html')));
	}

	function testIsBoxAd(){
		// These should should display a box ad. note the names of the files for explanations on why. 
		// Additional info in the files themselves
		$this->assertTrue(ArticleAdLogic::isBoxAdArticle(file_get_contents('./longArticleWithImagesNoCollision.html')));
		$this->assertTrue(ArticleAdLogic::isBoxAdArticle(file_get_contents('./mediumArticlePlainText.html')));
		$this->assertTrue(ArticleAdLogic::isBoxAdArticle(file_get_contents('./shortArticleWithImagesNoCollision.html')));
		$this->assertTrue(ArticleAdLogic::isBoxAdArticle(file_get_contents('./articleWithMagicWordBoxAd.html')));
		$this->assertTrue(ArticleAdLogic::isBoxAdArticle(file_get_contents('./table30Percent.html')));
		$this->assertTrue(ArticleAdLogic::isBoxAdArticle(file_get_contents('./table200Pixels.html')));
		$this->assertTrue(ArticleAdLogic::isBoxAdArticle(file_get_contents('./table200pxPixels.html')));

		// These should should display a banner ad
		$this->assertFalse(ArticleAdLogic::isBoxAdArticle(file_get_contents('./articleWithMagicWordBanner.html')));
		$this->assertFalse(ArticleAdLogic::isBoxAdArticle(file_get_contents('./longArticleWithWideTable.html')));
		$this->assertFalse(ArticleAdLogic::isBoxAdArticle(file_get_contents('./table100Percent.html')));
		$this->assertFalse(ArticleAdLogic::isBoxAdArticle(file_get_contents('./table500Pixels.html')));
		$this->assertFalse(ArticleAdLogic::isBoxAdArticle(file_get_contents('./table500pxPixels.html')));
		$this->assertFalse(ArticleAdLogic::isBoxAdArticle(file_get_contents('./tableWithClass.html')));
		$this->assertFalse(ArticleAdLogic::isBoxAdArticle(file_get_contents('./tableWithId.html')));
	}
}
// header('Content-Type: text/plain');
$suite = new PHPUnit_TestSuite();
$suite->addTest(new ArticleAdLogicTest('testIsShort'));
$suite->addTest(new ArticleAdLogicTest('testIsLong'));
$suite->addTest(new ArticleAdLogicTest('testIsBoxAd'));
$result = PHPUnit::run($suite);
echo $result->toHTML();



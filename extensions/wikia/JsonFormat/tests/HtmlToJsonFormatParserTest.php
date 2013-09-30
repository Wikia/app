<?php
/**
 * User: artur
 * Date: 21.05.13
 * Time: 16:17
 */

class HtmlToJsonFormatParserTest extends WikiaBaseTest {

	public function testParseSimple() {
		$htmlParser = new HtmlParser();
		$node = $htmlParser->parse("<div><a>link</div>");

		$this->assertEquals( 'root', $node->getType() );
		$this->assertEquals( 1, sizeof($node->getChildren()), 'wrong number of children' );
		$this->assertEquals( 'text', $node->getChildren()[0]->getType() );
		$this->assertEquals( 'link', $node->getChildren()[0]->getText() );
	}

	public function testParseSimpleNoA() {
		$htmlParser = new HtmlParser();
		$node = $htmlParser->parse("<div>link</div>");

		$this->assertEquals( 'root', $node->getType() );
		$this->assertEquals( 1, sizeof($node->getChildren()) );
		$this->assertEquals( 'text', $node->getChildren()[0]->getType() );
		$this->assertEquals( 'link', $node->getChildren()[0]->getText() );
	}

	public function testParseDivWrappingSection() {
		$htmlParser = new HtmlParser();
		$node = $htmlParser->parse('
			<div>pre <h2><span class="mw-headline" id="Section">Section1</span><span class="editsection"><a href="...;section=1" title="Edit Section section"><img src="" class="sprite edit-pencil" />Edit</a></span></h2>
			post</div>
			<h3><span class="mw-headline" id="Section">Section2</span><span class="editsection"><a href="...;section=1" title="Edit Section section"><img src="" class="sprite edit-pencil" />Edit</a></span></h3>
		');

		$this->assertEquals( 'root', $node->getType() );
		$this->assertEquals( 2, sizeof($node->getChildren()) );
		$this->assertEquals( 'text', $node->getChildren()[0]->getType() );
		$this->assertEquals( 'pre ', $node->getChildren()[0]->getText() );
		$this->assertEquals( 'section', $node->getChildren()[1]->getType() );
		$this->assertEquals( 'Section1', $node->getChildren()[1]->getText() );
	}

	public function testSectionsSameLevel() {
		$htmlParser = new HtmlParser();
		$node = $htmlParser->parse('
			<div>pre<!--
			--><h2><span class="mw-headline" id="Section">Section1</span><span class="editsection"><a href="...;section=1" title="Edit Section section"><img src="" class="sprite edit-pencil" />Edit</a></span></h2>
			post</div>
			<h2><span class="mw-headline" id="Section">Section2</span><span class="editsection"><a href="...;section=1" title="Edit Section section"><img src="" class="sprite edit-pencil" />Edit</a></span></h2>
		');

		$this->assertEquals( 'root', $node->getType() );
		$this->assertEquals( 3, sizeof($node->getChildren()) );
		$this->assertEquals( 'text', $node->getChildren()[0]->getType() );
		$this->assertEquals( 'pre', $node->getChildren()[0]->getText() );
		$this->assertEquals( 'section', $node->getChildren()[1]->getType() );
		$this->assertEquals( 'Section1', $node->getChildren()[1]->getText() );
		$this->assertEquals( 'section', $node->getChildren()[2]->getType() );
		$this->assertEquals( 'Section2', $node->getChildren()[2]->getText() );
	}

	public function testParseSimpleParagraph() {
		$htmlParser = new HtmlParser();
		$node = $htmlParser->parse("<p><a>link</p>");

		$this->assertEquals( 'root', $node->getType() );
		$this->assertEquals( 1, sizeof($node->getChildren()) );
		$this->assertEquals( 'text', $node->getChildren()[0]->getType() );
		$this->assertEquals( 'link', $node->getChildren()[0]->getText() );
	}

	public function testParseSection() {
		$htmlParser = new HtmlParser();
		$node = $htmlParser->parse('<h1><span class="mw-headline" id="Section">Section</span><span class="editsection"><a href="...;section=1" title="Edit Section section"><img src="" class="sprite edit-pencil" />Edit</a></span></h1>');

		$this->assertEquals( 'root', $node->getType() );
		$this->assertEquals( 1, sizeof($node->getChildren()), "Wrong number of elements." );
		$this->assertEquals( 'section', $node->getChildren()[0]->getType() );
		$this->assertEquals( 'Section', $node->getChildren()[0]->getText() );
		$this->assertEquals( 1, $node->getChildren()[0]->getLevel(), "Wrong section level." );
	}

	public function testParseSectionWithContent() {
		$htmlParser = new HtmlParser();
		$node = $htmlParser->parse('<h1><span class="mw-headline" id="Section">Section</span><span class="editsection"><a href="...;section=1" title="Edit Section section"><img src="" class="sprite edit-pencil" />Edit</a></span></h1> content');

		$this->assertEquals( 'root', $node->getType() );
		$this->assertEquals( 1, sizeof($node->getChildren()) );
		$this->assertEquals( 'section', $node->getChildren()[0]->getType() );
		$this->assertEquals( 'Section', $node->getChildren()[0]->getText() );
		$this->assertEquals( 1, $node->getChildren()[0]->getLevel(), "Wrong section level." );
		$this->assertEquals( 1, sizeof($node->getChildren()[0]->getChildren()), "Wrong number of children in section." );
		$this->assertEquals( 'text', $node->getChildren()[0]->getChildren()[0]->getType() );
		$this->assertEquals( ' content', $node->getChildren()[0]->getChildren()[0]->getText() );
	}
}

<?php
class VenusInfoboxExtractorTest extends WikiaBaseTest {
	protected function setUp () {
		require_once( dirname(__FILE__) . '/../InfoboxExtractor.class.php');
		parent::setUp();
	}

	public $contentInfoboxInside = <<<EOD
		<p>text</p>
		<ul><li>li</li><li>li2</li></ul>
		<h2>header</h2>
		aaaa
		<div class="infoBox">infobox</div>
		<table><tr><td>TD</td></tr></table>
		<p>text 2</p>
EOD;

	public $contentInfoboxWrongTag = <<<EOD
		<p>text</p>
		<ul><li>li</li><li>li2</li></ul>
		<h2>header</h2>
		aaaa
		<p class="infoBox">infobox</p>
		<table><tr><td>TD</td></tr></table>
		<p>text 2</p>
EOD;

	public $contentInfoboxLast = <<<EOD
		<p>text</p>
		<ul><li>li</li><li>li2</li></ul>
		<h2>header</h2>
		aaaa
		<table><tr><td>TD</td></tr></table>
		<p>text 2</p>
		<table class="other-class infobox"><tr><td>infobox</td></tr></table>
EOD;

	public $contentInfoboxFirst = <<<EOD
		<div class="some-class character-infobox">infobox</div>
		<p>text</p>
		<ul><li>li</li><li>li2</li></ul>
		<h2>header</h2>
		aaaa
		<table><tr><td>TD</td></tr></table>
		<p>text 2</p>
EOD;

	public $contentNoInfobox = <<<EOD
		<div class="some-class character">infobox</div>
		<p>text</p>
		<ul><li>li</li><li>li2</li></ul>
		<h2>header</h2>
		aaaa
		<table><tr><td>TD</td></tr></table>
		<p>text 2</p>
EOD;

	/**
	 * @dataProvider testGetInfoboxNodesDataProvider
	 */
	public function testGetInfoboxNodes( $content, $expected ) {
		$infoboxExractor = new InfoboxExtractor( $content );

		$nodes = $infoboxExractor->getInfoboxNodes();

		$this->assertEquals( $expected['length'], $nodes->length );

		if ($nodes->length) {
			$node = $nodes->item(0);

			$this->assertEquals( $expected['tagName'], $node->tagName );
			$this->assertContains( $expected['class'], $node->getAttribute('class') );
		}
	}

	public function testGetInfoboxNodesDataProvider() {
		return [
			[
				$this->contentInfoboxInside,
				[
					'tagName' => 'div',
					'class' => 'infoBox',
					'length' => 1
				]
			],
			[
				$this->contentInfoboxLast,
				[
					'tagName' => 'table',
					'class' => 'infobox',
					'length' => 1
				]
			],
			[
				$this->contentInfoboxFirst,
				[
					'tagName' => 'div',
					'class' => 'character-infobox',
					'length' => 1
				]
			],
			[
				$this->contentNoInfobox,
				[
					'tagName' => '',
					'class' => '',
					'length' => 0
				]
			],
			[
				$this->contentInfoboxWrongTag,
				[
					'tagName' => '',
					'class' => '',
					'length' => 0
				]
			],
		];
	}

	/**
	 * @dataProvider testClearInfoboxStylesDataProvider
	 */
	public function testClearInfoboxStyles( $html, $expected ) {
		$infoboxExractor = new InfoboxExtractor( $html );
		$dom = $infoboxExractor->getDOMDocument();

		$infobox = $dom->documentElement->firstChild->firstChild;
		$infobox = $infoboxExractor->clearInfoboxStyles( $infobox );

		$styles = $infobox->getAttribute('style');

		$this->assertEquals( $expected, $styles );
	}

	public function testClearInfoboxStylesDataProvider() {
		return [
			[
				'<div class="some-class character-infobox" style="max-width:100px;height:200px;font-size:11px;">infobox</div>',
				'font-size:11px;'
			],
			[
				'<table class="infobox" style="width:100px;max-width: 200px; margin-top:20px; color:#999;height:200px;font-size:11px; min-height:100px;"><tr><td>infobox</td></tr></table>',
				'width:100px;color:#999;font-size:11px;'
			],
			[
				'<div class="character-infobox" style="font-size:11px;border:1px solid blue;">infobox</div>',
				'font-size:11px;border:1px solid blue;'
			]
		];
	}

	/**
	 * @dataProvider testWrapInfoboxDataProvider
	 */
	public function testWrapInfobox($html, $attributes, $expectedHtml ) {
		$infoboxExractor = new InfoboxExtractor( $html );
		$dom = $infoboxExractor->getDOMDocument();

		$infobox = $dom->documentElement->firstChild->firstChild;
		$infoboxContainer = $infoboxExractor->wrapInfobox( $infobox, $attributes['id'], $attributes['class'] );

		$nodeHtml = $dom->saveHTML( $infoboxContainer );

		$this->assertEquals( $nodeHtml, $expectedHtml );
	}

	public function testWrapInfoboxDataProvider() {
		return [
			[
				'<div class="some-class character-infobox">infobox</div>',
				[ 'id' => 'infoboxContainer', 'class' => 'infobox-venus' ],
				'<div id="infoboxContainer" class="infobox-venus"><div class="some-class character-infobox">infobox</div></div>'
			],
			[
			'<div class="some-class character-infobox">infobox</div>',
				[ 'id' => '', 'class' => 'infobox-venus' ],
				'<div class="infobox-venus"><div class="some-class character-infobox">infobox</div></div>'
			],
			[
				'<div class="some-class character-infobox">infobox</div>',
				[ 'id' => 'infoboxContainer', 'class' => '' ],
				'<div id="infoboxContainer"><div class="some-class character-infobox">infobox</div></div>'
			],
			[
				'<div class="some-class character-infobox">infobox</div>',
				[ 'id' => '', 'class' => '' ],
				'<div><div class="some-class character-infobox">infobox</div></div>'
			]
		];
	}


	/**
	 * @dataProvider testInsertNodeDataProvider
	 */
	public function testInsertNode( $content, $prepend, $expectedHTML ) {
		$nodeHtml = '';

		$infoboxExtractor = new InfoboxExtractor( $content );
		$dom = $infoboxExtractor->getDOMDocument();

		$nodes = $infoboxExtractor->getInfoboxNodes();

		if ($nodes->length) {
			$infobox = $nodes->item(0);

			$parent = $dom->documentElement->firstChild;

			$infoboxExtractor->insertNode( $parent, $infobox, $prepend );
			if ( $prepend === true ) {
				$nodeHtml = trim($dom->saveHTML( $parent->firstChild ));
			} elseif ( $prepend === false ) {
				$nodeHtml = trim($dom->saveHTML( $parent->lastChild ));
			}
		}

		$this->assertEquals($expectedHTML, $nodeHtml);
	}

	public function testInsertNodeDataProvider() {
		return [
			[
				$this->contentInfoboxInside,
				true, //first
				'<div class="infoBox">infobox</div>'
			],
			[
				$this->contentInfoboxInside,
				false, //last
				'<div class="infoBox">infobox</div>'
			],
			[
				$this->contentInfoboxLast,
				true, //first
				'<table class="other-class infobox"><tr><td>infobox</td></tr></table>'
			],
			[
				$this->contentInfoboxFirst,
				false, //last
				'<div class="some-class character-infobox">infobox</div>'
			],
		];
	}

	/**
	 * @dataProvider testRemoveBlacklistedPropertiesDataProvider
	 */
	public function testRemoveBlacklistedProperties( $styles, $expected ) {
		$infoboxExtractor = new InfoboxExtractor( '' );
		$styles = $infoboxExtractor->removeBlacklistedProperties( $styles );

		$this->assertEquals( $expected, $styles );
	}

	public function testRemoveBlacklistedPropertiesDataProvider() {
		return [
			[
				'font-size:20px; width: 200px; margin-left: 20%; border: none;',
				'font-size:20px;width: 200px;border: none;',
			],
			[
				'height: 160px; max-width: 200px;',
				'',
			],
			[
				'max-height: 80%; text-align: top; max-width: 400px; width: 140px; color: #000;',
				'text-align: top;width: 140px;color: #000;',
			],
			[
				'font-size:20px;border: none;',
				'font-size:20px;border: none;',
			]
		];
	}

	/**
	 * @dataProvider testGetStylesArrayDataProvider
	 */
	public function testGetStylesArray( $styles, $expected ) {
		$infoboxExtractor = new InfoboxExtractor( '' );
		$stylesArray = $infoboxExtractor->getStylesArray( $styles );

		$this->assertEquals( $expected, $stylesArray );
	}

	public function testGetStylesArrayDataProvider() {
		return [
			[
				'font-size:20px; width: 200px; margin-left: 20%; border: none;',
				[
					'font-size' => 'font-size:20px',
					'width' => 'width: 200px',
					'margin-left' => 'margin-left: 20%',
					'border' => 'border: none'
				]
			],
			[
				'',
				[]
			],
			[
				'height: 160px; width: 200px;',
				[
					'height' => 'height: 160px',
					'width' => 'width: 200px'
				]
			]
		];
	}
} 

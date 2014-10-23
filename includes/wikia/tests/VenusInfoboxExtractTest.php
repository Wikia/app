<?php
class VenusInfoboxExtractTest extends WikiaBaseTest {
	protected function setUp () {
		require_once( dirname(__FILE__) . '/../InfoboxExtract.class.php');
		parent::setUp();
	}

	/**
	 * @dataProvider testGetInfoboxNodesDataProvider
	 */
	public function testGetInfoboxNodes( $content, $expectedHTML, $expected ) {
		$nodeHtml = '';

		$infoboxExract = new InfoboxExtract( $content );
		$dom = $infoboxExract->getDOMDocument();

		$nodes = $infoboxExract->getInfoboxNodes();

		if ($nodes->length) {
			$node = $nodes->item(0);
			$nodeHtml = $dom->saveHTML($node);
		}

		$result = ($nodeHtml == $expectedHTML);

		$this->assertEquals($expected, $result);
	}

	public function testGetInfoboxNodesDataProvider() {
		return [
			[
				$this->contentInfoboxInside,
				'<div class="infoBox">infobox</div>',
				true
			],
			[
				$this->contentInfoboxInside,
				'<p class="infoBox">infobox</p>',
				false
			],
			[
				$this->contentInfoboxLast,
				'<table class="other-class infobox"><tr><td>infobox</td></tr></table>',
				true
			],
			[
				$this->contentInfoboxLast,
				'<table class="infobox"><tr><td>infobox</td></tr></table>',
				false
			],
			[
				$this->contentInfoboxFirst,
				'<div class="some-class character-infobox">infobox</div>',
				true
			],
			[
				$this->contentNoInfobox,
				'',
				true
			],
			[
				$this->contentInfoboxWrongTag,
				'',
				true
			],
		];
	}

	/**
	 * @dataProvider testClearInfoboxStylesDataProvider
	 */
	public function testClearInfoboxStyles( $html, $expectedHtml ) {
		$infoboxExract = new InfoboxExtract( $html );
		$dom = $infoboxExract->getDOMDocument();

		$infobox = $dom->documentElement->firstChild->firstChild;
		$infobox = $infoboxExract->clearInfoboxStyles( $infobox );

		$nodeHtml = $dom->saveHTML( $infobox );

		$this->assertEquals( $nodeHtml, $expectedHtml );
	}

	public function testClearInfoboxStylesDataProvider() {
		return [
			[
				'<div class="some-class character-infobox" style="width:100px;height:200px;font-size:11px;">infobox</div>',
				'<div class="some-class character-infobox" style="font-size:11px;">infobox</div>'
			],
			[
				'<table class="infobox" style="width:100px;max-width: 200px; color:#999;height:200px;font-size:11px; min-height:100px;"><tr><td>infobox</td></tr></table>',
				'<table class="infobox" style="color:#999;font-size:11px;"><tr><td>infobox</td></tr></table>'
			],
			[
				'<div class="character-infobox" style="font-size:11px;border:1px solid blue;">infobox</div>',
				'<div class="character-infobox" style="font-size:11px;border:1px solid blue;">infobox</div>'
			]
		];
	}

	/**
	 * @dataProvider testWrapInfoboxDataProvider
	 */
	public function testWrapInfobox($html, $attributes, $expectedHtml ) {
		$infoboxExract = new InfoboxExtract( $html );
		$dom = $infoboxExract->getDOMDocument();

		$infobox = $dom->documentElement->firstChild->firstChild;
		$infoboxContainer = $infoboxExract->wrapInfobox( $infobox, $attributes['id'], $attributes['class'] );

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
	public function testInsertNode( $content, $position, $expectedHTML ) {
		$nodeHtml = '';

		$infoboxExtract = new InfoboxExtract( $content );
		$dom = $infoboxExtract->getDOMDocument();

		$nodes = $infoboxExtract->getInfoboxNodes();

		if ($nodes->length) {
			$infobox = $nodes->item(0);

			$parent = $dom->documentElement->firstChild;

			$infoboxExtract->insertNode( $parent, $infobox, $position );
			if ( $position === 0 ) {
				$nodeHtml = trim($dom->saveHTML( $parent->firstChild ));
			} elseif ( $position === 1 ) {
				$nodeHtml = trim($dom->saveHTML( $parent->lastChild ));
			}
		}

		$this->assertEquals($expectedHTML, $nodeHtml);
	}

	public function testInsertNodeDataProvider() {
		return [
			[
				$this->contentInfoboxInside,
				0, //first
				'<div class="infoBox">infobox</div>'
			],
			[
				$this->contentInfoboxInside,
				1, //last
				'<div class="infoBox">infobox</div>'
			],
			[
				$this->contentInfoboxLast,
				0, //first
				'<table class="other-class infobox"><tr><td>infobox</td></tr></table>'
			],
			[
				$this->contentInfoboxFirst,
				1, //last
				'<div class="some-class character-infobox">infobox</div>'
			],
		];
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

} 

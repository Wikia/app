<?php

class DivContainingHeadersVisitorTest extends WikiaBaseTest {

	//load extension
	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/JsonFormat/JsonFormat.setup.php";
		parent::setUp();
	}

	/**
	 * @group ContractualResponsibilitiesValidation
	 * @dataProvider getUrlWithoutPathDataProvider
	 */
	public function testGetUrlWithoutPath( $wgArticlePath, $url, $expected ) {
		$divVisitor = new DivContainingHeadersVisitor( new \CompositeVisitor(), new \JsonFormatBuilder() );
		$getUrlWithoutPath = self::getFn( $divVisitor, 'getUrlWithoutPath' );
		$this->assertEquals( $expected, $getUrlWithoutPath( $url, $wgArticlePath ) );
	}

	/**
	 * @group ContractualResponsibilitiesValidation
	 */
	public function testParseTabber() {
		$generatedJson = $this->getSimpleJson( $this->getTabberHtml() );
		$expectedJson = json_decode( $this->getParsedTabberJSON(), true );
		$this->assertEquals( $expectedJson, $generatedJson );
	}

	/**
	 * @group ContractualResponsibilitiesValidation
	 */
	public function testParsingTabViewTitles() {
		$body = $this->getDomBody( $this->getHtmlForTestingTabviewTitles() );
		$divVisitor = new DivContainingHeadersVisitor( new \CompositeVisitor(), new \JsonFormatBuilder() );
		$getTabTitle = self::getFn( $divVisitor, 'getTabTitle' );

		$xpath = new DOMXPath( $body->ownerDocument );
		$tabs = $xpath->query( '//a', $body );

		$this->assertEquals( 'before span sub Test 3 after span', $getTabTitle( $xpath, $tabs->item( 0 ) ) );
		$this->assertEquals( 'sub sub Test 3', $getTabTitle( $xpath, $tabs->item( 1 ) ) );
	}

	public function getUrlWithoutPathDataProvider() {
		return [
			[
				'$1',
				'Test',
				'Test'
			],
			[
				'$1',
				'Test?action=render',
				'Test'
			],
			[
				'$1',
				'Test/subTest',
				'Test/subTest'
			],
			[
				'$1',
				'Test/subTest?action=render',
				'Test/subTest'
			],
			[
				'/$1',
				'/Test',
				'Test'
			],
			[
				'/$1',
				'/Test?action=render',
				'Test'
			],
			[
				'/$1',
				'/Test/subTest',
				'Test/subTest'
			],
			[
				'/$1',
				'/Test/subTest?action=render',
				'Test/subTest'
			],
			[
				'/wiki/$1',
				'/wiki/Test',
				'Test'
			],
			[
				'/wiki/$1',
				'/wiki/Test?action=render',
				'Test'
			],
			[
				'/wiki/$1',
				'/wiki/Test/subTest',
				'Test/subTest'
			],
			[
				'/wiki/$1',
				'/wiki/Test/subTest?action=render',
				'Test/subTest'
			],
			[
				'/wiki/$1/stub',
				'/wiki/Test/stub',
				'Test'
			],
			[
				'/wiki/$1/stub',
				'/wiki/Test/stub?action=render',
				'Test'
			],
			[
				'/wiki/$1/stub',
				'/wiki/Test/subTest/stub',
				'Test/subTest'
			],
			[
				'/wiki/$1/stub',
				'/wiki/Test/subTest/stub?action=render',
				'Test/subTest'
			],
			[
				'/wiki/stub/$1',
				'/wiki/stub/Test',
				'Test'
			],
			[
				'/wiki/stub/$1',
				'/wiki/stub/Test?action=render',
				'Test'
			],
			[
				'/wiki/stub/$1',
				'/wiki/stub/Test/subTest',
				'Test/subTest'
			],
			[
				'/wiki/stub/$1',
				'/wiki/stub/Test/subTest?action=render',
				'Test/subTest'
			],
			[
				'/wiki/stub/$1/ignore',
				'/wiki/stub/Test/ignore',
				'Test'
			],
			[
				'/wiki/stub/$1/ignore',
				'/wiki/stub/Test/ignore?action=render',
				'Test'
			],
			[
				'/wiki/stub/$1/ignore',
				'/wiki/stub/Test/subTest/ignore',
				'Test/subTest'
			],
			[
				'/wiki/stub/$1/ignore',
				'/wiki/stub/Test/subTest/ignore?action=render',
				'Test/subTest'
			],
			[
				'/wiki/$1/stub',
				'',
				null
			],
			[
				'/wiki/$1/stub',
				null,
				null
			],
			[
				null,
				null,
				null
			],
			[
				'',
				'Test',
				'Test'
			],
			[
				null,
				'Test',
				'Test'
			],
			[
				'without sequential characters $ and 1 - which is not a valid case for Wikia stack',
				'Test/subTest',
				'Test/subTest'
			],
			[
				// very artificial test case
				'/wiki/$1/stub',
				// sub-article has such title, as right piece of $wgArticlePath
				'/wiki/Test/subTest/stub/stub',
				'Test/subTest/stub'
			],
			[
				// very artificial test case
				'/wiki/$1/stub',
				// sub-article has such title, as right piece of $wgArticlePath
				'/wiki/Test/subTest/stub/stub?action=render',
				'Test/subTest/stub'
			],
		];
	}

	protected function getTabberHtml() {
		return <<<TABBER_HTML_EXAMPLE
<?xml encoding=\"UTF-8\">
<html>
	<body>
		<div class="tabber">
			<div class="tabbertab" title="Links 1111">
				<p>
					<ul>
						<li>aaaa</li>
						<li>bbbbbb</li>
						<li>cccc ccccc</li>
					</ul>
				</p>
			</div>
			<div class="tabbertab" title="Links 2222">
				<p>
					<ul>
						<li>
							<a rel="nofollow" class="external text" href="http://www.mtv.ca/degrassi/episodes/pid/144885/degrassi-ep-1331-you-are-not-alone">Watch You Are Not Alone on MTV</a>
						</li>
						<li>
							<a rel="nofollow" class="external text" href="http://www.teennick.com/videos/clip/degrassi-1331-full-alkjsdf.html">Watch You Are Not Alone on Teennick</a>
						</li>
					</ul>
				</p>
			</div>
		</div>
	</body>
</html>
TABBER_HTML_EXAMPLE;
		}

	protected function getParsedTabberJSON() {
		return <<<PARSED_TABBER_JSON
{
	"sections": [
		{
			"title": "test",
            "level": 1,
			"content": [ ],
			"images": [ ]
		},
		{
            "title": "Links 1111",
            "level": 2,
            "content": [
                {
                    "type": "list",
                    "elements": [
                        {
                            "text": "aaaa",
                            "elements": [ ]
                        },
                        {
                            "text": "bbbbbb",
                            "elements": [ ]
                        },
                        {
                            "text": "cccc ccccc",
                            "elements": [ ]
                        }
                    ]
                }
            ],
            "images": [ ]
		},
		{
            "title": "Links 2222",
            "level": 2,
            "content": [
                {
                    "type": "list",
                    "elements": [
                        {
                            "text": "Watch You Are Not Alone on MTV",
                            "elements": [ ]
                        },
                        {
                            "text": "Watch You Are Not Alone on Teennick",
                            "elements": [ ]
                        }
                    ]
	            }
            ],
            "images": [ ]
		}
	]
}
PARSED_TABBER_JSON;

	}

	protected static function getFn( $obj, $name ) {
		$class = new ReflectionClass( get_class( $obj ) );
		$method = $class->getMethod( $name );
		$method->setAccessible( true );

		return function () use ( $obj, $method ) {
			$args = func_get_args();
			return $method->invokeArgs( $obj, $args );
		};
	}

	/**
	 * Piece of logic, which traversing HTML source of article, and generating simplified JSON representation
	 * 
	 * @param $html
	 * @return array
	 */
	protected function getSimpleJson( $html ) {
		$body = $this->getDomBody( $html );
		$jsonFormatTraversingState = new \JsonFormatBuilder();
		$visitor = ( new \Wikia\JsonFormat\HtmlParser() )->createVisitor( $jsonFormatTraversingState );
		$visitor->visit( $body );
		$root = $jsonFormatTraversingState->getJsonRoot();
		$simplifier = new Wikia\JsonFormat\JsonFormatSimplifier();
		$generatedJson = $simplifier->simplify( $root, 'test' );
		return $generatedJson;
	}

	/**
	 * @param $html
	 * @return DOMNode
	 */
	protected function getDomBody( $html ) {
		$doc = new \DOMDocument();
		$doc->loadHTML( $html );
		$body = $doc->getElementsByTagName( 'body' )->item( 0 );
		return $body;
	}

	/**
	 * @return string
	 */
	protected function getHtmlForTestingTabviewTitles() {
		$html = <<<DUMMY_HTML
<?xml encoding=\"UTF-8\">
<html>
	<body>
		<ul class="tabs">
			<li class="selected" data-tab="flytabs_00">
				<a href="/wiki/Test3/subTest3?action=render">
					before span <span>sub Test 3</span> after span
				</a>
			</li>
			<li data-tab="flytabs_01">
				<a href="/wiki/Test3/subTest3/subSubTest3?action=render">
					<span>sub sub Test 3</span>
				</a>
			</li>
		</ul>
	</body>
</html>
DUMMY_HTML;
		return $html;
	}

}

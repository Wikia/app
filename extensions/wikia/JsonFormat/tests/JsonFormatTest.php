<?php

class JsonFormatTest extends WikiaBaseTest {

	protected $parser;
	protected $htmlParser;
	protected $hooks;

	//load extension
	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/JsonFormat/JsonFormat.setup.php";
		$this->mockGlobalVariable( 'wgTitle', Title::newFromText( 'TestPageDoesNotExist' ) );
		parent::setUp();
	}

	public function setThumbnailImageHooks( $value = true ) {
		global $wgHooks;
		if ( $value ) {
			if ( isset( $this->hooks ) ) {
				$wgHooks[ 'ThumbnailImageHTML' ] = $this->hooks;
				unset( $this->hooks );
			}
			//else leave it as it is
		} else {
			if ( array_key_exists( 'ThumbnailImageHTML', $wgHooks ) ) {
				$this->hooks = $wgHooks[ 'ThumbnailImageHTML' ];
				unset( $wgHooks[ 'ThumbnailImageHTML' ] );
			}
		}
	}

	/* Main tests */
	/**
	 * @group Slow
	 * @group ContractualResponsibilitiesValidation
	 * @slowExecutionTime 0.21435 ms
	 * @dataProvider StructureProvider
	 */
	public function testStructureMatching( $wikiText, $expectedStructure = null ) {
		$output = $this->getParsedOutput( $wikiText );

		if ( $expectedStructure !== null ) {
			$this->assertNotEmpty( $output );
			$this->checkClassStructure( $output, $expectedStructure );
		}
	}

	/**
	 * @group Slow
	 * @group ContractualResponsibilitiesValidation
	 * @slowExecutionTime 0.1468 ms
	 * @dataProvider StructureProvider
	 */
	public function testStructureMatchingWithLazyLoad( $wikiText, $expectedStructure = null ) {
		$this->markTestSkipped( "Skipping temporarly because of https://wikia-inc.atlassian.net/browse/MAIN-7626" );
		$this->setThumbnailImageHooks( false );
		$output = $this->getParsedOutput( $wikiText );

		if ( $expectedStructure !== null ) {
			$this->assertNotEmpty( $output );
			$this->checkClassStructure( $output, $expectedStructure );
		}
		$this->setThumbnailImageHooks( true );
	}

	/**
	 * @group UsingDB
	 * @group ContractualResponsibilitiesValidation
	 * @dataProvider ContentProvider
	 */
	public function testContentMatching( $wikiText, $expectedContent ) {
		$output = $this->getParsedOutput( $wikiText );

		$children = $output->getChildren();

		$this->checkContent( $children, $expectedContent );
	}

	/**
	 * @group UsingDB
	 * @group ContractualResponsibilitiesValidation
	 * @dataProvider ContentProvider
	 */
	public function testContentMatchingWithLazyLoad( $wikiText, $expectedContent ) {
		$this->setThumbnailImageHooks( false );
		$output = $this->getParsedOutput( $wikiText );

		$children = $output->getChildren();

		$this->checkContent( $children, $expectedContent );
		$this->setThumbnailImageHooks( true );
	}

	/* Helpers */
	protected function checkContent( $data, $content ) {
		foreach ( $content as $key => $params ) {
			if ( is_numeric( $key ) ) {
				if ( empty( $data[ $key ] ) ) {
					$this->fail( "Key $key not found in data.  Expecting: " . print_r( [ $key => $params ], true ) );
				} else {
					$element = $data[ $key ];
					$this->checkContent( $element, $params );
				}
			} else {
				//do assertion
				if ( $key == 'child' ) {
					$this->checkContent( $data->getChildren(), $params );
				} else {
					if ( !isset( $values ) ) {
						$values = $data->toArray();
					}
					$this->assertEquals( $params, $values[ $key ] );
				}
			}
		}
	}

	protected function checkClassStructure( $data, $structure ) {
		foreach ( $structure as $class => $params ) {
			$classInfo = explode( ':', $class );
			$this->assertInstanceOf( $classInfo[ 0 ], $data, sprintf('Instance check failed for %s', $class) );
			$i = 0;
			foreach ( $params as $keyOrClass => $element ) {
				if ( is_numeric( $keyOrClass ) || !method_exists( $data, 'getChildren' ) ) {
					//assert values
					if ( !isset( $values ) ) {
						$values = $data->toArray();
					}
					$val = is_string( $values[ $element ] ) ? trim( $values[ $element ] ) : $values[ $element ];
					$this->assertNotNull( $val, 'Value not set. ' . $keyOrClass . ' => ' . $element . "\n" . print_r( $params, true ) . "\n" . print_r( $values, true ) );
					$this->assertNotEmpty( $val, 'Empty element found. ' . $keyOrClass . ' => ' . $element . "\n" . print_r( $params, true ) . "\n" . print_r( $values, true ) );
				} else {
					if ( !isset( $children ) ) {
						$children = $data->getChildren();
					}
					$this->checkClassStructure( $children[ $i ], [ $keyOrClass => $element ] );
					$i++;
				}
			}
		}
	}

	protected function getParsedOutput( $wikitext ) {
		return $this->memCacheDisabledSection( function () use ( $wikitext ) {
			global $wgOut, $wgWikiaEnvironment;
			$parser = ParserPool::get();
			$htmlOutput = $parser->parse( $wikitext, new Title(), $wgOut->parserOptions() );

			//check for empty result
			if ( !empty( $wikitext ) ) {
				$this->assertNotEmpty( $htmlOutput->getText(), 'Provided WikiText could not be parsed.' );
				\Wikia\Logger\WikiaLogger::instance()->info(
					'JsonFormatTest::getParsedOutput', [
						'wikitext' => $wikitext,
						'html_output' => $htmlOutput->getText()
					]
				);
			}

			$htmlParser = new \Wikia\JsonFormat\HtmlParser();
			$jsonOutput = $htmlParser->parse( $htmlOutput->getText() );

			return $jsonOutput;
		} );
	}

	/* Test providers */
	public function ContentProvider() {
		return [
			[ '==Section heading==
Nullam eros mi, mollis in sollicitudin non, tincidunt sed enim. Sed et felis metus, rhoncus ornare nibh. Ut at magna leo.',
			  [
				  0 => [
					  'level' => 2,
					  'title' => 'Section heading',
					  'child' => [
						  1 => [
							  'child' => [
								  0 => [
									  'text' => "Nullam eros mi, mollis in sollicitudin non, tincidunt sed enim. Sed et felis metus, rhoncus ornare nibh. Ut at magna leo. "
								  ]
							  ]
						  ]
					  ]
				  ]
			  ]
			],
			[
				'mollis in sollicitudin non',
				[
					0 => [
						'child' => [
							0 => [
								'text' => "mollis in sollicitudin non "
							]
						]
					]
				]
			],
			[
				'[[Link]]',
				[
					0 => [
						'child' => [
							0 => [
								'text' => 'Link',
								'url' => '/wiki/Link?action=edit&redlink=1'
							]
						]
					]
				]
			],
			[
				'[[File:Wiki-background|thumb|left|64px|Blaba abas asdfadsf asdfadsf]]',
				[
					0 => [
						'caption' => 'Blaba abas asdfadsf asdfadsf'
					]
				]
			]
		];
	}

	public function StructureProvider() {
		return [
			[ '<div style="myArticleIsUberyStyled">
{| class="infobox" style="clear: right; border: solid #aaa 1px; margin: 0 0 1em 1em; background: #f9f9f9; color:black;
width: 310px; padding: 10px; text-align: left; float: right; margin-bottom:15px;"
|- class="hiddenStructure"
| valign=top nowrap=nowrap | \'\'\'Written by\'\'\'&nbsp; || Lorem
|- class="hiddenStructure"
| valign=top | \'\'\'Illustrator\'\'\'&nbsp; || Ipsum
|- class="hiddenStructure"
| valign=top |\'\'\'Published\'\'\'&nbsp; || Kra
|- class="hiddenStructure"
| valign=top |\'\'\'Publisher\'\'\'&nbsp; || Kre
|- class="hiddenStructure"
| valign=top | \'\'\'Series\'\'\'&nbsp; || Mija
|- class="hiddenStructure"
| valign=top | \'\'\'ISBN\'\'\'&nbsp; || Lis
|}<noinclude>
<br clear="all">

=Test article=
<div class="coolStyling">
==Section heading==

Nullam eros mi, mollis in sollicitudin non, tincidunt sed enim. Sed et felis metus, rhoncus ornare nibh. Ut at magna leo. Suspendisse egestas est ac dolor imperdiet pretium. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor, erat sit amet venenatis luctus, augue libero ultrices quam, ut congue nisi risus eu purus. Cras semper consectetur elementum. Nulla vel aliquet libero. Vestibulum eget felis nec purus commodo convallis. Aliquam erat volutpat.

<gallery orientation="none">
Firefly-Serenity Database wordmark.png
01-K64 Firefly Mark I.jpg
FireflyLogo-NoBackground.png
FireflyLogoMini.png
FireflyCategoryLogo.png
Firefly class ship.jpg
Firefly logo.png
</gallery>
[[File:Firefly_logo.png|thumb|adsfadsfasd]]
[[Image:Firefly_logo.png]]
[[File:Firefly_logo.png|thumb|200px|adsfadsfasd]]
[[File:Firefly-Series1-3.jpg|frame|left|dsadfa]]
[[File:Wiki-background|thumb|left|64px|Blaba abas asdfadsf asdfadsf]]
</div>


==Section heading==

Proin ut quam eros. <span>Donec sed lobortis diam.</span> Nulla nec odio lacus. Quisque porttitor egestas dolor in placerat. Nunc vehicula dapibus ipsum. Duis venenatis risus non nunc fermentum dapibus. [[Morbi]] lorem ante, malesuada in mollis nec, auctor nec massa. Aenean tempus dui eget felis blandit at fringilla urna ultrices. Suspendisse feugiat, ante et viverra \'\'lacinia\'\', lectus sem lobortis dui, ultricies consectetur leo mauris at tortor. Nunc et \'\'\'tortor\'\'\' sit amet orci consequat semper. \'\'\'\'\'Nulla non fringilla diam.\'\'\'\'\'

<center>
{|
|- class="hiddenStructure"
| valign=top nowrap=nowrap | \'\'\'Written by\'\'\'&nbsp; || Lorem
|- class="hiddenStructure"
| valign=top | \'\'\'Illustrator\'\'\'&nbsp; || Ipsum
|}
</center>

===Linkz===
<center>[[Link Hogthrob]]</center>
[[Kermit the Frog]]

===References===
<references />

===Random list===

# something
* intend
* intend
# some more
*intend one more time

<div class="randomHTML">
<span>Lorem ipsum</span>
<!-- I\'ve spent few ours doing that html and css code please do not change 
anything here -->
<div><p>more divs</p></div>
<div> ups forgot to close that one
		</div>

		end
</div>',
			  [ 'JsonFormatRootNode' => [
				  'JsonFormatTextNode' => [ ],
				  'JsonFormatInfoboxNode' => [
					  'JsonFormatInfoboxKeyValueNode' => [
						  'key', 'value'
					  ],
					  'JsonFormatInfoboxKeyValueNode:1' => [
						  'key', 'value'
					  ],
					  'JsonFormatInfoboxKeyValueNode:2' => [
						  'key', 'value'
					  ],
					  'JsonFormatInfoboxKeyValueNode:3' => [
						  'key', 'value'
					  ],
					  'JsonFormatInfoboxKeyValueNode:4' => [
						  'key', 'value'
					  ],
					  'JsonFormatInfoboxKeyValueNode:5' => [
						  'key', 'value'
					  ]
				  ],
				  'JsonFormatParagraphNode' => [
					  'JsonFormatTextNode' => [ ]
				  ],
				  'JsonFormatTextNode:1' => [ ],
				  'JsonFormatSectionNode' => [
					  'level', 'title',
					  'JsonFormatTextNode' => [ ],
					  'JsonFormatSectionNode' => [
						  'level', 'title',
						  'JsonFormatTextNode' => [ ],
						  'JsonFormatParagraphNode' => [
							  'JsonFormatTextNode' => [ 'text' ]
						  ],
						  'JsonFormatTextNode:1' => [ ],
						  'JsonFormatImageFigureNode' => [ 'src', 'caption' ],
						  'JsonFormatParagraphNode:1' => [
							  'JsonFormatImageNode' => [ 'src' ],
							  'JsonFormatTextNode' => [ ]
						  ],
						  'JsonFormatTextNode:2' => [ ],
						  'JsonFormatImageFigureNode:1' => [ 'src', 'caption' ],
						  'JsonFormatImageFigureNode:2' => [ 'src', 'caption' ],
						  'JsonFormatImageFigureNode:3' => [ 'src', 'caption' ],
						  'JsonFormatTextNode:3' => [ ],
						  'JsonFormatParagraphNode:2' => [
							  'JsonFormatTextNode' => [ ]
						  ],
						  'JsonFormatTextNode:4' => [ ]
					  ],
					  'JsonFormatSectionNode:1' => [
						  'level', 'title',
						  'JsonFormatTextNode' => [ ],
						  'JsonFormatParagraphNode' => [
							  'JsonFormatTextNode' => [ 'text' ],
							  'JsonFormatLinkNode' => [ 'text', 'url' ],
							  'JsonFormatTextNode:1' => [ 'text' ],
						  ],
						  'JsonFormatTextNode:1' => [ ],
						  'JsonFormatTableNode' => [
							  'JsonFormatTableRowNode' => [
								  'JsonFormatTableCellNode' => [
									  'JsonFormatTextNode' => [ 'text' ]
								  ],
								  'JsonFormatTableCellNode:1' => [
									  'JsonFormatTextNode' => [ 'text' ]
								  ]
							  ],
							  'JsonFormatTableRowNode:1' => [
								  'JsonFormatTableCellNode' => [
									  'JsonFormatTextNode' => [ 'text' ]
								  ],
								  'JsonFormatTableCellNode:1' => [
									  'JsonFormatTextNode' => [ 'text' ]
								  ]
							  ]
						  ],
						  'JsonFormatTextNode:2' => [ ],
						  'JsonFormatSectionNode' => [
							  'level', 'title',
							  'JsonFormatTextNode' => [ ],
							  'JsonFormatLinkNode' => [ 'text', 'url' ],
							  'JsonFormatTextNode:1' => [ ],
							  'JsonFormatParagraphNode' => [
								  'JsonFormatLinkNode' => [ 'text', 'url' ],
								  'JsonFormatTextNode' => [ ]
							  ],
							  'JsonFormatTextNode:2' => [ ]
						  ],
						  'JsonFormatSectionNode:1' => [
							  'level', 'title',
							  'JsonFormatTextNode' => [ ],
							  'JsonFormatParagraphNode' => [
								  'JsonFormatTextNode' => [ ]
							  ],
							  'JsonFormatTextNode:1' => [ ]
						  ],
						  'JsonFormatSectionNode:2' => [
							  'level', 'title',
							  'JsonFormatTextNode' => [ ],
							  'JsonFormatListNode' => [
								  'JsonFormatListItemNode' => [
									  'JsonFormatTextNode' => [ 'text' ]
								  ],
							  ],
							  'JsonFormatListNode:1' => [
								  'JsonFormatListItemNode' => [
									  'JsonFormatTextNode' => [ 'text' ]
								  ],
								  'JsonFormatListItemNode:1' => [
									  'JsonFormatTextNode' => [ 'text' ]
								  ]
							  ],
							  'JsonFormatListNode:2' => [
								  'JsonFormatListItemNode' => [
									  'JsonFormatTextNode' => [ 'text' ]
								  ],
							  ],
							  'JsonFormatListNode:3' => [
								  'JsonFormatListItemNode' => [
									  'JsonFormatTextNode' => [ 'text' ]
								  ]
							  ],
							  'JsonFormatTextNode:1' => [ ]
						  ]
					  ]
				  ]
			  ]
			  ]
			],
			[ '
{| class="infobox" style="clear: right; border: solid #aaa 1px; margin: 0 0 1em 1em; background: #f9f9f9; color:black;
width: 310px; padding: 10px; text-align: left; float: right; margin-bottom:15px;"
|- class="hiddenStructure"
| valign=top nowrap=nowrap | \'\'\'Written by\'\'\'&nbsp; || Lorem
|- class="hiddenStructure"
| valign=top | \'\'\'Illustrator\'\'\'&nbsp; || Ipsum
|- class="hiddenStructure"
| valign=top |\'\'\'Published\'\'\'&nbsp; || Kra
|- class="hiddenStructure"
| valign=top |\'\'\'Publisher\'\'\'&nbsp; || Kre
|- class="hiddenStructure"
| valign=top | \'\'\'Series\'\'\'&nbsp; || Mija
|- class="hiddenStructure"
| valign=top | \'\'\'ISBN\'\'\'&nbsp; || Lis
|}
',
				[
					'JsonFormatRootNode' => [
						'JsonFormatInfoboxNode' => [
							'JsonFormatInfoboxKeyValueNode' => [
								'key', 'value'
							],
							'JsonFormatInfoboxKeyValueNode:1' => [
								'key', 'value'
							],
							'JsonFormatInfoboxKeyValueNode:2' => [
								'key', 'value'
							],
							'JsonFormatInfoboxKeyValueNode:3' => [
								'key', 'value'
							],
							'JsonFormatInfoboxKeyValueNode:4' => [
								'key', 'value'
							],
							'JsonFormatInfoboxKeyValueNode:5' => [
								'key', 'value'
							]
						]
					]
				]
			],
			[
				'Text',
				[
					'JsonFormatRootNode' => [
						'JsonFormatParagraphNode' => [
							'JsonFormatTextNode' => [ ]
						],
					]
				]
			],
			[
				'[[Image:Firefly_logo.png]]
[[File:Firefly_logo.png|thumb|200px|adsfadsfasd]]',
				[
					'JsonFormatRootNode' => [
						'JsonFormatParagraphNode' => [
							'JsonFormatImageNode' => [ 'src' ],
						],
						'JsonFormatTextNode' => [ ],
						'JsonFormatImageFigureNode' => [ 'src', 'caption' ]
					]
				]
			],
			[
				'',
				[
					'JsonFormatRootNode' => []
				]
			],
			[
				'=h1=',
				[
					'JsonFormatRootNode' => [
						'JsonFormatSectionNode' => [ 'level', 'title' ]
					]
				]
			]
		];
	}

}

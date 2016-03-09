<?php

class JsonSimplifierTest extends WikiaBaseTest {
	//load extension
	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/JsonFormat/JsonFormat.setup.php";
		parent::setUp();
	}

	/**
	 * @group ContractualResponsibilitiesValidation
	 */
	public function testImages() {
		// PLA-1362
		$htmlParser = new \Wikia\JsonFormat\HtmlParser();
		$simplifier = new Wikia\JsonFormat\JsonFormatSimplifier;

		$text = 'A fake but valid image:'.
			'<a href="http://example.com" class="image">'.
			'<img src="http://example.com/image.png"></a>'.
			'And a blank, invalid one:'.
			'<a href="http://example.com" class="image">'.
			'<img alt="Quote3" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///'.
			'yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="20" height="22"></a>';
		$jsonOutput = $htmlParser->parse( $text );	
		$jsonSimple = $simplifier->simplify( $jsonOutput, "Images" );
		$images = $jsonSimple['sections'][0]['images'];
		$this->assertEquals( "http://example.com/image.png", $images[0]['src'] );
		$this->assertEquals( 1, count($images), "Blank image has not been skipped" );		
	}

	/**
	 * @group ContractualResponsibilitiesValidation
	 */
	public function testEditSection() {
		$htmlParser = new \Wikia\JsonFormat\HtmlParser();
		$simplifier = new Wikia\JsonFormat\JsonFormatSimplifier;
		
		$text = <<<'EOD'
<p>Episode 3
<a href="http://marvel.wikia.com/User_blog:Jamie/Episode_3_-_Captain_America_2:_The_Winter_Soldier" title="Episode 3 - Captain America 2: The Winter Soldier"><img alt="CBS Episode 3 Thumbnail" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="230" height="129" data-image-name="CBS Episode 3 Thumbnail.jpg" data-image-key="CBS_Episode_3_Thumbnail.jpg" data-src="http://img2.wikia.nocookie.net/__cb20140422231629/marveldatabase/images/thumb/7/77/CBS_Episode_3_Thumbnail.jpg/230px-CBS_Episode_3_Thumbnail.jpg" class="lzy lzyPlcHld" onload="if(typeof ImgLzy==&quot;object&quot;){ImgLzy.load(this)}" /><noscript><img alt="CBS Episode 3 Thumbnail" src="http://img2.wikia.nocookie.net/__cb20140422231629/marveldatabase/images/thumb/7/77/CBS_Episode_3_Thumbnail.jpg/230px-CBS_Episode_3_Thumbnail.jpg" width="230" height="129" data-image-name="CBS Episode 3 Thumbnail.jpg" data-image-key="CBS_Episode_3_Thumbnail.jpg" /></noscript></a><br />
Captain America 2: The Winter Soldier<br />
</p>
<hr />
<a href="http://marvel.wikia.com/User_blog:Jamie/Episode_3_-_Captain_America_2:_The_Winter_Soldier" title="User blog:Jamie/Episode 3 - Captain America 2: The Winter Soldier"><b>Watch Episode 3</b></a> | <a href="http://marvel.wikia.com/Marvel_Database:Comic_Book_Showcase" title="Marvel Database:Comic Book Showcase"><b>View All</b></a></div></div>
</td></tr></table>
<nav id="toc" class="toc"><div id="toctitle"><h2>Contents</h2><span class="toctoggle">[<a href="#" class="internal" id="togglelink" data-show="show" data-hide="hide">show</a>]</span></div><ol></ol></nav>
<p><br />
</p>
<h2 id="History-Header"><span class="mw-headline" id="HistoryEdit">History<span class="editsection"><a  class="text" href="http://marvel.wikia.com/index.php?title=Thor_(Thor_Odinson)&amp;action=edit">Edit</a></span></span></h2>
<dl><dd><a href="http://img1.wikia.nocookie.net/__cb20080712212308/marveldatabase/images/5/56/Quote1.png" class="image"><img alt="Quote1" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="29" height="22" data-image-name="Quote1.png" data-image-key="Quote1.png" data-src="http://img1.wikia.nocookie.net/__cb20080712212308/marveldatabase/images/5/56/Quote1.png" class="lzy lzyPlcHld" onload="if(typeof ImgLzy==&quot;object&quot;){ImgLzy.load(this)}" /><noscript><img alt="Quote1" src="http://img1.wikia.nocookie.net/__cb20080712212308/marveldatabase/images/5/56/Quote1.png" width="29" height="22" data-image-name="Quote1.png" data-image-key="Quote1.png" /></noscript></a>      <span title="Source:  &#91;&#91;Category:Quote Source Needed]]"><i> All the power of the storm, from all the world, flows through my veins, and can be summoned by mine hammer at any time, wherever it is. A lightning storm in Japan? Mine. A hurricane off the coast of Barbados? Mine again. A brace of tornadoes in Kansas? Aye...mine. All that might, all that destructive force, mine to command. Channeled and guided through the mystic might of this hammer, guided right at thee! </i></span>     <a href="http://img1.wikia.nocookie.net/__cb20080712212429/marveldatabase/images/8/88/Quote2.png" class="image"><img alt="Quote2" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="29" height="22" data-image-name="Quote2.png" data-image-key="Quote2.png" data-src="http://img1.wikia.nocookie.net/__cb20080712212429/marveldatabase/images/8/88/Quote2.png" class="lzy lzyPlcHld" onload="if(typeof ImgLzy==&quot;object&quot;){ImgLzy.load(this)}" /><noscript><img alt="Quote2" src="http://img1.wikia.nocookie.net/__cb20080712212429/marveldatabase/images/8/88/Quote2.png" width="29" height="22" data-image-name="Quote2.png" data-image-key="Quote2.png" /></noscript></a>
<dl><dd>--<b> <strong class="selflink">Thor</strong> </b><sup class="noprint"></sup>&#160;
</dd></dl>
</dd></dl>
<p><b>Thor</b> is the blood-son of <a href="http://marvel.wikia.com/Odin_Borson_(Earth-616)" title="Odin Borson (Earth-616)">Odin</a>, All-Father of the <a href="http://marvel.wikia.com/Asgardians" title="Asgardians">Asgardians</a>, and Jord, who was also known as <a href="http://marvel.wikia.com/Gaea_(Earth-616)" title="Gaea (Earth-616)">Gaea</a>, the goddess who was one of the <a href="http://marvel.wikia.com/Elder_Gods" title="Elder Gods">Elder Gods</a>. Odin sought to father a son whose power would derive from both Asgard and Midgard (as the Earth realm is called by Asgardians), and hence he sought to mate with Jord. Odin created a cave in <a href="http://marvel.wikia.com/Norway" title="Norway">Norway</a> where Jord gave birth to Thor.<sup id="cite_ref-Thor_King-Size_Special_Vol_1_4_0-0" class="reference"><a href="#cite_note-Thor_King-Size_Special_Vol_1_4-0">[1]</a></sup> Months after the infant Thor was weaned, Odin brought him to Asgard to be raised. Odin's wife, the goddess <a href="http://marvel.wikia.com/Frigga_(Earth-616)" title="Frigga (Earth-616)">Frigga</a>, acted as Thor's mother from that time onward. Not until many decades later did Thor learn that Jord was his birth mother.
</p>
EOD;
		$jsonOutput = $htmlParser->parse( $text );	
		$jsonSimple = $simplifier->simplify( $jsonOutput, "Thor" );
		$this->assertEquals('History', $jsonSimple['sections'][1]['title'], "Edit section should not be included in title");
		$this->assertEquals(2, count($jsonSimple['sections']), "There should be 2 sections");		
	}

	/**
	 * @group ContractualResponsibilitiesValidation
	 */
	public function testLists() {
		$htmlParser = new \Wikia\JsonFormat\HtmlParser();
		$simplifier = new Wikia\JsonFormat\JsonFormatSimplifier;

		$text = <<<'EOD'
<ul><li>"<a href="/wiki/Casa_Bonita" title="Casa Bonita">Casa Bonita</a>"
</li><li>"<a href="/wiki/Sexual_Healing" title="Sexual Healing">Sexual Healing</a>"
</li><li>"<a href="/wiki/Make_Love,_Not_Warcraft" title="Make Love, Not Warcraft">Make Love, Not Warcraft</a>"
</li></ul>
EOD;

		$jsonOutput = $htmlParser->parse( $text );	
		$jsonSimple = $simplifier->simplify( $jsonOutput, "Chips-A-Ho!" );
		$this->assertEquals( "list", $jsonSimple['sections'][0]['content'][0]['type'] );
		$this->assertEquals( '"Casa Bonita"', $jsonSimple['sections'][0]['content'][0]['elements'][0]['text'] );
	}
	
	/**
	 * @group Slow
	 * @group ContractualResponsibilitiesValidation
	 * @slowExecutionTime 0.01676 ms
	 */
	public function testProcessList() {

		$mockSimplifier = $this->getMockBuilder( '\Wikia\JsonFormat\JsonFormatSimplifier' )
			->disableOriginalConstructor()
			->setMethods( ['__construct', 'readText'] )
			->getMock();

		$mockSimplifier->expects( $this->any() )
			->method( 'readText' )
			->will( $this->returnCallback( array($this, 'mock_readText') ) );


		/*Generate mock objects*/
		for ( $i = 1; $i < 5; $i++ ) {

			if ( $i <= 2 ) {
				$mockList[ $i ] = $this->getMockBuilder( 'JsonFormatListNode' )
					->disableOriginalConstructor()
					->setMethods( ['getChildren', 'getType'] )
					->getMock();

				$mockList[ $i ]->expects( $this->any() )
					->method( 'getType' )
					->will( $this->returnValue( 'list' ) );
			}

			$mockListItem[ $i ] = $this->getMockBuilder( 'JsonFormatListItemNode' )
				->disableOriginalConstructor()
				->setMethods( ['getChildren', 'getType'] )
				->getMock();

			$mockListItem[ $i ]->expects( $this->any() )
				->method( 'getType' )
				->will( $this->returnValue( 'listItem' ) );

			$mockTextNode[ $i ] = $this->getMockBuilder( 'JsonFormatTextNode' )
				->disableOriginalConstructor()
				->setMethods( ['getText', 'getType'] )
				->getMock();

			$mockTextNode[ $i ]->expects( $this->any() )
				->method( 'getType' )
				->will( $this->returnValue( 'text' ) );

			$mockTextNode[ $i ]->expects( $this->any() )
				->method( 'getText' )
				->will( $this->returnValue( 'text_' . $i ) );

			$mockContainer[ $i ] = $this->getMockBuilder( 'JsonFormatContainerNode' )
				->disableOriginalConstructor()
				->setMethods( ['getChildren', 'getType'] )
				->getMock();

			$mockContainer[ $i ]->expects( $this->any() )
				->method( 'getType' )
				->will( $this->returnValue( 'container' ) );
		}


		/*Generate objects tree */
		$this->setMockMethodValue( $mockList[ 1 ], [$mockListItem[ 1 ], $mockListItem[ 2 ]], 'getChildren' );

		$this->setMockMethodValue( $mockListItem[ 1 ], [$mockTextNode[ 1 ]], 'getChildren' );
		$this->setMockMethodValue( $mockListItem[ 2 ], [$mockTextNode[ 2 ], $mockList[ 2 ]], 'getChildren' );

		$this->setMockMethodValue( $mockList[ 2 ], [$mockListItem[ 3 ], $mockListItem[ 4 ]], 'getChildren' );
		$this->setMockMethodValue( $mockListItem[ 3 ], [$mockTextNode[ 3 ]], 'getChildren' );
		$this->setMockMethodValue( $mockListItem[ 4 ], [$mockTextNode[ 4 ]], 'getChildren' );

		$refl = new ReflectionClass($mockSimplifier);
		$method = $refl->getMethod( 'processList' );
		$method->setAccessible( true );

		$expected = [
			['text' => 'text_1', 'elements' => []],

			['text' => 'text_2', 'elements' => [
					['text' => 'text_3', 'elements' => []],
					['text' => 'text_4', 'elements' => []]
				]
			]
		];

		$this->assertEquals( $expected, $method->invoke( $mockSimplifier, $mockList[ 1 ] ) );
	}

	public function mock_readText( $parentNode ) {
		$out = '';
		foreach ( $parentNode->getChildren() as $childNode ) {
			if ( $childNode->getType() == 'text' ) {
				$out .= $childNode->getText();
			}
		}
		return $out;
	}


	private function setMockMethodValue( &$mock, $value, $method = 'getText' ) {
		$mock->expects( $this->any() )
			->method( $method )
			->will( $this->returnValue( $value ) );
	}

	/**
	 * @group ContractualResponsibilitiesValidation
	 */
	public function testPrehistoricIceMan() {
		// PLA-1343
		$htmlParser = new \Wikia\JsonFormat\HtmlParser();
		$simplifier = new Wikia\JsonFormat\JsonFormatSimplifier;
		$text = '<p><b>"Prehistoric Ice Man"</b> is the eighteenth and final episode of '.
						'<a href="/wiki/Season_Two" title="Season Two">Season Two</a>, and the 31st '.
						'overall episode of <i>South Park</i>. It originally aired on January 20, 1999'.
						'<sup id="cite_ref-0" class="reference"><a href="#cite_note-0">[1]</a></sup>.</p>';
		$jsonOutput = $htmlParser->parse($text);	
		$jsonSimple = $simplifier->simplify( $jsonOutput, "Prehistoric Ice Man" );	
		$this->assertEquals("paragraph", $jsonSimple['sections'][0]['content'][0]['type']);
		$paragraph = $jsonSimple['sections'][0]['content'][0]['text'];
		$this->assertEquals('"Prehistoric Ice Man" is the eighteenth and final episode of Season Two, '.
			'and the 31st overall episode of South Park. It originally aired on January 20, 1999.', $paragraph);		
	}
}

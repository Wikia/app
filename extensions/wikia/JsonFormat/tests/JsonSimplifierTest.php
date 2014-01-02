<?php

class JsonSimplifierTest extends WikiaBaseTest {
	//load extension
	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/JsonFormat/JsonFormat.setup.php";
		parent::setUp();
	}


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


}
<?php

class WikiaExternalImageListTest extends WikiaBaseTest {
	/**
	 * @covers WikiaExternalImageList
	 * @dataProvider checkingUrlsAgainstWhiteListProvider
	 */
	public function testCheckingUrlsAgainstWhiteList( $url, $whiteList, $expected ) {
		$globalTitleMock = $this->getMock( 'GlobalTitle', [ 'getContent' ] );
		$globalTitleMock->expects( $this->any() )
			->method( 'getContent' )
			->willReturn( $whiteList );
		$this->mockClass( 'GlobalTitle', $globalTitleMock );

		$result = WikiaExternalImageList::onOutputMakeExternalImage( $url );
		$this->assertEquals( $expected, $result );
	}

	public function checkingUrlsAgainstWhiteListProvider() {
		return [
			[
				'https://i.imgur.com/NfClEf0.gif',
				[ '^https?://i\.imgur\.com/[a-z0-9\.]+(gif|jpg|jpeg|png)$', '^http://4cdn\.hu/kraken/image/upload/[^\n]+.jpeg$' ],
				true
			],
			[
				'http://i.imgur.com/NfClEf0.gif',
				[ '^https?://i\.imgur\.com/[a-z0-9\.]+(gif|jpg|jpeg|png)$', '^http://4cdn\.hu/kraken/image/upload/[^\n]+.jpeg$' ],
				true
			],
			[
				'http://i.imgur.com/russianscript.js',
				[ '^https?://i\.imgur\.com/[a-z0-9\.]+(gif|jpg|jpeg|png)$', '^http://4cdn\.hu/kraken/image/upload/[^\n]+.jpeg$' ],
				false
			],
			[
				'http://www.example.com/assets/evil',
				[ '^https?://i\.imgur\.com/[a-z0-9\.]+(gif|jpg|jpeg|png)$', '^http://4cdn\.hu/kraken/image/upload/[^\n]+.jpeg$' ],
				false
			],
		];
	}
}

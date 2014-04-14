<?php
require_once( $IP . '/extensions/wikia/LyricsApi/LyricsUtils.class.php' );

class LyricsUtilsTest extends WikiaBaseTest {

	/**
	 * @param String $message
	 * @param String $input
	 * @param String $expected
	 *
	 * @dataProvider removeWikitextFromLyricsDataProvider
	 */
	public function testRemoveWikitextFromLyrics( $message, $input, $expected ) {
		$this->assertEquals( $expected, LyricsUtils::removeWikitextFromLyrics( $input ), $message );
	}

	public function removeWikitextFromLyricsDataProvider() {
		return [
			[
				'empty string',
				'',
				''
			],
			[
				'cleaning wikipedia template',
				"Benjamin {{wp|Franklin Peale|Franklin Peale}}, usually {{wp|Franklin Peale|Franklin}}, was an employee and officer of the Philadelphia Mint from 1833 to 1854. Although Peale introduced many innovations to the Mint of the United States, he was eventually dismissed amid allegations he had used his position for personal gain.",
				"Benjamin Franklin Peale, usually Franklin, was an employee and officer of the Philadelphia Mint from 1833 to 1854. Although Peale introduced many innovations to the Mint of the United States, he was eventually dismissed amid allegations he had used his position for personal gain.",
			],
		];
	}

}

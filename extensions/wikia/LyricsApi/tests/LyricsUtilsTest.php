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
			[
				'cleaning wikitext formatting',
				"Benjamin ''Franklin Peale'', usually '''Franklin Peale''', was an employee and '''''officer''''' of the Philadelphia Mint from 1833 to 1854. Although Peale introduced many innovations to the Mint of the United States, he was eventually dismissed amid allegations he had used his position for personal gain.",
				"Benjamin Franklin Peale, usually Franklin Peale, was an employee and officer of the Philadelphia Mint from 1833 to 1854. Although Peale introduced many innovations to the Mint of the United States, he was eventually dismissed amid allegations he had used his position for personal gain.",
			],
			[
				'cleaning wikitext links',
				"Benjamin [[Franklin Peale]], usually [http://wikia.com Franklin Peale], was an employee and '''''officer''''' of the Philadelphia Mint from 1833 to 1854. Although Peale introduced many innovations to the Mint of the United States, he was eventually dismissed amid allegations he had used his position for personal gain.",
				"Benjamin Franklin Peale, usually Franklin Peale, was an employee and officer of the Philadelphia Mint from 1833 to 1854. Although Peale introduced many innovations to the Mint of the United States, he was eventually dismissed amid allegations he had used his position for personal gain.",
			],
		];
	}

	/**
	 * @param $message
	 * @param $field
	 * @param $affToken
	 * @param $expected
	 *
	 * @dataProvider generateITunesUrlDataProvider
	 */
	public function testGenerateITunesURL( $message, $field, $affToken, $expected ) {
		$this->assertEquals( $expected, LyricsUtils::generateITunesUrl( $field, $affToken), $message );
	}

	public function generateITunesUrlDataProvider() {
		return [
			[
				'empty field',
				'',
				'0',
				false
			],
			[
				'use default country',
				'id292721355?i=292721406',
				'30',
				'http://itunes.apple.com/us/album/id292721355?i=292721406&at=30'
			],
			[
				'use cusotom country',
				'id251299901?i=251299941&cc=gb',
				'31',
				'http://itunes.apple.com/gb/album/id251299901?i=251299941&at=31'
			],
		];
	}
}

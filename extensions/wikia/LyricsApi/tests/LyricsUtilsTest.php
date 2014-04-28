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
	public function testGenerateITunesURL( $message, $field, $linkType, $affToken, $expected ) {
		$this->assertEquals( $expected, LyricsUtils::generateITunesUrl( $field, $linkType, $affToken), $message );
	}

	public function generateITunesUrlDataProvider() {
		return [
			[
				'empty field',
				'',
				LyricsUtils::TYPE_SONG,
				'0',
				false
			],
			[
				'use default country',
				'id292721355?i=292721406',
				LyricsUtils::TYPE_SONG,
				'30',
				'http://itunes.apple.com/us/album/id292721355?i=292721406&at=30'
			],
			[
				'use custom country',
				'id251299901?i=251299941&cc=gb',
				LyricsUtils::TYPE_SONG,
				'31',
				'http://itunes.apple.com/gb/album/id251299901?i=251299941&at=31'
			],
			[
				'wrong song link',
				'23204023',
				LyricsUtils::TYPE_SONG,
				'32',
				'http://itunes.apple.com/us/album/id23204023?at=32'
			],
			[
				'artist link',
				'23203991',
				LyricsUtils::TYPE_ARTIST,
				'33',
				'http://itunes.apple.com/us/artist/id23203991?at=33'
			],
			[
				'album link',
				'id532966186',
				LyricsUtils::TYPE_ALBUM,
				'34',
				'http://itunes.apple.com/us/album/id532966186?at=34'
			],
			[
				'wrong album link',
				'532966186',
				LyricsUtils::TYPE_ALBUM,
				'35',
				'http://itunes.apple.com/us/album/id532966186?at=35'
			],
			[
				'Finnish song',
				'id255733668?i=255733670&cc=fi',
				LyricsUtils::TYPE_SONG,
				'36',
				'http://itunes.apple.com/fi/album/id255733668?i=255733670&at=36'
			],
			[
				'Wrong id finnish album',
				'387912205&cc=fi',
				LyricsUtils::TYPE_ALBUM,
				'37',
				'http://itunes.apple.com/fi/album/id387912205?at=37'
			]
		];
	}

	/**
	 * @param String $message
	 * @param String $input
	 * @param String $expected
	 *
	 * @dataProvider removeBracketsDataProvider
	 */
	public function testRemoveBrackets( $message, $input, $expected ) {
		$this->assertEquals( $expected, LyricsUtils::removeBrackets( $input ), $message );
	}

	public function removeBracketsDataProvider() {
		return [
			[
				'empty string',
				'',
				''
			],
			[
				'empty parenthesis',
				'()',
				''
			],
			[
				'parenthesis at the end',
				'Happy (From "Despicable Me 2")',
				'Happy'
			],
			[
				'two parenthesis at the end',
				'Happy (From "Despicable Me 2") (German version)',
				'Happy'
			],
			[
				'two parenthesis at the end',
				'Happy (From "Despicable Me 2") (German version)',
				'Happy'
			],
		];
	}
}

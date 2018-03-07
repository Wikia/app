<?php

use PHPUnit\Framework\TestCase;

require_once 'migrateCustomCss.php';

class MigrateCustomCssToHttpsTest extends WikiaBaseTest {

	function setUp() {
		parent::setUp();
		// mock the class to silence the output method
		$this->task = $this->getMockBuilder( 'MigrateCustomCssToHttps' )
			->setMethods( [ 'output' ] )
			->getMock();

		$this->mockGlobalVariable( 'wgServer', 'http://mechtest.wikia.com' );
	}

	public function testWikiaComVignetteUrls() {

		$this->assertEquals( 'https://images.wikia.nocookie.net/guildwars/es/images//6/64/Favicon.ico',
			$this->task->fixUrl( 'http://images.wikia.com/guildwars/es/images//6/64/Favicon.ico' ) );

		$this->assertEquals( 'https://images.wikia.nocookie.net/guildwars/es/images//6/64/Favicon.ico',
			$this->task->fixUrl( 'http://static.wikia.com/guildwars/es/images//6/64/Favicon.ico' ) );

		$this->assertEquals( 'https://images.wikia.nocookie.net/guildwars/es/images//6/64/Favicon.ico',
			$this->task->fixUrl( 'https://static.wikia.com/guildwars/es/images//6/64/Favicon.ico' ) );

		$this->assertEquals( 'https://vignette.wikia.nocookie.net/guildwars/es/images//6/64/Favicon.ico',
			$this->task->fixUrl( 'http://vignette2.wikia.nocookie.net/guildwars/es/images//6/64/Favicon.ico' ) );
	}

	public function testVignetteUrlsWithParams() {
		$this->assertEquals( 'https://images.wikia.nocookie.net/runescape/images/a/ab/Runescape_chat.eot?a=b',
			$this->task->fixUrl( 'http://images.wikia.com/runescape/images/a/ab/Runescape_chat.eot?a=b' ) );

		$this->assertEquals( 'https://vignette.wikia.nocookie.net/guildwars/es/images//6/64/Favicon.ico?a=b',
			$this->task->fixUrl( 'http://vignette2.wikia.nocookie.net/guildwars/es/images//6/64/Favicon.ico?a=b' ) );


		// if the params are empty, allow to remove the question mark
		$this->assertEquals( 'https://images.wikia.nocookie.net/runescape/images/a/ab/Runescape_chat.eot',
			$this->task->fixUrl( 'http://images.wikia.com/runescape/images/a/ab/Runescape_chat.eot?' ) );
	}

	public function testShardedVignetteUrls() {

		$this->assertEquals( 'https://images.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png',
			$this->task->fixUrl( 'http://images1.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png' ) );

		$this->assertEquals( 'https://vignette.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png',
			$this->task->fixUrl( 'http://vignette5.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png' ) );

		$this->assertEquals( 'https://images.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png',
			$this->task->fixUrl( 'http://img1.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png' ) );

		$this->assertEquals( 'https://images.wikia.nocookie.net/monsterhunters/ko/images/c/cc/Infobox_header_overlay.png',
			$this->task->fixUrl( 'http://image3.wikia.nocookie.net/monsterhunters/ko/images/c/cc/Infobox_header_overlay.png' ) );

		$this->assertEquals( 'https://images.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png',
			$this->task->fixUrl( 'http://static1.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png' ) );

		$this->assertEquals( 'https://images.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png',
			$this->task->fixUrl( 'http://slot1.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png' ) );
	}

	public function testWwwPrefixedVignetteUrls() {
		$this->assertEquals( 'https://images.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png',
			$this->task->fixUrl( 'http://www.images.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png' ) );

		$this->assertEquals( 'https://images.wikia.nocookie.net/__cb20121002232621/narutofantasyrpg/de/images/e/e1/Benutzer_Icon_Monobook.png',
			$this->task->fixUrl( 'http://www.images2.wikia.nocookie.net/__cb20121002232621/narutofantasyrpg/de/images/e/e1/Benutzer_Icon_Monobook.png' ) );

		$this->assertEquals( 'https://images.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png',
			$this->task->fixUrl( 'http://www.static.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png' ) );
	}

	public function testLegacyImagesUrls() {

		$this->assertEquals( 'https://images.wikia.nocookie.net/__cb100006/common/skins/oasis/images/sprite.png',
			$this->task->fixUrl( 'http://slot1.images.wikia.nocookie.net/__cb100006/common/skins/oasis/images/sprite.png' ) );

		$this->assertEquals( 'https://images.wikia.nocookie.net/__cb1509098293/common/skins/shared/images/sprite.png',
			$this->task->fixUrl( 'https://slot1-images.wikia.nocookie.net/__cb1509098293/common/skins/shared/images/sprite.png' ) );

		$this->assertEquals( 'https://images.wikia.nocookie.net/__cb58376/common/resources/jquery.ui/themes/default/jquery.ui.theme.css',
			$this->task->fixUrl( 'http://slot2.images.wikia.nocookie.net/__cb58376/common/resources/jquery.ui/themes/default/jquery.ui.theme.css' ) );

		$this->assertEquals( 'https://images.wikia.nocookie.net/__cb1509098293/common/skins/shared/images/sprite.png',
			$this->task->fixUrl( 'https://www.slot1-images.wikia.nocookie.net/__cb1509098293/common/skins/shared/images/sprite.png' ) );

		$this->assertEquals( 'https://images.wikia.nocookie.net/__cb58376/common/resources/jquery.ui/themes/default/jquery.ui.theme.css',
			$this->task->fixUrl( 'http://slot2.images.wikia.nocookie.net/__cb58376/common/resources/jquery.ui/themes/default/jquery.ui.theme.css' ) );
	}

	public function testProtocolRelativeVignetteUrls() {

		$this->assertEquals( 'https://images.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png',
			$this->task->fixUrl( '//www.static.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png' ) );

		$this->assertEquals( 'https://vignette.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png',
			$this->task->fixUrl( '//vignette.wikia.nocookie.net/djinni/images/6/68/Wikia_logo.png' ) );
	}

	public function testExternalHttpUrls() {
		$this->assertEquals( '//muppet.wikia.com/wiki/MediaWiki:aaa.css',
			$this->task->fixUrl( 'http://muppet.wikia.com/wiki/MediaWiki:aaa.css' ) );

		$this->assertEquals( '//de.starwars.wikia.com/wiki/MediaWiki:aaa.css',
			$this->task->fixUrl( 'http://de.starwars.wikia.com/wiki/MediaWiki:aaa.css' ) );

		// leave https links intact
		$this->assertEquals( 'https://muppet.wikia.com/wiki/MediaWiki:aaa.css',
			$this->task->fixUrl( 'https://muppet.wikia.com/wiki/MediaWiki:aaa.css' ) );
	}

	public function testLocalHttpUrls() {
		$this->assertEquals( '/wiki/MediaWiki:aaa.css',
			$this->task->fixUrl( 'http://mechtest.wikia.com/wiki/MediaWiki:aaa.css' ) );

		$this->assertEquals( '/wiki/MediaWiki:aaa.css',
			$this->task->fixUrl( 'https://mechtest.wikia.com/wiki/MediaWiki:aaa.css' ) );

		$this->assertEquals( '/wiki/MediaWiki:aaa.css',
			$this->task->fixUrl( '//mechtest.wikia.com/wiki/MediaWiki:aaa.css' ) );
	}

	public function testThirdPartyUrls() {
		// do not touch https links
		$this->assertEquals( 'https://www.xyz.com/aaa.css',
			$this->task->fixUrl( 'https://www.xyz.com/aaa.css' ) );

		// do not touch protocol relative links
		$this->assertEquals( '//fonts.googleapis.com/css?family=Henny+Penny',
			$this->task->fixUrl( '//fonts.googleapis.com/css?family=Henny+Penny' ) );
		$this->assertEquals( '//www.xyz.com/aaa.css',
			$this->task->fixUrl( '//www.xyz.com/aaa.css' ) );

		// do not touch unknown hosts
		$this->assertEquals( 'http://www.xyz.com/aaa.css',
			$this->task->fixUrl( 'http://www.xyz.com/aaa.css' ) );

		// upgrade well known third party links
		$this->assertEquals( 'https://i.imgur.com/PONtpqK.jpg',
			$this->task->fixUrl( 'http://i.imgur.com/PONtpqK.jpg' ) );

		$this->assertEquals( 'https://fonts.googleapis.com/css?family=Nunito',
			$this->task->fixUrl( 'http://fonts.googleapis.com/css?family=Nunito' ) );

		$this->assertEquals( 'https://upload.wikimedia.org/wikipedia/en/a/a7/Monobook-globe.png',
			$this->task->fixUrl( 'http://upload.wikimedia.org/wikipedia/en/a/a7/Monobook-globe.png' ) );

		$this->assertEquals( 'https://en.wikipedia.org/skins/monobook/discussionitem_icon.gif',
			$this->task->fixUrl( 'http://en.wikipedia.org/skins/monobook/discussionitem_icon.gif' ) );
	}

	/**
	 * @desc Tests the main functionality of scrapers (it's being re-used in all types of scrapers)
	 * @dataProvider getCssUrlExtractorDataProvider
	 */
	public function testCssUrlExtractor($css, $match) {
		$taskMock = $this->getMockBuilder( 'MigrateCustomCssToHttps' )
			->setMethods( [ 'makeUrlHttpsComatible', 'output' ] )
			->getMock();

		$taskMock
			->expects( is_null( $match ) ? $this->never() : $this->once() )
			->method( 'makeUrlHttpsComatible' )
			->with( $match );

		$taskMock->updateCSSContent( $css );
	}

	public function getCssUrlExtractorDataProvider() {
		return [
			# regular url
			[ 'background: #fff; url(http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg) repeat scroll center top;',
				[ 'url(http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg)', 'http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg' ] ],
			# space after "url"
			[ 'background: #fff; url (http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg) repeat scroll center top;',
				[ 'url (http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg)', 'http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg' ] ],
			# single quotes
			[ 'background: #fff; url(\'http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg\') repeat scroll center top;',
				[ 'url(\'http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg\')', 'http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg' ] ],
			[ 'background: #fff; url( \'http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg\' ) repeat scroll center top;',
				[ 'url( \'http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg\' )', 'http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg' ] ],
			[ 'background: #fff; url ( "http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bgx.jpg" ) repeat scroll center top;',
				[ 'url ( "http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bgx.jpg" )', 'http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bgx.jpg' ] ],
			# double quotes
			[ 'background: #fff; url("http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg") repeat scroll center top;',
				[ 'url("http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg")', 'http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg' ] ],
			# uppercase
			[ 'background: #fff; URL("http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg") repeat scroll center top;',
				[ 'URL("http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg")', 'http://images.wikia.com/gaia/images/1/1d/Gaiaonline_global_bg.jpg' ] ],
			# parentheses in url
			[ 'background-image: url("http://runescape.wikia.com/wiki/Special:FilePath?file=Inventory_interface_(horizontal).png");',
				[ 'url("http://runescape.wikia.com/wiki/Special:FilePath?file=Inventory_interface_(horizontal).png")', 'http://runescape.wikia.com/wiki/Special:FilePath?file=Inventory_interface_(horizontal).png' ] ],
			#
			# @import
			[ '@import "http://gaia.wikia.com/index.php?title=MediaWiki:Common.css&action=raw&ctype=text/css";',
				[ '@import "http://gaia.wikia.com/index.php?title=MediaWiki:Common.css&action=raw&ctype=text/css"', 'http://gaia.wikia.com/index.php?title=MediaWiki:Common.css&action=raw&ctype=text/css' ] ],
			[ '@import \'http://gaia.wikia.com/index.php?title=MediaWiki:Common.css&action=raw&ctype=text/css\';',
				[ '@import \'http://gaia.wikia.com/index.php?title=MediaWiki:Common.css&action=raw&ctype=text/css\'', 'http://gaia.wikia.com/index.php?title=MediaWiki:Common.css&action=raw&ctype=text/css' ] ],
			[ '@IMPORT \'http://gaia.wikia.com/index.php?title=MediaWiki:Common.css&action=raw&ctype=text/css\';',
				[ '@IMPORT \'http://gaia.wikia.com/index.php?title=MediaWiki:Common.css&action=raw&ctype=text/css\'', 'http://gaia.wikia.com/index.php?title=MediaWiki:Common.css&action=raw&ctype=text/css' ] ],
			# alpha filter
			[ '#submit {filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'/images/btn.png\', sizingMethod=\'scale\');}',
				[ '(src=\'/images/btn.png\'', '/images/btn.png' ] ],
			[ 'filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=http://commons.wikimedia.org/wiki/File:RomanF-01.png, sizingMethod=\'crop\')',
				[ '(src=http://commons.wikimedia.org/wiki/File:RomanF-01.png', 'http://commons.wikimedia.org/wiki/File:RomanF-01.png' ] ],
			[ 'filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=http://commons.wikimedia.org/wiki/File:RomanF-01.png)',
				[ '(src=http://commons.wikimedia.org/wiki/File:RomanF-01.png', 'http://commons.wikimedia.org/wiki/File:RomanF-01.png' ] ],

			# urls that should not be altered
			[ '.speech-bubble-message a[href="http://theuniversim.wikia.com/wiki/Message_Wall:"]:not(.subtle)::after {', null ],
			[ '* For more information see <http://dev.wikia.com/wiki/Less>', null ],
			[ ' bottom (see http://www.fontspring.com/blog/the-new-bulletproof-font-face-syntax)', null ],
			[ 'a[href="http://ru.bloodborne.wikia.com/wiki/%D0%A1%D0%BB%D1%83%D0%B6%D0%B5%D0%B1%D0%BD%D0%B0%D1%8F:Contributions/Bermoodok"]', null ],
			[ '.listofponies a[href^="http://www.reddit.com/r/listofponies"],', null ],
		];
	}

}

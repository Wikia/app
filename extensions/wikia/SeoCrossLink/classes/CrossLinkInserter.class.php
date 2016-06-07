<?php

namespace Wikia\SeoCrossLink;

use Wikia\Logger\WikiaLogger;

class CrossLinkInserter {
	/**
	 * Hot words will be only searched within this many first characters of the content
	 */
	const CHARACTER_LIMIT = 20000;

	const HOT_WORDS = [
		[ 'Mojito', 'http://cocktails.wikia.com/wiki/Mojito', 'cocktails' ],
		[ 'Mojitos', 'http://cocktails.wikia.com/wiki/Mojito', 'cocktails' ],
		[ 'Gruyère', 'http://cheese.wikia.com/wiki/Gruy%C3%A8re', 'cheese' ],
		[ 'Gruyere', 'http://cheese.wikia.com/wiki/Gruy%C3%A8re', 'cheese' ],
		[ 'Sushi', 'http://japaneserecipes.wikia.com/wiki/Sushi', 'japaneserecipes' ],
		[ 'Pilsner', 'http://beer.wikia.com/wiki/Pilsner', 'beer' ],
		[ 'Frappuccino', 'http://coffee.wikia.com/wiki/Frappuccino', 'coffee' ],
		[ 'Wolverine', 'http://marvel.wikia.com/wiki/James_Howlett_%28Earth-616%29', 'enmarveldatabase' ],
		[ 'Maserati', 'http://automobile.wikia.com/wiki/Maserati', 'automobile' ],
		[ 'Green tea', 'http://tea.wikia.com/wiki/Green_tea', 'tea' ],
		[ 'AK-47', 'http://guns.wikia.com/wiki/Kalashnikov_rifle', 'guns' ],
		[ 'AK 47', 'http://guns.wikia.com/wiki/Kalashnikov_rifle', 'guns' ],
		[ 'AK47', 'http://guns.wikia.com/wiki/Kalashnikov_rifle', 'guns' ],
	];

	public function insertCrossLinks( $text ) {
		global $wgDBname;

		$firstPart = mb_substr( $text, 0, self::CHARACTER_LIMIT );

		$urlsAlreadyLinked = [];

		foreach ( self::HOT_WORDS as $line ) {
			list( $hotWord, $targetUrl, $targetDbName ) = $line;

			// Only link once to a given URL
			if ( in_array( $targetUrl, $urlsAlreadyLinked ) ) {
				continue;
			}

			// Don't do internal links
			if ( $targetDbName === $wgDBname ) {
				continue;
			}

			// Early exit before doing heavy regular expressions
			if ( mb_stripos( $firstPart, $hotWord ) === false ) {
				continue;
			}

			// Regex time: find the occurrence of the word after opening of <p>, <li>, <td>, <div>
			// <span>, <b>, <i>, <string>, or <em> tag without any other HTML between the opening
			// and the word. A closing </br> tag will do too
			$regex = ':<(li|td|p|div|span|b|i|strong|em|/br)( [^<>]*)?>([^<>]*?)(\b' . preg_quote( $hotWord ) . '\b):i';
			$replacement = '<\1\2>\3<a class="external" href="' . htmlspecialchars( $targetUrl ) . '">\4</a>';

			if ( preg_match( $regex, $firstPart ) ) {
				// Only replace the first matched appearance of the word
				$firstPart = preg_replace( $regex, $replacement, $firstPart, 1 );
				$urlsAlreadyLinked[] = $targetUrl;
				WikiaLogger::instance()->info( __CLASS__ . ' ' . $targetUrl );
			}
		}

		if ( count( $urlsAlreadyLinked ) === 0 ) {
			// Didn't replace anything, just exit
			return $text;
		}

		$remainder = mb_substr( $text, self::CHARACTER_LIMIT );

		return $firstPart . $remainder;
	}
}

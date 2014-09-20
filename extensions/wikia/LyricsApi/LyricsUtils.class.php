<?php

/**
 * Class LyricsUtils
 *
 * @desc Keeps data which are being reused in API controller and maintenance scripts
 */
class LyricsUtils {
	/**
	 * @desc Field type in lyricsapi solr index which describes an artist
	 */
	const TYPE_ARTIST = 'artist';

	/**
	 * @desc Field type in lyricsapi solr index which describes an album
	 */
	const TYPE_ALBUM = 'album';

	/**
	 * @desc Field type in lyricsapi solr index which describes a song
	 */
	const TYPE_SONG = 'song';

	/**
	 * @desc Decodes JSON into array/object
	 *
	 * @param String $text
	 *
	 * @return mixed
	 */
	public static function deserialize( $text ) {
		return json_decode( $text );
	}

	/**
	 * Converts string to lowercase
	 *
	 * @param string $text
	 * @return string
	 */
	public static function lowercase( $text ) {
		return mb_strtolower( $text );
	}

	/**
	 * @desc Given the lyrics (possibly containing wikitext) this will filter most wikitext out of them
	 * that is likely to appear in them.
	 *
	 * @param String $lyrics
	 * @return String
	 */
	public static function removeWikitextFromLyrics( $lyrics ) {
		global $wgParser;

		$lyrics = preg_replace_callback( '/\{\{(.*?)\}\}/', function( $matches ) {
			$explodedArr = explode( '|', $matches[1] );
			return $explodedArr[ count( $explodedArr ) - 1 ];
		}, $lyrics );

		return trim( $wgParser->stripSectionName( $lyrics ) );
	}

	/**
	 * @desc Generate iTunes link from the itunes data field
	 *
	 * @param string $field
	 * @param string $linkType
	 * @param string $affToken
	 * @return bool|string
	 */
	public static function generateITunesUrl( $field, $linkType, $affToken = '' ) {
		if ( $field ) {
			$country = 'us';
			$segments = explode( '&cc=', $field );
			if ( count( $segments ) > 1 ) {
				$field = $segments[ 0 ];
				$country = $segments[ 1 ];
			}
			// Segment is artist for artists and album for albums and songs
			$segment = $linkType == self::TYPE_ARTIST ? self::TYPE_ARTIST : self::TYPE_ALBUM;
			$linkParts = explode( '?', $field );
			$path = $linkParts[ 0 ];
			// Fix paths without leading id
			$path = substr( $path, 0, 2 ) === 'id' ? $path : 'id' . $path;
			// Get params if any (for songs)
			$params = [];
			if ( isset( $linkParts[ 1 ] ) ) {
				parse_str( $linkParts[ 1 ], $params );
			}
			// Add affiliate token param
			$params[ 'at' ] = $affToken;
			// Generate final URL
			return sprintf(
				'http://itunes.apple.com/%s/%s/%s?%s',
				$country,
				$segment,
				$path,
				http_build_query( $params )
			);
		}
		return false;
	}

	public static function removeBrackets( $string ) {
		return trim( preg_replace( '#(\(|\[)(.*?)(\)|\])#s', '', $string ) );
	}

}

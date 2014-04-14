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
	 * @desc Given the lyrics (possibly containing wikitext) this will filter most wikitext out of them
	 * that is likely to appear in them.
	 *
	 * @param String $lyrics
	 * @return String
	 */
	public static function removeWikitextFromLyrics( $lyrics ) {
		// Clean up wikipedia template to be plaintext
		$lyrics = preg_replace( "/\{\{wp.*\|(.*?)\}\}/", "$1", $lyrics );

		// Clean up links & category-links to be plaintext
		$lyrics = preg_replace( "/\[\[([^\|\]]*)\]\]/", "$1", $lyrics ); // links with no alias (no pipe)
		$lyrics = preg_replace( "/\[\[.*\|(.*?)\]\]/", "$1", $lyrics );

		// Filter out extra formatting markup
		$lyrics = preg_replace( "/'''/", "", $lyrics ); // rm bold
		$lyrics = preg_replace( "/''/", "", $lyrics ); // rm italics

		return $lyrics;
	}

}

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

}

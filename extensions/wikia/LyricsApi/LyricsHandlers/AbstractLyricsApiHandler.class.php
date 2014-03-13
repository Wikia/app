<?php
/**
 * Class AbstractLyricsApiHandler
 *
 * @desc An interface for all *LyricsApiHandlers
 */
abstract class AbstractLyricsApiHandler {

	const API_ENTRY_POINT = 'wikia.php';
	const API_CONTROLLER_NAME = 'LyricsApi';

	abstract public function getArtist( $artist );
	abstract public function getAlbum( $artist, $album );
	abstract public function getSong( $artist, $album, $song );
	abstract public function searchArtist( $query );
	abstract public function searchSong( $query );
	abstract public function searchLyrics( $query );

	/**
	 * @desc Builds an URL to the API
	 *
	 * @param Array $params params added to the URL
	 *
	 * @return string
	 */
	protected function buildUrl( $params ) {
		global $wgServer;
		return implode('',
			[
				$wgServer,
				'/',
				self::API_ENTRY_POINT,
				'?',
				http_build_query( $params )
			]);
	}

}
 

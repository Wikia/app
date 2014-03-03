<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/3/14
 * Time: 1:50 PM
 */


class LyricsApiController extends WikiaController {
	const PARAM_ARTIST = 'artist';

	const RESPONSE_CACHE_VALIDITY = 86400; // 24h

	private $lyricsApiHandler = null;

	public function __construct() {
		$this->lyricsApiHandler = new MockLyricsApiHandler();
	}

	public function getArtist() {
		$artist = $this->wg->Request->getVal( self::PARAM_ARTIST );

		if( empty( $artist ) ) {
			throw new InvalidParameterApiException( self::PARAM_ARTIST );
		}

		$results = $this->lyricsApiHandler->getArtist( $artist );
		$this->response->setVal( 'result', $results );
		$this->response->setCacheValidity( self::RESPONSE_CACHE_VALIDITY );
	}

	public function getAlbum() {
		$artist = $this->wg->Request->getVal( 'artist' );
		$album = $this->wg->Request->getVal( 'album' );
	}

	public function getSong() {
		$artist = $this->wg->Request->getVal( 'artist' );
		$album = $this->wg->Request->getVal( 'album' );
		$song = $this->wg->Request->getVal( 'song' );
	}

	public function searchArtist() {
		$query = $this->wg->Request->getVal( 'query' );
	}

	public function searchSong() {
		$query = $this->wg->Request->getVal( 'query' );
	}
	public function searchLyrics() {
		$query = $this->wg->Request->getVal( 'query' );
	}

} 
<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/3/14
 * Time: 1:50 PM
 */


class LyricsApiController extends WikiaController {
	const PARAM_ARTIST = 'artist';
	const PARAM_ALBUM = 'album';
	const PARAM_SONG = 'song';

	const RESPONSE_CACHE_VALIDITY = 86400; // 24h

	private $lyricsApiHandler = null;

	public function __construct() {
		parent::__construct();
		$this->lyricsApiHandler = new MockLyricsApiHandler();
	}

	public function getArtist() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$artist = $this->wg->Request->getVal( self::PARAM_ARTIST );

		if( empty( $artist ) ) {
			throw new InvalidParameterApiException( self::PARAM_ARTIST );
		}

		$results = $this->lyricsApiHandler->getArtist( $artist );
		$this->response->setVal( 'result', $results );
		$this->response->setCacheValidity( self::RESPONSE_CACHE_VALIDITY );
	}

	public function getAlbum() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$artistName = $this->wg->Request->getVal( self::PARAM_ARTIST );
		$albumName = $this->wg->Request->getVal( self::PARAM_ALBUM );

		if( empty( $artistName ) ) {
			throw new InvalidParameterApiException( self::PARAM_ARTIST );
		}

		if( empty( $albumName ) ) {
			throw new InvalidParameterApiException( self::PARAM_ALBUM );
		}

		$album = $this->lyricsApiHandler->getAlbum( $artistName, $albumName );
		$this->response->setVal( 'result', $album );
		$this->response->setCacheValidity( self::RESPONSE_CACHE_VALIDITY );
	}

	public function getSong() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$artistName = $this->wg->Request->getVal( self::PARAM_ARTIST );
		$albumName = $this->wg->Request->getVal( self::PARAM_ALBUM );
		$songName = $this->wg->Request->getVal( self::PARAM_SONG );

		if( empty( $artistName ) ) {
			throw new InvalidParameterApiException( self::PARAM_ARTIST );
		}

		if( empty( $albumName ) ) {
			throw new InvalidParameterApiException( self::PARAM_ALBUM );
		}

		if( empty( $songName ) ) {
			throw new InvalidParameterApiException( self::PARAM_SONG );
		}

		$song = $this->lyricsApiHandler->getSong( $artistName, $albumName, $songName );
		$this->response->setVal( 'result', $song );
		$this->response->setCacheValidity( self::RESPONSE_CACHE_VALIDITY );
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

	public function suggestArtist() {
		$query = $this->wg->Request->getVal( 'query' );
	}

	public function suggestAlbum() {
		$query = $this->wg->Request->getVal( 'query' );
	}

	public function suggestSong() {
		$query = $this->wg->Request->getVal( 'query' );
	}
} 
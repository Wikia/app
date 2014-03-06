<?php
/**
 * Class LyricsApiController
 *
 * @desc Entry point for LyricsAPI
 */
class LyricsApiController extends WikiaController {
	const PARAM_ARTIST = 'artist';
	const PARAM_ALBUM = 'album';
	const PARAM_SONG = 'song';
	const PARAM_QUERY = 'query';

	const RESPONSE_CACHE_VALIDITY = 86400; // 24h

	private $lyricsApiHandler = null;

	public function __construct() {
		parent::__construct();
		$this->lyricsApiHandler = new MockLyricsApiHandler();
	}

	/**
	 * @desc Gets information about given artist
	 *
	 * @requestParam String $artist name of the artist
	 * @response Object $result artists' data
	 *
	 * @throws InvalidParameterApiException
	 */
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

	/**
	 * @desc Gets information about an album of given artist
	 *
	 * @requestParam String $artist artist name
	 * @requestParam String $album album name
	 *
	 * @response Object $result album's data
	 *
	 * @throws InvalidParameterApiException
	 */
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

	/**
	 * @desc Gets information about a song of given artist from given album
	 *
	 * @requestParam String $artist artist's name
	 * @requestParam String $album album's name
	 * @requestParam String $song song's name
	 *
	 * @response Object $result song's data
	 *
	 * @throws InvalidParameterApiException
	 */
	public function getSong() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$artistName = $this->wg->Request->getVal( self::PARAM_ARTIST );
		$albumName = $this->wg->Request->getVal( self::PARAM_ALBUM );
		$songName = $this->wg->Request->getVal( self::PARAM_SONG );

		if( empty( $artistName ) ) {
			throw new InvalidParameterApiException( self::PARAM_ARTIST );
		}

		if( empty( $songName ) ) {
			throw new InvalidParameterApiException( self::PARAM_SONG );
		}

		$song = $this->lyricsApiHandler->getSong( $artistName, $albumName, $songName );
		$this->response->setVal( 'result', $song );
		$this->response->setCacheValidity( self::RESPONSE_CACHE_VALIDITY );
	}

	/**
	 * @desc Searches for an artist
	 *
	 * @requestParam String $query searching phrase
	 *
	 * @response Object $result searching results
	 *
	 * @throws InvalidParameterApiException
	 */
	public function searchArtist() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$query = $this->wg->Request->getVal( self::PARAM_QUERY );

		if( empty( $query ) ) {
			throw new InvalidParameterApiException( self::PARAM_QUERY );
		}

		$artists = $this->lyricsApiHandler->searchArtist( $query );
		$this->response->setVal( 'result', $artists );
		$this->response->setCacheValidity( self::RESPONSE_CACHE_VALIDITY );
	}

	/**
	 * @desc Searches for a song
	 *
	 * @requestParam String $query searching phrase
	 *
	 * @response Object $result searching results
	 *
	 * @throws InvalidParameterApiException
	 */
	public function searchSong() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$query = $this->wg->Request->getVal( self::PARAM_QUERY );

		if( empty( $query ) ) {
			throw new InvalidParameterApiException( self::PARAM_QUERY );
		}

		$songs = $this->lyricsApiHandler->searchSong( $query );
		$this->response->setVal( 'result', $songs );
		$this->response->setCacheValidity( self::RESPONSE_CACHE_VALIDITY );
	}

	/**
	 * @desc Searches for lyrics
	 *
	 * @requestParam String $query searching phrase
	 *
	 * @response Object $result searching results
	 *
	 * @throws InvalidParameterApiException
	 */
	public function searchLyrics() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$query = $this->wg->Request->getVal( self::PARAM_QUERY );

		if( empty( $query ) ) {
			throw new InvalidParameterApiException( self::PARAM_QUERY );
		}

		$lyrics = $this->lyricsApiHandler->searchLyrics( $query );
		$this->response->setVal( 'result', $lyrics );
		$this->response->setCacheValidity( self::RESPONSE_CACHE_VALIDITY );
	}

	/**
	 * @desc Gets suggestion of an artist
	 *
	 * @requestParam String $query searching phrase
	 *
	 * @response Array $result artists names
	 *
	 * @throws InvalidParameterApiException
	 */
	public function suggestArtist() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$query = $this->wg->Request->getVal( self::PARAM_QUERY );

		if( empty( $query ) ) {
			throw new InvalidParameterApiException( self::PARAM_QUERY );
		}

		$artists = $this->lyricsApiHandler->suggestArtist( $query );
		$this->response->setVal( 'result', $artists );
		$this->response->setCacheValidity( self::RESPONSE_CACHE_VALIDITY );
	}

	/**
	 * @desc Gets albums suggestions
	 *
	 * @requestParam String $query searching phrase
	 *
	 * @response Array $result albums names
	 *
	 * @throws InvalidParameterApiException
	 */
	public function suggestAlbum() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$query = $this->wg->Request->getVal( self::PARAM_QUERY );

		if( empty( $query ) ) {
			throw new InvalidParameterApiException( self::PARAM_QUERY );
		}

		$albums = $this->lyricsApiHandler->suggestAlbum( $query );
		$this->response->setVal( 'result', $albums );
		$this->response->setCacheValidity( self::RESPONSE_CACHE_VALIDITY );
	}

	/**
	 * @desc Gets songs suggestions
	 *
	 * @requestParam String $query searching phrase
	 *
	 * @response Array $result songs names
	 *
	 * @throws InvalidParameterApiException
	 */
	public function suggestSong() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$query = $this->wg->Request->getVal( self::PARAM_QUERY );

		if( empty( $query ) ) {
			throw new InvalidParameterApiException( self::PARAM_QUERY );
		}

		$songs = $this->lyricsApiHandler->suggestSong( $query );
		$this->response->setVal( 'result', $songs );
		$this->response->setCacheValidity( self::RESPONSE_CACHE_VALIDITY );
	}

}

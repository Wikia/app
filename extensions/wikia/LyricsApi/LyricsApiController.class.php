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
		global $wgLyricsSolrConfig;

		parent::__construct();

		$config = [
			'adapteroptions' => [
				'host' => $wgLyricsSolrConfig['host'],
				'port' => $wgLyricsSolrConfig['port'],
				'path' => $wgLyricsSolrConfig['path'],
				'core' => $wgLyricsSolrConfig['core'],
			]
		];

		$this->lyricsApiHandler = new SolrLyricsApiHandler( $config );
	}

	private function getData( $params, $method ) {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$results = call_user_func_array( [ $this->lyricsApiHandler, $method ], $params );

		$this->response->setVal( 'result', $results );
		$this->response->setCacheValidity( self::RESPONSE_CACHE_VALIDITY );
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
		$artist = $this->wg->Request->getVal( self::PARAM_ARTIST );

		if( empty( $artist ) ) {
			throw new InvalidParameterApiException( self::PARAM_ARTIST );
		}

		$this->getData( [ $artist ], 'getArtist' );
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
		$artistName = $this->wg->Request->getVal( self::PARAM_ARTIST );
		$albumName = $this->wg->Request->getVal( self::PARAM_ALBUM );

		if( empty( $artistName ) ) {
			throw new InvalidParameterApiException( self::PARAM_ARTIST );
		}

		if( empty( $albumName ) ) {
			throw new InvalidParameterApiException( self::PARAM_ALBUM );
		}

		$this->getData( [ $artistName, $albumName ], 'getAlbum' );
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
		$artistName = $this->wg->Request->getVal( self::PARAM_ARTIST );
		$albumName = $this->wg->Request->getVal( self::PARAM_ALBUM );
		$songName = $this->wg->Request->getVal( self::PARAM_SONG );

		if( empty( $artistName ) ) {
			throw new InvalidParameterApiException( self::PARAM_ARTIST );
		}

		if( empty( $songName ) ) {
			throw new InvalidParameterApiException( self::PARAM_SONG );
		}

		$this->getData( [ $artistName, $albumName, $songName ], 'getSong' );
	}

	/**
	 * @desc Re-used in other public methods functionality to get a query param from the request
	 *
	 * @requestParam String $query searching phrase
	 *
	 * @return String
	 *
	 * @throws InvalidParameterApiException
	 */
	private function getQueryFromRequest() {
		$query = $this->wg->Request->getVal( self::PARAM_QUERY );

		if( empty( $query ) ) {
			throw new InvalidParameterApiException( self::PARAM_QUERY );
		}

		return $query;
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
		$query = $this->getQueryFromRequest();
		$this->getData( [ $query ], 'searchArtist' );
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
		$query = $this->getQueryFromRequest();
		$this->getData( [ $query ], 'searchSong' );
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
		$query = $this->getQueryFromRequest();
		$this->getData( [ $query ], 'searchLyrics' );
	}

}


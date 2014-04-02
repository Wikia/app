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
	const PARAM_LIMIT = 'limit';
	const PARAM_OFFSET = 'offset';

	const SEARCH_RESULTS_DEFAULT_LIMIT = 25;
	const SEARCH_RESULTS_DEFAULT_OFFSET = 0;

	private $lyricsApiHandler = null;

	/**
	 * @desc Constructor, gets the configuration from global $wgLyricsSolariumOptions variable and sets data handler
	 */
	public function __construct() {
		parent::__construct();
		$lyricsApiBase = new LyricsApiBase();
		$this->lyricsApiHandler = new SolrLyricsApiHandler(
			$lyricsApiBase->getConfig()
		);
	}

	/**
	 * @desc Calls methods of data handlers with given params. Sets caching and response format to JSON.
	 *
	 * @param Array $params
	 * @param String $method
	 *
	 * @throws NotFoundApiException
	 */
	private function getData( $params, $method ) {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$results = call_user_func_array( [ $this->lyricsApiHandler, $method ], $params );

		if( is_null( $results ) ) {
			throw new NotFoundApiException( $this->getNotFoundDetails( $method ) );
		}

		$this->response->setVal( 'result', $results );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	/**
	 * @desc Returns proper details message for NotFoundApiException
	 *
	 * @param String $method
	 *
	 * @return string
	 */
	private function getNotFoundDetails( $method ) {
		switch( $method ) {
			case 'getArtist':
				$details = 'Artist not found';
				break;
			case 'getAlbum':
				$details = 'Album not found';
				break;
			case 'getSong':
				$details = 'Song not found';
				break;
			case 'searchArtist':
				$details = 'Could not found artist which match the criteria';
				break;
			case 'searchSong':
				$details = 'Could not found album which match the criteria';
				break;
			case 'searchLyrics':
				$details = 'Could not found song which match the criteria';
				break;
			default:
				$details = 'No results found';
		}

		return $details;
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
	 * @requestParam String $song song's name
	 *
	 * @response Object $result song's data
	 *
	 * @throws InvalidParameterApiException
	 */
	public function getSong() {
		$artistName = $this->wg->Request->getVal( self::PARAM_ARTIST );
		$songName = $this->wg->Request->getVal( self::PARAM_SONG );

		if( empty( $artistName ) ) {
			throw new InvalidParameterApiException( self::PARAM_ARTIST );
		}

		if( empty( $songName ) ) {
			throw new InvalidParameterApiException( self::PARAM_SONG );
		}

		$this->getData( [ $artistName, $songName ], 'getSong' );
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
		list( $limit, $offset ) = $this->getPaginationParamsFromRequest();
		$this->getData( [ $query, $limit, $offset ], 'searchArtist' );
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
		list( $limit, $offset ) = $this->getPaginationParamsFromRequest();
		$this->getData( [ $query, $limit, $offset ], 'searchSong' );
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
		list( $limit, $offset ) = $this->getPaginationParamsFromRequest();
		$this->getData( [ $query, $limit, $offset ], 'searchLyrics' );
	}

	/**
	 * @desc Gets limit and offset from request if they're not passed it returns defaults
	 *
	 * @return array
	 * @throws InvalidParameterApiException
	 */
	private function getPaginationParamsFromRequest() {
		$limit = $this->wg->Request->getInt( self::PARAM_LIMIT, self::SEARCH_RESULTS_DEFAULT_LIMIT );
		$offset = $this->wg->Request->getInt( self::PARAM_OFFSET, self::SEARCH_RESULTS_DEFAULT_OFFSET );

		if( $limit <= 0 ) {
			throw new InvalidParameterApiException( self::PARAM_LIMIT );
		}

		if( $offset < 0 ) {
			throw new InvalidParameterApiException( self::PARAM_OFFSET );
		}

		return [ $limit, $offset ];
	}

}


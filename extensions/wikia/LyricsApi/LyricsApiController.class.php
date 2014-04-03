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
		$this->lyricsApiHandler = new SolrLyricsApiHandler( F::app()->wg->LyricsApiSolrariumConfig );
	}

	/**
	 * @desc Validates fields and executes the provided method
	 *
	 * @param $method - Search method name to be called
	 * @param array $fields = array of required request field names
	 * @param bool $pagination - get pagination values from request
	 * @throws NotFoundApiException
	 * @throws InvalidParameterApiException
	 */
	private function executeSearch($method, Array $fields = [], $pagination = false) {
		$searchParams = new LyricsApiSearchParams();

		// Validate fields
		foreach($fields as $fieldName) {
			$fieldValue = $this->wg->Request->getVal( $fieldName );
			if( empty( $fieldValue ) ) {
				throw new InvalidParameterApiException( $fieldName );
			}
			$searchParams->addField( $fieldName, $fieldValue );
		}

		// Get pagination
		if ( $pagination ) {
			list( $limit, $offset ) = $this->getPaginationParamsFromRequest();
			$searchParams->setLimit( $limit );
			$searchParams->setOffset( $offset );
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$results = $this->lyricsApiHandler->$method( $searchParams );

		// Validate result
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
				$details = 'Could not find artist which match the criteria';
				break;
			case 'searchSong':
				$details = 'Could not find album which match the criteria';
				break;
			case 'searchLyrics':
				$details = 'Could not find song which match the criteria';
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
		$this->executeSearch( 'getArtist', [ self::PARAM_ARTIST ] );
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
		$this->executeSearch( 'getAlbum', [ self::PARAM_ARTIST, self::PARAM_ALBUM ] );
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
		$this->executeSearch( 'getSong', [ self::PARAM_ARTIST, self::PARAM_SONG ] );
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
		$this->executeSearch( 'searchArtist', [ self::PARAM_QUERY ], true );
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
		$this->executeSearch( 'searchSong', [ self::PARAM_QUERY ], true );
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
		$this->executeSearch( 'searchLyrics', [ self::PARAM_QUERY ], true );
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


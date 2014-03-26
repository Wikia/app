<?php

class SolrLyricsApiHandler extends AbstractLyricsApiHandler {
	const IMG_WIDTH_SMALL = 174;
	const IMG_HEIGHT_SMALL = 174;
	const IMG_WIDTH_MEDIUM = 300;
	const IMG_HEIGHT_MEDIUM = 300;
	const IMG_WIDTH_LARGE = 600;
	const IMG_HEIGHT_LARGE = 600;

	const HIGHLIGHT_PREFIX = '<em>';
	const HIGHLIGHT_POSTFIX = '</em>';

	const INDEX_FIELD_NAME_LYRICS = 'lyrics';

	/**
	 * @var Solarium_Client
	 */
	public $client;

	/**
	 * @var Integer
	 */
	public $cityId;

	public function __construct( $config ) {
		$this->cityId = F::app()->wg->CityId;
		$this->client = new Solarium_Client( $config );
	}

	/**
	 * @desc Creates select query on Solr
	 *
	 * @param array $fields
	 * @return Solarium_Query_Select
	 */
	private function newQueryFromSearch( Array $fields ) {
		$query = $this->client->createSelect();
		$queryText = implode( ' AND ', array_keys( $fields ) );
		$query->setQuery( $queryText, array_values( $fields ) );

		return $query;
	}

	/**
	 * @desc Returns first document from results set
	 *
	 * @param Solarium_Result_Select $resultSet
	 * @return null
	 */
	private function getFirstResult( $resultSet ) {
		if ( $resultSet->getNumFound() ) {
			foreach ($resultSet as $document) {
				return $document;
			}
		}
		return null;
	}

	/**
	 * @desc Adds images to an response results
	 *
	 * @param stdClass $obj response results object i.e. $song, $artist, $album
	 * @param String $image image title
	 */
	private function appendImages( $obj, $image ) {
		// Quick fix for wrong data in templates (i.e. metallica.jpg instead of Metallica.jpg)
		$image = ucfirst( $image );
		$obj->small_image = $this->getImage( $image );
		$obj->medium_image = $this->getImage( $image, self::IMG_WIDTH_MEDIUM, self::IMG_HEIGHT_MEDIUM );
		$obj->large_image = $this->getImage( $image, self::IMG_WIDTH_LARGE, self::IMG_HEIGHT_LARGE );
	}

	/**
	 * @desc Uses ImagesService to create an image URL
	 *
	 * @param String $imageTitle
	 * @param int $width optional
	 * @param int $height optional
	 *
	 * @return bool|null|Object|string
	 */
	private function getImage( $imageTitle, $width = self::IMG_WIDTH_SMALL, $height = self::IMG_HEIGHT_SMALL ) {
		return ImagesService::getImageSrcByTitle( $this->cityId, $imageTitle, $width, $height );
	}

	/**
	 * @desc Decodes JSON into array/object
	 *
	 * @param String $text
	 *
	 * @return mixed
	 */
	private function deserialize( $text ) {
		return json_decode( $text );
	}

	/**
	 * @desc Gets albums of an artist for SolrLyricsApiHandler::getArtist() response
	 *
	 * @param String $artistName
	 * @param Array $albums
	 *
	 * @return array
	 */
	private function getAlbums( $artistName, $albums ) {
		$albumsList = [];
		$albums = $this->deserialize( $albums );

		if ( is_array( $albums ) ) {
			foreach ( $albums as $solrAlbum ) {
				$responseAlbum = new stdClass();
				$responseAlbum->name = $solrAlbum->album_name;
				$this->appendImages( $responseAlbum, $solrAlbum->image );

				if ( $solrAlbum->release_date ) {
					$responseAlbum->year = $solrAlbum->release_date;
				}

				$responseAlbum->url = $this->buildUrl( [
					'controller' => self::API_CONTROLLER_NAME,
					'method' => 'getAlbum',
					LyricsApiController::PARAM_ARTIST => $artistName,
					LyricsApiController::PARAM_ALBUM => $responseAlbum->name,
				] );

				$albumsList[] = $responseAlbum;
			}
		}

		return $albumsList;
	}

	/**
	 * @desc Gets songs
	 *
	 * @param String $artistName
	 * @param String $albumName there are songs without albums and that's why we allow here an empty string
	 * @param String $songs
	 *
	 * @return array
	 */
	private function getSongs( $artistName, $albumName = '', $songs ) {
		$songsList = [];
		$songs = $this->deserialize( $songs );

		if ( is_array( $songs ) ) {
			foreach ( $songs as $solrSong ) {
				$responseSong = new stdClass();
				$responseSong->name = $solrSong->song_name;
				if ( isset( $solrSong->id ) ) {
					// Songs without id are only for information
					$responseSong->url = $this->buildUrl( [
						'controller' => self::API_CONTROLLER_NAME,
						'method' => 'getSong',
						LyricsApiController::PARAM_ARTIST => $artistName,
						LyricsApiController::PARAM_ALBUM => $albumName,
						LyricsApiController::PARAM_SONG => $responseSong->name,
					] );
				}
				$songsList[] = $responseSong;
			}
		}

		return $songsList;
	}

	/**
	 * @desc Decorates Solr results with images URLs, albums and songs for an artist
	 *
	 * @param Solarium_Document_ReadOnly $solrAlbum
	 * @return stdClass
	 */
	private function getOutputArtist( $solrAlbum ) {
		$artist = new stdClass();
		$artist->name = $solrAlbum->artist_name;

		if ( $solrAlbum->image ) {
			$this->appendImages( $artist, $solrAlbum->image );
		}

		if ( $solrAlbum->albums ) {
			$artist->albums = $this->getAlbums( $artist->name, $solrAlbum->albums );
		}

		if ( $solrAlbum->songs ) {
		// some artists have songs without albums that's why we have an empty string passed here
			$artist->songs = $this->getSongs( $artist->name, '', $solrAlbum->songs );
		}

		return $artist;
	}

	/**
	 * @desc Gets an artist from Solr index if exists
	 *
	 * @param String $artist
	 *
	 * @return null|stdClass
	 */
	public function getArtist( $artist ) {
		$query = $this->newQueryFromSearch( [
			'type: %1%' => LyricsApiBase::TYPE_ARTIST,
			'artist_name: %P2%' => $artist,
		] );

		$query->setFields( [
			'artist_name',
			'image',
			'albums',
			'songs'
		] );

		$query->setStart( 0 )->setRows( 1 );
		$solrAlbum = $this->getFirstResult( $this->client->select( $query ) );

		if ( is_null( $solrAlbum ) ) {
			return null;
		}

		return $this->getOutputArtist( $solrAlbum );
	}

	/**
	 * @desc Gets an album from Solr index if exists
	 *
	 * @param String $artist
	 * @param String $album
	 *
	 * @return null|stdClass
	 */
	public function getAlbum( $artist, $album ) {
		$query = $this->newQueryFromSearch( [
			'type: %1%' => LyricsApiBase::TYPE_ALBUM,
			'artist_name: %P2%' => $artist,
			'album_name: %P3%' => $album,
		] );

		$query->setFields( [
			'artist_name',
			'album_name',
			'image',
			'genres',
			'length',
			'itunes',
			'release_date',
			'songs'
		] );

		$query->setStart( 0 )->setRows( 1 );
		$queryResult = $this->getFirstResult( $this->client->select( $query ) );

		if ( is_null( $queryResult ) ) {
			return null;
		}

		$album = new stdClass();
		$album->name = $queryResult->album_name;

		if ( $queryResult->image ) {
			$this->appendImages( $album, $queryResult->image );
		}

		if ( $queryResult->genres ) {
			$album->genres = $this->deserialize( $queryResult->genres );
		}

		if ( $queryResult->length ) {
			$album->length = $queryResult->length;
		}

		if ( $queryResult->itunes ) {
			$album->itunes = $queryResult->itunes;
		}

		$album->artist = new stdClass();
		$album->artist->name = $queryResult->artist_name;
		$album->artist->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getArtist',
			LyricsApiController::PARAM_ARTIST => $album->artist->name,
		]);

		if ( $queryResult->songs ) {
			$album->songs = $this->getSongs( $album->artist->name, $album->name, $queryResult->songs );
		}

		return $album;
	}

	/**
	 * @desc Builds API requests URLs, images URLs and whole song object returned in response results
	 *
	 * @param Solarium_Document_ReadOnly $solrSong song object retrieved from solr
	 * @param Solarium_Result_Select_Highlighting_Result $highlights optional Solarium result object with highlighting
	 *
	 * @return stdClass
	 */
	private function getOutputSong( $solrSong, $highlights = null ) {
		$song = new stdClass();
		$song->name = $solrSong->song_name;

		if ( $solrSong->itunes ) {
			$song->itunes = $solrSong->itunes;
		}

		$song->lyrics = $solrSong->lyrics;

		$song->artist = new stdClass();
		$song->artist->name = $solrSong->artist_name;
		$song->artist->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getArtist',
			LyricsApiController::PARAM_ARTIST => $song->artist->name
		] );

		if ( $solrSong->album_id ) {
			$song->album = new stdClass();
			$song->album->name = $solrSong->album_name;
			$song->album->url = $this->buildUrl([
				'controller' => self::API_CONTROLLER_NAME,
				'method' => 'getAlbum',
				LyricsApiController::PARAM_ARTIST => $song->artist->name,
				LyricsApiController::PARAM_ALBUM => $song->album->name
			] );
		}

		if ( $solrSong->image ) {
			$this->appendImages( $song, $solrSong->image );
		}

		if( !is_null( $highlights ) ) {
			$song->hightlights = $highlights->getField( self::INDEX_FIELD_NAME_LYRICS );
		}

		return $song;
	}

	/**
	 * @desc Gets a song from Solr index if exists
	 *
	 * @param String $artist
	 * @param String $album
	 * @param String $song
	 *
	 * @return null|stdClass
	 */
	public function getSong( $artist, $album, $song ) {
		$solrQuery = [
			'type: %1%' => LyricsApiBase::TYPE_SONG,
			'artist_name: %P2%' => $artist,
			'song_name: %P3%' => $song,
		];

		$query = $this->newQueryFromSearch( $solrQuery );
		$query->setFields( [
			'artist_name',
			'album_id',
			'album_name',
			'song_name',
			'image',
			self::INDEX_FIELD_NAME_LYRICS
		] );

		$query->setStart( 0 )->setRows( 1 );
		$solrSong = $this->getFirstResult( $this->client->select( $query ) );

		if ( is_null( $solrSong ) ) {
			return null;
		}

		return $this->getOutputSong( $solrSong );
	}

	/**
	 * @desc Searches for an artist in Solr index
	 *
	 * @param String $query
	 * @param Integer $limit
	 * @param Integer $offset
	 *
	 * @return array|null|stdClass
	 */
	public function searchArtist( $query, $limit, $offset ) {
		$query = $this->newQueryFromSearch( [
			'type: %1%' => LyricsApiBase::TYPE_ARTIST,
			'search_artist_name: %P2%' => $query,
		] );
		$query->setStart( $offset );
		$query->setRows( $limit );

		$solrArtists = $this->client->select( $query );

		if ( $solrArtists->getNumFound() <= 0 ) {
			return null;
		}

		$artists = [];
		foreach ( $solrArtists as $solrArtist ) {
			$artists[] = $this->getOutputArtist( $solrArtist );
		}

		return $artists;
	}

	/**
	 * @desc Searches for a song in Solr index
	 *
	 * @param String $query
	 * @param Integer $limit
	 * @param Integer $offset
	 *
	 * @return array|null|stdClass
	 */
	public function searchSong( $query, $limit, $offset ) {
		$query = $this->newQueryFromSearch( [
			'type: %1%' => LyricsApiBase::TYPE_SONG,
			'search_song_name: %P2%' => $query,
		] );
		$query->setStart( $offset );
		$query->setRows( $limit );

		$solrSongs = $this->client->select( $query );
		if ( $solrSongs->getNumFound() <= 0 ) {
			return null;
		}

		$songs = [];
		foreach ( $solrSongs as $solrSong ) {
			$songs[] = $this->getOutputSong( $solrSong );
		}

		return $songs;
	}

	/**
	 * @desc Searches for a song lyrics in Solr index
	 *
	 * @param String $query
	 * @param Integer $limit
	 * @param Integer $offset
	 *
	 * @return array|null|stdClass
	 */
	public function searchLyrics( $query, $limit, $offset ) {
		$query = $this->newQueryFromSearch( [
			'type: %1%' => LyricsApiBase::TYPE_SONG,
			'lyrics: %P2%' => $query,
		] );
		$query->setStart( $offset );
		$query->setRows( $limit );

		$hl = $query->getHighlighting();
		$hl->setFields( self::INDEX_FIELD_NAME_LYRICS );
		$hl->setSimplePrefix( self::HIGHLIGHT_PREFIX );
		$hl->setSimplePostfix( self::HIGHLIGHT_POSTFIX );

		$solrSongs = $this->client->select( $query );

		if ( $solrSongs->getNumFound() <= 0 ) {
			return null;
		}

		$songs = [];
		$highlighting = $solrSongs->getHighlighting();
		/** @var Solarium_Document_ReadOnly $solrSong */
		foreach ( $solrSongs as $solrSong ) {
			$fields = $solrSong->getFields();
			$songs[] = $this->getOutputSong( $solrSong, $highlighting->getResult( $fields['id'] ) );
		}

		return $songs;
	}

}

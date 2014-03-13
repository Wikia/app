<?php

class SolrLyricsApiHandler extends AbstractLyricsApiHandler {

	/**
	 * @var Solarium_Client
	 */
	var $client;


	// TODO: these must be shared with the maintenance script
	const TYPE_ARTIST = 'artist';
	const TYPE_ALBUM = 'album';
	const TYPE_SONG = 'song';

	public function __construct( $config ) {
		// TODO: Check if connection is ok
		$this->client = new Solarium_Client( $config );
	}

	private function newQueryFromSearch( Array $fields ) {
		$query = $this->client->createSelect();
		$queryText = implode(' AND ', array_keys( $fields ) );
		$query->setQuery( $queryText, array_values($fields) );
		return $query;
	}

	private function getFirstResult( $resultSet ) {
		if ( $resultSet->getNumFound() ) {
			foreach ($resultSet as $document) {
				return $document;
			}
		}
		return null;
	}

	private function getImage( $imageTitle, $thumbnailConfig = [] ) {
		// TODO: Do me
		return $imageTitle;
	}

	private function deSerialize ( $text ) {
		return json_decode( $text );
	}

	private function getAlbums( $artistName, $albums ) {
		$albumsList = [];
		$albums = $this->deSerialize( $albums );
		if ( is_array( $albums ) ) {
			foreach ( $albums as $solrAlbum ) {
				$responseAlbum = new stdClass();
				$responseAlbum->name = $solrAlbum->album_name;
				$responseAlbum->image = $this->getImage( $solrAlbum->image );
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

	private function getSongs( $artistName, $albumName, $songs ) {
		$songsList = [];
		$songs = $this->deSerialize( $songs );
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

	public function getArtist( $artist ) {
		$query = $this->newQueryFromSearch( [
			'type: %1%' => self::TYPE_ARTIST,
			'artist_name: %P2%' => $artist,
		] );
		$query->setFields( [
			'artist_name',
			'image',
			'albums',
			'songs'
		] );
		$query->setStart( 0 )->setRows( 1 );

		$queryResult = $this->getFirstResult( $this->client->select( $query ) );
		if ( is_null( $queryResult ) ) {
			return null;
		}
		$artist = new stdClass();
		$artist->name = $queryResult->artist_name;
		if ( $queryResult->image ) {
			$artist->image = $this->getImage( $queryResult->image );
		}
		if ( $queryResult->albums ) {
			$artist->albums = $this->getAlbums( $artist->name, $queryResult->albums );
		}
		if ( $queryResult->songs ) {
			$artist->songs = $this->getSongs( $artist->name, '', $queryResult->albums );
		}
		return $artist;
	}

	public function getAlbum( $artist, $album ) {
		$query = $this->newQueryFromSearch( [
			'type: %1%' => self::TYPE_ARTIST,
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
			$album->image = $this->getImage( $queryResult->image );
		}
		if ( $queryResult->genres ) {
			$album->genres = $this->deSerialize( $queryResult->genres );
		}
		if ( $queryResult->length ) {
			$album->length = $queryResult->length;
		}
		if ( $queryResult->itunes ) {
			$album->itunes = $queryResult->itunes;
		}
		$album->artist = new stdClass();
		$album->artist->name = $album->artist_name;
		$album->artist->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getArtist',
			LyricsApiController::PARAM_ARTIST => $album->artist->name,
		]);
		if ( $queryResult->songs ) {
			$album->songs = $this->getSongs( $album->artist_name, $album->name, $queryResult->songs );
		}
		return $album;
	}

	public function getSong( $artist, $album, $song ) {
		$query = $this->newQueryFromSearch( [
			'type: %1%' => self::TYPE_SONG,
			'artist_name: %P2%' => $artist,
			'album_name: %P3%' => $album,
			'song_name: %P4%' => $song,
		] );
		$query->setFields( [
			'artist_name',
			'album_name',
			'song_name',
			'image',
			'lyrics'
		] );
		$query->setStart( 0 )->setRows( 1 );

		$queryResult = $this->getFirstResult( $this->client->select( $query ) );
		if ( is_null( $queryResult ) ) {
			return null;
		}
		$song = new stdClass();
		$song->name = $queryResult->song_name;
		if ( $queryResult->itunes ) {
			$song->itunes = $queryResult->itunes;
		}
		$song->lyrics = $queryResult->lyrics;

		$song->artist = new stdClass();
		$song->artist->name = $queryResult->artist_name;
		$song->artist->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getArtist',
			LyricsApiController::PARAM_ARTIST => $song->artist->name
		] );

		$song->album = new stdClass();
		$song->album->name = $queryResult->album_name;
		$song->album->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getArtist',
			LyricsApiController::PARAM_ARTIST => $song->album->name
		] );
		if ( $queryResult->image ) {
			$song->album->image = $this->getImage( $queryResult->image );
		}
		return $album;
	}

	public function searchArtist( $query ) {
		// TODO: Implement searchArtist() method.
	}

	public function searchSong( $query ) {
		// TODO: Implement searchSong() method.
	}

	public function searchLyrics( $query ) {
		// TODO: Implement searchLyrics() method.
	}
}
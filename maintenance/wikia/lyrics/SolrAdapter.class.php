<?php

/**
 * Class SolrAdapter
 *
 * @desc Solr database adapter for Lyrics API scraper
 */
class SolrAdapter {
	const MAX_QUEUE_LENGTH = 50;

	private $client;
	private $queue = [];

	/**
	 * @var Solarium_Query_Update
	 */
	private $update;

	/**
	 * @desc Constructor
	 *
	 * @param $config - Solarium client config array
	 */
	public function __construct( $config ) {
		$this->client = new Solarium_Client( $config );
		$this->update = $this->client->createUpdate();
		$this->timer = microtime( true );
	}

	/**
	 * @desc Destructor
	 */
	public function __destruct() {
		// Flush the queue on destroy
		$this->commit();
	}

	/**
	 * Commit the documents in the current update queue
	 *
	 * @return null|Solarium_Result_Update
	 */
	public function commit() {
		$result = null;
		if ( $this->queue ) {
			printf('COMMIT %f s for %d commits' . PHP_EOL, ( microtime( true ) - $this->timer ), count( $this->queue ) );
			$this->timer = microtime( true );
			$update = $this->client->createUpdate();
			$update->addDocuments( $this->queue );
			$update->addCommit();
			$result = $this->client->update( $update );
			$this->update = $this->client->createUpdate();
			$this->queue = [];
		}
		return $result;
	}

	/**
	 * @desc Commit the queue if number of documents = MAX_QUEUE_LENGTH
	 */
	private function autoCommit() {
		if ( count( $this->queue ) >= self::MAX_QUEUE_LENGTH ) {
			$this->commit();
		}
	}

	/**
	 * @desc Add document to the queue
	 *
	 * @param Solarium_Document_ReadWrite $doc
	 */
	private function add( Solarium_Document_ReadWrite $doc ) {
		$this->queue[] = $doc;
		$this->autoCommit();
	}

	/**
	 * @desc Create new update document
	 *
	 * @param $data
	 * @return Solarium_Document_ReadWrite
	 */
	private function newDocFromData( $data ) {
		$doc = $this->update->createDocument();
		foreach ( $data as $key => $value ) {
			$doc->{$key} = $value;
		}
		return $doc;
	}

	/**
	 * @desc Encode metadata
	 *
	 * @param array $metaData
	 * @return mixed|string
	 */
	private function encodeMeta( Array $metaData ) {
		return json_encode( $metaData );
	}

	/**
	 * @desc Generate meta data for album
	 *
	 * @param array $album - Album data array
	 * @return array|null
	 */
	public function getAlbumMetaData( Array $album ) {
		$albumData =  [
			'album_id' => $album['id'],
			'album_name' => $album['album_name'],
		];
		if ( isset($album['image']) ) {
			$albumData['image'] = $album['image'];
		}
		if ( isset($album['release_date']) ) {
			$albumData['release_date'] = $album['release_date'];
		}
		return $albumData;
	}

	/**
	 * @desc Generate meta data for song
	 *
	 * @param array $song - Song data array
	 * @return array
	 */
	public function getSongMetaData( Array $song ) {
		$result = [
			'song_name' => $song['song_name'],
		];

		if ( isset( $song['id'] ) ) {
			$result['id'] = $song['id'];
		}

		return $result;
	}

	/**
	 * @desc Generate meta data for albums and songs not in albums
	 *
	 * @param array $albums - array with albums data
	 * @return array
	 */
	public function getAlbumsMetaData( Array $albums ) {
		$result = [
			'albums' => [],
			'songs' => []
		];

		foreach ( $albums as $album ) {
			if ( isset( $album['id'] ) ) {
				$result['albums'][] = $this->getAlbumMetaData( $album );
			} else {
				foreach ( $album['songs'] as $song ) {
					$result['songs'][] = $this->getSongMetaData( $song );
				}
			}
		}

		return $result;
	}

	/**
	 * @desc Generate meta data for songs
	 *
	 * @param array $songs
	 * @return array
	 */
	public function getSongsMetaData( Array $songs ) {
		$result = [];
		foreach ( $songs as $song ) {
			$result[] = $this->getSongMetaData( $song );
		}
		return $result;
	}

	/**
	 * @desc Save artist document to Solr
	 *
	 * @param array $artist
	 * @param array $albums
	 */
	public function saveArtist( Array $artist, Array $albums ) {
		// Add albums data
		$albumsMetaData = $this->getAlbumsMetaData( $albums );

		if ( !empty( $albumsMetaData['albums'] ) ) {
			$artist['albums'] = $this->encodeMeta( $albumsMetaData['albums'] );
		}
		if ( !empty( $albumsMetaData['songs'] ) ) {
			$artist['songs'] = $this->encodeMeta( $albumsMetaData['songs'] );
		}
		$artist['type'] = LyricsUtils::TYPE_ARTIST;

		if ( isset( $artist['genres'] ) && $artist['genres'] ) {
			$artist['genres'] = json_encode( array_values( $artist['genres'] ) );
		}

		$doc = $this->newDocFromData( $artist );

		$this->add( $doc );
	}

	/**
	 * @desc Save album document to Solr
	 *
	 * @param array $artist
	 * @param array $album
	 * @param array $songs
	 */
	public function saveAlbum( Array $artist, Array $album, Array $songs ) {
		// Add artist meta data
		$album['artist_name'] = $artist['artist_name'];
		$album['artist_name_lc_s'] = $artist['artist_name_lc_s'];
		$album['artist_id'] = $artist['id'];
		
		// Add songs meta data
		$album['songs'] = $this->encodeMeta( $this->getSongsMetaData( $songs ) );
		
		if ( isset( $album['genres'] ) && $album['genres'] ) {
			$album['genres'] = json_encode( array_values( $album['genres'] ) );
		}
		$album['type'] = LyricsUtils::TYPE_ALBUM;
		$doc = $this->newDocFromData( $album );
		$this->add( $doc );
	}

	/**
	 * @desc Save song document to Solr
	 *
	 * @param array $artist
	 * @param array $album
	 * @param array $song
	 */
	public function saveSong( Array $artist, Array $album, Array $song ) {
		$song['artist_id'] = $artist['id'];
		$song['artist_name'] = $artist['artist_name'];
		$song['artist_name_lc_s'] = $artist['artist_name_lc_s'];
		
		if ( isset( $album['id'] ) ) {
			$song['album_name'] = $album['album_name'];
			$song['album_id'] = $album['id'];
			if ( isset( $album['image'] ) ) {
				$song['image'] = $album['image'];
			}
		}
		$song['type'] = LyricsUtils::TYPE_SONG;
		$doc = $this->newDocFromData( $song );
		$this->add( $doc );
	}

	/**
	 * @desc Deletes documents from the Solr; the documents should have timestamp lower than given $datetime parameter
	 * and should belong to one of the artists
	 *
	 * @param Array $artists
	 * @param String $datetime
	 * @return Solarium_Result_Update
	 */
	public function delDocsByArtistsAndDate( $artists, $datetime ) {
		$placeholders = [];
		$artistsCount = count( $artists );
		for( $i = 1; $i <= $artistsCount; $i++ ) {
			$placeholders[] = 'artist_name: %P' . $i . '%';
		}

		$query = $this->client->createSelect();
		$queryText = 'timestamp:[* TO ' . $query->getHelper()->formatDate( $datetime ) . '] AND (';
		$queryText .= implode( ' OR ', $placeholders );
		$queryText .= ') ';

		$query->setQuery( $queryText, $artists );
		/** @var Solarium_Query_Update $update */
		$update = $this->client->createUpdate();
		$update->addDeleteQuery( $query );
		$update->addCommit();
		return $this->client->update( $update );
	}

}

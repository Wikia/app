<?php

require_once( dirname(__FILE__) . '/../../../lib/vendor/Solarium/Autoloader.php' );


/**
 * Interface DataBaseAdapter
 *
 * Database connection interfaca
 */
interface DataBaseAdapter {

	function saveArtist( Array $artist, Array $albums);
	function saveAlbum( Array $artist, Array $album, Array $songs);
	function saveSong( Array $artist, Array $album, Array $song);
}


class MockAdapter implements DataBaseAdapter {

	function saveArtist( Array $artist, Array $albums) {
		echo 'ARTIST: ' . json_encode( [$artist, $albums], JSON_PRETTY_PRINT ) . PHP_EOL;
	}

	function saveAlbum( Array $artist, Array $album, Array $songs) {
		echo 'ALBUM: ' .json_encode( [$artist, $album, $songs], JSON_PRETTY_PRINT ) . PHP_EOL;
	}

	function saveSong( Array $artist, Array $album, Array $song) {
		echo 'SONG: ' .json_encode( [$artist, $album, $song], JSON_PRETTY_PRINT ) . PHP_EOL;
	}
}

/**
 * Class SolrAdapter
 *
 * Solr database adapter for Lyrics API scraper
 *
 */
class SolrAdapter implements DataBaseAdapter {

	const MAX_QUEUE_LENGTH = 50;
	const TYPE_ARTIST = 'artist';
	const TYPE_ALBUM = 'album';
	const TYPE_SONG = 'song';

	private $client;
	private $queue = [];

	/**
	 * @var Solarium_Query_Update
	 */
	private $update;

	/**
	 * Constructor
	 *
	 * @param $config - Solarium client config array
	 */
	function __construct( $config ) {
		$this->client = new Solarium_Client( $config );
		$this->update = $this->client->createUpdate();
		$this->timer = microtime( true );
	}

	/**
	 * Destructor
	 */
	function __destruct() {
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
	 * Commit the queue if number of documents = MAX_QUEUE_LENGTH
	 */
	private function autoCommit() {
		if ( count( $this->queue ) >= self::MAX_QUEUE_LENGTH ) {
			$this->commit();
		}
	}

	/**
	 * Add document to the queue
	 *
	 * @param Solarium_Document_ReadWrite $doc
	 */
	private function add( Solarium_Document_ReadWrite $doc ) {
		$this->queue[] = $doc;
		$this->autoCommit();
	}

	/**
	 * Create new solr doc from data array
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
	 * Encode metadata
	 *
	 * @param array $metaData
	 * @return mixed|string
	 */
	private function encodeMeta( Array $metaData ) {
		return json_encode( $metaData );
	}

	/**
	 * Generate meta data for album
	 *
	 * @param array $album - Album data array
	 * @return array|null
	 */
	function getAlbumMetaData( Array $album ) {
		if ( isset( $album['id'] ) ) {
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
		return null;
	}

	/**
	 * Generate meta data for song
	 *
	 * @param array $song - Song data array
	 * @return array
	 */
	function getSongMetaData( Array $song ) {
		$result = [
			'name' => $song['song_name'],
		];
		if ( isset( $song['id'] ) ) {
			$result['id'] = $song['id'];
		}
		return $result;
	}

	/**
	 * Generate meta data for albums
	 *
	 * @param array $albums - array with albums data
	 * @return array
	 */
	function getAlbumsMetaData( Array $albums ) {
		$result = [];
		foreach ( $albums as $album ) {
			$album = $this->getAlbumMetaData( $album );
			if ( $album ) {
				$result[] = $album;
			}
		}
		return $result;
	}

	/**
	 * Generate meta data for songs
	 *
	 * @param array $songs
	 * @return array
	 */
	function getSongsMetaData( Array $songs ) {
		$result = [];
		foreach ( $songs as $song ) {
			$result[] = $this->getSongMetaData( $song );
		}
		return $result;
	}

	/**
	 * Set genres data to data element
	 *
	 * @param $element
	 */
	function setGenres( &$element ) {
		if ( isset( $element['genres'] ) ) {
			if ( !is_array( $element['genres'] ) ) {
				$element['genres'] = [$element['genres']];
			}
			$element['genres'] = json_encode( array_values( $element['genres'] ) );
		}
	}


	/**
	 * Save artist document to Solr
	 *
	 * @param array $artist
	 * @param array $albums
	 */
	function saveArtist( Array $artist, Array $albums ) {
		// Add albums data
		$artist['albums'] = $this->encodeMeta( $this->getAlbumsMetaData( $albums ) );
		$artist['type'] = self::TYPE_ARTIST;
		$this->setGenres( $artist );
		$doc = $this->newDocFromData( $artist );
		$this->add( $doc );
	}

	/**
	 * Save album document to Solr
	 *
	 * @param array $artist
	 * @param array $album
	 * @param array $songs
	 */
	function saveAlbum( Array $artist, Array $album, Array $songs ) {
		// Non album
		if ( !isset($album['id'] ) ) {
			return;
		}
		// Add artist meta data
		$album['artist_name'] = $artist['artist_name'];
		$album['artist_id'] = $artist['id'];
		// Add songs meta data
		$album['songs'] = $this->encodeMeta( $this->getSongsMetaData( $songs ) );
		$this->setGenres( $album );
		$album['type'] = self::TYPE_ALBUM;
		$doc = $this->newDocFromData( $album );
		$this->add( $doc );
	}

	/**
	 * Save song document to Solr
	 *
	 * @param array $artist
	 * @param array $album
	 * @param array $song
	 */
	function saveSong( Array $artist, Array $album, Array $song ) {
		// Non lyrics song
		if ( !isset( $song['id'] ) ) {
			return;
		}
		$song['artist_id'] = $artist['id'];
		$song['artist_name'] = $artist['artist_name'];
		if ( isset( $album['id'] ) ) {
			$song['album_name'] = $album['album_name'];
			$song['album_id'] = $album['id'];
			if ( isset( $album['image'] ) ) {
				$song['image'] = $album['image'];
			}
		}
		$this->setGenres( $song );
		$song['type'] = self::TYPE_SONG;
		$doc = $this->newDocFromData( $song );
		$this->add( $doc );
	}
}

/**
 * Create new DatabaseAdapter
 *
 * @param $adapterType - Type of adapter to create
 * @param $config - configuration for selected adapter
 * @return DataBaseAdapter
 */
function newDatabaseAdapter( $adapterType, $config ) {
	switch ( $adapterType ) {
		case 'solr':
			return new SolrAdapter( $config );
			break;
		default :
			return new MockAdapter( $config );
	}
}
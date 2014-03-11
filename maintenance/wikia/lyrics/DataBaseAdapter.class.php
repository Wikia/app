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

	const MAX_QUEUE_LENGTH = 10;
	const TYPE_ARTIST = 1;
	const TYPE_ALBUM = 2;
	const TYPE_SONG = 3;

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
	}

	/**
	 * Destructor
	 */
	function __destruct() {
		// Flush the queue on destroy
		$this->commit();
	}

	/**
	 * Generate key based on the provided keys
	 *
	 * @param array $fields
	 * @return string
	 */
	private function generateKey( Array $fields ) {
		return implode( '~', $fields );
	}

	/**
	 * Commit the documents in the current update queue
	 *
	 * @return null|Solarium_Result_Update
	 */
	public function commit() {
		$result = null;
		if ( $this->queue ) {
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
		if ( count( $this->queue ) == self::MAX_QUEUE_LENGTH ) {
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

	function getAlbumMetaData( Array $album ) {
		if ( isset( $album['id'] ) ) {
			return [
				'id' => $album['id'],
				'album_name' => $album['album_name'],
				'image' => $album['image'],
				'release_date' => $album['release_date'],
				'available' => $album['available'],
			];
		}
		return null;
	}

	function getArtistMetaData( Array $artist ) {
		$result = [
			'id' => $artist['id'],
			'name' => $artist['artist_name'],
		];
		if ( isset( $artist['image'] ) ) {
			$result['image'] = $artist['image'];
		}
		return $result;
	}

	function getSongMetaData( Array $song ) {
		$result = [
			'name' => $song['song_name'],
		];
		if ( isset( $song['id'] ) ) {
			$result['id'] = $song['id'];
		}
		return $result;
	}

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

	function getSongsMetaData( Array $songs ) {
		$result = [];
		foreach ( $songs as $song ) {
			$song = $this->getSongMetaData( $song );
			if ( $song ) {
				$result[] = $song;
			}
		}
		return $result;
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
		$album['artist'] = $this->encodeMeta( $this->getArtistMetaData( $artist ) );
		// Add songs meta data
		$album['songs'] = $this->encodeMeta( $this->getSongsMetaData( $songs ) );

		$album['artist_id'] = $artist['id'];
		$album['artist_name'] = $artist['artist_name'];

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
		// Non song
		if ( !isset( $song['id'] ) ) {
			return;
		}
		$song['artist'] = $this->encodeMeta( $this->getArtistMetaData( $artist ) );
		$albumMeta = $this->getAlbumMetaData( $album );
		if ( !is_null( $albumMeta ) ) {
			$song['album'] = $albumMeta;
		}
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
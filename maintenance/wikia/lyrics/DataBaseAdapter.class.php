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

	public function saveArtist( Array $artist, Array $albums) {
		echo 'ARTIST: ' . json_encode( [$artist, $albums], JSON_PRETTY_PRINT ) . PHP_EOL;
	}

	public function saveAlbum( Array $artist, Array $album, Array $songs) {
		echo 'ALBUM: ' .json_encode( [$artist, $album, $songs], JSON_PRETTY_PRINT ) . PHP_EOL;
	}

	public function saveSong( Array $artist, Array $album, Array $song) {
		echo 'SONG: ' .json_encode( [$artist, $album, $song], JSON_PRETTY_PRINT ) . PHP_EOL;
	}

}

/**
 * Class SolrAdapter
 *
 * @desc Solr database adapter for Lyrics API scraper
 */
class SolrAdapter implements DataBaseAdapter {

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
		$artist['albums'] = $this->encodeMeta( $this->getAlbumsMetaData( $albums ) );
		$artist['type'] = LyricsApiBase::TYPE_ARTIST;
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
		$album['artist_id'] = $artist['id'];
		
		// Add songs meta data
		$album['songs'] = $this->encodeMeta( $this->getSongsMetaData( $songs ) );
		
		if ( isset( $album['genres'] ) && $album['genres'] ) {
			$album['genres'] = json_encode( array_values( $album['genres'] ) );
		}
		$album['type'] = LyricsApiBase::TYPE_ALBUM;
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
		
		if ( isset( $album['id'] ) ) {
			$song['album_name'] = $album['album_name'];
			$song['album_id'] = $album['id'];
			if ( isset( $album['image'] ) ) {
				$song['image'] = $album['image'];
			}
		}
		$song['type'] = LyricsApiBase::TYPE_SONG;
		$doc = $this->newDocFromData( $song );
		$this->add( $doc );
	}
}

/**
 * @desc Create new DatabaseAdapter
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

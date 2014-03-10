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
	}

	/**
	 * Create new update document
	 *
	 * @return Solarium_Document_ReadWrite
	 */
	private function newDoc() {
		return $this->update->createDocument();
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
	 * Save artist document to Solr
	 *
	 * @param array $artist
	 * @param array $albums
	 */
	function saveArtist( Array $artist, Array $albums ) {
		$meta = [
			'albums' => [],
			'songs' => [],
		];
		if (
			isset( $artist['image'] ) &&
			!empty( $artist['image'] )
		) {
			$meta['image'] = $artist['image'];
		}
		foreach ( $albums as $album ) {
			if ( empty( $album['article_id'] ) ) {
				foreach ( $album['songs'] as $song ) {
					$meta['songs'][] = [
						'name' => $song['name'],
						'available' => $song['available'],
					];
				}
			} else {
				$meta['albums'][] = [
					'name' => $album['name'],
					'image' => $album['image'],
					'year' => $album['year'],
					'available' => $album['available'],
				];
			}
		}
		$doc = $this->newDoc();
		$doc->id = $this->generateKey( [$artist['name']] );
		$doc->name = $artist['name'];
		$doc->meta = $this->encodeMeta( $meta );
		$doc->type = self::TYPE_ARTIST;
		$doc->article_id = $artist['article_id'];
		$this->add( $doc );
		$this->autoCommit();
	}

	/**
	 * Save album document to Solr
	 *
	 * @param array $artist
	 * @param array $album
	 * @param array $songs
	 */
	function saveAlbum( Array $artist, Array $album, Array $songs) {
		if ( empty ( $album['article_id'] ) ) {
			// Don't create meta albums like "Other songs"
			return;
		}
		$meta = [
			'image' => $album['image'],
			'year' => $album['year'],
			'length' => $album['length'],
			'genres' => $album['genres'],
			'itunes' => $album['itunes'],
			'artist' => [
				'name' => $artist['name'],
				'image' => $artist['image'],
			],
			'songs' => []
		];

		foreach ( $songs as $song ) {
			$meta['songs'][] = [
				'name' => $song['name'],
				'number' => $song['number'],
				'available' => $song['available'],
			];
		}
		$doc = $this->newDoc();
		$doc->id = $this->generateKey( [$artist['name'], $album['name']] );
		$doc->name = $album['name'];
		$doc->meta = $this->encodeMeta( $meta );
		$doc->type = self::TYPE_ALBUM;
		$doc->article_id = $album['article_id'];
		$this->add( $doc );
		$this->autoCommit();
	}

	/**
	 * Save song document to Solr
	 *
	 * @param array $artist
	 * @param array $album
	 * @param array $song
	 */
	function saveSong( Array $artist, Array $album, Array $song) {
		$meta = [
			'itunes' => $song['itunes'],
			'artist' => [
				'name' => $artist['name'],
				'image' => $artist['image'],
			],
		];

		if ( $album['available'] ) {
			$meta['album'] = [
				'name' => $album['name'],
				'image' => $album['image'],
			];
			$key = $this->generateKey( [
				$artist['name'],
				$album['name'],
				$song['name'],
			] );
		} else {
			$key = $this->generateKey( [
				$artist['name'],
				'',
				$song['name'],
			] );
		}
		$doc = $this->newDoc();
		$doc->id = $key;
		$doc->name = $song['name'];
		$doc->meta = $this->encodeMeta( $meta );
		$doc->content = $song['lyrics'];
		$doc->type = self::TYPE_SONG;
		$doc->article_id = $song['article_id'];
		$this->add( $doc );
		$this->autoCommit();
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
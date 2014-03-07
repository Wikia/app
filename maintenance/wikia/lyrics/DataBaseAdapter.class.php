<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/4/14
 * Time: 11:31 AM
 */

require_once( dirname(__FILE__) . '/../../../lib/vendor/Solarium/Autoloader.php' );


abstract class DataBaseAdapter {

	abstract function saveArtist($artist, $albums);
	abstract function saveAlbum($artist, $album, $songs);
	abstract function saveSong($artist, $album, $song);

}

class MockAdapter extends DataBaseAdapter {

	function saveArtist($artist, $albums) {
		echo 'ARTIST: ' . json_encode( [$artist, $albums], JSON_PRETTY_PRINT ) . PHP_EOL;
	}

	function saveAlbum($artist, $album, $songs) {
		echo 'ALBUM: ' .json_encode( [$artist, $album, $songs], JSON_PRETTY_PRINT ) . PHP_EOL;
	}

	function saveSong($artist, $album, $song) {
		echo 'SONG: ' .json_encode( [$artist, $album, $song], JSON_PRETTY_PRINT ) . PHP_EOL;
	}
}


// TODO: BATCH FEED THE DATA
class SolrAdapter extends DataBaseAdapter {

	private $client;

	function __construct( $config ) {
		$this->client = new Solarium_Client( $config );
	}

	private function generateKey( $fields ) {
		return implode( '~', $fields );
	}

	function saveArtist( $artist, $albums ) {
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
		$update = $this->client->createUpdate();
		$doc = $update->createDocument();
		$doc->id = $this->generateKey( [$artist['name']] );
		$doc->name = $artist['name'];
		$doc->meta = json_encode( $meta );
		$doc->type = 1;
		$doc->article_id = $artist['article_id'];
		$update->addDocuments( array( $doc ) );
		$update->addCommit();
		return $this->client->update( $update );
	}

	function saveAlbum($artist, $album, $songs) {
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

		$update = $this->client->createUpdate();
		$doc = $update->createDocument();
		$doc->id = $this->generateKey( [$artist['name'], $album['name']] );
		$doc->name = $album['name'];
		$doc->meta = json_encode( $meta );
		$doc->type = 2;
		$doc->article_id = $album['article_id'];
		$update->addDocuments( array( $doc ) );
		$update->addCommit();
		return $this->client->update( $update );
	}

	function saveSong($artist, $album, $song) {
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

		$update = $this->client->createUpdate();
		$doc = $update->createDocument();
		$doc->id = $key;
		$doc->name = $song['name'];
		$doc->meta = json_encode( $meta );
		$doc->content = $song['lyrics'];
		$doc->type = 3;
		$doc->article_id = $song['article_id'];
		$update->addDocuments( array( $doc ) );
		$update->addCommit();
		return $this->client->update( $update );
	}

}


function newDatabaseAdapter( $adapterType, $config ) {
	switch ( $adapterType ) {
		case 'solr':
			return new SolrAdapter( $config );
			break;
		default :
			return new MockAdapter( $config );
	}
}
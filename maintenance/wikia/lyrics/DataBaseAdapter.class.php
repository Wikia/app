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

	function saveArtist($artist, $albums) { echo 'R'; }
	function saveAlbum($artist, $album, $songs) { echo 'L'; }
	function saveSong($artist, $album, $song) { echo 'S'; }
}

class SolrAdapter extends DataBaseAdapter {

	private $client;

	function __construct( $config ) {
		$this->client = new Solarium_Client( $config );
	}

	private function generateKey( $fields ) {
		return implode( '|#|', $fields );
	}

	function saveArtist( $artist, $albums ) {
		$meta = [
			'albums' => []
		];
		if (
			isset( $artist['image'] ) &&
			!empty( $artist['image'] )
		) {
			$meta['image'] = $artist['image'];
		}
		foreach ( $albums as $album ) {
			$meta['albums'][] = [
				'name' => $album['name'],
				'image' => $album['image'],
				'year' => $album['year'],
			];
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
			'album' => [
				'name' => $album['name'],
				'image' => $album['image'],
			]
		];

		$update = $this->client->createUpdate();
		$doc = $update->createDocument();
		$doc->id = $this->generateKey( [
			$artist['name'],
			$album['name'],
			$song['name'],
		] );
		$doc->name = $album['name'];
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
<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/3/14
 * Time: 2:11 PM
 */

class MockLyricsApiHandler extends AbstractLyricsApiHandler {
	const API_ENTRY_POINT = 'wikia.php';

	function buildUrl( $params ) {
		global $wgServer;
		return implode('',
			[
				$wgServer,
				'/',
				self::API_ENTRY_POINT,
				'?',
				http_build_query( $params )
			]);
	}

	public function getArtist( $artist ) {
		global $wgServer;

		$result = new stdClass();
		$result->name = $artist;
		$result->image = 'http://placekitten.com/' . rand(128, 1024) . '/' . rand(128, 1024) . '/';

		$album1 = new stdClass();
		$album1->name = 'Album #1';
		$album1->image = 'http://placekitten.com/' . rand(128, 1024) . '/' . rand(128, 1024) . '/';
		$album1->year = 2001;
		$album1->url = sprintf( '%s/%s?controller=LyricsApi&method=getAlbum&artist=%s&album=%s', $wgServer, self::API_ENTRY_POINT, urlencode( $artist ), urlencode( $album1->name ) );

		$album2 = new stdClass();
		$album2->name = 'Album #2';
		$album2->image = 'http://placekitten.com/' . rand(128, 1024) . '/' . rand(128, 1024) . '/';
		$album2->year = 2011;
		$album2->url = sprintf( '%s/%s?controller=LyricsApi&method=getAlbum&artist=%s&album=%s', $wgServer, self::API_ENTRY_POINT, urlencode( $artist ), urlencode( $album2->name ) );

		$result->albums = [
			$album2,
			$album1
		];

		return $result;
	}

	public function getAlbum( $artistName, $albumName ) {
		$album = new StdClass();

		$album->name = $albumName;
		$album->image = $albumName . '.jpg';
		$album->year = '2000';
		$album->length = '6:66';
		$album->genres = ['Hard', 'Heavy'];

		$artist = new StdClass();
		$artist->name = $artistName;
		$artist->image = $artistName . '.jpg';
		$artist->url = $this->buildUrl([
			'controller' => 'LyricsApiController',
			'method' => 'getArtist',
			LyricsApiController::PARAM_ARTIST => $artistName
		]);
		$artist->itunes = 'ARTIST';
		$album->artist = $artist;

		$album->songs = [];
		$song = new StdClass();
		$song->name =  $albumName . ' song 1';
		$song->url = $this->buildUrl([
			'controller' => 'LyricsApiController',
			'method' => 'getSong',
			LyricsApiController::PARAM_ARTIST => $artistName,
			LyricsApiController::PARAM_ALBUM => $albumName,
			LyricsApiController::PARAM_SONG => $song->name
		]);
		$album->songs[] = $song;

		$song = new StdClass();
		$song->name =  $albumName . ' song 2';
		$song->url = $this->buildUrl([
			'controller' => 'LyricsApiController',
			'method' => 'getSong',
			'artist' => $artistName,
			'album' => $albumName,
			'song' => $song->name
		]);
		$album->songs[] = $song;
		return $album;
	}

	public function getSong( $artist, $album, $song ) {}
	public function searchArtist( $query ) {}
	public function searchSong( $query ) {}
	public function searchLyrics( $query ) {}

} 
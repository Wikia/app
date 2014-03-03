<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/3/14
 * Time: 2:11 PM
 */

class MockLyricsApiHandler extends AbstractLyricsApiHandler {
	const API_ENTRY_POINT = 'wikia.php';
	const API_CONTROLLER_NAME = 'LyricsApi';

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

	function getImage( $image ) {
		return 'http://placekitten.com/' . rand(128, 1024) . '/' . rand(128, 1024) . '/';
	}

	public function getArtist( $artist ) {
		global $wgServer;

		$result = new stdClass();
		$result->name = $artist;
		$result->image = $this->getMockedImgUrl();

		$album1 = new stdClass();
		$album1->name = 'Album #1';
		$album1->image = $this->getMockedImgUrl();
		$album1->year = 2001;
		$album1->url = sprintf( '%s/%s?controller=LyricsApi&method=getAlbum&artist=%s&album=%s', $wgServer, self::API_ENTRY_POINT, urlencode( $artist ), urlencode( $album1->name ) );

		$album2 = new stdClass();
		$album2->name = 'Album #2';
		$album2->image = $this->getMockedImgUrl();
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
		$album->image = $this->getImage( $albumName . '.jpg' );
		$album->year = '2000';
		$album->length = '6:66';
		$album->genres = ['Hard', 'Heavy'];
		$album->itunes = 'ALBUMITUNES';

		$artist = new StdClass();
		$artist->name = $artistName;
		$artist->image = $this->getImage( $artistName . '.jpg' );
		$artist->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getArtist',
			LyricsApiController::PARAM_ARTIST => $artistName
		]);
		$album->artist = $artist;

		$album->songs = [];
		for($i = 0; $i < 13; $i++) {
			$song = new StdClass();
			$song->name =  sprintf('%s song %d', $albumName, $i);
			$song->url = $this->buildUrl([
				'controller' => self::API_CONTROLLER_NAME,
				'method' => 'getSong',
				LyricsApiController::PARAM_ARTIST => $artistName,
				LyricsApiController::PARAM_ALBUM => $albumName,
				LyricsApiController::PARAM_SONG => $song->name
			]);
			$album->songs[] = $song;
		}
		return $album;
	}

	public function getSong( $artistName, $albumName, $songName ) {
		$song = new StdClass();
		$song->name = $songName;
		$song->lyrics = str_repeat('Lorem ipsum opusum'.PHP_EOL, 10);
		$song->itunes = 'SONGITUNES';

		$artist = new StdClass();
		$artist->name = $artistName;
		$artist->image = $this->getImage( $artistName . '.jpg' );
		$artist->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getArtist',
			LyricsApiController::PARAM_ARTIST => $artistName
		]);
		$song->artist = $artist;

		$album = new StdClass();
		$album->name = $albumName;
		$album->image = $this->getImage( $albumName . '.jpg' );
		$album->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getAlbum',
			LyricsApiController::PARAM_ARTIST => $artistName,
			LyricsApiController::PARAM_ALBUM => $albumName
		]);
		$song->album = $album;
		return $song;
	}
	public function searchArtist( $query ) {}
	public function searchSong( $query ) {}
	public function searchLyrics( $query ) {}

	/**
	 * @desc Just a simple helper method to return random placekitten images' urls
	 *
	 * @return string
	 */
	private function getMockedImgUrl() {
		return sprintf( '%s/%d/%d', 'http://placekitten.com', rand(128, 1024), rand(128, 1024) );
	}

} 
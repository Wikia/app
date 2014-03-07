<?php
/**
 * Class MockLyricsApiHandler
 *
 * @desc Provides mocked data for LyricsApi
 */
class MockLyricsApiHandler extends AbstractLyricsApiHandler {
	const API_ENTRY_POINT = 'wikia.php';
	const API_CONTROLLER_NAME = 'LyricsApi';

	/**
	 * @desc Builds an URL to the API
	 *
	 * @param Array $params params added to the URL
	 *
	 * @return string
	 */
	private function buildUrl( $params ) {
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

	/**
	 * @desc Returns an URL to random placekitten.com image
	 *
	 * @return string
	 */
	private function getImage() {
		return 'http://placekitten.com/' . rand(128, 1024) . '/' . rand(128, 1024) . '/';
	}

	/**
	 * @desc Returns mocked data about an artist
	 *
	 * @param String $artist artist name
	 *
	 * @return stdClass
	 */
	public function getArtist( $artist ) {
		$result = new stdClass();
		$result->name = $artist;
		$result->image = $this->getImage();

		$album1 = new stdClass();
		$album1->name = 'Album #1';
		$album1->image = $this->getImage();
		$album1->year = 2001;
		$album1->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getAlbum',
			LyricsApiController::PARAM_ARTIST => $artist,
			LyricsApiController::PARAM_ALBUM => $album1->name,
		]);

		$album2 = new stdClass();
		$album2->name = 'Album #2';
		$album2->image = $this->getImage();
		$album2->year = 2011;
		$album2->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getAlbum',
			LyricsApiController::PARAM_ARTIST => $artist,
			LyricsApiController::PARAM_ALBUM => $album2->name,
		]);

		$result->albums = [
			$album2,
			$album1
		];

		return $result;
	}

	/**
	 * @desc Returns mocked data about an album
	 *
	 * @param String $artistName
	 * @param String $albumName
	 *
	 * @return StdClass
	 */
	public function getAlbum( $artistName, $albumName ) {
		$album = new StdClass();
		$album->name = $albumName;
		$album->image = $this->getImage();
		$album->year = '2000';
		$album->length = '6:66';
		$album->genres = ['Hard', 'Heavy'];
		$album->itunes = 'ALBUMITUNES';

		$artist = new StdClass();
		$artist->name = $artistName;
		$artist->image = $this->getImage();
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

	/**
	 * @desc Returns mocked data about a song
	 *
	 * @param String $artistName
	 * @param String $albumName
	 * @param String $songName
	 *
	 * @return StdClass
	 */
	public function getSong( $artistName, $albumName, $songName ) {
		$song = new StdClass();
		$song->name = $songName;
		$song->lyrics = str_repeat('Lorem ipsum opusum'.PHP_EOL, 10);
		$song->itunes = 'SONGITUNES';

		$artist = new StdClass();
		$artist->name = $artistName;
		$artist->image = $this->getImage();
		$artist->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getArtist',
			LyricsApiController::PARAM_ARTIST => $artistName
		]);
		$song->artist = $artist;

		$album = new StdClass();
		$album->name = $albumName;
		$album->image = $this->getImage();
		$album->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getAlbum',
			LyricsApiController::PARAM_ARTIST => $artistName,
			LyricsApiController::PARAM_ALBUM => $albumName
		]);
		$song->album = $album;
		return $song;
	}

	/**
	 * @desc Returns mocked search results for an artist
	 *
	 * @param String $query
	 *
	 * @return array
	 */
	public function searchArtist( $query ) {
		$artists = [];
		for ( $i = 0; $i < 5; $i++ ) {
			$artist = new StdClass();
			$artist->name = $query . $i;
			$artist->image = $this->getImage();
			$artist->url = $this->buildUrl([
				'controller' => self::API_CONTROLLER_NAME,
				'method' => 'getArtist',
				LyricsApiController::PARAM_ARTIST => $artist->name
			]);
			$artists[] = $artist;
		}
		return $artists;
	}

	/**
	 * @desc Returns mocked search results for a song
	 *
	 * @param String $query
	 *
	 * @return array
	 */
	public function searchSong( $query ) {
		$songs = [];
		for ( $i = 0; $i < 5; $i++ ) {
			$song = new StdClass();
			$song->name =  sprintf('%s  %d', $query, $i);
			$song->image =  $this->getImage();
			$song->url = $this->buildUrl([
				'controller' => self::API_CONTROLLER_NAME,
				'method' => 'getSong',
				LyricsApiController::PARAM_ARTIST => 'Mocked Artist',
				LyricsApiController::PARAM_ALBUM => 'Mocked Album',
				LyricsApiController::PARAM_SONG => $song->name
			]);
			$songs[] = $song;
		}
		return $songs;
	}

	/**
	 * @desc Returns mocked search results for lyrics
	 *
	 * @param String $query
	 *
	 * @return array
	 */
	public function searchLyrics( $query ) {
		$songs = [];
		for ( $i = 0; $i < 5; $i++ ) {
			$song = new StdClass();
			$song->name =  sprintf('%s  %d', $query, $i);
			$song->image =  $this->getImage();
			$song->url = $this->buildUrl([
				'controller' => self::API_CONTROLLER_NAME,
				'method' => 'getSong',
				LyricsApiController::PARAM_ARTIST => 'Mocked Artist',
				LyricsApiController::PARAM_ALBUM => 'Mocked Album',
				LyricsApiController::PARAM_SONG => $song->name
			]);
			$song->highlight = 'i love '.$song->name.' desperately';
			$songs[] = $song;
		}
		return $songs;
	}

	/**
	 * @desc Returns mocked suggestions for an artist
	 *
	 * @param String $query
	 *
	 * @return array
	 */
	public function suggestArtist( $query ) {
		$artists = [];
		for ( $i = 0; $i < 5; $i++ ) {
			$artists[] = $query. $i;
		}
		return $artists;
	}

	/**
	 * @desc Returns mocked suggestions for an artist
	 *
	 * @param String $query
	 *
	 * @return array
	 */
	public function suggestAlbum( $query ) {
		$albums = [];
		for ( $i = 0; $i < 5; $i++ ) {
			$albums[] = $query. $i;
		}
		return $albums;
	}

	/**
	 * @desc Returns mocked suggestions for an artist
	 *
	 * @param String $query
	 *
	 * @return array
	 */
	public function suggestSong( $query ) {
		$songs = [];
		for ( $i = 0; $i < 5; $i++ ) {
			$songs[] = $query. $i;
		}
		return $songs;
	}

}

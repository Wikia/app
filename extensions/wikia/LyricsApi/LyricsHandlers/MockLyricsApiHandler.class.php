<?php
/**
 * Class MockLyricsApiHandler
 *
 * @desc Provides mocked data for LyricsApi
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

	private function generateSongs( $count, $artistName, $albumName ) {
		$songs = [];
		for($i = 0; $i < $count; $i++) {
			$song = new StdClass();
			$song->name =  sprintf('%s song %d', $albumName, $i);

			// Songs without song pages and lyrics
			if ( $i % 3 != 0 ) {
				$song->url = $this->buildUrl([
					'controller' => self::API_CONTROLLER_NAME,
					'method' => 'getSong',
					LyricsApiController::PARAM_ARTIST => $artistName,
					LyricsApiController::PARAM_ALBUM => $albumName,
					LyricsApiController::PARAM_SONG => $song->name
				]);
			}
			$songs[] = $song;
		}
		return $songs;
	}

	function getImage( $image ) {
		return 'http://placekitten.com/' . rand(128, 1024) . '/' . rand(128, 1024) . '/';
	}

	public function getArtist( $artistName ) {
		$result = new stdClass();
		$result->name = $artistName;
		$result->image = $this->getImage( $artistName );

		$album1 = new stdClass();
		$album1->name = 'Album #1';
		$album1->image = $this->getImage( $album1->name );
		$album1->year = 2001;
		$album1->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getAlbum',
			LyricsApiController::PARAM_ARTIST => $artistName,
			LyricsApiController::PARAM_ALBUM => $album1->name,
		]);

		$album2 = new stdClass();
		$album2->name = 'Album #2';
		$album2->image = $this->getImage( $album2->name );
		$album2->year = 2011;
		$album2->url = $this->buildUrl([
			'controller' => self::API_CONTROLLER_NAME,
			'method' => 'getAlbum',
			LyricsApiController::PARAM_ARTIST => $artistName,
			LyricsApiController::PARAM_ALBUM => $album2->name,
		]);

		$result->albums = [
			$album2,
			$album1
		];

		// Songs without albums
		$result->songs = $this->generateSongs( 5, $artistName, '' );

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

		$album->songs = $this->generateSongs( 13, $artistName, $albumName );
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

		// Songs without album
		if ( $albumName ) {
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
		}
		return $song;
	}

	public function searchArtist( $query ) {
		$artists = [];
		for ( $i = 0; $i < 5; $i++ ) {
			$artist = new StdClass();
			$artist->name = $query . $i;
			$artist->image = $this->getImage( $artist->name . '.jpg' );
			$artist->url = $this->buildUrl([
				'controller' => self::API_CONTROLLER_NAME,
				'method' => 'getArtist',
				LyricsApiController::PARAM_ARTIST => $artist->name
			]);
			$artists[] = $artist;
		}
		return $artists;
	}

	public function searchSong( $query ) {
		$songs = [];
		for ( $i = 0; $i < 5; $i++ ) {
			$song = new StdClass();
			$song->name =  sprintf('%s  %d', $query, $i);
			$song->image =  $this->getImage( $song->name . '.jpg' );
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

	public function searchLyrics( $query ) {
		$songs = [];
		for ( $i = 0; $i < 5; $i++ ) {
			$song = new StdClass();
			$song->name =  sprintf('%s  %d', $query, $i);
			$song->image =  $this->getImage( $song->name . '.jpg' );
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
	
	public function suggestArtist( $query ) {
		$artists = [];
		for ( $i = 0; $i < 5; $i++ ) {
			$artists[] = $query. $i;
		}
		return $artists;
	}

	public function suggestAlbum( $query ) {
		$albums = [];
		for ( $i = 0; $i < 5; $i++ ) {
			$albums[] = $query. $i;
		}
		return $albums;
	}

	public function suggestSong( $query ) {
		$songs = [];
		for ( $i = 0; $i < 5; $i++ ) {
			$songs[] = $query. $i;
		}
		return $songs;
	}

}

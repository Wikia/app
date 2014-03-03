<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/3/14
 * Time: 2:11 PM
 */

class MockLyricsApiHandler extends AbstractLyricsApiHandler {
	const API_ENTRY_POINT = 'wikia.php';

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

	public function getAlbum( $artist, $album ) {
		return [
			'artist' => [
				'name' => $artist,
				'image' => $artist . '.jpg',
				'url' => $artist
			],
			'name' => $album,
			'image' => $album . '.jpg',
			'songs' => [
				[
					'name' => $album . ' song 1',
					'url' => $album . ' song 1',
				],
				[
					'name' => $album . ' song 2',
					'url' => $album . ' song 2',
				],
			]
		];
	}

	public function getSong( $artist, $album, $song ) {}
	public function searchArtist( $query ) {}
	public function searchSong( $query ) {}
	public function searchLyrics( $query ) {}

} 
<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/3/14
 * Time: 2:11 PM
 */

class MockLyricsApiHandler extends AbstractLyricsApiHandler {

	public function getArtist( $artist ) {}

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
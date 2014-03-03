<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/3/14
 * Time: 2:22 PM
 */

class LyricsAlbum {

	private $name;
	private $image;
	private $artist;
	private $songs;

	/**
	 * @return mixed
	 */
	public function getSongs()
	{
		return $this->songs;
	}

	/**
	 * @param mixed $artist
	 */
	public function setArtist($artist) {
		$this->artist = $artist;
	}

	/**
	 * @return mixed
	 */
	public function getArtist() {
		return $this->artist;
	}

	/**
	 * @param mixed $image
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * @return mixed
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	public function getByArtistName ( $artist, $name ) {
		$handler = getHandler();
		$document = $handler->getAlbum( $artist, $name );

		$this->artist = new LyricsArtist();
		$this->artist->setName( $document['artist']['name'] );
		$this->artist->setImage( $document['artist']['image'] );
		$this->artist->setUrl( $document['artist']['url'] );

		$this->setName( $document['name'] );
		$this->setImage( $document['image'] );

		$this->clearSongs();
		foreach ($document['songs'] as $song) {
			$lyricsSong = new LyricsSong();
			$lyricsSong->setName( $song['name'] );
			$lyricsSong->setUrl( $song['url'] );
			$this->addSong( $lyricsSong );
		}
	}

	private function clearSongs() {
		$this->songs = [];
	}


	private function addSong( LyricsSong $lyricsSong ) {
		$this->songs[] = $lyricsSong;
	}
} 
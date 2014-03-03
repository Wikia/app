<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/3/14
 * Time: 1:50 PM
 */


class LyricsApiController extends WikiaController {

	private $lyricsApiHandler = null;

	public function __construct() {
		$this->lyricsApiHandler = new LyricsApiHandlerFactory();
	}

	public function getArtist() {
		$artist = $this->wg->Request->getVal( 'artist' );
	}

	public function getAlbum() {
		$artist = $this->wg->Request->getVal( 'artist' );
		$album = $this->wg->Request->getVal( 'album' );
	}

	public function getSong() {
		$artist = $this->wg->Request->getVal( 'artist' );
		$album = $this->wg->Request->getVal( 'album' );
		$song = $this->wg->Request->getVal( 'song' );
	}

	public function searchArtist() {
		$query = $this->wg->Request->getVal( 'query' );
	}

	public function searchSong() {
		$query = $this->wg->Request->getVal( 'query' );
	}
	public function searchLyrics() {
		$query = $this->wg->Request->getVal( 'query' );
	}

} 
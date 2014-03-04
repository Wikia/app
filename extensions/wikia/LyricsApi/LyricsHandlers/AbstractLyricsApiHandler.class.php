<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/3/14
 * Time: 2:08 PM
 */


abstract class AbstractLyricsApiHandler {

	abstract public function getArtist( $artist );
	abstract public function getAlbum( $artist, $album );
	abstract public function getSong( $artist, $album, $song );
	abstract public function searchArtist( $query );
	abstract public function searchSong( $query );
	abstract public function searchLyrics( $query );
	abstract public function suggestArtist( $query );
	abstract public function suggestAlbum( $query );
	abstract public function suggestSong( $query );

} 
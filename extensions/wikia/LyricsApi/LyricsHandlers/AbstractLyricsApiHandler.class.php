<?php
/**
 * Class AbstractLyricsApiHandler
 *
 * @desc An interface for all *LyricsApiHandlers
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
 

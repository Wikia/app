<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/4/14
 * Time: 11:31 AM
 */

class DataBaseAdapter {
	function saveArtist($artist, $albums) { echo 'R'; }
	function saveAlbum($artist, $album, $songs) { echo 'L'; }
	function saveSong($artist, $album, $song) { echo 'S'; }
}
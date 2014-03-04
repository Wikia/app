<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 3/4/14
 * Time: 11:31 AM
 */

abstract class DataBaseAdapter {

	abstract function saveArtist($artist, $albums);
	abstract function saveAlbum($artist, $album, $songs);
	abstract function saveSong($artist, $album, $song);

}

class MockBaseAdapter extends DataBaseAdapter {

	function saveArtist($artist, $albums) { echo 'R'; }
	function saveAlbum($artist, $album, $songs) { echo 'L'; }
	function saveSong($artist, $album, $song) { echo 'S'; }
}


function newDatabaseAdapter( $adapterType, $config ) {
	switch ( $adapterType ) {
		default :
			return new MockBaseAdapter( $config );
	}
}
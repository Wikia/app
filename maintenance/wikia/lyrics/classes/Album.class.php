<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 2:00 PM
 */

class Album extends BaseLyricsEntity {

	var $dataMap = [
		'name' => 'name',
		'pic' => 'pic',
		'year' => 'year',
	];

	function save( $albumData ) {
		// TODO: Save and return id
	}
} 
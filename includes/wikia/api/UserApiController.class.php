<?php
/**
 * Created by adam
 * Date: 07.05.13
 */

class ArticlesApiController extends WikiaApiController {

	/**
	 * Get details about one or more user
	 *
	 * @requestParam string $ids A string with a comma-separated list of user ID's
	 * @requestParam integer $size [OPTIONAL] The desired width and height for the thumbnail, defaults to 100, 0 for no thumbnail
	 *
	 * @responseParam array $items A list of results with the user ID as the index, each item has a title, name, url, avatar, numberofedits
	 * @responseParam string $basepath domain of a wiki to create a url for an user
	 *
	 * @example &ids=2187,23478&size=150
	 */
	public function getDetails() {

	}

}
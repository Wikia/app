<?php

/**
 * WikiaPhotoGalleryRSS class
 * Handles RSS parsing and image exctracting
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-08-31
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class WikiaPhotoGalleryRSS {

	static $data;

	/*
	 * parseFeed - grabs XML for feed and exctract images with captions
	 *
	 * @author Marooned
	 */
	static function parseFeed($url, $omitDB = false) {
		global $wgOut;

		//reset array
		self::$data = array('feedTitle' => '', 'images' => array());

		if (!$omitDB) {
			//check DB for this URL - we might have it already (background task will refresh it)
			$data = self::getDataByUrl($url);
		}

		if ($omitDB || is_null($data)) {
			//no data in DB - fetch from feed
			$itemCount = 0;
			$rssContent = Http::get($url);

			$feed = new SimplePie();
			$feed->set_raw_data($rssContent);
			$feed->init();

			self::$data['feedTitle'] = $feed->get_title();

			foreach ($feed->get_items() as $item) {
				$enclosures = $item->get_enclosures();

				$enclosuresFound = false;
				//we have enclosures - use them instead of content of feed (usually there are bigger image while content uses thumbnails)
				if (!is_null($enclosures)) {
					foreach ($enclosures as $enclosure) {
						$type = $enclosure->get_type();
						if (!empty($type) && substr($type, 0, 6) === 'image/') {
							self::$data['images'][] = array(
								'src' => $enclosure->get_link(),
								'caption' => $item->get_title(),
								'link' => $item->get_link()
							);
							$enclosuresFound = true;
							break;	//one image per feed
						}
					}
				}

				//if enclosures has not been found or doesn't contain any images - use regular method
				if (!$enclosuresFound) {
					//look for <img /> tags
					$description = $item->get_description();
					preg_match('/<img .*?src=([\'"])(.*?\.(?:jpg|jpeg|gif|png))\1/', $description, $matches);
					if (!empty($matches[2])) {
						self::$data['images'][] = array(
							'src' => $matches[2],
							'caption' => $item->get_title(),
							'link' => $item->get_link()
						);
					}
				}

				if (count(self::$data['images']) >= 20 || ++$itemCount > 50) {
					break; //take up to 20 images, from up to 50 articles.
				}
			}

			//store data in DB only if valid rss (images found)
			if (count(self::$data['images'])) {
				self::setData($url, self::$data);
			}
		} else {
			self::$data = $data;
		}

		return self::$data;
	}

	/*
	 * getDataByUrl - gets gallery metadata from DB by URL
	 *
	 * @author Marooned
	 */
	private static function getDataByUrl($url) {
		global $wgExternalDatawareDB;

		$result = null;
		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);

		$row = $dbr->selectRow(
			'photo_gallery_feeds',
			'data',
			array('url' => $url),
			__METHOD__
		);

		if ($row !== false) {
			$result = unserialize($row->data);
		}

		return $result;
	}

	/*
	 * setData - sets gallery data into DB
	 *
	 * @author Marooned
	 */
	private static function setData($url, $data) {
		global $wgExternalDatawareDB;

		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);

		$fields = array(
			'url' => $url,
			'data' => serialize($data)
		);

		$dbw->replace('photo_gallery_feeds', array('url'), $fields, __METHOD__);
		//mostly AJAX calls
		$dbw->commit();
	}
}
<?php
/**
 * This service provides images related data
 */
class ImagesService extends Service {

	/**
	 * Get list of images which:
	 *  - are used on pages (in content namespaces) matching given query
	 *  - match given query
	 */
	public static function search($query, $limit = 50) {
		global $wgContentNamespaces;
		wfProfileIn(__METHOD__);

		$images = array();

		$query_select = "SELECT il_to FROM imagelinks JOIN page ON page_id=il_from WHERE page_title = '%s' and page_namespace = %s";
		$query_glue = ' UNION DISTINCT ';

		// get articles and images matching given query (using API)
		$data = ApiService::call(array(
			'action' => 'query',
			'list' => 'search',
			'srnamespace' => implode('|', array_merge($wgContentNamespaces, array(NS_FILE))),
			'srlimit' => $limit,
			'srsearch' => $query,
		));

		if (!empty($data['query']['search'])) {
			$dbr = wfGetDB(DB_SLAVE);
			$query_arr = array();

			// get images used on pages returned by API query
			foreach ($data['query']['search'] as $aResult) {
				$query_arr[] = sprintf($query_select, $dbr->strencode(str_replace(' ', '_', $aResult['title'])), $aResult['ns']);
			}

			$query_sql = implode($query_glue, $query_arr);
			$res = $dbr->query($query_sql, __METHOD__);

			if($res->numRows() > 0) {
				while( $row = $res->fetchObject() ) {
					$images[] = $row->il_to;

					if (count($images) == $limit) {
						break;
					}
				}
			}
			$dbr->freeResult($res);
		}

		wfProfileOut(__METHOD__);
		return $images;
	}

	/**
	 * Get lists of images used on given article
	 */
	public static function getFromArticle(Title $title, $limit = 50) {
		wfProfileIn(__METHOD__);

		$images = array();

		// get list of images linked with given article
		$res = ApiService::call(array(
			'action' => 'query',
			'prop' => 'images',
			'titles' => $title->getPrefixedText(),
			'imlimit' => $limit,
		));

		if (!empty($res['query']['pages'])) {
			$data = array_pop($res['query']['pages']);

			if (!empty($data['images'])) {
				foreach($data['images'] as $entry) {
					// ignore Video:foo entries from VET
					if ($entry['ns'] == NS_IMAGE) {
						$images[] = $entry['title'];
					}
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $images;
	}

	/**
	 * Get list of recently uploaded files (RT #79288)
	 */
	public static function getRecentlyUploaded($limit) {
		global $wgEnableAchievementsExt;
		wfProfileIn(__METHOD__);

		$images = false;

		// get list of recent log entries (type = 'upload')
		// limit*2 because of possible duplicates in log caused by image reuploads
		$res = ApiService::call(array(
			'action' => 'query',
			'list' => 'logevents',
			'letype' => 'upload',
			'leprop' => 'title',
			'lelimit' => $limit * 2,
		));

		if (!empty($res['query']['logevents'])) {
			foreach($res['query']['logevents'] as $entry) {
				// ignore Video:foo entries from VideoEmbedTool
				if ($entry['ns'] == NS_IMAGE) {
					$image = Title::newFromText($entry['title']);
					if (!empty($image)) {
						// skip badges upload (RT #90607)
						if (!empty($wgEnableAchievementsExt) && Ach_isBadgeImage($image->getText())) {
							continue;
						}

						// use keys to remove duplicates
						$images[$image->getDBkey()] = $image;

						// limit number of results
						if (count($images) == $limit) {
							break;
						}
					}
				}
			}

			// use numeric keys
			$images = array_values($images);
		}

		wfProfileOut(__METHOD__);
		return $images;
	}

}

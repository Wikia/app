<?php

class RealgravityFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'RealgravityApiWrapper';
	protected static $PROVIDER = 'realgravity';
	protected static $FEED_URL = 'http://mediacast.realgravity.com/vs/2/videos/$1.json?providers=$2&lookup_columns=tag_list,title&search_term=$3&per_page=$4&page=$5';
	private static $API_PROVIDER_IDS = array('MACHINIMA'=>240);
	const API_PAGE_SIZE = 100;

	public function import($content='', $params=array()) {

		wfProfileIn( __METHOD__ );

		$numCreated = 0;

		if (!empty($params['keyphrasesCategories'])) {
			foreach ($params['keyphrasesCategories'] as $keyphrase=>$categories) {
				$movieParams = array(
				    'addlCategories'	=> $categories,
				    'debug'		=> !empty($params['debug']),
				    'startDate'		=> !empty($params['startDate']) ? $params['startDate'] : '',
				    'endDate'		=> !empty($params['endDate']) ? $params['endDate'] : ''
				    );
				$numCreated += $this->importVideosForKeyphrase($keyphrase, $movieParams);
			}
		}
		wfProfileOut( __METHOD__ );

		return $numCreated;
	}

	protected function importVideosForKeyphrase($keyword, $params=array()) {

		wfProfileIn( __METHOD__ );

		$addlCategories = !empty($params['addlCategories']) ? $params['addlCategories'] : array();
		$debug = !empty($params['debug']);
		$startDate = !empty($params['startDate']) ? $params['startDate'] : '';
		$endDate = !empty($params['endDate']) ? $params['endDate'] : '';

		$articlesCreated = 0;
		$page = 1;

		do {
			$numVideos = 0;

			// connect to provider API
			$url = $this->initFeedUrl($keyword, $startDate, $endDate, $page++);
			print("Connecting to $url...\n");
			$req = MWHttpRequest::factory( $url );
			$status = $req->execute();
			if( $status->isOK() ) {
				$response = $req->getContent();
			}
			else {
				print("ERROR: problem downloading content!\n");
				wfProfileOut( __METHOD__ );
				return 0;
			}

			// parse response
			$videos = json_decode( $response, true );
			$numVideos = sizeof($videos['videos']);
			print("Found $numVideos videos...\n");
			for ($i=0; $i<$numVideos; $i++) {
				$clipData = array();
				$video = $videos['videos'][$i];
				$clipData['clipTitle'] = trim($video['title']);
				$clipData['videoId'] = $video['guid'];
				$clipData['thumbnail'] = $video['image'];
				$clipData['duration'] = $video['duration'];
				$clipData['published'] = $video['date'];
				$clipData['category'] = $video['category_name'];
				$clipData['keywords'] = trim($video['tags']);
				$clipData['description'] = trim($video['description']);
				$clipData['aspectRatio'] = $video['aspect_ratio'];

				$msg = '';
				$createParams = array('addlCategories'=>$addlCategories, 'debug'=>$debug);
				$articlesCreated += $this->createVideo($clipData, $msg, $createParams);
				if ($msg) {
					print "ERROR: $msg\n";
				}
			}
		}
		while ($numVideos == self::API_PAGE_SIZE);

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	private function initFeedUrl($keyword, $startDate, $endDate, $page=1) {
		global $wgRealgravityApiKey;

		$url = str_replace('$1', $wgRealgravityApiKey, static::$FEED_URL);
		$url = str_replace('$2', self::$API_PROVIDER_IDS['MACHINIMA'], $url);
		$url = str_replace('$3', urlencode($keyword), $url);
		$url = str_replace('$4', self::API_PAGE_SIZE, $url);
		$url = str_replace('$5', $page, $url);
		if ($startDate && $endDate) {
			$url .= '&date_range=' . $startDate . '..' . $endDate;
		}
		return $url;
	}

	protected function generateName(array $data) {
		$name = $data['clipTitle'];

		// per parent class's definition, do not sanitize

		return $name;
	}

	protected function generateCategories(array $data, $addlCategories) {
		$categories = !empty($addlCategories) ? $addlCategories : array();
		$categories[] = 'RealGravity';
		$categories[] = 'Games';

		return $categories;
	}

	protected function generateMetadata(array $data, &$errorMsg) {
		$keywords = explode(',', $data['keywords']);	// keywords is a comma-delimited string
		array_walk($keywords, array($this, 'trimArrayItem'));
		$parsedData = array(
		    'videoId'		=> $data['videoId'],
		    'thumbnail'		=> $data['thumbnail'],
		    'duration'		=> $data['duration'],
		    'published'		=> strtotime($data['published']),
		    'category'		=> $data['category'],
		    'keywords'		=> implode(', ', $keywords),
		    'description'	=> $data['description'],
		    'aspectRatio'	=> $data['aspectRatio']
		    );

		return $parsedData;
	}

	private function trimArrayItem(&$item, $key) {
		$item = trim($item);
	}
}
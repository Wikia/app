<?php

class MovieclipsFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'MovieclipsApiWrapper';
	protected static $PROVIDER = 'movieclips';
	protected static $FEED_URL = 'http://api.movieclips.com/v2/movies/$1/videos';
	const MOVIECLIPS_XMLNS = 'http://api.movieclips.com/schemas/2010';
	const API_REQUEST_DELAY = 2;	// seconds
	
	private $rssContent;
	
	public function import($file='', $params=array()) {	
		$numCreated = 0;
		
		if (!empty($params['movieclipsidsCategories'])) {
			foreach ($params['movieclipsidsCategories'] as $id=>$categories) {
				$movieParams = array('addlCategories'=>$categories, 'debug'=>!empty($params['debug']));
				$numCreated += $this->importVideosForMovie($id, $movieParams);
			}
		}		
		
		return $numCreated;
	}
	
	protected function importVideosForMovie($movieId, $params=array()) {
		$addlCategories = !empty($params['addlCategories']) ? $params['addlCategories'] : array();
		$debug = !empty($params['debug']);

		$articlesCreated = 0;

		$url = str_replace('$1', $movieId, static::$FEED_URL);
		print("Connecting to $url...\n");
		sleep(self::API_REQUEST_DELAY);	// making too quick requests results in 503 errors
		$this->rssContent = $this->getUrlContent($url);
		
		if (!$this->rssContent) {
			print("ERROR: problem downloading content!\n");
			return 0;
		}

		$feed = new SimplePie();
		$feed->set_raw_data($this->rssContent);
		$feed->init();
		if ($feed->error()) {
			print("ERROR: {$feed->error()}");
			return $articlesCreated;
		}

		foreach ($feed->get_items() as $key=>$item) {
			$clipData = array();
			
			// video title
			$clipData['clipTitle'] = html_entity_decode( $item->get_title() );

			// id
			$mcIds = $item->get_item_tags(self::MOVIECLIPS_XMLNS, 'id');
			$clipData['videoId'] = $mcIds[0]['data'];
			
			// title and year, description
			$origDescription = strip_tags( html_entity_decode( $item->get_description() ) );			
			$clipData['movieTitleAndYear'] = $this->parseMovieTitleAndYear($origDescription);
			$clipData['description'] = str_replace("{$clipData['movieTitleAndYear']} - {$clipData['clipTitle']} - ", '', $origDescription);
						
			// published
			$clipData['published'] = $item->get_date();
			
			// thumbnails, duration
			if ($enclosure = $item->get_enclosure()) {
				$clipData['duration'] = $enclosure->get_duration();

				$thumbnails = (array) $enclosure->get_thumbnails();
				$largestThumbIdx = sizeof($thumbnails) - 1;	// assume largest thumbnail is last one
				$clipData['thumbnail'] = $thumbnails[$largestThumbIdx];
			}
			
			$createParams = array('addlCategories'=>$addlCategories, 'debug'=>$debug);
			$msg = '';
			$articlesCreated += $this->createVideo($clipData, $msg, $createParams);
			if ($msg) {
				print "ERROR: $msg\n";
			}
		}

		return $articlesCreated;
	}
	
	protected function parseMovieTitleAndYear($description) {
		preg_match('/(.+? \(\d{4}\)) - /', $description, $matches);
		if (is_array($matches) && sizeof($matches) > 1) {
			return $matches[1];
		}

		return '';
	}
	
	protected function generateName(array $data) {
		$name = $data['movieTitleAndYear'] . ' - ' . $data['clipTitle'];
		
		// per parent class's definition, do not sanitize

		return $name;
	}

	protected function generateMetadata(array $data, &$errorMsg) {
		$metadata = array(
		    'videoId'		=> $data['videoId'],
		    'description'	=> $data['description'],
		    'duration'		=> $data['duration'],
		    'movieTitleAndYear'	=> $data['movieTitleAndYear'],
		    'published'		=> strtotime($data['published']),
		    'thumbnailUrl'	=> $data['thumbnail'],
		    'videoTitle'	=> $data['clipTitle']
		);
		
		return $metadata;
	}
	
	protected function generateCategories(array $data, $addlCategories) {
		$categories = !empty($addlCategories) ? $addlCategories : array();
		$categories[] = 'MovieClips Inc.';
		$categories[] = 'Entertainment';
		
		return $categories;
	}
		
	protected function generateTitleName(array $data) {
		return $data['movieTitleAndYear'];
	}

}
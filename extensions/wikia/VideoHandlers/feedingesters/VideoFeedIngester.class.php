<?php

abstract class VideoFeedIngester {
	const PROVIDER_SCREENPLAY = 'screenplay';
	const PROVIDER_MOVIECLIPS = 'movieclips';
	const PROVIDER_REALGRAVITY = 'realgravity';
	public static $PROVIDERS = array(self::PROVIDER_SCREENPLAY, self::PROVIDER_MOVIECLIPS, self::PROVIDER_REALGRAVITY);
	protected static $CLIP_TYPE_BLACKLIST = array();
	protected static $API_WRAPPER;
	protected static $PROVIDER;
	private static $instances = array();
	
	abstract public function import($file, $params=array());
	abstract protected function generateName(array $data);
	abstract public function generateTitleName(array $data);
	abstract protected function generateInterfaceObject(array $data, &$errorMsg);
	abstract protected function generateCategories(array $data, $addlCategories);
	
	public function getInstance($provider='') {
		if (empty($provider)) {
			$className = __CLASS__;
		}
		else {
			$className = ucfirst($provider) . 'FeedIngester';
			if (!class_exists($className)) {
				return null;
			}
		}
		
		if (empty(self::$instances[$className])) {
			self::$instances[$className] = new $className();
		}
		
		return self::$instances[$className];
	}

	public function createVideoPage(array $data, &$msg, $params=array()) {
		$debug = !empty($params['debug']);
		$addlCategories = !empty($params['addlCategories']) ? $params['addlCategories'] : array();
		
		$id = $data['videoId'];
		$name = $this->generateName($data);
		$interfaceObject = $this->generateInterfaceObject($data, $msg);
		if (!empty($msg)) {
			return 0;
		}
		
		$title = $this->makeTitleSafe($name);
		if(is_null($title)) {
			$msg = "article title was null: clip id $id. name: $name";
			return 0;
		}
		if(!$debug && $title->exists()) {
			// don't output duplicate error message
			return 0;
		}	

		$categories = $this->generateCategories($data, $addlCategories);
		$categories[] = 'Video';
		$categoryStr = '';
		foreach ($categories as $categoryName) {
			$category = Category::newFromName($categoryName);
			$categoryStr .= '[[' . $category->getTitle()->getFullText() . ']]';
		}
		
		if ($debug) {
			print "parsed partner clip id $id. name: {$title->getText()}. data: " . implode(',', $interfaceObject) . ". categories: " . implode(',', $categories) . "\n";
			return 1;
		}
		else {
			$apiParams = array('videoId'=>$id, 'interfaceObj'=>$interfaceObject);
			$apiWrapper = new static::$API_WRAPPER($name, $apiParams);
			$uploadedTitle = null;
			$result = VideoHandlersUploader::uploadVideo(static::$PROVIDER, $name, $uploadedTitle, $categoryStr.$apiWrapper->getDescription(), false);
			if ($result->ok) {
				print "Ingested {$uploadedTitle->getText()} from partner clip id $id. {$uploadedTitle->getFullURL()}\n\n";
				return 1;
			}
		}

		return 0;
	}

	protected function makeTitleSafe($name) {
		return Title::makeTitleSafe(NS_FILE, $name);    // makeTitleSafe strips '#' and anything after. just leave # out
	}		

	protected function getUrlContent($url) {
		return Http::get($url);
	}
	
	/**
	 * Try to find keyphrase in the subject. A keyphrase could be 
	 * "harry potter". A keyphrase is present in the subject if "harry" and
	 * "potter" are present.
	 * @param string $subject
	 * @param string $keyphrase
	 * @return boolean 
	 */
	protected function isKeyphraseInString($subject, $keyphrase) {
		$keyphraseFound = false;
		$keywords = explode(' ', $keyphrase);
		$keywordMissing = false;
		foreach ($keywords as $keyword) {
			if (stripos($subject, $keyword) === false) {
				$keywordMissing = true;
				break;
			}
		}
		if (!$keywordMissing) {
			$keyphraseFound = true;
		}
		
		return $keyphraseFound;
	}

	protected function isClipTypeBlacklisted(array $clipData) {
		// assume that a clip with properties that match exactly undesired
		// values should not be imported. This assumption will have to
		// change if we consider values that fall into a range, such as
		// duration < MIN_VALUE
		if (is_array(static::$CLIP_TYPE_BLACKLIST)) {
			$arrayIntersect = array_intersect(static::$CLIP_TYPE_BLACKLIST, $clipData);
			if ($arrayIntersect == static::$CLIP_TYPE_BLACKLIST) {
				return true;
			}
		}
		
		return false;
	}
	
}
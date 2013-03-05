<?php

class VideoPageController extends WikiaController {

	/**
	 *
	 */
	public function fileUsage() {
		
		$this->setVal('limit', 50);
		$summary = F::app()->sendRequest('VideoPageController', 'getGlobalUsage')->getData()['summary'];

		$heading = '';
		$fileList = array();
		$type = $this->getVal('type', 'local');

		if (!empty($summary) ) {

			if ($type === 'global') {
				$heading = wfMsg('video-page-global-file-list-header');
				
				if (array_key_exists($this->wg->DBname, $summary)) {
					unset($summary[$this->wg->DBname]);
				}
				
				$count = 0;
				$shortenedSummary = array();
				
				// shorten it to 3
				foreach($summary as $wiki => $articles) {
					if($count < 3) {
						foreach($articles as $article) {
							$dbName = $article['wiki'];
							if(empty($shortenedSummary[$dbName])) {
								$shortenedSummary[$dbName] = array();
							}
							$shortenedSummary[$dbName][] = $article;
							if(++$count > 2) {
								break;
							}
						}
					}
				}
				
				$data = F::app()->sendRequest( 'VideoPageController', 'fileList', array('summary' => $shortenedSummary, 'type' => 'global'))->getData();

				$fileList = empty($data['fileList']) ? array() : $data['fileList'];
			} else {
				$heading = wfMsg('video-page-file-list-header');
				$dbName = $this->wg->DBname;
				
				$shortenedSummary = array();
				if(array_key_exists($dbName, $summary)) {
					$summary = array($dbName => $summary[$dbName]);
					// shorten it to 3, different algo than global list
					$count = 0;
					$articles = array();
					foreach($summary[$dbName] as $article) {
						$articles[] = $article;
						if(++$count > 2) {
							break;
						}
					}
					$shortenedSummary = array($dbName => $articles);
				}
				
				$data = F::app()->sendRequest( 'VideoPageController', 'fileList', array('summary' => $shortenedSummary, 'type' => 'local') )->getData();
				$fileList = empty($data['fileList']) ? array() : $data['fileList'];
			}
		}

		$this->heading = $heading;
		$this->fileList = $fileList;
		$this->summary = $summary;
		$this->type = $type;
	}
	
	public function fileList() {
		//$summary = F::app()->sendRequest('VideoPageController', 'getGlobalUsage', array('fileTitle' => 'File:Shoot_Many_Robots_Design_Many_Robots_Trailer'))->getData()['summary'];
		$summary = $this->getVal('summary', '');
		$type = $this->getVal('type', '');
		$result = array();
		if(empty($summary) || empty($type)) {
			$this->result = $result;
			return;
		}
		
		if($type === 'global') {
			$expandedSummary = $this->addGlobalSummary($summary);
		} else {
			$expandedSummary = $this->addLocalSummary($summary);
		}
		
		$result = array();
		
		foreach($expandedSummary as $wiki => $articles) {
			foreach($articles as $article) {
				$result[] = $article;
			}
		}
		
		$this->fileList = $result;
		$this->type = $type;
	}

	private function nameToTitle ( $dbName ) {
		$wikiData = WikiFactory::getWikiByDB($dbName);
		return $wikiData->city_title;
	}

	public function relatedPages() {
		$this->text = '';
	
		if(empty($this->wg->EnableRelatedPagesExt)) {
			return;
		}
		
		$res = $this->queryImageLinks(1);
		$first = $res->fetchObject();

		if (!empty($first)) {
			$titleID = $first->page_id;

			$title = Title::newFromID($titleID);

			# Get the categories for this title
			$cats = $title->getParentCategories();
			$titleCats = array();

			# Construct an array of category name to sorting key.  We use the 'normal'
			# default as the sorting key since we don't really care about the sorting
			# here.  We just need to give the RelatedPages module something to work with
			foreach ($cats as $cat_text => $title_text) {
				$categoryTitle = Title::newFromText($cat_text);
				$categoryName = $categoryTitle->getText();
				$titleCats[$categoryName] = 'normal';
			}

			# Seed the RelatedPages instance with the categories we found.  Normally
			# categories are set via a hook in the page render process, so we have to
			# supply our own here.
			$relatedPages = RelatedPages::getInstance();
			$relatedPages->setCategories($titleCats);

			# Rendering the RelatedPages index with our alternate title and pre-seeded categories.
			$this->text = F::app()->renderView( 'RelatedPages', 'Index', array( "altTitle" => $title ) );
		}
	}

	public function videoCaption() {
		global $wgWikiaVideoProviders;

		$provider = $this->getVal('provider');
		if ( !empty($provider) ) {
			$providerName = explode( '/', $provider );
			$provider = array_pop( $providerName );
		}

		$expireDate = $this->getVal( 'expireDate', '' );
		if ( !empty($expireDate) ) {
			$date = $this->wg->Lang->date( $expireDate );
			$expireDate = $this->wf->Message( 'video-page-expires', $date )->text();
		}

		$this->provider = ucwords($provider);
		$this->detailUrl = $this->getVal('detailUrl');
		$this->providerUrl = $this->getVal('providerUrl');
		$this->expireDate = $expireDate;
		$this->viewCount = $this->getVal('views');
	}

	private function queryImageLinks( $limit ) {
		$target = $this->wg->Title->getDBkey();
		$dbr = wfGetDB( DB_SLAVE );

		return $dbr->select(
			array( 'imagelinks', 'page' ),
			array( 'page_namespace', 'page_title', 'page_id', 'il_to' ),
			array( 'il_to' => $target, 'il_from = page_id', 'page_is_redirect = 0' ),
			__METHOD__,
			array( 'LIMIT' => $limit + 1, 'ORDER BY' => 'il_from', )
		);
	}

	public function getGlobalUsage () {
		$fileTitle = $this->getVal('fileTitle', '');
		$titleObj = empty($fileTitle) ? $this->wg->Title : Title::newFromText($fileTitle);

		// Query the global usage table to see where the current File title is used
		$query = new GlobalUsageQuery( $titleObj->getDBkey() );
		
		$titleObj = null;
		
		if ( $this->getVal('offset') ) {
			$query->setOffset( $this->getVal('offset') );
		}
		$query->setLimit( $this->wg->Request->getInt('limit', 50) );
		$query->execute();

		$summary = $query->getSingleImageResult();
		
		// Translate key names and add some additional data
		foreach ($summary as $dbName => $articles) {
			foreach ($articles as $info) {
				// Change the 'wiki' key from a db name to a display name
				//$dbName = $info['wiki'];
				$info['wiki'] = $this->nameToTitle($dbName);
				$info['dbName'] = $dbName;
			}
		}

		$this->summary = $summary;
	}

	public function addLocalSummary ( $data ) {
		$handle = fopen("/tmp/debug.out", 'a');
		fwrite($handle, 'LOCAL: '. print_r($data, true));
		fclose($handle);
		return $this->addSummary($data, function ($dbName, $articleIds) {
			$response = $this->app->sendRequest('ArticleSummaryController', 'blurb', array('ids' => implode(',', $articleIds)));
			return $response->getData();
		});
	}

	public function addGlobalSummary( $data ) {
		return $this->addSummary($data, function ($dbName, $articleIds) {
			$url = WikiFactory::DBtoURL($dbName);
			$url = WikiFactory::getLocalEnvURL($url);
			$url .= '/wikia.php?controller=ArticleSummaryController&method=blurb&format=json&ids=';
			$url .= implode(',', $articleIds);

			$out = Http::get($url);
			return json_decode($out, true);
		});
	}

	private function addSummary ( $data, $summaryFunc ) {

		// Iterate through each wiki DB name in the data
		foreach ($data as $dbName => $articles) {

			// Get all the article IDs for this wiki so we can make one call to
			// grab the extra data we need from the ArticleSummaryController
			$articleIds = array_map(function ($item) { return $item['id']; }, $articles);

			// This function will fetch the data for us
			$extraData = $summaryFunc($dbName, $articleIds);

			if (!empty($extraData['summary'])) {
				// Eliminate the superfluous 'summary' key
				$extraData = $extraData['summary'];

				// Loop with indexes so we can change $data in place
				for ($i = 0; $i < count($articles); $i++) {
					$info = $articles[$i];
					$extraInfo = $extraData[$info['id']];

					$articles[$i] = array_merge($info, $extraInfo);
				}

				$data[$dbName] = $articles;
			}
		}

		return $data;
	}
}

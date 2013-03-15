<?php

class VideoPageController extends WikiaController {

	/**
	 *
	 */
	public function fileUsage() {
		$app = F::app();

		$this->setVal('limit', 50);

		$heading = '';
		$fileList = array();
		$shortenedSummary = array();
		$type = $this->getVal('type', 'local');

		if ($type === 'global') {
			$heading = wfMsg('video-page-global-file-list-header');

			$summary = $app->sendRequest('VideoPageController', 'getGlobalUsage')->getData()['summary'];
			
			if (array_key_exists($this->wg->DBname, $summary)) {
				unset($summary[$this->wg->DBname]);
			}
			
			$count = 0;
			
			// shorten it to 3
			foreach ($summary as $wiki => $articles) {
				if ($count < 3) {
					foreach ($articles as $article) {
						$dbName = $article['wiki'];
						if(empty($shortenedSummary[$dbName])) {
							$shortenedSummary[$dbName] = array();
						}
						$shortenedSummary[$dbName][] = $article;
						if (++$count > 2) {
							break;
						}
					}
				} else {
					break;
				}
			}
		} else {
			$heading = wfMsg('video-page-file-list-header');
			$summary = $app->sendRequest('VideoPageController', 'getLocalUsage')->getData()['summary'];

			if ($summary and count($summary)) {
				$dbName = $this->wg->DBname;
				$shortenedSummary = array($dbName => array_slice($summary, 0, 3));
			}
		}

		$data = $app->sendRequest( 'VideoPageController', 'fileList', array('summary' => $shortenedSummary, 'type' => $type) )->getData();
		$fileList = empty($data['fileList']) ? array() : $data['fileList'];

		$this->heading = $heading;
		$this->fileList = $fileList;
		$this->summary = $summary;
		$this->type = $type;
	}
	
	public function fileList() {
		$summary = $this->getVal('summary', '');
		$type = $this->getVal('type', '');
		$result = array();
		if(empty($summary) || empty($type)) {
			$this->result = $result;
			return;
		}

		if ($type === 'global') {
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

		# Find the first page that links to this current file page that has a category
		$pageId = $this->firstPageWithCategory();
		if (empty($pageId)) {
			return;
		}

		# Get the title object
		$title = Title::newFromID($pageId);
		if (empty($title)) {
			return;
		}

		# Get the categories for this title
		$cats = $title->getParentCategories();
		if (!count($cats)) {
			return;
		}
		$titleCats = array();

		# Construct an array of category names to feed to the RelatedPages extension
		foreach ($cats as $cat_text => $title_text) {
			$categoryTitle = Title::newFromText($cat_text);
			$titleCats[] = $categoryTitle->getDBkey();
		}

		# Seed the RelatedPages instance with the categories we found.  Normally
		# categories are set via a hook in the page render process, so we have to
		# supply our own here.
		$relatedPages = RelatedPages::getInstance();
		$relatedPages->setCategories($titleCats);

		# Rendering the RelatedPages index with our alternate title and pre-seeded categories.
		$this->text = F::app()->renderView( 'RelatedPages', 'Index', array( "altTitle" => $title ) );
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

	private function firstPageWithCategory () {
		$target = $this->wg->Title->getDBkey();
		$dbr = wfGetDB( DB_SLAVE );

		# We want to find the first page that has a link to the current file page AND
		# has at least one category associated with it.  The categor(ies) are how
		# the RelatedPages extention determines what's related
		$res = $dbr->select(
			array( 'imagelinks', 'page', 'categorylinks' ),
			array( 'distinct(page_id) as page_id' ),
			array( 'il_to' => $target, 'il_from = page_id', 'page_is_redirect = 0', 'cl_from = page_id' ),
			__METHOD__,
			array( 'LIMIT' => 1, 'ORDER BY' => 'il_from', )
		);

		$info = $res->fetchObject();
		$dbr->freeResult($res);

		return empty($info) ? null : $info->page_id;
	}

	public function getLocalUsage () {
		$target = $this->getVal('fileTitle', $this->wg->Title->getDBkey());
		$limit = $this->wg->Request->getInt('limit', 50);

		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			array( 'imagelinks', 'page' ),
			array( 'page_id', 'page_namespace', 'page_title', 'page_is_redirect', 'il_to' ),
			array( 'il_to' => $target, 'il_from = page_id' ),
			__METHOD__,
			array( 'LIMIT' => $limit, 'ORDER BY' => 'il_from', )
		);

		$summary = array();
		foreach ( $res as $row ) {
			if ( ! $row->page_is_redirect ) {
				$summary[] = array("title" => $row->page_title,
								   "id"    => $row->page_id,
								   "namespace_id" => $row->page_namespace,
								 );
			}
		}

		$this->summary = $summary;
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

<?php

/**
 * Controller for the video file page
 *
 * @author garth@wikia-inc.com
 * @author hyun@wikia-inc.com
 */

class VideoPageController extends WikiaController {

	/**
	 * Collects data about what articles the current file appears in, either
	 * locally and globally.
	 * 
	 * @requestParam string type (optional) Possible values are 'global' or 'local', defaulting to 'local' if not given.
	 *                                      Determines whether this collects a local or global file usage data
	 */
	public function fileUsage() {
		$app = F::app();

		// The 'limit' parameter is used by both usage methods we forward to as a way to limit
		// the number of rows returned.  This is a safeguard against extreme cases
		$this->setVal('limit', 50);

		$heading = '';               // The message to use for the section header
		$shortenedSummary = array(); // A subset of the data returned to show immediately
		$fileList = array();         // The list of other articles to show based on $shortenedSummary

		$type = $this->getVal('type', 'local');

		// Based on $typoe get global or local data
		if ($type === 'global') {
			$heading = wfMsg('video-page-global-file-list-header');

			// Forward to the getGlobalUsage method
			$summary = $app->sendRequest('VideoPageController', 'getGlobalUsage')->getData()['summary'];
			
			if (array_key_exists($this->wg->DBname, $summary)) {
				unset($summary[$this->wg->DBname]);
			}
			
			$count = 0;
			
			// Shorten the list to 3 articles.  We'll flesh out these three with full
			// details to display now and flesh out the others dynamically from JS when
			// the user pages forward
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

			// Shorten the list down to three articles much like above in global, but
			// here we also need to make the $shortentedSummary structure uniform to match
			// the global case
			if ($summary and count($summary)) {
				$dbName = $this->wg->DBname;
				$shortenedSummary = array($dbName => array_slice($summary, 0, 3));
			}
		}

		// Send the $shortenedSummary to fileList to flesh out the details
		$params = array('summary' => $shortenedSummary, 'type' => $type);
		$data = $app->sendRequest( 'VideoPageController', 'fileList', $params )->getData();
		$fileList = empty($data['fileList']) ? array() : $data['fileList'];

		// Set template variables
		$this->heading = $heading;
		$this->fileList = $fileList;
		$this->summary = $summary;
		$this->type = $type;
	}
	
	/**
	 * This method takes the minimum data provided in summary (at least an article title
	 * an article ID and namespace ID) and fills in additional details needed to show
	 * an image, a snippet and some links to the source article.
	 *
	 * @requestParam summary array (required) An array of associative arrays.  This data is
	 *                                        returned by fileUsage above as $summary
	 * @requestParam type string (optional) Can be 'global' or 'local'.  Defaults to 'local'.
	 *                                      Determines whether to grab summary data from the local wiki
	 *                                      or from an external wiki
	 */
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

	/**
	 * Controller to handle showing pages related to the current file.  Uses
	 * the RelatedPages extension to render the final HTML
	 */
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

	/**
	 * Controller to display a caption under the video, including provider and views
	 */
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

		// We want to find the first page that has a link to the current file page AND
		// has at least one category associated with it.  The categor(ies) are how
		// the RelatedPages extention determines what's related.  The query looks something
		// like:
		// 
		//     SELECT distinct(page_id) as page_id
		//       FROM imagelinks, page, categorylinks
		//      WHERE il_to = 'Scooby_Eats_Scooby_Snacks'
		//        AND il_from = page_id
		//        AND page_is_redirect = 0
		//        AND cl_from = page_id
		//      LIMIT 1
		$res = $dbr->select(
			array( 'imagelinks', 'page', 'categorylinks' ),
			array( 'distinct(page_id) as page_id' ),
			array( 'il_to' => $target, 'il_from = page_id', 'page_is_redirect = 0', 'cl_from = page_id' ),
			__METHOD__,
			array( 'LIMIT' => 1 )
		);

		$info = $res->fetchObject();
		$dbr->freeResult($res);

		return empty($info) ? null : $info->page_id;
	}

	/**
	 * Figure out what articles on the local wiki are using this file.
	 */
	public function getLocalUsage () {
		$target = $this->getVal('fileTitle', $this->wg->Title->getDBkey());
		$limit = $this->wg->Request->getInt('limit', 50);

		$dbr = wfGetDB( DB_SLAVE );

		// This SQL is lifted from the core file page code that shows where a file is
		// used but it couldn't be resued because it included outputing HTML.  It finds
		// pages that are referenced from imagelinks rows with our current file.
		$res = $dbr->select(
			array( 'imagelinks', 'page' ),
			array( 'page_id', 'page_namespace', 'page_title', 'page_is_redirect', 'il_to' ),
			array( 'il_to' => $target, 'il_from = page_id' ),
			__METHOD__,
			array( 'LIMIT' => $limit )
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

	/**
	 * Figure out what articles include this file from any wiki
	 */
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

	/**
	 * Add more detail for local articles to the current $data by forwarding to 
	 * the ArticleSummaryController
	 */
	public function addLocalSummary ( $data ) {
		return $this->addSummary($data, function ($dbName, $articleIds) {
			$response = $this->app->sendRequest('ArticleSummaryController', 'blurb', array('ids' => implode(',', $articleIds)));
			return $response->getData();
		});
	}

	/**
	 * Add more detail for global articles to the current $data by making HTTP requests
	 * to the other wiki URLs
	 */
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

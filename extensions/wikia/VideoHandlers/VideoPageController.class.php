<?php

class VideoPageController extends WikiaController {

	public function setupResources() {

	}

	/**
	 *
	 */
	public function fileUsage() {
		$type = $this->getVal('type', 'local');

		$query = new GlobalUsageQuery( $this->wg->Title->getDBkey() );
		if ( $this->getVal('offset') ) {
			$query->setOffset( $this->getVal('offset') );
		}
		$query->setLimit( $this->wg->Request->getInt('limit', 50) );
		$query->execute();

		$summary = $query->getSingleImageResult();

		$heading = '';
		$fileList = array();

		if(!empty($summary) ) {
			if($type === 'global') {
				$heading = wfMsg('video-page-global-file-list-header');
				if (array_key_exists($this->wg->CityId, $summary)) {
					unset($summary[$this->wg->CityId]);
				}

				$count = 0;
				foreach ($summary as $wikiID => $info) {
					$item = $info[0];
					$dbName = $item['wiki'];

					// Change the 'wiki' key from a db name to a display name
					$item['wiki'] = $this->nameToTitle($dbName);

					$summaryInfo = $this->queryGlobalSummary($dbName, array($item['id']));

					$itemInfo = $summaryInfo['summary'][$dbName][$item['id']];

					$item = array_merge($item, $itemInfo);

					$fileList[] = $item;
					$count++;
					if ($count >=3) {
						break;
					}
				}
			} else {
				$heading = wfMsg('video-page-file-list-header');
				if (array_key_exists($this->wg->CityId, $summary)) {
					$fileList = $summary[$this->wg->CityId];

					// Change the 'wiki' key from a db name to a display name
					foreach ($fileList as $data) {
						$data['wiki'] = $this->nameToTitle($data['wiki']);
					}
				}
			}
		}

		$this->heading = $heading;
		$this->fileList = $fileList;
	}

	private function nameToTitle ( $dbName ) {
		$wikiData = WikiFactory::getWikiByDB($dbName);
		return $wikiData->city_title;
	}

	public function relatedPages() {
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

	private function queryGlobalSummary( $dbName, $ids ) {
		$url = WikiFactory::DBtoURL($dbName);
		$url = WikiFactory::getLocalEnvURL($url);
		$url .= '/wikia.php?controller=ArticleSummaryController&method=blurb&format=json&ids=';
		$url .= implode(',', $ids);

		$out = Http::get($url);

		return json_decode($out, true);
	}
}

<?php

class VideoPageController extends WikiaController {

	public function setupResources() {
		
	}
	
	public function videoCaption() {
		
	}
	
	/**
	 *
	 */
	public function fileUsage() {
		$type = $this->getVal('type', 'local');

		$summary = VideoUsageService::summaryInfoByWiki($this->wg->Title->getDBkey());
		
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
					$fileList[] = $info[0];
					$count++;
					if ($count >=3) {
						break;
					}
				}
			} else {
				$heading = wfMsg('video-page-file-list-header');
				if (array_key_exists($this->wg->CityId, $summary)) {
					$fileList = $summary[$this->wg->CityId];
				}
			}

		}
		
		$this->heading = $heading;
		$this->fileList = $fileList;
	}

	public function relatedPages() {
		$titleID = 15; # Find title from one of the pages that include the current video
return;
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

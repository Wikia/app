<?php

class VideoPageController extends WikiaController {

	public function setupResources() {
		
	}
	
	public function videoCaption() {
		
	}
	
	public function fileUsage() {

	}
	
	public function globalUsage() {

	}
	
	public function relatedPages() {

		$titleID = ; # Find title from one of the pages that include the current video
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
		$text = F::app()->renderView( 'RelatedPages', 'Index', array( "altTitle" => $title ) );
	}

}
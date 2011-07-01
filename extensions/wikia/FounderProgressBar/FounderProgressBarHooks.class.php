<?php

/**
 * This class is a container for all the hooks we will use to capture actions/events for the Founder Progress Bar
 *
 */

class FounderProgressBarHooks {

	/**
	 * @desc Counts the following actions
	 * 
	 * Add 10 pages
	 * Fill out your main page
	 */
	function onArticleSaveComplete (&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {

		$app = F::app();
		//$request = $app::build("WikiaRequest");

		// Tasks related to article editing content
		if ($article->getTitle()->getNamespace() == NS_CONTENT) {
			$app->sendRequest('FounderProgressBar', 'doTask', array('task_id' => FT_TOTAL_EDIT_75));

			$app->sendRequest('FounderProgressBar', 'doTask', array('task_id' => FT_TOTAL_EDIT_300));		
		}

		if ($flags & EDIT_NEW) {
			// Tasks related to adding new pages
			$app->sendRequest('FounderProgressBar', 'doTask', array('task_id' => FT_PAGE_ADD_10));
			
			$app->sendRequest('FounderProgressBar', 'doTask', array('task_id' => FT_PAGE_ADD_20));			
		}
		// Tasks related to updating existing pages
		if ($flags & EDIT_UPDATE) {

			// if main page
				// FT_MAINPAGE_EDIT
				// FT_MAINPAGE_ADDSLIDER
			
			// if category page
			if ($article->getTitle()->getNamespace() == NS_CATEGORY) {
				$app->sendRequest('FounderProgressBar', 'doTask', array('task_id' => FT_CATEGORY_EDIT));
			}		

			// if topnav edit
			//if () {
			//$app->sendRequest('FounderProgressBar', 'doTask', array('task_id' => FT_TOPNAV_EDIT));
			//}
			
			// if wordmark edit?
			// FT_WORDMARK_EDIT

			// if topten list
			// FT_TOPTENLIST_ADD
			
			// if blogpost
			// FT_BLOGPOST_ADD
			
			// if commcorner
			// FT_COMMCORNER_EDIT

			// if page contains gallery tag
			// FT_GALLERY_ADD
			
			// if page contains video tag
			// FT_VIDEO_ADD
			
			// if profile page
			// FT_PROFILE_EDIT
			
		}
						
		return true;
	}
	
	/**
	 * @desc Counts the following actions
	 * 
	 * Adding a photo
	 * 
	 */
	function onUploadComplete (&$image) {
		$app = F::app();		
		$app->sendRequest('FounderProgressBar', 'doTask', array('task_id' => FT_PHOTO_ADD_10));
		$app->sendRequest('FounderProgressBar', 'doTask', array('task_id' => FT_PHOTO_ADD_20));
		return true;
	}
	
	function onAddNewAccount ($user) {
		$app = F::app();		
		$app->sendRequest('FounderProgressBar', 'doTask', array('task_id' => FT_USER_ADD_5));
		return true;
	}
	
	function onAddCategoryPage (&$categoryPage, &$title, &$titletext, &$sortkey) {		
		$app = F::app();		
		$app->sendRequest('FounderProgressBar', 'doTask', array('task_id' => FT_CATEGORY_ADD_3));
		$app->sendRequest('FounderProgressBar', 'doTask', array('task_id' => FT_CATEGORY_ADD_5));
		
		return true;
	}

	// Initialize schema
	function onWikiCreation ( $params ) {
		
	}
	
	// Initialize schema
	function onWikiFactoryChanged( $cv_name, $city_id, $value ) {
	}
}

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
		return true;
	}
	
	/**
	 * @desc Counts the following actions
	 * 
	 * Add a photo or gallery to the main page
	 * 
	 */
	function onUploadComplete (&$image) {
		return true;
	}
	
	/**
	 * @desc Counts the following actions
	 * 
	 * Populate the database with a starter list of tasks to complete
	 * 
	 */
	
	function onWikiCreation ($params) {
		
	}
}

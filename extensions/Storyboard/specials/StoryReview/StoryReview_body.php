<?php
/**
 * File holding the SpecialStoryReview class that allows reviewers to moderate the submitted stories.
 *
 * @file StoryReview_body.php
 * @ingroup Storyboard
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class SpecialStoryReview extends IncludableSpecialPage {

	public function __construct() {
		parent::__construct( 'StoryReview' );

		wfLoadExtensionMessages( 'Storyboard' );
	}

	public function execute( $language ) {
		global $wgUser;
		if ( $wgUser->isAllowed( 'storyreview' ) && !$wgUser->isBlocked() ) {
			// If the user has the storyreview permission and is not blocked, show the regular output.
			$this->addOutput();
		} else {
			// If the user is not authorized, show an error.
			global $wgOut;
			$wgOut->permissionRequired( 'storyreview' );
		}
	}
	
	private function addOutput() {
		global $wgOut;
		
		$wgOut->setPageTitle(wfMsg('storyboard-storyreview'));
		
		$wgOut->includeJQuery();
		
		// Get a slave db object to do read operations against.
		$dbr = wfGetDB( DB_SLAVE );
		
		// Create a query to retrieve information about all non hidden stories.
		$stories = $dbr->select(
			Storyboard_TABLE,
			array(
				'story_id',
				'story_author_name',
				'story_title',
				'story_text',
				'story_is_published'			
			),
			'story_is_hidden = 0'
		);
		
		// Arrays to hold the html segments for both the unreviewed and reviewed stories.
		$unreviewed = array();
		$reviewed = array();
		
		// Loop through all stories, get their html segments, and store in the appropriate array.
		while ($story = $dbr->fetchObject($stories)) {
			if ($story->story_is_published) {
				$reviewed = array_merge($reviewed, $this->getStorySegments($story));
			}
			else {
				$unreviewed = array_merge($unreviewed, $this->getStorySegments($story));
			}
		}
		
		// Create the page layout, and add the stories.
		$htmlSegments = array();
		$htmlSegments[] = '<h2>' . wfMsg('storyboard-unreviewed') . '</h2>';
		$htmlSegments[] = '<table width="100%">';
		$htmlSegments = array_merge($htmlSegments, $unreviewed);
		$htmlSegments[] = '</table>';
		$htmlSegments[] = '<h2>' . wfMsg('storyboard-reviewed') . '</h2>';
		$htmlSegments[] = '<table width="100%">';
		$htmlSegments = array_merge($htmlSegments, $reviewed);
		$htmlSegments[] = '</table>';			

		// Join all the html segments and add the resulting string to the page.
		$wgOut->addHTML(implode('', $htmlSegments));
	}
	
	/**
	 * Returns the html segments for a single story.
	 * 
	 * TODO: add \n's to get cleaner html output
	 * 
	 * @param $story
	 * @return array
	 */
	private function getStorySegments($story) {
		$segments = array();
		$segments[] = '<tr><td><table width="100%" border="1"><tr><td rowspan="2" width="200px">';
		$segments[] = '<img src="http://upload.wikimedia.org/wikipedia/mediawiki/9/99/SemanticMaps.png">'; // TODO: get cropped image here
		$segments[] = '</td><td><b>';
		$segments[] = $story->story_title;
		$segments[] = '</b><br />';
		$segments[] = $story->story_text;
		$segments[] = '</td></tr><tr><td align="center" height="35">';
		$segments[] = '<button type="button">'; // TODO: figure out how to best update db info (page submit with form or onclick with ajax call?)
		$segments[] = wfMsg('storyboard-publish');
		$segments[] = '</button> &nbsp;&nbsp;&nbsp; <button type="button">';
		$segments[] = wfMsg('edit');
		$segments[] = '</button> &nbsp;&nbsp;&nbsp; <button type="button">';
		$segments[] = wfMsg('hide');
		$segments[] = '</button></td></tr></table></td></tr>';	
		return $segments;
	}
}
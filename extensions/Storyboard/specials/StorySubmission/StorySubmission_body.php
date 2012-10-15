<?php
/**
 * File holding the SpecialStorySubmission class defining a special page to save submitted stories and display a success message.
 *
 * @file StorySubmission_body.php
 * @ingroup Storyboard
 * @ingroup SpecialPage
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class SpecialStorySubmission extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'StorySubmission' );
	}

	public function execute( $title ) {
		global $wgOut, $wgRequest, $wgUser;

		if ( $wgRequest->wasPosted() &&
			( $wgUser->matchEditToken( $wgRequest->getVal( 'wpStoryEditToken' ) ) || !$wgUser->isLoggedIn() )
			) {
				$title = $wgRequest->getText( 'storytitle' );
			
				// This might happen when the user has javascript disabled, or something in the client side validation breaks down.
				$exists = ApiStoryExists::StoryExists( array( 'storytitle' => $title ) );

				if ( !$exists ) {
					$this->saveStory( $title );
				}
	
				$this->displayResult( !$exists, $title );
		} else {
			$wgOut->setPageTitle( wfMsg( 'storyboard-notsubmitted' ) );
			$wgOut->returnToMain();
		}
	}

	/**
	 * Store the submitted story in the database, and return a page telling the user his story has been submitted.
	 * 
	 * @param string $title
	 */
	private function saveStory( $title ) {
		global $wgRequest, $wgUser;
		global $egStoryboardEmailSender, $egStoryboardEmailSenderName, $egStoryboardBoardUrl;
		
		$dbw = wfGetDB( DB_MASTER );
		
		$story = array(
			'story_lang_code' => $wgRequest->getText( 'lang' ),
			'story_author_name' => $wgRequest->getText( 'name' ),
			'story_author_location' => $wgRequest->getText( 'location' ),
			'story_author_occupation' => $wgRequest->getText( 'occupation' ),
			'story_author_email' => $wgRequest->getText( 'email' ),
			'story_title' => $title,
			'story_text' => $wgRequest->getText( 'storytext' ),
			'story_created' => $dbw->timestamp( time() ),
			'story_modified' => $dbw->timestamp( time() ),
		);

		// If the user is logged in, also store his user id.
		if ( $wgUser->isLoggedIn() ) {
			$story[ 'story_author_id' ] = $wgUser->getId();
		}	

		$dbw->insert( 'storyboard', $story );
		
		$to = new MailAddress( $wgRequest->getText( 'email' ), $wgRequest->getText( 'name' ) );
		$from = new MailAddress( $egStoryboardEmailSender, $egStoryboardEmailSenderName );
		$subject = wfMsg( 'storyboard-emailtitle' ); 
		$body = wfMsgExt( 'storyboard-emailbody', 'parsemag', $title, $egStoryboardBoardUrl );

		$mailer = new UserMailer();
		$mailer->send( $to, $from, $subject, $body );			
	}
	
	/**
	 * Displays the result of the submission to the user.
	 * 
	 * @param boolean $wasSaved
	 * @param string $title
	 */
	private function displayResult( $wasSaved, $title ) {
		global $wgOut, $wgTitle;
		global $egStoryboardBoardUrl;
		
		if ( $wasSaved ) {
			$wgOut->setPageTitle( wfMsg( 'storyboard-submissioncomplete' ) );
			
			// TODO: magically get location of the page containing stories
			$wgOut->addWikiMsg( 'storyboard-createdsuccessfully', $wgTitle->getFullURL() );
		} else {
			$wgOut->setPageTitle( wfMsg( 'storyboard-submissionincomplete' ) );
			
			$wgOut->addWikiMsg( 'storyboard-alreadyexists', $title, $wgTitle->getFullURL() );
			
			// Let's not give a null link to people with no JS.
			// TODO: change this to the last page somehow
			$fallBackUrl = htmlspecialchars( $egStoryboardBoardUrl );
			$wgOut->addHtml(
				"<a href=\"$fallBackUrl\" onclick='history.go(-1); return false;'>" .
				htmlspecialchars( wfMsg( 'storyboard-changetitle' ) ) .
				'</a>'
			);
		}
	}
	
}
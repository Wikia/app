<?php
/**
 * A special page for creating new polls.
 * @file
 * @ingroup Extensions
 */
class CreatePoll extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'CreatePoll' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgMemc, $wgContLang, $wgHooks, $wgSupressPageTitle, $wgPollScripts;

		$wgSupressPageTitle = true;

		// Blocked users cannot create polls
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage( false );
			return false;
		}

		// Check that the DB isn't locked
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		/**
		 * Redirect anonymous users to login page
		 * It will automatically return them to the CreatePoll page
		 */
		if( $wgUser->getID() == 0 ) {
			$wgOut->setPageTitle( wfMsgHtml( 'poll-woops' ) );
			$login = SpecialPage::getTitleFor( 'Userlogin' );
			$wgOut->redirect( $login->getLocalURL( 'returnto=Special:CreatePoll' ) );
			return false;
		}

		/**
		 * Create Poll Thresholds based on User Stats
		 */
		global $wgCreatePollThresholds;
		if( is_array( $wgCreatePollThresholds ) && count( $wgCreatePollThresholds ) > 0 ) {
			$canCreate = true;

			$stats = new UserStats( $wgUser->getID(), $wgUser->getName() );
			$stats_data = $stats->getUserStats();

			$threshold_reason = '';
			foreach( $wgCreatePollThresholds as $field => $threshold ) {
				if ( $stats_data[$field] < $threshold ) {
					$canCreate = false;
					$threshold_reason .= ( ( $threshold_reason ) ? ', ' : '' ) . "$threshold $field";
				}
			}

			if( $canCreate == false ) {
				$wgSupressPageTitle = false;
				$wgOut->setPageTitle( wfMsg( 'poll-create-threshold-title' ) );
				$wgOut->addHTML( wfMsg( 'poll-create-threshold-reason', $threshold_reason ) );
				return '';
			}
		}

		// i18n for JS
		$wgHooks['MakeGlobalVariablesScript'][] = 'CreatePoll::addJSGlobals';

		// Add CSS & JS
		$wgOut->addScriptFile( $wgPollScripts . '/Poll.js' );
		$wgOut->addExtensionStyle( $wgPollScripts . '/Poll.css' );

		// If the request was POSTed, try creating the poll
		if( $wgRequest->wasPosted() && $_SESSION['alreadysubmitted'] == false ) {
			$_SESSION['alreadysubmitted'] = true;

			// Add poll
			$poll_title = Title::makeTitleSafe( NS_POLL, $wgRequest->getVal( 'poll_question' ) );
			if( is_null( $poll_title ) && !$poll_title instanceof Title ) {
				$wgSupressPageTitle = false;
				$wgOut->setPageTitle( wfMsg( 'poll-create-threshold-title' ) );
				$wgOut->addHTML( wfMsg( 'poll-create-threshold-reason', $threshold_reason ) );
				return '';
			}

			// Put choices in wikitext (so we can track changes)
			$choices = '';
			for( $x = 1; $x <= 10; $x++ ) {
				if( $wgRequest->getVal( "answer_{$x}" ) ) {
					$choices .= $wgRequest->getVal( "answer_{$x}" ) . "\n";
				}
			}

			// Create poll wiki page
			$localizedCategoryNS = $wgContLang->getNsText( NS_CATEGORY );
			$article = new Article( $poll_title );
			$article->doEdit(
				"<userpoll>\n$choices</userpoll>\n\n[[" .
					$localizedCategoryNS . ':' .
					wfMsgForContent( 'poll-category' ) . "]]\n" .
				'[[' . $localizedCategoryNS . ':' .
					wfMsgForContent( 'poll-category-user', $wgUser->getName() ) . "]]\n" .
				'[[' . $localizedCategoryNS . ":{{subst:CURRENTMONTHNAME}} {{subst:CURRENTDAY}}, {{subst:CURRENTYEAR}}]]\n\n__NOEDITSECTION__",
				wfMsgForContent( 'poll-edit-desc' )
			);

			$newPageId = $article->getID();

			$p = new Poll();
			$poll_id = $p->addPollQuestion(
				$wgRequest->getVal( 'poll_question' ),
				$wgRequest->getVal( 'poll_image_name' ),
				$newPageId
			);

			// Add choices
			for( $x = 1; $x <= 10; $x++ ) {
				if( $wgRequest->getVal( "answer_{$x}" ) ) {
					$p->addPollChoice(
						$poll_id,
						$wgRequest->getVal( "answer_{$x}" ),
						$x
					);
				}
			}

			// Clear poll cache
			$key = wfMemcKey( 'user', 'profile', 'polls', $wgUser->getID() );
			$wgMemc->delete( $key );

			// Redirect to new poll page
			$wgOut->redirect( $poll_title->getFullURL() );
		} else {
			$_SESSION['alreadysubmitted'] = false;
			include( 'create-poll.tmpl.php' );
			$template = new CreatePollTemplate;
			$wgOut->addTemplate( $template );
		}
	}

	/**
	 * Add some new JS globals for i18n. This will be going away once we
	 * require ResourceLoader.
	 *
	 * @param $vars Array: array of pre-existing JS globals
	 * @return Boolean: true
	 */
	public static function addJSGlobals( &$vars ) {
		$vars['_POLL_CREATEPOLL_ERROR'] = wfMsg( 'poll-createpoll-error-nomore' );
		$vars['_POLL_UPLOAD_NEW'] = wfMsg( 'poll-upload-new-image' );
		$vars['_POLL_AT_LEAST'] = wfMsg( 'poll-atleast' );
		$vars['_POLL_ENTER_QUESTION'] = wfMsg( 'poll-enterquestion' );
		$vars['_POLL_HASH'] = wfMsg( 'poll-hash' );
		$vars['_POLL_PLEASE_CHOOSE'] = wfMsg( 'poll-pleasechoose' );
		$iframeTitle = SpecialPage::getTitleFor( 'PollAjaxUpload' );
		$vars['_POLL_IFRAME_URL'] = $iframeTitle->escapeFullURL( 'wpThumbWidth=75' );
		return true;
	}
}

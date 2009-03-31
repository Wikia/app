<?php

/**
 * Job for making translation fuzzy when the definition changes.
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
/*
 * Based on Tim Starling's DoubleRedirectJob.php
 */
class FuzzyJob extends Job {
	static $user;

	public static function fuzzyPages( $reason, $comment, Title $prefix ) {
		$dbr = wfGetDB( DB_SLAVE );
		$likePattern = $dbr->escapeLike( $prefix->getDBkey() ) . '/%%';

		$res = $dbr->select(
			'page',
			array( 'page_namespace', 'page_title' ),
			array(
				'page_namespace' => $prefix->getNamespace(),
				"page_title LIKE '$likePattern'"
			), __METHOD__ );
		// Nothind to update
		if ( !$res->numRows() ) return;

		$jobs = array();
		foreach ( $res as $row ) {
			$title = Title::makeTitle( $row->page_namespace, $row->page_title );
			// Should not happen, but who knows
			if ( !$title ) continue;

			$jobs[] = new self( $title, array(
				'reason' => $reason,
				'comment' => $comment ) );
		}
		Job::batchInsert( $jobs );
	}

	function __construct( $title, $params = false, $id = 0 ) {
		parent::__construct( __CLASS__, $title, $params, $id );
		$this->reason = $params['reason'];
		$this->comment = $params['comment'];
		$this->removeDuplicates = false;
	}

	function run() {
		$targetRev = Revision::newFromTitle( $this->title );
		if ( !$targetRev ) {
			wfDebug( __METHOD__ . ": target page deleted, ignoring\n" );
			return true;
		}
		$text = $targetRev->getText();

		# Add fuzzy tag if there isn't already one
		if ( strpos( $text, TRANSLATE_FUZZY ) === false ) {
			$text = TRANSLATE_FUZZY . $text;
		}

		# Add a comment to help translators to identify what has changed
		$text .= "\n" . $this->reason;

		# Save it
		global $wgUser;
		$oldUser = $wgUser;
		$wgUser = $this->getUser();
		$article = new Article( $this->title );
		$article->doEdit( $text, $this->comment, EDIT_UPDATE | EDIT_FORCE_BOT );
		$wgUser = $oldUser;

		return true;
	}

	/**
	 * Get a user object for doing edits, from a request-lifetime cache
	 */
	function getUser() {
		if ( !self::$user ) {
			global $wgTranslateFuzzyBotName;
			self::$user = User::newFromName( $wgTranslateFuzzyBotName, false );
			if ( !self::$user->isLoggedIn() ) {
				self::$user->addToDatabase();
			}
		}
		return self::$user;
	}
}


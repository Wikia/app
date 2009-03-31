<?php

/**
 * Job for updating tag translation pages when changes happen.
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class RenderJob extends Job {
	public static function renderPage( Title $source, Title $target, $user, $summary, $flags, $now = false ) {
		$job = new self( $source, array(
			'source' => $source,
			'target' => $target,
			'user' => $user,
			'summary' => $summary,
			'flags' => $flags,
		) );

		if ( $now ) $job->run();
		else Job::batchInsert( array( $job ) );
	}

	function __construct( $title, $params = false, $id = 0 ) {
		parent::__construct( __CLASS__, $title, $params, $id );
		$this->params = $params;
		$this->removeDuplicates = true;
	}

	function run() {
		global $wgUser;

		$source  = $this->params['source'];
		$target  = $this->params['target'];
		$user    = User::newFromName( $this->params['user'] );
		$summary = $this->params['summary'];
		$flags   = $this->params['flags'];

		list( , $code ) = TranslateTagUtils::keyAndCode( $target );

		// Try to get the text of the page
		$text = TranslateTagUtils::getTagPageSource( $source );
		if ( $text === null ) return;

		// Construct a translated page
		$tag = TranslateTag::getInstance();
		$text = $tag->renderPage( $text, $source, $code );
		$text .= '<translate />'; // hint that we know to set the parser language

		# Save it
		$oldUser = $wgUser;
		$wgUser = $user;
		$article = new Article( $target );
		$article->doEdit( $text, $summary, $flags );
		$wgUser = $oldUser;

		return true;
	}

	/**
	 * Get a user object for doing edits, from a request-lifetime cache
	 */
	function getUser() {
		return User::newFromName( $this->params['user'], false );
	}
}


<?php

/**
 * Job for updating translation pages.
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class RenderJob extends Job {
	public static function newJob( Title $target ) {
		global $wgTranslateFuzzyBotName;
		wfLoadExtensionMessages( 'PageTranslation' );

		$job = new self( $target );
		$job->setUser( $wgTranslateFuzzyBotName );
		$job->setFlags( EDIT_FORCE_BOT );
		$job->setSummary( wfMsgForContent( 'tpt-render-summary' ) );
		return $job;
	}

	function __construct( $title, $params = array(), $id = 0 ) {
		parent::__construct( __CLASS__, $title, $params, $id );
		$this->params = $params;
		$this->removeDuplicates = true;
	}

	function run() {
		// Initialization
		$title = $this->title;
		list( $key, $code ) = TranslateUtils::figureMessage( $title->getPrefixedText() );

		// Return the actual translation page...
		$page = TranslatablePage::isTranslationPage( $title );
		if ( !$page ) {
			var_dump( $this->params );
			var_dump( $title );
			throw new MWException( "Oops, this should not happen!" );
		}

		$group = MessageGroups::getGroup( "page|$key" );
		$collection = $group->initCollection( $code );

		// Muck up the text
		$text = $page->getParse()->getTranslationPageText( $collection );
		// Same as in renderSourcePage
		$cb = array( __CLASS__, 'replaceTagCb' );
		$text = preg_replace_callback( '~(\n?<translate>\s*?)(.*?)(\s*?</translate>)~s', $cb, $text );

		// Other stuff
		$user    = $this->getUser();
		$summary = $this->getSummary();
		$flags   = $this->getFlags();

		$article = new Article( $title );

		// TODO: fuzzybot hack
		PageTranslationHooks::$allowTargetEdit = true;

		// User hack
		global $wgUser;
		$oldUser = $wgUser;
		$wgUser = $user;

		// Do the edit
		$article->doEdit( $text, $summary, $flags );

		// User hack
		$wgUser = $oldUser;

		PageTranslationHooks::$allowTargetEdit = false;

		// purge cache
		$page->getTranslationPercentages( true );

		return true;
	}

	public static function replaceTagCb( $matches ) {
		return $matches[2];
	}

	public function setFlags( $flags ) {
		$this->params['flags'] = $flags;
	}

	public function getFlags() {
		return $this->params['flags'];
	}


	public function setSummary( $summary ) {
		$this->params['summary'] = $summary;
	}

	public function getSummary() {
		return $this->params['summary'];
	}


	public function setUser( $user ) {
		if ( $user instanceof User ) {
			$this->params['user'] = $user->getName();
		} else {
			$this->params['user'] = $user;
		}
	}
	/**
	 * Get a user object for doing edits.
	 */
	public function getUser() {
		return User::newFromName( $this->params['user'], false );
	}
}


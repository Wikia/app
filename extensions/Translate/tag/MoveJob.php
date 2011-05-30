<?php
/**
 * Contains class with job for moving translation pages.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Contains class with job for moving translation pages.
 *
 * @ingroup PageTranslation JobQueue
 * @todo Get rid of direct reference to $wgMemc.
 */
class MoveJob extends Job {
	public static function newJob( Title $source, Title $target, $base, /*User*/ $performer ) {
		global $wgTranslateFuzzyBotName;

		$job = new self( $source );
		$job->setUser( $wgTranslateFuzzyBotName );
		$job->setTarget( $target->getPrefixedText() );
		$job->setSummary( wfMsgForContent( 'pt-movepage-logreason', $target->getPrefixedText() ) );
		$job->setBase( $base );
		$job->setPerformer( $performer );
		$job->lock();
		return $job;
	}

	function __construct( $title, $params = array(), $id = 0 ) {
		parent::__construct( __CLASS__, $title, $params, $id );
	}

	function run() {
		global $wgUser;

		// Initialization
		$title = $this->title;
		// Other stuff
		$user    = $this->getUser();
		$summary = $this->getSummary();
		$target  = $this->getTarget();
		$base    = $this->getBase();

		PageTranslationHooks::$allowTargetEdit = true;
		$oldUser = $wgUser;
		$wgUser = $user;
		self::forceRedirects( false );

		// Don't check perms, don't leave a redirect
		$ok = $title->moveTo( $target, false, $summary, false );
		if ( !$ok ) {
			$logger = new LogPage( 'pagetranslation' );
			$params = array(
				'user' => $this->getPerformer(),
				'target' => $target->getPrefixedText(),
				'error' => base64_encode( serialize( $ok ) ), // This is getting ridiculous
			);
			$doer = User::newFromName( $this->getPerformer() );
			$logger->addEntry( 'movenok', $title, null, array( serialize( $params ) ), $doer );
		}

		self::forceRedirects( true );
		PageTranslationHooks::$allowTargetEdit = false;

		$this->unlock();

		global $wgMemc;
		$pages = (array) $wgMemc->get( wfMemcKey( 'pt-base', $base ) );
		$last = true;

		foreach ( $pages as $page ) {
			if ( $wgMemc->get( wfMemcKey( 'pt-lock', $page ) ) === true ) {
				$last = false;
				break;
			}
		}

		if ( $last )  {
			$wgMemc->delete( wfMemcKey( 'pt-base', $base ) );
			$logger = new LogPage( 'pagetranslation' );
			$params = array( 'user' => $this->getPerformer() );
			$doer = User::newFromName( $this->getPerformer() );
			$logger->addEntry( 'moveok', Title::newFromText( $base ), null, array( serialize( $params ) ), $doer );
		}

		$wgUser = $oldUser;

		return true;
	}

	public function setSummary( $summary ) {
		$this->params['summary'] = $summary;
	}

	public function getSummary() {
		return $this->params['summary'];
	}

	public function setBase( $base ) {
		$this->params['base'] = $base;
	}

	public function getBase() {
		return $this->params['base'];
	}

	public function setPerformer( $performer ) {
		if ( is_object( $performer ) ) {
			$this->params['performer'] = $performer->getName();
		} else {
			$this->params['performer'] = $performer;
		}
	}

	public function getPerformer() {
		return $this->params['performer'];
	}

	public function setTarget( $target ) {
		if ( $target instanceof Title ) {
			$this->params['target'] = $target->getPrefixedText();
		} else {
			$this->params['target'] = $target;
		}
	}

	public function getTarget() {
		return Title::newFromText( $this->params['target'] );
	}

	public function setUser( $user ) {
		if ( is_object( $user ) ) {
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

	public function lock() {
		global $wgMemc;
		$wgMemc->set( wfMemcKey( 'pt-lock', $this->title->getPrefixedText() ), true, 60 * 60 * 6 );
		$wgMemc->set( wfMemcKey( 'pt-lock', $this->getTarget()->getPrefixedText() ), true, 60 * 60 * 6 );
	}

	public function unlock() {
		global $wgMemc;
		$wgMemc->delete( wfMemcKey( 'pt-lock', $this->title->getPrefixedText() ) );
		$wgMemc->delete( wfMemcKey( 'pt-lock', $this->getTarget()->getPrefixedText() ) );
	}

	/**
	 * Adapted from wfSuppressWarnings to allow not leaving redirects.
	 */
	public static function forceRedirects( $end = false ) {
		static $suppressCount = 0;
		static $originalLevel = null;

		global $wgGroupPermissions;
		global $wgUser;

		if ( $end ) {
			if ( $suppressCount ) {
				--$suppressCount;
				if ( !$suppressCount ) {
					if ( $originalLevel === null ) {
						unset( $wgGroupPermissions['*']['suppressredirect'] );
					} else {
						$wgGroupPermissions['*']['suppressredirect'] = $originalLevel;
					}
				}
			}
		} else {
			if ( !$suppressCount ) {
				$originalLevel = isset( $wgGroupPermissions['*']['suppressredirect'] ) ? $wgGroupPermissions['*']['suppressredirect'] : null;
				$wgGroupPermissions['*']['suppressredirect'] = true;
			}
			++$suppressCount;
		}
		$wgUser->clearInstanceCache();
	}
}

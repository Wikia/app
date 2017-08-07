<?php

namespace Captcha;

use Captcha\Factory;
use Wikia\Logger\WikiaLogger;

class Handler extends \WikiaObject {

	// Number of seconds after a bad login that a captcha will be shown to that client on the login
	// form to slow down password-guessing bots. Set to five minutes.
	const BAD_LOGIN_TTL = 300;

	// Number of bad login attempts before triggering the captcha.  0 means the captcha is presented
	// on the first login.
	const MAX_BAD_LOGIN_ATTEMPTS = 3;

	protected $action;

	protected $trigger;

	/** @var \Captcha\Module\BaseCaptcha */
	protected $captcha;

	public function __construct() {
		$this->captcha = Factory\Module::getInstance();
		parent::__construct();
	}

	/**
	 * Inject whazawhoo
	 *
	 * @fixme if multiple thingies insert a header, could break
	 * https://wikia-inc.atlassian.net/browse/SOC-289
	 *
	 * @param \HTMLForm $form
	 *
	 * @return bool whether to keep running callbacks
	 */
	public function injectEmailUser( \HTMLForm $form ) {
		if ( $this->wg->CaptchaTriggers['sendemail'] ) {
			if ( $this->wg->User->isAllowed( 'skipcaptcha' ) ) {
				$this->log( "user group allows skipping captcha on email sending\n" );
				return true;
			}
			$form->addFooterText(
				"<div class='captcha'>" .
				$this->wg->Out->parse( $this->captcha->getMessage( 'sendemail' ) ) .
				$this->captcha->getForm() .
				"</div>\n" );
		}
		return true;
	}

	/**
	 * Inject whazawhoo
	 *
	 * @fixme if multiple thingies insert a header, could break
	 * https://wikia-inc.atlassian.net/browse/SOC-289
	 *
	 * @param \QuickTemplate $template
	 *
	 * @return bool whether to keep running callbacks
	 */
	public function injectUserCreate( \QuickTemplate $template ): bool {
		if ( $this->wg->CaptchaTriggers['createaccount'] ) {
			if ( $this->wg->User->isAllowed( 'skipcaptcha' ) ) {
				$this->log( "user group allows skipping captcha on account creation\n" );
				return true;
			}

			$message = '';
			\Hooks::run( 'GetConfirmEditMessage', [ $this, &$message ] );
			if ( empty( $message ) ) {
				$message = $this->captcha->getMessage( 'createaccount' );
			}
			$template->set( 'captcha',
				"<div class='captcha'>" .
				$this->captcha->getForm() .
				'<p class="captchadesc" >' . $message . '</p>' .
				"</div>\n" );
		}
		return true;
	}

	/**
	 * Inject a captcha into the user login form after a failed
	 * password attempt as a speedbump for mass attacks.
	 *
	 * @fixme if multiple thingies insert a header, could break
	 * https://wikia-inc.atlassian.net/browse/SOC-289
	 *
	 * @param \QuickTemplate $template
	 *
	 * @return bool whether to keep running callbacks
	 */
	public function injectUserLogin( \QuickTemplate $template ): bool {
		if ( $this->isBadLoginTriggered() ) {
			$template->set( 'header',
				"<div class='captcha'>" .
				\F::app()->wg->Out->parse( $this->captcha->getMessage( 'badlogin' ) ) .
				$this->captcha->getForm() .
				"</div>\n" );
		}
		return true;
	}

	/**
	 * When a bad login attempt is made, increment an expiring counter
	 * in the memcache cloud. Later checks for this may trigger a
	 * captcha display to prevent too many hits from the same place.
	 *
	 * @param \User $user
	 * @param string $password
	 * @param int $retval authentication return value
	 *
	 * @return bool whether to keep running callbacks
	 */
	public function triggerUserLogin( $user, $password, $retval ) {
		if ( $retval == \LoginForm::WRONG_PASS && $this->wg->CaptchaTriggers['badlogin'] ) {
			$key = $this->badLoginKey();
			$count = $this->wg->Memc->get( $key );
			if ( !$count ) {
				$this->wg->Memc->add( $key, 0, self::BAD_LOGIN_TTL );
			}
			$this->wg->Memc->incr( $key );
		}
		return true;
	}

	/**
	 * Check if a bad login has already been registered for this
	 * IP address. If so, require a captcha.
	 *
	 * @return bool
	 */
	private function isBadLoginTriggered() {
		if ( empty( $this->wg->CaptchaTriggers['badlogin'] ) ) {
			return false;
		}

		$loginAttempts = $this->wg->Memc->get( $this->badLoginKey() );
		return $loginAttempts >= self::MAX_BAD_LOGIN_ATTEMPTS;
	}

	/**
	 * Check if the IP is allowed to skip captchas
	 */
	public function isIPWhitelisted() {
		if ( $this->wg->CaptchaWhitelistIP ) {
			$ip = $this->wg->Request->getIP();

			foreach ( $this->wg->CaptchaWhitelistIP as $range ) {
				if ( \IP::isInRange( $ip, $range ) ) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Internal cache key for 'badlogin' checks.
	 *
	 * @return string
	 */
	private function badLoginKey() {
		$ip = \F::app()->wg->Request->getIP();
		return wfMemcKey( 'captcha', 'badlogin', 'ip', $ip );
	}

	/**
	 * @param \EditPage $editPage
	 * @param string $action (edit/create/addurl...)
	 *
	 * @return bool true if action triggers captcha on editPage's namespace
	 */
	public function captchaTriggers( &$editPage, $action ) {
		$ns = $editPage->mTitle->getNamespace();

		// Special config for this NS?
		if ( isset( $this->wg->CaptchaTriggersOnNamespace[$ns][$action] ) ) {
			return $this->wg->CaptchaTriggersOnNamespace[$ns][$action];
		}

		return ( !empty( $this->wg->CaptchaTriggers[$action] ) ); // Default
	}

	/**
	 * @param \EditPage $editPage
	 * @param string $newText
	 * @param string $section
	 * @param bool $merged
	 *
	 * @return bool true if the captcha should run
	 */
	public function shouldCheck( \EditPage $editPage, $newText, $section, $merged = false ): bool {
		$this->trigger = '';
		$title = $editPage->mArticle->getTitle();

		if ( $this->wg->User->isAllowed( 'skipcaptcha' ) ) {
			$this->log( "user group allows skipping captcha\n" );
			return false;
		}

		if ( $this->isIPWhitelisted() ) {
			return false;
		}

		if ( $this->wg->EmailAuthentication && $this->wg->AllowConfirmedEmail &&
			$this->wg->User->isEmailConfirmed() ) {
			$this->log( "user has confirmed mail, skipping captcha\n" );
			return false;
		}

		if ( $this->captchaTriggers( $editPage, 'edit' ) ) {
			// Check on all edits
			$this->trigger = sprintf( "edit trigger by '%s' at [[%s]]",
				$this->wg->User->getName(),
				$title->getPrefixedText() );
			$this->action = 'edit';
			$this->log( "checking all edits...\n" );
			return true;
		}

		if ( $this->captchaTriggers( $editPage, 'create' ) && !$editPage->mTitle->exists() ) {
			// Check if creating a page
			$this->trigger = sprintf( "Create trigger by '%s' at [[%s]]",
				$this->wg->User->getName(),
				$title->getPrefixedText() );
			$this->action = 'create';
			$this->log( "checking on page creation...\n" );
			return true;
		}

		if ( $this->captchaTriggers( $editPage, 'addurl' ) ) {
			// Only check edits that add URLs
			if ( $merged ) {
				// Get links from the database
				$oldLinks = $this->getLinksFromTracker( $title );
				// Share a parse operation with Article::doEdit()
				$editInfo = $editPage->mArticle->prepareTextForEdit( $newText );
				$newLinks = array_keys( $editInfo->output->getExternalLinks() );
			} else {
				// Get link changes in the slowest way known to man
				$oldText = $this->loadText( $editPage, $section );
				$oldLinks = $this->findLinks( $editPage, $oldText );
				$newLinks = $this->findLinks( $editPage, $newText );
			}

			$unknownLinks = array_filter( $newLinks, [ $this, 'filterLink' ] );
			$addedLinks = array_diff( $unknownLinks, $oldLinks );
			$numLinks = count( $addedLinks );

			if ( $numLinks > 0 ) {
				$this->trigger = sprintf( "%dx url trigger by '%s' at [[%s]]: %s",
					$numLinks,
					$this->wg->User->getName(),
					$title->getPrefixedText(),
					implode( ", ", $addedLinks ) );
				$this->action = 'addurl';
				return true;
			}
		}

		if ( $this->wg->CaptchaRegexes ) {
			// Custom regex checks
			$oldText = $this->loadText( $editPage, $section );

			foreach ( $this->wg->CaptchaRegexes as $regex ) {
				$newMatches = [];
				if ( preg_match_all( $regex, $newText, $newMatches ) ) {
					$oldMatches = [];
					preg_match_all( $regex, $oldText, $oldMatches );

					$addedMatches = array_diff( $newMatches[0], $oldMatches[0] );

					$numHits = count( $addedMatches );
					if ( $numHits > 0 ) {
						$this->trigger = sprintf( "%dx %s at [[%s]]: %s",
							$numHits,
							$regex,
							$this->wg->User->getName(),
							$title->getPrefixedText(),
							implode( ", ", $addedMatches ) );
						$this->action = 'edit';
						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Filter callback function for URL whitelisting
	 *
	 * @param string $url URL to check
	 *
	 * @return bool true if unknown, false if whitelisted
	 */
	private function filterLink( $url ) {
		$source = wfMessage( 'captcha-addurl-whitelist' )->inContentLanguage()->text();

		$whitelist = wfEmptyMsg( 'captcha-addurl-whitelist' )
			? false
			: $this->buildRegexes( explode( "\n", $source ) );

		$cwl = $this->wg->CaptchaWhitelist !== false ? preg_match( $this->wg->CaptchaWhitelist, $url ) : false;
		$wl = $whitelist !== false ? preg_match( $whitelist, $url ) : false;

		return !( $cwl || $wl );
	}

	/**
	 * Build regex from white-list
	 *
	 * @param string[] $lines Lines from [[MediaWiki:Captcha-addurl-whitelist]]
	 *
	 * @return string Regex or bool false if white-list is empty
	 */
	private function buildRegexes( $lines ) {
		# Code duplicated from the SpamBlacklist extension (r19197)

		# Strip comments and whitespace, then remove blanks
		$lines = array_filter( array_map( 'trim', preg_replace( '/#.*$/', '', $lines ) ) );

		# No lines, don't make a regex which will match everything
		if ( count( $lines ) == 0 ) {
			$this->log( "No lines\n" );
			return false;
		} else {
			# Make regex
			# It's faster using the S modifier even though it will usually only be run once
			// $regex = 'http://+[a-z0-9_\-.]*(' . implode( '|', $lines ) . ')';
			// return '/' . str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $regex) ) . '/Si';
			$regexes = '';
			$regexStart = '/^https?:\/\/+[a-z0-9_\-.]*(';
			$regexEnd = ')/Si';
			$regexMax = 4096;
			$build = false;
			foreach ( $lines as $line ) {
				// FIXME: not very robust size check, but should work. :)
				if ( $build === false ) {
					$build = $line;
				} elseif ( strlen( $build ) + strlen( $line ) > $regexMax ) {
					$regexes .= $regexStart .
						str_replace( '/', '\/', preg_replace( '|\\\*/|', '/', $build ) ) .
						$regexEnd;
					$build = $line;
				} else {
					$build .= '|' . $line;
				}
			}
			if ( $build !== false ) {
				$regexes .= $regexStart .
					str_replace( '/', '\/', preg_replace( '|\\\*/|', '/', $build ) ) .
					$regexEnd;
			}
			return $regexes;
		}
	}

	/**
	 * Load external links from the externallinks table
	 *
	 * @param \Title $title
	 *
	 * @return array
	 */
	public function getLinksFromTracker( $title ) {
		$dbr = wfGetDB( DB_SLAVE );
		$id = $title->getArticleID(); // should be zero queries
		$res = $dbr->select(
			'externallinks',
			[ 'el_to' ],
			[ 'el_from' => $id ],
			__METHOD__
		);
		$links = [];
		foreach ( $res as $row ) {
			/** @var \stdClass $row */
			$links[] = $row->el_to;
		}
		return $links;
	}

	/**
	 * Backend function for confirmEdit() and confirmEditAPI()
	 *
	 * @param \EditPage $editPage
	 * @param string $newText
	 * @param string $section
	 * @param bool $merged
	 *
	 * @return bool false if the CAPTCHA is rejected, true otherwise
	 */
	private function doConfirmEdit( $editPage, $newText, $section, $merged = false ) {
		if ( $this->wg->Request->getVal( 'captchaid' ) ) {
			$this->wg->Request->setVal( 'wpCaptchaId', $this->wg->Request->getVal( 'captchaid' ) );
		}
		if ( $this->wg->Request->getVal( 'captchaword' ) ) {
			$this->wg->Request->setVal( 'wpCaptchaWord', $this->wg->Request->getVal( 'captchaword' ) );
		}
		if ( $this->shouldCheck( $editPage, $newText, $section, $merged ) ) {
			return Factory\Module::getInstance()->passCaptcha();
		} else {
			$this->log( "no need to show captcha.\n" );
			return true;
		}
	}

	/**
	 * The main callback run on edit attempts.
	 *
	 * @param \EditPage $editPage
	 * @param string $newText
	 * @param string $section
	 * @param bool $merged
	 *
	 * @return bool true to continue saving, false to abort and show a captcha form
	 */
	public function confirmEdit( $editPage, $newText, $section, $merged = false ) {
		if ( defined( 'MW_API' ) ) {
			# API mode
			# The CAPTCHA was already checked and approved
			return true;
		}

		$result = null;
		$hookParams = [ $this, $editPage, $newText, $section, $merged, &$result ];
		if ( !\Hooks::run( 'ConfirmEdit::onConfirmEdit', $hookParams ) ) {
			return $result;
		}

		if ( !$this->doConfirmEdit( $editPage, $newText, $section, $merged ) ) {
			$editPage->showEditForm( [ $this, 'editCallback' ] );
			return false;
		}
		return true;
	}

	/**
	 * Insert the captcha prompt into an edit form.
	 *
	 * @param \OutputPage $out
	 */
	public function editCallback( \OutputPage $out ) {
		$out->addWikiText( $this->captcha->getMessage( $this->action ) );
		$out->addHTML( $this->captcha->getForm() );
	}

	/**
	 * A more efficient edit filter callback based on the text after section merging
	 *
	 * @param \EditPage $editPage
	 * @param string $newText
	 *
	 * @return bool
	 */
	public function confirmEditMerged( $editPage, $newText ) {
		return $this->confirmEdit( $editPage, $newText, false, true );
	}

	public function confirmEditAPI( $editPage, $newText, &$resultArr ) {
		if ( !$this->doConfirmEdit( $editPage, $newText, false, false ) ) {
			$this->captcha->addCaptchaAPI( $resultArr );
			return false;
		}

		return true;
	}

	/**
	 * Hook for user creation form submissions.
	 *
	 * @param \User $u
	 * @param string $message
	 *
	 * @return bool true to continue, false to abort user creation
	 */
	public function confirmUserCreate( $u, &$message ) {
		if ( $this->wg->CaptchaTriggers['createaccount'] ) {
			if ( $this->isIPWhitelisted() )
				return true;

			$this->trigger = "new account '" . $u->getName() . "'";
			if ( !$this->captcha->passCaptcha() ) {
				$message = wfMessage( 'captcha-createaccount-fail' )->escaped();
				return false;
			}
		}
		return true;
	}

	/**
	 * Check the captcha on Special:EmailUser
	 *
	 * @param \MailAddress $from
	 * @param \MailAddress $to
	 * @param string $subject
	 * @param string $text
	 * @param string $error reference
	 *
	 * @return Bool true to continue saving, false to abort and show a captcha form
	 */
	public function confirmEmailUser( $from, $to, $subject, $text, &$error ) {
		if ( $this->wg->CaptchaTriggers['sendemail'] ) {
			if ( $this->wg->User->isAllowed( 'skipcaptcha' ) ) {
				$this->log( "user group allows skipping captcha on email sending\n" );
				return true;
			}
			if ( $this->isIPWhitelisted() ) {
				return true;
			}

			if ( defined( 'MW_API' ) ) {
				# API mode
				# Asking for captchas in the API is really silly
				$error = wfMessage( 'captcha-disabledinapi' )->escaped();
				return false;
			}
			$this->trigger = "{$this->wg->User->getName()} sending email";
			if ( !$this->captcha->passCaptcha() ) {
				$error = wfMessage( 'captcha-sendemail-fail' )->escaped();
				return false;
			}
		}
		return true;
	}

	/**
	 * Log the status and any triggering info for debugging or statistics
	 *
	 * @param string $message
	 */
	public function log( $message ) {
		$log = WikiaLogger::instance();
		$log->info( 'Captcha: ' . $message, [
			'action' => $this->action,
			'detail' => $this->trigger,
		] );
	}

	/**
	 * Retrieve the current version of the page or section being edited...
	 *
	 * @param \EditPage $editPage
	 * @param string $section
	 *
	 * @return string
	 */
	private function loadText( $editPage, $section ) {
		$rev = \Revision::newFromTitle( $editPage->mTitle );
		if ( is_null( $rev ) ) {
			return "";
		} else {
			$text = $rev->getText();
			if ( $section != '' ) {
				return \F::app()->wg->Parser->getSection( $text, $section );
			} else {
				return $text;
			}
		}
	}

	/**
	 * Extract a list of all recognized HTTP links in the text.
	 *
	 * @param \EditPage $editPage
	 * @param string $text
	 *
	 * @return array of strings
	 */
	public function findLinks( \EditPage $editPage, $text ) {
		$options = new \ParserOptions();
		$text = $this->wg->Parser->preSaveTransform( $text, $editPage->mTitle, $this->wg->User, $options );
		$out = $this->wg->Parser->parse( $text, $editPage->mTitle, $options );

		return array_keys( $out->getExternalLinks() );
	}
}

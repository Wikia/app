<?php

namespace Captcha\Modules;

use Wikia\Logger\WikiaLogger;
use Captcha;

/**
 * Class CaptchaBase
 */
abstract class BaseCaptcha {

	/** @var string */
	private $action;

	/** @var string */
	private $trigger;

	/**
	 * Returns whether the the catpcha type is valid for the current request.  The main reason a captcha may be
	 * invalid currently is if the captcha implementation is blocked, e.g. China blocking Google
	 *
	 * @return bool
	 */
	public static function isValid() {
		return false;
	}

	/**
	 * Adds/updates keys in $resultArr['captcha'].  These values are used to display the captcha to the user
	 *
	 * @param $resultArr
	 */
	abstract public function addCaptchaAPI( &$resultArr );

	/**
	 * Insert a captcha prompt into the edit form.
	 * This sample implementation generates a simple arithmetic operation;
	 * it would be easy to defeat by machine.
	 *
	 * Override this!
	 *
	 * @return string HTML
	 */
	abstract public function getForm();

	/**
	 * Insert the captcha prompt into an edit form.
	 *
	 * @param \OutputPage $out
	 */
	function editCallback( &$out ) {
		$out->addWikiText( $this->getMessage( $this->action ) );
		$out->addHTML( $this->getForm() );
	}

	abstract public function getMessage( $action );

	/**
	 * Show a message asking the user to enter a captcha on edit.  The result will be treated as wiki text.
	 * Modules should list out the messages keys they will send here to assist grepping for i18n strings.
	 *
	 * @param string $captchaModule The captcha module besing used
	 * @param string $action Action being performed
	 * @return string
	 */
	public function getModuleMessage( $captchaModule, $action ) {
		$name = $captchaModule . '-' . $action;
		$text = wfMessage( $name )->escaped();

		// Obtain a more tailored message, if possible, otherwise, fall back to the default for edits
		return wfMessage( $name )->isBlank() ? wfMessage( $captchaModule . '-edit' )->escaped() : $text;
	}

	/**
	 * Inject whazawhoo
	 * @fixme if multiple thingies insert a header, could break
	 * @param \HTMLForm $form
	 * @return bool true to keep running callbacks
	 */
	function injectEmailUser( &$form ) {
		$wg = \F::app()->wg;

		if ( $wg->CaptchaTriggers['sendemail'] ) {
			if ( $wg->User->isAllowed( 'skipcaptcha' ) ) {
				wfDebug( "ConfirmEdit: user group allows skipping captcha on email sending\n" );
				return true;
			}
			$form->addFooterText(
				"<div class='captcha'>" .
				$wg->Out->parse( $this->getMessage( 'sendemail' ) ) .
				$this->getForm() .
				"</div>\n" );
		}
		return true;
	}

	/**
	 * Inject whazawhoo
	 * @fixme if multiple thingies insert a header, could break
	 *
	 * @param \QuickTemplate $template
	 *
	 * @return bool true to keep running callbacks
	 */
	function injectUserCreate( &$template ) {
		$wg = \F::app()->wg;

		if ( $wg->CaptchaTriggers['createaccount'] ) {
			if ( $wg->User->isAllowed( 'skipcaptcha' ) ) {
				wfDebug( "ConfirmEdit: user group allows skipping captcha on account creation\n" );
				return true;
			}

			$message = '';
			wfRunHooks( 'GetConfirmEditMessage', [ $this, &$message ] );
			if ( empty( $message ) ) {
				$message = $this->getMessage( 'createaccount' );
			}
			$template->set( 'captcha',
				"<div class='captcha'>" .
				$this->getForm() .
				'<p class="captchadesc" >' . $message . '</p>' .
				"</div>\n" );
		}
		return true;
	}

	/**
	 * Inject a captcha into the user login form after a failed
	 * password attempt as a speedbump for mass attacks.
	 * @fixme if multiple thingies insert a header, could break
	 *
	 * @param \QuickTemplate $template
	 *
	 * @return bool true to keep running callbacks
	 */
	function injectUserLogin( &$template ) {
		if ( $this->isBadLoginTriggered() ) {
			$template->set( 'header',
				"<div class='captcha'>" .
				\F::app()->wg->Out->parse( $this->getMessage( 'badlogin' ) ) .
				$this->getForm() .
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
	 * @return bool true to keep running callbacks
	 */
	function triggerUserLogin( $user, $password, $retval ) {
		$wg = \F::app()->wg;

		if ( $retval == \LoginForm::WRONG_PASS && $wg->CaptchaTriggers['badlogin'] ) {
			$key = $this->badLoginKey();
			$count = $wg->Memc->get( $key );
			if ( !$count ) {
				$wg->Memc->add( $key, 0, $wg->CaptchaBadLoginExpiration );
			}
			$wg->Memc->incr( $key );
		}
		return true;
	}

	/**
	 * Check if a bad login has already been registered for this IP address. If so, require a captcha.
	 *
	 * @return bool
	 */
	private function isBadLoginTriggered() {
		$wg = \F::app()->wg;
		return (
			$wg->CaptchaTriggers['badlogin'] &&
			intval( $wg->Memc->get( $this->badLoginKey() ) ) >= $wg->CaptchaBadLoginAttempts
		);
	}

	/**
	 * Check if the IP is allowed to skip captchas
	 *
	 * @return bool
	 */
	public function isIPWhitelisted() {
		$wg = \F::app()->wg;
		if ( $wg->CaptchaWhitelistIP ) {
			$ip = $wg->Request->getIP();

			foreach ( $wg->CaptchaWhitelistIP as $range ) {
				if ( \IP::isInRange( $ip, $range ) ) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Internal cache key for badlogin checks.
	 *
	 * @return string
	 */
	private function badLoginKey() {
		$ip = \F::app()->wg->Request->getIP();
		return wfMemcKey( 'captcha', 'badlogin', 'ip', $ip );
	}

	/**
	 * Check if the submitted form matches the captcha session data provided
	 * by the plugin when the form was generated.  This method is required if passCaptcha
	 * is not overridden.
	 *
	 * @param string $answer
	 * @param array $info
	 *
	 * @return bool
	 */
	public function keyMatch( $answer, $info ) {
		return false;
	}

	/**
	 * @param \EditPage $editPage
	 * @param string $action (edit/create/addurl...)
	 *
	 * @return bool True if action triggers captcha on editPage's namespace
	 */
	function captchaTriggers( &$editPage, $action ) {
		$wg = \F::app()->wg;
		$ns = $editPage->mTitle->getNamespace();

		// Special config for this NS?
		if ( isset( $wg->CaptchaTriggersOnNamespace[$ns][$action] ) )
			return $wg->CaptchaTriggersOnNamespace[$ns][$action];

		// Default to trigger for action on all namespaces
		return !empty( $wg->CaptchaTriggers[$action] );
	}

	/**
	 * @param \EditPage $editPage
	 * @param string $newtext
	 * @param string $section
	 * @return bool true if the captcha should run
	 */
	function shouldCheck( &$editPage, $newtext, $section, $merged = false ) {
		$this->trigger = '';

		if ( $this->isWhiteListed() ) {
			return false;
		}

		if ( $this->canSkipOnConfirmedEmail() ) {
			wfDebug( "ConfirmEdit: user has confirmed mail, skipping captcha\n" );
			return false;
		}

		if ( $this->isTriggeredByEdit( $editPage ) ) {
			return true;
		}

		if ( $this->isTriggeredByCreate( $editPage ) ) {
			return true;
		}

		if ( $this->isTriggerByURL( $editPage, $newtext, $section, $merged ) ) {
			return true;
		}

		if ( $this->isTriggeredByRegex( $editPage, $newtext, $section ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Return whether the current user has been whitelisted for some reason
	 *
	 * @return bool
	 */
	protected function isWhiteListed() {
		if ( \F::app()->wg->User->isAllowed( 'skipcaptcha' ) ) {
			wfDebug( "ConfirmEdit: user group allows skipping captcha\n" );
			return true;
		}

		if ( $this->isIPWhitelisted() ) {
			return true;
		}

		return false;
	}

	/**
	 * Determine if skipping captcha for users with confirmed emails is enabled and if so, whether the current user
	 * has a confirmed email.
	 *
	 * @return bool
	 */
	protected function canSkipOnConfirmedEmail() {
		$wg = \F::app()->wg;
		return (
			$wg->EmailAuthentication &&
			$wg->AllowConfirmedEmail &&
			$wg->User->isEmailConfirmed()
		);
	}

	/**
	 * Determine if a captcha should be triggered because of a page edit
	 *
	 * @param $editPage
	 *
	 * @return bool
	 */
	protected function isTriggeredByEdit( $editPage ) {
		$wg = \F::app()->wg;
		/** @var \Title $title */
		$title = $editPage->mArticle->getTitle();

		if ( $this->captchaTriggers( $editPage, 'edit' ) ) {
			// Check on all edits
			$this->trigger = sprintf(
				"edit trigger by '%s' at [[%s]]",
				$wg->User->getName(),
				$title->getPrefixedText()
			);
			$this->action = 'edit';
			wfDebug( "ConfirmEdit: checking all edits...\n" );
			return true;
		}

		return false;
	}

	/**
	 * Determine if a captcha should be triggered because of a page create
	 *
	 * @param $editPage
	 *
	 * @return bool
	 */
	protected function isTriggeredByCreate( $editPage ) {
		$wg = \F::app()->wg;
		/** @var \Title $title */
		$title = $editPage->mArticle->getTitle();

		if ( $this->captchaTriggers( $editPage, 'create' )  && !$editPage->mTitle->exists() ) {
			// Check if creating a page
			$this->trigger = sprintf( "Create trigger by '%s' at [[%s]]",
				$wg->User->getName(),
				$title->getPrefixedText() );
			$this->action = 'create';
			wfDebug( "ConfirmEdit: checking on page creation...\n" );
			return true;
		}

		return false;
	}

	/**
	 * Determine if a captcha should be triggered because an anonymous edit included a URL in the text
	 *
	 * @param $editPage
	 * @param $newtext
	 * @param $section
	 * @param $merged
	 *
	 * @return bool
	 */
	protected function isTriggerByURL( $editPage, $newtext, $section, $merged ) {

		if ( !$this->captchaTriggers( $editPage, 'addurl' ) ) {
			return false;
		}

		// Only check edits that add URLs
		$addedLinks = $this->getAddedLinks( $editPage, $newtext, $section, $merged );
		$numLinks = count( $addedLinks );

		if ( $numLinks > 0 ) {
			$wg = \F::app()->wg;
			/** @var \Title $title */
			$title = $editPage->mArticle->getTitle();

			$this->trigger = sprintf(
				"%dx url trigger by '%s' at [[%s]]: %s",
				$numLinks,
				$wg->User->getName(),
				$title->getPrefixedText(),
				implode( ', ', $addedLinks )
			);
			$this->action = 'addurl';
			return true;
		}

		return false;
	}

	/**
	 * Return an array of links added by this edit
	 *
	 * @param $editPage
	 * @param $newtext
	 * @param $section
	 * @param $merged
	 *
	 * @return array
	 */
	protected function getAddedLinks( $editPage, $newtext, $section, $merged ) {
		$title = $editPage->mArticle->getTitle();

		// Only check edits that add URLs
		if ( $merged ) {
			// Get links from the database
			$oldLinks = $this->getLinksFromTracker( $title );
			// Share a parse operation with Article::doEdit()
			$editInfo = $editPage->mArticle->prepareTextForEdit( $newtext );
			$newLinks = array_keys( $editInfo->output->getExternalLinks() );
		} else {
			// Get link changes in the slowest way known to man
			$oldtext = $this->loadText( $editPage, $section );
			$oldLinks = $this->findLinks( $editPage, $oldtext );
			$newLinks = $this->findLinks( $editPage, $newtext );
		}

		$unknownLinks = array_filter( $newLinks, [ &$this, 'filterLink' ] );
		return array_diff( $unknownLinks, $oldLinks );
	}

	/**
	 * Determine if the text of the edit matches any triggering text based on a list of regular expressions in
	 * $wgCaptchaRegexes.
	 *
	 * @param $editPage
	 * @param $newtext
	 * @param $section
	 *
	 * @return bool
	 */
	protected function isTriggeredByRegex( $editPage, $newtext, $section ) {
		$wg = \F::app()->wg;

		if ( empty( $wg->CaptchaRegexes ) ) {
			return false;
		}

		// Custom regex checks
		$oldtext = $this->loadText( $editPage, $section );

		foreach ( $wg->CaptchaRegexes as $regex ) {

			if ( preg_match_all( $regex, $newtext, $newMatches ) ) {

				preg_match_all( $regex, $oldtext, $oldMatches );

				$addedMatches = array_diff( $newMatches[0], $oldMatches[0] );

				$numHits = count( $addedMatches );
				if ( $numHits > 0 ) {
					/** @var \Title $title */
					$title = $editPage->mArticle->getTitle();

					$this->trigger = sprintf(
						"%dx %s at [[%s]]: %s",
						$numHits,
						$regex,
						$wg->User->getName(),
						$title->getPrefixedText(),
						implode( ", ", $addedMatches )
					);
					$this->action  = 'edit';

					return true;
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
		$wg = \F::app()->wg;

		$source = wfMessage( 'captcha-addurl-whitelist' )->inContentLanguage()->escaped();

		$whitelist = wfEmptyMsg( 'captcha-addurl-whitelist', $source )
			? false
			: $this->buildRegexes( explode( "\n", $source ) );

		$cwl = $wg->CaptchaWhitelist !== false ? preg_match( $wg->CaptchaWhitelist, $url ) : false;
		$wl = $whitelist !== false ? preg_match( $whitelist, $url ) : false;

		return !( $cwl || $wl );
	}

	/**
	 * Build regex from whitelist
	 *
	 * @param string $lines line from [[MediaWiki:Captcha-addurl-whitelist]]
	 *
	 * @return string Regex or bool false if whitelist is empty
	 */
	private function buildRegexes( $lines ) {
		# Code duplicated from the SpamBlacklist extension (r19197)

		# Strip comments and whitespace, then remove blanks
		$lines = array_filter( array_map( 'trim', preg_replace( '/#.*$/', '', $lines ) ) );

		# No lines, don't make a regex which will match everything
		if ( count( $lines ) == 0 ) {
			wfDebug( "No lines\n" );
			return false;
		}

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

	/**
	 * Load external links from the externallinks table
	 * @param \Title $title
	 *
	 * @return Array
	 */
	function getLinksFromTracker( $title ) {
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
	 * @return bool false if the CAPTCHA is rejected, true otherwise
	 */
	private function doConfirmEdit( $editPage, $newtext, $section, $merged = false ) {
		global $wgRequest;
		if ( $wgRequest->getVal( 'captchaid' ) ) {
			$wgRequest->setVal( 'wpCaptchaId', $wgRequest->getVal( 'captchaid' ) );
		}
		if ( $wgRequest->getVal( 'captchaword' ) ) {
			$wgRequest->setVal( 'wpCaptchaWord', $wgRequest->getVal( 'captchaword' ) );
		}
		if ( $this->shouldCheck( $editPage, $newtext, $section, $merged ) ) {
			return $this->passCaptcha();
		} else {
			wfDebug( "ConfirmEdit: no need to show captcha.\n" );
			return true;
		}
	}

	/**
	 * The main callback run on edit attempts.
	 *
	 * @param \EditPage $editPage
	 * @param string $newtext
	 * @param string $section
	 * @param bool $merged
	 *
	 * @return bool true to continue saving, false to abort and show a captcha form
	 */
	public function confirmEdit( $editPage, $newtext, $section, $merged = false ) {
		if ( defined( 'MW_API' ) ) {
			# API mode
			# The CAPTCHA was already checked and approved
			return true;
		}

		$result = null;
		$hookParams = [ &$this, &$editPage, $newtext, $section, $merged, &$result ];
		if ( !wfRunHooks( 'ConfirmEdit::onConfirmEdit', $hookParams ) ) {
			return $result;
		}

		if ( !$this->doConfirmEdit( $editPage, $newtext, $section, $merged ) ) {
			$editPage->showEditForm( [ &$this, 'editCallback' ] );
			return false;
		}
		return true;
	}

	/**
	 * A more efficient edit filter callback based on the text after section merging.  Called via hook.
	 *
	 * @param \EditPage $editPage
	 * @param string $newtext
	 *
	 * @return bool
	 */
	public function confirmEditMerged( $editPage, $newtext ) {
		return $this->confirmEdit( $editPage, $newtext, false, true );
	}

	/**
	 * Called via hook.
	 *
	 * @param $editPage
	 * @param $newtext
	 * @param $resultArr
	 *
	 * @return bool
	 */
	public function confirmEditAPI( $editPage, $newtext, &$resultArr ) {
		if ( !$this->doConfirmEdit( $editPage, $newtext, false, false ) ) {
			$this->addCaptchaAPI( $resultArr );
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
	function confirmUserCreate( $u, &$message ) {
		if ( \F::app()->wg->CaptchaTriggers['createaccount'] ) {
			if ( $this->isIPWhitelisted() )
				return true;

			$this->trigger = "new account '" . $u->getName() . "'";
			if ( !$this->passCaptcha() ) {
				$message = wfMsg( 'captcha-createaccount-fail' );
				return false;
			}
		}
		return true;
	}

	/**
	 * Hook for user login form submissions.
	 *
	 * @param \User $u
	 * @param string $pass
	 * @param int $retval
	 *
	 * @return bool true to continue, false to abort user creation
	 */
	function confirmUserLogin( $u, $pass, &$retval ) {
		if ( $this->isBadLoginTriggered() ) {
			if ( $this->isIPWhitelisted() )
				return true;

			$this->trigger = "post-badlogin login '" . $u->getName() . "'";
			if ( !$this->passCaptcha() ) {
				// Emulate a bad-password return to confuse the shit out of attackers
				$retval = \LoginForm::WRONG_PASS;
				return false;
			}
		}
		return true;
	}

	/**
	 * Check the captcha on Special:EmailUser
	 *
	 * @param string $from MailAddress
	 * @param string $to MailAddress
	 * @param string $subject
	 * @param string $text
	 * @param string $error reference
	 *
	 * @return Bool true to continue saving, false to abort and show a captcha form
	 */
	function confirmEmailUser( $from, $to, $subject, $text, &$error ) {
		$wg = \F::app()->wg;

		if ( $wg->CaptchaTriggers['sendemail'] ) {
			if ( $wg->User->isAllowed( 'skipcaptcha' ) ) {
				wfDebug( "ConfirmEdit: user group allows skipping captcha on email sending\n" );
				return true;
			}
			if ( $this->isIPWhitelisted() )
				return true;

			if ( defined( 'MW_API' ) ) {
				# API mode
				# Asking for captchas in the API is really silly
				$error = wfMessage( 'captcha-disabledinapi' )->escaped();
				return false;
			}
			$this->trigger = "{$wg->User->getName()} sending email";
			if ( !$this->passCaptcha() ) {
				$error = wfMessage( 'captcha-sendemail-fail' )->escaped();
				return false;
			}
		}
		return true;
	}

	/**
	 * @param \ApiEditPage $module
	 * @param $params array
	 *
	 * @return bool
	 */
	public function APIGetAllowedParams( &$module, &$params ) {
		if ( !$module instanceof \ApiEditPage ) {
			return true;
		}
		$params['captchaword'] = null;
		$params['captchaid'] = null;

		return true;
	}

	/**
	 * @param \ApiEditPage $module
	 * @param $desc array
	 * @return bool
	 */
	public function APIGetParamDescription( &$module, &$desc ) {
		if ( !$module instanceof \ApiEditPage ) {
			return true;
		}
		$desc['captchaid'] = 'CAPTCHA ID from previous request';
		$desc['captchaword'] = 'Answer to the CAPTCHA';

		return true;
	}

	/**
	 * Given a required captcha run, test form input for correct
	 * input on the open session.
	 *
	 * @return bool if passed, false if failed or new session
	 */
	 public function passCaptcha() {
		$info = $this->retrieveCaptcha();
		if ( $info ) {
			global $wgRequest;
			if ( $this->keyMatch( $wgRequest->getVal( 'wpCaptchaWord' ), $info ) ) {
				$this->log( "passed" );
				$this->clearCaptcha( $info );
				return true;
			} else {
				$this->clearCaptcha( $info );
				$this->log( "bad form input" );
				return false;
			}
		} else {
			$this->log( "new captcha session" );
			return false;
		}
	}

	/**
	 * Log the status and any triggering info for debugging or statistics
	 *
	 * @param string $message
	 */
	public function log( $message ) {
		$log = WikiaLogger::instance();
		$log->info( "Captcha: $message", [
			'trigger' => $this->trigger,
			'action' => $this->action,
		] );
	}

	/**
	 * Generate a captcha session ID and save the info in PHP's session storage.
	 * (Requires the user to have cookies enabled to get through the captcha.)
	 *
	 * A random ID is used so legit users can make edits in multiple tabs or
	 * windows without being unnecessarily hobbled by a serial order requirement.
	 * Pass the returned id value into the edit form as wpCaptchaId.
	 *
	 * @param array $info data to store
	 * @return string captcha ID key
	 */
	function storeCaptcha( $info ) {
		if ( !isset( $info['index'] ) ) {
			// Assign random index if we're not updating
			$info['index'] = strval( mt_rand() );
		}
		Captcha\Store::get()->store( $info['index'], $info );
		return $info['index'];
	}

	/**
	 * Fetch this session's captcha info.
	 *
	 * @return mixed array of info, or false if missing
	 */
	public function retrieveCaptcha() {
		global $wgRequest;
		$index = $wgRequest->getVal( 'wpCaptchaId' );
		return Captcha\Store::get()->retrieve( $index );
	}

	/**
	 * Clear out existing captcha info from the session, to ensure
	 * it can't be reused.
	 *
	 * @param array $info
	 */
	public function clearCaptcha( Array $info ) {
		Captcha\Store::get()->clear( $info['index'] );
	}

	/**
	 * Retrieve the current version of the page or section being edited...
	 *
	 * @param \EditPage $editPage
	 * @param string $section
	 *
	 * @return string
	 */
	private function loadText( \EditPage $editPage, $section ) {
		$rev = \Revision::newFromTitle( $editPage->mTitle );
		if ( is_null( $rev ) ) {
			return '';
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
	 * @param \EditPage $editpage
	 * @param string $text
	 *
	 * @return array of strings
	 */
	public function findLinks( \EditPage &$editpage, $text ) {
		$wg = \F::app()->wg;

		$options = new \ParserOptions();
		$text = $wg->Parser->preSaveTransform( $text, $editpage->mTitle, $wg->User, $options );
		$out = $wg->Parser->parse( $text, $editpage->mTitle, $options );

		return array_keys( $out->getExternalLinks() );
	}

	/**
	 * Show a page explaining what this wacky thing is.
	 */
	public function showHelp() {
		$wg = \F::app()->wg;

		$wg->Out->setPageTitle( wfMessage( 'captchahelp-title' )->escaped() );
		$wg->Out->addWikiText( wfMessage( 'captchahelp-text' )->escaped() );
		if ( Captcha\Store::get()->cookiesNeeded() ) {
			$wg->Out->addWikiText( wfMessage( 'captchahelp-cookies-needed' )->escaped() );
		}
	}
}

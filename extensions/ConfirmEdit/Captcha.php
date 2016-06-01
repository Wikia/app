<?php

class SimpleCaptcha {

	function getCaptcha() {
		$a = mt_rand( 0, 100 );
		$b = mt_rand( 0, 10 );

		/* Minus sign is used in the question. UTF-8,
		   since the api uses text/plain, not text/html */
		$op = mt_rand( 0, 1 ) ? '+' : '−';

		// No space before and after $op, to ensure correct
		// directionality.
		$test = "$a$op$b";
		$answer = ( $op == '+' ) ? ( $a + $b ) : ( $a - $b );
		return array( 'question' => $test, 'answer' => $answer );
	}

	function addCaptchaAPI( &$resultArr ) {
		$captcha = $this->getCaptcha();
		$index = $this->storeCaptcha( $captcha );
		$resultArr['captcha']['type'] = 'simple';
		$resultArr['captcha']['mime'] = 'text/plain';
		$resultArr['captcha']['id'] = $index;
		$resultArr['captcha']['question'] = $captcha['question'];
	}

	/**
	 * Insert a captcha prompt into the edit form.
	 * This sample implementation generates a simple arithmetic operation;
	 * it would be easy to defeat by machine.
	 *
	 * Override this!
	 *
	 * @return string HTML
	 */
	function getForm() {
		$captcha = $this->getCaptcha();
		$index = $this->storeCaptcha( $captcha );

		return "<p><label for=\"wpCaptchaWord\">{$captcha['question']}</label> = " .
			Xml::element( 'input', array(
				'name' => 'wpCaptchaWord',
				'id'   => 'wpCaptchaWord',
				'tabindex' => 1 ) ) . // tab in before the edit textarea
			"</p>\n" .
			Xml::element( 'input', array(
				'type'  => 'hidden',
				'name'  => 'wpCaptchaId',
				'id'    => 'wpCaptchaId',
				'value' => $index ) );
	}

	/**
	 * Insert the captcha prompt into an edit form.
	 * @param OutputPage $out
	 */
	function editCallback( &$out ) {
		$out->addWikiText( $this->getMessage( $this->action ) );
		$out->addHTML( $this->getForm() );
	}

	/**
	 * Show a message asking the user to enter a captcha on edit
	 * The result will be treated as wiki text
	 *
	 * @param $action Action being performed
	 * @return string
	 */
	function getMessage( $action ) {
		$name = 'captcha-' . $action;
		$text = wfMsg( $name );
		# Obtain a more tailored message, if possible, otherwise, fall back to
		# the default for edits
		return wfEmptyMsg( $name, $text ) ? wfMsg( 'captcha-edit-confirmedit' ) : $text;
	}

	/**
	 * Inject whazawhoo
	 * @fixme if multiple thingies insert a header, could break
	 * @param $form HTMLForm
	 * @return bool true to keep running callbacks
	 */
	function injectEmailUser( &$form ) {
		global $wgCaptchaTriggers, $wgOut, $wgUser;
		if ( $wgCaptchaTriggers['sendemail'] ) {
			if ( $wgUser->isAllowed( 'skipcaptcha' ) ) {
				wfDebug( "ConfirmEdit: user group allows skipping captcha on email sending\n" );
				return true;
			}
			$form->addFooterText(
				"<div class='captcha'>" .
				$wgOut->parse( $this->getMessage( 'sendemail' ) ) .
				$this->getForm() .
				"</div>\n" );
		}
		return true;
	}

	/**
	 * Inject whazawhoo
	 * @fixme if multiple thingies insert a header, could break
	 * @param QuickTemplate $template
	 * @return bool true to keep running callbacks
	 */
	function injectUserCreate( &$template ) {
		global $wgCaptchaTriggers, $wgOut, $wgUser;
		if ( $wgCaptchaTriggers['createaccount'] ) {
			if ( $wgUser->isAllowed( 'skipcaptcha' ) ) {
				wfDebug( "ConfirmEdit: user group allows skipping captcha on account creation\n" );
				return true;
			}
			/* Wikia change - begin */
			$message = '';
			wfRunHooks( 'GetConfirmEditMessage', array( $this, &$message) );
			if ( empty($message) ) {
				$message = $this->getMessage( 'createaccount' );
			}
			$template->set( 'captcha',
				"<div class='captcha'>" .
				$this->getForm() .
				'<p class="captchadesc" >' . $message .'</p>'.
				"</div>\n" );
			/* Wikia change - end */
		}
		return true;
	}

	/**
	 * Inject a captcha into the user login form after a failed
	 * password attempt as a speedbump for mass attacks.
	 * @fixme if multiple thingies insert a header, could break
	 * @param $template QuickTemplate
	 * @return bool true to keep running callbacks
	 */
	function injectUserLogin( &$template ) {
		if ( $this->isBadLoginTriggered() ) {
			global $wgOut;
			$template->set( 'header',
				"<div class='captcha'>" .
				$wgOut->parse( $this->getMessage( 'badlogin' ) ) .
				$this->getForm() .
				"</div>\n" );
		}
		return true;
	}

	/**
	 * When a bad login attempt is made, increment an expiring counter
	 * in the memcache cloud. Later checks for this may trigger a
	 * captcha display to prevent too many hits from the same place.
	 * @param User $user
	 * @param string $password
	 * @param int $retval authentication return value
	 * @return bool true to keep running callbacks
	 */
	function triggerUserLogin( $user, $password, $retval ) {
		global $wgCaptchaTriggers, $wgCaptchaBadLoginExpiration, $wgMemc;
		if ( $retval == LoginForm::WRONG_PASS && $wgCaptchaTriggers['badlogin'] ) {
			$key = $this->badLoginKey();
			$count = $wgMemc->get( $key );
			if ( !$count ) {
				$wgMemc->add( $key, 0, $wgCaptchaBadLoginExpiration );
			}
			$count = $wgMemc->incr( $key );
		}
		return true;
	}

	/**
	 * Check if a bad login has already been registered for this
	 * IP address. If so, require a captcha.
	 * @return bool
	 * @access private
	 */
	function isBadLoginTriggered() {
		global $wgMemc, $wgCaptchaTriggers, $wgCaptchaBadLoginAttempts;
		return $wgCaptchaTriggers['badlogin'] && intval( $wgMemc->get( $this->badLoginKey() ) ) >= $wgCaptchaBadLoginAttempts;
	}

	/**
	 * Check if the IP is allowed to skip captchas
	 */
	function isIPWhitelisted() {
		global $wgCaptchaWhitelistIP;

		if ( $wgCaptchaWhitelistIP ) {
			global $wgRequest;

			// Compat: WebRequest::getIP is only available since MW 1.19.
			$ip = method_exists( $wgRequest, 'getIP' ) ? $wgRequest->getIP() : wfGetIP();

			foreach ( $wgCaptchaWhitelistIP as $range ) {
				if ( IP::isInRange( $ip, $range ) ) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Internal cache key for badlogin checks.
	 * @return string
	 * @access private
	 */
	function badLoginKey() {
		global $wgRequest;
		// Compat: WebRequest::getIP is only available since MW 1.19.
		$ip = method_exists( $wgRequest, 'getIP' ) ? $wgRequest->getIP() : wfGetIP();
		return wfMemcKey( 'captcha', 'badlogin', 'ip', $ip );
	}

	/**
	 * Check if the submitted form matches the captcha session data provided
	 * by the plugin when the form was generated.
	 *
	 * Override this!
	 *
	 * @param string $answer
	 * @param array $info
	 * @return bool
	 */
	function keyMatch( $answer, $info ) {
		return $answer == $info['answer'];
	}

	// ----------------------------------

	/**
	 * @param EditPage $editPage
	 * @param string $action (edit/create/addurl...)
	 * @return bool true if action triggers captcha on editPage's namespace
	 */
	function captchaTriggers( &$editPage, $action ) {
		global $wgCaptchaTriggers, $wgCaptchaTriggersOnNamespace;
		// Special config for this NS?
		if ( isset( $wgCaptchaTriggersOnNamespace[$editPage->mTitle->getNamespace()][$action] ) )
			return $wgCaptchaTriggersOnNamespace[$editPage->mTitle->getNamespace()][$action];

		return ( !empty( $wgCaptchaTriggers[$action] ) ); // Default
	}

	/**
	 * @param EditPage $editPage
	 * @param string $newtext
	 * @param string $section
	 * @return bool true if the captcha should run
	 */
	function shouldCheck( &$editPage, $newtext, $section, $merged = false ) {
		$this->trigger = '';
		$title = $editPage->mArticle->getTitle();

		global $wgUser;
		if ( $wgUser->isAllowed( 'skipcaptcha' ) ) {
			wfDebug( "ConfirmEdit: user group allows skipping captcha\n" );
			return false;
		}
		if ( $this->isIPWhitelisted() )
			return false;


		global $wgEmailAuthentication, $ceAllowConfirmedEmail;
		if ( $wgEmailAuthentication && $ceAllowConfirmedEmail &&
			$wgUser->isEmailConfirmed() ) {
			wfDebug( "ConfirmEdit: user has confirmed mail, skipping captcha\n" );
			return false;
		}

		if ( $this->captchaTriggers( $editPage, 'edit' ) ) {
			// Check on all edits
			global $wgUser;
			$this->trigger = sprintf( "edit trigger by '%s' at [[%s]]",
				$wgUser->getName(),
				$title->getPrefixedText() );
			$this->action = 'edit';
			wfDebug( "ConfirmEdit: checking all edits...\n" );
			return true;
		}

		if ( $this->captchaTriggers( $editPage, 'create' )  && !$editPage->mTitle->exists() ) {
			// Check if creating a page
			global $wgUser;
			$this->trigger = sprintf( "Create trigger by '%s' at [[%s]]",
				$wgUser->getName(),
				$title->getPrefixedText() );
			$this->action = 'create';
			wfDebug( "ConfirmEdit: checking on page creation...\n" );
			return true;
		}

		if ( $this->captchaTriggers( $editPage, 'addurl' ) ) {
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

			$unknownLinks = array_filter( $newLinks, array( &$this, 'filterLink' ) );
			$addedLinks = array_diff( $unknownLinks, $oldLinks );
			$numLinks = count( $addedLinks );

			if ( $numLinks > 0 ) {
				global $wgUser;
				$this->trigger = sprintf( "%dx url trigger by '%s' at [[%s]]: %s",
					$numLinks,
					$wgUser->getName(),
					$title->getPrefixedText(),
					implode( ", ", $addedLinks ) );
				$this->action = 'addurl';
				return true;
			}
		}

		global $wgCaptchaRegexes;
		if ( $wgCaptchaRegexes ) {
			// Custom regex checks
			$oldtext = $this->loadText( $editPage, $section );

			foreach ( $wgCaptchaRegexes as $regex ) {
				$newMatches = array();
				if ( preg_match_all( $regex, $newtext, $newMatches ) ) {
					$oldMatches = array();
					preg_match_all( $regex, $oldtext, $oldMatches );

					$addedMatches = array_diff( $newMatches[0], $oldMatches[0] );

					$numHits = count( $addedMatches );
					if ( $numHits > 0 ) {
						global $wgUser;
						$this->trigger = sprintf( "%dx %s at [[%s]]: %s",
							$numHits,
							$regex,
							$wgUser->getName(),
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
	 * @param string url to check
	 * @return bool true if unknown, false if whitelisted
	 * @access private
	 */
	function filterLink( $url ) {
		global $wgCaptchaWhitelist;
		$source = wfMsgForContent( 'captcha-addurl-whitelist-confirmedit' );

		$whitelist = wfEmptyMsg( 'captcha-addurl-whitelist-confirmedit', $source )
			? false
			: $this->buildRegexes( explode( "\n", $source ) );

		$cwl = $wgCaptchaWhitelist !== false ? preg_match( $wgCaptchaWhitelist, $url ) : false;
		$wl  = $whitelist          !== false ? preg_match( $whitelist, $url )          : false;

		return !( $cwl || $wl );
	}

	/**
	 * Build regex from whitelist
	 * @param string lines from [[MediaWiki:captcha-addurl-whitelist-confirmedit]]
	 * @return string Regex or bool false if whitelist is empty
	 * @access private
	 */
	function buildRegexes( $lines ) {
		# Code duplicated from the SpamBlacklist extension (r19197)

		# Strip comments and whitespace, then remove blanks
		$lines = array_filter( array_map( 'trim', preg_replace( '/#.*$/', '', $lines ) ) );

		# No lines, don't make a regex which will match everything
		if ( count( $lines ) == 0 ) {
			wfDebug( "No lines\n" );
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
	 * @param $title Title
	 * @return Array
	 */
	function getLinksFromTracker( $title ) {
		$dbr = wfGetDB( DB_SLAVE );
		$id = $title->getArticleID(); // should be zero queries
		$res = $dbr->select( 'externallinks', array( 'el_to' ),
			array( 'el_from' => $id ), __METHOD__ );
		$links = array();
		foreach ( $res as $row ) {
			$links[] = $row->el_to;
		}
		return $links;
	}

	/**
	 * Backend function for confirmEdit() and confirmEditAPI()
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
	 * @param EditPage $editPage
	 * @param string $newtext
	 * @param string $section
	 * @param bool $merged
	 * @return bool true to continue saving, false to abort and show a captcha form
	 */
	function confirmEdit( $editPage, $newtext, $section, $merged = false ) {
		if ( defined( 'MW_API' ) ) {
			# API mode
			# The CAPTCHA was already checked and approved
			return true;
		}

		#<Wikia>
		$result = null;
		if( !wfRunHooks( 'ConfirmEdit::onConfirmEdit', array( &$this, &$editPage, $newtext, $section, $merged, &$result ) ) ) {
			return $result;
		}
		#</Wikia>

		if ( !$this->doConfirmEdit( $editPage, $newtext, $section, $merged ) ) {
			$editPage->showEditForm( array( &$this, 'editCallback' ) );
			return false;
		}
		return true;
	}

	/**
	 * A more efficient edit filter callback based on the text after section merging
	 * @param EditPage $editPage
	 * @param string $newtext
	 */
	function confirmEditMerged( $editPage, $newtext ) {
		return $this->confirmEdit( $editPage, $newtext, false, true );
	}

	function confirmEditAPI( $editPage, $newtext, &$resultArr ) {
		if ( !$this->doConfirmEdit( $editPage, $newtext, false, false ) ) {
			$this->addCaptchaAPI( $resultArr );
			return false;
		}

		return true;
	}

	/**
	 * Hook for user creation form submissions.
	 * @param User $u
	 * @param string $message
	 * @return bool true to continue, false to abort user creation
	 */
	function confirmUserCreate( $u, &$message ) {
		global $wgCaptchaTriggers, $wgUser;
		if ( $wgCaptchaTriggers['createaccount'] ) {
			/*	Wikia edit, fbId::47248 No one will be allowed to skip captcha for user creation.
				Commenting this section out, but feel free to uncomment it if situation changes.
			if ( $wgUser->isAllowed( 'skipcaptcha' ) ) {
				wfDebug( "ConfirmEdit: user group allows skipping captcha on account creation\n" );
				return true;
			}
			end Wikia edit fbId::47248 */
			if ( $this->isIPWhitelisted() )
				return true;

			$this->trigger = "new account '" . $u->getName() . "'";
			if ( !$this->passCaptcha() ) {
				$message = wfMsg( 'captcha-createaccount-fail-confirmedit' );
				return false;
			}
		}
		return true;
	}

	/**
	 * Hook for user login form submissions.
	 * @param User $u
	 * @param string $message
	 * @return bool true to continue, false to abort user creation
	 */
	function confirmUserLogin( $u, $pass, &$retval ) {
		if ( $this->isBadLoginTriggered() ) {
			if ( $this->isIPWhitelisted() )
				return true;

			$this->trigger = "post-badlogin login '" . $u->getName() . "'";
			if ( !$this->passCaptcha() ) {
				// Emulate a bad-password return to confuse the shit out of attackers
				$retval = LoginForm::WRONG_PASS;
				return false;
			}
		}
		return true;
	}

	/**
	 * Check the captcha on Special:EmailUser
	 * @param $from MailAddress
	 * @param $to MailAddress
	 * @param $subject String
	 * @param $text String
	 * @param $error String reference
	 * @return Bool true to continue saving, false to abort and show a captcha form
	 */
	function confirmEmailUser( $from, $to, $subject, $text, &$error ) {
		global $wgCaptchaTriggers, $wgUser;
		if ( $wgCaptchaTriggers['sendemail'] ) {
			if ( $wgUser->isAllowed( 'skipcaptcha' ) ) {
				wfDebug( "ConfirmEdit: user group allows skipping captcha on email sending\n" );
				return true;
			}
			if ( $this->isIPWhitelisted() )
				return true;

			if ( defined( 'MW_API' ) ) {
				# API mode
				# Asking for captchas in the API is really silly
				$error = wfMsg( 'captcha-disabledinapi-confirmedit' );
				return false;
			}
			$this->trigger = "{$wgUser->getName()} sending email";
			if ( !$this->passCaptcha() ) {
				$error = wfMsg( 'captcha-sendemail-fail-confirmedit' );
				return false;
			}
		}
		return true;
	}

	/**
	 * @param $module ApiBase
	 * @param $params array
	 * @return bool
	 */
	public function APIGetAllowedParams( &$module, &$params ) {
		if ( !$module instanceof ApiEditPage ) {
			return true;
		}
		$params['captchaword'] = null;
		$params['captchaid'] = null;

		return true;
	}

	/**
	 * @param $module ApiBae
	 * @param $desc array
	 * @return bool
	 */
	public function APIGetParamDescription( &$module, &$desc ) {
		if ( !$module instanceof ApiEditPage ) {
			return true;
		}
		$desc['captchaid'] = 'CAPTCHA ID from previous request';
		$desc['captchaword'] = 'Answer to the CAPTCHA';

		return true;
	}

	/**
	 * Given a required captcha run, test form input for correct
	 * input on the open session.
	 * @return bool if passed, false if failed or new session
	 */
	function passCaptcha() {
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
	 * @param string $message
	 */
	function log( $message ) {
		wfDebugLog( 'captcha', 'ConfirmEdit: ' . $message . '; ' .  $this->trigger );
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
			// Assign random index if we're not udpating
			$info['index'] = strval( mt_rand() );
		}
		CaptchaStore::get()->store( $info['index'], $info );
		return $info['index'];
	}

	/**
	 * Fetch this session's captcha info.
	 * @return mixed array of info, or false if missing
	 */
	function retrieveCaptcha() {
		global $wgRequest;
		$index = $wgRequest->getVal( 'wpCaptchaId' );
		return CaptchaStore::get()->retrieve( $index );
	}

	/**
	 * Clear out existing captcha info from the session, to ensure
	 * it can't be reused.
	 */
	function clearCaptcha( $info ) {
		CaptchaStore::get()->clear( $info['index'] );
	}

	/**
	 * Retrieve the current version of the page or section being edited...
	 * @param EditPage $editPage
	 * @param string $section
	 * @return string
	 * @access private
	 */
	function loadText( $editPage, $section ) {
		$rev = Revision::newFromTitle( $editPage->mTitle );
		if ( is_null( $rev ) ) {
			return "";
		} else {
			$text = $rev->getText();
			if ( $section != '' ) {
				global $wgParser;
				return $wgParser->getSection( $text, $section );
			} else {
				return $text;
			}
		}
	}

	/**
	 * Extract a list of all recognized HTTP links in the text.
	 * @param string $text
	 * @return array of strings
	 */
	function findLinks( &$editpage, $text ) {
		global $wgParser, $wgUser;

		$options = new ParserOptions();
		$text = $wgParser->preSaveTransform( $text, $editpage->mTitle, $wgUser, $options );
		$out = $wgParser->parse( $text, $editpage->mTitle, $options );

		return array_keys( $out->getExternalLinks() );
	}

	/**
	 * Show a page explaining what this wacky thing is.
	 */
	function showHelp() {
		global $wgOut;
		$wgOut->setPageTitle( wfMsg( 'captchahelp-title' ) );
		$wgOut->addWikiText( wfMsg( 'captchahelp-text-confirmedit' ) );
		if ( CaptchaStore::get()->cookiesNeeded() ) {
			$wgOut->addWikiText( wfMsg( 'captchahelp-cookies-needed-confirmedit' ) );
		}
	}
}

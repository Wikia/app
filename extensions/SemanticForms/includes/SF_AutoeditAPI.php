<?php
/**
 * File holding the SFAutoEditAPI class
 *
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticForms
 */

/**
 * The SF_AutoEditAPI class.
 *
 * @ingroup SemanticForms
 */
class SFAutoeditAPI extends ApiBase {

	const ACTION_FORMEDIT = 0;
	const ACTION_SAVE = 1;
	const ACTION_PREVIEW = 2;
	const ACTION_DIFF = 3;

	/**
	 * Error level used when a non-recoverable error occurred.
	 */
	const ERROR = 0;

	/**
	 * Error level used when a recoverable error occurred.
	 */
	const WARNING = 1;

	/**
	 * Error level used to give information that might be of interest to the user.
	 */
	const NOTICE = 2;

	/**
	 * Error level used for debug messages.
	 */
	const DEBUG = 3;

	private $mOptions = array( );
	private $mAction;
	private $mStatus;

	/**
	 * Converts an options string into an options array and stores it
	 *
	 * @param string $options
	 * @return the options array
	 */
	function addOptionsFromString( $options ) {
		return $this->parseDataFromQueryString( $this->mOptions, $options );
	}

	/**
	 * Returns the options array
	 */
	function getOptions() {
		return $this->mOptions;
	}

	/**
	 * Returns the action performed by the module.
	 *
	 * Return value is either null or one of ACTION_SAVE, ACTION_PREVIEW,
	 * ACTION_FORMEDIT
	 *
	 * @return null|number
	 */
	function getAction() {
		return $this->mAction;
	}

	/**
	 * Sets the options array
	 */
	function setOptions( $options ) {
		$this->mOptions = $options;
	}

	/**
	 * Sets an option in the options array
	 */
	function setOption( $option, $value ) {
		$this->mOptions[$option] = $value;
	}

	/**
	 * Returns the HTTP status
	 *
	 * 200 - ok
	 * 400 - error
	 *
	 * @return number
	 */
	function getStatus() {
		return $this->mStatus;
	}

	/**
	 * Evaluates the parameters, performs the requested API query, and sets up
	 * the result.
	 *
	 * The execute() method will be invoked when an API call is processed.
	 *
	 * The result data is stored in the ApiResult object available through
	 * getResult().
	 */
	function execute() {

		$this->prepareAction();

		try {
			$this->doAction();
		} catch ( MWException $e ) {
			$this->logMessage( $e->getMessage(), $e->getCode() );
		}

		$this->finalizeResults();
		$this->setHeaders();
	}

	/**
	 *
	 */
	function prepareAction() {

		// get options from the request, but keep the explicitly set options
		global $wgVersion;
		if ( version_compare( $wgVersion, '1.20', '>=' ) ) {
			$data = $this->getRequest()->getValues();
		} else { // TODO: remove else branch when raising supported version to MW 1.20, getValues() was buggy before
			$data = $_POST + $_GET;
		}
		$this->mOptions = SFUtils::array_merge_recursive_distinct( $data, $this->mOptions );

		global $wgParser;
		if ( $wgParser === null ) {
			$wgParser = new Parser();
		}

		$wgParser->startExternalParse(
			null,
			ParserOptions::newFromUser( $this->getUser() ),
			Parser::OT_WIKI
		);

		// MW uses the parameter 'title' instead of 'target' when submitting
		// data for formedit action => use that
		if ( !array_key_exists( 'target', $this->mOptions ) && array_key_exists( 'title', $this->mOptions ) ) {

			$this->mOptions['target'] = $this->mOptions['title'];
			unset( $this->mOptions['title'] );
		}

		// if the 'query' parameter was used, unpack the param string
		if ( array_key_exists( 'query', $this->mOptions ) ) {

			$this->addOptionsFromString( $this->mOptions['query'] );
			unset( $this->mOptions['query'] );
		}

		// if an action is explicitly set in the form data, use that
		if ( array_key_exists( 'wpSave', $this->mOptions ) ) {

			// set action to 'save' if requested
			$this->mAction = self::ACTION_SAVE;
			unset( $this->mOptions['wpSave'] );
		} else if ( array_key_exists( 'wpPreview', $this->mOptions ) ) {

			// set action to 'preview' if requested
			$this->mAction = self::ACTION_PREVIEW;
			unset( $this->mOptions['wpPreview'] );
		} else if ( array_key_exists( 'wpDiff', $this->mOptions ) ) {

			// set action to 'preview' if requested
			$this->mAction = self::ACTION_DIFF;
			unset( $this->mOptions['wpDiff'] );
		} else if ( array_key_exists( 'action', $this->mOptions ) ) {

			switch ( $this->mOptions['action'] ) {

				case 'sfautoedit' :
					$this->mAction = self::ACTION_SAVE;
					break;
				case 'preview' :
					$this->mAction = self::ACTION_PREVIEW;
					break;
				default :
					$this->mAction = self::ACTION_FORMEDIT;
			}
		} else {
			// set default action
			$this->mAction = self::ACTION_FORMEDIT;
		}

		$hookQuery = null;

		// ensure 'form' key exists
		if ( array_key_exists( 'form', $this->mOptions ) ) {
			$hookQuery = $this->mOptions['form'];
		} else {
			$this->mOptions['form'] = '';
		}

		// ensure 'target' key exists
		if ( array_key_exists( 'target', $this->mOptions ) ) {
			if ( $hookQuery !== null ) {
				$hookQuery .= '/' . $this->mOptions['target'];
			}
		} else {
			$this->mOptions['target'] = '';
		}

		// Normalize form and target names

		$form = Title::newFromText( $this->mOptions['form'] );
		if ( $form !== null ) {
			$this->mOptions['form'] = $form->getPrefixedText();
		}

		$target = Title::newFromText( $this->mOptions['target'] );
		if ( $target !== null ) {
			$this->mOptions['target'] = $target->getPrefixedText();
		}

		wfRunHooks( 'sfSetTargetName', array( &$this->mOptions['target'], $hookQuery ) );

		// set html return status. If all goes well, this will not be changed
		$this->mStatus = 200;
	}

	/**
	 * Get the Title object of a form suitable for editing the target page.
	 *
	 * @return Title
	 * @throws MWException
	 */
	protected function getFormTitle() {

		// if no form was explicitly specified, try for explicitly set alternate forms
		if ( $this->mOptions['form'] === '' ) {

			$this->logMessage( 'No form specified. Will try to find the default form for the target page.', self::DEBUG );

			$formNames = array();

			// try explicitly set alternative forms
			if ( array_key_exists( 'alt_form', $this->mOptions ) ) {

				$formNames = (array)$this->mOptions['alt_form']; // cast to array to make sure we get an array, even if only a string was sent

			}

			// if no alternate forms were explicitly set, try finding a default form for the target page
			if ( count( $formNames ) === 0 ) {

				// if no form and and no alt forms and no target page was specified, give up
				if ( $this->mOptions['target'] === '' ) {
					throw new MWException( wfMessage( 'sf_autoedit_notargetspecified' )->parse() );
				}

				$targetTitle = Title::newFromText( $this->mOptions['target'] );

				// if the specified target title is invalid, give up
				if ( !$targetTitle instanceof Title ) {
					throw new MWException( wfMessage( 'sf_autoedit_invalidtargetspecified', $this->mOptions['target'] )->parse() );
				}

				$formNames = SFFormLinker::getDefaultFormsForPage( $targetTitle );

				// if no default form can be found, try alternate forms
				if ( count( $formNames ) === 0 ) {

					$formNames = SFFormLinker::getFormsThatPagePointsTo( $targetTitle->getText(), $targetTitle->getNamespace(), SFFormLinker::ALTERNATE_FORM );

					// if still no form can be found, give up
					if ( count( $formNames ) === 0 ) {
						throw new MWException( wfMessage( 'sf_autoedit_noformfound' )->parse() );
					}

				}

			}

			// if more than one form was found, issue a notice and give up
			// this happens if no default form but several alternate forms are defined
			if ( count( $formNames ) > 1 ) {
				throw new MWException( wfMessage( 'sf_autoedit_toomanyformsfound' )->parse(), self::DEBUG );
			}

			$this->mOptions['form'] = $formNames[0];

			$this->logMessage( 'Using ' . $this->mOptions['form'] . ' as default form.', self::DEBUG );
		}

		$formTitle = Title::makeTitleSafe( SF_NS_FORM, $this->mOptions['form'] );

		// if the given form is not a valid title, give up
		if ( !($formTitle instanceOf Title) ) {
			throw new MWException( wfMessage( 'sf_autoedit_invalidform', $this->mOptions['form'] )->parse() );
		}

		// if the form page is a redirect, follow the redirect
		if ( $formTitle->isRedirect() ) {

			$this->logMessage( 'Form ' . $this->mOptions['form'] . ' is a redirect. Finding target.', self::DEBUG );

			// FIXME: Title::newFromRedirectRecurse is deprecated as of MW 1.21
			$formTitle = Title::newFromRedirectRecurse( WikiPage::factory( $formTitle )->getRawText() );

			// if we exeeded $wgMaxRedirects or encountered an invalid redirect target, give up
			if ( $formTitle->isRedirect() ) {

				$newTitle = WikiPage::factory( $formTitle )->getRedirectTarget();

				if ( $newTitle instanceOf Title && $newTitle->isValidRedirectTarget() ) {
					throw new MWException( wfMessage( 'sf_autoedit_redirectlimitexeeded', $this->mOptions['form'] )->parse() );
				} else {
					throw new MWException( wfMessage( 'sf_autoedit_invalidredirecttarget', $newTitle->getFullText(), $this->mOptions['form'] )->parse() );
				}
			}
		}

		// if specified or found form does not exist (e.g. is a red link), give up
		// FIXME: Throw specialized error message, so a list of alternative forms can be shown
		if ( !$formTitle->exists() ) {
			throw new MWException( wfMessage( 'sf_autoedit_invalidform', $this->mOptions['form'] )->parse() );
		}

		return $formTitle;
	}

	protected function setupEditPage( $targetContent ) {

		// Find existing target article if it exists, or create a new one.
		$targetTitle = Title::newFromText( $this->mOptions['target'] );

		// if the specified target title is invalid, give up
		if ( !$targetTitle instanceof Title ) {
			throw new MWException( wfMessage( 'sf_autoedit_invalidtargetspecified', $this->mOptions['target'] )->parse() );
		}

		$article = new Article( $targetTitle );

		// set up a normal edit page
		// we'll feed it our data to simulate a normal edit
		$editor = new EditPage( $article );

		// set up form data:
		// merge data coming from the web request on top of some defaults
		$data = array_merge(
				array(
					'wpTextbox1' => $targetContent,
					'wpSummary' => '',
					'wpStarttime' => wfTimestampNow(),
					'wpEdittime' => '',
					'wpEditToken' => isset( $this->mOptions[ 'token' ] ) ? $this->mOptions[ 'token' ] : $this->getUser()->getEditToken(),
					'action' => 'submit',
				),
				$this->mOptions
		);

		if ( array_key_exists( 'format', $data ) ) {
			unset( $data['format'] );
		}

		// set up a faux request with the simulated data
		$request = new FauxRequest( $data, true );

		// and import it into the edit page
		$editor->importFormData( $request );
		$editor->sfFauxRequest = $request;

		return $editor;
	}

	/**
	 * Sets the output HTML of wgOut as the module's result
	 */
	protected function setResultFromOutput() {

		// turn on output buffering
		ob_start();

		// generate preview document and write it to output buffer
		$this->getOutput()->output();

		// retrieve the preview document from output buffer
		$targetHtml = ob_get_contents();

		// clean output buffer, so MW can use it again
		ob_clean();

		// store the document as result
		$this->getResult()->addValue( null, 'result', $targetHtml );

	}

	protected function doPreview( $editor ) {

		global $wgOut;

		$previewOutput = $editor->getPreviewText();

		wfRunHooks( 'EditPage::showEditForm:initial', array( &$editor, &$wgOut ) );

		$this->getOutput()->addStyle( 'common/IE80Fixes.css', 'screen', 'IE 8' );
		$this->getOutput()->setRobotPolicy( 'noindex,nofollow' );

		// This hook seems slightly odd here, but makes things more
		// consistent for extensions.
		wfRunHooks( 'OutputPageBeforeHTML', array( &$wgOut, &$previewOutput ) );

		$this->getOutput()->addHTML( Html::rawElement( 'div', array( 'id' => 'wikiPreview' ), $previewOutput ) );

		$this->setResultFromOutput();

	}

	protected function doDiff( $editor ) {
		$editor->showDiff();
		$this->setResultFromOutput();
	}

	protected function doStore( EditPage $editor ) {

		$title = $editor->getTitle();

		// If they used redlink=1 and the page exists, redirect to the main article and send notice
		if ( $this->getRequest()->getBool( 'redlink' ) && $title->exists() ) {
			$this->logMessage( wfMessage( 'sf_autoedit_redlinkexists' )->parse(), self::WARNING );
		}

		$permErrors = $title->getUserPermissionsErrors( 'edit', $this->getUser() );

		// if this title needs to be created, user needs create rights
		if ( !$title->exists() ) {
			$permErrors = array_merge( $permErrors, wfArrayDiff2( $title->getUserPermissionsErrors( 'create', $this->getUser() ), $permErrors ) );
		}

		if ( $permErrors ) {

			// Auto-block user's IP if the account was "hard" blocked
			$this->getUser()->spreadAnyEditBlock();

			foreach ( $permErrors as $error ) {
				$this->logMessage( call_user_func_array( 'wfMessage', $error )->parse() );
			}

			return;
		}

		$resultDetails = false;
		# Allow bots to exempt some edits from bot flagging
		$bot = $this->getUser()->isAllowed( 'bot' ) && $editor->bot;

		$request = $editor->sfFauxRequest;
		if ( $editor->tokenOk( $request ) ) {
			$ctx = RequestContext::getMain();
			$tempTitle = $ctx->getTitle();
			$ctx->setTitle( $title );
			$status = $editor->internalAttemptSave( $resultDetails, $bot );
			$ctx->setTitle( $tempTitle );
		} else {
			throw new MWException( wfMessage( 'session_fail_preview' )->parse() );
		}

		switch ( $status->value ) {
			case EditPage::AS_HOOK_ERROR_EXPECTED: // A hook function returned an error
			case EditPage::AS_CONTENT_TOO_BIG: // Content too big (> $wgMaxArticleSize)
			case EditPage::AS_ARTICLE_WAS_DELETED: // article was deleted while editting and param wpRecreate == false or form was not posted
			case EditPage::AS_CONFLICT_DETECTED: // (non-resolvable) edit conflict
			case EditPage::AS_SUMMARY_NEEDED: // no edit summary given and the user has forceeditsummary set and the user is not editting in his own userspace or talkspace and wpIgnoreBlankSummary == false
			case EditPage::AS_TEXTBOX_EMPTY: // user tried to create a new section without content
			case EditPage::AS_MAX_ARTICLE_SIZE_EXCEEDED: // article is too big (> $wgMaxArticleSize), after merging in the new section
			case EditPage::AS_END: // WikiPage::doEdit() was unsuccessfull

				throw new MWException( wfMessage( 'sf_autoedit_fail', $this->mOptions['target'] )->parse() );

			case EditPage::AS_HOOK_ERROR: // Article update aborted by a hook function

				$this->logMessage( 'Article update aborted by a hook function', self::DEBUG );
				return false; // success

			// TODO: This error code only exists from 1.21 onwards. It is
			// suitably handled by the default branch, but really should get its
			// own branch. Uncomment once compatibility to pre1.21 is dropped.
//			case EditPage::AS_PARSE_ERROR: // can't parse content
//
//				throw new MWException( $status->getHTML() );
//				return true; // fail

			case EditPage::AS_SUCCESS_NEW_ARTICLE: // Article successfully created

				$query = $resultDetails['redirect'] ? 'redirect=no' : '';
				$anchor = isset( $resultDetails['sectionanchor'] ) ? $resultDetails['sectionanchor'] : '';

				$this->getOutput()->redirect( $title->getFullURL( $query ) . $anchor );
				$this->getResult()->addValue( NULL, 'redirect', $title->getFullURL( $query ) . $anchor );
				return false; // success

			case EditPage::AS_SUCCESS_UPDATE: // Article successfully updated

				$extraQuery = '';
				$sectionanchor = $resultDetails['sectionanchor'];

				// Give extensions a chance to modify URL query on update
				wfRunHooks( 'ArticleUpdateBeforeRedirect', array( $editor->getArticle(), &$sectionanchor, &$extraQuery ) );

				if ( $resultDetails['redirect'] ) {
					if ( $extraQuery == '' ) {
						$extraQuery = 'redirect=no';
					} else {
						$extraQuery = 'redirect=no&' . $extraQuery;
					}
				}

				$this->getOutput()->redirect( $title->getFullURL( $extraQuery ) . $sectionanchor );
				$this->getResult()->addValue( NULL, 'redirect', $title->getFullURL( $extraQuery ) . $sectionanchor );

				return false; // success

			case EditPage::AS_BLANK_ARTICLE: // user tried to create a blank page

				$this->logMessage( 'User tried to create a blank page', self::DEBUG );

				$this->getOutput()->redirect( $editor->getContextTitle()->getFullURL() );
				$this->getResult()->addValue( NULL, 'redirect', $editor->getContextTitle()->getFullURL() );

				return false; // success

			case EditPage::AS_SPAM_ERROR: // summary contained spam according to one of the regexes in $wgSummarySpamRegex

				$match = $resultDetails['spam'];
				if ( is_array( $match ) ) {
					$match = $this->getLanguage()->listToText( $match );
				}

				throw new MWException( wfMessage( 'spamprotectionmatch', wfEscapeWikiText( $match ) )->parse() ); // FIXME: Include better error message

			case EditPage::AS_BLOCKED_PAGE_FOR_USER: // User is blocked from editting editor page
				throw new UserBlockedError( $this->getUser()->getBlock() );

			case EditPage::AS_IMAGE_REDIRECT_ANON: // anonymous user is not allowed to upload (User::isAllowed('upload') == false)
			case EditPage::AS_IMAGE_REDIRECT_LOGGED: // logged in user is not allowed to upload (User::isAllowed('upload') == false)
				throw new PermissionsError( 'upload' );

			case EditPage::AS_READ_ONLY_PAGE_ANON: // editor anonymous user is not allowed to edit editor page
			case EditPage::AS_READ_ONLY_PAGE_LOGGED: // editor logged in user is not allowed to edit editor page
				throw new PermissionsError( 'edit' );

			case EditPage::AS_READ_ONLY_PAGE: // wiki is in readonly mode (wfReadOnly() == true)
				throw new ReadOnlyError;

			case EditPage::AS_RATE_LIMITED: // rate limiter for action 'edit' was tripped
				throw new ThrottledError();

			case EditPage::AS_NO_CREATE_PERMISSION: // user tried to create editor page, but is not allowed to do that ( Title->usercan('create') == false )
				$permission = $title->isTalkPage() ? 'createtalk' : 'createpage';
				throw new PermissionsError( $permission );

			default:
				// We don't recognize $status->value. The only way that can happen
				// is if an extension hook aborted from inside ArticleSave.
				// Render the status object into $editor->hookError
				$editor->hookError = '<div class="error">' . $status->getWikitext() . '</div>';
				throw new MWException( $status->getHTML() );
		}
	}

	protected function doFormEdit( $formHTML, $formJS ) {
		// return form html and js in the result
		$this->getResult()->addValue( array('form'), 'HTML', $formHTML );
		$this->getResult()->addValue( array('form'), 'JS', $formJS );
}

	protected function finalizeResults() {

		// set response text depending on the status and the requested action
		if ( $this->mStatus === 200 ) {
			if ( array_key_exists( 'ok text', $this->mOptions ) ) {
				$responseText = MessageCache::singleton()->parse( $this->mOptions['ok text'], Title::newFromText( $this->mOptions['target'] ) )->getText();
			} elseif ( $this->mAction === self::ACTION_SAVE ) {
				$responseText = wfMessage( 'sf_autoedit_success', $this->mOptions['target'], $this->mOptions['form'] )->parse();
			} else {
				$responseText = null;
			}
		} else {
			// get errortext (or use default)
			if ( array_key_exists( 'error text', $this->mOptions ) ) {
				$responseText = MessageCache::singleton()->parse( $this->mOptions['error text'], Title::newFromText( $this->mOptions['target'] ) )->getText();
			} elseif ( $this->mAction === self::ACTION_SAVE ) {
				$responseText = wfMessage( 'sf_autoedit_fail', $this->mOptions['target'] )->parse();
			} else {
				$responseText = null;
			}
		}

		$result = $this->getResult();

		if ( $responseText !== null ) {
			$result->addValue( null, 'responseText', $responseText );
		}

		$result->addValue( null, 'status', $this->mStatus, true );
		$result->addValue( array('form'), 'title', $this->mOptions['form'] );
		$result->addValue( null, 'target', $this->mOptions['target'], true );
	}

	/**
	 * Set custom headers to attach to the answer
	 */
	protected function setHeaders() {

		if ( !headers_sent() ) {

			header( 'X-Status: ' . $this->mStatus, true, $this->mStatus );
			header( 'X-Form: ' . $this->mOptions['form'] );
			header( 'X-Target: ' . $this->mOptions['target'] );

			$redirect = $this->getOutput()->getRedirect();
			if ( $redirect ) {
				header( 'X-Location: ' . $redirect );
			}
		}
	}

	/**
	 * Generates a target name from the given target name formula
	 *
	 * This parses the formula and replaces &lt;unique number&gt; tags
	 *
	 * @param type $targetNameFormula
	 *
	 * @throws MWException
	 * @return type
	 */
	protected function generateTargetName( $targetNameFormula ) {

		$targetName = $targetNameFormula;

		// prepend a super-page, if one was specified
		if ( $this->getRequest()->getCheck( 'super_page' ) ) {
			$targetName = $this->getRequest()->getVal( 'super_page' ) . '/' . $targetName;
		}

		// prepend a namespace, if one was specified
		if ( $this->getRequest()->getCheck( 'namespace' ) ) {
			$targetName = $this->getRequest()->getVal( 'namespace' ) . ':' . $targetName;
		}

		// replace "unique number" tag with one that won't get erased by the next line
		$targetName = preg_replace( '/<unique number(.*)>/', '{num\1}', $targetName, 1 );

		// if any formula stuff is still in the name after the parsing, just remove it
		// FIXME: This is wrong. If anything is still left, something should have been present in the form and wasn't. An error should be raised.
		//$targetName = StringUtils::delimiterReplace( '<', '>', '', $targetName );

		// replace spaces back with underlines, in case a magic word or parser
		// function name contains underlines - hopefully this won't cause
		// problems of its own
		$targetName = str_replace( ' ', '_', $targetName );

		// now run the parser on it
		global $wgParser;
		$targetName = $wgParser->transformMsg( $targetName, ParserOptions::newFromUser( null ) );

		$titleNumber = '';
		$isRandom = false;
		$randomNumHasPadding = false;
		$randomNumDigits = 6;

		if ( preg_match( '/{num.*}/', $targetName, $matches ) && strpos( $targetName, '{num' ) !== false ) {
			// Random number
			if ( preg_match( '/{num;random(;(0)?([1-9][0-9]*))?}/', $targetName, $matches ) ) {
				$isRandom = true;
				$randomNumHasPadding = array_key_exists( 2, $matches );
				$randomNumDigits = ( array_key_exists( 3, $matches ) ? $matches[3] : $randomNumDigits );
				$titleNumber = SFUtils::makeRandomNumber( $randomNumDigits, $randomNumHasPadding );
			} else if ( preg_match( '/{num.*start[_]*=[_]*([^;]*).*}/', $targetName, $matches ) ) {
				// get unique number start value
				// from target name; if it's not
				// there, or it's not a positive
				// number, start it out as blank
				;
				if ( count( $matches ) == 2 && is_numeric( $matches[1] ) && $matches[1] >= 0 ) {
					// the "start" value"
					$titleNumber = $matches[1];
				}
			} else if ( preg_match( '/^(_?{num.*}?)*$/', $targetName, $matches ) ) {
				// the target name contains only underscores and number fields,
				// i.e. would result in an empty title without the number set
				$titleNumber = '1';
			} else {
				$titleNumber = '';
			}

			// set target title
			$targetTitle = Title::newFromText( preg_replace( '/{num.*}/', $titleNumber, $targetName ) );

			// if the specified target title is invalid, give up
			if ( !$targetTitle instanceof Title ) {
				throw new MWException( wfMessage( 'sf_autoedit_invalidtargetspecified', trim( preg_replace( '/<unique number(.*)>/', $titleNumber, $targetNameFormula ) ) )->parse() );
			}

			// if title exists already cycle through numbers for this tag until
			// we find one that gives a nonexistent page title;
			//
			// can not use $targetTitle->exists(); it does not use
			// Title::GAID_FOR_UPDATE, which is needed to get correct data from
			// cache; use $targetTitle->getArticleID() instead
			while ( $targetTitle->getArticleID( Title::GAID_FOR_UPDATE ) !== 0 ) {

				if ( $isRandom ) {
					$titleNumber = SFUtils::makeRandomNumber( $randomNumDigits, $randomNumHasPadding );
				}
				// if title number is blank, change it to 2; otherwise,
				// increment it, and if necessary pad it with leading 0s as well
				elseif ( $titleNumber == "" ) {
					$titleNumber = 2;
				} else {
					$titleNumber = str_pad( $titleNumber + 1, strlen( $titleNumber ), '0', STR_PAD_LEFT );
				}

				$targetTitle = Title::newFromText( preg_replace( '/{num.*}/', $titleNumber, $targetName ) );
			}

			$targetName = $targetTitle->getPrefixedText();
		}

		return $targetName;
	}

	/**
	 * Depending on the requested action this method will try to store/preview
	 * the data in mOptions or retrieve the edit form.
	 *
	 * The form and target page will be available in mOptions after execution of
	 * the method.
	 *
	 * Errors and warnings are logged in the API result under the 'errors' key.
	 * The general request status is maintained in mStatus.
	 *
	 * @global $wgRequest
	 * @global $wgOut
	 * @global SFFormPrinter $sfgFormPrinter
	 * @throws MWException
	 */
	public function doAction() {
		global $wgOut, $wgParser, $wgRequest, $sfgFormPrinter;

		// if the wiki is read-only, do not save
		if ( wfReadOnly() ) {

			if ( $this->mAction === self::ACTION_SAVE ) {
				throw new MWException( wfMessage( 'sf_autoedit_readonly', wfReadOnlyReason() )->parse() );
			}

			// even if not saving notify client anyway. Might want to dislay a notice
			$this->logMessage( wfMessage( 'sf_autoedit_readonly', wfReadOnlyReason() )->parse(), self::NOTICE );
		}

		// find the title of the form to be used
		$formTitle = $this->getFormTitle();

		// get the form content
		$formContent = StringUtils::delimiterReplace(
						'<noinclude>', // start delimiter
						'</noinclude>', // end delimiter
						'', // replace by
						WikiPage::factory( $formTitle )->getRawText() // subject
		);

		// signals that the form was submitted
		// always true, else we would not be here
		$isFormSubmitted = $this->mAction === self::ACTION_SAVE || $this->mAction === self::ACTION_PREVIEW || $this->mAction === self::ACTION_DIFF;

		// the article id of the form to be used
		$formArticleId = $formTitle->getArticleID();

		// the name of the target page; might be empty when using the one-step-process
		$targetName = $this->mOptions['target'];

		// if the target page was not specified, try finding the page name formula
		// (Why is this not done in SFFormPrinter::formHTML?)
		if ( $targetName === '' ) {

			// Parse the form to see if it has a 'page name' value set.
			if ( preg_match( '/{{{\s*info.*page name\s*=\s*(.*)}}}/msU', $formContent, $matches ) ) {
				$pageNameElements = SFUtils::getFormTagComponents( trim( $matches[1] ) );
				$targetNameFormula = $pageNameElements[0];
			} else {
				throw new MWException( wfMessage( 'sf_autoedit_notargetspecified' )->parse() );
			}

			$targetTitle = null;
		} else {
			$targetNameFormula = null;
			$targetTitle = Title::newFromText( $targetName );
		}

		$preloadContent = '';

		// save $wgRequest for later restoration
		$oldRequest = $wgRequest;
		$pageExists = false;

		// preload data if not explicitly excluded and if the preload page exists
		if ( !isset( $this->mOptions['preload'] ) || $this->mOptions['preload'] !== false ) {

			if ( isset( $this->mOptions['preload'] ) && is_string( $this->mOptions['preload'] ) ) {
				$preloadTitle = Title::newFromText( $this->mOptions['preload'] );
			} else {
				$preloadTitle = Title::newFromText( $targetName );
			}

			if ( $preloadTitle !== null && $preloadTitle->exists() ) {

				// the content of the page that was specified to be used for preloading
				$preloadContent = WikiPage::factory( $preloadTitle )->getRawText();

				$pageExists = true;

			} else {
				if ( isset( $this->mOptions['preload'] ) ) {
					$this->logMessage( wfMessage( 'sf_autoedit_invalidpreloadspecified', $this->mOptions['preload'] )->parse(), self::WARNING );
				}
			}
		}

		// Allow extensions to set/change the preload text, for new
		// pages.
		if ( !$pageExists ) {
			wfRunHooks( 'sfEditFormPreloadText', array( &$preloadContent, $targetTitle, $formTitle ) );
		}

		// Flag to keep track of formHTML() runs.
		$formHtmlHasRun = false;

		if ( $preloadContent !== '' ) {

			// @HACK - we need to set this for the preload to take
			// effect in the form.
			$pageExists = true;

			// Spoof $wgRequest for SFFormPrinter::formHTML().
			if ( isset( $_SESSION ) ) {
				$wgRequest = new FauxRequest( $this->mOptions, true, $_SESSION );
			} else {
				$wgRequest = new FauxRequest( $this->mOptions, true );
			}
			// Call SFFormPrinter::formHTML() to get at the form
			// HTML of the existing page.
			list ( $formHTML, $formJS, $targetContent, $form_page_title, $generatedTargetNameFormula ) =
				$sfgFormPrinter->formHTML(
					$formContent, $isFormSubmitted, $pageExists, $formArticleId, $preloadContent, $targetName, $targetNameFormula
				);

			// Parse the data to be preloaded from the form HTML of
			// the existing page.
			$data = $this->parseDataFromHTMLFrag( $formHTML );

			// ...and merge/overwrite it with the new data.
			$this->mOptions = SFUtils::array_merge_recursive_distinct( $data, $this->mOptions );
		}

		// We already preloaded stuff for saving/previewing -
		// do not do this again.
		if ( $isFormSubmitted && !$wgRequest->getCheck( 'partial' ) ) {
			$preloadContent = '';
			$pageExists = false;
		} else {
			// Source of the data is a page.
			$pageExists = ( is_a( $targetTitle, 'Title') && $targetTitle->exists() );
		}

		// Spoof $wgRequest for SFFormPrinter::formHTML().
		if ( isset( $_SESSION ) ) {
			$wgRequest = new FauxRequest( $this->mOptions, true, $_SESSION );
		} else {
			$wgRequest = new FauxRequest( $this->mOptions, true );
		}

		// get wikitext for submitted data and form
		list ( $formHTML, $formJS, $targetContent, $generatedFormName, $generatedTargetNameFormula ) =
				$sfgFormPrinter->formHTML( $formContent, $isFormSubmitted, $pageExists, $formArticleId, $preloadContent, $targetName, $targetNameFormula );

		// Restore original request.
		$wgRequest = $oldRequest;

		if ( $generatedFormName !== '' ) {
			$formTitle = Title::newFromText( $generatedFormName );
			$this->mOptions['formtitle'] = $formTitle->getText();
		}

		$this->mOptions['formHTML'] = $formHTML;
		$this->mOptions['formJS'] = $formJS;

		if ( $isFormSubmitted ) {

			// If the target page was not specified, see if
			// something was generated from the target name formula.
			if ( $this->mOptions['target'] === '' ) {

				// If no name was generated, we cannot save => give up
				if ( $generatedTargetNameFormula === '' ) {
					throw new MWException( wfMessage( 'sf_autoedit_notargetspecified' )->parse() );
				}

				$this->mOptions['target'] = $this->generateTargetName( $generatedTargetNameFormula );
			}

			// Lets other code process additional form-definition syntax
			wfRunHooks( 'sfWritePageData', array( $this->mOptions['form'], Title::newFromText( $this->mOptions['target'] ), &$targetContent ) );

			$editor = $this->setupEditPage( $targetContent );

			// Perform the requested action.
			if ( $this->mAction === self::ACTION_PREVIEW ) {
				$this->doPreview( $editor );
			} else if ( $this->mAction === self::ACTION_DIFF ) {
				$this->doDiff( $editor );
			} else {
				$this->doStore( $editor );
			}
		} else if ( $this->mAction === self::ACTION_FORMEDIT ) {

			$parserOutput = $wgParser->getOutput();
			if( method_exists( $wgOut, 'addParserOutputMetadata' ) ){
				$wgOut->addParserOutputMetadata( $parserOutput );
			} else {
				$wgOut->addParserOutputNoText( $parserOutput );
			}

			$this->doFormEdit( $formHTML, $formJS );
		}
	}

	private function parseDataFromHTMLFrag( $html ) {

		$data = array( );
		$doc = new DOMDocument();
		@$doc->loadHTML(
			'<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/></head><body>'
			. $html
			. '</body></html>'
		);

		// Process input tags.
		$inputs = $doc->getElementsByTagName( 'input' );

		for ( $i = 0; $i < $inputs->length; $i++ ) {

			$input = $inputs->item( $i );
			$type = $input->getAttribute( 'type' );
			$name = trim( $input->getAttribute( 'name' ) );

			if ( !$name || $input->hasAttribute( 'disabled' ) ) {
				continue;
			}

			if ( $type === '' )
				$type = 'text';

			switch ( $type ) {
				case 'checkbox':
				case 'radio':
					if ( $input->hasAttribute( 'checked' ) ) {
						self::addToArray( $data, $name, $input->getAttribute( 'value' ) );
					}
					break;

				// case 'button':
				case 'hidden':
				case 'image':
				case 'password':
				// case 'reset':
				// case 'submit':
				case 'text':
					self::addToArray( $data, $name, $input->getAttribute( 'value' ) );
					break;
			}
		}

		// Process select tags
		$selects = $doc->getElementsByTagName( 'select' );

		for ( $i = 0; $i < $selects->length; $i++ ) {

			$select = $selects->item( $i );
			$name = trim( $select->getAttribute( 'name' ) );

			if ( !$name || $select->hasAttribute( 'disabled' ) ) {
				continue;
			}

			$options = $select->getElementsByTagName( 'option' );

			// If the current $select is a radio button select
			// (i.e. not multiple) set the first option to selected
			// as default. This may be overwritten in the loop below.
			if ( $options->length > 0 && (!$select->hasAttribute( 'multiple' ) ) ) {
				self::addToArray( $data, $name, $options->item( 0 )->getAttribute( 'value' ) );
			}

			for ( $o = 0; $o < $options->length; $o++ ) {
				if ( $options->item( $o )->hasAttribute( 'selected' ) ) {
					if ( $options->item( $o )->getAttribute( 'value' ) ) {
						self::addToArray( $data, $name, $options->item( $o )->getAttribute( 'value' ) );
					} else {
						self::addToArray( $data, $name, $options->item( $o )->nodeValue );
					}
				}
			}
		}

		// Process textarea tags
		$textareas = $doc->getElementsByTagName( 'textarea' );

		for ( $i = 0; $i < $textareas->length; $i++ ) {
			$textarea = $textareas->item( $i );
			$name = trim( $textarea->getAttribute( 'name' ) );

			if ( !$name )
				continue;

			self::addToArray( $data, $name, $textarea->textContent );
		}

		return $data;
	}

	/**
	 * Parses data from a query string into the $data array
	 *
	 * @param Array $data
	 * @param String $queryString
	 * @return Array
	 */
	private function parseDataFromQueryString( &$data, $queryString ) {
		$params = explode( '&', $queryString );

		foreach ( $params as $param ) {
			$elements = explode( '=', $param, 2 );

			$key = trim( urldecode( $elements[0] ) );
			$value = count( $elements ) > 1 ? urldecode( $elements[1] ) : null;

			if ( $key == "query" || $key == "query string" ) {
				$this->parseDataFromQueryString( $data, $value );
			} else {
				self::addToArray( $data, $key, $value );
			}
		}

		return $data;
	}

	/**
	 * This function recursively inserts the value into a tree.
	 *
	 * @param $array is root
	 * @param $key identifies path to position in tree.
	 *    Format: 1stLevelName[2ndLevel][3rdLevel][...], i.e. normal array notation
	 * @param $value: the value to insert
	 * @param $toplevel: if this is a toplevel value.
	 */
	public static function addToArray( &$array, $key, $value, $toplevel = true ) {
		$matches = array( );

		if ( preg_match( '/^([^\[\]]*)\[([^\[\]]*)\](.*)/', $key, $matches ) ) {

			// for some reason toplevel keys get their spaces encoded by MW.
			// We have to imitate that.
			if ( $toplevel ) {
				$key = str_replace( ' ', '_', $matches[1] );
			} else {
				$key = $matches[1];
			}

			// if subsequent element does not exist yet or is a string (we prefer arrays over strings)
			if ( !array_key_exists( $key, $array ) || is_string( $array[$key] ) ) {
				$array[$key] = array( );
			}

			self::addToArray( $array[$key], $matches[2] . $matches[3], $value, false );
		} else {
			if ( $key ) {
				// only add the string value if there is no child array present
				if ( !array_key_exists( $key, $array ) || !is_array( $array[$key] ) ) {
					$array[$key] = $value;
				}
			} else {
				array_push( $array, $value );
			}
		}
	}

	/**
	 * Add error message to the ApiResult
	 *
	 * @param string $msg
	 * @param int $errorLevel
	 *
	 * @return string
	 */
	private function logMessage( $msg, $errorLevel = self::ERROR ) {

		if ( $errorLevel === self::ERROR ) {
			$this->mStatus = 400;
		}

		$this->getResult()->addValue( array( 'errors' ), null, array( 'level' => $errorLevel, 'message' => $msg ) );

		return $msg;
	}

	/**
	 * Indicates whether this module requires write mode
	 * @return bool
	 */
	public function isWriteMode() {
		return true;
	}

	/**
	 * Returns the array of allowed parameters (parameter name) => (default
	 * value) or (parameter name) => (array with PARAM_* constants as keys)
	 * Don't call this function directly: use getFinalParams() to allow
	 * hooks to modify parameters as needed.
	 *
	 * @return array or false
	 */
	function getAllowedParams() {
		return array(
			'form' => null,
			'target' => null,
			'query' => null,
			'preload' => null
		);
	}

	/**
	 * Returns an array of parameter descriptions.
	 * Don't call this functon directly: use getFinalParamDescription() to
	 * allow hooks to modify descriptions as needed.
	 *
	 * @return array or false
	 */
	function getParamDescription() {
		return array(
			'form' => 'The form to use.',
			'target' => 'The target page.',
			'query' => 'The query string.',
			'preload' => 'The name of a page to preload'
		);
	}

	/**
	 * Returns the description string for this module
	 *
	 * @return mixed string or array of strings
	 */
	function getDescription() {
		return <<<END
This module is used to remotely create or edit pages using Semantic Forms.

Add "template-name[field-name]=field-value" to the query string parameter, to set the value for a specific field.
To set values for more than one field use "&", or rather its URL encoded version "%26": "template-name[field-name-1]=field-value-1%26template-name[field-name-2]=field-value-2".
See the first example below.

In addition to the query parameter, any parameter in the URL of the form "template-name[field-name]=field-value" will be treated as part of the query. See the second example.
END;
	}

	/**
	 * Returns usage examples for this module.
	 *
	 * @return mixed string or array of strings
	 */
	protected function getExamples() {
		return array(
			'With query parameter:    api.php?action=sfautoedit&form=form-name&target=page-name&query=template-name[field-name-1]=field-value-1%26template-name[field-name-2]=field-value-2',
			'Without query parameter: api.php?action=sfautoedit&form=form-name&target=page-name&template-name[field-name-1]=field-value-1&template-name[field-name-2]=field-value-2'
		);
	}

	/**
	 * Returns a string that identifies the version of the class.
	 * Includes the class name, the svn revision, timestamp, and
	 * last author.
	 *
	 * @return string
	 */
	function getVersion() {
		global $sfgIP;
		$gitSha1 = SpecialVersion::getGitHeadSha1( $sfgIP );
		return __CLASS__ . '-' . SF_VERSION . ($gitSha1 !== false) ? ' (' . substr( $gitSha1, 0, 7 ) . ')' : '';
	}

}

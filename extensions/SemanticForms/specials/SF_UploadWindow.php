<?php
/**
 * SFUploadWindow - used for uploading files from within a form.
 * This class is nearly identical to MediaWiki's SpecialUpload class, with
 * a few changes to remove skin CSS and HTML, and to populate the relevant
 * field in the form with the name of the uploaded form.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFSpecialPages
 */
class SFUploadWindow extends UnlistedSpecialPage {
	/**
	 * Constructor : initialise object
	 * Get data POSTed through the form and assign them to the object
	 * @param WebRequest $request Data posted.
	 */
	public function __construct( $request = null ) {
		parent::__construct( 'UploadWindow', 'upload' );
		$this->loadRequest( is_null( $request ) ? $this->getRequest() : $request );
	}

	/** Misc variables **/
	public $mRequest;			// The WebRequest or FauxRequest this form is supposed to handle
	public $mSourceType;
	public $mUpload;
	public $mLocalFile;
	public $mUploadClicked;

	protected $mTextTop;
	protected $mTextAfterSummary;

	/** User input variables from the "description" section **/
	public $mDesiredDestName;	// The requested target file name
	public $mComment;
	public $mLicense;

	/** User input variables from the root section **/
	public $mIgnoreWarning;
	public $mWatchThis;
	public $mCopyrightStatus;
	public $mCopyrightSource;

	/** Hidden variables **/
	public $mForReUpload;		// The user followed an "overwrite this file" link
	public $mCancelUpload;		// The user clicked "Cancel and return to upload form" button
	public $mTokenOk;

	/** used by Semantic Forms **/
	public $mInputID;
	public $mDelimiter;

	/**
	 * Initialize instance variables from request and create an Upload handler
	 *
	 * @param WebRequest $request The request to extract variables from
	 */
	protected function loadRequest( $request ) {
		$this->mRequest = $request;
		$this->mSourceType	= $request->getVal( 'wpSourceType', 'file' );
		$this->mUpload	    = UploadBase::createFromRequest( $request );
		$this->mUploadClicked     = $request->wasPosted()
			&& ( $request->getCheck( 'wpUpload' )
				|| $request->getCheck( 'wpUploadIgnoreWarning' ) );

		// Guess the desired name from the filename if not provided
		$this->mDesiredDestName   = $request->getText( 'wpDestFile' );
		if ( !$this->mDesiredDestName )
			$this->mDesiredDestName = $request->getText( 'wpUploadFile' );
		$this->mComment	   = $request->getText( 'wpUploadDescription' );
		$this->mLicense	   = $request->getText( 'wpLicense' );


		$this->mDestWarningAck    = $request->getText( 'wpDestFileWarningAck' );
		$this->mIgnoreWarning     = $request->getCheck( 'wpIgnoreWarning' )
			|| $request->getCheck( 'wpUploadIgnoreWarning' );
		$this->mWatchthis	 = $request->getBool( 'wpWatchthis' );
		$this->mCopyrightStatus   = $request->getText( 'wpUploadCopyStatus' );
		$this->mCopyrightSource   = $request->getText( 'wpUploadSource' );


		$this->mForReUpload       = $request->getBool( 'wpForReUpload' ); // updating a file
		$this->mCancelUpload      = $request->getCheck( 'wpCancelUpload' )
					 || $request->getCheck( 'wpReUpload' ); // b/w compat

		// If it was posted check for the token (no remote POST'ing with user credentials)
		$token = $request->getVal( 'wpEditToken' );
		if ( $this->mSourceType == 'file' && $token == null ) {
			// Skip token check for file uploads as that can't be faked via JS...
			// Some client-side tools don't expect to need to send wpEditToken
			// with their submissions, as that was new in 1.16.
			$this->mTokenOk = true;
		} else {
			$this->mTokenOk = $this->getUser()->matchEditToken( $token );
		}
		$this->mInputID	   = $request->getText( 'sfInputID' );
		$this->mDelimiter	 = $request->getText( 'sfDelimiter' );
		$this->uploadFormTextTop = '';
		$this->uploadFormTextAfterSummary = '';
	}

	/**
	 * Special page entry point
	 */
	public function execute( $par ) {
		// Only output the body of the page.
		$this->getOutput()->setArticleBodyOnly( true );
		// This line is needed to get around Squid caching.
		$this->getOutput()->sendCacheControl();

		$this->setHeaders();
		$this->outputHeader();

		# Check uploading enabled
		if ( !UploadBase::isEnabled() ) {
			throw new ErrorPageError( 'uploaddisabled', 'uploaddisabledtext' );
		}

		# Check permissions
                $user = $this->getUser();
                $permissionRequired = UploadBase::isAllowed( $user );
                if ( $permissionRequired !== true ) {
                        throw new PermissionsError( $permissionRequired );
                }

		# Check blocks
		if ( $this->getUser()->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->getBlock() );
		}

		# Check whether we actually want to allow changing stuff
		if ( wfReadOnly() ) {
			throw new ReadOnlyError();
		}

		# Unsave the temporary file in case this was a cancelled upload
		if ( $this->mCancelUpload ) {
			if ( !$this->unsaveUploadedFile() )
				# Something went wrong, so unsaveUploadedFile showed a warning
				return;
		}

		# Process upload or show a form
		if ( $this->mTokenOk && !$this->mCancelUpload
				&& ( $this->mUpload && $this->mUploadClicked ) ) {
			$this->processUpload();
		} else {
			# Backwards compatibility hook
			if( !wfRunHooks( 'UploadForm:initial', array( &$this ) ) ) {
				wfDebug( "Hook 'UploadForm:initial' broke output of the upload form" );
				return;
			}

			$this->showUploadForm( $this->getUploadForm() );
		}

		# Cleanup
		if ( $this->mUpload )
			$this->mUpload->cleanupTempFile();
	}

	/**
	 * Show the main upload form and optionally add the session key to the
	 * output. This hides the source selection.
	 *
	 * @param string $message HTML message to be shown at top of form
	 * @param string $sessionKey Session key of the stashed upload
	 */
	protected function showUploadForm( $form ) {
		# Add links if file was previously deleted
		if ( !$this->mDesiredDestName )
			$this->showViewDeletedLinks();

		$form->show();
	}

	/**
	 * Get an UploadForm instance with title and text properly set.
	 *
	 * @param string $message HTML string to add to the form
	 * @param string $sessionKey Session key in case this is a stashed upload
	 * @return UploadForm
	 */
	protected function getUploadForm( $message = '', $sessionKey = '', $hideIgnoreWarning = false ) {
		# Initialize form
		$form = new SFUploadForm( array(
			'watch' => $this->watchCheck(),
			'forreupload' => $this->mForReUpload,
			'sessionkey' => $sessionKey,
			'hideignorewarning' => $hideIgnoreWarning,
			'texttop' => $this->uploadFormTextTop,
			'textaftersummary' => $this->uploadFormTextAfterSummary,
			'destfile' => $this->mDesiredDestName,
			'sfInputID' => $this->mInputID,
			'sfDelimiter' => $this->mDelimiter,
		) );
		$form->setTitle( $this->getTitle() );

		# Check the token, but only if necessary
		if ( !$this->mTokenOk && !$this->mCancelUpload
				&& ( $this->mUpload && $this->mUploadClicked ) )
			$form->addPreText( wfMessage( 'session_fail_preview' )->parse() );

		# Add upload error message
		$form->addPreText( $message );
		
		# Add footer to form
		if ( !wfMessage( 'uploadfooter' )->isDisabled() ) {
			$uploadFooter = wfMessage( 'uploadfooter' )->plain();
			$form->addPostText( '<div id="mw-upload-footer-message">'
				. $this->getOutput()->parse( $uploadFooter ) . "</div>\n" );
		}

		return $form;
	}

	/**
	 * Shows the "view X deleted revivions link""
	 */
	protected function showViewDeletedLinks() {
		$title = Title::makeTitleSafe( NS_FILE, $this->mDesiredDestName );
		// Show a subtitle link to deleted revisions (to sysops et al only)
		if ( $title instanceof Title && ( $count = $title->isDeleted() ) > 0
			&& $this->getUser()->isAllowed( 'deletedhistory' ) ) {
			$link = wfMessage( $this->getUser()->isAllowed( 'delete' ) ? 'thisisdeleted' : 'viewdeleted' )
				->rawParams( $this->getSkin()->linkKnown(
					SpecialPage::getTitleFor( 'Undelete', $title->getPrefixedText() ),
					wfMessage( 'restorelink' )->numParams( $count )->escaped()
				)
			)->parse();
			$this->getOutput()->addHTML( "<div id=\"contentSub2\">{$link}</div>" );
		}

		// Show the relevant lines from deletion log (for still deleted files only)
		if ( $title instanceof Title && $title->isDeletedQuick() && !$title->exists() ) {
			$this->showDeletionLog( $this->getOutput(), $title->getPrefixedText() );
		}
	}

	/**
	 * Stashes the upload and shows the main upload form.
	 *
	 * Note: only errors that can be handled by changing the name or
	 * description should be redirected here. It should be assumed that the
	 * file itself is sane and has passed UploadBase::verifyFile. This
	 * essentially means that UploadBase::VERIFICATION_ERROR and
	 * UploadBase::EMPTY_FILE should not be passed here.
	 *
	 * @param string $message HTML message to be passed to mainUploadForm
	 */
	protected function recoverableUploadError( $message ) {
		$sessionKey = $this->mUpload->stashSession();
		$message = '<h2>' . wfMessage( 'uploadwarning' )->escaped() . "</h2>\n" .
			'<div class="error">' . $message . "</div>\n";
		
		$form = $this->getUploadForm( $message, $sessionKey );
		$form->setSubmitText( wfMessage( 'upload-tryagain' )->text() );
		$this->showUploadForm( $form );
	}
	/**
	 * Stashes the upload, shows the main form, but adds an "continue anyway button"
	 *
	 * @param array $warnings
	 */
	protected function uploadWarning( $warnings ) {
		$sessionKey = $this->mUpload->stashSession();

		$warningHtml = '<h2>' . wfMessage( 'uploadwarning' )->escaped() . "</h2>\n"
			. '<ul class="warning">';
		foreach ( $warnings as $warning => $args ) {
				if ( $warning == 'exists' ) {
					$msg = self::getExistsWarning( $args );
				} elseif ( $warning == 'duplicate' ) {
					$msg = self::getDupeWarning( $args );
				} elseif ( $warning == 'duplicate-archive' ) {
					$msg = "\t<li>" . wfMessage(
						'file-deleted-duplicate',
						array( Title::makeTitle( NS_FILE, $args )->getPrefixedText() )
					)->parse() . "</li>\n";
				} else {
					if ( is_bool( $args ) )
						$args = array();
					elseif ( !is_array( $args ) ) {
						$args = array( $args );
					}
					$msg = "\t<li>" . wfMessage( $warning, $args )->parse() . "</li>\n";
				}
				$warningHtml .= $msg;
		}
		$warningHtml .= "</ul>\n";
		$warningHtml .= wfMessage( 'uploadwarning-text' )->parseAsBlock();

		$form = $this->getUploadForm( $warningHtml, $sessionKey, /* $hideIgnoreWarning */ true );
		$form->setSubmitText( wfMessage( 'upload-tryagain' )->text() );
		$form->addButton( 'wpUploadIgnoreWarning', wfMessage( 'ignorewarning' )->text() );
		$form->addButton( 'wpCancelUpload', wfMessage( 'reuploaddesc' )->text() );

		$this->showUploadForm( $form );
	}

	/**
	 * Show the upload form with error message, but do not stash the file.
	 *
	 * @param string $message
	 */
	protected function uploadError( $message ) {
		$message = '<h2>' . wfMessage( 'uploadwarning' )->escaped() . "</h2>\n" .
			'<div class="error">' . $message . "</div>\n";
		$this->showUploadForm( $this->getUploadForm( $message ) );
	}

	/**
	 * Do the upload.
	 * Checks are made in SpecialUpload::execute()
	 */
	protected function processUpload() {
		// Verify permissions
		$permErrors = $this->mUpload->verifyPermissions( $this->getUser() );
		if ( $permErrors !== true )
			return $this->getOutput()->showPermissionsErrorPage( $permErrors );

		// Fetch the file if required
		$status = $this->mUpload->fetchFile();
		if ( !$status->isOK() )
			return $this->showUploadForm( $this->getUploadForm( $this->getOutput()->parse( $status->getWikiText() ) ) );

		if( !wfRunHooks( 'UploadForm:BeforeProcessing', array( &$this ) ) ) {
			wfDebug( "Hook 'UploadForm:BeforeProcessing' broke processing the file.\n" );
			// This code path is deprecated. If you want to break upload processing
			// do so by hooking into the appropriate hooks in UploadBase::verifyUpload
			// and UploadBase::verifyFile.
			// If you use this hook to break uploading, the user will be returned
			// an empty form with no error message whatsoever.
			return;
		}

		// Upload verification
		$details = $this->mUpload->verifyUpload();
		if ( $details['status'] != UploadBase::OK )
			return $this->processVerificationError( $details );

		$this->mLocalFile = $this->mUpload->getLocalFile();

		// Check warnings if necessary
		if ( !$this->mIgnoreWarning ) {
			$warnings = $this->mUpload->checkWarnings();
			if ( count( $warnings ) )
				return $this->uploadWarning( $warnings );
		}

		// Get the page text if this is not a reupload
		if ( !$this->mForReUpload ) {
			$pageText = self::getInitialPageText( $this->mComment, $this->mLicense,
				$this->mCopyrightStatus, $this->mCopyrightSource );
		} else {
			$pageText = false;
		}
		$status = $this->mUpload->performUpload( $this->mComment, $pageText, $this->mWatchthis, $this->getUser() );
		if ( !$status->isGood() )
			return $this->uploadError( $this->getOutput()->parse( $status->getWikiText() ) );

		// $this->getOutput()->redirect( $this->mLocalFile->getTitle()->getFullURL() );
		// Semantic Forms change - output Javascript to either
		// fill in or append to the field in original form, and
		// close the window
		# Chop off any directories in the given filename
		if ( $this->mDesiredDestName ) {
			$basename = $this->mDesiredDestName;
		} elseif ( is_a( $this->mUpload, 'UploadFromFile' ) ) {
			// MediaWiki 1.24+?
			$imageTitle = $this->mUpload->getTitle();
			$basename = $imageTitle->getText();
		} else {
			$basename = $this->mSrcName;
		}

		$basename = str_replace( '_', ' ', $basename );
		// UTF8-decoding is needed for IE.
		// Actually, this doesn't seem to fix the encoding in IE
		// any more... and it messes up the encoding for all other
		// browsers. @TODO - fix handling in IE!
		//$basename = utf8_decode( $basename );
		
		$output = <<<END
		<script type="text/javascript">
		var input = parent.window.jQuery( parent.document.getElementById("{$this->mInputID}") );
END;
		
		if ( $this->mDelimiter == null ) {
			$output .= <<<END
		input.val( '$basename' );
		input.change();
END;
		} else {
			$output .= <<<END
		// if the current value is blank, set it to this file name;
		// if it's not blank and ends in a space or delimiter, append
		// the file name; if it ends with a normal character, append
		// both a delimiter and a file name; and add on a delimiter
		// at the end in any case
		var cur_value = parent.document.getElementById("{$this->mInputID}").value;
		
		if (cur_value === '') {
			input.val( '$basename' + '{$this->mDelimiter} ' );
			input.change();
		} else {
			var last_char = cur_value.charAt(cur_value.length - 1);
			if (last_char == '{$this->mDelimiter}' || last_char == ' ') {
				parent.document.getElementById("{$this->mInputID}").value += '$basename' + '{$this->mDelimiter} ';
				input.change();
			} else {
				parent.document.getElementById("{$this->mInputID}").value += '{$this->mDelimiter} $basename{$this->mDelimiter} ';
				input.change();
			}
		}

END;
		}
		$output .= <<<END
		parent.jQuery.fancybox.close();
	</script>

END;
		// $this->getOutput()->addHTML( $output );
		print $output;
		$img = null; // @todo: added to avoid passing a ref to null - should this be defined somewhere?

		wfRunHooks( 'SpecialUploadComplete', array( &$this ) );
	}

	/**
	 * Get the initial image page text based on a comment and optional file status information
	 */
	public static function getInitialPageText( $comment = '', $license = '', $copyStatus = '', $source = '' ) {
		global $wgUseCopyrightUpload;
		if ( $wgUseCopyrightUpload ) {
			$licensetxt = '';
			if ( $license !== '' ) {
				$licensetxt = '== ' . wfMessage( 'license-header' )->inContentLanguage()->text() . " ==\n" . '{{' . $license . '}}' . "\n";
			}
			$pageText = '== ' . wfMessage ( 'filedesc' )->inContentLanguage()->text() . " ==\n" . $comment . "\n" .
			  '== ' . wfMessage( 'filestatus' )->inContentLanguage()->text() . " ==\n" . $copyStatus . "\n" .
			  "$licensetxt" .
			  '== ' . wfMessage( 'filesource' )->inContentLanguage()->text() . " ==\n" . $source ;
		} else {
			if ( $license !== '' ) {
				$filedesc = $comment === '' ? '' : '== ' . wfMessage( 'filedesc' )->inContentLanguage()->text() . " ==\n" . $comment . "\n";
				 $pageText = $filedesc .
					 '== ' . wfMessage( 'license-header' )->inContentLanguage()->text() . " ==\n" . '{{' . $license . '}}' . "\n";
			} else {
				$pageText = $comment;
			}
		}
		return $pageText;
	}

	/**
	 * See if we should check the 'watch this page' checkbox on the form
	 * based on the user's preferences and whether we're being asked
	 * to create a new file or update an existing one.
	 *
	 * In the case where 'watch edits' is off but 'watch creations' is on,
	 * we'll leave the box unchecked.
	 *
	 * Note that the page target can be changed *on the form*, so our check
	 * state can get out of sync.
	 */
	protected function watchCheck() {
		if ( $this->getUser()->getOption( 'watchdefault' ) ) {
			// Watch all edits!
			return true;
		}

		$local = wfLocalFile( $this->mDesiredDestName );
		if ( $local && $local->exists() ) {
			// We're uploading a new version of an existing file.
			// No creation, so don't watch it if we're not already.
			return $local->getTitle()->userIsWatching();
		} else {
			// New page should get watched if that's our option.
			return $this->getUser()->getOption( 'watchcreations' );
		}
	}


	/**
	 * Provides output to the user for a result of UploadBase::verifyUpload
	 *
	 * @param array $details Result of UploadBase::verifyUpload
	 */
	protected function processVerificationError( $details ) {
		global $wgFileExtensions;

		switch( $details['status'] ) {

			/** Statuses that only require name changing **/
			case UploadBase::MIN_LENGTH_PARTNAME:
				$this->recoverableUploadError( wfMessage( 'minlength1' )->escaped() );
				break;
			case UploadBase::ILLEGAL_FILENAME:
				$this->recoverableUploadError( wfMessage( 'illegalfilename',
					$details['filtered'] )->parse() );
				break;
			case UploadBase::OVERWRITE_EXISTING_FILE:
				$this->recoverableUploadError( wfMessage( $details['overwrite'] )->parse() );
				break;
			case UploadBase::FILETYPE_MISSING:
				$this->recoverableUploadError( wfMessage( 'filetype-missing' )->parse() );
				break;

			/** Statuses that require reuploading **/
			case UploadBase::EMPTY_FILE:
				$this->showUploadForm( $this->getUploadForm( wfMessage( 'emptyfile' )->escaped() ) );
				break;
			case UploadBase::FILETYPE_BADTYPE:
				$finalExt = $details['finalExt'];
				$this->uploadError(
					wfMessage( 'filetype-banned-type',
						htmlspecialchars( $finalExt ), // @todo Double escaping?
						implode(
							wfMessage( 'comma-separator' )->text(),
							$wgFileExtensions
						)
					)->numParams( count( $wgFileExtensions ) )->parse()
				);
				break;
			case UploadBase::VERIFICATION_ERROR:
				unset( $details['status'] );
				$code = array_shift( $details['details'] );
				$this->uploadError( wfMessage( $code, $details['details'] )->parse() );
				break;
			case UploadBase::HOOK_ABORTED:
				$error = $details['error'];
				$this->uploadError( wfMessage( $error )->parse() );
				break;
			default:
				throw new MWException( __METHOD__ . ": Unknown value `{$details['status']}`" );
		}
	}

	/**
	 * Remove a temporarily kept file stashed by saveTempUploadedFile().
	 * @access private
	 * @return success
	 */
	protected function unsaveUploadedFile() {
		if ( !( $this->mUpload instanceof UploadFromStash ) )
			return true;
		$success = $this->mUpload->unsaveUploadedFile();
		if ( ! $success ) {
			$this->getOutput()->showFileDeleteError( $this->mUpload->getTempPath() );
			return false;
		} else {
			return true;
		}
	}

	/*** Functions for formatting warnings ***/

	/**
	 * Formats a result of UploadBase::getExistsWarning as HTML
	 * This check is static and can be done pre-upload via AJAX
	 *
	 * @param array $exists The result of UploadBase::getExistsWarning
	 * @return string Empty string if there is no warning or an HTML fragment
	 * consisting of one or more <li> elements if there is a warning.
	 */
	public static function getExistsWarning( $exists ) {
		if ( !$exists )
			return '';

		$file = $exists['file'];
		$filename = $file->getTitle()->getPrefixedText();
		$warning = array();

		if ( $exists['warning'] == 'exists' ) {
			// Exact match
			$warning[] = '<li>' . wfMessage( 'fileexists', $filename )->parse() . '</li>';
		} elseif ( $exists['warning'] == 'page-exists' ) {
			// Page exists but file does not
			$warning[] = '<li>' . wfMessage( 'filepageexists', $filename )->parse() . '</li>';
		} elseif ( $exists['warning'] == 'exists-normalized' ) {
			$warning[] = '<li>' . wfMessage( 'fileexists-extension', $filename,
				$exists['normalizedFile']->getTitle()->getPrefixedText() )->parse() . '</li>';
		} elseif ( $exists['warning'] == 'thumb' ) {
			// Swapped argument order compared with other messages for backwards compatibility
			$warning[] = '<li>' . wfMessage( 'fileexists-thumbnail-yes',
				$exists['thumbFile']->getTitle()->getPrefixedText(), $filename )->parse() . '</li>';
		} elseif ( $exists['warning'] == 'thumb-name' ) {
			// Image w/o '180px-' does not exists, but we do not like these filenames
			$name = $file->getName();
			$badPart = substr( $name, 0, strpos( $name, '-' ) + 1 );
			$warning[] = '<li>' . wfMessage( 'file-thumbnail-no', $badPart )->parse() . '</li>';
		} elseif ( $exists['warning'] == 'bad-prefix' ) {
			$warning[] = '<li>' . wfMessage( 'filename-bad-prefix', $exists['prefix'] )->parse() . '</li>';
		} elseif ( $exists['warning'] == 'was-deleted' ) {
			# If the file existed before and was deleted, warn the user of this
			$ltitle = SpecialPage::getTitleFor( 'Log' );
			$llink = Linker::linkKnown(
				$ltitle,
				wfMessage( 'deletionlog' )->escaped(),
				array(),
				array(
					'type' => 'delete',
					'page' => $filename
				)
			);
			$warning[] = '<li>' . wfMessage( 'filewasdeleted' )->rawParams( $llink )->parse() . '</li>';
		}

		return implode( "\n", $warning );
	}

	/**
	 * Get a list of warnings
	 *
	 * @param string local filename, e.g. 'file exists', 'non-descriptive filename'
	 * @return array list of warning messages
	 */
	public static function ajaxGetExistsWarning( $filename ) {
		$file = wfFindFile( $filename );
		if ( !$file ) {
			// Force local file so we have an object to do further checks against
			// if there isn't an exact match...
			$file = wfLocalFile( $filename );
		}
		$s = '&#160;';
		if ( $file ) {
			$exists = UploadBase::getExistsWarning( $file );
			$warning = self::getExistsWarning( $exists );
			if ( $warning !== '' ) {
				$s = "<ul>$warning</ul>";
			}
		}
		return $s;
	}

	/**
	 * Render a preview of a given license for the AJAX preview on upload
	 *
	 * @param string $license
	 * @return string
	 */
	public static function ajaxGetLicensePreview( $license ) {
		global $wgParser, $wgUser;
		$text = '{{' . $license . '}}';
		$title = Title::makeTitle( NS_FILE, 'Sample.jpg' );
		$options = ParserOptions::newFromUser( $wgUser );

		// Expand subst: first, then live templates...
		$text = $wgParser->preSaveTransform( $text, $title, $wgUser, $options );
		$output = $wgParser->parse( $text, $title, $options );

		return $output->getText();
	}

	/**
	 * Construct a warning and a gallery from an array of duplicate files.
	 */
	public static function getDupeWarning( $dupes ) {
		if ( $dupes ) {
			global $wgOut;
			$msg = "<gallery>";
			foreach ( $dupes as $file ) {
				$title = $file->getTitle();
				$msg .= $title->getPrefixedText() .
					"|" . $title->getText() . "\n";
			}
			$msg .= "</gallery>";
			return "<li>" .
				wfMessage( "file-exists-duplicate" )->numParams( count( $dupes ) )->parseAsBlock() .
				$wgOut->parse( $msg ) .
				"</li>\n";
		} else {
			return '';
		}
	}

}

/**
 * Sub class of HTMLForm that provides the form section of SpecialUpload
 */
class SFUploadForm extends HTMLForm {
	protected $mWatch;
	protected $mForReUpload;
	protected $mSessionKey;
	protected $mHideIgnoreWarning;
	protected $mDestWarningAck;
	
	protected $mSourceIds;

	public function __construct( $options = array() ) {
		$this->mWatch = !empty( $options['watch'] );
		$this->mForReUpload = !empty( $options['forreupload'] );
		$this->mSessionKey = isset( $options['sessionkey'] )
				? $options['sessionkey'] : '';
		$this->mHideIgnoreWarning = !empty( $options['hideignorewarning'] );
		$this->mDestFile = isset( $options['destfile'] ) ? $options['destfile'] : '';

		$this->mTextTop = isset( $options['texttop'] ) ? $options['texttop'] : '';
		$this->mTextAfterSummary = isset( $options['textaftersummary'] ) ? $options['textaftersummary'] : '';

		$sourceDescriptor = $this->getSourceSection();
		$descriptor = $sourceDescriptor
			+ $this->getDescriptionSection()
			+ $this->getOptionsSection();

		parent::__construct( $descriptor, 'upload' );

		# Set some form properties
		$this->setSubmitText( wfMessage( 'uploadbtn' )->text() );
		$this->setSubmitName( 'wpUpload' );
		$this->setSubmitTooltip( 'upload' );
		$this->setId( 'mw-upload-form' );

		# Build a list of IDs for javascript insertion
		$this->mSourceIds = array();
		foreach ( $sourceDescriptor as $key => $field ) {
			if ( !empty( $field['id'] ) )
				$this->mSourceIds[] = $field['id'];
		}
		// added for Semantic Forms
		$this->addHiddenField( 'sfInputID', $options['sfInputID'] );
		$this->addHiddenField( 'sfDelimiter', $options['sfDelimiter'] );

	}

	/**
	 * Get the descriptor of the fieldset that contains the file source 
	 * selection. The section is 'source'
	 * 
	 * @return array Descriptor array
	 */
	protected function getSourceSection() {
		if ( $this->mSessionKey ) {
			return array(
				'wpSessionKey' => array(
					'type' => 'hidden',
					'default' => $this->mSessionKey,
				),
				'wpSourceType' => array(
					'type' => 'hidden',
					'default' => 'Stash',
				),
			);
		}

		$canUploadByUrl = UploadFromUrl::isEnabled() && $this->getUser()->isAllowed( 'upload_by_url' );
		$radio = $canUploadByUrl;
		$selectedSourceType = strtolower( $this->getRequest()->getText( 'wpSourceType', 'File' ) );

		$descriptor = array();

		if ( $this->mTextTop ) {
			$descriptor['UploadFormTextTop'] = array(
				'type' => 'info',
				'section' => 'source',
				'default' => $this->mTextTop,
				'raw' => true,
			);
		}

		$descriptor['UploadFile'] = array(
				'class' => 'SFUploadSourceField',
				'section' => 'source',
				'type' => 'file',
				'id' => 'wpUploadFile',
				'label-message' => 'sourcefilename',
				'upload-type' => 'File',
				'radio' => &$radio,
				'help' => wfMessage( 'upload-maxfilesize',
						$this->getLanguage()->formatSize(
							wfShorthandToInteger( ini_get( 'upload_max_filesize' ) )
						)
					)->parse() . ' ' . wfMessage( 'upload_source_file' )->escaped(),
				'checked' => $selectedSourceType == 'file',
		);
		if ( $canUploadByUrl ) {
			global $wgMaxUploadSize;
			$descriptor['UploadFileURL'] = array(
				'class' => 'SFUploadSourceField',
				'section' => 'source',
				'id' => 'wpUploadFileURL',
				'label-message' => 'sourceurl',
				'upload-type' => 'Url',
				'radio' => &$radio,
				'help' => wfMessage( 'upload-maxfilesize',
						$this->getLanguage()->formatSize( $wgMaxUploadSize )
					)->parse() . ' ' . wfMessage( 'upload_source_url' )->escaped(),
				'checked' => $selectedSourceType == 'url',
			);
		}

		$descriptor['Extensions'] = array(
			'type' => 'info',
			'section' => 'source',
			'default' => $this->getExtensionsMessage(),
			'raw' => true,
		);
		return $descriptor;
	}


	/**
	 * Get the messages indicating which extensions are preferred and prohibitted.
	 * 
	 * @return string HTML string containing the message
	 */
	protected function getExtensionsMessage() {
		# Print a list of allowed file extensions, if so configured.  We ignore
		# MIME type here, it's incomprehensible to most people and too long.
		global $wgCheckFileExtensions, $wgStrictFileExtensions,
		$wgFileExtensions, $wgFileBlacklist;

		if ( $wgCheckFileExtensions ) {
			if ( $wgStrictFileExtensions ) {
				# Everything not permitted is banned
				$extensionsList =
					'<div id="mw-upload-permitted">' .
						wfMessage( 'upload-permitted', $this->getLanguage()->commaList( $wgFileExtensions ) )->parse() .
					"</div>\n";
			} else {
				# We have to list both preferred and prohibited
				$extensionsList =
					'<div id="mw-upload-preferred">' .
						wfMessage( 'upload-preferred', $this->getLanguage()->commaList( $wgFileExtensions ) )->parse() .
					"</div>\n" .
					'<div id="mw-upload-prohibited">' .
						wfMessage( 'upload-prohibited', $this->getLanguage()->commaList( $wgFileBlacklist ) )->parse() .
					"</div>\n";
			}
		} else {
			# Everything is permitted.
			$extensionsList = '';
		}
		return $extensionsList;
	}

	/**
	 * Get the descriptor of the fieldset that contains the file description
	 * input. The section is 'description'
	 * 
	 * @return array Descriptor array
	 */
	protected function getDescriptionSection() {
		$cols = intval( $this->getUser()->getOption( 'cols' ) );
		if ( $this->getUser()->getOption( 'editwidth' ) ) {
			$this->getOutput()->addInlineStyle( '#mw-htmlform-description { width: 100%; }' );
		}

		$descriptor = array(
			'DestFile' => array(
				'type' => 'text',
				'section' => 'description',
				'id' => 'wpDestFile',
				'label-message' => 'destfilename',
				'size' => 60,
			),
			'UploadDescription' => array(
				'type' => 'textarea',
				'section' => 'description',
				'id' => 'wpUploadDescription',
				'label-message' => $this->mForReUpload
					? 'filereuploadsummary'
					: 'fileuploadsummary',
				'cols' => $cols,
				'rows' => 4,
			),
/*
			'EditTools' => array(
				'type' => 'edittools',
				'section' => 'description',
			),
*/
			'License' => array(
				'type' => 'select',
				'class' => 'Licenses',
				'section' => 'description',
				'id' => 'wpLicense',
				'label-message' => 'license',
			),
		);

		if ( $this->mTextAfterSummary ) {
			$descriptor['UploadFormTextAfterSummary'] = array(
				'type' => 'info',
				'section' => 'description',
				'default' => $this->mTextAfterSummary,
				'raw' => true,
			);
		}

		if ( $this->mForReUpload )
			$descriptor['DestFile']['readonly'] = true;

		global $wgUseCopyrightUpload;
		if ( $wgUseCopyrightUpload ) {
			$descriptor['UploadCopyStatus'] = array(
				'type' => 'text',
				'section' => 'description',
				'id' => 'wpUploadCopyStatus',
				'label-message' => 'filestatus',
			);
			$descriptor['UploadSource'] = array(
				'type' => 'text',
				'section' => 'description',
				'id' => 'wpUploadSource',
				'label-message' => 'filesource',
			);
		}

		return $descriptor;
	}

	/**
	 * Get the descriptor of the fieldset that contains the upload options, 
	 * such as "watch this file". The section is 'options'
	 * 
	 * @return array Descriptor array
	 */
	protected function getOptionsSection() {
		$descriptor = array(
			'Watchthis' => array(
				'type' => 'check',
				'id' => 'wpWatchthis',
				'label-message' => 'watchthisupload',
				'section' => 'options',
			)
		);
		if ( !$this->mHideIgnoreWarning ) {
			$descriptor['IgnoreWarning'] = array(
				'type' => 'check',
				'id' => 'wpIgnoreWarning',
				'label-message' => 'ignorewarnings',
				'section' => 'options',
			);
		}
		$descriptor['DestFileWarningAck'] = array(
			'type' => 'hidden',
			'id' => 'wpDestFileWarningAck',
			'default' => $this->mDestWarningAck ? '1' : '',
		);


		return $descriptor;

	}

	/**
	 * Add the upload JS and show the form.
	 */
	public function show() {
		$this->addUploadJS();
		parent::show();
		// disable output - we'll print out the page manually,
		// taking the body created by the form, plus the necessary
		// Javascript files, and turning them into an HTML page
		global $wgTitle, $wgLanguageCode,
		$wgXhtmlDefaultNamespace, $wgXhtmlNamespaces, $wgContLang;

		$out = $this->getOutput();

		$out->disable();
		$wgTitle = SpecialPage::getTitleFor( 'Upload' );

		$out->addModules( array(
			'mediawiki.action.edit', // For <charinsert> support
			'mediawiki.special.upload', // Extras for thumbnail and license preview.
			'mediawiki.legacy.upload', // For backward compatibility (this was removed 2014-09-10)
		) );

		$text = <<<END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="{$wgXhtmlDefaultNamespace}"
END;
		foreach ( $wgXhtmlNamespaces as $tag => $ns ) {
			$text .= "xmlns:{$tag}=\"{$ns}\" ";
		}
		$dir = $wgContLang->isRTL() ? "rtl" : "ltr";
		$text .= "xml:lang=\"{$wgLanguageCode}\" lang=\"{$wgLanguageCode}\" dir=\"{$dir}\">";

		$text .= <<<END

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
{$out->getHeadScripts()}
</head>
<body>
{$out->getHTML()}
{$out->getBottomScripts()}
</body>
</html>


END;
		print $text;
	}

	/**
	 * Add upload JS to OutputPage
	 * 
	 * @param bool $autofill Whether or not to autofill the destination
	 * 	filename text box
	 */
	protected function addUploadJS( $autofill = true ) {
		global $wgUseAjax, $wgAjaxUploadDestCheck, $wgAjaxLicensePreview;
		global $wgStrictFileExtensions, $wgMaxUploadSize;

		$scriptVars = array(
			'wgAjaxUploadDestCheck' => $wgUseAjax && $wgAjaxUploadDestCheck,
			'wgAjaxLicensePreview' => $wgUseAjax && $wgAjaxLicensePreview,
			'wgUploadAutoFill' => (bool)$autofill &&
				// If we received mDestFile from the request, don't autofill
				// the wpDestFile textbox
				$this->mDestFile === '',
			'wgUploadSourceIds' => $this->mSourceIds,
			'wgStrictFileExtensions' => $wgStrictFileExtensions,
			'wgCapitalizeUploads' => MWNamespace::isCapitalized( NS_FILE ),
			'wgMaxUploadSize' => $wgMaxUploadSize,
		);

		$this->getOutput()->addScript( Skin::makeVariablesScript( $scriptVars ) );
	}

	/**
	 * Empty function; submission is handled elsewhere.
	 * 
	 * @return bool false
	 */
	function trySubmit() {
		return false;
	}

}

/**
 * A form field that contains a radio box in the label.
 */
class SFUploadSourceField extends HTMLTextField {
	
	function getLabelHtml( $cellAttributes = array() ) {
		$id = "wpSourceType{$this->mParams['upload-type']}";
		$label = Html::rawElement( 'label', array( 'for' => $id ), $this->mLabel  );

		if ( !empty( $this->mParams['radio'] ) ) {
			$attribs = array(
				'name' => 'wpSourceType',
				'type' => 'radio',
				'id' => $id,
				'value' => $this->mParams['upload-type'],
			);
			
			if ( !empty( $this->mParams['checked'] ) )
				$attribs['checked'] = 'checked';
			$label .= Html::element( 'input', $attribs );
		}

		return Html::rawElement( 'td', array( 'class' => 'mw-label' ), $label );
	}
	
	function getSize() {
		return isset( $this->mParams['size'] )
			? $this->mParams['size']
			: 60;
	}
	
	/**
	 * This page can be shown if uploading is enabled.
	 * Handle permission checking elsewhere in order to be able to show
	 * custom error messages.
	 *
	 * @param User $user
	 * @return bool
	 */
	public function userCanExecute( User $user ) {
		return UploadBase::isEnabled() && parent::userCanExecute( $user );
	}

}

<?php
/**
 * Form for handling multiple uploads and special page.
 *
 * @file
 * @ingroup SpecialPage
 * @ingroup Upload
 */

class MultipleUpload extends SpecialUpload {
	public $mDesiredDestNames;
	public $mUploads;
	public $mUploadHasBeenShown;
	public $mSessionKeys;

	// status messagse for multiple files
	public $mWarnings;
	public $mSuccesses;
	public $mErrors;

	/**
	 * Constructor : initialise object
	 * Get data POSTed through the form and assign them to the object
	 * @param WebRequest $request Data posted.
	 */
	public function __construct( $request = null ) {
		global $wgRequest;

		SpecialPage::__construct( 'MultipleUpload', 'upload' );

		$this->loadRequest( is_null( $request ) ? $wgRequest : $request );
		$this->mUploadHasBeenShown = false;
		$this->mSessionKeys = array();
		$this->mWarnings = array();
		$this->mSuccesses = array();
		$this->mErrors = array();
	}

	/**
	 * Initialize instance variables from request and create an Upload handler
	 *
	 * @param WebRequest $request The request to extract variables from
	 */
	protected function loadRequest( $request ) {
		global $wgUser, $wgMaxUploadFiles;

		// let's make the parent happy
		wfSuppressWarnings();
		$_FILES['wpUploadFile'] = $_FILES['wpUploadFile0'];
		wfRestoreWarnings();
		// Guess the desired name from the filename if not provided
		$this->mDesiredDestNames = array();
		$this->mUploads			 = array();

		// deal with session keys, if we have some pick the first one, for now
		$vals = $request->getValues();
		$fromsession = false;
		foreach ( $vals as $k => $v ) {
			if ( preg_match( "@^wpSessionKey@", $k ) ) {
				$request->setVal( 'wpSessionKey', $v );
				$fromsession = true;
				$filenum = preg_replace( "@wpSessionKey@", '', $k );
				$request->setVal( 'wpDestFile', $request->getVal( 'wpDestFile' . $filenum ) );
				$up = UploadBase::createFromRequest( $request );
				$this->mUploads[] = $up;
				$this->mDesiredDestNames[] = $request->getVal( 'wpDestFile' . $filenum );
			}
		}

		parent::loadRequest( $request );

		$this->mUploadClicked = $request->wasPosted()
			&& ( $request->getCheck( 'wpUpload' )
				|| $request->getCheck( 'wpUploadIgnoreWarning' ) );

		if ( !$fromsession ) {
			for ( $i = 0; $i < $wgMaxUploadFiles; $i++ ) {
				$this->mDesiredDestNames[$i] = $request->getText( 'wpDestFile'. $i );
				if( !$this->mDesiredDestNames[$i] && $request->getFileName( 'wpUploadFile' . $i ) !== null ) {
					$this->mDesiredDestNames[$i] = $request->getFileName( 'wpUploadFile' . $i );
				}
				wfSuppressWarnings();
				$request->setVal( 'wpUploadFile', $_FILES['wpUploadFile' . $i] );
				wfRestoreWarnings();
				$request->setVal( 'wpDestFile', $request->getVal( 'wpDestFile' . $i ) );
				move_uploaded_file( 'wpUploadFile' . $i, 'wpUploadFile' );
				wfSuppressWarnings();
				$_FILES['wpUploadFile'] = $_FILES['wpUploadFile' . $i];
				wfRestoreWarnings();
				$up = UploadBase::createFromRequest( $request );
				$this->mUploads[$i] = $up;
			}
		}
		$this->mDesiredDestName = $this->mDesiredDestNames[0];
		$this->mUpload= $this->mUploads[0];
	}

	function showUploadForm( $form ) {
		if ( $this->mUploadHasBeenShown ) {
			return;
		}
		parent::showUploadForm( $form );
		$this->mUploadHasBeenShown = true;
	}

	/**
	 * Get an UploadForm instance with title and text properly set.
	 *
	 * @param string $message HTML string to add to the form
	 * @param string $sessionKey Session key in case this is a stashed upload
	 * @return UploadForm
	 */
	protected function getUploadForm( $message = '', $sessionKeys = array(), $hideIgnoreWarning = false ) {
		global $wgOut, $wgMaxUploadFiles;

		# Initialize form
		$options = array(
			'watch' => $this->getWatchCheck(),
			'forreupload' => $this->mForReUpload,
			'hideignorewarning' => $hideIgnoreWarning,
			'destwarningack' => (bool)$this->mDestWarningAck,
			'texttop' => $this->uploadFormTextTop,
			'textaftersummary' => $this->uploadFormTextAfterSummary,
		);
		foreach ( $this->mSessionKeys as $f => $key ) {
			$options['sessionkey'. $f] = $key;
		}
		for ( $i = 0; $i < $wgMaxUploadFiles; $i++ ) {
			$options['destfile' . $i] = $this->mDesiredDestNames[$i];
		}
		$form = new MultiUploadForm( $options );
		$form->setTitle( $this->getTitle() );

		# Check the token, but only if necessary
		if( !$this->mTokenOk && !$this->mCancelUpload
				&& ( $this->mUploads[0] && $this->mUploadClicked ) ) {
			$form->addPreText( wfMsgExt( 'session_fail_preview', 'parseinline' ) );
		}

		# Add text to form
		$form->addPreText( '<div id="uploadtext">' .
			wfMsgExt( 'uploadtext', 'parse', array( $this->mDesiredDestName ) ) .
			'</div>' );
		# Add upload error message
		$form->addPreText( $message );

		# Add footer to form
		$uploadFooter = wfMsgNoTrans( 'uploadfooter' );
		if ( $uploadFooter != '-' && !wfEmptyMsg( 'uploadfooter', $uploadFooter ) ) {
			$form->addPostText( '<div id="mw-upload-footer-message">'
				. $wgOut->parse( $uploadFooter ) . "</div>\n" );
		}

		return $form;
	}

	/**
	 * Shows the "view X deleted revivions link"
	 */
	protected function showViewDeletedLinks() {
		global $wgMaxUploadFiles;
		for ( $i = 0; $i < $wgMaxUploadFiles; $i++ ) {
			$this->showViewDeletedLinksInner( $this->mDesiredDestNames[$i] );
		}
	}

	protected function showViewDeletedLinksInner( $name ) {
		global $wgOut, $wgUser;

		$title = Title::makeTitleSafe( NS_FILE, $this->mDesiredDestName );
		// Show a subtitle link to deleted revisions (to sysops et al only)
		if( $title instanceof Title ) {
			$count = $title->isDeleted();
			if ( $count > 0 && $wgUser->isAllowed( 'deletedhistory' ) ) {
				$link = wfMsgExt(
					$wgUser->isAllowed( 'delete' ) ? 'thisisdeleted' : 'viewdeleted',
					array( 'parse', 'replaceafter' ),
					$wgUser->getSkin()->linkKnown(
						SpecialPage::getTitleFor( 'Undelete', $title->getPrefixedText() ),
						wfMsgExt( 'restorelink', array( 'parsemag', 'escape' ), $count )
					)
				);
				$wgOut->addHTML( "<div id=\"contentSub2\">{$link}</div>" );
			}
		}

		// Show the relevant lines from deletion log (for still deleted files only)
		if( $title instanceof Title && $title->isDeletedQuick() && !$title->exists() ) {
			$this->showDeletionLog( $wgOut, $title->getPrefixedText() );
		}
	}

	/**
	 * Stashes the upload, shows the main form, but adds an "continue anyway button".
	 * Also checks whether there are actually warnings to display.
	 *
	 * @param $warnings Array
	 * @return Boolean: true if warnings were displayed, false if there are no
	 * 	warnings and the should continue processing like there was no warning
	 */
	protected function showUploadWarning( $warnings ) {
		global $wgUser;

		# If there are no warnings, or warnings we can ignore, return early.
		# mDestWarningAck is set when some javascript has shown the warning
		# to the user. mForReUpload is set when the user clicks the "upload a
		# new version" link.
		if ( !$warnings || ( count( $warnings ) == 1 &&
			isset( $warnings['exists'] ) &&
			( $this->mDestWarningAck || $this->mForReUpload ) ) )
		{
			return false;
		}

		$sessionKey = $this->mUpload->stashSession();

		$sk = $wgUser->getSkin();

		$warningHtml = '<h2>' . wfMsgHtml( 'uploadwarning' ) . "</h2>\n"
			. '<ul class="warning">';
		foreach( $warnings as $warning => $args ) {
				$msg = '';
				if( $warning == 'exists' ) {
					$msg = "\t<li>" . self::getExistsWarning( $args ) . "</li>\n";
				} elseif( $warning == 'duplicate' ) {
					$msg = self::getDupeWarning( $args, $this->mLocalFile->getTitle() );
				} elseif( $warning == 'duplicate-archive' ) {
					$msg = "\t<li>" . wfMsgExt( 'file-deleted-duplicate', 'parseinline',
							array( Title::makeTitle( NS_FILE, $args )->getPrefixedText() ) )
						. "</li>\n";
				} else {
					if ( $args === true ) {
						$args = array();
					} elseif ( !is_array( $args ) ) {
						$args = array( $args );
					}
					$msg = "\t<li>" . wfMsgExt( $warning, 'parseinline', $args ) . "</li>\n";
				}
				$warningHtml .= $msg;
		}
		$warningHtml .= "</ul>\n";
		$warningHtml .= wfMsgExt( 'uploadwarning-text', 'parse' );

		// store it in an array to show later
		$this->mWarnings[] = $warningHtml;
		$this->mSessionKeys[$this->mUpload->getLocalFile()->getName()] = $sessionKey;

		# Indicate that we showed a form
		return true;
	}

	/**
	 * Show the upload form with error message, but do not stash the file.
	 *
	 * @param $message String
	 */
	protected function showUploadError( $message ) {
		$err ='<ul><li>';
		$file = $this->mLocalFile;
		if ($file)
			$t = $this->mLocalFile->getTitle();
		if ($t)
			$err .= $t->getFullText() . ":";
		$err .= $message . "</li></ul>\n";
		$this->mErrors[] = $err;
	}

	/**
	 * Do the upload.
	 * Checks are made in SpecialUpload::execute()
	 */
	protected function processUpload() {
		global $wgMaxUploadFiles, $wgOut;

		for ( $i = 0; $i < $wgMaxUploadFiles; $i++ ) {
			if ( isset( $this->mUploads[$i] ) ) {
				$this->mUpload = $this->mUploads[$i];
				$this->mUploadSuccessful = false; // reset
				parent::processUpload();
				if ( $this->mUploadSuccessful ) {
					$this->mSuccesses[] = "<ul><li><a href='" . $this->mLocalFile->getTitle()->getFullURL() .
						"' target='new'>{$this->mLocalFile->getTitle()->getFullText()}: " .
						wfMsg( 'multiupload-fileuploaded' ) . '</a></li></ul>';
				}
			}
		}
		// clear out the redirects
		$wgOut->redirect( '' );

		// tell the good news first
		if ( sizeof( $this->mSuccesses ) > 0 ) {
			$wgOut->addHTML( '<h2>' . wfMsgHtml( 'successfulupload' ) . "</h2>\n" );
			$wgOut->addHTML( implode( $this->mSuccesses ) );
		}

		// the bad news
		if ( sizeof( $this->mErrors ) > 0 ) {
			$wgOut->addHTML( '<h2>' . wfMsgHtml( 'uploadwarning' ) . "</h2>\n" );
			$wgOut->addHTML( implode( $this->mErrors ) );
		}

		// the hopefully recoverable news
		if ( sizeof( $this->mWarnings ) > 0 || sizeof( $this->mErrors ) > 0 ) {
			$wgOut->addHTML( '<br /><br /><hr />' ); // visually separate the form from the errors/successes
			$form = $this->getUploadForm( implode( $this->mWarnings ), $this->mSessionKeys, /* $hideIgnoreWarning */ true );
			$form->setSubmitText( wfMsg( 'upload-tryagain' ) );
			$form->addButton( 'wpUploadIgnoreWarning', wfMsg( 'ignorewarning' ) );
			$form->addButton( 'wpCancelUpload', wfMsg( 'reuploaddesc' ) );
			$this->showUploadForm( $form );
		}
	}


	/**
	 * Remove a temporarily kept file stashed by saveTempUploadedFile().
	 *
	 * @return Boolean: success
	 */
	protected function unsaveUploadedFile() {
		global $wgMaxUploadFiles;
		$ret = true;
		for ( $i = 0; $i < $wgMaxUploadFiles; $i++ ) {
			if ( isset( $this->mUploads[$i] ) ) {
				$this->mUpload = $this->mUploads[$i];
				// return false if even one of them failed
				$ret = $ret && parent::unsaveUploadedFile();
			}
		}
		return $ret;
	}

	/**
	 * Construct a warning and a gallery from an array of duplicate files.
	 * Override because the original doesn't say which file is a dupe
	 */
	public static function getDupeWarning( $dupes, $dupetitle = null ) {
		$result = parent::getDupeWarning( $dupes );
		return preg_replace( "@<li>@", "<li>{$dupetitle->getText()}", $result );
	}

}

/**
 * Sub class of HTMLForm that provides the form section of SpecialUpload
 */
class MultiUploadForm extends UploadForm {

	protected $mDestFiles;
	protected $mSessionKeys;

	public function __construct( $options = array() ) {
		// basically we want to map filenames to session keys here somehow
		global $wgMaxUploadFiles;
		$this->mDestFiles = array();
		for( $i = 0; $i < $wgMaxUploadFiles; $i++ ) {
			$this->mDestFiles[$i] = $options['destfile'. $i];
		}
		$this->mSessionKeys = array();
		foreach ( $options as $k => $v ) {
			if ( preg_match( "@^sessionkey@", $k ) ) {
				$this->mSessionKeys[$k] = $v;
			}
		}
		parent::__construct( $options );
	}

	protected function getDescriptionSection() {
		// get the usual one and clear out the DestFile
		$descriptor = parent::getDescriptionSection();
		unset( $descriptor['DestFile'] );
		return $descriptor;
	}

	/**
	 * Get the descriptor of the fieldset that contains the file source
	 * selection. The section is 'source'
	 *
	 * @return array Descriptor array
	 */
	protected function getSourceSection() {
		global $wgLang, $wgUser, $wgRequest, $wgMaxUploadFiles;

		if ( sizeof( $this->mSessionKeys ) > 0) {
			$data = array(
				'wpSourceType' => array(
					'type' => 'hidden',
					'default' => 'Stash',
				),
			);
			$index = 0;
			foreach ( $this->mDestFiles as $k => $v ) {
				if ( $v == '' ) {
					continue;
				}
				$data['wpDestFile' . $index] = array(
					'type' => 'hidden',
					'default' => $v,
				);
				$data['wpSessionKey' . $index] = array(
					'type' => 'hidden',
					'default' => $this->mSessionKeys['sessionkey' . $v],
				);
				$index++;
			}
			return $data;
		}

		$canUploadByUrl = UploadFromUrl::isEnabled() && $wgUser->isAllowed( 'upload_by_url' );
		$radio = $canUploadByUrl;
		$selectedSourceType = strtolower( $wgRequest->getText( 'wpSourceType', 'File' ) );

		$descriptor = array();
		if ( $this->mTextTop ) {
			$descriptor['UploadFormTextTop'] = array(
				'type' => 'info',
				'section' => 'source',
				'default' => $this->mTextTop,
				'raw' => true,
			);
		}

		for ( $i = 0; $i < $wgMaxUploadFiles; $i++ ) {
			$descriptor['UploadFile' . $i] = array(
				'class' => 'UploadSourceField',
				'section' => 'source',
				'type' => 'file',
				'id' => 'wpUploadFile' . $i,
				'label-message' => 'sourcefilename',
				'upload-type' => 'File',
				'radio' => &$radio,
				'checked' => $selectedSourceType == 'file',
			);
			$descriptor['DestFile' . $i] = array(
				'type' => 'text',
				'section' => 'source',
				'id' => 'wpDestFile' . $i,
				'label-message' => 'destfilename',
				'size' => 60,
				'default' => $this->mDestFiles[$i],
				# FIXME: hack to work around poor handling of the 'default' option in HTMLForm
				'nodata' => strval( $this->mDestFile ) !== '',
			);

			if ( $canUploadByUrl ) {
				global $wgMaxUploadSize;
				$descriptor['UploadFileURL'] = array(
					'class' => 'UploadSourceField',
					'section' => 'source',
					'id' => 'wpUploadFileURL',
					'label-message' => 'sourceurl',
					'upload-type' => 'url',
					'radio' => &$radio,
					'help' => wfMsgExt( 'upload-maxfilesize',
							array( 'parseinline', 'escapenoentities' ),
							$wgLang->formatSize( $wgMaxUploadSize )
						) . ' ' . wfMsgHtml( 'upload_source_url' ),
					'checked' => $selectedSourceType == 'url',
				);
			}
		}
		wfRunHooks( 'UploadFormSourceDescriptors', array( &$descriptor, &$radio, $selectedSourceType ) );

		$descriptor['Extensions'] = array(
			'type' => 'info',
			'section' => 'source',
			'default' => $this->getExtensionsMessage(),
			'raw' => true,
				'help' => wfMsgExt( 'upload-maxfilesize',
						array( 'parseinline', 'escapenoentities' ),
						$wgLang->formatSize(
							wfShorthandToInteger( ini_get( 'upload_max_filesize' ) )
						)
					) . ' ' . wfMsgHtml( 'upload_source_file' ),
		);
		return $descriptor;
	}

	/**
	 * Add upload JavaScript to $wgOut
	 */
	protected function addUploadJS() {
		global $wgScriptPath, $wgMaxUploadFiles, $wgFileExtensions;

		global $wgUseAjax, $wgAjaxUploadDestCheck, $wgAjaxLicensePreview, $wgEnableAPI;
		global $wgOut;

		$useAjaxDestCheck = $wgUseAjax && $wgAjaxUploadDestCheck;
		$useAjaxLicensePreview = $wgUseAjax && $wgAjaxLicensePreview && $wgEnableAPI;

		$scriptVars = array(
			'wgAjaxUploadDestCheck' => $useAjaxDestCheck,
			'wgAjaxLicensePreview' => $useAjaxLicensePreview,
			'wgUploadAutoFill' => !$this->mForReUpload &&
				// If we received mDestFile from the request, don't autofill
				// the wpDestFile textbox
				$this->mDestFile === '',
			'wgUploadSourceIds' => $this->mSourceIds,
		);

		$wgOut->addScript( Skin::makeVariablesScript( $scriptVars ) );

		// For <charinsert> support
		$wgOut->addScriptFile( 'edit.js' );

		// changed
		$wgOut->addScriptFile( "$wgScriptPath/extensions/MultiUpload/multiupload.js" );
		$newscriptVars = array(
			'wgMaxUploadFiles' => $wgMaxUploadFiles,
			'wgFileExtensions' => $wgFileExtensions
		);
		$wgOut->addScript( Skin::makeVariablesScript( $newscriptVars ) );
	}

}


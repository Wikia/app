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

	// status messages for multiple files
	public $mWarnings;
	public $mSuccesses;
	public $mErrors;

	/**
	 * Constructor : initialise object
	 * Get data POSTed through the form and assign them to the object
	 * @param WebRequest $request Data posted.
	 */
	public function __construct( $request = null ) {
		SpecialPage::__construct( 'MultipleUpload', 'upload' );

		$this->mUploadHasBeenShown = false;
		$this->mSessionKeys = array();
		$this->mWarnings = array();
		$this->mSuccesses = array();
		$this->mErrors = array();
	}

	/**
	 * ShoutWiki change -- gets and returns the amount of files a user can
	 * upload at once.
	 *
	 * @return Integer: amount of files the user can upload at once
	 */
	public static function getMaxUploadFiles() {
		global $wgUser, $wgMaxUploadFiles;
		$groups = $wgUser->getEffectiveGroups();
		if( in_array( 'staff', $groups ) ) {
			$wgMaxUploadFiles = 40;
		} elseif( in_array( 'sysop', $groups ) ) {
			$wgMaxUploadFiles = 20;
		} elseif( in_array( 'autoconfirmed', $groups ) ) {
			$wgMaxUploadFiles = 10;
		} else {
			$wgMaxUploadFiles = 5;
		}
		return $wgMaxUploadFiles;
	}

	/**
	 * Initialize instance variables from request and create an Upload handler
	 *
	 * @param WebRequest $request The request to extract variables from
	 */
	protected function loadRequest() {
		$request = $this->getRequest();

		// let's make the parent happy
		wfSuppressWarnings();
		$_FILES['wpUploadFile'] = $_FILES['wpUploadFile0'];
		wfRestoreWarnings();
		// Guess the desired name from the filename if not provided
		$this->mDesiredDestNames = array();
		$this->mUploads = array();

		// deal with session keys, if we have some pick the first one, for now
		$vals = $request->getValues();
		$fromSession = false;
		$maxUploadFiles = MultipleUpload::getMaxUploadFiles();
		$cntSessionKey = 0;
		foreach ( $vals as $k => $v ) {
			if ( preg_match( '@^wpSessionKey@', $k ) ) {
				$cntSessionKey++;
				if ( $cntSessionKey > $maxUploadFiles ) {
					break;
				}
				$request->setVal( 'wpSessionKey', $v );
				$fromSession = true;
				$filenum = preg_replace( '@wpSessionKey@', '', $k );
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

		if ( !$fromSession ) {
			for ( $i = 0; $i < $maxUploadFiles; $i++ ) {
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
				if ( $up ) {
					$this->mUploads[] = $up;
				}
			}
		}
		$this->mDesiredDestName = $this->mDesiredDestNames[0];
		$this->mUpload = $this->mUploads[0];
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
			$options['sessionkey' . $f] = $key;
		}
		for ( $i = 0; $i < count($this->mDesiredDestNames); $i++ ) {
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
				. $this->getOutput()->parse( $uploadFooter ) . "</div>\n" );
		}

		return $form;
	}

	/**
	 * Shows the "view X deleted revivions link"
	 */
	protected function showViewDeletedLinks() {
		foreach ( $this->mDesiredDestNames as $desiredDestName ) {
			$this->showViewDeletedLinksInner( $desiredDestName );
		}
	}

	protected function showViewDeletedLinksInner( $name ) {
		$title = Title::makeTitleSafe( NS_FILE, $name );
		// Show a subtitle link to deleted revisions (to sysops et al only)
		if( $title instanceof Title ) {
			$count = $title->isDeleted();
			$user = $this->getUser();
			if ( $count > 0 && $user->isAllowed( 'deletedhistory' ) ) {
				$link = wfMsgExt(
					$user->isAllowed( 'delete' ) ? 'thisisdeleted' : 'viewdeleted',
					array( 'parse', 'replaceafter' ),
					Linker::linkKnown(
						SpecialPage::getTitleFor( 'Undelete', $title->getPrefixedText() ),
						wfMsgExt( 'restorelink', array( 'parsemag', 'escape' ), $count )
					)
				);
				$this->getOutput()->addHTML( "<div id=\"contentSub2\">{$link}</div>" );
			}
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
		$hashed = md5( $this->mUpload->getTitle()->getDBKey() );
		$this->mSessionKeys[$hashed] = $sessionKey;

		# Indicate that we showed a form
		return true;
	}

	/**
	 * Show the upload form with error message, but do not stash the file.
	 *
	 * @param $message String
	 */
	protected function showUploadError( $message ) {
		$err = '<ul><li>';
		$file = $this->mLocalFile;
		if ( $file ) {
			$t = $this->mLocalFile->getTitle();
			if ( $t ) {
				$err .= $t->getFullText() . ':';
			}
		}
		$err .= $message . "</li></ul>\n";
		$this->mErrors[] = $err;
	}

	/**
	 * Do the upload.
	 * Checks are made in SpecialUpload::execute()
	 */
	protected function processUpload() {
		for ( $i = 0; $i < MultipleUpload::getMaxUploadFiles(); $i++ ) {
			if ( isset( $this->mUploads[$i] ) ) {
				$this->mUpload = $this->mUploads[$i];
				$title = $this->mUpload->getTitle();
				if ( !empty( $title ) ) {
					$this->mUploadSuccessful = false; // reset
					parent::processUpload();
					if ( $this->mUploadSuccessful ) {
						$this->mSuccesses[] = "<ul><li><a href='" . $this->mLocalFile->getTitle()->getFullURL() .
							"' target='new'>{$this->mLocalFile->getTitle()->getFullText()}: " .
							wfMsg( 'multiupload-fileuploaded' ) . '</a></li></ul>';
					}
				}
			}
		}

		$out = $this->getOutput();

		// clear out the redirects
		$out->redirect( '' );

		// tell the good news first
		if ( sizeof( $this->mSuccesses ) > 0 ) {
			$out->addHTML( '<h2>' . wfMsgHtml( 'multiupload-successful-upload' ) . "</h2>\n" );
			$out->addHTML( implode( $this->mSuccesses ) );
		}

		// the bad news
		if ( sizeof( $this->mErrors ) > 0 ) {
			$out->addHTML( '<h2>' . wfMsgHtml( 'uploaderror' ) . "</h2>\n" );
			$out->addHTML( implode( $this->mErrors ) );
		}

		// the hopefully recoverable news
		if ( sizeof( $this->mWarnings ) > 0 || sizeof( $this->mErrors ) > 0 ) {
			$out->addHTML( '<br /><br /><hr />' ); // visually separate the form from the errors/successes
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
		$ret = true;
		foreach ( $this->mUploads as $upload ) {
			$this->mUpload = $upload;
			// return false if even one of them failed
			$ret = $ret && parent::unsaveUploadedFile();
		}
		return $ret;
	}

	/**
	 * Construct a warning and a gallery from an array of duplicate files.
	 * Override because the original doesn't say which file is a dupe
	 */
	public static function getDupeWarning( $dupes, $dupeTitle = null ) {
		$result = parent::getDupeWarning( $dupes );
		return preg_replace( '@<li>@', "<li>{$dupeTitle->getText()}", $result );
	}

}

/**
 * Sub class of HTMLForm that provides the form section of SpecialUpload
 */
class MultiUploadForm extends UploadForm {

	protected $mDestFiles;
	protected $mSessionKeys;

	public function __construct( $options = array(), $context = null, $messagePrefix = 'multiupload' ) {
		// basically we want to map filenames to session keys here somehow
		$this->mDestFiles = array();
		for( $i = 0; $i < MultipleUpload::getMaxUploadFiles(); $i++ ) {
			$this->mDestFiles[$i] = ( empty( $options['destfile'. $i] ) ) ? '' : $options['destfile'. $i];
		}
		$this->mSessionKeys = array();
		foreach ( $options as $k => $v ) {
			if ( preg_match( '@^sessionkey@', $k ) ) {
				$this->mSessionKeys[$k] = $v;
			}
		}
		// In an ideal world, this would work:
		#parent::__construct( $options, $context, $messagePrefix );
		// But MediaWiki is MediaWiki, so of course you can't pass the third
		// parameter to UploadForm::__construct(), but instead it hardcodes it
		// to 'upload'...great. So, we have to duplicate that function here. :(
		$this->mWatch = !empty( $options['watch'] );
		$this->mForReUpload = !empty( $options['forreupload'] );
		$this->mSessionKey = isset( $options['sessionkey'] )
				? $options['sessionkey'] : '';
		$this->mHideIgnoreWarning = !empty( $options['hideignorewarning'] );
		$this->mDestWarningAck = !empty( $options['destwarningack'] );
		$this->mDestFile = isset( $options['destfile'] ) ? $options['destfile'] : '';

		$this->mComment = isset( $options['description'] ) ?
			$options['description'] : '';

		$this->mTextTop = isset( $options['texttop'] )
			? $options['texttop'] : '';

		$this->mTextAfterSummary = isset( $options['textaftersummary'] )
			? $options['textaftersummary'] : '';

		$sourceDescriptor = $this->getSourceSection();
		$descriptor = $sourceDescriptor
			+ $this->getDescriptionSection()
			+ $this->getOptionsSection();

		$this->setMessagePrefix( 'multiupload' );
		HTMLForm::__construct( $descriptor, $context, 'multiupload' ); // here's the change

		# Set some form properties
		$this->setSubmitText( wfMsg( 'uploadbtn' ) );
		$this->setSubmitName( 'wpUpload' );
		# Used message keys: 'accesskey-upload', 'tooltip-upload'
		$this->setSubmitTooltip( 'upload' );
		$this->setId( 'mw-upload-form' );

		# Build a list of IDs for javascript insertion
		$this->mSourceIds = array();
		foreach ( $sourceDescriptor as $field ) {
			if ( !empty( $field['id'] ) ) {
				$this->mSourceIds[] = $field['id'];
			}
		}
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
		if ( sizeof( $this->mSessionKeys ) > 0 ) {
			$data = array(
				'SourceType' => array(
					'type' => 'hidden',
					'default' => 'Stash',
				),
			);
			$index = 0;
			foreach ( $this->mDestFiles as $k => $v ) {
				if ( $v == '' ) {
					continue;
				}
				$data['DestFile' . $index] = array(
					'type' => 'hidden',
					'default' => $v,
				);
				$hashed = md5( $v );
				if ( !empty($this->mSessionKeys['sessionkey' . $hashed]) ) {
					$data['SessionKey' . $index] = array(
						'type' => 'hidden',
						'default' => $this->mSessionKeys['sessionkey' . $hashed],
					);
				}
				$index++;
			}
			return $data;
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

		for ( $i = 0; $i < MultipleUpload::getMaxUploadFiles(); $i++ ) {
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
							$this->getLang()->formatSize( $wgMaxUploadSize )
						) . ' ' . wfMsgHtml( 'upload_source_url' ),
					'checked' => $selectedSourceType == 'url',
				);
			}
		}

		$descriptor['Extensions'] = array(
			'type' => 'info',
			'section' => 'source',
			'default' => $this->getExtensionsMessage(),
			'raw' => true,
				'help' => wfMsgExt( 'upload-maxfilesize',
						array( 'parseinline', 'escapenoentities' ),
						$this->getLang()->formatSize(
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
		global $wgExtensionsPath, $wgFileExtensions;

		global $wgUseAjax, $wgAjaxUploadDestCheck, $wgAjaxLicensePreview, $wgEnableAPI;

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

		$out = $this->getOutput();
		$out->addScript( Skin::makeVariablesScript( $scriptVars ) );

		// changed
		$out->addScriptFile( "$wgExtensionsPath/MultiUpload/multiupload.js" );
		$newscriptVars = array(
			'wgMaxUploadFiles' => MultipleUpload::getMaxUploadFiles(),
			'wgFileExtensions' => $wgFileExtensions
		);
		$out->addScript( Skin::makeVariablesScript( $newscriptVars ) );
	}

}
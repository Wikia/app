<?php
class ThemeDesignerController extends WikiaController {

	public function init() {
		$this->backgroundImageName = null;
		$this->backgroundImageUrl = null;
		$this->backgroundImageAlign = null;
		$this->backgroundImageThumb = null;
		$this->backgroundImageWidth = null;
		$this->backgroundImageHeight = null;
		$this->wordmarkImageName = null;
		$this->wordmarkImageUrl = null;
		$this->errors = array();

		$this->dir = $this->wg->ContLang->getDir();
		$this->mimetype = $this->wg->Mimetype;
		$this->charset = $this->wg->OutputEncoding;
	}

	public function executeIndex() {
		wfProfileIn( __METHOD__ );
		global $wgLang, $wgOut;

		$themeSettings = new ThemeSettings();

		// current settings
		$this->themeSettings = $themeSettings->getSettings();

		// application theme settings (not user settable)
		$this->applicationThemeSettings = SassUtil::getApplicationThemeSettings();

		// recent versions
		$themeHistory = array_reverse($themeSettings->getHistory());

		// format time (for edits older than 30 days - show timestamp)
		foreach($themeHistory as &$entry) {
			$diff = time() - strtotime( $entry['timestamp'] );

			if($diff < 30 * 86400) {
				$entry['timeago'] = wfTimeFormatAgo($entry['timestamp']);
			} else {
				$entry['timeago'] = $wgLang->date($entry['timestamp']);
			}
		}
		$this->themeHistory = $themeHistory;

		// URL user should be redirected to when settings are saved
		if(isset($_SERVER['HTTP_REFERER'])) {
			$this->returnTo = $_SERVER['HTTP_REFERER'];
		} else {
			$this->returnTo = $this->wg->Script;
		}

		// load Google Analytics code
		$this->analytics = AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);

		$wgOut->getResourceLoader()->getModule( 'mediawiki' );

		$ret = implode( "\n", array(
			$wgOut->getHeadLinks( null, true ),
			$wgOut->buildCssLinks(),
			$wgOut->getHeadScripts(),
			$wgOut->getHeadItems()
		) );

		$this->globalVariablesScript = $ret;

		wfProfileOut( __METHOD__ );
	}

	public function executeThemeTab() {

	}

	public function executeCustomizeTab() {

	}

	public function executeWordmarkTab() {
		global $wgFavicon;
		$this->faviconUrl = wfReplaceImageServer($wgFavicon);
	}

	public function executePicker() {

	}

	public function executePreview() {

	}

	/**
	 *
	 * @author Federico "Lox" Lucignano
	 */
	private function getUploadErrorMessage( $status ) {
		global $wgFileExtensions, $wgLang;

		switch( $status[ 'status' ] ) {
			case UploadBackgroundFromFile::FILESIZE_ERROR:
				$msg = wfMsgHtml( 'themedesigner-size-error' );
				break;
			case UploadBackgroundFromFile::FILETYPE_ERROR:
			case UploadWordmarkFromFile::FILETYPE_ERROR:
				$msg = wfMsgHtml( 'themedesigner-type-error' );
				break;
			case UploadWordmarkFromFile::FILEDIMENSIONS_ERROR:
				$msg = wfMsgHtml( 'themedesigner-dimensions-error' );
				break;
			case UploadBase::MIN_LENGTH_PARTNAME:
				$msg = wfMsgHtml( 'minlength1' );
				break;
			case UploadBase::ILLEGAL_FILENAME:
				$msg = wfMsgExt(
					'illegalfilename',
					'parseinline',
					$status['filtered']
				);
				break;
			case UploadBase::OVERWRITE_EXISTING_FILE:
				$msg =  wfMsgExt(
					$status['overwrite'],
					'parseinline'
				);
				break;
			case UploadBase::FILETYPE_MISSING:
				$msg = wfMsgExt(
					'filetype-missing',
					'parseinline'
				);
				break;
			case UploadBase::EMPTY_FILE:
				$msg = wfMsgHtml( 'emptyfile' );
				break;
			case UploadBase::FILETYPE_BADTYPE:
				$finalExt = $status['finalExt'];

				$msg = wfMsgExt(
					'filetype-banned-type',
					array( 'parseinline' ),
					htmlspecialchars( $finalExt ),
					implode(
						wfMsgExt(
							'comma-separator',
							array( 'escapenoentities' )
						),
						$wgFileExtensions
					),
					$wgLang->formatNum( count( $wgFileExtensions ) )
				);
				break;
			case UploadBase::VERIFICATION_ERROR:
				unset( $status['status'] );
				$code = array_shift( $status['details'] );
				$msg = wfMsgExt(
					$code,
					'parseinline',
					$status['details']
				);
				break;
			case UploadBase::HOOK_ABORTED:
				if ( is_array( $status['error'] ) ) { # allow hooks to return error details in an array
					$args = $status['error'];
					$error = array_shift( $args );
				} else {
					$error = $status['error'];
					$args = null;
				}

				$msg = wfMsgExt( $error, 'parseinline', $args );
				break;
			default:
				throw new MWException( __METHOD__ . ": Unknown value `{$status['status']}`" );
		}

		return $msg;
	}

	/**
	 *
	 * @author Federico "Lox" Lucignano
	 */
	private function getUploadWarningMessages( $warnings ){
		$ret = array();

		foreach( $warnings as $warning => $args ) {
			if ( $args === true ) {
				$args = array();
			} elseif ( !is_array( $args ) ) {
				$args = array( $args );
			}

			$ret[] = wfMsgExt( $warning, 'parseinline', $args );
		}

		return $ret;
	}

	public function executeWordmarkUpload() {
		$upload = new UploadWordmarkFromFile();

		$status = $this->uploadImage($upload);

		if($status['status'] === 'uploadattempted' && $status['isGood']) {
			$file = $upload->getLocalFile();
			$this->wordmarkImageUrl = wfReplaceImageServer( $file->getUrl() );
			$this->wordmarkImageName = $file->getName();

			// if wordmark url is not set then it means there was some problem
			if ( $this->wordmarkImageUrl == null || $this->wordmarkImageName == null ) {
				$this->errors = array( wfMsg( 'themedesigner-unknown-error' ) );
			}

			wfRunHooks( 'UploadWordmarkComplete', array( &$upload ) );
		} else if ($status['status'] === 'error') {
			$this->errors = $status['errors'];
		}

	}

	public function executeFaviconUpload() {
		$upload = new UploadFaviconFromFile();

		$this->faviconImageName = '';
		$this->faviconImageUrl = '';

		$status = $this->uploadImage($upload);
		if($status['status'] === 'uploadattempted' && $status['isGood']) {
			$file = $upload->getLocalFile(); /* @var $file LocalFile */
			$this->faviconImageUrl = wfReplaceImageServer( $file->getUrl() );
			$this->faviconImageName = $file->getName();

			// if wordmark url is not set then it means there was some problem
			if ( $this->faviconImageUrl == null ) {
				$this->errors = array( wfMsg( 'themedesigner-unknown-error' ) );
			}
		} else if ($status['status'] === 'error') {
			$this->errors = $status['errors'];
		}
	}

	public function executeBackgroundImageUpload() {
		$upload = new UploadBackgroundFromFile();

		$status = $this->uploadImage($upload);

		if($status['status'] === 'uploadattempted' && $status['isGood']) {
			$file = $upload->getLocalFile(); /* @var $file LocalFile */
			$this->backgroundImageUrl = wfReplaceImageServer( $file->getUrl() );
			$this->backgroundImageName = $file->getName();
			$this->backgroundImageAlign = $upload->getImageAlign();
			$this->backgroundImageHeight = $file->getHeight();
			$this->backgroundImageWidth = $file->getWidth();

			//get cropped URL
			$is = new ImageServing( null, 120, array( "w"=>"120", "h"=>"100" ) );
			$this->backgroundImageThumb = wfReplaceImageServer( $file->getThumbUrl( $is->getCut( $file->width, $file->height, "origin" ) . "-" . $file->getName() ) );

			// if background image url is not set then it means there was some problem
			if ( $this->backgroundImageUrl == null ) {
				$this->errors = array( wfMsg( 'themedesigner-unknown-error' ) );
			}

		} else if ($status['status'] === 'error') {
			$this->errors = $status['errors'];
		}
	}

	/**
	 * @param UploadBase $upload
	 * @return array
	 */
	private function uploadImage($upload) {
		global $wgRequest, $wgUser;

		$uploadStatus = array("status" => "error");

		$upload->initializeFromRequest( $wgRequest );
		$permErrors = $upload->verifyPermissions( $wgUser );

		if ( $permErrors !== true ) {
			$uploadStatus["errors"] = array( wfMsg( 'badaccess' ) );
		} else {
			$details = $upload->verifyUpload();

			if ( $details[ 'status' ] != UploadBase::OK ) {
				$uploadStatus["errors"] = array( $this->getUploadErrorMessage( $details ) );
			} else {
				$warnings = $upload->checkWarnings();

				if ( !empty( $warnings ) ) {
					$uploadStatus["errors"] = $this->getUploadWarningMessages( $warnings );
				} else {
					//save temp file
					$status = $upload->performUpload();

					$uploadStatus["status"] = "uploadattempted";
					$uploadStatus["isGood"] = $status->isGood();
				}
			}
		}

		return $uploadStatus;
	}

	public function executeSaveSettings() {
		global $wgRequest;

		wfProfileIn( __METHOD__ );

		$data = $wgRequest->getArray( 'settings' );

		$themeSettings = new ThemeSettings();
		$themeSettings->saveSettings($data);

		wfProfileOut( __METHOD__ );
	}

}

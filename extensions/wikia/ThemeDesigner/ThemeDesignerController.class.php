<?php
class ThemeDesignerController extends WikiaController {

	public function init() {
		$this->backgroundImageName = null;
		$this->backgroundImageUrl = null;
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

	public function index() {
		wfProfileIn( __METHOD__ );
		
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
				$entry['timeago'] = $this->wg->Lang->date($entry['timestamp']);
			}
		}
		$this->themeHistory = $themeHistory;

		// URL user should be redirected to when settings are saved
		if(isset($_SERVER['HTTP_REFERER'])) {
			$this->returnTo = $_SERVER['HTTP_REFERER'];
		} else {
			$this->returnTo = $this->wg->Script;
		}

		$this->wg->Out->getResourceLoader()->getModule( 'mediawiki' );

		$ret = implode( "\n", [
			$this->wg->Out->getHeadLinks( null, true ),
			$this->wg->Out->buildCssLinks(),
			$this->wg->Out->getHeadScripts(),
			$this->wg->Out->getHeadItems()
		] );

		$this->globalVariablesScript = $ret;

		$pageTitle = wfMessage( 'themedesigner-title' );
		$this->pageTitle = ( new WikiaHtmlTitle() )->setParts( [ $pageTitle ] )->getTitle();

		wfProfileOut( __METHOD__ );
	}

	public function themeTab() {

	}

	public function customizeTab() {

	}

	public function wordmarkTab() {
		$this->response->setData( [
			'faviconUrl' => Wikia::getFaviconFullUrl(),
			'token' => $this->wg->User->getEditToken(),
		] );
	}

	public function picker() {
		// SUS-797: Add edit token for background image upload
		$this->response->setVal( 'token', $this->wg->User->getEditToken() );
	}

	public function preview() {
		$this->infoboxTheme = $this->wg->EnablePortableInfoboxEuropaTheme ? 'theme="europa"' : '';
	}

	/**
	 *
	 * @author Federico "Lox" Lucignano
	 */
	private function getUploadErrorMessage( $status ) {
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
						$this->wg->FileExtensions
					),
					$this->wg->Lang->formatNum( count( $this->wg->FileExtensions ) )
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

	public function wordmarkUpload() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		// SUS-797: Validate edit token and POST request for external requests
		$this->checkWriteRequest();

		$upload = new UploadWordmarkFromFile();

		$status = $this->uploadImage($upload);

		if($status['status'] === 'uploadattempted' && $status['isGood']) {
			$file = $upload->getLocalFile();
			$wordmarkImageUrl = wfReplaceImageServer( $file->getUrl() );
			$wordmarkImageName = $file->getName();

			// if wordmark url is not set then it means there was some problem
			if ( $wordmarkImageUrl == null || $wordmarkImageName == null ) {
				$this->response->setData( [
					'errors' => [ wfMessage( 'themedesigner-unknown-error' )->escaped() ]
				] );
			}

			Hooks::run( 'UploadWordmarkComplete', [ &$upload ] );

			$this->response->setData( [
				'wordmarkImageUrl' => $wordmarkImageUrl,
				'wordmarkImageName' => $wordmarkImageName
			] );
			return;
		}

		if ( $status['status'] === 'error' ) {
			$this->response->setData( [
				'errors' => $status['errors']
			] );
		}
	}

	public function faviconUpload() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		
		// SUS-797: Validate edit token and POST request for external requests
		$this->checkWriteRequest();

		$upload = new UploadFaviconFromFile();

		$status = $this->uploadImage($upload);
		if($status['status'] === 'uploadattempted' && $status['isGood']) {
			$file = $upload->getLocalFile(); /* @var $file LocalFile */
			$faviconImageUrl = wfReplaceImageServer( $file->getUrl() );

			// if wordmark url is not set then it means there was some problem
			if ( $faviconImageUrl == null ) {
				$this->response->setData( [
					'errors' => [ wfMessage( 'themedesigner-unknown-error' )->escaped() ]
				] );
				return;
			}
			
			$this->response->setData( [
				'faviconImageUrl' => $faviconImageUrl,
				'faviconImageName' => $file->getName()
			] );
			return;
		}
		
		if ($status['status'] === 'error') {
			$this->response->setData( [
				'errors' => $status['errors']
			] );
		}		
	}

	public function backgroundImageUpload() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		
		// SUS-797: Validate edit token and POST request for external requests
		$this->checkWriteRequest();

		$upload = new UploadBackgroundFromFile();

		$status = $this->uploadImage($upload);

		if($status['status'] === 'uploadattempted' && $status['isGood']) {
			$file = $upload->getLocalFile(); /* @var $file LocalFile */
			$backgroundImageUrl = wfReplaceImageServer( $file->getUrl() );

			// if background image url is not set then it means there was some problem
			if ( $backgroundImageUrl == null ) {
				$this->response->setData( [
					'errors' => [ wfMessage( 'themedesigner-unknown-error' )->escaped() ]
				] );
				return;
			}

			//get cropped URL
			$is = new ImageServing( null, 120, array( "w"=>"120", "h"=>"100" ) );
			
			$this->response->setData( [
				'backgroundImageUrl' => $backgroundImageUrl,
				'backgroundImageName' => $file->getName(),
				'backgroundImageHeight' => $file->getHeight(),
				'backgroundImageWidth' => $file->getWidth(),
				'backgroundImageThumb' => wfReplaceImageServer( $file->getThumbUrl( $is->getCut( $file->width, $file->height, "origin" ) . "-" . $file->getName() ) )
			] );
			return;
		}
		
		if ($status['status'] === 'error') {
			$this->response->setData( [
				'errors' => $status['errors']
			] );
		}
	}

	/**
	 * @param UploadBase $upload
	 * @return array
	 */
	private function uploadImage($upload) {
		$uploadStatus = array("status" => "error");

		if ( empty( $this->wg->EnableUploads ) ) {
			$uploadStatus["errors"] = [ wfMessage( 'themedesigner-upload-disabled' )->plain() ];
		} else {
			$upload->initializeFromRequest( $this->wg->Request );
			$permErrors = $upload->verifyPermissions( $this->wg->User );

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
		}

		return $uploadStatus;
	}

	public function saveSettings() {
		// SUS-797: Validate edit token and POST request for external requests
		$this->checkWriteRequest();
		
		$data = $this->request->getArray( 'settings' );

		$themeSettings = new ThemeSettings();
		$themeSettings->saveSettings( $data );
	}


	/**
	 * SUS-797: This function is called automatically by WikiaDispatcher for every request
	 * @param User $user user trying to call the controller
	 * @param string $method controller method
	 * @return bool True if the user should NOT be allowed access
	 */
	public function userAllowedRequirementCheck( $user, $method ) {
		return !ThemeDesignerHelper::checkAccess();
	}
}

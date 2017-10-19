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
		$this->errors = [];

		$this->dir = $this->wg->ContLang->getDir();
		$this->mimetype = $this->wg->Mimetype;
		$this->charset = $this->wg->OutputEncoding;
	}

	public function executeIndex() {
		// check rights
		if ( !ThemeDesignerHelper::checkAccess() ) {
			$this->displayRestrictionError( __METHOD__ );
		}

		$wgLang = RequestContext::getMain()->getLanguage();
		$wgOut = RequestContext::getMain()->getOutput();
		$themeSettings = new ThemeSettings();

		// current settings
		$this->themeSettings = $themeSettings->getSettings();

		// SUS-2975: wordmark-text comes pre-escaped if set - decode any HTML entities
		if ( !empty( $this->themeSettings['wordmark-text'] ) ) {
			$this->themeSettings['wordmark-text'] = Sanitizer::decodeCharReferences( $this->themeSettings['wordmark-text'] );
		}

		// application theme settings (not user settable)
		$this->applicationThemeSettings = SassUtil::getApplicationThemeSettings();

		// recent versions
		$themeHistory = array_reverse( $themeSettings->getHistory() );

		// format time (for edits older than 30 days - show timestamp)
		foreach ( $themeHistory as &$entry ) {
			$diff = time() - strtotime( $entry['timestamp'] );

			if ( $diff < 30 * 86400 ) {
				$entry['timeago'] = wfTimeFormatAgo( $entry['timestamp'] );
			} else {
				$entry['timeago'] = $wgLang->date( $entry['timestamp'] );
			}
		}
		$this->themeHistory = $themeHistory;

		// URL user should be redirected to when settings are saved
		if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
			$this->returnTo = $_SERVER['HTTP_REFERER'];
		} else {
			$this->returnTo = $this->wg->Script;
		}

		$wgOut->getResourceLoader()->getModule( 'mediawiki' );

		$ret = implode( "\n", [
			$wgOut->getHeadLinks( null, true ),
			$wgOut->buildCssLinks(),
			$wgOut->getHeadScripts(),
			$wgOut->getHeadItems()
		] );

		$this->globalVariablesScript = $ret;

		$pageTitle = wfMessage( 'themedesigner-title' );
		$this->pageTitle = ( new WikiaHtmlTitle() )->setParts( [ $pageTitle ] )->getTitle();
	}

	public function executeThemeTab() {

	}

	public function executeCustomizeTab() {

	}

	public function executeWordmarkTab() {
		$this->faviconUrl = Wikia::getFaviconFullUrl();
	}

	public function executePicker() {

	}

	public function executePreview() {
		global $wgEnablePortableInfoboxEuropaTheme;

		$this->infoboxTheme = $wgEnablePortableInfoboxEuropaTheme ? 'theme="europa"' : '';
	}

	/**
	 *
	 * @author Federico "Lox" Lucignano
	 */
	private function getUploadErrorMessage( $status ) {
		global $wgFileExtensions, $wgLang;

		switch ( $status['status'] ) {
			case UploadBackgroundFromFile::FILESIZE_ERROR:
				$msg = wfMessage( 'themedesigner-size-error' )->escaped();
				break;
			case UploadBackgroundFromFile::FILETYPE_ERROR:
			case UploadWordmarkFromFile::FILETYPE_ERROR:
				$msg = wfMessage( 'themedesigner-type-error' )->escaped();
				break;
			case UploadWordmarkFromFile::FILEDIMENSIONS_ERROR:
				$msg = wfMessage( 'themedesigner-dimensions-error' )->escaped();
				break;
			case UploadBase::MIN_LENGTH_PARTNAME:
				$msg = wfMessage( 'minlength1' )->escaped();
				break;
			case UploadBase::ILLEGAL_FILENAME:
				$msg = wfMessage(
					'illegalfilename',
					$status['filtered']
				)->parse();
				break;
			case UploadBase::OVERWRITE_EXISTING_FILE:
				$msg = wfMessage(
					$status['overwrite']
				)->parse();
				break;
			case UploadBase::FILETYPE_MISSING:
				$msg = wfMessage(
					'filetype-missing'
				)->parse();
				break;
			case UploadBase::EMPTY_FILE:
				$msg = wfMessage( 'emptyfile' )->escaped();
				break;
			case UploadBase::FILETYPE_BADTYPE:
				$finalExt = $status['finalExt'];

				$msg = wfMessage(
					'filetype-banned-type',
					htmlspecialchars( $finalExt ),
					implode(
						wfMessage( 'comma-separator' )->escaped(),
						$wgFileExtensions
					),
					$wgLang->formatNum( count( $wgFileExtensions ) )
				)->parse();
				break;
			case UploadBase::VERIFICATION_ERROR:
				unset( $status['status'] );
				$code = array_shift( $status['details'] );
				$msg = wfMessage(
					$code,
					$status['details']
				)->parse();
				break;
			case UploadBase::HOOK_ABORTED:
				// allow hooks to return error details in an array
				if ( is_array( $status['error'] ) ) {
					$args = $status['error'];
					$error = array_shift( $args );
				} else {
					$error = $status['error'];
					$args = null;
				}

				$msg = wfMessage( $error, $args )->parse();
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
	private function getUploadWarningMessages( $warnings ) {
		$ret = [];

		foreach ( $warnings as $warning => $args ) {
			if ( $args === true ) {
				$args = [];
			} elseif ( !is_array( $args ) ) {
				$args = [ $args ];
			}

			$ret[] = wfMessage( $warning, $args )->parse();
		}

		return $ret;
	}

	public function executeWordmarkUpload() {
		// check rights
		if ( !ThemeDesignerHelper::checkAccess() ) {
			$this->displayRestrictionError( __METHOD__ );
		}

		$upload = new UploadWordmarkFromFile();

		$status = $this->uploadImage( $upload );

		if ( $status['status'] === 'uploadattempted' && $status['isGood'] ) {
			$file = $upload->getLocalFile();
			$this->wordmarkImageUrl = wfReplaceImageServer( $file->getUrl() );
			$this->wordmarkImageName = $file->getName();

			// if wordmark url is not set then it means there was some problem
			if ( $this->wordmarkImageUrl == null || $this->wordmarkImageName == null ) {
				$this->errors = [ wfMessage( 'themedesigner-unknown-error' )->escaped() ];
			}

			Hooks::run( 'UploadWordmarkComplete', [ &$upload ] );
		} else if ( $status['status'] === 'error' ) {
			$this->errors = $status['errors'];
		}

	}

	public function executeFaviconUpload() {
		// check rights
		if ( !ThemeDesignerHelper::checkAccess() ) {
			$this->displayRestrictionError( __METHOD__ );
		}

		$upload = new UploadFaviconFromFile();

		$this->faviconImageName = '';
		$this->faviconImageUrl = '';

		$status = $this->uploadImage( $upload );
		if ( $status['status'] === 'uploadattempted' && $status['isGood'] ) {
			$file = $upload->getLocalFile();
			/* @var $file LocalFile */
			$this->faviconImageUrl = wfReplaceImageServer( $file->getUrl() );
			$this->faviconImageName = $file->getName();

			// if wordmark url is not set then it means there was some problem
			if ( $this->faviconImageUrl == null ) {
				$this->errors = [ wfMessage( 'themedesigner-unknown-error' )->escaped() ];
			}
		} else if ( $status['status'] === 'error' ) {
			$this->errors = $status['errors'];
		}
	}

	public function executeBackgroundImageUpload() {
		// check rights
		if ( !ThemeDesignerHelper::checkAccess() ) {
			$this->displayRestrictionError( __METHOD__ );
		}

		$upload = new UploadBackgroundFromFile();

		$status = $this->uploadImage( $upload );

		if ( $status['status'] === 'uploadattempted' && $status['isGood'] ) {
			$file = $upload->getLocalFile();

			$this->setBackgroundDetails( $file, $this->getVal( 'type', 'background' ) );

			// if background image url is not set then it means there was some problem
			if ( $this->backgroundImageUrl == null ) {
				$this->errors = [ wfMessage( 'themedesigner-unknown-error' )->text() ];
			}

		} else if ( $status['status'] === 'error' ) {
			$this->errors = $status['errors'];
		}
	}

	private function setBackgroundDetails( File $file, string $type ) {
		$this->backgroundImageName = $file->getName();

		if ( $type === 'community-header-background' ) {
			$this->backgroundImageUrl = VignetteRequest::fromUrl( $file->getUrl() )
				->zoomCrop()
				->width( ThemeSettings::COMMUNITY_HEADER_BACKGROUND_WIDTH )
				->height( ThemeSettings::COMMUNITY_HEADER_BACKGROUND_HEIGHT )
				->url();

			$this->backgroundImageThumb = VignetteRequest::fromUrl( $file->getUrl() )
				->zoomCrop()
				->width( 120 )
				->height( 33 )
				->url();
		} else if ( $type === 'background' ) {
			$this->backgroundImageUrl = wfReplaceImageServer( $file->getUrl() );
			$this->backgroundImageHeight = $file->getHeight();
			$this->backgroundImageWidth = $file->getWidth();

			//get cropped URL
			$is = new ImageServing( null, 120, [ "w" => "120", "h" => "100" ] );
			$this->backgroundImageThumb = wfReplaceImageServer(
				$file->getThumbUrl(
					$is->getCut( $file->width, $file->height, "origin" ) . "-" . $file->getName()
				)
			);
		}
	}

	/**
	 * Upload a temporary file. It will be made "permanent" by ThemeDesigner::saveImage method.
	 *
	 * @param UploadBackgroundFromFile|UploadFaviconFromFile|UploadWordmarkFromFile $upload
	 * @return array
	 */
	private function uploadImage( $upload ): array {
		global $wgEnableUploads;

		$wgRequest = RequestContext::getMain()->getRequest();
		$wgUser = RequestContext::getMain()->getUser();

		$uploadStatus = [ "status" => "error" ];

		if ( empty( $wgEnableUploads ) ) {
			$uploadStatus["errors"] = [ wfMessage( 'themedesigner-upload-disabled' )->escaped() ];
		} else {
			$upload->initializeFromRequest( $wgRequest );
			$permErrors = $upload->verifyPermissions( $wgUser );

			if ( $permErrors !== true ) {
				$uploadStatus["errors"] = [ wfMessage( 'badaccess' )->escaped() ];
			} else {
				$details = $upload->verifyUpload();

				if ( $details['status'] != UploadBase::OK ) {
					$uploadStatus["errors"] = [ $this->getUploadErrorMessage( $details ) ];
				} else {
					$warnings = $upload->checkWarnings();

					if ( !empty( $warnings ) ) {
						$uploadStatus["errors"] = $this->getUploadWarningMessages( $warnings );
					} else {
						//save temp file
						$status = $upload->performUpload('', '', false, $wgUser);

						$uploadStatus["status"] = "uploadattempted";
						$uploadStatus["isGood"] = $status->isGood();
					}
				}
			}
		}

		return $uploadStatus;
	}

	public function saveSettings() {
		global $wgBlankImgUrl;

		$this->checkWriteRequest();

		// check rights
		if ( !ThemeDesignerHelper::checkAccess() ) {
			$this->displayRestrictionError( __METHOD__ );
		}

		$data = $this->request->getArray( 'settings' );

		// SUS-2942: this data is calculated from temporary file, should not be set directly
		foreach ( ThemeSettings::IMAGES as $imageSource ) {
			if ( !empty( $data["$imageSource-image-name"] ) && strpos( $data["$imageSource-image-name"],'Temp_file_' ) !== 0 ) {
				unset( $data["$imageSource-image-name"] );
			}

			if ( !empty( $data["$imageSource-image"] ) ) {
				unset( $data["$imageSource-image"] );
			}

			unset( $data["$imageSource-image-width"] );
			unset( $data["$imageSource-image-height"] );

			if ( isset( $data["$imageSource-image-url"] ) && $data["$imageSource-image-url"] !== $wgBlankImgUrl ) {
				unset( $data["$imageSource-image-url"] );
			}

			unset( $data["user-$imageSource-image"] );
			unset( $data["user-$imageSource-image-thumb"] );
		}

		$themeSettings = new ThemeSettings();
		$themeSettings->saveSettings( $data );
	}


	private function displayRestrictionError( $method ) {
		throw new PermissionsError( $method );
	}
}

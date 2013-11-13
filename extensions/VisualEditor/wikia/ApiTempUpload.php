<?php

class ApiTempUpload extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		// Check whether upload is enabled
		if ( !UploadBase::isEnabled() ) {
			$this->dieUsageMsg( 'uploaddisabled' );
		}

		$this->mUser = $this->getUser();

		// Parameter handling
		$this->mParams = $this->extractRequestParams();
		$this->mRequest = $this->getMain()->getRequest();

		if ( $this->mParams['type'] === 'temporary' ) {
			$this->executeTemporary();
		} else if ( $this->mParams['type'] === 'permanent' ) {
			$this->executePermanent();
		} else {
			$this->dieUsageMsg( 'The type parameter must be set to temporary or permanent' );
		}
	}

	private function executePermanent() {
		if ( !empty( $this->mParams['provider'] ) && !empty( $this->mParams['videoId'] ) ) {
			$this->executePermanentVideo();
		} else {
			$this->executePermanentImage();
		}
	}

	private function executePermanentVideo() {
		if ( empty ( $this->mParams['desiredName'] ) ) {
			$this->dieUsageMsg( 'The desiredName parameter must be set' );
		}
		// TODO: Check with Video team if that's the best way to look for video duplicates
		$duplicates = WikiaFileHelper::findVideoDuplicates(
			$this->mParams['provider'],
			$this->mParams['videoId']
		);
		if ( count( $duplicates ) > 0 ) {
			$file = wfFindFile( $duplicates[0]['img_name'] );
			$name = $file->getTitle()->getText();

		} else if( $this->mParams['provider'] == 'FILE' ) {
			// no need to upload, local reference
			$title = Title::newFromText( $this->mParams['desiredName'], NS_FILE );
			$name = $title->getText();

			if ( empty( $title ) ) {
				$this->dieUsageMsg( 'This video name contains invalid characters, like #' );
			}
			wfRunHooks( 'AddPremiumVideo', array( $title ) );

		} else {
			$uploader = new VideoFileUploader();

			$title = $uploader->getUniqueTitle(
				$uploader->sanitizeTitle( $this->mParams['desiredName'] )
			);
			$uploader->setProvider( $this->mParams['provider'] );
			$uploader->setVideoId( $this->mParams['videoId'] );
			$uploader->setTargetTitle( $title->getBaseText() );
			$uploader->upload( $title );
			$name = $title->getText();
		}
		$this->getResult()->addValue( null, $this->getModuleName(), array( 'name' => $name ) );
	}

	private function executePermanentImage() {
		if ( empty ( $this->mParams['desiredName'] ) ) {
			$this->dieUsageMsg( 'The desiredName parameter must be set' );
		}
		if ( empty ( $this->mParams['temporaryFileName'] ) ) {
			$this->dieUsageMsg( 'The temporaryFileName parameter must be set' );
		}
		$temporaryFile = new FakeLocalFile(
			Title::newFromText( $this->mParams['temporaryFileName'], 6 ),
			RepoGroup::singleton()->getLocalRepo()
		);
		$duplicates = RepoGroup::singleton()->findBySha1(
			FSFile::getSha1Base36FromPath( $temporaryFile->getLocalRefPath() )
		);
		if ( count ( $duplicates ) > 0 ) {
			$name = $duplicates[0]->getTitle()->getText();
		} else {
			$title = $this->getUniqueTitle( $this->mParams['desiredName'] );
			$file = new LocalFile( $title, RepoGroup::singleton()->getLocalRepo() );
			$file->upload( $temporaryFile->getPath(), '', '' );
			$name = $file->getTitle()->getText();
		}
		$this->getResult()->addValue( null, $this->getModuleName(), array( 'name' => $name ) );
	}

	private function getUniqueTitle( $name ) {
		$filename = pathinfo( $name, PATHINFO_FILENAME );
		$extension = pathinfo( $name, PATHINFO_EXTENSION );
		$title = Title::makeTitleSafe( NS_IMAGE, $filename . '.' . $extension );
		if ( !empty( $title ) && $title->exists() ) {
			for ( $i = 0; $i <= 3; $i++ ) {
				$title = Title::makeTitleSafe( NS_IMAGE, $filename . '-' . $i . '.' . $extension );
				if ( $title && !$title->exists() ) {
					break;
				}
			}
			if ( !empty( $title ) && $title->exists() ) {
				$title = Title::makeTitleSafe( NS_IMAGE, $filename . '-' . time() . '.' . $extension );
			}
		}
		return $title;
	}

	private function createTemporaryFile( $filepath ) {
		$temporaryFile = new FakeLocalFile(
			Title::newFromText( 'Temp_' . uniqid( '', true ), 6 ),
			RepoGroup::singleton()->getLocalRepo()
		);
		$temporaryFile->upload( $filepath, '', '' );
		return $temporaryFile;
	}

	private function executeTemporary() {
		if ( $this->mRequest->wasPosted() ) {
			$this->executeTemporaryImage();
		} else {
			$this->executeTemporaryVideo();
		}
	}

	private function executeTemporaryImage() {
		$this->mUpload = new UploadFromFile();
		$this->mUpload->initialize(
			$this->mRequest->getFileName( 'file' ),
			$this->mRequest->getUpload( 'file' )
		);
		// First check permission to upload
		$this->checkPermissions( $this->mUser );
		$this->verifyUpload();
		$temporaryFile = $this->createTemporaryFile( $this->mRequest->getFileTempName( 'file' ) );
		$this->getResult()->addValue( null, $this->getModuleName(), array(
			'title' => $this->mUpload->getTitle()->getText(),
			'temporaryThumbUrl' => $temporaryFile->getUrl(),
			'temporaryFileName' => $temporaryFile->getName()
		) );
	}

	private function executeTemporaryVideo() {
		$app = F::app();

		// First check permission to upload
		$this->mUpload = new UploadFromUrl();
		$this->checkPermissions( $this->mUser );

		$awf = ApiWrapperFactory::getInstance();
		$url = $this->mParams['url'];
		$nonPremiumException = null;

		// ApiWrapperFactory->getApiWrapper(...) require whole URL to be passed in (including protocol)
		if ( !preg_match( '/^https?:\/\//', $url ) ) {
			$url = 'http://' . $url;
		}
		try {
			$apiwrapper = $awf->getApiWrapper( $url );
		} catch ( Exception $e ) {
			$nonPremiumException = $e;
		}

		if ( !empty( $apiwrapper ) ) {
			// handle supported 3rd party (non-premium) videos
			$this->mUpload->initializeFromRequest( new FauxRequest(
				array(
					'wpUpload' => 1,
					'wpSourceType' => 'web',
					'wpUploadFileURL' => $apiwrapper->getThumbnailUrl()
				),
				true
			) );
			$status = $this->mUpload->fetchFile();
			if ( !$status->isGood() ) {
				$this->dieUsageMsg( 'Error fetching file from remote source' );
			}
			$this->verifyUpload();
			$temporaryFile = $this->createTemporaryFile( $this->mUpload->getTempPath() );

			// define vars to pass back
			$fileTitle = $apiwrapper->getTitle();
			$temporaryThumbUrl = $temporaryFile->getUrl();
			$temporaryFileName = $temporaryFile->getName();
			$provider = $apiwrapper->getProvider();
			$videoId = $apiwrapper->getVideoId();

		} else {
			// handle local and premium videos by parsing url for 'File:'
			$file = null;

			// get the video name
			$nsFileTranslated = $app->wg->ContLang->getNsText( NS_FILE );

			// added $nsFileTransladed to fix bugId:#48874
			$pattern = '/(File:|'.$nsFileTranslated.':)(.+)$/';

			if ( preg_match( $pattern, $url, $matches ) ) {
				$file = wfFindFile( $matches[2] );
				if ( !$file ) { // bugID: 26721
					$file = wfFindFile( urldecode( $matches[2] ) );
				}
			}
			elseif ( preg_match( $pattern, urldecode( $url ), $matches ) ) {
				$file = wfFindFile( $matches[2] );
				if ( !$file ) { // bugID: 26721
					$file = wfFindFile( $matches[2] );
				}
			}
			else {
				if ( $nonPremiumException ) {
					// Non premium videos are not allowed on some wikis
					if ( empty( $app->wg->allowNonPremiumVideos ) ) {
						$this->dieUsageMsg( 'This wiki does not support non-premium videos' );
					}

					if ( $nonPremiumException->getMessage() != '' ) {
						$this->dieUsageMsg( $nonPremiumException->getMessage() );
					}
				}

				$this->dieUsageMsg( 'The supplied URL is invalid' );
			}

			if ( !$file ) {
				$this->dieUsageMsg( 'The supplied video does not exist' );
			}

			// define vars to pass back
			$fileTitle = $file->getTitle()->getText();
			$temporaryThumbUrl = $file->getUrl();
			$temporaryFileName = $file->getTitle()->getText();
			$provider = 'FILE';
			$videoId = $file->getHandler()->getVideoId();

		}

		$this->getResult()->addValue( null, $this->getModuleName(), array(
			'title' => $fileTitle,
			'temporaryThumbUrl' => $temporaryThumbUrl,
			'temporaryFileName' => $temporaryFileName,
			'provider' => $provider,
			'videoId' => $videoId,
		) );
	}

	/**
	 * Checks that the user has permissions to perform this upload.
	 * Dies with usage message on inadequate permissions.
	 * @param $user User The user to check.
	 */
	protected function checkPermissions( $user ) {
		// Check whether the user has the appropriate permissions to upload anyway
		if ( $this->mUpload->isAllowed( $user ) !== true ) {
			if ( !$user->isLoggedIn() ) {
				$this->dieUsageMsg( array( 'mustbeloggedin', 'upload' ) );
			} else {
				$this->dieUsageMsg( 'badaccess-groups' );
			}
		}
	}

	protected function verifyUpload( ) {
		global $wgFileExtensions;

		$verification = $this->mUpload->verifyUpload( );
		if ( $verification['status'] === UploadBase::OK ) {
			return;
		}

		// TODO: Move them to ApiBase's message map
		switch( $verification['status'] ) {
			// Recoverable errors
			case UploadBase::MIN_LENGTH_PARTNAME:
				$this->dieRecoverableError( 'filename-tooshort', 'filename' );
				break;
			case UploadBase::ILLEGAL_FILENAME:
				$this->dieRecoverableError( 'illegal-filename', 'filename',
						array( 'filename' => $verification['filtered'] ) );
				break;
			case UploadBase::FILENAME_TOO_LONG:
				$this->dieRecoverableError( 'filename-toolong', 'filename' );
				break;
			case UploadBase::FILETYPE_MISSING:
				$this->dieRecoverableError( 'filetype-missing', 'filename' );
				break;
			case UploadBase::WINDOWS_NONASCII_FILENAME:
				$this->dieRecoverableError( 'windows-nonascii-filename', 'filename' );
				break;

			// Unrecoverable errors
			case UploadBase::EMPTY_FILE:
				$this->dieUsage( 'The file you submitted was empty', 'empty-file' );
				break;
			case UploadBase::FILE_TOO_LARGE:
				$this->dieUsage( 'The file you submitted was too large', 'file-too-large' );
				break;

			case UploadBase::FILETYPE_BADTYPE:
				$this->getResult()->setIndexedTagName( $wgFileExtensions, $verification['finalExt'] );
				$this->dieUsage( 'This type of file is banned', 'filetype-banned',
						0, array(
							'filetype' => $verification['finalExt'],
							'allowed' => $wgFileExtensions
						) );
				break;
			case UploadBase::VERIFICATION_ERROR:
				$this->getResult()->setIndexedTagName( $verification['details'], 'detail' );
				$this->dieUsage( 'This file did not pass file verification', 'verification-error',
						0, array( 'details' => $verification['details'] ) );
				break;
			case UploadBase::HOOK_ABORTED:
				$this->dieUsage( "The modification you tried to make was aborted by an extension hook",
						'hookaborted', 0, array( 'error' => $verification['error'] ) );
				break;
			default:
				$this->dieUsage( 'An unknown error occurred', 'unknown-error',
						0, array( 'code' =>  $verification['status'] ) );
				break;
		}
	}

	public function getAllowedParams() {
		return array(
			'type' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'url' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'provider' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'videoId' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'temporaryFileName' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'desiredName' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			)
		);
	}

	public function getParamDescription() {
		$params = array(
			'type' => '"temporary" or "permanent"'
		);
		return $params;
	}

	public function isWriteMode() {
		return true;
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}

}

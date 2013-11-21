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
		$this->desiredName = wfStripIllegalFilenameChars( $this->mParams['desiredName'] );
		if ( $this->mParams['mediaType'] === 'video' ) {
			$this->executePermanentVideo();
		} else {
			$this->executePermanentImage();
		}
	}

	private function executePermanentVideo() {
		if ( empty( $this->mParams['provider'] ) ) {
			$this->dieUsageMsg( 'The provider parameter must be set' );
		}

		if ( $this->mParams['provider'] == 'wikia' ) {
			if ( empty( $this->mParams['title'] ) ) {
				$this->dieUsageMsg( 'The title parameter must be set' );
			}
			// no need to upload, local reference
			$title = Title::newFromText( $this->mParams['title'], NS_FILE );
			if ( empty( $title ) ) {
				$this->dieUsageMsg( 'This video name contains invalid characters, like #' );
			}
			$name = $title->getText();
			wfRunHooks( 'AddPremiumVideo', array( $title ) );

		} else if ( empty( $this->desiredName ) || empty( $this->mParams['videoId'] ) ) {
			$this->dieUsageMsg( 'The desiredName, provider, and videoId parameters must be set to correct values' );
		} else {
			// TODO: Check with Video team if that's the best way to look for video duplicates
			$duplicates = WikiaFileHelper::findVideoDuplicates(
				$this->mParams['provider'],
				$this->mParams['videoId']
			);

			if ( count( $duplicates ) > 0 ) {
				$file = wfFindFile( $duplicates[0]['img_name'] );
				$name = $file->getTitle()->getText();
			} else {
				$uploader = new VideoFileUploader();

				$title = $uploader->getUniqueTitle(
					$uploader->sanitizeTitle( $this->desiredName )
				);
				$uploader->setProvider( $this->mParams['provider'] );
				$uploader->setVideoId( $this->mParams['videoId'] );
				$uploader->setTargetTitle( $title->getBaseText() );
				$uploader->upload( $title );
				$name = $title->getText();
			}
		}

		$this->getResult()->addValue( null, $this->getModuleName(), array( 'name' => $name ) );
	}

	private function executePermanentImage() {
		if ( empty ( $this->desiredName ) ) {
			$this->dieUsageMsg( 'The desiredName parameter must be set to a correct value' );
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
			$title = $this->getUniqueTitle( $this->desiredName );
			$file = new LocalFile( $title, RepoGroup::singleton()->getLocalRepo() );
			$pageText = '';
			if ( isset( $this->mParams['license'] ) ) {
				$pageText = SpecialUpload::getInitialPageText( '', $this->mParams['license'] );
			}
			$file->upload( $temporaryFile->getPath(), '', $pageText );
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
		// First check permission to upload
		$this->mUpload = new UploadFromUrl();
		$this->checkPermissions( $this->mUser );

		$url = $this->mParams['url'];
		$wikiaFileStatus = WikiaFileHelper::getWikiaFileFromUrl( $url );

		if ( !$wikiaFileStatus->isGood() ) {
			// It's a wikia file url but the file doesn't exist
			$this->dieUsageMsg( $wikiaFileStatus->getWarningsArray() );
		}

		$file = $wikiaFileStatus->value;

		if ( !empty( $file ) ) {
			// Handle local and premium videos
			$this->getResult()->addValue( null, $this->getModuleName(), array(
				'title' => $file->getTitle()->getText(),
				'url' => $file->getUrl(),
				'provider' => 'wikia',
			) );

		} else {
			// Handle urls from supported 3rd parties (like youtube)
			// A whole url (including protocol) is necessary for ApiWrapperFactory->getApiWrapper()
			if ( !preg_match( '/^https?:\/\//', $url ) ) {
				$url = 'http://' . $url;
			}

			// ApiWrapper handles adding of non-premium videos
			try {
				$awf = ApiWrapperFactory::getInstance();
				$apiwrapper = $awf->getApiWrapper( $url );
			} catch ( Exception $e ) {
				if ( $e->getMessage() != '' ) {
					$this->dieUsageMsg( $e->getMessage() );
				}

				$this->dieUsageMsg( 'The supplied URL is invalid' );
			}

			if ( empty( $apiwrapper ) ) {
				$this->dieUsageMsg( 'The supplied video does not exist' );
			}

			// We have passed the error checking, the URL is good, so create a temp file
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

			$this->getResult()->addValue( null, $this->getModuleName(), array(
				'title' => $apiwrapper->getTitle(),
				'temporaryThumbUrl' => $temporaryFile->getUrl(),
				'temporaryFileName' => $temporaryFile->getName(),
				'provider' => $apiwrapper->getProvider(),
				'videoId' => $apiwrapper->getVideoId(),
			) );
		}
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
			'desiredName' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'license' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'provider' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'temporaryFileName' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'type' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'url' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'videoId' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'title' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'mediaType' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
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

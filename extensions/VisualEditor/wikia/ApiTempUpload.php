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
			//$this->executePermanent();
			$this->dieUsageMsg( 'Not implemented yet' );
		} else {
			$this->dieUsageMsg( 'The type parameter must be set to temporary or permanent' );
		}
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
		$result = array();

		if ( $this->mRequest->wasPosted() ) {
			// file/image
			$this->mUpload = new UploadFromFile();
			$this->mUpload->initialize(
				$this->mRequest->getFileName( 'file' ),
				$this->mRequest->getUpload( 'file' )
			);
			// First check permission to upload
			$this->checkPermissions( $this->mUser );
			$this->verifyUpload();
			$temporaryFile = $this->createTemporaryFile( $this->mRequest->getFileTempName( 'file' ) );
			$result['title'] = $this->mUpload->getTitle()->getText();
		} else {
			// video
			$awf = ApiWrapperFactory::getInstance();
			$apiwrapper = $awf->getApiWrapper( $this->mParams['url'] );
			if ( !$apiwrapper ) {
				$this->dieUsageMsg( 'Incorrect video URL' );
			}
			$this->mUpload = new UploadFromUrl();
			$this->mUpload->initializeFromRequest( new FauxRequest(
				array(
					'wpUpload' => 1,
					'wpSourceType' => 'web',
					'wpUploadFileURL' => $apiwrapper->getThumbnailUrl()
				),
				true
			) );
			// First check permission to upload
			$this->checkPermissions( $this->mUser );
			$status = $this->mUpload->fetchFile();
			if ( !$status->isGood() ) {
				$this->dieUsage( 'Error fetching file from remote source' );
			}
			$this->verifyUpload();
			$temporaryFile = $this->createTemporaryFile( $this->mUpload->getTempPath() );
			$result['title'] = $apiwrapper->getTitle();
			$result['provider'] = $apiwrapper->getProvider();
			$result['videoId'] = $apiwrapper->getVideoId();
		}

		$result['temporaryThumbUrl'] = $temporaryFile->getUrl();
		$result['temporaryFileName'] = $temporaryFile->getName();
		$this->getResult()->addValue( null, $this->getModuleName(), $result );
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

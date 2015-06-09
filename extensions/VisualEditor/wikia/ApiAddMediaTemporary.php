<?php

class ApiAddMediaTemporary extends ApiAddMedia {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$this->mParams = $this->extractRequestParams();
		$this->mRequest = $this->getMain()->getRequest();
		$this->mUser = $this->getUser();

		if ( $this->mRequest->wasPosted() ) {
			$result = $this->executeImage();
		} else {
			$result = $this->executeVideo();
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	private function executeImage() {
		$duplicate = $this->getFileDuplicate( $this->mRequest->getFileTempName( 'file' ) );
		if ( $duplicate ) {
			return array(
				'title' => $duplicate->getTitle()->getText(),
				'url' => $duplicate->getUrl()
			);
		} else {
			// Check whether upload is enabled
			if ( !UploadBase::isEnabled() ) {
				$this->dieUsageMsg( 'uploaddisabled' );
			}
			$this->mUpload = new UploadFromFile();
			$this->mUpload->initialize(
				$this->mRequest->getFileName( 'file' ),
				$this->mRequest->getUpload( 'file' )
			);
			$this->checkPermissions();
			$this->verifyUpload();
			$tempFile = $this->createTempFile( $this->mRequest->getFileTempName( 'file' ) );
			return array(
				'title' => $this->mUpload->getTitle()->getText(),
				'tempUrl' => $tempFile->getUrl(),
				'tempName' => $tempFile->getName()
			);
		}
	}

	private function executeVideo() {
		$wikiaFilename = WikiaFileHelper::getWikiaFilename( $this->mParams['url'] );
		if ( $wikiaFilename ) {
			return $this->executeWikiaVideo( $wikiaFilename );
		} else {
			return $this->execute3rdPartyVideo( $this->mParams['url'] );
		}
	}

	private function executeWikiaVideo( $wikiaFilename ) {
		$wikiaFile = wfFindFile( $wikiaFilename );
		if ( !$wikiaFile ) {
			$this->dieUsage( 'Valid Wikia video URL, but video is missing', 'wikia-video-missing' );
		}
		return array(
			'title' => $wikiaFile->getTitle()->getText(),
			'url' => $wikiaFile->getUrl(),
			'provider' => 'wikia'
		);
	}

	private function execute3rdPartyVideo( $url ) {
		if ( empty( F::app()->wg->allowNonPremiumVideos ) ) {
			$this->dieUsage( 'Only premium videos are allowed', 'onlyallowpremium' );
		}
		if ( !preg_match( '/^https?:\/\//', $url ) ) {
			$url = 'http://' . $url;
		}
		try {
			$apiwrapper = ApiWrapperFactory::getInstance()->getApiWrapper( $url );
		} catch ( Exception $e ) {
			$this->dieUsage( 'There was an issue with ApiWrapper', 'apiwrapper-error' );
		}
		if ( empty( $apiwrapper ) ) {
			$this->dieUsageMsg( 'The supplied video does not exist' );
		}
		$duplicate = $this->getVideoDuplicate(
			$apiwrapper->getProvider(),
			$apiwrapper->getVideoId()
		);
		$result = array(
			'provider' => $apiwrapper->getProvider(),
			'videoId' => $apiwrapper->getVideoId()
		);
		if ( $duplicate ) {
			$result['title'] = $duplicate->getTitle()->getText();
			$result['url'] = $duplicate->getUrl();
		} else {
			// Check whether upload is enabled
			if ( !UploadBase::isEnabled() ) {
				$this->dieUsageMsg( 'uploaddisabled' );
			}
			F::app()->wg->DisableProxy = true;
			$this->mUpload = new UploadFromUrl();
			$this->mUpload->initializeFromRequest( new FauxRequest(
				array(
					'wpUpload' => 1,
					'wpSourceType' => 'web',
					'wpUploadFileURL' => $apiwrapper->getThumbnailUrl()
				),
				true
			) );
			$this->mUpload->fetchFile();
			$this->checkPermissions();
			$this->verifyUpload();

			$tempFile = $this->createTempFile( $this->mUpload->getTempPath() );

			$result['title'] = $apiwrapper->getTitle();
			$result['tempUrl'] = $tempFile->getUrl();
			$result['tempName'] = $tempFile->getName();
		}
		return $result;
	}

	private function createTempFile( $filepath ) {
		$tempFile = new FakeLocalFile(
			Title::newFromText( uniqid( 'Temp_', true ), 6 ),
			RepoGroup::singleton()->getLocalRepo()
		);
		$tempFile->upload( $filepath, '', '' );
		// TODO: Add to the garbage collector
		return $tempFile;
	}

	protected function checkPermissions() {
		// Check whether the user has the appropriate permissions to upload anyway
		if ( $this->mUpload->verifyTitlePermissions( $this->mUser ) !== true ) {
			if ( !$this->mUser->isLoggedIn() ) {
				$this->dieUsageMsg( array( 'mustbeloggedin', 'upload' ) );
			} else {
				$this->dieUsageMsg( 'badaccess-groups' );
			}
		}
	}

	protected function verifyUpload( ) {
		$verification = $this->mUpload->verifyUpload( );
		if ( $verification['status'] === UploadBase::OK ) {
			return;
		}
		$this->dieUsage( 'An unknown error occurred', 'unknown-error',
				0, array( 'code' =>  $verification['status'] ) );
	}

	public function getAllowedParams() {
		return array(
			'url' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			)
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}

}

<?php

use \Wikia\Logger\WikiaLogger;

class ApiAddMediaPermanent extends ApiAddMedia {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$this->mParams = $this->extractRequestParams();
		if ( empty( $this->mParams['provider'] ) ) {
			$result = $this->executeImage();
		} else {
			$result = $this->executeVideo();
		}
		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	private function executeImage() {
		if ( empty ( $this->mParams['tempName'] ) ) {
			$this->dieUsageMsg( 'The tempName parameter must be set' );
		}
		$tempFile = new FakeLocalFile(
			Title::newFromText( $this->mParams['tempName'], 6 ),
			RepoGroup::singleton()->getLocalRepo()
		);
		$duplicate = $this->getFileDuplicate( $tempFile->getLocalRefPath() );
		if ( $duplicate ) {
			$file = $duplicate;
		} else {
			$title = $this->getUniqueTitle(
				wfStripIllegalFilenameChars( $this->mParams['title'] )
			);
			if ( isset( $this->mParams['license'] ) ) {
				$pageText = SpecialUpload::getInitialPageText( '', $this->mParams['license'] );
			}
			$file = new LocalFile( $title, RepoGroup::singleton()->getLocalRepo() );
			$file->upload( $tempFile->getPath(), '', $pageText ? $pageText : '' );

			/**
			 * As we're not using Wikia Upload we're need to send file to Scribe manually.
			 * Hook from ScribeEventProducerController::onUploadComplete won't fire for this upload.
			 */
			$page = WikiPage::factory( $file->getTitle() );
			$oScribeProducer = new ScribeEventProducer( 'create' );
			if ( $oScribeProducer->buildEditPackage( $page, User::newFromId( $page->getUser() ), null, $file ) ) {
				$oScribeProducer->sendLog();
			}
		}

		return [
			'title' => $file->getTitle()->getText(),
			'url' => $file->getUrl(),
			'article_id' => $file->getTitle()->getArticleID()
		];
	}

	private function executeVideo() {
		if ( empty ( $this->mParams['provider'] ) ) {
			$this->dieUsageMsg( 'The provider parameter must be set' );
		}
		if ( $this->mParams['provider'] === 'wikia' ) {
			return $this->executeWikiaVideo();
		} else {
			return $this->execute3rdPartyVideo();
		}
	}

	private function executeWikiaVideo() {
		$title = Title::newFromText( $this->mParams['title'], NS_FILE );
		wfRunHooks( 'AddPremiumVideo', array( $title ) );
		return array(
			'title' => $title->getText()
		);
	}

	private function execute3rdPartyVideo() {
		if ( empty ( $this->mParams['videoId'] ) ) {
			$this->dieUsageMsg( 'The videoId parameter must be set' );
		}
		$duplicate = $this->getVideoDuplicate(
			$this->mParams['provider'],
			$this->mParams['videoId']
		);
		if ( $duplicate ) {
			return array(
				'title' => $duplicate->getTitle()->getText()
			);
		} else {
			$uploader = new VideoFileUploader();
			$title = $uploader->getUniqueTitle(
				wfStripIllegalFilenameChars( $this->mParams['title'] )
			);

			// https://wikia-inc.atlassian.net/browse/VE-1819
			if ( !$title ) {
				WikiaLogger::instance()->debug( 'ApiAddMediaPermanent', array( 'title' => $this->mParams['title'] ) );
			}

			$uploader->setProvider( $this->mParams['provider'] );
			$uploader->setVideoId( $this->mParams['videoId'] );
			$uploader->setTargetTitle( $title->getBaseText() );
			$uploader->upload( $title );
			return array(
				'title' => $title->getText()
			);
		}
	}

	private function getUniqueTitle( $name ) {
		$pathinfo = mb_pathinfo( $name );
		$filename = $pathinfo['filename'];
		$extension = $pathinfo['extension'];
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

	public function getAllowedParams() {
		return array(
			'token' => null,
			'license' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'provider' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'tempName' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'title' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'videoId' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			)
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}

}

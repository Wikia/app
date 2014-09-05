<?php

class NjordController extends WikiaController {

	const HERO_IMAGE_FILENAME = 'wikia-hero-image';

	public function index() {
		$this->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/NjordPrototype/css/Njord.scss' ) );
		$this->wg->Out->addScriptFile( $this->wg->ExtensionsPath . '/wikia/NjordPrototype/scripts/Njord.js' );
		$this->wg->Out->addScriptFile( $this->wg->ExtensionsPath . '/wikia/NjordPrototype/scripts/Njord.fileUpload.js' );

		$wikiDataModel = new WikiDataModel( Title::newMainPage()->getText() );
		$wikiDataModel->getFromProps();
		$this->wikiData = $wikiDataModel;
	}

	public function upload() {
		if ( $this->getRequest()->wasPosted() ) {
			$url = $this->getRequest()->getVal( 'url', false );
			if ( $url ) {
				$uploader = new UploadFromUrl();
				$uploader->initializeFromRequest( new FauxRequest(
					[
						'wpUpload' => 1,
						'wpSourceType' => 'web',
						'wpUploadFileURL' => $url
					],
					true
				) );
				$uploader->fetchFile();
			} else {
				$webRequest = $this->getContext()->getRequest();
				$uploader = new UploadFromFile();
				$uploader->initialize( $webRequest->getFileName( 'file' ), $webRequest->getUpload( 'file' ) );
			}
			$stash = new UploadStash( RepoGroup::singleton()->getLocalRepo(), $this->getContext()->getUser() );
			$stashFile = $stash->stashFile( $uploader->getTempPath() );
			$this->getResponse()->setFormat( 'json' );
			$this->getResponse()->setVal( 'url', $stashFile->getFullUrl() );
			$this->getResponse()->setVal( 'filename', $stashFile->getFileKey() );
		}
	}

	public function saveHeroData() {
		$success = false;

		$this->getResponse()->setFormat( 'json' );

		$wikiData = $this->request->getVal( 'wikiData', [ ] );
		$wikiDataModel = new WikiDataModel( Title::newMainPage()->getText() );
		$wikiDataModel->setFromAttributes( $wikiData );
		$wikiDataModel->setImageName(!empty( $wikiData['imagename'] ) ? $wikiData['imagename'] : null);

		$imageName = $wikiDataModel->getImageName();

		if ( $imageName ) {
			$stash = RepoGroup::singleton()->getLocalRepo()->getUploadStash();

			$temp_file = $stash->getFile( $imageName );
			$file = new LocalFile( static::HERO_IMAGE_FILENAME, RepoGroup::singleton()->getLocalRepo() );

			$status = $file->upload( $temp_file->getPath(), '', '' );
			if ( $status->isOK() ) {
				$success = true;

				$wikiDataModel->setImageName($file->getTitle()->getDBKey());
				$wikiDataModel->setImagePath($file->getFullUrl);

				$wikiDataModel->storeInPage();
				$wikiDataModel->storeInProps();
			}
			//clean up stash
			$stash->removeFile( $imageName );
		}

		$this->getResponse()->setVal( 'success', $success );
		$this->getResponse()->setVal( 'wikiData' , $wikiDataModel );
	}
}

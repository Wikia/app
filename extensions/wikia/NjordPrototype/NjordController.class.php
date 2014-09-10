<?php

class NjordController extends WikiaController {

	const HERO_IMAGE_FILENAME = 'wikia-hero-image';

	public function index() {
		$this->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/NjordPrototype/css/Njord.scss' ) );
		$this->wg->Out->addScriptFile( $this->wg->ExtensionsPath . '/wikia/NjordPrototype/scripts/jquery-ui-1.9.2.js' );
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
		wfProfileIn(__METHOD__);

		$success = false;

		$this->getResponse()->setFormat( 'json' );

		$wikiData = $this->request->getVal( 'wikiData', [ ] );
		$wikiDataModel = new WikiDataModel( Title::newMainPage()->getText() );
		$wikiDataModel->setFromAttributes( $wikiData );
		$imageChanged = !empty( $wikiData['imagechanged'] );
		$imageName = !empty( $wikiData['imagename'] ) ? $wikiData['imagename'] : null;

		if ( $imageChanged && $imageName ) {
			wfProfileIn(__METHOD__ . '::uploadStart');
			$stash = RepoGroup::singleton()->getLocalRepo()->getUploadStash();

			$temp_file = $stash->getFile( $imageName );
			$file = new LocalFile( static::HERO_IMAGE_FILENAME, RepoGroup::singleton()->getLocalRepo() );

			$status = $file->upload( $temp_file->getPath(), '', '' );
			wfProfileIn(__METHOD__ . '::uploadEnd');

			if ( $status->isOK() ) {
				$wikiDataModel->setImageName($file->getTitle()->getDBKey());
				$wikiDataModel->setImagePath($file->getFullUrl());

				$wikiDataModel->storeInPage();
				$wikiDataModel->storeInProps();

				//clean up stash
				$stash->removeFile( $imageName );
				$success = true;
			}
		} else {
			$wikiDataModel->setImageNameFromProps();
			$wikiDataModel->storeInPage();
			$wikiDataModel->storeInProps();
			$success = true;
		}
		if(!$success) {
			$wikiDataModel->getFromProps();
		}

		$this->getResponse()->setVal( 'success', $success );
		$this->getResponse()->setVal( 'wikiData', $wikiDataModel);

		wfProfileOut(__METHOD__);
	}
}

<?php

class NjordController extends WikiaController {

	const HERO_IMAGE_FILENAME = 'wikia-hero-image';

	public function getWikiMarkup() {
		$articleTitle = $this->getRequest()->getVal('articleTitle');
		$pageTitleObj = Title::newFromText( $articleTitle );
		$pageArticleObj = new Article( $pageTitleObj );

		$articleWikiMarkup = $pageArticleObj->getPage()->getText();
		$this->getResponse()->setFormat( 'json' );
		$this->getResponse()->setVal('wikiMarkup', $articleWikiMarkup);
	}

	public function MainPageModuleSave() {
		$articleTitle = $this->getRequest()->getVal('pageTitle');
		$wikiMarkup = $this->getRequest()->getVal('wikiMarkup');
		$pageTitleObj = Title::newFromText( $articleTitle );
		$pageArticleObj = new Article( $pageTitleObj );

		$pageArticleObj->doEdit( $wikiMarkup, '' );
		$pageArticleObj->doPurge();
		$newHtml = $pageArticleObj->getPage()->getParserOutput( new ParserOptions( null, null ) )->getText();

		$this->getResponse()->setFormat( 'json' );
		$this->getResponse()->setVal('html', $newHtml);
	}

	public function index() {
		$this->wg->SuppressPageHeader = true;
		
		$this->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/NjordPrototype/css/Njord.scss' ) );
		$this->wg->Out->addScriptFile( $this->wg->ExtensionsPath . '/wikia/NjordPrototype/scripts/jquery-ui-1.9.2.js' );
		$this->wg->Out->addScriptFile( $this->wg->ExtensionsPath . '/wikia/NjordPrototype/scripts/jquery.caret.js' );
		$this->wg->Out->addScriptFile( $this->wg->ExtensionsPath . '/wikia/NjordPrototype/scripts/Njord.js' );
		$this->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/NjordPrototype/css/Mom.scss' ) );
		$this->wg->Out->addScriptFile( $this->wg->ExtensionsPath . '/wikia/NjordPrototype/scripts/Mom.js' );

		$wikiDataModel = new WikiDataModel( Title::newMainPage()->getText() );
		$wikiDataModel->getFromProps();
		$this->wikiData = $wikiDataModel;
	}

	public function modula() {
		$this->content = $this->getRequest()->getVal('content');
		$this->align = $this->getRequest()->getVal('align');
		$this->ctitle = $this->getRequest()->getVal('content-title');
	}

	public function mom() {}

	public function reorder() {
		$params = $this->getRequest()->getParams();

		$pageTitleObj = Title::newFromText( $params['page'] );
		$pageArticleObj = new Article( $pageTitleObj );
		$content = $pageArticleObj->getContent();

		$content = mb_ereg_replace('<modula.*/>', '', $content, 'sU' );
		$moduleTags = [];
		foreach ($params['left'] as $title) {
			$moduleTags[] = Xml::element( 'modula', $attribs = [
				'align' => 'left',
				'content-title' => $title,
			] );
		}
		$content = mb_ereg_replace('(<mainpage-leftcolumn-start.*/>)\s*', "\\1\n" . implode($moduleTags, "\n"). "\n", $content, 'sU' );
		$moduleTags = [];
		foreach ($params['right'] as $title) {
			$moduleTags[] = Xml::element( 'modula', $attribs = [
				'align' => 'right',
				'content-title' => $title,
			] );
		}
		$content = mb_ereg_replace('(<mainpage-rightcolumn-start.*/>)\s*', "\\1\n" . implode($moduleTags, "\n"). "\n", $content, 'sU' );
		// save and purge
		$pageArticleObj->doEdit( $content, '' );
		$pageArticleObj->doPurge();
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

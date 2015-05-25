<?php

class NjordController extends WikiaController {

	const HERO_IMAGE_FILENAME = 'wikia-hero-image';
	const THUMBNAILER_SIZE_SUFIX = '1600px-0';

	const MAINPAGE_PAGE = 'mainpage';

	private static $wikiDataModel = null;

	public function __construct() {
		parent::__construct();

		$this->initWikiDataModel();
	}

	private function initWikiDataModel() {
		if (self::$wikiDataModel === null) {
			self::$wikiDataModel = new WikiDataModel(Title::newMainPage()->getText());
			self::$wikiDataModel->getFromProps();
		}
	}

	public function getWikiMarkup() {
		$articleWikiMarkup = '';
		$articleTitle = $this->getRequest()->getVal( 'articleTitle' );
		$pageTitleObj = Title::newFromText( $articleTitle );
		if ( isset($pageTitleObj) && $pageTitleObj->exists() ) {
			$pageArticleObj = new Article( $pageTitleObj );
			$articleWikiMarkup = $pageArticleObj->getPage()->getText();
		}
		$this->getResponse()->setFormat( 'json' );
		$this->getResponse()->setVal( 'wikiMarkup', $articleWikiMarkup );
	}

	public function MainPageModuleSave() {
		$articleTitle = $this->getRequest()->getVal( 'pageTitle' );
		$wikiMarkup = $this->getRequest()->getVal( 'wikiMarkup' );
		$pageTitleObj = Title::newFromText( $articleTitle );
		$pageArticleObj = new Article( $pageTitleObj );

		$pageArticleObj->doEdit( $wikiMarkup, '' );
		$pageArticleObj->doPurge();
		$newHtml = $pageArticleObj->getPage()->getParserOutput( new ParserOptions( null, null ) )->getText();

		$this->getResponse()->setFormat( 'json' );
		$this->getResponse()->setVal( 'html', $newHtml );
	}

	public function index() {
		global $wgTitle, $wgUser, $wgBlankImgUrl;
		$wikiDataModel = self::$wikiDataModel;

		$this->wg->SupressPageTitle = true;

		$this->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/NjordPrototype/css/Njord.scss' ) );

		$wikiDataModel->imageSet = true;
		if ( !isset( $wikiDataModel->imagePath ) ) {
			$wikiDataModel->imageSet = false;
			$wikiDataModel->imagePath = $wgBlankImgUrl;
			$wikiDataModel->originalImagePath = $wgBlankImgUrl;
		}

		// template vars
		$this->wikiData = $wikiDataModel;
		$this->isAllowedToEdit = $this->wg->user->isAllowed( 'njordeditmode' );
	}

	public function summary() {
		global $wgUser;
		$wikiDataModel = self::$wikiDataModel;

		if ( !$wgUser->isLoggedIn() && $wikiDataModel->isEmpty() ) {
			return $this->skipRendering();
		}

		// template vars
		$this->wikiData = $wikiDataModel;
		$this->isAllowedToEdit = $this->wg->user->isAllowed( 'njordeditmode' );
	}

	public function modula() {
		$this->content = $this->getRequest()->getVal( 'content' );
		$this->align = $this->getRequest()->getVal( 'align' );
		$this->ctitle = $this->getRequest()->getVal( 'content-title' );
		$this->title = $this->getRequest()->getVal( 'title' );

		if ( empty( $this->ctitle ) ) {
			$mainpage = Title::newFromText( self::MAINPAGE_PAGE );
			$subpages = $mainpage->getSubpages();
			$current = 1;
			while ( $subpages->valid() ) {
				$curSub = $subpages->current();
				if ( $current == $curSub->getSubpageText() ) {
					$current++;
				}
				$subpages->next();
			}
			$this->ctitle = self::MAINPAGE_PAGE . "/" . $current;
		}
	}

	public function mom() {
	}

	public function reorder() {
		$params = $this->getRequest()->getParams();

		$pageTitleObj = Title::newFromText( $params[ 'page' ] );
		$pageArticleObj = new Article( $pageTitleObj );
		$content = $pageArticleObj->getContent();

		$content = mb_ereg_replace( '<modula.*/>', '', $content, 'sU' );
		$moduleTags = [ ];
		foreach ( $params[ 'left' ] as $raw ) {
			$data = json_decode( $raw );
			$moduleTags[ ] = Xml::element( 'modula', $attribs = [
				'align' => 'left',
				'title' => $data->text,
				'content-title' => $data->title,
			] );
		}
		$content = mb_ereg_replace( '(<mainpage-leftcolumn-start.*/>)\s*', "\\1\n" . implode( $moduleTags, "\n" ) . "\n", $content, 'sU' );
		$moduleTags = [ ];
		foreach ( $params[ 'right' ] as $raw ) {
			$data = json_decode( $raw );
			$moduleTags[ ] = Xml::element( 'modula', $attribs = [
				'align' => 'right',
				'title' => $data->text,
				'content-title' => $data->title,
			] );
		}
		$content = mb_ereg_replace( '(<mainpage-rightcolumn-start.*/>)\s*', "\\1\n" . implode( $moduleTags, "\n" ) . "\n", $content, 'sU' );
		// save and purge
		$pageArticleObj->doEdit( $content, '' );
		$pageArticleObj->doPurge();
	}

	public function upload() {
		if ( $this->getRequest()->wasPosted() ) {
			$url = $this->getRequest()->getVal( 'url', false );
			try {
				if ( $url ) {
					list( $tempPath, $EIA, $errorMessage ) = $this->uploadFromUrl( $url );
				} else {
					list( $tempPath, $EIA, $errorMessage ) = $this->uploadFromFile();
				}
			} catch ( Exception $exception ) {
				$EIA = false;
				$errorMessage = $exception->getMessage();
			}

			$this->getResponse()->setFormat( 'json' );
			$this->getResponse()->setVal( 'isOk', $EIA );
			if ( $EIA === true ) {
				$stash = RepoGroup::singleton()->getLocalRepo()->getUploadStash();
				$stashFile = $stash->stashFile( $tempPath );
				$this->getResponse()->setVal( 'url', wfReplaceImageServer( $stashFile->getThumbUrl( static::THUMBNAILER_SIZE_SUFIX ) ) );
				$this->getResponse()->setVal( 'filename', $stashFile->getFileKey() );
			} else {
				$this->getResponse()->setVal( 'errTitle', wfMessage( 'hero-image-error')->text() );
				$this->getResponse()->setVal( 'errMessage', $errorMessage );
			}
		}
	}

	public function saveTitleAndDescription() {
		$description = $this->getRequest()->getVal( 'description', false );

		$success = false;
		$wikiDataModel = $this->getWikiData();

		if ( $description ) {
			$wikiDataModel->description = $description;
		}

		if ( $description ) {
			$success = $this->setWikiData( $wikiDataModel );
		}

		$this->getResponse()->setVal( 'success', $success );
		$this->getResponse()->setVal( 'wikiData', $wikiDataModel );
	}

	public function saveHeroImage() {
		$image = $this->getRequest()->getVal( 'imagename', false );
		$cropPosition = $this->getRequest()->getVal( 'cropposition', false );
		$success = false;
		if ( $image !== false && $cropPosition !== false ) {
			$wikiDataModel = $this->getWikiData();
			$wikiDataModel->cropPosition = $cropPosition;

			wfProfileIn( __METHOD__ . '::uploadStart' );
			$stash = RepoGroup::singleton()->getLocalRepo()->getUploadStash();

			$temp_file = $stash->getFile( $image );
			$file = new LocalFile( static::HERO_IMAGE_FILENAME, RepoGroup::singleton()->getLocalRepo() );

			$status = $file->upload( $temp_file->getPath(), '', '' );
			wfProfileIn( __METHOD__ . '::uploadEnd' );

			if ( $status->isOK() ) {
				$wikiDataModel->setImageName( $file->getTitle()->getDBKey() );
				$wikiDataModel->setImagePath( $file->getFullUrl() );
				$success = $this->setWikiData( $wikiDataModel );
				//clean up stash
				$stash->removeFile( $image );
			}
		}
		$this->getResponse()->setVal( 'success', $success );
		$this->getResponse()->setVal( 'wikiData', $wikiDataModel );
	}

	protected function getWikiData() {
		//FIXME: use actual main page instead of default one
		$wikiDataModel = new WikiDataModel( Title::newMainPage()->getText() );
		$wikiDataModel->getFromProps();
		return $wikiDataModel;
	}

	protected function setWikiData( WikiDataModel $wikiDataModel ) {
		if ( $this->isAllowedToEdit = $this->wg->user->isAllowed( 'njordeditmode' ) ) {
			$wikiDataModel->storeInPage();
			$wikiDataModel->storeInProps();

			return true;
		} else {
			return false;
		}
	}

	public function saveHeroData() {
		wfProfileIn( __METHOD__ );

		$success = false;

		$this->getResponse()->setFormat( 'json' );

		$wikiData = $this->request->getVal( 'wikiData', [ ] );
		$wikiDataModel = new WikiDataModel( Title::newMainPage()->getText() );
		$wikiDataModel->setFromAttributes( $wikiData );
		$imageChanged = !empty( $wikiData[ 'imagechanged' ] );
		$imageName = !empty( $wikiData[ 'imagename' ] ) ? $wikiData[ 'imagename' ] : null;

		if ( $imageChanged && $imageName ) {
			wfProfileIn( __METHOD__ . '::uploadStart' );
			$stash = RepoGroup::singleton()->getLocalRepo()->getUploadStash();

			$temp_file = $stash->getFile( $imageName );
			$file = new LocalFile( static::HERO_IMAGE_FILENAME, RepoGroup::singleton()->getLocalRepo() );

			$status = $file->upload( $temp_file->getPath(), '', '' );
			wfProfileIn( __METHOD__ . '::uploadEnd' );

			if ( $status->isOK() ) {
				$wikiDataModel->setImageName( $file->getTitle()->getDBKey() );
				$wikiDataModel->setImagePath( $file->getFullUrl() );

				$success = $this->setWikiData( $wikiDataModel );

				//clean up stash
				$stash->removeFile( $imageName );
			}
		} else {
			$wikiDataModel->setImageNameFromProps();
			$success = $this->setWikiData( $wikiDataModel );
		}
		if ( !$success ) {
			$wikiDataModel->getFromProps();
		}

		$this->getResponse()->setVal( 'success', $success );
		$this->getResponse()->setVal( 'wikiData', $wikiDataModel );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * @param $url
	 * @return array
	 */
	public function uploadFromUrl( $url ) {
		$uploader = new UploadFromUrl();
		$uploader->initializeFromRequest( new FauxRequest(
			[
				'wpUpload' => 1,
				'wpSourceType' => 'web',
				'wpUploadFileURL' => $url
			],
			true
		) );
		$status = $uploader->fetchFile();
		if ( $status->isGood() ) {
			return [ $uploader->getTempPath(), true ];
		} else {
			return [ $uploader->getTempPath(), false, $this->getUploadUrlErrorMessage( $status ) ];
		}
	}

	private function getUploadUrlErrorMessage( $status ) {
		return "";
	}

	/**
	 * @return array
	 */
	public function uploadFromFile() {
		$webRequest = $this->getContext()->getRequest();
		$uploader = new UploadFromFile();
		$uploader->initialize( $webRequest->getFileName( 'file' ), $webRequest->getUpload( 'file' ) );
		$verified = $uploader->verifyUpload();
		if ( $verified[ 'status' ] == 0 || $verified[ 'status' ] == 10 ) {
			return [ $uploader->getTempPath(), true ];
		} else {
			return [ $uploader->getTempPath(), false, $this->getUploadFileErrorMessage( $uploader,
				$verified ) ];
		}
	}

	public function getUploadFileErrorMessage( UploadFromFile $uploader, $verified ) {
		$errorReadable = $uploader->getVerificationErrorCode( $verified[ 'status' ] );
		return wfMessage( $errorReadable )->parse();
	}
}

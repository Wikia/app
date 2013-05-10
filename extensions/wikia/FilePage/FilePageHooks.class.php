<?php

class FilePageHooks extends WikiaObject{

	const VIDEO_WIKI = 298117;

	function __construct(){
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}

	/**
	 * Determine which FilePage to show based on skin and File type (image/video)
	 *
	 * @param Title $oTitle
	 * @param Article $oArticle
	 */
	public function onArticleFromTitle( &$oTitle, &$oArticle ){
		global $wgEnableVideoPageRedesign;

		if ( ( $oTitle instanceof Title ) && ( $oTitle->getNamespace() == NS_FILE ) ){

			if ( F::app()->checkSkin( 'oasis' ) &&  !empty( $wgEnableVideoPageRedesign ) ) {
				$oArticle = new FilePageTabbed( $oTitle );
			} else {
				$oArticle = new FilePageFlat( $oTitle );
			}
		}

		return true;
	}



	/**
	 * Add JS and CSS to File Page
	 */
	public function onBeforePageDisplay( OutputPage $out, $skin ) {
		global $wgEnableVideoPageRedesign;

		$app = F::app();

		wfProfileIn(__METHOD__);
		// load assets when File Page redesign is enabled and on the File Page
		if( $app->checkSkin( 'oasis' ) && $app->wg->Title->getNamespace() == NS_FILE &&  !empty( $wgEnableVideoPageRedesign ) ) {
			$assetsManager = F::build( 'AssetsManager', array(), 'getInstance' );
			$scssPackage = 'file_page_css';
			$jsPackage = 'file_page_js';

			foreach ( $assetsManager->getURL( $scssPackage ) as $url ) {
				$out->addStyle( $url );
			}

			foreach ( $assetsManager->getURL( $jsPackage ) as $url ) {
				$out->addScript( "<script src=\"{$url}\"></script>" );
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}


	/*
	 * Add "replace" button to File pages
	 * Add "remove" action to MenuButtons on premium video file pages
	 * This button will remove a video from a wiki but keep it on the Video Wiki.
	 */
	public function onSkinTemplateNavigation($skin, &$tabs) {
		global $wgUser;

		$app = F::app();

		$title = $app->wg->Title;

		if ( ( $title instanceof Title ) && ( $title->getNamespace() == NS_FILE ) && $title->exists() ) {
			$file = $app->wf->FindFile( $title );
			if ( ( $file instanceof File ) && UploadBase::userCanReUpload( $wgUser, $file->getName() ) ) {
				if ( WikiaFileHelper::isTitleVideo( $title ) ) {
					$uploadTitle = SpecialPage::getTitleFor( 'WikiaVideoAdd' );
					$href = $uploadTitle->getFullURL( array(
						'name' => $file->getName()
					 ) );
				} else {
					$uploadTitle = SpecialPage::getTitleFor( 'Upload' );
					$href = $uploadTitle->getFullURL( array(
						'wpDestFile' => $file->getName(),
						'wpForReUpload' => 1
					 ) );
				}
				$tabs['actions']['replace-file'] = array(
					'class' => 'replace-file',
					'text' => wfMessage('file-page-replace-button'),
					'href' => $href,
				);
			}
		}

		// Ignore Video Wiki videos beyond this point
		if( $app->wg->CityId == self::VIDEO_WIKI ) {
			return true;
		}

		if ( WikiaFileHelper::isTitleVideo( $title ) ) {
			$file = $app->wf->FindFile( $title );
			if( !$file->isLocal() ) {
				// Prevent move tab being shown.
				unset( $tabs['actions']['move'] );
			}
		}

		return true;
	}

	/**
	 * Hook: get wiki link for SpecialGlobalUsage::formatItem()
	 * @param array $item
	 * @param string $page
	 * @param string|false $link
	 * @return true
	 */
	public function onGlobalUsageFormatItemWikiLink( $item, $page, &$link ) {
		$link = WikiFactory::DBtoUrl( $item['wiki'] );
		if ( $link ) {
			$link .= 'wiki/'.$page;
			$link = Xml::element( 'a', array( 'href' => $link ), str_replace( '_',' ', $page ) );
		}

		return true;
	}

	/**
	 * Hook: get wiki link for GlobalUsage
	 * @param string $wikiName
	 * @return true
	 */
	public function onGlobalUsageImagePageWikiLink( &$wikiName ) {
		$wiki = WikiFactory::getWikiByDB( $wikiName );
		if ( $wiki ) {
			$wikiName = '['.$wiki->city_url.' '.$wiki->city_title.']';
		}

		return true;
	}

	/**
	 * Hook: check for video files
	 * @param array $images
	 * @return true
	 */
	public function onGlobalUsageLinksUpdateComplete( &$images ) {
		$videoFiles = array();
		foreach( $images as $image ) {
			$file = wfFindFile( $image );
			if ( $file instanceof File && WikiaFileHelper::isFileTypeVideo( $file ) ) {
				$videoFiles[] = $image;
			}
		}
		$images = $videoFiles;

		return true;
	}
}

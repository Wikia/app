<?php

/**
 * Class FilePageHooks
 */
class FilePageHooks extends WikiaObject{

	/**
	 * Determine which FilePage to show based on skin and File type (image/video)
	 *
	 * @param Title $oTitle
	 * @param Article $oArticle
	 * @return bool true
	 */
	static public function onArticleFromTitle( &$oTitle, &$oArticle ) {
		if ( ( $oTitle instanceof Title ) && ( $oTitle->getNamespace() == NS_FILE ) ) {
			$oArticle = WikiaFileHelper::getMediaPage( $oTitle );
		}

		return true;
	}


	/**
	 * Add JS and CSS to File Page (except mobile skin - see onWikiaMobileAssetsPackages)
	 *
	 * @param OutputPage $out
	 * @param $skin
	 * @return bool
	 */
	static public function onBeforePageDisplay( OutputPage $out, $skin ) {
		global $wgEnableVideoPageRedesign;

		$app = F::app();

		wfProfileIn(__METHOD__);
		if ( $app->wg->Title->getNamespace() == NS_FILE ) {
			$assetsManager = AssetsManager::getInstance();
			$wikiaFilePageJs = 'wikia_file_page_js';

			foreach ( $assetsManager->getURL( $wikiaFilePageJs ) as $url ) {
				$out->addScript( "<script src=\"{$url}\"></script>" );
			}

			// load assets when File Page redesign is enabled
			if ( $app->checkSkin( 'oasis' ) &&  !empty( $wgEnableVideoPageRedesign ) ) {
				$filePageTabbedCss = 'file_page_tabbed_css';
				$filePageTabbedJs = 'file_page_tabbed_js';

				foreach ( $assetsManager->getURL( $filePageTabbedCss ) as $url ) {
					$out->addStyle( $url );
				}

				foreach ( $assetsManager->getURL( $filePageTabbedJs ) as $url ) {
					$out->addScript( "<script src=\"{$url}\"></script>" );
				}
			}
		}
		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Add assets to mobile file page
	 *
	 * @param array $jsStaticPackages
	 * @param array $jsExtensionPackages
	 * @param array $scssPackages
	 * @return bool
	 */
	static public function onWikiaMobileAssetsPackages( Array &$jsStaticPackages, Array &$jsExtensionPackages, Array &$scssPackages ) {
		if ( F::app()->wg->Title->getNamespace() == NS_FILE ) {
			$jsExtensionPackages[] = 'filepage_js_wikiamobile';
			$scssPackages[] = 'filepage_scss_wikiamobile';
		}

		return true;
	}

	/**
	 * Add "replace" button to File pages
	 * This button will remove a video from a wiki but keep it on the Video Wiki.
	 */
	static public function onSkinTemplateNavigation( $skin, &$tabs ) {
		global $wgUser;

		$app = F::app();

		$title = $app->wg->Title;

		if ( ( $title instanceof Title ) && ( $title->getNamespace() == NS_FILE ) && $title->exists() ) {
			$file = wfFindFile( $title );
			if ( ( $file instanceof File ) && UploadBase::userCanReUpload( $wgUser, $file->getName() ) ) {
				if ( WikiaFileHelper::isFileTypeVideo( $file ) ) {
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

		if ( WikiaFileHelper::isFileTypeVideo( $title ) ) {
			$file = wfFindFile( $title );
			if ( !$file->isLocal() ) {
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
	 * @return bool true
	 */
	static public function onGlobalUsageFormatItemWikiLink( $item, $page, &$link ) {
		$link = WikiFactory::DBtoUrl( $item['wiki'] );
		if ( $link ) {
			$domain = WikiFactory::cityUrlToDomain( $link );
			$articlePath = str_replace( '$1', $page, WikiFactory::cityUrlToArticlePath( $link ) );

			$link = $domain . $articlePath;
			$link = Xml::element( 'a', array( 'href' => $link ), str_replace( '_',' ', $page ) );
		}

		return true;
	}

	/**
	 * Hook: get wiki link for GlobalUsage
	 * @param string $wikiName
	 * @return bool true
	 */
	static public function onGlobalUsageImagePageWikiLink( &$wikiName ) {
		$wiki = WikiFactory::getWikiByDB( $wikiName );
		if ( $wiki ) {
			$wikiName = '['.$wiki->city_url.' '.$wiki->city_title.']';
		}

		return true;
	}

	/**
	 * Hook: check for video files
	 * @param array $images
	 * @return bool true
	 */
	static public function onGlobalUsageLinksUpdateComplete( &$images ) {
		$videoFiles = array();
		foreach ( $images as $image ) {
			$file = wfFindFile( $image );
			if ( $file instanceof File && WikiaFileHelper::isFileTypeVideo( $file ) ) {
				$videoFiles[] = $image;
			}
		}
		$images = $videoFiles;

		return true;
	}

	/**
	 * Hook to set surrogate keys on pages
	 *
	 * @param Title $title -- instance of Title class
	 *
	 * @return true -- because it's a hook
	 */
	public static function onInsertSurrogateKey( Title $title , &$surrogateKeys ) {
		$surrogateKeys = array_merge( $surrogateKeys, FilePageHelper::getSurrogateKeys( $title ) );

		return true;
	}

	/**
	 * Hook to clear caches for linked materials
	 *
	 * @param Title $title -- instance of Title class
	 *
	 * @return true -- because it's a hook
	 */
	public static function onUndeleteComplete( Title $title ) {
		self::clearLinkedFilesCache( $title, true );

		return true;
	}

	/**
	 * Hook to clear caches for linked materials
	 *
	 * @param WikiPage $page
	 *
	 * @return true -- because it's a hook
	 */
	public static function onArticleSave( WikiPage $page ) {
		self::clearLinkedFilesCache( $page->getTitle(), true );

		return true;
	}

	/**
	 * Hook to clear caches for linked materials
	 *
	 * @param Title $title -- instance of Title class
	 * @param User $user -- current user
	 * @param string $reason -- undeleting reason
	 *
	 * @return true -- because it's a hook
	 */
	public static function onArticleDelete( WikiPage $page ) {
		self::clearLinkedFilesCache( $page->mTitle );

		return true;
	}

	/**
	 * Hook to clear caches for linked materials after material was edited
	 *
	 * @param Title $title -- instance of Title class
	 * @param User $user -- current user
	 * @param string $reason -- undeleting reason
	 *
	 * @return true -- because it's a hook
	 */
	public static function onArticleSaveComplete( WikiPage $page ) {
		self::clearLinkedFilesCache( $page->mTitle, true );

		return true;
	}


	/**
	 * Clear memcache and purge page
	 *
	 * @param Title $title -- instance of Title class
	 *
	 */
	private static function purgeMemcache( Title $title ) {
		global $wgMemc;
		$redirKey = wfMemcKey( 'redirprefix', 'http', $title->getPrefixedText() );
		$wgMemc->delete( $redirKey );
		$redirKey = wfMemcKey( 'redirprefix', 'https', $title->getPrefixedText() );
		$wgMemc->delete( $redirKey );
		\Wikia\Logger\WikiaLogger::instance()->info( __FUNCTION__, [
			'key' => $redirKey,
		] );
	}


	/**
	 * getFileLinks get links to material
	 *
	 * @param $id Int: page_id value of the page being deleted
	 *
	 * @return ResultWrapper -  image links
	 */
	private static function getFileLinks( $id ) {
		$dbr = wfGetDB( DB_SLAVE );

		return $dbr->select(
			[ 'imagelinks' ],
			[ 'il_to' ],
			[ 'il_from' => $id ],
			__METHOD__,
			[ 'ORDER BY' => 'il_to', ] );

	}

	/**
	 * Clear memcache redirs before db changed
	 *
	 * @param $id Int: page_id value of the page being deleted
	 */
	private static function clearLinkedFilesCache( Title $title, bool $memcacheOnly = false ) {
		$results = FilePageHelper::getFileLinks( $title->getArticleID() );
		$keys = FilePageHelper::getSurrogateKeys( $title );
		if ( $results ) {
			foreach ( $results as $row ) {
				$title = Title::makeTitleSafe( NS_FILE, $row->il_to );
				self::purgeMemcache( $title );
			}
		}
		if ( !$memcacheOnly ) {
			foreach ( $keys as $key ) {
				\Wikia\Logger\WikiaLogger::instance()->info( __FUNCTION__, [
					'key' => $key,
				] );
				Wikia::purgeSurrogateKey( $key );
				Wikia::purgeSurrogateKey( $key, 'mercury' );
			}
		}
	}
}

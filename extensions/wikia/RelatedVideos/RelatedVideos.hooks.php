<?php

class RelatedVideosHookHandler {

	const RELATED_VIDEOS_POSITION = 2;

	static public function onOutputPageBeforeHTML( OutputPage &$out, &$text ) {
		wfProfileIn(__METHOD__);

		if( $out->isArticle() && F::app()->wg->request->getVal( 'diff' ) === null && ( F::app()->wg->title->getNamespace() == NS_MAIN ) ) {
			$text .= F::app()->sendRequest('RelatedVideos', 'getCarousel')->toString();
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Purge RelatedVideos namespace article after an edit
	 *
	 * @param WikiPage $article
	 * @param $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param $status
	 * @param $baseRevId
	 * @return bool
	 */
	static public function onArticleSaveComplete(&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		wfProfileIn(__METHOD__);

		$title = $article->getTitle();
		if ( !empty( $title ) ) {
			switch ( $title->getNamespace() ) {
				case NS_RELATED_VIDEOS:
					$relatedVideosNSData = RelatedVideosNamespaceData::newFromTitle($title);
					$relatedVideosNSData->purge();
					break;
				case NS_MEDIAWIKI:
					if ( $title->getText() == RelatedVideosNamespaceData::GLOBAL_RV_LIST ) {
						$relatedVideos = RelatedVideosNamespaceData::newFromGeneralMessage();
						if ( !empty($relatedVideos) ) {
							$relatedVideos->purge();
							if ( VideoInfoHelper::videoInfoExists() ) {
								$data = $relatedVideos->getData();
								if ( !empty($data['lists'][RelatedVideosNamespaceData::WHITELIST_MARKER]) ) {
									$images = array();
									foreach( $data['lists'][RelatedVideosNamespaceData::WHITELIST_MARKER] as $page ) {
										$key = md5( $page['title'] );
										if ( !array_key_exists($key, $images) ) {
											$images[$key] = $page['title'];
										}
									}

									if ( !empty($images) ) {
										$affected = false;
										$userId = $user->getId();
										$videoInfoHelper = new VideoInfoHelper();
										foreach( $images as $img ) {
											$videoInfo = $videoInfoHelper->getVideoInfoFromTitle( $img, true );
											if ( !empty($videoInfo) ) {
												$affected = ( $affected || $videoInfo->addPremiumVideo( $userId ) );
											}
										}

										if ( $affected ) {
											$mediaService = new MediaQueryService();
											$mediaService->clearCacheTotalVideos();
											$mediaService->clearCacheTotalPremiumVideos();
										}
									}
								}
							}
						}
					}
					break;
			}
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Entry for adding parser magic words
	 */
	static public function onLanguageGetMagic( &$magicWords, $langCode ){
		wfProfileIn(__METHOD__);

		$magicWords[ 'RELATEDVIDEOS_POSITION' ] = array( 0, '__RELATEDVIDEOS__' );

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Entry for removing the magic words from displayed text
	 */
	static public function onInternalParseBeforeLinks( &$parser, &$text, &$strip_state ) {
		wfProfileIn(__METHOD__);

		if ( empty( F::app()->wg->RTEParserEnabled ) ) {
			$oMagicWord = MagicWord::get('RELATEDVIDEOS_POSITION');
			$text = $oMagicWord->replace('<span data-placeholder="RelatedVideosModule"></span>', $text, 1 );
			$text = $oMagicWord->replace( '', $text );
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	static public function onGetRailModuleList(&$modules) {
		$app = F::App();
		wfProfileIn(__METHOD__);

		$title = $app->wg->Title;
		$namespace = $title->getNamespace();

		if( self::isRailModuleWanted($title, $namespace) ) {
			// This module wants to be above the hulu module (1280) if logged in
			// and above the photos module (1300) if not logged in.  Give extra number space
			// so that other modules can slip in if need be.
			$pos = $app->wg->User->isAnon() ? 1305 : 1285;
			$modules[$pos] = array('RelatedVideosRail', 'index', null);
		}

		wfProfileOut(__METHOD__);
		return true;
	}
	
	static private function isRailModuleWanted($title, $namespace) {
		$app = F::App();
		
		return !HubService::isCorporatePage()
			&& $title->exists()
			&& $app->wg->request->getVal( 'diff' ) === null
			&& ( $namespace == NS_MAIN 
				|| $namespace == NS_FILE 
				|| $namespace == NS_CATEGORY
				|| ( (!empty($app->wg->ContentNamespace)) && in_array($namespace, $app->wg->ContentNamespace) ) 
			);
	}

	/**
	 * Hook: clear cache when file is deleted
	 * @param LocalFile $file
	 * @param $oldimage
	 * @param $article
	 * @param User $user
	 * @param $reason
	 * @return true
	 */
	static public function onFileDeleteComplete( &$file, $oldimage, $article, $user, $reason ) {
		RelatedVideosEmbededData::purgeEmbededArticles( $file->getTitle() );

		return true;
	}

	/**
	 * Hook: clear cache when file is restored
	 * @param Title $title
	 * @param $versions
	 * @param User $user
	 * @param $comment
	 * @return true
	 */
	static public function onFileUndeleteComplete( $title, $versions, $user, $comment ) {
		RelatedVideosEmbededData::purgeEmbededArticles( $title );

		return true;
	}

	/**
	 * Hook: clear cache when file is renamed
	 * @param $form
	 * @param Title $oldTitle
	 * @param Title $newTitle
	 * @return true
	 */
	static public function onFileRenameComplete( &$form , &$oldTitle , &$newTitle ) {
		if ( $oldTitle->getDBKey() != $newTitle->getDBKey() ) {
			RelatedVideosEmbededData::purgeEmbededArticles( $oldTitle );
		}

		return true;
	}

	/**
	 * Hook: delete video from related videos module when the file page is deleted
	 * @param WikiPage $wikiPage
	 * @param User $user
	 * @param string $reason
	 * @param integer $pageId
	 * @return true
	 */
	static public function onArticleDeleteComplete( &$wikiPage, &$user, $reason, $pageId  ) {
		$title = $wikiPage->getTitle();
		if ( $title instanceof Title && $title->getNamespace() == NS_FILE ) {
			$relatedVideos = RelatedVideosNamespaceData::newFromGeneralMessage();
			if( !empty($relatedVideos) ) {
				// add video only if the videos already exists in blacklist
				$entry = $relatedVideos->getEntry( $title->getText(), RelatedVideosNamespaceData::WHITELIST_MARKER );
				if ( !empty($entry) ) {
					// move title from white list to black list
					$result = $relatedVideos->addToList( RelatedVideosNamespaceData::BLACKLIST_MARKER, array( $entry ) );
				}
			}
		}

		return true;
	}

	/**
	 * Hook: restore video to related videos module when the file page is undeleted
	 * @param Title $title
	 * @param User $wgUser
	 * @param string $reason
	 * @return true
	 */
	static public function onUndeleteComplete( &$title, &$user, $reason ) {
		if ( $title instanceof Title && $title->getNamespace() == NS_FILE ) {
			$relatedVideos = RelatedVideosNamespaceData::newFromGeneralMessage();
			if( !empty($relatedVideos) ) {
				// add video only if the videos already exists in blacklist
				$entry = $relatedVideos->getEntry( $title->getText(), RelatedVideosNamespaceData::BLACKLIST_MARKER );
				if ( !empty($entry) ) {
					$result = $relatedVideos->addToList( RelatedVideosNamespaceData::WHITELIST_MARKER, array( $entry ) );
				}
			}
		}

		return true;
	}
}

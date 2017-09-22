<?php

/**
 * Class RecirculationHooks
 */
class RecirculationHooks {

	/**
	 * Insert Recirculation to the right rail
	 *
	 * @param array $modules
	 *
	 * @return bool
	 */
	static public function onGetRailModuleList( &$modules ) {
		// Check if we're on a page where we want to show a recirculation module.
		// If we're not, stop right here.
		if ( !static::isCorrectPageType() ) {
			return true;
		}

		// Use a different position depending on whether the user is logged in
		// This is based off of the logic from the VideosModule extension
		$app = F::App();
		$pos = $app->wg->User->isAnon() ? 1305 : 1285;

		$modules[$pos] = [ 'Recirculation', 'container', [ 'containerId' => 'recirculation-rail' ] ];

		return true;
	}

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		JSMessages::enqueuePackage( 'Recirculation', JSMessages::EXTERNAL );
		Wikia::addAssetsToOutput( 'recirculation_scss' );

		if ( static::isCorrectPageType() ) {
			self::addLiftIgniterMetadata( $out );
		}

		return true;
	}

	/**
	 * Modify assets appended to the bottom of the page
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public static function onOasisSkinAssetGroups( &$jsAssets ) {
		global $wgNoExternals;

		if ( static::isCorrectPageType() ) {
			if ( empty( $wgNoExternals ) ) {
				$jsAssets[] = 'recirculation_liftigniter_tracker';
			}
			$jsAssets[] = 'recirculation_js';
		}

		return true;
	}

	/**
	 * Return whether we're on one of the pages where we want to show the Recirculation widgets,
	 * specifically File pages, Article pages, and Main pages
	 *
	 * @return bool
	 */
	static public function isCorrectPageType() {
		$wg = F::app()->wg;

		$showableNameSpaces = array_merge( $wg->ContentNamespaces, [ NS_FILE, NS_BLOG_ARTICLE ] );

		if ( $wg->Title->exists() &&
			in_array( $wg->Title->getNamespace(), $showableNameSpaces ) &&
			$wg->request->getVal( 'action', 'view' ) === 'view' &&
			$wg->request->getVal( 'diff' ) === null &&
			!WikiaPageType::isCorporatePage()
		) {
			return true;
		} else {
			return false;
		}
	}

	static public function canShowDiscussions( $cityId, $ignoreWgEnableRecirculationDiscussions = false ) {
		$discussionsAlias = WikiFactory::getVarValueByName( 'wgRecirculationDiscussionsAlias', $cityId );

		if ( !empty( $discussionsAlias ) ) {
			$cityId = $discussionsAlias;
		}

		$discussionsEnabled = WikiFactory::getVarValueByName( 'wgEnableDiscussions', $cityId );
		$recirculationDiscussionsEnabled =
			WikiFactory::getVarValueByName( 'wgEnableRecirculationDiscussions', $cityId );

		if ( !empty( $discussionsEnabled ) &&
			( $ignoreWgEnableRecirculationDiscussions || !empty( $recirculationDiscussionsEnabled ) )
		) {
			return true;
		} else {
			return false;
		}
	}

	private static function addLiftIgniterMetadata( OutputPage $outputPage ) {
		$metaData = self::getMetaData();
		$metaDataJson = json_encode( $metaData );

		$outputPage->addScript(
			"<script id=\"liftigniter-metadata\" type=\"application/json\">${metaDataJson}</script>"
		);
	}

	private static function getMetaData() {
		global $wgLanguageCode, $wgCityId, $wgEnableArticleFeaturedVideo;
		$context = RequestContext::getMain();
		$title = $context->getTitle();
		$articleId = $title->getArticleID();
		$shouldNoIndex = self::shouldIndex();
		$metaDataService = new LiftigniterMetadataService();
		$metaDataFromService = $metaDataService->getLiMetadataForArticle( $wgCityId, $articleId );
		$metaData['language'] = $wgLanguageCode;

		if ( !empty( $metaDataFromService ) ) {
			$metaData['guaranteed_impression'] = $metaDataFromService->getGuaranteedNumber();
			$metaData['start_date'] = $metaDataFromService->getDateFrom()->format( 'Y-m-d H:i:s' );
			$metaData['end_date'] = $metaDataFromService->getDateTo()->format( 'Y-m-d H:i:s' );
			if ( !empty( $metaDataFromService->getGeos() ) ) {
				$metaData['geolocation'] = $metaDataFromService->getGeos();
			}
		}

		if ( $shouldNoIndex ) {
			$metaData['noIndex'] = 'true';
		}

		if ( !empty( $wgEnableArticleFeaturedVideo ) &&
			ArticleVideoContext::isFeaturedVideoEmbedded( $title->getPrefixedDBkey() )
		) {
			$metaData['type'] = 'video';
		}

		return $metaData;
	}

	private static function checkIfIsProduction() {
		global $wgDevelEnvironment, $wgStagingEnvironment, $wgWikiaEnvironment;

		return empty( $wgDevelEnvironment ) &&
			empty( $wgStagingEnvironment ) &&
			$wgWikiaEnvironment !== WIKIA_ENV_STAGING;
	}

	private static function shouldIndex() {
		global $wgCityId, $wgIsPrivateWiki;
		$context = RequestContext::getMain();
		$title = $context->getTitle();
		$isProduction = self::checkIfIsProduction();
		$isPrivateWiki = WikiFactory::isWikiPrivate( $wgCityId ) || $wgIsPrivateWiki;

		return !$isProduction ||
			$isPrivateWiki ||
			$title->inNamespace( NS_FILE ) ||
			( $title->inNamespace( NS_BLOG_ARTICLE ) && empty( $metaDataFromService ) );
	}
}

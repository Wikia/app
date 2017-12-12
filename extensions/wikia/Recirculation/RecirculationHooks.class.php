<?php

use \Swagger\Client\Liftigniter\Metadata\Models\Item;
/**
 * Class RecirculationHooks
 */
class RecirculationHooks {

	const DATE_FORMAT = 'Y-m-d H:i:s';

	/**
	 * @param OutputPage $out
	 * @param Skin $skin
	 *
	 * @return bool
	 */
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
	public static function isCorrectPageType() {
		$wg = F::app()->wg;
		$title = RequestContext::getMain()->getTitle();
		$showableNamespaces = array_merge( $wg->ContentNamespaces, self::getNoIndexNamespaces() );
		$isInShowableNamespaces = $title->exists() && $title->inNamespaces( $showableNamespaces );

		return $isInShowableNamespaces &&
			!WikiaPageType::isActionPage() &&
			!WikiaPageType::isCorporatePage();
	}

	/**
	 * @param $cityId
	 * @param bool $ignoreWgEnableRecirculationDiscussions
	 *
	 * @return bool
	 */
	public static function canShowDiscussions( $cityId, $ignoreWgEnableRecirculationDiscussions = false ) {
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

	/**
	 * @param OutputPage $outputPage
	 */
	private static function addLiftIgniterMetadata( OutputPage $outputPage ) {
		$metaData = self::getMetaData();
		$metaDataJson = json_encode( $metaData );

		$outputPage->addScript(
			"<script id=\"liftigniter-metadata\" type=\"application/json\">${metaDataJson}</script>"
		);
	}

	/**
	 * @param String $cityId
	 * @param String $articleId
	 * @return null|Item
	 */
	private static function getMetaDataForArticle( String $cityId, String $articleId ) {
		$metaDataFromService = WikiaDataAccess::cache(
			'liftigniter-metadata',
			WikiaResponse::CACHE_SHORT,
			function () {
				$metaDataService = new LiftigniterMetadataService();

				return $metaDataService->getLiMetadata();
			}
		);

		if ( is_array( $metaDataFromService ) ) {
			return current( array_filter( $metaDataFromService, function ( Item $item ) use ( $cityId, $articleId ) {
				if ( $item->getProduct() === $cityId && $item->getId() === $articleId ) {
					return $item;
				}

				return null;
			} ) );
		} else {
			return null;
		}
	}

	/**
	 * @return array
	 */
	private static function getMetaData() {
		global $wgLanguageCode, $wgCityId, $wgEnableArticleFeaturedVideo;

		$title = RequestContext::getMain()->getTitle();
		$articleId = $title->getArticleID();

		$metaDataFromService = self::getMetaDataForArticle( $wgCityId, $articleId );
		$shouldNoIndex = self::shouldNoIndex( $metaDataFromService );
		$metaData = [];
		$metaData['language'] = $wgLanguageCode;

		if ( !empty( $metaDataFromService ) ) {
			$metaData['guaranteed_impression'] = $metaDataFromService->getGuaranteedNumber();
			$metaData['start_date'] = $metaDataFromService->getDateFrom()->format( self::DATE_FORMAT );
			$metaData['end_date'] = $metaDataFromService->getDateTo()->format( self::DATE_FORMAT );
			if ( !empty( $metaDataFromService->getGeos() ) ) {
				$metaData['geolocation'] = $metaDataFromService->getGeos();
			}
		}

		if ( $shouldNoIndex ) {
			$metaData['noIndex'] = 'true';
		}

		if ( !empty( $wgEnableArticleFeaturedVideo ) &&
			ArticleVideoContext::isFeaturedVideoEmbedded( $title->getArticleID() )
		) {
			$metaData['type'] = 'video';
		}

		return $metaData;
	}

	/**
	 * @return bool
	 */
	private static function isProduction() {
		global $wgDevelEnvironment, $wgStagingEnvironment, $wgWikiaEnvironment;

		return empty( $wgDevelEnvironment ) &&
			empty( $wgStagingEnvironment ) &&
			$wgWikiaEnvironment !== WIKIA_ENV_STAGING;
	}

	/**
	 * @param Item $metaDataFromService is actual Data returned by Liftigniter Metadata Service
	 *
	 * @return bool
	 */
	private static function shouldNoIndex( $metaDataFromService ) {
		global $wgDisableShowInRecirculation;

		return self::isPrivateOrNotProduction() ||
			( ( self::isNoIndexNamespace() || $wgDisableShowInRecirculation ) &&
				empty( $metaDataFromService ) ) ||
			RequestContext::getMain()->getRequest()->getVal( 'redirect' ) === 'no';
	}

	/**
	 * @return bool
	 */
	private static function isPrivateOrNotProduction() {
		global $wgCityId, $wgIsPrivateWiki;

		$isPrivateWiki = WikiFactory::isWikiPrivate( $wgCityId ) || $wgIsPrivateWiki;

		return !self::isProduction() || $isPrivateWiki;
	}

	/**
	 * @return bool
	 */
	private static function isNoIndexNamespace() {
		return RequestContext::getMain()->getTitle()->inNamespaces( self::getNoIndexNamespaces() );
	}

	/**
	 * @return array
	 */
	private static function getNoIndexNamespaces() {
		$noIndexNamespaces = [ NS_FILE ];
		if ( defined( 'NS_BLOG_ARTICLE' ) ) {
			$noIndexNamespaces[] = NS_BLOG_ARTICLE;
		}

		return $noIndexNamespaces;
	}

}

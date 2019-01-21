<?php

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
		if ( static::isCorrectPageType() ) {
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
	 * @return array
	 */
	private static function getNoIndexNamespaces() {
		$noIndexNamespaces = [ NS_FILE ];
		if ( defined( 'NS_BLOG_ARTICLE' ) ) {
			$noIndexNamespaces[] = NS_BLOG_ARTICLE;
		}

		return $noIndexNamespaces;
	}

	public static function onGetRailModuleList( array &$railModuleList ) {
		$railModuleList[1000] = [ 'RailContentService', 'renderRailModule', null ];
	}
}

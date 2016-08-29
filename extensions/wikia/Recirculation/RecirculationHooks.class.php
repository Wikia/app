<?php

/**
 * Class RecirculationHooks
 */
class RecirculationHooks {

	/**
	 * Insert Recirculation to the right rail
	 * @param array $modules
	 * @return bool
	 */
	static public function onGetRailModuleList( &$modules ) {
		wfProfileIn( __METHOD__ );

		// Check if we're on a page where we want to show a recirculation module.
		// If we're not, stop right here.
		if ( !static::isCorrectPageType() ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		// Use a different position depending on whether the user is logged in
		// This is based off of the logic from the VideosModule extension
		$app = F::App();
		$pos = $app->wg->User->isAnon() ? 1305 : 1285;

		$modules[$pos] = array( 'Recirculation', 'container', ['containerId' => 'RECIRCULATION_RAIL'] );

		wfProfileOut( __METHOD__ );

		return true;
	}

	public static function onBeforePageDisplay() {
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
		global $wgCityId;

		if ( static::isCorrectPageType() ) {
			$jsAssets[] = 'recirculation_js';

			if ( static::canShowDiscussions( $wgCityId ) ) {
				$jsAssets[] = 'recirculation_discussions_js';
			}
		}

		return true;
	}

	/**
	 * Return whether we're on one of the pages where we want to show the Recirculation widgets,
	 * specifically File pages, Article pages, and Main pages
	 * @return bool
	 */
	static public function isCorrectPageType() {
		$wg = F::app()->wg;

		$showableNameSpaces = array_merge( $wg->ContentNamespaces, [ NS_FILE ] );

		if ( $wg->Title->exists()
			&& in_array( $wg->Title->getNamespace(), $showableNameSpaces )
			&& $wg->request->getVal( 'action', 'view' ) === 'view'
			&& $wg->request->getVal( 'diff' ) === null
		) {
			return true;
		} else {
			return false;
		}
	}

	static public function canShowDiscussions( $cityId ) {
		$discussionsAlias = WikiFactory::getVarValueByName( 'wgRecirculationDiscussionsAlias', $cityId );

		if ( !empty( $discussionsAlias ) ) {
			$cityId = $discussionsAlias;
		}

		$discussionsEnabled = WikiFactory::getVarValueByName( 'wgEnableDiscussions', $cityId );
		$recirculationDiscussionsEnabled = WikiFactory::getVarValueByName( 'wgEnableRecirculationDiscussions', $cityId );

		if ( !empty( $discussionsEnabled ) && !empty( $recirculationDiscussionsEnabled ) ) {
			return true;
		} else {
			return false;
		}		
	}
}

<?php

class GoogleAmpHelper {

	/**
	 * Checks whether a title is a CMP.
	 * @param Title $title
	 * @return bool
	 */
	static private function isCuratedMainPage( Title $title ) : bool {
		global $wgCityId;

		return $title->isMainPage() && ( new CommunityDataService( $wgCityId ) )->hasData();
	}

	/**
	 * Checks whether AMP version is enabled for a given title.
	 *
	 * @param Title $title
	 * @return bool
	 */
	static public function isAmpEnabled( Title $title ): bool {
		global $wgGoogleAmpNamespaces, $wgGoogleAmpArticleBlacklist;

		if ( $title->exists() &&
			in_array( $title->getNamespace(), $wgGoogleAmpNamespaces ) &&
			!in_array( $title->getPrefixedDBkey(), $wgGoogleAmpArticleBlacklist ) &&
			!self::isCuratedMainPage( $title ) ) {
				return true;
		}
		return false;
	}

	/**
	 * If Amp is enabled for a given title, return Amp article address.
	 *
	 * @param Title $title
	 * @return string|null
	 */
	static public function getAmpAddress( Title $title ) {
		global $wgServer, $wgGoogleAmpAddress;

		if ( !self::isAmpEnabled( $title ) ) {
			return null;
		}

		$wikiServer = WikiFactory::getLocalEnvURL( $wgServer, WIKIA_ENV_PROD );
		$serverRegex = '/^https?:\/\/(.+)\.wikia\.com/';
		if ( preg_match( $serverRegex, $wikiServer, $groups ) !== 1 ) {
			return null;
		}
		$wikiServer = rawurlencode( $groups[1] );
		$article = rawurlencode( $title->getPrefixedDBkey() );

		return str_replace( '{WIKI}', $wikiServer, str_replace( '{ARTICLE}', $article, $wgGoogleAmpAddress ) );
	}

	/**
	 * Adds Amp article data
	 *
	 * @param Title $title
	 * @param $data Mercury article data to be returned
	 * @return bool
	 */
	static public function onMercuryPageData( Title $title, &$data ): bool {
		$ampAddress = self::getAmpAddress( $title );
		if ( $ampAddress ) {
			$data['amphtml'] = $ampAddress;
		}
		return true;
	}

	/**
	 * Add Amp rel link to page header.
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return bool
	 */
	static public function onBeforePageDisplay( OutputPage $out, Skin $skin ): bool {
		$title = $out->getTitle();
		if ( $title ) {
			$ampArticle = self::getAmpAddress( $title );
			if ( $ampArticle ) {
				$out->addLink( [
					'rel' => 'amphtml',
					'href' => $ampArticle
				] );
			}
		}
		return true;
	}
}

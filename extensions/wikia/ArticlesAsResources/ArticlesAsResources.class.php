<?php

/**
 * ResourceLoader enhancement that allows combining
 * content of articles from local and external wikis.
 *
 * @author Sean Colombo
 * @author Wladyslaw Bodzek
 */
class ArticlesAsResources {

	// Cached (hard-coded) IDs of popular wikis
	// (may be we should not do it)
	const COMMUNITY_WIKI_ID = 177;
	const DEV_WIKI_ID = 7931;

	// Domain suffix that is used as a fallback when finding wiki
	// by its domain name
	const WIKIA_DEFAULT_DOMAIN_SUFFIX = '.wikia.com';

	/**
	 * Transforms value from GET only= into corresponding
	 * ResourceLoaderWikiModule type= value.
	 *
	 * Basically it's just stripping the last "s" from the input
	 * for "scripts" and "styles".
	 *
	 * @param $type string
	 * @return bool|string
	 */
	static protected function getTypeByOnly( $type ) {
		switch ( $type ) {
			case 'scripts': // from only=scripts
				return 'script'; // type=script
			case 'styles': // only=styles
				return 'style'; // type=style
		}
		return false;
	}

	/**
	 * Get wiki ID by its db name
	 *
	 * @param $dbName string Database name
	 * @return int Wiki ID (or null)
	 */
	static protected function getCityIdByDbName( $dbName ) {
		wfProfileIn(__METHOD__);
		$id = null;
		if ( $dbName === 'c' ) {
			$id = self::COMMUNITY_WIKI_ID;
		}
		if ( $id === null ) {
			$id = WikiFactory::DBtoID($dbName);
		}
		wfProfileOut(__METHOD__);
		return $id;
	}

	/**
	 * Get wiki ID by its url. Handles both "dev.wikia.com" and "dev"
	 * (in the second pass it appends ".wikia.com" at the end of the supplied value).
	 *
	 * @param $url string
	 * @return int Wiki ID (or null)
	 */
	static protected function getCityIdByUrl( $url ) {
		wfProfileIn(__METHOD__);
		$id = null;
		if ( $url === 'dev' ) {
			$id = self::DEV_WIKI_ID;
		}
		if ( $id === null ) {
			$id = WikiFactory::DomainToID($url);
		}
		if ( $id === null ) {
			$id = WikiFactory::DomainToID($url . self::WIKIA_DEFAULT_DOMAIN_SUFFIX );
		}
		wfProfileOut(__METHOD__);
		return $id;
	}

	/**
	 * Parse user-supplied list of articles in various formats
	 * to the other one that is understood by ResourceLoaderCustomWikiModule.
	 *
	 * Supported formats are:
	 * - (l|local):<page> - page from local wiki
	 * - (w|remote|external):<dbname>:<page> - search by wiki dbname
	 * - (u|url):<url_or_its_part>:<page> - search by wiki exact url or that one suffixed by ".wikia.com"
	 * - <page> - page from local wiki
	 *
	 * Output format is:
	 * - local wiki: array( 'title' => '<page>', 'originalName' => '<input>' )
	 * - other wiki: array( 'cityId' => <numeric_id>, 'title' => '<page>', 'originalName' => '<input>' )
	 *
	 * @param $list array
	 * @return array
	 */
	static protected function parseArticleNames( $list ) {
		wfProfileIn(__METHOD__);
		$articles = array();
		foreach ($list as $k => $name) {
			$matches = array();
			if (preg_match('/^(?:l|local):(.*)$/', $name, $matches)) {
				$articles[] = array(
					'originalName' => $name,
					'title' => $matches[1],
				);
			} elseif (preg_match('/^(?:w|remote|external):(c:)?([^:]+):(.*)$/', $name, $matches)) {
				$cityId = null;

				// Special case for "w:c:" interwiki style links (BugId:45853)
				if ( $matches[1] ) {
					$cityId = self::getCityIdByUrl( $matches[2] );
				}

				// Fall back to dbName lookup
				if ( $cityId === null ) {
					$cityId = self::getCityIdByDbName( $matches[2] );
				}

				$articles[] = array(
					'originalName' => $name,
					'cityId' => $cityId,
					'title' => $matches[3],
				);
			} elseif (preg_match('/^(?:u|url):([^:]+):(.*)$/', $name, $matches)) {
				$articles[] = array(
					'originalName' => $name,
					'cityId' => self::getCityIdByUrl( $matches[1] ),
					'title' => $matches[2],
				);
			} else {
				$articles[] = array(
					'originalName' => $name,
					'title' => $name,
				);
			}
		}
		wfProfileOut(__METHOD__);
		return $articles;
	}

	/**
	 * Hook handler.
	 *
	 * If mode equals 'articles' in the request, bootstraps fake module and reinitialize
	 * ResourceLoaderContext object to include the just-defined fake module.
	 *
	 * @param $resourceLoader ResourceLoader
	 * @param $context ResourceLoaderContext
	 * @return bool
	 */
	static public function onResourceLoaderBeforeRespond( $resourceLoader, ResourceLoaderContext &$context ) {
		wfProfileIn(__METHOD__);
		/* @var $request WebRequest */
		$request = $context->getRequest();
		if ( $request->getVal( 'mode' ) !== 'articles' ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$only = $context->getOnly();
		$type = self::getTypeByOnly($only);
		if ( empty( $type ) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$articles = $request->getVal('articles');
		$articles = explode('|',$articles);
		if ( empty( $articles ) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		// prepare fake ResourceLoader module metadata
		$moduleName = md5( serialize( array( $articles, $only, $context->getHash() ) ) );
		$moduleFullName = 'wikia.fake.articles.' . $moduleName;
		$moduleInfo = array(
			'class' => 'ResourceLoaderCustomWikiModule',
			'articles' => self::parseArticleNames( $articles ),
			'type' => $type,
		);

		// register new fake module
		$resourceLoader->register($moduleFullName,$moduleInfo);

		// reinitialize ResourceLoader context
		$request->setVal('modules',$moduleFullName);
		$context = new ResourceLoaderContext( $resourceLoader, $request );
		wfProfileOut(__METHOD__);
		return true;
	}
}

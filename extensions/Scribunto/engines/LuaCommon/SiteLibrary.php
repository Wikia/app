<?php

class Scribunto_LuaSiteLibrary extends Scribunto_LuaLibraryBase {
	private static $siteStatsLoaded = false;
	private static $namespacesCache = null;
	private $pagesInCategoryCache = array();

	function register() {
		global $wgContLang, $wgNamespaceAliases, $wgNonincludableNamespaces;

		$lib = array(
			'loadSiteStats' => array( $this, 'loadSiteStats' ),
			'getNsIndex' => array( $this, 'getNsIndex' ),
			'pagesInCategory' => array( $this, 'pagesInCategory' ),
			'pagesInNamespace' => array( $this, 'pagesInNamespace' ),
			'usersInGroup' => array( $this, 'usersInGroup' ),
		);
		$info = array(
			'siteName' => $GLOBALS['wgSitename'],
			'server' => $GLOBALS['wgServer'],
			'scriptPath' => $GLOBALS['wgScriptPath'],
			'stylePath' => $GLOBALS['wgStylePath'],
			'currentVersion' => SpecialVersion::getVersion(),
		);

		if ( !self::$namespacesCache ) {
			$namespaces = array();
			$namespacesByName = array();
			foreach ( $wgContLang->getFormattedNamespaces() as $ns => $title ) {
				$canonical = MWNamespace::getCanonicalName( $ns );
				$namespaces[$ns] = array(
					'id' => $ns,
					'name' => $title,
					'canonicalName' => strtr( $canonical, '_', ' ' ),
					'hasSubpages' => MWNamespace::hasSubpages( $ns ),
					'hasGenderDistinction' => MWNamespace::hasGenderDistinction( $ns ),
					'isCapitalized' => MWNamespace::isCapitalized( $ns ),
					'isContent' => MWNamespace::isContent( $ns ),
					'isIncludable' => !( $wgNonincludableNamespaces && in_array( $ns, $wgNonincludableNamespaces ) ), // Wikia change - MWNamespace::isNonincludable is not supported in MW 1.19
					'isMovable' => MWNamespace::isMovable( $ns ),
					'isSubject' => MWNamespace::isSubject( $ns ),
					'isTalk' => MWNamespace::isTalk( $ns ),
					'aliases' => array(),
				);
				if ( $ns >= NS_MAIN ) {
					$namespaces[$ns]['subject'] = MWNamespace::getSubject( $ns );
					$namespaces[$ns]['talk'] = MWNamespace::getTalk( $ns );
					$namespaces[$ns]['associated'] = MWNamespace::getAssociated( $ns );
				} else {
					$namespaces[$ns]['subject'] = $ns;
				}
				$namespacesByName[strtr( $title, ' ', '_' )] = $ns;
				if ( $canonical ) {
					$namespacesByName[$canonical] = $ns;
				}
			}

			$aliases = array_merge( $wgNamespaceAliases, $wgContLang->getNamespaceAliases() );
			foreach ( $aliases as $title => $ns ) {
				if ( !isset( $namespacesByName[$title] ) && isset( $namespaces[$ns] ) ) {
					$ct = count( $namespaces[$ns]['aliases'] );
					$namespaces[$ns]['aliases'][$ct+1] = $title;
					$namespacesByName[$title] = $ns;
				}
			}

			$namespaces[NS_MAIN]['displayName'] = wfMessage( 'blanknamespace' )->text();

			self::$namespacesCache = $namespaces;
		}
		$info['namespaces'] = self::$namespacesCache;

		if ( self::$siteStatsLoaded ) {
			$stats = $this->loadSiteStats();
			$info['stats'] = $stats[0];
		}

		$this->getEngine()->registerInterface( 'mw.site.lua', $lib, $info );
	}

	public function loadSiteStats() {
		global $wgDisableCounters;

		self::$siteStatsLoaded = true;
		return array( array(
			'pages' => (int)SiteStats::pages(),
			'articles' => (int)SiteStats::articles(),
			'files' => (int)SiteStats::images(),
			'edits' => (int)SiteStats::edits(),
			'views' => $wgDisableCounters ? null : (int)SiteStats::views(),
			'users' => (int)SiteStats::users(),
			'activeUsers' => (int)SiteStats::activeUsers(),
		) );
	}

	public function pagesInCategory( $category = null, $which = null ) {
		$this->checkType( 'pagesInCategory', 1, $category, 'string' );
		$this->checkTypeOptional( 'pagesInCategory', 2, $which, 'string', 'all' );

		$title = Title::makeTitleSafe( NS_CATEGORY, $category );
		if ( !$title ) {
			return array( 0 );
		}
		$cacheKey = $title->getDBkey();

		if ( !isset( $this->pagesInCategoryCache[$cacheKey] ) ) {
			$this->incrementExpensiveFunctionCount();
			$category = Category::newFromTitle( $title );
			$counts = array(
				'all' => (int)$category->getPageCount(),
				'subcats' => (int)$category->getSubcatCount(),
				'files' => (int)$category->getFileCount(),
			);
			$counts['pages'] = $counts['all'] - $counts['subcats'] - $counts['files'];
			$this->pagesInCategoryCache[$cacheKey] = $counts;
		}
		if ( $which === '*' ) {
			return array( $this->pagesInCategoryCache[$cacheKey] );
		}
		if ( !isset( $this->pagesInCategoryCache[$cacheKey][$which] ) ) {
			$this->checkType( 'pagesInCategory', 2, $which, "one of '*', 'all', 'pages', 'subcats', or 'files'" );
		}
		return array( $this->pagesInCategoryCache[$cacheKey][$which] );
	}

	public function pagesInNamespace( $ns = null ) {
		$this->checkType( 'pagesInNamespace', 1, $ns, 'number' );
		return array( (int)SiteStats::pagesInNs( intval( $ns ) ) );
	}

	public function usersInGroup( $group = null ) {
		$this->checkType( 'usersInGroup', 1, $group, 'string' );
		return array( (int)SiteStats::numberingroup( strtolower( $group ) ) );
	}

	public function getNsIndex( $name = null ) {
		global $wgContLang;
		$this->checkType( 'getNsIndex', 1, $name, 'string' );
		return array( $wgContLang->getNsIndex( $name ) );
	}
}

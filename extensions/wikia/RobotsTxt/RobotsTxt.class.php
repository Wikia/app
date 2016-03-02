<?php

class RobotsTxt {
	const CACHE_PERIOD_REGULAR = 24 * 3600;
	const CACHE_PERIOD_EXPERIMENTAL = 3600;

	private $allowed = [];
	private $blockedRobots = [];
	private $disallowed = [];
	private $sitemap;
	private $experimentalAllowDisallowSection = null;

	public function __construct() {
		$this->englishLang = new Language();
		$this->specialNamespaces = $this->getNamespaces( NS_SPECIAL );
	}

	/**
	 * Allow a special page to be crawled
	 *
	 * Allows crawling a page when accessed using /wiki/Special:XXX URL
	 * and the localized variants of the URL.
	 *
	 * @param string $pageName name of the special page as exposed in alias file for the special page
	 */
	public function allowSpecialPage( $pageName ) {
		foreach ( $this->specialNamespaces as $specialNamespaceAlias ) {
			foreach ( $this->getSpecialPageNames( $pageName ) as $localPageName ) {
				$this->allowed[] = $this->buildUrl( $specialNamespaceAlias, $localPageName );
			}
		}
	}

	/**
	 * Disallow a specific robot to crawl all the pages
	 *
	 * @param string $robot User-agent (fragment) of the robot
	 */
	public function blockRobot( $robot ) {
		$this->blockedRobots[] = $robot;
	}

	/**
	 * Disallow given namespace
	 *
	 * It emits both the Disallow and Noindex directive
	 *
	 * If you block NS_SPECIAL, you can still allow specific special pages by allowSpecialPage
	 *
	 * Multiple ways of accessing the special pages are blocked:
	 *
	 *  * /wiki/Namespace:XXX
	 *  * /index.php?title=Namespace:XXX
	 *  * /index.php/Namespace:XXX
	 *  * all above in the wiki content language
	 *
	 * @param int $namespaceId namespace to block
	 */
	public function disallowNamespace( $namespaceId ) {
		foreach ( $this->getNamespaces( $namespaceId ) as $namespace ) {
			$this->disallowed[] = $this->buildUrl( $namespace );
			$this->disallowed[] = '/*?*title=' . $namespace . ':';
			$this->disallowed[] = '/index.php/' . $namespace . ':';
		}
	}

	/**
	 * Disallow crawling pages with a given query param
	 *
	 * This will only block robots that understand wildcards.
	 * The param is matched loosely, so ABCsomeparam is blocked as well when you block someparam
	 *
	 * @param string $param URL param to block
	 */
	public function disallowParam( $param ) {
		$this->disallowed[] = '/*?*' . $param . '=';
	}

	/**
	 * Disallow a specific path
	 *
	 * It emits both the Disallow and Noindex directive
	 *
	 * @param string $path path prefix to block (some robots accept wildcards)
	 */
	public function disallowPath( $path ) {
		$this->disallowed[] = $path;
	}

	/**
	 * Get robots.txt contents as array of lines
	 *
	 * @return array
	 */
	public function getContents() {
		if ( $this->experimentalAllowDisallowSection ) {
			return array_merge(
				explode( PHP_EOL, trim( $this->experimentalAllowDisallowSection ) ),
				[ '' ],
				$this->getSitemapSection()
			);
		}

		return array_merge(
			$this->getBlockedRobotsSection(),
			$this->getAllowDisallowSection(),
			$this->getSitemapSection()
		);
	}

	/**
	 * Get headers to set
	 *
	 * @return array
	 */
	public function getHeaders() {
		if ( $this->experimentalAllowDisallowSection ) {
			$cachePeriod = self::CACHE_PERIOD_EXPERIMENTAL;
		} else {
			$cachePeriod = self::CACHE_PERIOD_REGULAR;
		}

		return [
			'Content-Type: text/plain',
			'Cache-Control: s-maxage=' . $cachePeriod,
			'X-Pass-Cache-Control: public, max-age=' . $cachePeriod,
		];
	}

	/**
	 * Set experimental contents for robots.txt
	 *
	 * This overrides all allow*, disallow* and block* calls.
	 * This affects the cache TTL.
	 * This has no effect on the sitemap line.
	 *
	 * @param string $content content for robots.txt (excluding the sitemap rule)
	 */
	public function setExperimentalAllowDisallowSection( $content ) {
		$this->experimentalAllowDisallowSection = $content;
	}

	/**
	 * Set Sitemap URL
	 *
	 * @param string $sitemapUrl
	 */
	public function setSitemap( $sitemapUrl ) {
		$this->sitemap = $sitemapUrl;
	}

	// Private methods follow:

	private function buildUrl( $specialNamespace, $localPageName = '' ) {
		global $wgArticlePath;
		return str_replace( '$1', $specialNamespace . ':' . $localPageName, $wgArticlePath );
	}

	private function encodeUri( $in ) {
		return str_replace(
			[ '%2F', '%3A', '%2A', '%3F', '%3D', '%24' ],
			[ '/', ':', '*', '?', '=', '$' ],
			rawurlencode( $in )
		);
	}

	private function getAllowDisallowSection() {

		$allowSection = array_map(
			function ( $prefix ) {
				return 'Allow: ' . $this->encodeUri( $prefix );
			},
			$this->allowed
		);

		$disallowSection = array_map(
			function ( $prefix ) {
				return 'Disallow: ' . $this->encodeUri( $prefix );
			},
			$this->disallowed
		);

		$noIndexSection = array_map(
			function ( $prefix ) {
				return 'Noindex: ' . $this->encodeUri( $prefix );
			},
			$this->disallowed
		);

		if ( count( $allowSection ) || count( $disallowSection ) ) {
			return array_merge(
				[ 'User-agent: *' ],
				$allowSection,
				$disallowSection,
				$noIndexSection,
				[ '' ]
			);
		}

		return [];
	}

	private function getBlockedRobotsSection() {
		$r = [];
		foreach ( $this->blockedRobots as $robot ) {
			$r[] = 'User-agent: ' . $robot;
			$r[] = 'Disallow: /';
			$r[] = '';
		}
		return $r;
	}

	private function getSitemapSection() {
		if ( $this->sitemap ) {
			return [ 'Sitemap: ' . $this->encodeUri( $this->sitemap ) ];
		}
		return [];
	}

	/**
	 * Get the special page's aliases
	 *
	 * @param $pageName special page name as specified in the SpecialPage object
	 * @return array
	 */
	private function getSpecialPageNames( $pageName ) {
		global $wgContLang;
		$aliases = $wgContLang->getSpecialPageAliases()[$pageName];
		if ( empty( $aliases ) ) {
			$aliases = [];
		}
		return $aliases;
	}

	/**
	 * Get the namespace's English and translated name
	 *
	 * @param $namespaceId
	 * @return array
	 */
	private function getNamespaces( $namespaceId ) {
		global $wgContLang;
		return array_unique( [
			$wgContLang->getNamespaces()[$namespaceId],
			$this->englishLang->getNamespaces()[$namespaceId],
		] );
	}
}

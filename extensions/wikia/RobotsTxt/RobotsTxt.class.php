<?php

class RobotsTxt {

	//// Caching for 1 hour in case this does a lot of damage and we need to revert quickly
	//// In the long run, we can for longer, much longer
	const CACHE_PERIOD = 3600;

	private $allowed = [];
	private $blockedRobots = [];
	private $disallowed = [];
	private $sitemap;

	public function __construct() {
		global $wgContLang;

		$this->englishLang = new Language();
		$this->specialNamespaces = array_unique( [
			$wgContLang->getNamespaces()[NS_SPECIAL],
			$this->englishLang->getNamespaces()[NS_SPECIAL],
		] );
	}

	/**
	 * Allow a special page to be crawled
	 *
	 * Allows crawling a page when accessed using /wiki/Special:XXX URL
	 * and the localized variants of the URL.
	 *
	 * @param $pageName string name of the special page as exposed in alias file for the special page
	 */
	public function allowSpecialPage( $pageName ) {
		foreach ( $this->specialNamespaces as $specialNamespace ) {
			foreach ( $this->getSpecialPageNames( $pageName ) as $localPageName ) {
				$this->allowed[] = $this->buildUrl( $specialNamespace, $localPageName );
			}
		}
	}

	/**
	 * Disallow a specific robot to crawl all the pages
	 *
	 * @param $robot string User-agent (fragment) of the robot
	 */
	public function blockRobot( $robot ) {
		$this->blockedRobots[] = $robot;
	}

	/**
	 * Disallow crawling pages with a given query param
	 *
	 * This will only block robots that understand wildcards.
	 * The param is matched loosely, so ABCsomeparam is blocked as well when you block someparam
	 *
	 * @param $param param to block
	 */
	public function disallowParam( $param ) {
		$this->disallowed[] = '/*?*' . $param . '=';
	}

	/**
	 * Disallow a specific path
	 *
	 * @param $path the path prefix to block (some robots accept wildcards)
	 */
	public function disallowPath( $path ) {
		$this->disallowed[] = $path;
	}

	/**
	 * Disallow all special pages (use allowSpecialPage to whitelist some)
	 *
	 * Multiple ways of accessing the special pages are blocked:
	 *
	 *  * /wiki/Special:XXX
	 *  * /index.php?title=Special:XXX
	 *  * /index.php/Special:XXX
	 *  * all above in the wiki content language
	 */
	public function disallowSpecialPages() {
		foreach ( $this->specialNamespaces as $namespace ) {
			$this->disallowed[] = $this->buildUrl( $namespace );
			$this->disallowed[] = '/*?*title=' . $namespace . ':';
			$this->disallowed[] = '/index.php/' . $namespace . ':';
		}
	}

	/**
	 * Get robots.txt contents as array of lines
	 *
	 * @return array
	 */
	public function getContents() {
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
		return [
			'Content-Type: text/plain',
			'Cache-Control: s-maxage=' . self::CACHE_PERIOD,
			'X-Pass-Cache-Control: public, max-age=3600' . self::CACHE_PERIOD,
		];
	}

	/**
	 * Set Sitemap URL
	 *
	 * @param $sitemapUrl
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
			['%2F', '%3A', '%2A', '%3F', '%3D', '%24'],
			['/', ':', '*', '?', '=', '$'],
			rawurlencode( $in )
		);
	}

	private function getAllowDisallowSection() {
		$allowSection = array_map(
			function ( $prefix ) {
				return 'Allow: ' . $this->encodeUri( $prefix );
			} ,
			$this->allowed
		);

		$disallowSection = array_map(
			function ( $prefix ) {
				return 'Disallow: ' . $this->encodeUri( $prefix );
			} ,
			$this->disallowed
		);

		if ( count( $allowSection ) || count( $disallowSection ) ) {
			return array_merge(
				['User-agent: *'],
				$allowSection,
				$disallowSection,
				['']
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
			return ['Sitemap: ' . $this->encodeUri( $this->sitemap )];
		}
		return [];
	}

	private function getSpecialPageNames( $pageName ) {
		global $wgContLang;
		$aliases = $wgContLang->getSpecialPageAliases()[ $pageName ];
		if ( empty( $aliases ) ) {
			$aliases = [];
		}
		return $aliases;
	}
}

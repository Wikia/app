<?php
namespace Wikia\RobotsTxt;

/**
 * Class Wikia\RobotsTxt\WikiaRobots
 *
 * This class reads the variables and decides which pages should be blocked and which be allowed
 * for robots. It can configure a Wikia\RobotsTxt\RobotsTxt instance to produce a robots.txt class. It can
 * also be used to produce the <meta robots> tags.
 */
class WikiaRobots {

	const CACHE_PERIOD_REGULAR = 24 * 3600;
	const CACHE_PERIOD_EXPERIMENTAL = 3600;
	const CACHE_PERIOD_DEGRADED = 3600;

	/**
	 * Whether robots are allowed to crawl any portion of the site
	 *
	 * @var bool
	 */
	private $accessAllowed;

	/**
	 * List of additional paths to allow (in addition to white-listed special pages below)
	 *
	 * @var array
	 */
	private $allowedPaths = [
		// SEO-302: Allow Googlebot to crawl Android app contents
		// @see http://developer.android.com/training/app-indexing/enabling-app-indexing.html)
		// The order of precedence between those two is undefined:
		// "Disallow: /*?*action=" and "Allow: /api.php"
		// @see https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt#order-of-precedence-for-group-member-records
		// That's why we're adding quite explicit "Allow: /api.php?*action=" (even though it's redundant)
		// robots.txt Tester in Google Search Console shows this will do:
		// @see https://www.google.com/webmasters/tools/robots-testing-tool?hl=en&siteUrl=http://muppet.wikia.com/
		'/api.php?',
		'/api.php?action=',
		'/api.php?*&action='
	];

	/**
	 * Special pages to allow (normally all special pages are blocked)
	 *
	 * The key is the special page, the value is one of:
	 *  * allow  -- puts an Allow line in robots.txt and index,follow robot strategy for <meta>
	 *  * follow -- puts an Allow line in robots.txt and noindex,follow robot strategy for <meta>
	 *
	 * @var array
	 */
	private $allowedSpecialPages = [
		'CreateNewWiki' => 'allow',
		'Forum' => 'allow',
		'Sitemap' => 'allow',
		'Videos' => 'allow',
	];

	/**
	 * Namespaces to disallow
	 *
	 * @var int[]
	 */
	private $blockedNamespaces = [
		NS_SPECIAL,
		NS_TEMPLATE,
		NS_TEMPLATE_TALK,
		NS_USER_TALK,
	];

	/**
	 * List of additional paths to block
	 *
	 * @var array
	 */
	private $blockedPaths = [
		// Discussions user pages
		'/d/u/',
		// Discussions guidelines
		'/d/g',
		// Feeds and posts user pages
		'/f/u/',
		// Feeds and posts guidelines
		'/f/g',
		// Fandom old URLs
		'/fandom?p=',
		//Mobile Wiki search URL
		'/search',
	];

	/**
	 * List of params to disallow
	 *
	 * @var string[]
	 */
	private $blockedParams = [
		'action',
		'feed',
		'from', // user-supplied legacy MW pagination
		'oldid',
		'printable',
		'redirect',
		'useskin',
		'uselang',
		'veaction',
	];

	/**
	 * Whether the current robots setup is experimental or not
	 * This switches the cache time from 24 hours to 1 hour
	 * @var bool
	 */
	private $experiment = false;

	/**
	 * Whether the current robots content is degraded because fetching rules from
	 * language wikis failed.
	 * @var bool
	 */
	private $degraded = false;

	/**
	 * The object used to construct paths
	 *
	 * @var PathBuilder
	 */
	private $pathBuilder;

	/**
	 * Wikia\RobotsTxt\WikiaRobots constructor.
	 *
	 * @param PathBuilder $pathBuilder
	 */
	public function __construct( PathBuilder $pathBuilder ) {
		global $wgRequest,
			   $wgRobotsTxtCustomRules,
			   $wgWikiaEnvironment;

		$this->pathBuilder = $pathBuilder;
		$this->accessAllowed = $wgWikiaEnvironment === WIKIA_ENV_PROD || $wgRequest->getBool( 'forcerobots' );
		$this->experiment = false;

		if ( isset( $wgRobotsTxtCustomRules['allowSpecialPage'] ) ) {
			foreach ( (array) $wgRobotsTxtCustomRules['allowSpecialPage'] as $page ) {
				$this->allowedSpecialPages[$page] = 'allow';
			}
		}
	}

	/**
	 * @param RobotsTxt $robots
	 * @return RobotsTxt
	 */
	public function configureRobotsBuilder( RobotsTxt $robots ) {
		global $wgEnableSitemapXmlExt,
			   $wgRobotsTxtBlockedWiki,
			   $wgSitemapXmlExposeInRobots,
			   $wgServer,
			   $wgScriptPath,
			   $wgRequest,
			   $wgCityId;

		if ( !$this->accessAllowed || !empty( $wgRobotsTxtBlockedWiki ) ) {
			// No crawling preview, verify, sandboxes, showcase, etc
			$robots->addDisallowedPaths( [ $this->pathBuilder->buildPath( '/' ) ] );
			return $robots;
		}

		if ( \Hooks::run( 'GenerateRobotsRules', [ $wgCityId ] ) ) {
			// Sitemap
			if ( !empty( $wgEnableSitemapXmlExt ) && !empty( $wgSitemapXmlExposeInRobots ) ) {
				$sitemapUrl = $wgServer . $wgScriptPath . '/sitemap-newsitemapxml-index.xml';
				$sitemapUrl = wfHttpToHttps( $sitemapUrl );
				$robots->addSitemap( $sitemapUrl );
			}

			// Allow specific paths
			$robots->addAllowedPaths( array_map( [ $this->pathBuilder, 'buildPath' ], $this->allowedPaths ) );

			// Allow special pages
			foreach ( array_keys( $this->allowedSpecialPages ) as $page ) {
				$robots->addAllowedPaths( $this->pathBuilder->buildPathsForSpecialPage( $page, true ) );
			}
		}

		return $robots;
	}
}

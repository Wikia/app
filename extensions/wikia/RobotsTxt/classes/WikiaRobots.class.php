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
	];

	/**
	 * List of additional paths to block
	 *
	 * @var array
	 */
	private $blockedPaths = [
		'/d/u/', // User pages for discussions
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
		global $wgAllowSpecialImagesInRobots,
			   $wgEnableLocalSitemap,
			   $wgRequest,
			   $wgRobotsTxtCustomRules,
			   $wgWikiaEnvironment;

		$this->pathBuilder = $pathBuilder;
		$this->accessAllowed = ( $wgWikiaEnvironment === WIKIA_ENV_PROD || $wgRequest->getBool( 'forcerobots' ) );
		$this->experiment = false;

		if ( isset( $wgRobotsTxtCustomRules['allowSpecialPage'] ) ) {
			foreach ( (array) $wgRobotsTxtCustomRules['allowSpecialPage'] as $page ) {
				$this->allowedSpecialPages[$page] = 'allow';
			}
		}

		if ( !empty( $wgEnableLocalSitemap ) ) {
			$this->allowedSpecialPages['Allpages'] = 'allow';
		}

		if ( !empty( $wgAllowSpecialImagesInRobots ) ) {
			$this->allowedSpecialPages['Images'] = 'allow';
		}

		// TODO: reverse the logic
		// Have $wgRobotsTxtCustomRules['allowNamespaces'] which removes them from
		// $this->namespacesToBlock
		if ( isset( $wgRobotsTxtCustomRules['disallowNamespace'] ) ) {
			$this->blockedNamespaces = array_merge(
				$this->blockedNamespaces,
				(array) $wgRobotsTxtCustomRules['disallowNamespace']
			);
		}
	}

	public function configureRobotsBuilder( RobotsTxt $robots ) {
		global $wgEnableSpecialSitemapExt, $wgRobotsTxtRemoveDeprecatedDirectives, $wgServer;


		if ( !$this->accessAllowed ) {
			// No crawling preview, verify, sandboxes, showcase, etc
			$robots->addDisallowedPaths( [ '/' ] );
			return $robots;
		}

		// Sitemap
		if ( !empty( $wgEnableSpecialSitemapExt ) ) {
			$robots->setSitemap( $wgServer . '/sitemap-index.xml' );
		}

		// Block namespaces
		foreach ( $this->blockedNamespaces as $ns ) {
			$robots->addDisallowedPaths(
				$this->pathBuilder->buildPathsForNamespace( $ns )
			);
		}

		// Block additional paths
		$robots->addDisallowedPaths( $this->blockedPaths );

		// Block params
		foreach ( $this->blockedParams as $param ) {
			$robots->addDisallowedPaths( $this->pathBuilder->buildPathsForParam( $param ) );
		}

		// Allow specific paths
		$robots->addAllowedPaths( $this->allowedPaths );

		// Allow special pages
		foreach ( array_keys( $this->allowedSpecialPages ) as $page ) {
			$robots->addAllowedPaths( $this->pathBuilder->buildPathsForSpecialPage( $page, true ) );
		}

		return $robots;
	}

	/**
	 * Get one of the possible robots policy to use in <meta> tags:
	 *
	 *  * index,follow (page is fully allowed to be crawled by robots)
	 *  * noindex,follow (only read the links, but don't save the page to their index)
	 *  * noindex,nofollow (don't read the page, don't put to index, don't follow any links)
	 *
	 * The title is checked to see if the namespace is blocked. For special pages the whitelist
	 * is checked for the specific page. The request is checked for any forbidden params.
	 *
	 * Also if we're in non-production environment, the function is gonna return noindex,nofollow.
	 *
	 * @param \Title $title - the title to generate the tag for (normally pass $wg\Title)
	 * @param \WebRequest $request - the request to generate the tag for (normally pas $wgRequest)
	 * @return string
	 */
	public function getMetaRobotsPolicy( \Title $title, \WebRequest $request ) {
		if ( !$this->accessAllowed ) {
			return 'noindex,nofollow';
		}

		// Check for blocked params
		if ( array_intersect( $this->blockedParams, $request->getValueNames() ) ) {
			return 'noindex,nofollow';
		}

		// Check namespace
		if ( !in_array( $title->getNamespace(), $this->blockedNamespaces ) ) {
			return 'index,follow';
		}

		// The namespace is blocked, checking the specific page

		if ( $title->isSpecialPage() ) {
			foreach ( $this->allowedSpecialPages as $allowedPage => $policy ) {
				if ( $title->isSpecial( $allowedPage ) ) {
					if ( $policy === 'follow' ) {
						return 'noindex,follow';
					}
					return 'index,follow';
				}
			}
		}

		// The namespace was blocked, the page was not specifically allowed

		return 'noindex,nofollow';
	}

	/**
	 * Get headers to set for robots.txt
	 *
	 * @return array
	 */
	public function getRobotsTxtCachePeriod() {
		if ( $this->experiment ) {
			return self::CACHE_PERIOD_EXPERIMENTAL;
		}
		return self::CACHE_PERIOD_REGULAR;
	}
}

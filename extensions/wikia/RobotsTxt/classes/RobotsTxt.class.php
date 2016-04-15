<?php

namespace Wikia\RobotsTxt;

class RobotsTxt {

	private $allowed = [];
	private $blockedRobots = [];
	private $disallowed = [];
	private $sitemap;

	/**
	 * Allow specific paths
	 *
	 * It emits the Allow directives
	 *
	 * @param string[] $paths path prefixes to allow (some robots accept wildcards)
	 */
	public function addAllowedPaths( array $paths ) {
		$this->allowed = array_merge( $this->allowed, $paths );
	}

	/**
	 * Disallow specific robots to crawl all the pages
	 *
	 * @param string[] $robots User-agent (fragment) of the robot (or an array of such)
	 */
	public function addBlockedRobots( array $robots ) {
		$this->blockedRobots = array_merge( $this->blockedRobots, $robots );
	}

	/**
	 * Disallow specific paths
	 *
	 * It emits both the Disallow and Noindex directive for each path
	 *
	 * @param string[] $paths path prefixes to block (some robots accept wildcards)
	 */
	public function addDisallowedPaths( array $paths ) {
		$this->disallowed = array_merge( $this->disallowed, $paths );
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
	 * Set Sitemap URL
	 *
	 * @param string $sitemapUrl
	 */
	public function setSitemap( $sitemapUrl ) {
		$this->sitemap = $sitemapUrl;
	}

	// Private methods follow:

	private function getAllowDisallowSection() {

		$allowSection = array_map(
			function ( $prefix ) {
				return 'Allow: ' . $prefix;
			},
			$this->allowed
		);

		$disallowSection = array_map(
			function ( $prefix ) {
				return 'Disallow: ' . $prefix;
			},
			$this->disallowed
		);

		$noIndexSection = array_map(
			function ( $prefix ) {
				return 'Noindex: ' . $prefix;
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
			return [ 'Sitemap: ' . $this->sitemap ];
		}
		return [];
	}
}

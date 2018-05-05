<?php

namespace Wikia\RobotsTxt;

class RobotsTxt {
	private $robots = [];
	private $sitemap;

	public function createRobot( $ua ) {
		return new Robot( $ua );
	}

	/**
	 * Create robot entry and add it to robots list
	 * 
	 * @param Robot $robot
	 * @return Robot
	 */
	public function addRobot ( $robot ) {
		$ua = $robot->getUserAgent();

		if ( isset( $this->robots[ $ua ] ) ) {
			throw new Exception( 'Robot with given user agent already exists.' );
		} else {
			return ( $this->robots[ $ua ] = $robot );
		}
	}

	/**
	 * Return robot with given User-agent (if exists)
	 * 
	 * @param string $ua User-agent
	 * @return Robot
	 */
	public function getRobot( $ua ) {
		return $this->robots[ $ua ] || null;
	}

	/**
	 * Get robots.txt contents as array of lines
	 *
	 * @return array
	 */
	public function getContents() {
		return array_merge(
			$this->getRobotsSection(),
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
	private function getRobotsSection() {
		$lines = [];

		foreach ( $this->robots as $robot ) {
			$lines = array_merge( $lines, $robot->getContent() );
		}

		return $lines;
	}

	private function getSitemapSection() {
		if ( $this->sitemap ) {
			return [ 'Sitemap: ' . $this->sitemap ];
		}
		return [];
	}
}

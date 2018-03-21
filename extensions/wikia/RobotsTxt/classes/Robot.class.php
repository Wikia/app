<?php

namespace Wikia\RobotsTxt;

class Robot {
	private $userAgent = null;
	private $allowed = [];
	private $disallowed = [];

	public function __construct( $ua = '*' ) {
		$this->userAgent = $ua;
	}

	/**
	 * Returns robot's user agent
	 * 
	 * @return string
	 */
	public function getUserAgent() {
		return $this->userAgent;
	}

	/**
	 * Set crawler User Agent
	 * 
	 * @param string $ua User-agent (fragment) of the robot (or an array of such)
	 */
	public function setUserAgent( $ua ) {
		$this->userAgent = $ua;
	}

	/**
	 * Allow specific paths
	 *
	 * It emits the Allow directives
	 *
	 * @param string[] $paths path prefixes to allow (some robots accept wildcards)
	 */
	public function allowPaths( array $paths ) {
		$this->allowed = array_merge( $this->allowed, $paths );
	}

	/**
	 * Disallow specific paths
	 *
	 * It emits both the Disallow and Noindex directive for each path
	 *
	 * @param string[] $paths path prefixes to block (some robots accept wildcards)
	 */
	public function disallowPaths( array $paths ) {
		$this->disallowed = array_merge( $this->disallowed, $paths );
	}

	/**
	 * Disallow specific robot to crawl all the pages
	 */
	public function block() {
		$this->allowed = [];
		$this->disallowed = [];
		$this->disallowPaths( [ '/' ] );
	}

	/**
	 * Get robots.txt contents as array of lines
	 *
	 * @return array
	 */
	public function getContent() {
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
			( empty( $this->disallowed ) && empty( $this->allowed ) ) ? [ '' ] : $this->disallowed
		);

		$noIndexSection = array_map(
			function ( $prefix ) {
				return 'Noindex: ' . $prefix;
			},
			( count( $this->disallowed ) === 1 && $this->disallowed[0] === '/' ) ? [] : $this->disallowed
		);

		if ( count( $allowSection ) || count( $disallowSection ) ) {
			return array_merge(
				[ 'User-agent: ' . $this->userAgent ],
				$allowSection,
				$noIndexSection,
				$disallowSection,
				[ '' ]
			);
		}

		return [];
	}
}

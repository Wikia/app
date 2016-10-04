<?php

class RobotsTxtMock extends \Wikia\RobotsTxt\RobotsTxt {
	public $spiedAllowedPaths = [];
	public $spiedDisallowedPaths = [];
	public $spiedSitemap = [];
	public $spiedBlockedRobots = [];

	public function addAllowedPaths( array $paths ) {
		$this->spiedAllowedPaths[] = $paths;
	}

	public function addDisallowedPaths( array $paths ) {
		$this->spiedDisallowedPaths[] = $paths;
	}

	public function addBlockedRobots( array $robots ) {
		$this->spiedBlockedRobots[] = $robots;
	}

	public function getContents() {
	}

	public function setSitemap( $sitemapUrl ) {
		$this->spiedSitemap[] = $sitemapUrl;
	}
}

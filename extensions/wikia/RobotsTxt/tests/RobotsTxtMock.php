<?php

class RobotsTxtMock extends \Wikia\RobotsTxt\RobotsTxt {
	public $spiedRobots = [];
	public $spiedSitemap = [];

	public function addRobot( $robot ) {
		$this->spiedRobots[ $robot->getUserAgent() ] = $robot;
	}

	public function getContents() {
	}

	public function setSitemap( $sitemapUrl ) {
		$this->spiedSitemap[] = $sitemapUrl;
	}

	public function createRobot( $ua ) {
		return new RobotMock( $ua );
	}
}

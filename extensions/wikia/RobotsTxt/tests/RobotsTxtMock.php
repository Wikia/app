<?php

class RobotsTxtMock extends \Wikia\RobotsTxt\RobotsTxt {
	public $spiedRobots = [];
	public $spiedSitemap = [];

	public function addRobot( Robot $robot ) {
		$this->$spiedRobots[] = $robot;
	}

	public function getContents() {
	}

	public function setSitemap( $sitemapUrl ) {
		$this->spiedSitemap[] = $sitemapUrl;
	}
}

<?php

use Wikia\RobotsTxt\PathBuilder;
use Wikia\RobotsTxt\RobotsTxt;
use Wikia\RobotsTxt\WikiaRobots;

class WikiaRobotsController extends WikiaController {

	public function getAllowedDisallowed() {
		$wikiaRobots = new WikiaRobots( new PathBuilder() );
		$robots = $wikiaRobots->configureRobotsBuilder( new RobotsTxt() );

		$this->response->setVal( 'allowed', $robots->getAllowedPaths() );
		$this->response->setVal( 'disallowed', $robots->getDisallowedPaths() );
		$this->response->setVal( 'sitemaps', $robots->getSitemaps() );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}
}

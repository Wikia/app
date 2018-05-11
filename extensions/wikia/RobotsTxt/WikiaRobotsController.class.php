<?php

use Wikia\RobotsTxt\PathBuilder;
use Wikia\RobotsTxt\RobotsTxt;
use Wikia\RobotsTxt\WikiaRobots;

class WikiaRobotsController extends WikiaController {

	const WIKI_VARIABLES_CACHE_TTL = 60;

	public function getAllowedDisallowed() {
		$wikiaRobots = new WikiaRobots( new PathBuilder() );
		$robots = $wikiaRobots->configureRobotsBuilder( new RobotsTxt() );

		$this->response->setVal( 'allowed', $robots->getAllowedPaths() );
		$this->response->setVal( 'disallowed', $robots->getDisallowedPaths() );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		// cache wikiVariables for 1 minute
		//$this->response->setCacheValidity( self::WIKI_VARIABLES_CACHE_TTL ); // ?
	}
}
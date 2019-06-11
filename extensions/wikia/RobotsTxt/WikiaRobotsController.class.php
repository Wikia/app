<?php

use Wikia\RobotsTxt\PathBuilder;
use Wikia\RobotsTxt\RobotsTxt;
use Wikia\RobotsTxt\WikiaRobots;

class WikiaRobotsController extends WikiaController {
	protected function getLocalRules() {
		$wikiaRobots = new WikiaRobots( new PathBuilder() );
		$robots = $wikiaRobots->configureRobotsBuilder( new RobotsTxt() );
		return [
			'allowed' => $robots->getAllowedPaths(),
			'disallowed' => $robots->getDisallowedPaths(),
			'sitemaps' => $robots->getSitemaps(),
		];
	}

	public function getAllowedDisallowed() {
		$rules = $this->getLocalRules();

		foreach ($rules as $key => $val) {
			$this->response->setVal( $key, $val );
		}
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	public function getRulesForDomain() {
		global $wgServer, $wgCityId;

		$wikis = \WikiFactory::getWikisUnderDomain( parse_url( $wgServer, PHP_URL_HOST ), true );
		$degraded = false;
		$allow = [];
		$disallow = [];
		$sitemap = [];
		foreach ( $wikis as $wikiData ) {
			if ( \Hooks::run( 'GenerateRobotsRules', [ $wikiData['city_id'] ] ) ) {
				if ( $wikiData['city_id'] === $wgCityId ) {
					$response = $this->getLocalRules();
				} else {
					$params = [
						'controller' => 'WikiaRobots',
						'method'     => 'getAllowedDisallowed',
						'shallow'    => 1
					];
					if ( $this->request->getBool( 'forcerobots' ) ) {
						$params['forcerobots'] = '1';
					}
					$response = \ApiService::foreignCall( $wikiData['city_dbname'], $params, \ApiService::WIKIA, false, true );
				}
				if ( !empty( $response ) ) {
					if ( isset( $response['allowed'] ) ) {
						$allow = array_merge( $allow, $response['allowed'] );
					}
					if ( isset( $response['disallowed'] ) ) {
						$disallow = array_merge( $disallow, $response['disallowed'] );
					}
					if ( isset( $response['sitemaps'] ) ) {
						$sitemap = array_merge( $sitemap, $response['sitemaps'] );
					}
				} else {
					$degraded = true;
				}
			}
		}

		$this->response->setVal( 'Allow', $allow );
		$this->response->setVal( 'Noindex', $disallow );
		$this->response->setVal( 'Disallow', $disallow );
		$this->response->setVal( 'Sitemap', $sitemap );
		$this->response->setVal( 'Degraded', $degraded );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

	}
}

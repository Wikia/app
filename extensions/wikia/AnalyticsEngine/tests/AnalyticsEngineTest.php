<?php

use PHPUnit\Framework\TestCase;

class AnalyticsEngineTest extends TestCase {

	public function testAddModuleForOasisSkin() {
		$skin = Skin::newFromKey( 'oasis' );
		$modules = [];

		AnalyticsEngine::onWikiaSkinTopShortTTLModules( $modules, $skin );

		$this->assertContains( 'ext.wikia.analyticsEngine', $modules );
	}

	public function testDoesNotAddModuleForNonOasisSkin() {
		$skin = Skin::newFromKey( 'monobook' );
		$modules = [];

		AnalyticsEngine::onWikiaSkinTopShortTTLModules( $modules, $skin );

		$this->assertNotContains( 'ext.wikia.analyticsEngine', $modules );
	}
}

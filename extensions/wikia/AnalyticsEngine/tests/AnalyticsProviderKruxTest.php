<?php

class AnalyticsProviderKruxTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->mockGlobalVariable('wgNoExternals', false);
		$this->mockGlobalVariable('wgEnableKruxTargeting', true);
		$this->mockGlobalVariable('wgWikiDirectedAtChildrenByStaff', false);

		$this->setupFile = "$IP/extensions/wikia/AdEngine/AdEngine2.setup.php";
		$this->setupFile = "$IP/extensions/wikia/AnalyticsEngine/AnalyticsEngine.setup.php";

		parent::setUp();
	}

	public function testKruxEnabled() {
		$this->assertTrue(AnalyticsProviderKrux::isEnabled());
	}

	public function testKruxDisabledByNoExternalsVar() {
		$this->mockGlobalVariable('wgNoExternals', true);

		$this->assertFalse(AnalyticsProviderKrux::isEnabled());
	}

	public function testKruxDisabledByEnableKruxTargetingVar() {
		$this->mockGlobalVariable('wgEnableKruxTargeting', false);

		$this->assertFalse(AnalyticsProviderKrux::isEnabled());
	}

	public function testKruxDisabledByWikiDirectedAtChildren() {
		$this->mockGlobalVariable('wgWikiDirectedAtChildrenByStaff', true);

		$this->assertFalse(AnalyticsProviderKrux::isEnabled());
	}
}

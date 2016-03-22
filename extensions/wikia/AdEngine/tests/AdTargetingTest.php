<?php

class AdTargetingTest extends WikiaBaseTest {

	public function setUp() {
		global $IP, $wgDartCustomKeyValues, $wgWikiDirectedAtChildrenByFounder, $wgWikiDirectedAtChildrenByStaff;
		$wgDartCustomKeyValues = null;
		$wgWikiDirectedAtChildrenByFounder = false;
		$wgWikiDirectedAtChildrenByStaff = false;

		$this->setupFile = "$IP/extensions/wikia/AdEngine/AdEngine2.setup.php";
		parent::setUp();
	}

	public function testWikiNotDirectedAtChildrenAndNoDartParams() {
		$this->assertEquals(AdTargeting::TEEN, AdTargeting::getEsrbRating());
	}

	public function testWikiDirectedAtChildrenByFounderAndNoDartParams() {
		$this->mockGlobalVariable('wgWikiDirectedAtChildrenByFounder', true);

		$this->assertEquals(AdTargeting::EARLY_CHILDHOOD, AdTargeting::getEsrbRating());
	}

	public function testWikiDirectedAtChildrenByStaffAndNoDartParams() {
		$this->mockGlobalVariable('wgWikiDirectedAtChildrenByStaff', true);

		$this->assertEquals(AdTargeting::EARLY_CHILDHOOD, AdTargeting::getEsrbRating());
	}

	public function testWikiNotDirectedAtChildrenAndDartParamsWithoutEsrb() {
		$this->mockGlobalVariable('wgDartCustomKeyValues', 'key1=value1;key2=value2');

		$this->assertEquals(AdTargeting::TEEN, AdTargeting::getEsrbRating());
	}

	public function testWikiNotDirectedAtChildrenAndOverrideRatingByDartParams() {
		$this->mockGlobalVariable('wgDartCustomKeyValues', 'key1=value1;esrb=mature');

		$this->assertEquals(AdTargeting::MATURE, AdTargeting::getEsrbRating());
	}

	public function testOverrideRatingByDartParams() {
		$this->mockGlobalVariable('wgDartCustomKeyValues', 'key1=value1;esrb=everyone');

		$this->assertEquals(AdTargeting::EVERYONE, AdTargeting::getEsrbRating());
	}

	public function testPickLastRatingFromDartParams() {
		$this->mockGlobalVariable('wgWikiDirectedAtChildrenByStaff', true);
		$this->mockGlobalVariable('wgDartCustomKeyValues', 'esrb=mature;key1=value1;esrb=everyone');

		$this->assertEquals(AdTargeting::EVERYONE, AdTargeting::getEsrbRating());
	}

}

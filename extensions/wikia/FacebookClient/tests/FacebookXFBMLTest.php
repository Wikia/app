<?php

class FacebookXFBMLTest extends WikiaBaseTest {

	/**
	 * Test that Wikia supports a base set of facebook social plugins. See SOC-261
	 */
	public function testSocialPluginsList() {
		$requiredPlugins = [
			'fb:facepile',
			'fb:follow',
			'fb:like-box',
			'fb:like',
			'fb:recommendations',
			'fb:share-button'
		];

		foreach( $requiredPlugins as $requiredPlugin ) {
			$this->assertContains( $requiredPlugin, FacebookClientXFBML::$supportedTags );
		}
	}
}

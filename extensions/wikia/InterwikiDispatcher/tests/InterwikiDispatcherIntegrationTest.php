<?php

/**
 * @group Integration
 */
class InterwikiDispatcherIntegrationTest extends WikiaDatabaseTest {

	/**
	 * @dataProvider interWikiUrlDataProvider
	 *
	 * @param string $interwikiPageName
	 * @param $expected
	 *
	 * @throws MWException
	 */
	public function testGetInterWikiUrl( string $interwikiPageName, string $expected ) {
		$t = Title::newFromText( $interwikiPageName );
		$this->assertEquals( $expected, InterwikiDispatcher::getInterWikiaURL( $t ) );
	}

	public function interWikiUrlDataProvider() {
		yield [ 'w:c:unittest:Testing', '//unittest.wikia.com/wiki/Testing' ];
		yield [ 'w:c:unittestsecondary:Testing', '//unittest.wikia.com/wiki/Testing' ];
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/interwiki_dispatcher.yaml' );
	}
}

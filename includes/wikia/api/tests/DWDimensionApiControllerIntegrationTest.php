<?php

/**
 * @group Integration
 */
class DWDimensionApiControllerIntegrationTest extends WikiaDatabaseTest {

	public function testWikiDartTags() {
		$controller = new DWDimensionApiController();
		$controller->getWikiDartTags();

		$responseData = $controller->getResponse()->getData();
		$this->assertEquals( 3, count($responseData) );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/wiki_dart_tags_integration.yaml' );
	}
}

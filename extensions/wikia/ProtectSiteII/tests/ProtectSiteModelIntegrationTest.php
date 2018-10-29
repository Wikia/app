<?php

/**
 * @group Integration
 */
class ProtectSiteModelIntegrationTest extends WikiaDatabaseTest {

	const EXPIRED_WIKI_ID = 2;
	const PROTECTED_WIKI_ID = 3;

	/** @var ProtectSiteModel $model */
	private $model;

	protected function setUp() {
		parent::setUp();
		$this->model = new ProtectSiteModel();
	}

	public function testShouldDeleteOutdatedEntries() {
		$this->model->deleteExpiredSettings();

		$this->assertEquals( 0, $this->model->getProtectionSettings( static::EXPIRED_WIKI_ID ), 'Expired settings should be deleted' );
		$this->assertNotEquals( 0, $this->model->getProtectionSettings( static::PROTECTED_WIKI_ID ), 'Still live settings should not be deleted' );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__  . '/fixtures/protect_site_model.yaml' );
	}
}

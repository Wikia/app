<?php

/**
 * @group Integration
 */
class WantedPagesIntegrationTest extends WikiaDatabaseTest {
	/** @var WantedPagesPage $wantedPagesPage */
	private $wantedPagesPage;

	protected function setUp() {
		parent::setUp();

		$this->wantedPagesPage = new WantedPagesPage();
	}

	public function testQuery() {
		$res = $this->wantedPagesPage->reallyDoQuery( 1000 );

		foreach ( $res as $row ) {
			$this->assertNotEquals( 'PageLinkedFromMwPage', $row->title, 'Page linked on MW page should not generate entry' );
			$this->assertNotEquals( 'UserPageLinkedFromNormalPage', $row->title, 'User page linked on normal page should not generate entry' );
		}

		$this->assertCount( 2, $res );
	}

	public function testQueryWithLimit() {
		$res = $this->wantedPagesPage->reallyDoQuery( 1 );

		foreach ( $res as $row ) {
			$this->assertNotEquals( 'PageLinkedFromMwPage', $row->title, 'Page linked on MW page should not generate entry' );
			$this->assertNotEquals( 'UserPageLinkedFromNormalPage', $row->title, 'User page linked on normal page should not generate entry' );
		}

		$this->assertCount( 1, $res );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/../../../fixtures/wanted_pages.yaml' );
	}
}

<?php

class UpdatePagesTaskIntegrationTest extends WikiaDatabaseTest {
	/** @var UpdatePagesTask $updatePagesTask */
	private $updatePagesTask;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../Pages.setup.php';

		$this->updatePagesTask = ( new UpdatePagesTask() )->wikiId( 177 );
	}

	public function testNoRowInsertedIfArticleDoesNotExist() {
		$this->updatePagesTask->insertOrUpdateEntry( 999, true );

		$this->assertTableRowCount( 'pages', 2 );
	}

	public function testRowIsInsertedForNewArticle() {
		$this->updatePagesTask->insertOrUpdateEntry( 3, true );

		$queryTable = $this->getConnection()->createQueryTable( 'pages', 'SELECT * FROM pages' );
		$expectedTable = $this->createYamlDataSet( __DIR__ . '/fixtures/state_post_insert_page.yaml' )
			->getTable( 'pages' );

		$this->assertTablesEqual( $expectedTable, $queryTable );
	}

	public function testRowIsUpdatedIfExists() {
		$this->updatePagesTask->insertOrUpdateEntry( 2, true );

		$queryTable = $this->getConnection()->createQueryTable( 'pages', 'SELECT * FROM pages' );
		$expectedTable = $this->createYamlDataSet( __DIR__ . '/fixtures/state_post_update_page.yaml' )
			->getTable( 'pages' );

		$this->assertTablesEqual( $expectedTable, $queryTable );
	}

	public function testRowIsDeleted() {
		$this->updatePagesTask->deleteEntry( 2 );

		$queryTable = $this->getConnection()->createQueryTable( 'pages', 'SELECT * FROM pages' );
		$expectedTable = $this->createYamlDataSet( __DIR__ . '/fixtures/state_post_delete_page.yaml' )
			->getTable( 'pages' );

		$this->assertTablesEqual( $expectedTable, $queryTable );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/state_initial.yaml' );
	}
}

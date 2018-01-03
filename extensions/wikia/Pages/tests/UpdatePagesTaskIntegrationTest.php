<?php

class UpdatePagesTaskIntegrationTest extends WikiaDatabaseTest {
	/** @var UpdatePagesTask $updatePagesTask */
	private $updatePagesTask;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../Pages.setup.php';

		$this->updatePagesTask = ( new UpdatePagesTask() )->wikiId( 177 );
	}

	public function testRowIsInsertedForNewArticle() {
		$this->updatePagesTask->insertOrUpdateEntry( $this->newPagesEntry( 3 ), true );

		$queryTable = $this->getConnection()->createQueryTable( 'pages', 'SELECT * FROM pages' );
		$expectedTable = $this->createYamlDataSet( __DIR__ . '/fixtures/state_post_insert_page.yaml' )
			->getTable( 'pages' );

		$this->assertTablesEqual( $expectedTable, $queryTable );
	}

	public function testRowIsUpdatedIfExists() {
		$this->updatePagesTask->insertOrUpdateEntry( $this->newPagesEntry( 2 ), true );

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

	private function newPagesEntry( int $articleId ) {
		$wikiPage = WikiPage::newFromID( $articleId );

		return PagesEntry::newFromPageAndRevision( $wikiPage, $wikiPage->getRevision() )->jsonSerialize();
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/state_initial.yaml' );
	}
}

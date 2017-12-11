<?php

/**
 * @group Integration
 */
class WikiImporterIntegrationTest extends WikiaDatabaseTest {
	const FIXTURES_PATH = __DIR__ . '/../../fixtures/importer';

	private $xmlFile;

	public function testImportInvalidXmlThrowsException() {
		$this->expectException( MWException::class );
		$this->expectExceptionMessage( 'Expected <mediawiki> tag, got karamba' );

		$this->openXmlFile( 'invalid_import.xml' );

		$importStreamSource = new ImportStreamSource( $this->xmlFile );
		$wikiImporter = new WikiImporter( $importStreamSource );

		$wikiImporter->doImport();
	}

	public function testImportRevisionByRegisteredUser() {
		$this->openXmlFile( 'revision_by_user.xml' );

		$importStreamSource = new ImportStreamSource( $this->xmlFile );
		$wikiImporter = new WikiImporter( $importStreamSource );

		$result = $wikiImporter->doImport();

		$this->assertTrue( $result );
		$this->assertValidRevisionHasUserIdAndUserText( 1, 'TestImportedUser' );
	}

	public function testImportRevisionByNonExistingUser() {
		$this->openXmlFile( 'revision_by_invalid_user.xml' );

		$importStreamSource = new ImportStreamSource( $this->xmlFile );
		$wikiImporter = new WikiImporter( $importStreamSource );

		$result = $wikiImporter->doImport();

		$this->assertTrue( $result );
		$this->assertValidRevisionHasUserIdAndUserText( Wikia::BOT_USER_ID, 'FANDOMbot' );
	}

	public function testImportRevisionByAnon() {
		$this->openXmlFile( 'revision_by_anon.xml' );

		$importStreamSource = new ImportStreamSource( $this->xmlFile );
		$wikiImporter = new WikiImporter( $importStreamSource );

		$result = $wikiImporter->doImport();

		$this->assertTrue( $result );
		$this->assertValidRevisionHasUserIdAndUserText( 0, '8.8.8.8' );
	}

	private function openXmlFile( string $fileName ) {
		$this->xmlFile = fopen( static::FIXTURES_PATH . "/$fileName", 'rt' );
	}

	private function assertValidRevisionHasUserIdAndUserText( int $expectedUserId, string $expectedUserText ) {
		$title = Title::makeTitle( NS_MAIN, 'Slicer' );
		$revision = Revision::newFromId( $title->getLatestRevID( Title::GAID_FOR_UPDATE ) );

		$this->assertInstanceOf( Revision::class, $revision );
		$this->assertEquals( $expectedUserId, $revision->getUser() );
		$this->assertEquals( $expectedUserText, $revision->getUserText() );
		$this->assertEquals( 'jkwdimyhtuxpg111tp1tzg031idxrs0', $revision->getSha1() );
	}

	protected function tearDown() {
		parent::tearDown();

		stream_wrapper_unregister( 'uploadsource' );
		fclose( $this->xmlFile );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( static::FIXTURES_PATH . '/wiki_importer.yaml' );
	}
}

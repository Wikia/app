<?php

class SpecialAdTestImport extends SpecialPage {

	private $interwiki = false;
	private $namespace;
	private $logcomment = false;
	private $secret = '802712e4da0b1989240faa2b9169bebb1916f7ce';
	private $source = 'http://adtest.wikia.com';

	public function __construct() {
		parent::__construct( 'AdTestImport' );
	}

	private function getAdTestDump() {
		$apiUrl = $this->source . '/api.php?action=query&list=allpages&aplimit=500&format=json';
		$apiResult = json_decode(file_get_contents($apiUrl));

		foreach ($apiResult->query->allpages as $page) {
			$titles[] = str_replace(' ', '_', $page->title);
		}

		$tempFile = tempnam( '/tmp/', 'adtest-xml' );
		$cmd = 'curl -X POST ' . escapeshellarg( $this->source . '/wiki/Special:Export?action=submit' );
		$cmd .= ' -d curonly=1 -d catname=';
		$cmd .= ' -d pages=' . escapeshellarg( join( "\n", $titles ) );

		file_put_contents( $tempFile, shell_exec( $cmd ) );

		return $tempFile;
	}

	public function execute( $par ) {
		$this->setHeaders();
		$this->outputHeader();

		if ( sha1( 'xxx' . $this->getRequest()->getVal( 'action' ) . 'xxx' ) !== $this->secret ) {
			$this->displayRestrictionError();
			return;
		}

		$tempFile = $this->getAdTestDump();
		$source = ImportStreamSource::newFromFile( $tempFile );
		$out = $this->getOutput();

		$importer = new WikiImporter( $source->value );
		if ( !is_null( $this->namespace ) ) {
			$importer->setTargetNamespace( $this->namespace );
		}
		$reporter = new ImportReporter( $importer, false, $this->interwiki, $this->logcomment );
		$reporter->setContext( $this->getContext() );

		$reporter->open();
		$importer->doImport();
		$result = $reporter->close();

		unlink( $tempFile );

		if ( $result->isGood() ) {
			$out->addWikiMsg( 'importsuccess' );
		}
	}
}

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
		$siteMapUrl = $this->source . '/sitemap-adtest-NS_0-0.xml.gz?cb=' . rand( 0, 1000 );
		$siteMap = shell_exec( 'curl ' . escapeshellarg( $siteMapUrl ) . ' | zcat' );
		$xml = simplexml_load_string( $siteMap );
		foreach ( $xml->url as $url ) {
			$titles[] = str_replace( $this->source . '/wiki/', '', $url->loc );
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

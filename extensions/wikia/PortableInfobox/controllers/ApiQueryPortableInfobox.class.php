<?php


class ApiQueryPortableInfobox extends ApiQueryGeneratorBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'ib' );
	}

	public function execute() {
		$articles = array_map( function ( Title $item ) {
			return Article::newFromTitle( $item, RequestContext::getMain() );
		}, array_filter( $this->getPageSet()->getGoodTitles(), function ( Title $el ) {
			return $el->inNamespace( NS_TEMPLATE );
		} ) );
		/**
		 * @var Article $article
		 */
		foreach ( $articles as $id => $article ) {
			dd( $article->getParserOutput()->getProperty( PortableInfoboxParserTagController::INFOBOXES_PROPERTY_NAME ) );
		}
		dd( $articles );
		$this->getResult()->addValue( null, $this->getModuleName(), $this->extractRequestParams() );
	}

	public function getVersion() {
		return __CLASS__ . '$Id$';
	}

	/**
	 * Execute this module as a generator
	 *
	 * @param $resultPageSet ApiPageSet: All output should be appended to
	 *  this object
	 */
	public function executeGenerator( $resultPageSet ) {
		// TODO: Implement executeGenerator() method.
	}
}

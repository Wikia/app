<?php


class ApiQueryPortableInfobox extends ApiQueryBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'ib' );
	}

	public function execute() {
		$this->runOnPageSet( $this->getPageSet() );
	}

	public function getVersion() {
		return __CLASS__ . '$Id$';
	}

	protected function runOnPageSet( ApiPageSet $pageSet ) {
		$articles = array_map( function ( Title $item ) {
			return Article::newFromTitle( $item, RequestContext::getMain() );
		}, $pageSet->getGoodTitles() );
		$parser = new Parser();
		$parserOptions = new ParserOptions();
		$frame = $parser->getPreprocessor()->newFrame();

		foreach ( $articles as $id => $article ) {
			$parsedInfoboxes = $this->getParsedInfoboxes( $article, $parser, $parserOptions, $frame );

			if ( is_array( $parsedInfoboxes ) ) {
				$inf = [ ];
				foreach ( array_keys( $parsedInfoboxes ) as $k => $v ) {
					$inf[ $k ] = [ ];
				}
				$pageSet->getResult()->setIndexedTagName( $inf, 'infobox' );
				$pageSet->getResult()->addValue( [ 'query', 'pages', $id ], 'infoboxes', $inf );
				foreach ( $parsedInfoboxes as $count => $infobox ) {
					$s = isset( $infobox[ 'sources' ] ) ? $infobox[ 'sources' ] : [ ];
					$pageSet->getResult()->addValue( [ 'query', 'pages', $id, 'infoboxes', $count ], 'id', $count );
					$pageSet->getResult()->setIndexedTagName( $s, "source" );
					$pageSet->getResult()->addValue( [ 'query', 'pages', $id, 'infoboxes', $count ], 'sources', $s );
				}
			}
		}
	}

	/**
	 * @desc For given Article, get property 'infoboxes' from parser output. If property is empty, this may mean that
	 * template is inside the <noinclude> tag. In this case, we want to skip the <includeonly> tags, get from this only
	 * infoboxes and parse them again to check their presence and get params.
	 * @param $article
	 * @param $parser
	 * @param $parserOptions
	 * @param $frame
	 * @return mixed
	 */
	protected function getParsedInfoboxes( $article, $parser, $parserOptions, $frame ) {
		$parsedInfoboxes = $article->getParserOutput()->getProperty( PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME );

		// if in template there are no infoboxes, thay can be hidden, so skip the <includeonly> tags
		// and parse again to check their presence
		if ( !$parsedInfoboxes ) {
			$templateText = $article->fetchContent();
			$templateText = $parser->getPreloadText( $templateText, $article->getTitle(), $parserOptions );

			$infoboxes = $this->processTemplate( $templateText );

			foreach ( $infoboxes as $infobox ) {
				PortableInfoboxParserTagController::getInstance()->render( $infobox, $parser, $frame );
			}

			$parsedInfoboxes = $parser->getOutput()->getProperty( PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME );
		}

		return $parsedInfoboxes;
	}

	/**
	 * @desc From the template string with removed <includeonly> tags, creates an array of
	 * strings containing only infoboxes. All template content which is not an infobox is removed.
	 *
	 * @param $text string Content of template which uses the <includeonly> tags
	 * @return array of striped infoboxes ready to parse
	 */
	protected function processTemplate( $text ) {
		$infoboxTag = '<infobox';
		$infoboxCloseTag = '</infobox>';
		$infoboxTagPosition = strpos( $text, $infoboxTag );
		$infoboxCloseTagPosition = strpos( $text, $infoboxCloseTag );
		$infoboxTagLength = strlen( $infoboxCloseTag );
		$result = [];

		if ( !$infoboxTagPosition ) {
			return [];
		}

		while ( $infoboxTagPosition && $infoboxCloseTagPosition ) {
			//substract an infobox from a string
			$onlyInfobox = substr( $text, $infoboxTagPosition, ( $infoboxCloseTagPosition + $infoboxTagLength ) - $infoboxTagPosition );
			$text = str_replace( $onlyInfobox, '', $text );
			$result[] = $onlyInfobox;

			$infoboxTagPosition = strpos( $text, $infoboxTag );
			$infoboxCloseTagPosition = strpos( $text, $infoboxCloseTag );
		}

		return $result;
	}
}

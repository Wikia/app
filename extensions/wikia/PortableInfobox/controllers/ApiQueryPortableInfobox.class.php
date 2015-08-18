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
		/**
		 * @var Article $article
		 */
		foreach ( $articles as $id => $article ) {
			$parsedInfoboxes = $article->getParserOutput()->getProperty( PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME );

			// if in template there are no infoboxes, thay can be hidden, so skip the <includeonly> tags
			// and parse again to check their presence
			if ( !$parsedInfoboxes ) {
				$templateText = $article->fetchContent();
				$templateText = $parser->getPreloadText($templateText, $article->getTitle(), $parserOptions);

				$infoboxes = $this->validateTemplate( $templateText );

				foreach ( $infoboxes as $infobox ) {
					PortableInfoboxParserTagController::getInstance()->render($infobox, $parser, $parser->getPreprocessor()->newFrame() );
				}

				$parsedInfoboxes = $parser->getOutput()->getProperty(PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME);
			}

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

	protected function validateTemplate( $text ) {
		$infoboxesCount = substr_count($text, '<infobox');
		$firstInfoboxTagPosition = strpos($text, '<infobox');
		$firstInfoboxCloseTagPosition = strpos($text, '</infobox>');
		$result = [];

		if ($infoboxesCount === 0 ) {
			return [];
		}

		if ( $infoboxesCount === 1 && $firstInfoboxTagPosition === 0 && $firstInfoboxCloseTagPosition === strlen($text) - 10) {
			return [$text];
		}
		var_dump($text);
		while ( $firstInfoboxTagPosition ) {
			//wyszukaj infoboxy i dodawaj do tablicy wynikowej
			$cuttedInfobox = substr($text, $firstInfoboxTagPosition, ($firstInfoboxCloseTagPosition + strlen('</infobox>')) - $firstInfoboxTagPosition);

			$text = str_replace($cuttedInfobox, '', $text);
			$result[] = $cuttedInfobox;

			$firstInfoboxTagPosition = strpos($text, '<infobox');
			$firstInfoboxCloseTagPosition = strpos($text, '</infobox>');
		}

		return $result;
	}
}

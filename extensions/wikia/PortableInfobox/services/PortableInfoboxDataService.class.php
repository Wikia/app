<?php

class PortableInfoboxDataService {

	const IMAGE_FIELD_TYPE = 'image';
	const INFOBOXES_PROPERTY_NAME = 'infoboxes';

	/**
	 * @var Title $title
	 */
	protected $title;

	protected function __construct( $title ) {
		$this->title = $title;
	}

	public static function newFromTitle( $title ) {
		return new PortableInfoboxDataService( $title );
	}

	public static function newFromPageID( $pageid ) {
		return new PortableInfoboxDataService( Title::newFromID( $pageid ) );
	}

	/**
	 * Returns infobox data
	 *
	 * @return array in format [ 'data' => [], 'sources' => [] ] or [] will be returned
	 */
	public function getData() {
		if ( $this->title && $this->title->exists() ) {
			$article = Article::newFromTitle( $this->title, RequestContext::getMain() );
			$data = $this->getParsedInfoboxes( $article );

			//return empty [] to prevent false on non existing infobox data
			return $data ? $data : [ ];
		}

		return [ ];
	}

	/**
	 * Get image list from infobox data
	 *
	 * @return array
	 */
	public function getImages() {
		$images = [ ];

		foreach ( $this->getData() as $infobox ) {
			// ensure data array exists
			$data = is_array( $infobox[ 'data' ] ) ? $infobox[ 'data' ] : [ ];
			foreach ( $data as $field ) {
				if ( $field[ 'type' ] == self::IMAGE_FIELD_TYPE && isset( $field[ 'data' ] ) && !empty( $field[ 'data' ][ 'key' ] ) ) {
					$images[ $field[ 'data' ][ 'key' ] ] = true;
				}
			}
		}

		return array_keys( $images );
	}

	/**
	 * @desc For given Article, get property 'infoboxes' from parser output. If property is empty, this may mean that
	 * template is inside the <noinclude> tag. In this case, we want to skip the <includeonly> tags, get from this only
	 * infoboxes and parse them again to check their presence and get params.
	 * @param $article
	 * @return mixed
	 */
	protected function getParsedInfoboxes( $article ) {
		//on empty parser cache this should be regenerated, see WikiPage.php:2996
		$parserOutput = $article->getParserOutput();
		$parsedInfoboxes = $parserOutput ?
			$parserOutput->getProperty( self::INFOBOXES_PROPERTY_NAME )
			: false;

		if ( !$parsedInfoboxes ) {
			$parser = new Parser();
			$parserOptions = new ParserOptions();
			$frame = $parser->getPreprocessor()->newFrame();

			$templateText = $article->fetchContent();
			$templateTextWithoutIncludeonly = $parser->getPreloadText( $templateText, $article->getTitle(), $parserOptions );
			$infoboxes = $this->processTemplate( $templateTextWithoutIncludeonly );

			foreach ( $infoboxes as $infobox ) {
				PortableInfoboxParserTagController::getInstance()->render( $infobox, $parser, $frame );
			}

			$parsedInfoboxes = $parser->getOutput()->getProperty( self::INFOBOXES_PROPERTY_NAME );
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
		preg_match_all( "/<infobox.+<\/infobox>/sU", $text, $result );

		return $result[0];
	}
}

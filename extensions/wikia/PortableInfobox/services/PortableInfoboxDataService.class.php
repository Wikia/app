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
			$data = $this->getParsedInfoboxes( $this->title );

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
	 * @desc For given Title, get property 'infoboxes' from parser output. If property is empty, this may mean that
	 * template is inside the <noinclude> tag. In this case, we want to skip the <includeonly> tags, get from this only
	 * infoboxes and parse them again to check their presence and get params.
	 * @param $title Title
	 * @return mixed
	 */
	protected function getParsedInfoboxes( $title ) {
		$article = Article::newFromTitle( $title, RequestContext::getMain() );

		if ( $title->getNamespace() === NS_TEMPLATE ) {
			$templateText = $article->fetchContent();
			$includeonlyText = $this->getIncludeonlyText( $templateText );

			if ( $includeonlyText ) {
				$parser = new Parser();
				$parserOptions = new ParserOptions();
				$frame = $parser->getPreprocessor()->newFrame();

				$templateTextWithoutIncludeonly = $parser->getPreloadText( $includeonlyText, $article->getTitle(), $parserOptions );
				$infoboxes = $this->getInfoboxes( $templateTextWithoutIncludeonly );

				if ( $infoboxes ) {
					foreach ( $infoboxes as $infobox ) {
						PortableInfoboxParserTagController::getInstance()->render( $infobox, $parser, $frame );
					}
					return $parser->getOutput()->getProperty( self::INFOBOXES_PROPERTY_NAME );
				}
			}
		}

		//on empty parser cache this should be regenerated, see WikiPage.php:2996
		$parserOutput = $article->getParserOutput();
		$parsedInfoboxes = $parserOutput ?
			$parserOutput->getProperty( self::INFOBOXES_PROPERTY_NAME )
			: false;

		return $parsedInfoboxes;
	}

	/**
	 * @desc From the template without <includeonly> tags, creates an array of
	 * strings containing only infoboxes. All template content which is not an infobox is removed.
	 *
	 * @param $text string Content of template which uses the <includeonly> tags
	 * @return array of striped infoboxes ready to parse
	 */
	protected function getInfoboxes( $text ) {
		preg_match_all( "/<infobox.+<\/infobox>/sU", $text, $result );

		return $result[0];
	}

	/**
	 * @desc returns the text from inside of the first <includeonly> tag and
	 * without the nowiki and pre tags.
	 * @param $text string template text
	 * @return string
	 */
	protected function getIncludeonlyText( $text ) {
		preg_match_all( "/<includeonly>(.+)<\/includeonly>/sU", $text, $result );

		if ( !isset( $result[1][0] ) ) {
			return null;
		}

		$result = $this->removeNowikiPre( $result[1][0] );
		return $result;

	}

	/**
	 * @desc for given template text returns it without text in <nowiki> and <pre> tags
	 * @param $text string
	 * @return string
	 */
	protected function removeNowikiPre( $text ) {
		$text = preg_replace( "/<nowiki>.+<\/nowiki>/sU", '', $text );
		$text = preg_replace( "/<pre>.+<\/pre>/sU", '', $text );

		return $text;
	}
}

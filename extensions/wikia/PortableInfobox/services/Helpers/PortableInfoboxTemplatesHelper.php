<?php

namespace Wikia\PortableInfobox\Helpers;

/**
 * Helper used for checking if template consist any hidden infoboxes (eg. put into <includeonly> tag)
 *
 * Class PortableInfoboxTemplatesHelper
 */
class PortableInfoboxTemplatesHelper {

	/**
	 * @desc For given Title, get property 'infoboxes' from parser output. If property is empty, this may mean that
	 * template is inside the <noinclude> tag. In this case, we want to skip the <includeonly> tags, get from this only
	 * infoboxes and parse them again to check their presence and get params.
	 *
	 * @param $title \Title
	 *
	 * @return mixed false when no infoboxes found, Array with infoboxes on success
	 */
	public function parseInfoboxes( $title ) {
		// for templates we need to check for include tags
		$article = \Article::newFromTitle( $title, \RequestContext::getMain() );
		$templateText = $article->fetchContent();
		$includeonlyText = $this->getIncludeonlyText( $templateText );

		if ( $includeonlyText ) {
			$parser = new \Parser();
			$parserOptions = new \ParserOptions();
			$frame = $parser->getPreprocessor()->newFrame();

			$templateTextWithoutIncludeonly = $parser->getPreloadText( $includeonlyText, $article->getTitle(), $parserOptions );
			$infoboxes = $this->getInfoboxes( $templateTextWithoutIncludeonly );

			if ( $infoboxes ) {
				// clear up cache before parsing
				foreach ( $infoboxes as $infobox ) {
					try {
						\PortableInfoboxParserTagController::getInstance()->render( $infobox, $parser, $frame );
					} catch ( \Exception $e ) {
						\Wikia\Logger\WikiaLogger::instance()->info( 'Invalid infobox syntax in includeonly tag' );
					}
				}

				return json_decode( $parser->getOutput()
					->getProperty( \PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME ), true );
			}
		}

		return false;
	}

	/**
	 * @desc From the template without <includeonly> tags, creates an array of
	 * strings containing only infoboxes. All template content which is not an infobox is removed.
	 *
	 * @param $text string Content of template which uses the <includeonly> tags
	 *
	 * @return array of striped infoboxes ready to parse
	 */
	protected function getInfoboxes( $text ) {
		preg_match_all( "/<infobox.+<\/infobox>/sU", $text, $result );

		return $result[ 0 ];
	}

	/**
	 * @desc returns the text from inside of the first <includeonly> tag and
	 * without the nowiki and pre tags.
	 *
	 * @param $text string template text
	 *
	 * @return string
	 */
	protected function getIncludeonlyText( $text ) {
		preg_match_all( "/<includeonly>(.+)<\/includeonly>/sU", $text, $result );
		if ( !isset( $result[ 1 ][ 0 ] ) ) {
			return null;
		}

		$result = $this->removeNowikiPre( $result[ 1 ][ 0 ] );

		return $result;

	}

	/**
	 * @desc for given template text returns it without text in <nowiki> and <pre> tags
	 *
	 * @param $text string
	 *
	 * @return string
	 */
	protected function removeNowikiPre( $text ) {
		$text = preg_replace( "/<nowiki>.+<\/nowiki>/sU", '', $text );
		$text = preg_replace( "/<pre>.+<\/pre>/sU", '', $text );

		return $text;
	}
}

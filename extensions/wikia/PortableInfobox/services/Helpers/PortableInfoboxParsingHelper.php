<?php

namespace Wikia\PortableInfobox\Helpers;

class PortableInfoboxParsingHelper {

	/**
	 * @desc Try to find out if infobox got "hidden" inside includeonly tag. Parse it if that's the case.
	 *
	 * @param $title \Title
	 *
	 * @return mixed false when no infoboxes found, Array with infoboxes on success
	 */
	public function parseIncludeonlyInfoboxes( $title ) {
		// for templates we need to check for include tags
		$templateText = $this->fetchArticleContent( $title );
		$includeonlyText = $this->getIncludeonlyText( $templateText );

		if ( $includeonlyText ) {
			$parser = new \Parser();
			$parserOptions = new \ParserOptions();
			$frame = $parser->getPreprocessor()->newFrame();

			$templateTextWithoutIncludeonly = $parser->getPreloadText( $includeonlyText, $title, $parserOptions );
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

	public function reparseArticle( $title ) {
		$parser = new \Parser();
		$parserOptions = new \ParserOptions();
		$parser->parse( $this->fetchArticleContent( $title ), $title, $parserOptions );

		return json_decode( $parser->getOutput()
			->getProperty( \PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME ), true );
	}

	/**
	 * @param $title \Title
	 *
	 * @return string
	 */
	protected function fetchArticleContent( \Title $title ) {
		if ( $title && $title->exists() ) {
			$article = \Article::newFromTitle( $title, \RequestContext::getMain() );

			if ( $article && $article->exists() ) {
				$content = $article->fetchContent();
			}
		}

		return isset( $content ) && $content ? $content : '';
	}

	/**
	 * @param $title
	 * @return array of strings (infobox markups)
	 */
	public function getMarkup( $title ) {
		$content = $this->fetchArticleContent( $title );
		return $this->getInfoboxes( $content );
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

	/**
	 * @desc returns the text from inside of the first <includeonly> tag and
	 * without the nowiki and pre tags.
	 *
	 * @param $text string template text
	 *
	 * @return string
	 */
	protected function getIncludeonlyText( $text ) {
		$clean = $this->removeNowikiPre( $text );

		preg_match_all( "/<includeonly>(.+)<\/includeonly>/sU", $clean, $result );
		if ( !isset( $result[ 1 ][ 0 ] ) ) {
			return null;
		}

		return $result[ 1 ][ 0 ];
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
		preg_match_all( "/<infobox[^>]*\\/>/sU", $text, $empty );
		preg_match_all( "/<infobox.+<\/infobox>/sU", $text, $result );

		return array_merge( $empty[ 0 ], $result[ 0 ] );
	}
}

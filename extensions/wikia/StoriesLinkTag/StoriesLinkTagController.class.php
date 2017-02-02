<?php

class StoriesLinkTagController extends WikiaController {

	const PARSER_TAG_NAME = 'storieslink';
	const MAX_URLS = 4;
	const MAX_LENGTH = 90;

	protected $counter = 0;
	protected $markers = [];
	protected static $instance = null;

	/**
	 * @return StoriesLinkTagController
	 */
	public static function getInstance() {
		if ( is_null( static::$instance ) ) {
			static::$instance = new StoriesLinkTagController();
		}

		return static::$instance;
	}

	/**
	 * Hook: used to register parser tag
	 * @param Parser $parser
	 * @return bool
	 */
	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ static::getInstance(), 'renderTag' ] );

		return true;
	}

	/**
	 * Render tag
	 *
	 * @param string $content - tag content
	 * @param array $attributes - tag attributes
	 * @param Parser $parser - parser instance
	 * @param PPFrame $frame - parent frame with the context
	 * @return string
	 */
	public function renderTag( $content, $attributes, Parser $parser, PPFrame $frame ) {
		$markerId = $this->getMarkerId( $parser );

		$urls = explode( PHP_EOL, trim( $content ) );
		$html = $this->app->renderView( 'StoriesLinkTag', 'render', [ 'markerId' => $this->counter, 'urls' => $urls ] );
		if ( !empty( $html ) ) {
			$html .= $this->getJSSnippet();
		}

		$this->markers[$markerId] = $html;

		return $markerId;
	}

	/**
	 * Get marker id
	 *
	 * @param Parser $parser
	 * @return string
	 */
	protected function getMarkerId( Parser $parser ) {
		$this->counter++;
		$markerId = $parser->uniqPrefix() . '-' . self::PARSER_TAG_NAME . '-' . $this->counter . Parser::MARKER_SUFFIX;

		return $markerId;
	}

	/**
	 * Hook: replace tag marker
	 * @param Parser $parser
	 * @param string $text
	 * @return bool
	 */
	public static function onParserAfterTidy( Parser &$parser, &$text ) {
		if ( empty( F::app()->wg->ArticleAsJson ) ) {
			$text = static::getInstance()->replaceMarkers( $text );
		}

		return true;
	}

	/**
	 * Hook: replace tag marker
	 * @param string $text
	 * @return bool
	 */
	public static function onArticleAsJsonBeforeEncode( &$text ) {
		$text = static::getInstance()->replaceMarkers( $text );

		return true;
	}

	/**
	 * Replace markers
	 * @param string $text
	 * @return string
	 */
	protected function replaceMarkers( $text ) {
		return strtr( $text, $this->markers );
	}

	/**
	 * Add assets to be loaded
	 * @return string
	 */
	protected function getJSSnippet() {
		$html = JSSnippets::addToStack(
			[
				'storieslink_tag_scss',
				'storieslink_tag_js'
			],
			[],
			'StoriesLinkTag.init',
			[$this->counter]
		);

		return $html;
	}

	/**
	 * Render storieslink unit
	 * @responseParam int markerId
	 * @responseParam array articles - list of articles
	 * @responseParam string readMore
	 */
	public function render() {
		$markerId = $this->request->getInt( 'markerId' );
		$urls = $this->request->getVal( 'urls', [] );

		$helper = new StoriesLinkTagHelper();
		if ( !$helper->canShowUnit() ) {
			return false;
		}

		$articles = [];
		$sliderId = 0;
		$urls = array_slice( array_filter( $urls ), 0, self::MAX_URLS );
		foreach ( $urls as $url ) {
			$urlParts = parse_url( trim( $url ) );
			if ( !empty( $urlParts['scheme'] ) && strtolower( $urlParts['scheme'] ) == 'http'
				&& !empty( $urlParts['host'] ) && strtolower( $urlParts['host'] ) == StoriesLinkTagHelper::VALID_HOST
				&& !empty( $urlParts['path'] ) && preg_match( '/^\/([^\/]+)\/(.+)/', $urlParts['path'], $matches )
			) {
				$article = $helper->getArticleDataBySlug( $matches[2], $matches[1] );
				if ( !empty( $article ) ) {
					$article['sliderId'] = $sliderId;
					$article['description'] = wfShortenText( $article['description'], self::MAX_LENGTH );
					$articles[] = $article;
					$sliderId++;
				}
			}
		}

		if ( empty( $articles ) ) {
			return false;
		}

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->markerId = $markerId;
		$this->articles = $articles;
		$this->readMore = wfMessage('storieslink-tag-read-more')->text();
	}

}

<?php

class JWPlayerTagController extends WikiaController {

	const PARSER_TAG_NAME = 'jwplayer';

	const ELEMENT_ID_PREFIX = 'jwPlayerTag';

	const CLASS_ATTR = 'class';
	const COMPONENT_ATTR = 'data-component';
	const DATA_ATTRS = 'data-attrs';
	const DATA_MEDIA_ID_ATTR = 'data-media-id';
	const ID_ATTR = 'id';
	const STYLE_ATTR = 'style';
	const WIDTH_ATTR = 'width';

	private static $elementIdCount = 1;

	public static function onParserFirstCallInit( Parser $parser ): bool {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderTag' ] );

		return true;
	}

	public static function getElementId() {
		$elementId = self::ELEMENT_ID_PREFIX . self::$elementIdCount;
		self::$elementIdCount++;

		return $elementId;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ): string {
		if ( !$this->validateArgs( $args ) ) {
			return '<strong class="error">' . wfMessage( 'jwplayer-tag-could-not-render' )->parse() . '</strong>';
		}

		if ( ArticleVideoContext::isFeaturedVideoEmbedded(
			RequestContext::getMain()->getTitle()->getArticleID()
		) ) {
			$script = JSSnippets::addToStack( [
				'jwplayer_tag_ads_js',
				'/extensions/wikia/JWPlayerTag/scripts/jwplayertag.js'
			] );
		} else {
			$script = JSSnippets::addToStack( [
				'jwplayer_tag_js',
				'jwplayer_tag_css'
			] );
		}

		$elementId = self::getElementId();

		return $script .
			Html::openElement( 'div', $this->getWrapperAttributes( $args, $elementId ) ) .
			Html::element( 'div', $this->getPlayerAttributes( $args, $elementId ) ) .
			Html::closeElement( 'div' );
	}

	private function validateArgs( $args ): bool {
		return array_key_exists( 'media-id', $args );
	}

	private function getPlayerAttributes( $args, $elementId ): array {
		$mediaId = $args['media-id'];

		return [
			self::CLASS_ATTR => 'jwplayer-container',
			self::ID_ATTR => $elementId,
			self::DATA_MEDIA_ID_ATTR => $mediaId,
			self::STYLE_ATTR => 'background-color:black; padding-top:56.25%;'
		];
	}

	private function getWrapperAttributes( $args, $elementId ): array {
		$width = array_key_exists( self::WIDTH_ATTR, $args ) ? $args[self::WIDTH_ATTR] : null;

		$attributes = [
			self::CLASS_ATTR => 'jwplayer-in-article-video',
			self::COMPONENT_ATTR => 'jwplayer-tag',
			self::DATA_ATTRS => json_encode( [
				'media-id' => $args['media-id'],
				'element-id' => $elementId,
			] )
		];

		if ( !empty( $width ) && is_numeric( $width ) ) {
			$attributes[self::STYLE_ATTR] = 'width:' . $width . 'px;';
		}

		return $attributes;
	}
}

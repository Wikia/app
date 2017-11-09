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

	public static function onParserFirstCallInit( Parser $parser ): bool {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderTag' ] );

		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ): string {
		if ( !$this->validateArgs( $args ) ) {
			return '<strong class="error">' . wfMessage( 'jwplayer-tag-could-not-render' )->parse() . '</strong>';
		}

		if (ArticleVideoContext::isFeaturedVideoEmbedded( RequestContext::getMain()->getTitle()->getPrefixedDBkey() )) {
			$script = JSSnippets::addToStack( [
				'/extensions/wikia/JWPlayerTag/scripts/jwplayertag.js'
			] );
		} else {
			$script = JSSnippets::addToStack( [
				'jwplayer_tag_js',
				'jwplayer_tag_css'
			] );
		}

		return $script .
			Html::openElement( 'div', $this->getWrapperAttributes( $args ) ) .
			Html::element( 'div', $this->getPlayerAttributes( $args ) ) .
			Html::closeElement( 'div' );
	}

	private function validateArgs( $args ): bool {
		return array_key_exists( 'media-id', $args );
	}

	private function getPlayerAttributes( $args ): array {
		$mediaId = $args['media-id'];

		return [
			self::CLASS_ATTR => 'jwplayer-container',
			self::ID_ATTR => self::ELEMENT_ID_PREFIX . $mediaId . rand(0, 1000),
			self::DATA_MEDIA_ID_ATTR => $mediaId,
			self::STYLE_ATTR => 'background-color:black; padding-top:56.25%;'
		];
	}

	private function getWrapperAttributes( $args ): array {
		$width = array_key_exists( self::WIDTH_ATTR, $args ) ? $args[self::WIDTH_ATTR] : null;

		$attributes = [
			self::CLASS_ATTR => 'jwplayer-in-article-video',
			self::COMPONENT_ATTR => 'jwplayer-tag',
			self::DATA_ATTRS => json_encode( ['media-id' => $args['media-id']] )
		];

		if ( !empty( $width ) && intval( $width ) > 0 ) {
			$attributes[self::STYLE_ATTR] = 'width:' . $width . 'px;';
		}

		return $attributes;
	}
}

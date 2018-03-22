<?php

class PlaybuzzTagController extends WikiaController {
	const PARSER_TAG_NAME = 'playbuzz';
	const PLAYBUZZ_SCRIPT_SRC = 'https://cdn.playbuzz.com/widget/feed.js';

	const DATA_ITEM_ATTR = 'data-item';
	const DATA_COMMENTS_ATTR = 'data-comments';
	const DATA_SHARES_ATTR = 'data-shares';
	const DATA_GAME_INFO_ATTR = 'data-game-info';
	const DATA_RECOMMEND_ATTR = 'data-recommend';

	private $wikiaTagBuilderHelper;

	public function __construct() {
		parent::__construct();

		$this->wikiaTagBuilderHelper = new WikiaTagBuilderHelper();
	}

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderTag' ] );
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		if ( !$this->validateArgs( $args ) ) {
			return '<strong class="error">' . wfMessage( 'playbuzz-tag-could-not-render' )->escaped() . '</strong>';
		}

		$script = JSSnippets::addToStack(self::PLAYBUZZ_SCRIPT_SRC);
		return $script . Html::element( 'div', $this->getAttributes( $args ) );
	}

	private function validateArgs( $args ) {
		return array_key_exists( self::DATA_ITEM_ATTR, $args );
	}

	private function getAttributes( array $args ): array {
		$attributes = [
			'class' => 'pb_feed',
			self::DATA_ITEM_ATTR => $args[self::DATA_ITEM_ATTR] ?? 'false',
			self::DATA_COMMENTS_ATTR => $args[self::DATA_COMMENTS_ATTR] ?? 'false',
			self::DATA_GAME_INFO_ATTR => $args[self::DATA_GAME_INFO_ATTR] ?? 'false',
			self::DATA_SHARES_ATTR => $args[self::DATA_SHARES_ATTR] ?? 'false',
			self::DATA_RECOMMEND_ATTR => $args[self::DATA_RECOMMEND_ATTR] ?? 'false'
		];

		if ( $this->wikiaTagBuilderHelper->isMobileSkin() ) {
			$attributes['data-wikia-widget'] = self::PARSER_TAG_NAME;
		}

		return $attributes;
	}
}

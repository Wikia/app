<?php

class PlaybuzzTagController extends WikiaController {
	const PARSER_TAG_NAME = 'playbuzz';
	const PLAYBUZZ_SCRIPT_SRC = 'http://cdn.playbuzz.com/widget/feed.js';
	const DATA_ITEM_ATTR = 'data-item';


	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderTag' ] );
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		if ( !$this->validateArgs( $args ) ) {
			return '<strong class="error">' . wfMessage( 'playbuzz-tag-could-not-render' )->escaped() . '</strong>';
		}

		$script = JSSnippets::addToStack(self::PLAYBUZZ_SCRIPT_SRC);
		return $script . Html::element( 'div', [ 'class' => 'pb_feed', 'data-item' => $args[self::DATA_ITEM_ATTR], 'data-version' => '2' ] );
	}

	private function validateArgs( $args ) {
		return array_key_exists( self::DATA_ITEM_ATTR, $args );
	}
}
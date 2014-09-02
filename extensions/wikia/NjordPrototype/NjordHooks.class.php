<?php
/**
 * Created by adam
 * Date: 02.09.14
 */

class NjordHooks {

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( 'hero', 'NjordHooks::renderHeroTag' );
		return true;
	}

	public static function renderHeroTag($content, array $attributes, Parser $parser, PPFrame $frame) {
		$model = new NjordModel();
		print_r($model);

		print_r($attributes);
		print_r($parser);
		print_r($frame);
		die;
		return '';
	}
}
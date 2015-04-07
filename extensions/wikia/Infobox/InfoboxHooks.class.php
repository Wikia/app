<?php

class InfoboxHooks {

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( 'infobox', 'InfoboxHooks::renderInfobox' );
		return true;
	}

	public static function renderInfobox( $content, array $attributes, Parser $parser, PPFrame $frame ) {
		$data = print_r($frame->getArguments(), true);
		return "DATA:\n" . $data . "XML:\n<pre>" . $content . "</pre>";
	}
}
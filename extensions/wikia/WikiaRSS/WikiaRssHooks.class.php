<?php 
class WikiaRssHooks {

	static public function onParserFirstCallInit(Parser $parser) {
		$parser->setHook('rss', array('WikiaRssHelper', 'renderRssPlaceholder'));
		return true;
	}

}
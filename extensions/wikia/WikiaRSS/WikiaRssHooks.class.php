<?php 
class WikiaRssHooks {
	
	public function onParserFirstCallInit(Parser $parser) {
		$parser->setHook('rss', array('WikiaRssHelper', 'renderRssPlaceholder'));
		return true;
	}
	
}
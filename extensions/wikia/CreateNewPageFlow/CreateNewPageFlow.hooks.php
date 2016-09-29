<?php

class CreateNewPageFlowHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'create_new_page_flow_js' );
	}
}

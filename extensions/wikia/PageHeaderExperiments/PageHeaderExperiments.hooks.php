<?php
class PageHeaderExperimentsHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'page_header_experiments_js' );
		\Wikia::addAssetsToOutput( 'page_header_experiments_scss' );

		return true;
	}
}
<?php
/**
 * Custom ResourceLoader module that loads a custom WikiLove.js per-wiki.
 */
class WikiLoveLocal extends ResourceLoaderWikiModule {

	/**
	 * @param $context ResourceLoaderContext
	 * @return array
	 */
	protected function getPages( ResourceLoaderContext $context ) {
		return array(
			'MediaWiki:WikiLove.js'      => array( 'type' => 'script' ),
		);
	}

	/**
	 * @return array
	 */
	public function getMessages() {
		global $wgWikiLoveOptionMessages;
		return $wgWikiLoveOptionMessages;
	}
}

<?php
/**
 * Custom ResourceLoader module that loads a Geshi.css per-wiki.
 */
class HighlightGeSHilocal extends ResourceLoaderWikiModule {

	/**
	 * @param $context ResourceLoaderContext
	 * @return array
	 */
	protected function getPages( ResourceLoaderContext $context ) {
		return array(
			'MediaWiki:Geshi.css'      => array( 'type' => 'style' ),
		);
	}
}

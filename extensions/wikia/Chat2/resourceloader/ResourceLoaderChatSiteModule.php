<?php

/**
 * Resource Loader module for site JS and CSS for inclusion in Special:Chat
 */
class ResourceLoaderChatSiteModule extends ResourceLoaderSiteModule {

	protected function getPages( ResourceLoaderContext $context ) {
		return [
			'MediaWiki:Chat.js' => [
				'type' => 'script',
			],
			'MediaWiki:Chat.css' => [
				'type' => 'style',
			],
		];
	}
}

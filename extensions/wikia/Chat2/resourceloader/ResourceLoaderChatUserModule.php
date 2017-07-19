<?php
/**
 * Resource Loader module for user JS and CSS for inclusion in Special:Chat
 */
class ResourceLoaderChatUserModule extends ResourceLoaderUserModule {

	protected function getPages( ResourceLoaderContext $context ) {
		$userName = $context->getUser();

		if ( $userName ) {
			$userPageTitle = Title::makeTitleSafe( NS_USER, $userName );
			$userPageText = $userPageTitle->getPrefixedDBkey();

			return [
				"$userPageText/chat.js" => [
					'type' => 'script',
				],
				"$userPageText/chat.css" => [
					'type' => 'style',
				],
			];
		}

		return [];
	}
}

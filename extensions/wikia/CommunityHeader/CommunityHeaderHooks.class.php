<?php

class CommunityHeaderHooks {
	public static function onBeforePageDisplay( /*\OutputPage $out, \Skin $skin */ ) {
		\Wikia::addAssetsToOutput( 'community_header_scss' );
		\Wikia::addAssetsToOutput( 'community_header_js' );

		return true;
	}


	/**
	 * Render the preview of wiki navigation menu
	 *
	 * @param Title $title Title of the page preview is generated for
	 * @param string $html preview content to modify
	 * @param string $wikitext current wikitext from the editor
	 * @return bool return true
	 */
	public static function onEditPageLayoutModifyPreview( Title $title, string &$html, string $wikitext ): bool {
		if ( NavigationModel::isWikiNavMessage( $title ) ) {
			// render a preview
			$html = F::app()->renderPartial(
				'CommunityHeaderService',
				'localNavigationPreview',
				[ 'wikiText' => $wikitext ]
			);
		}

		return true;
	}

	/**
	 * Add global JS variable indicating that we're editing wiki nav message
	 *
	 * @return bool return true
	 */
	public static function onEditPageMakeGlobalVariablesScript() {
		$context = RequestContext::getMain();

		if ( NavigationModel::isWikiNavMessage( $context->getTitle() ) ) {
			$context->getOutput()->addJsConfigVars( [
				'wgIsWikiNavMessage' => true
			] );
		}

		return true;
	}

	/**
	 * Clear the navigation service cache every time a message is edited
	 *
	 * @param string $title name of the page changed.
	 * @return bool return true
	 */
	public static function onMessageCacheReplace( string $title/*, string $text*/ ) {
		if ( NavigationModel::isWikiNavMessage( Title::newFromText( $title, NS_MEDIAWIKI ) ) ) {
			$model = new NavigationModel();
			$model->clearMemc( $title );
			wfDebug( __METHOD__ . ": '{$title}' cache cleared\n" );
		}

		return true;
	}
}

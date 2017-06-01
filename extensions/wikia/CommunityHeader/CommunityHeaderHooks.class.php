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
	public static function onEditPageLayoutModifyPreview( Title $title, &$html, $wikitext ) {
		if ( NavigationModel::isWikiNavMessage( $title ) ) {
			// render a preview
			$html = F::app()->renderPartial(
				'CommunityHeader',
				'localNavigationPreview',
				[ 'wikiText' => $wikitext ]
			);
		}

		return true;
	}
}

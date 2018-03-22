<?php

/**
 * Class CreatePageHelper
 */
class CreatePageHelper {

	/**
	 * @const array of namespace IDs
	 */
	const ALLOWED_NAMESPACES = [ NS_MAIN ];
	/**
	 * @const int the maximum number of returned items
	 */
	const FETCHED_TITLES_LIMIT = 6;
	/**
	 * @const string titles (without prefix) matching this regex will be filtered out
	 */
	const FORBIDDEN_CHARACTERS_REGEX = '/[:\/]+/';

	/**
	 * @return array[] Returned rows contain [title => string, url => string]
	 */
	public static function getMostWantedPages() {
		$WantedPagesPageResponse = ( new WantedPagesPage() )->doQuery();
		$dbr = wfGetDB( DB_SLAVE );
		$wantedPages = [];
		$fetchedTitlesCount = 0;

		while ( $row = $dbr->fetchObject( $WantedPagesPageResponse ) ) {
			if ( $row->title &&
				in_array( $row->namespace, static::ALLOWED_NAMESPACES ) &&
				$fetchedTitlesCount < static::FETCHED_TITLES_LIMIT
			) {
				$wantedPageTitle = Title::newFromText( $row->title, $row->namespace );

				if ( $wantedPageTitle instanceof Title &&
				     !$wantedPageTitle->isKnown() &&
					(
						empty( static::FORBIDDEN_CHARACTERS_REGEX ) ||
						!preg_match( static::FORBIDDEN_CHARACTERS_REGEX, $wantedPageTitle->getText() )
					)
				) {
					$wantedPages[] = [
						'title' => $wantedPageTitle->getFullText(),
						'url' => $wantedPageTitle->escapeLocalURL(
							[
								static::getPreferredEditorQueryParamName() => 'edit',
								'flow' => FlowTrackingHooks::CREATE_PAGE_CREATE_BUTTON,
								'source' => 'redlink',
							]
						),
					];
					$fetchedTitlesCount++;
				}
			}
		}

		return $wantedPages;
	}

	/**
	 * @return string['veaction'|'action']
	 */
	private static function getPreferredEditorQueryParamName() {
		if ( EditorPreference::isVisualEditorPrimary() &&
			EditorPreference::shouldShowVisualEditorLink( \RequestContext::getMain()->getSkin() ) ) {
			return 'veaction';
		} else {
			return 'action';
		}
	}
}

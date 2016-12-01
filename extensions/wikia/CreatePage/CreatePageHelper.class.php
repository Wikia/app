<?php

class CreatePageHelper {

	const ALLOWED_NAMESPACES = [ NS_MAIN ];
	const FETCHED_TITLES_LIMIT = 6;
	const FORBIDDEN_CHARACTERS_REGEX = '/[:\/]+/';

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

	private static function getPreferredEditorQueryParamName() {
		return EditorPreference::getPrimaryEditor() === EditorPreference::OPTION_EDITOR_VISUAL ? 'veaction' : 'action';
	}
}

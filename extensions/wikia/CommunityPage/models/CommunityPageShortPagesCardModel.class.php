<?php

class CommunityPageShortPagesCardModel {
	const SHORT_PAGES_LIMIT = 3;

	/**
	 * Will return short pages module
	 * @return array
	 */
	public function getData() {
		$pages = $this->getPages();

		$pagesCount = count( $pages );
		$pages = array_slice( $pages, 0, static::SHORT_PAGES_LIMIT );

		return $pagesCount > 0 ? [
			[
				'type' => 'expand-article',
				'title' => wfMessage( 'communitypage-cards-expand-articles' )->text(),
				'icon' => 'expand-article',
				'pages' => array_map( [ __CLASS__, 'getPage' ], $pages),
				'fulllistlink' => ( $pagesCount > static::SHORT_PAGES_LIMIT ) ?
					SpecialPage::getTitleFor( 'Shortpages' )->getLocalURL() : ''
			]
		] : [ ];
	}

	/**
	 * Extracts data from ShortPages special page
	 */
	private function getPages() {
		$pages = [ ];
		shuffle( $pages );

		foreach ( ( new ShortPagesPage() )->doQuery() as $obj ) {
			$pages[] = $obj->title;
		}

		return $pages;
	}

	private function getPage( $title ) {
		$title = Title::newFromText( $title );
		return [
			'link' => [
				'text' => $title->getText(),
				'articleurl' => $title->getFullURL(),
				'editlink' => $this->getEditUrl( $title->getFullURL() )
			]
		];
	}

	private function getEditUrl( $articleUrl ) {
		if ( EditorPreference::isVisualEditorPrimary() ) {
			return $articleUrl . '?veaction=edit';
		}
		return $articleUrl . '?action=edit';
	}
}

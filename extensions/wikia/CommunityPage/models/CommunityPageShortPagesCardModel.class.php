<?php

class CommunityPageShortPagesCardModel {
	const SHORT_PAGES_LIMIT = 3;

	/**
	 * Will return short pages module
	 * @return array
	 */
	public function getData() {
		$pages = $this->getPages();

		if ( $pages ) {
			return [
				'modules' => [
					[
						'type' => 'expand-article',
						'title' => wfMessage( 'communitypage-cards-expand-articles' )->text(),
						'icon' => 'expand-article',
						'pages' => $pages,
						'fulllistlink' => ( count( $pages ) > static::SHORT_PAGES_LIMIT )
							? SpecialPage::getTitleFor( 'Shortpages' )->getLocalURL()
							: ''
					]
				]
			];
		}
	}

	/**
	 * Extracts data from ShortPages special page
	 */
	private function getPages() {
		$pages = [];
		foreach ( ( new ShortPagesPage() )->doQuery() as $obj ) {
			$pages [] = $this->getPage( $obj->title );
		}
		shuffle( $pages );

		return array_slice( $pages, 0, static::SHORT_PAGES_LIMIT );
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

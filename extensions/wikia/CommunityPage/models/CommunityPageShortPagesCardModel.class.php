<?php

class CommunityPageShortPagesCardModel {

	/**
	 * Will return short pages module
	 * @return array
	 */
	public function getData() {
		$result = [
			[
				'type' => 'createpage',
				'title' => wfMessage( 'communitypage-cards-create-page' )->text(),
				'icon' => 'expand-article',
				'pages' => [ ],
				'fulllistlink' => SpecialPage::getTitleFor( 'Shortpages' )->getLocalURL()
			]
		];

		// limit number of modules returned
		return [
			'modules' => $result
		];
	}

	private function getPages() {
		//TODO: get pages from querycache on Shortpages
		return [];
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

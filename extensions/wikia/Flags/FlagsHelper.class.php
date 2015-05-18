<?php

use Flags\Views\FlagView;

class FlagsHelper {

	public function getFlagsForPageWikitext( $pageId ) {
		$flags = $this->sendGetFlagsForPageRequest( $pageId );
		if ( !empty( $flags ) ) {
			$flagsWikitext = '';
			$flagView = new FlagView();
			foreach ( $flags as $flagId => $flag ) {
				$flagsWikitext .= $flagView->createWikitextCall( $flag['flag_view'], $flag['params'] );
			}
			return $flagsWikitext;
		} else {
			return null;
		}
	}

	private function sendGetFlagsForPageRequest( $pageId ) {
		$app = \F::app();
		return $app->sendRequest('FlagsController',
			'getFlagsForPage',
			[
				'pageId' => $pageId,
			]
		)->getData();
	}
}

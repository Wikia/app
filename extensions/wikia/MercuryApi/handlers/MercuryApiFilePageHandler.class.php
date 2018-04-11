<?php

class MercuryApiFilePageHandler {

	public static function getFileContent( Title $title ) {
		$fileUsageData = F::app()->sendRequest(
			'FilePage',
			'fileUsage',
			[ 'type' => 'local', 'format' => 'json' ]
		)->getData();

		$details = WikiaFileHelper::getMediaDetail( $title );
		$mediaObject = ArticleAsJson::createMediaObject( $details, $title->getText() );

		// if article contains user provided HTML which is invalid (e.g. too many </div>), snippetter treat it as a text
		// too and it is not removed as other tags. In mobile-wiki we do not escape snippets, therefore invalid html may
		// cause errors on front-end side
		$fileUsageList = array_map( function( $item ) {
			$tidy = new tidy();
			$tidy->parseString( $item['snippet'] );
			$tidy->cleanRepair();
			$item['snippet'] = array_reduce(
				$tidy->body()->child,
				function ( $acc, $child ) {
					return $acc . $child->value;
				}
			);

			return $item;
		}, $fileUsageData['fileList']);

		return [
			'fileUsageList' => $fileUsageList,
			'fileUsageListSeeMoreUrl' => $fileUsageData['seeMoreLink'],
			'media' => $mediaObject
		];
	}
}

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

		return [
			'fileUsageList' => $fileUsageData['fileList'],
			'fileUsageListSeeMoreUrl' => $fileUsageData['seeMoreLink'],
			'media' => $mediaObject
		];
	}
}

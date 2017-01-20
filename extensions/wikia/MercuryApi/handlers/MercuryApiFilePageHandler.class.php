<?php

class MercuryApiFilePageHandler {

	public static function getFileContent( Title $title ) {
		$fileUsageData = F::app()->sendRequest(
			'FilePage',
			'fileUsage',
			[ 'type' => 'local', 'format' => 'json' ]
		)->getData();

		return [
			'fileUsageList' => $fileUsageData['fileList'],
			'fileUsageListSeeMoreUrl' => $fileUsageData['seeMoreLink']
		];
	}
}

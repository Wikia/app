<?php
class LatestPhotosController extends WikiaController {

	/**
	 * The widht&height of cropped thumbnail
	 *
	 * @var int
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	const THUMB_SIZE = 82;

	/**
	 * Just a string concatenated with other in creation of Memc Key
	 * @var String
	 */
	const MEMC_KEY_VER = '1.2';

	public function getLatestThumbsUrls() {
		global $wgMemc;
		$thumbUrls = $wgMemc->get( LatestPhotosController::memcacheKey() );
		if ( empty( $thumbUrls ) ) {
			// api service
			$helper = new LatestPhotosHelper();
			$params = [
				'action' => 'query',
				'list' => 'logevents',
				'letype' => 'upload',
				'leprop' => 'title',
				'lelimit' => 50,
			];

			$apiData = ApiService::call($params);

			if ( empty( $apiData ) ) {
				$this->response->setVal('thumbUrls', false);
			}
			$imageList = $apiData['query']['logevents'];

			$fileList = array_map([$helper, "getImageData"], $imageList);
			$fileList = array_filter($fileList, [$helper, "filterImages"]);

			// make sure the list of images is unique and limited to 11 images (12 including the see all image)
			$shaList = [];
			$uniqueList = [];

			foreach ($fileList as $data) {
				$sha = $data['file']->sha1;
				if ( !array_key_exists($sha, $shaList) && ( $data['file']->media_type != 'VIDEO' ) ) {
					$shaList[$sha] = true;
					$uniqueList[] = $data;
				}
				if (count($uniqueList) > 10) break;
			}

			$thumbUrls = array_map(array($helper, 'getTemplateData'), $uniqueList);
			$wgMemc->set( self::memcacheKey(), $thumbUrls);
		}
		$this->response->setVal('thumbUrls', $thumbUrls);
	}

	public static function memcacheKey() {
		// mech: bugfix for 19619 in getTemplateData method requires me to invalidate the cache,
		// so I'm changing the memkey
		$mKey = wfMemcKey('mOasisLatestPhotosKey' . self::MEMC_KEY_VER);
		return $mKey;
	}
}

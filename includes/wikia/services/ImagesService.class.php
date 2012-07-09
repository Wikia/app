<?php

class ImagesService extends Service {
	/**
	 * get image thumbnail
	 * @param integer wikiId
	 * @param integer pageId
	 * @return string imageUrl
	 */
	public static function getImageSrc($wikiId, $pageId, $imgSize = 250) {
		$app = F::app();

		$app->wf->ProfileIn(__METHOD__);

		$dbname = WikiFactory::IDtoDB($wikiId);

		if (!empty($app->wg->DevelEnvironment)) {
			/**
			 * TODO: FOR TESTING IN DEV ENVIRONMENT ONLY
			 *     BEST TO REMOVE BEFORE RELEASE
			 */
			if ($dbname == 'dehauptseite') {
				$dbname = 'de';
			}
			if ($dbname == 'enmarveldatabase') {
				$dbname = 'marvel';
			}
		}

		$param = array(
			'action' => 'imagecrop',
			'imgId' => $pageId,
			'imgSize' => $imgSize,
			'imgFailOnFileNotFound' => 'true',
		);

		$response = ApiService::foreignCall($dbname, $param);

		$imageSrc = (empty($response['image']['imagecrop'])) ? '' : $response['image']['imagecrop'];
		$imagePage = (empty($response['imagepage']['imagecrop'])) ? '' : $response['imagepage']['imagecrop'];

		$app->wf->ProfileOut(__METHOD__);
		return array('src' => $imageSrc, 'page' => $imagePage);
	}

	/**
	 * get image page url
	 * @param integer wikiId
	 * @param integer pageId
	 * @return string image page URL
	 */
	public static function getImagePage($wikiId, $pageId) {
		$app = F::app();
		$app->wf->ProfileIn(__METHOD__);

		$title = GlobalTitle::newFromId($pageId, $wikiId);
		$imagePage = ($title instanceof Title) ? $title->getFullURL() : '';

		$app->wf->ProfileOut(__METHOD__);
		return $imagePage;
	}

	public static function uploadImageFromUrl($imageUrl, $dstImageName, $user = null) {
		// disable recentchange hooks
		global $wgHooks;
		$wgHooks['RecentChange_save'] = array();
		$wgHooks['RecentChange_beforeSave'] = array();

		/* prepare temporary file */
		$data = array(
			'wpUpload' => 1,
			'wpSourceType' => 'web',
			'wpUploadFileURL' => $imageUrl
		);

		$upload = F::build('UploadFromUrl');
		$upload->initializeFromRequest(F::build('FauxRequest', array($data, true)));
		$upload->fetchFile();
		$upload->verifyUpload();

		// create destination file
		$title = Title::newFromText($dstImageName, NS_FILE);
		$file = F::build(
			'WikiaLocalFile',
			array(
				$title,
				RepoGroup::singleton()->getLocalRepo()
			)
		);

		/* real upload */
		$result = $file->upload(
			$upload->getTempPath(),
			$dstImageName,
			$dstImageName,
			File::DELETE_SOURCE,
			false,
			false,
			$user
		);

		return array(
			'status' => $result->ok,
			'errors' => $result->errors,
		);
	}
}

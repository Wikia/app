<?php

class ImagesService extends Service {
	const FILE_DATA_COMMENT_OPION_NAME = 'comment';
	const FILE_DATA_DESC_OPION_NAME = 'description';

	/**
	 * get image thumbnail
	 * @param integer $wikiId
	 * @param integer $pageId
	 * @return string imageUrl
	 */
	public static function getImageSrc($wikiId, $pageId, $imgSize = 250) {
		$app = F::app();

		$app->wf->ProfileIn(__METHOD__);

		$dbname = WikiFactory::IDtoDB($wikiId);

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
	 * @param integer $wikiId
	 * @param integer $pageId
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

	/**
	 * @desc Uploads an image on a wiki
	 *
	 * @static
	 * @param string $imageUrl url address to original file
	 * @param Object $oImageData an object with obligatory field "name" and optional fields: "comment", "description"
	 * @param User | null $user optional User's class instance (the file will be "uploaded" by this user)
	 *
	 * @return array
	 */
	public static function uploadImageFromUrl($imageUrl, $oImageData, $user = null) {
		// disable recentchange hooks
		global $wgHooks;
		$wgHooks['RecentChange_save'] = array();
		$wgHooks['RecentChange_beforeSave'] = array();

		/* prepare temporary file */
		$data = array(
			'wpUpload' => 1,
			'wpSourceType' => 'web',
			'wpUploadFileURL' => $imageUrl,
			'wpDestFile' => $oImageData->name,
		);

		//validate of optional image data
		foreach( array(self::FILE_DATA_COMMENT_OPION_NAME, self::FILE_DATA_DESC_OPION_NAME) as $option ) {
			if( !isset($oImageData->$option) ) {
				$oImageData->$option = $oImageData->name;
			}
		}

		$upload = F::build('UploadFromUrl'); /* @var $upload UploadFromUrl */
		$upload->initializeFromRequest(F::build('FauxRequest', array($data, true)));
		$fetchStatus = $upload->fetchFile();

		if( $fetchStatus->isGood() ) {
			$status = $upload->verifyUpload();

			if( isset($status['status']) && ($status['status'] == UploadBase::SUCCESS) ) {
				$file = self::createImagePage($oImageData->name); /** @var $file WikiaLocalFile */
				$result = self::updateImageInfoInDb( $file, $upload->getTempPath(), $oImageData, $user); /** @var $result */

				return self::buildStatus($result->ok, $file->getTitle()->getArticleID(), $result->errors);
			} else {
				$errorMsg = 'Upload verification faild ';
				$errorMsg .= ( isset($status['status']) ? print_r($status, true) : '');

				return self::buildStatus(false, null, $errorMsg);
			}
		} else {
			return self::buildStatus($fetchStatus->ok, null, $fetchStatus->errors);
		}
	}

	/**
	 * @param String $name destination file name
	 *
	 * @return WikiaLocalFile
	 */
	public static function createImagePage($name) {
		// create destination file
		$title = Title::newFromText($name, NS_FILE); /** @var $title Title */
		return F::build(
			'WikiaLocalFile',
			array(
				$title,
				RepoGroup::singleton()->getLocalRepo()
			)
		); /** @var $file WikiaLocalFile */
	}

	/**
	 * @param File $file
	 * @param String $tmpPath
	 * @param StdClass $imageData
	 * @param User|null $user
	 *
	 * @return mixed
	 */
	public static function updateImageInfoInDb(File $file, $tmpPath, $imageData, $user = null) {
		return $file->upload(
			$tmpPath,
			$imageData->comment,
			$imageData->description,
			File::DELETE_SOURCE,
			false,
			false,
			$user
		);
	}

	/**
	 * @param bool $status
	 * @param Integer|null $page_id
	 * @param null $errors
	 *
	 * @return array
	 */
	public static function buildStatus($status = false, $page_id = null, $errors = null) {
		return array(
			'status' => $status,
			'page_id' => $page_id,
			'errors' => $errors,
		);
	}
}

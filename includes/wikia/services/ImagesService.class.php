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

		wfProfileIn(__METHOD__);

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

		wfProfileOut(__METHOD__);
		return array('src' => $imageSrc, 'page' => $imagePage);
	}

	public static function getImageOriginalUrl($wikiId, $pageId) {
		$app = F::app();
		wfProfileIn(__METHOD__);

		$dbname = WikiFactory::IDtoDB($wikiId);
		$title = GlobalTitle::newFromId($pageId, $wikiId);

		$param = array(
			'action' => 'query',
			'prop' => 'imageinfo',
			'iiprop' => 'url',
			'titles' => $title->getPrefixedText(),
		);

		$imagePage = $title->getFullUrl();
		$response = ApiService::foreignCall($dbname, $param);

		if (!empty($response['query']['pages'])) {
			$imagePageData = array_shift($response['query']['pages']);
			$imageInfo = array_shift($imagePageData['imageinfo']);
			$imageSrc = (empty($imageInfo['url'])) ? '' : $imageInfo['url'];
		} else {
			$imageSrc = '';
		}

		wfProfileOut(__METHOD__);
		return array('src' => $imageSrc, 'page' => $imagePage);
	}

	/**
	 * @desc Returns image's thumbnail's url and its sizes if $destImageWidth given it can be scaled
	 *
	 * @param String $fileName filename with or without namespace string
	 * @param Integer $imageWidth optional parameter
	 *
	 * @return stdClass to the image's thumbnail
	 */
	public static function getLocalFileThumbUrlAndSizes($fileName, $destImageWidth = 0) {
		$app = F::app();

		$results = new stdClass();
		$results->url = '';
		$results->title = '';
		$results->width = 0;
		$results->height = 0;

		//remove namespace string
		$fileName = str_replace($app->wg->ContLang->getNsText(NS_FILE) . ':', '', $fileName);
		$title = Title::newFromText($fileName, NS_FILE);
		$article = Article::newFromID($title->getArticleID());

		if ($article instanceof Article && $article->isRedirect()) {
			$tmpTitle = $article->followRedirect();
			if ($tmpTitle instanceof Title) {
				$title = $tmpTitle;
			}
		}

		$foundFile = $app->wf->FindFile($title);

		if ($foundFile) {
			$imageWidth = $foundFile->getWidth();
			$sizes = ($destImageWidth > 0) ?
				self::calculateScaledImageSizes($destImageWidth, $imageWidth, $foundFile->getHeight()) :
				self::calculateScaledImageSizes($imageWidth, $imageWidth, $foundFile->getHeight());

			$results->url = $foundFile->createThumb($sizes->width);

			$results->width = intval($sizes->width);
			$results->height = intval($sizes->height);
			$results->title = $title->getText();
		}

		return $results;
	}

	/**
	 * @desc Depending on image original width&height we calculate or not new width based on passed $destImageWidth
	 *
	 * @param Integer $destImageSize
	 * @param Integer $imageWidth
	 * @param Integer $imageHeight
	 *
	 * @return object
	 */
	public static function calculateScaledImageSizes($destImageSize, $imageWidth, $imageHeight) {
		if ($imageWidth > $imageHeight) {
			$aspectRatio = $imageHeight / $imageWidth;
			$calculatedWidth = $destImageSize;
			$calculatedHeight = floor($destImageSize * $aspectRatio);
		} else if ($imageWidth < $imageHeight) {
			$aspectRatio = $imageWidth / $imageHeight;
			$calculatedWidth = floor($destImageSize * $aspectRatio);
			$calculatedHeight = $destImageSize;
		} else {
			$calculatedWidth = $destImageSize;
			$calculatedHeight = $destImageSize;
		}

		$result = new StdClass();
		$result->width = $calculatedWidth;
		$result->height = $calculatedHeight;

		return $result;
	}

	/**
	 * get image page url
	 * @param integer $wikiId
	 * @param integer $pageId
	 * @return string image page URL
	 */
	public static function getImagePage($wikiId, $pageId) {
		$app = F::app();
		wfProfileIn(__METHOD__);

		$title = GlobalTitle::newFromId($pageId, $wikiId);
		$imagePage = ($title instanceof Title) ? $title->getFullURL() : '';

		wfProfileOut(__METHOD__);
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
		foreach (array(self::FILE_DATA_COMMENT_OPION_NAME, self::FILE_DATA_DESC_OPION_NAME) as $option) {
			if (!isset($oImageData->$option)) {
				$oImageData->$option = $oImageData->name;
			}
		}

		$upload = F::build('UploadFromUrl');
		/* @var $upload UploadFromUrl */
		$upload->initializeFromRequest(F::build('FauxRequest', array($data, true)));
		$fetchStatus = $upload->fetchFile();

		if ($fetchStatus->isGood()) {
			$status = $upload->verifyUpload();

			if (isset($status['status']) && ($status['status'] == UploadBase::SUCCESS)) {
				$file = self::createImagePage($oImageData->name);
				/** @var $file WikiaLocalFile */
				$result = self::updateImageInfoInDb($file, $upload->getTempPath(), $oImageData, $user);
				/** @var $result */

				return self::buildStatus($result->ok, $file->getTitle()->getArticleID(), $result->errors);
			} else {
				$errorMsg = 'Upload verification faild ';
				$errorMsg .= (isset($status['status']) ? print_r($status, true) : '');

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
		$title = Title::newFromText($name, NS_FILE);
		/** @var $title Title */
		return F::build(
			'WikiaLocalFile',
			array(
				$title,
				RepoGroup::singleton()->getLocalRepo()
			)
		);
		/** @var $file WikiaLocalFile */
	}

	/**
	 * @param LocalFile $file
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

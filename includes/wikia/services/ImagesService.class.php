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

	public static function getImageOriginalUrl( $wikiId, $pageId ) {
		$app = F::app();

		$app->wf->ProfileIn(__METHOD__);

		$dbname = WikiFactory::IDtoDB($wikiId);

		$title = GlobalTitle::newFromId( $pageId, $wikiId );

		$param = array(
			'action' => 'query',
			'prop' => 'imageinfo',
			'iiprop' => 'url',
			'titles' => $title->getPrefixedText(),
		);

		$response = ApiService::foreignCall($dbname, $param);

		$app->wf->ProfileOut(__METHOD__);
		return array( 'src' => $imageSrc, 'page' => $imagePage );
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
	 * @desc Uploads an image on a wki
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
			'wpUploadFileURL' => $imageUrl
		);

		//validate of optional image data
		foreach( array(self::FILE_DATA_COMMENT_OPION_NAME, self::FILE_DATA_DESC_OPION_NAME) as $option ) {
			if( !isset($oImageData->$option) ) {
				$oImageData->$option = $oImageData->name;
			}
		}

		$upload = F::build('UploadFromUrl'); /* @var $upload UploadFromUrl */
		$upload->initializeFromRequest(F::build('FauxRequest', array($data, true)));
		$upload->fetchFile();
		$upload->verifyUpload();

		// create destination file
		$title = Title::newFromText($oImageData->name, NS_FILE);
		$file = F::build(
			'WikiaLocalFile',
			array(
				$title,
				RepoGroup::singleton()->getLocalRepo()
			)
		); /* @var $file WikiaLocalFile */

		/* real upload */
		$result = $file->upload(
			$upload->getTempPath(),
			$oImageData->comment,
			$oImageData->description,
			File::DELETE_SOURCE,
			false,
			false,
			$user
		);

		return array(
			'status' => $result->ok,
			'page_id' => $title->getArticleID(),
			'errors' => $result->errors,
		);
	}
}

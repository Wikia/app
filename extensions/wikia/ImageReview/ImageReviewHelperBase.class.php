<?php

abstract class ImageReviewHelperBase extends WikiaModel {
	const STATE_UNREVIEWED = 0;
	const STATE_IN_REVIEW = 1;
	const STATE_APPROVED = 2;
	const STATE_REJECTED = 4;
	const STATE_DELETED = 3;
	const STATE_QUESTIONABLE = 5;
	const STATE_QUESTIONABLE_IN_REVIEW = 6;

	const STATE_INVALID_IMAGE = 98;
	const STATE_ICO_IMAGE = 99;

	const FLAG_SUSPICOUS_USER = 2;
	const FLAG_SUSPICOUS_WIKI = 4;
	const FLAG_SKIN_DETECTED = 8;

	const ORDER_LATEST = 0;
	const ORDER_PRIORITY_LATEST = 1;
	const ORDER_OLDEST = 2;

	public abstract function updateImageState($images, $action = '');

	public abstract function resetAbandonedWork();

	public abstract function refetchImageListByTimestamp($timestamp);

	public abstract function getImageList($timestamp, $state = self::STATE_UNREVIEWED, $order = self::ORDER_LATEST);

	/**
	 * get image thumbnail
	 * @param integer wikiId
	 * @param integer pageId
	 * @return string imageUrl
	 */
	protected function getImageSrc($wikiId, $pageId, $imgSize = 250) {
		$this->wf->ProfileIn(__METHOD__);

		$dbname = WikiFactory::IDtoDB($wikiId);

		/* TODO: FOR TESTING ONLY: REMOVE BEFORE RELEASE */
		if(!empty($this->wg->DevelEnvironment)) {
			if($dbname == 'dehauptseite') {
				$dbname = 'de';
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

		$this->wf->ProfileOut(__METHOD__);
		return array('src' => $imageSrc, 'page' => $imagePage);
	}

	/**
	 * get image page url
	 * @param integer wikiId
	 * @param integer pageId
	 * @return string image page URL
	 */
	protected function getImagePage($wikiId, $pageId) {
		$this->wf->ProfileIn(__METHOD__);

		$title = GlobalTitle::newFromId($pageId, $wikiId);
		$imagePage = ($title instanceof Title) ? $title->getFullURL() : '';

		$this->wf->ProfileOut(__METHOD__);
		return $imagePage;
	}

	protected abstract function getWhitelistedWikis();

	protected abstract function getWhitelistedWikisFromWF();

	protected abstract function getTopWikis();

	public abstract function getImageCount();

	public abstract function getUserTsKey();

	protected function getOrder($order) {
		switch ($order) {
			case self::ORDER_PRIORITY_LATEST:
				$ret = 'priority desc, last_edited desc';
				break;
			case self::ORDER_OLDEST:
				$ret = 'last_edited asc';
				break;
			case self::ORDER_LATEST:
			default:
				$ret = 'last_edited desc';
		}
		return $ret;
	}
}

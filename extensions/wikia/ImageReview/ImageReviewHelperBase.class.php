<?php

abstract class ImageReviewHelperBase extends WikiaModel {
	const FLAG_SUSPICOUS_USER = 2;
	const FLAG_SUSPICOUS_WIKI = 4;
	const FLAG_SKIN_DETECTED = 8;

	const ORDER_LATEST = 0;
	const ORDER_PRIORITY_LATEST = 1;
	const ORDER_OLDEST = 2;

	/*
	 * LIMIT_IMAGES_FROM_DB should be a little greater than LIMIT_IMAGES, so if
	 * we fetch a few icons from DB, we can skip them
	 */
	const LIMIT_IMAGES = 20;
	const LIMIT_IMAGES_FROM_DB = 128;

	/**
	 * Define a size of a thumbnail
	 */
	const IMAGE_REVIEW_THUMBNAIL_SIZE = 250;

	/**
	 * Used in ImageReviewSpecial_index.php
	 * @var array
	 */
	static $sortOptions = array(
		'latest first' => 0,
		'by priority and recency' => 1,
		'oldest first' => 2,
	);

	public abstract function updateImageState($images, $action = '');

	public abstract function resetAbandonedWork();

	public abstract function refetchImageListByTimestamp($timestamp);

	public abstract function getImageList($timestamp, $state = ImageReviewStatuses::STATE_UNREVIEWED, $order = self::ORDER_LATEST);

	public abstract function getImageCount();

	public abstract function getUserTsKey();

	protected function getDatabaseHelper() {
		return new ImageReviewDatabaseHelper();
	}

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

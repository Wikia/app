<?php

/**
 * Base class for Hubs V2 module data providers
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

abstract class WikiaHubsV2ModuleDataProvider extends WikiaModel {
	/** TODO: remove after extracting */
	const GRID_0_5_MINIATURE_SIZE = 75;
	const GRID_1_MINIATURE_SIZE = 155;
	const GRID_2_MINIATURE_SIZE = 320;

	const FEATURED_VIDEO_WIDTH = 300;
	const FEATURED_VIDEO_HEIGHT = 225;

	const SPONSORED_IMAGE_WIDTH = 91;
	const SPONSORED_IMAGE_HEIGHT = 27;
	/** end remove after extracting */

	protected $lang;
	protected $date;
	protected $vertical;

	public function setLang($lang) {
		$this->lang = $lang;
	}

	public function getLang() {
		return $this->lang;
	}

	public function setDate($date) {
		$this->date = $date;
	}

	public function getDate() {
		return $this->date;
	}

	public function setVertical($vertical) {
		$this->vertical = $vertical;
	}

	public function getVertical() {
		return $this->vertical;
	}

	public abstract function getData();

	public abstract function storeData($data);


	// TODO: extract everything below
	protected function getStandardThumbnailUrl($imageName) {
		return $this->getThumbnailUrl($imageName, self::GRID_2_MINIATURE_SIZE);
	}

	protected function getSmallThumbnailUrl($imageName) {
		return $this->getThumbnailUrl($imageName, self::GRID_1_MINIATURE_SIZE);
	}

	protected function getMiniThumbnailUrl($imageName) {
		return $this->getThumbnailUrl($imageName, self::GRID_0_5_MINIATURE_SIZE);
	}

	/**
	 * @param string $imageName
	 *
	 * @return bool|Title
	 */
	protected function getImageTitle($imageName) {
		$title = F::build('Title', array($imageName, NS_FILE), 'newFromText');
		if (!($title instanceof Title)) {
			return false;
		}

		return $title;
	}

	/**
	 * @param Title $imageTitle Title instance of an image
	 *
	 * @return bool|File
	 */
	protected function getImageFile(Title $imageTitle) {
		$file = F::app()->wf->FindFile($imageTitle);
		if (!($file instanceof File)) {
			return false;
		}

		return $file;
	}

	/**
	 * @desc Returns false if failed or string with thumbnail url
	 *
	 * @param String $imageName image name
	 * @param Integer $width optional parameter
	 * @param Integer $height optional parameter
	 *
	 * @return bool|string
	 */
	protected function getThumbnailUrl($imageName, $width = -1, $height = -1) {
		$result = false;
		$this->imageThumb = null;

		$title = $this->getImageTitle($imageName);
		$file = $this->getImageFile($title);

		if ($file) {
			$width = ($width === -1) ? self::GRID_2_MINIATURE_SIZE : $width;

			$thumbParams = array('width' => $width, 'height' => $height);
			$this->imageThumb = $file->transform($thumbParams);

			$result = $this->imageThumb->getUrl();
		}

		return $result;
	}

	/**
	 * @return array
	 */
	protected function getImageThumbSize() {
		$result = array();

		if (!is_null($this->imageThumb)) {
			$result = array(
				'width' => $this->imageThumb->getWidth(),
				'height' => $this->imageThumb->getHeight(),
			);
		}

		return $result;
	}
}
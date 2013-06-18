<?php

/**
 * This class allows access to files from wikis different than the current one
 *
 * @author macbre
 */

class GlobalFile extends WikiaObject {

	private $mTitle;

	// local cache
	private $mData;
	private $url;
	private $uploadDir;

	public function __construct(GlobalTitle $title) {
		parent::__construct();

		$this->mTitle = $title;
	}

	/**
	 * Lazy-loads file meta data from another wiki
	 */
	private function loadData() {
		if (!isset($this->mData)) {
			$dbname = WikiFactory::IDtoDB($this->mTitle->mCityId);
			$dbr = wfGetDB( DB_SLAVE, array(), $dbname );

			$this->mData = $dbr->selectRow(
				'image',
				[
					'img_width',
					'img_height',
					'img_timestamp',
					'img_major_mime',
					'img_minor_mime'
				],
				['img_name' => $this->getName()],
				__METHOD__
			);
		}
	}

	/**
	 * Returns instance of GlobalFile for given file from given wiki
	 *
	 * @param string $title file name
	 * @param int $wikiId city ID
	 */
	static public function newFromText($title, $wikiId) {
		$title = GlobalTitle::newFromText($title, NS_FILE, $wikiId);
		return new self($title);
	}

	/**
	 * Returns instance of GlobalTitle for file page
	 *
	 * @return GlobalTitle
	 */
	public function getTitle() {
		return $this->mTitle;
	}

	/**
	 * Returns file name
	 *
	 * @return string file name
	 */
	public function getName() {
		return $this->mTitle->getText();
	}

	/**
	 * Returns true if file exists in the repository.
	 *
	 * @return boolean Whether file exists in the repository.
	 */
	public function exists() {
		$this->loadData();
		return !empty($this->mData);
	}

	private function getUploadDir() {
		if (!isset($this->uploadDir)) {
			$this->uploadDir = WikiFactory::getVarValueByName('wgUploadPath', $this->mTitle->mCityId);
		}

		return $this->uploadDir;
	}

	/**
	 * Gets path to original file
	 *
	 * @return string URL
	 */
	public function getUrl() {
		if ( !isset( $this->url ) ) {
			$this->url = $this->getUploadDir() . '/' . $this->getUrlRel();

			if (!empty($this->app->wg->DevelEnvironment)) {
				$this->url = wfReplaceImageServer( $this->url, $this->getTimestamp() );
			}
		}
		return $this->url;
	}

	public function getThumbUrl($suffix = false) {
		$path = $this->getUploadDir() . '/thumb/' . $this->getUrlRel();

		if ( $suffix !== false ) {
			$path .= '/' . rawurlencode( $suffix );
		}

		return $path;
	}

	/**
	 * Get the filename hash component of the directory including trailing slash,
	 * e.g. f/fa/
	 *
	 * @return string
	 */
	private function getHashPath() {
		$hash = md5($this->mTitle->getText());
		return "{$hash[0]}/{$hash[0]}{$hash[1]}/";
	}

	function getUrlRel() {
		return $this->getHashPath() . rawurlencode($this->getName());
	}

	/**
	 * @return int|null image width
	 */
	public function getWidth() {
		$this->loadData();
		return !empty($this->mData) ? intval($this->mData->img_width) : null;
	}

	/**
	 * @return int|null image height
	 */
	public function getHeight() {
		$this->loadData();
		return !empty($this->mData) ? intval($this->mData->img_height) : null;
	}

	/**
	 * @return string|null image timestamp
	 */
	public function getTimestamp() {
		$this->loadData();
		return !empty($this->mData) ? $this->mData->img_timestamp : null;
	}

	/**
	 * @return null|string file MIME type
	 */
	public function getMimeType() {
		$this->loadData();
		return !empty($this->mData) ? "{$this->mData->img_major_mime}/{$this->mData->img_minor_mime}" : null;
	}

	/**
	 * Returns URL to cropped image
	 *
	 * Uses ImageServing cropping functionality
	 *
	 * @param int $width requsted width
	 * @param int $height requsted height
	 * @return string URL
	 */
	public function getCrop( $width, $height ) {
		$imageServing = new ImageServing(null, $width, $height);
		return $imageServing->getUrl($this, $this->getWidth(), $this->getHeight());
	}
}

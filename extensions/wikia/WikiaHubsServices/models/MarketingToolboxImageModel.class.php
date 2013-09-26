<?php
class MarketingToolboxImageModel extends WikiaModel {
	protected $fileName;

	public function __construct($fileName) {
		$this->setFileName($fileName);
	}
	
	public function setFileName($name) {
		return $this->fileName = $name;
	}

	public function getFileName() {
		return $this->fileName;
	}

	/**
	 * @param integer $destImageWidth
	 * @return stdClass (simple stdObject with fields: title, url, width and height)
	 */
	public function getImageThumbData($destImageWidth = 0) {
		return ImagesService::getLocalFileThumbUrlAndSizes($this->getFileName(), $destImageWidth, ImagesService::EXT_JPG);
	}
}

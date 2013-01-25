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
	
	public function getImageData($destImageWidth) {
		return ImagesService::getLocalFileThumbUrlAndSizes($this->getFileName(), $destImageWidth);
	}
}

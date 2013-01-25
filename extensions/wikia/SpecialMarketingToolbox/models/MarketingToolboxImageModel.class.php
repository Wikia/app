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
	 * @return stdClass (simple stdObject with fields: url, width and height)
	 */
	public function getImageData($destImageWidth) {
		$tmpData = ImagesService::getLocalFileThumbUrlAndSizes($this->getFileName(), $destImageWidth);
		
		$data = new stdClass();
		$data->url = $tmpData->url;
		
		//if the file is not found in repo with equals string with the title that's why intval() here
		$data->width = intval($tmpData->width);
		$data->height = intval($tmpData->height);
		
		return $data;
	}
}

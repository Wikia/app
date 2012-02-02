<?php

class RealgravityApiWrapper extends WikiaVideoApiWrapper {

	public function getTitle() {
		return $this->videoName;
	}

	public function getDescription() {
		if (!empty($this->interfaceObj[3])) {
			return $this->interfaceObj[3];
		}
		return '';
	}

	public function getThumbnailUrl() {
		//echo "<pre>"; print_r($this->interfaceObj); die;
		if (!empty($this->interfaceObj[1])) {
			return $this->interfaceObj[1];
		}
		return '';
	}

	protected function getVideoDuration() {
		if (!empty($this->interfaceObj[2])) {
			return $this->interfaceObj[2];
		}
		return '';
	}

	protected function getAspectRatio() {
		$ratio = '';
		if (!empty($this->interfaceObj[0])) {
			list($width, $height) = explode('x', $this->interfaceObj[0]);
			$ratio = $width / $height;
		}
		return $ratio;
	}

}
<?php

class RealgravityApiWrapper extends WikiaVideoApiWrapper {

	const DEFAULT_VET_WIDTH = 350;  // defined in VideoEmbedTool_setup.php, but that extension may not be enabled!
	const REALGRAVITY_PLAYER_AUTOSTART_ID = 'ac330d90-cb46-012e-f91c-12313d18e962';
	const REALGRAVITY_PLAYER_NO_AUTOSTART_ID = '63541030-a4fd-012e-7c44-1231391272da';
	const REALGRAVITY_PLAYER_VIDEOEMBEDTOOL_ID = '49321a60-d897-012e-f9bf-12313d18e962';

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
<?php
class WikiaHubsWAMModel extends WikiaModel {
	const IMAGE_WIDTH = 48;
	const IMAGE_HEIGHT = 30;
	const WAM_LIMIT_FOR_HUB_PAGE = 5;
	
	public function getWamLimitForHubPage() {
		return self::WAM_LIMIT_FOR_HUB_PAGE;
	}
	
	public function getImageWidth() {
		return self::IMAGE_WIDTH;
	}

	public function getImageHeight() {
		return self::IMAGE_HEIGHT;
	}
}

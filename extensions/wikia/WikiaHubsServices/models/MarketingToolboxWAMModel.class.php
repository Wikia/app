<?php
class MarketingToolboxWAMModel extends WikiaModel {
	const WAM_LIMIT_FOR_HUB_PAGE = 5;
	
	public function getWamLimitForHubPage() {
		return self::WAM_LIMIT_FOR_HUB_PAGE;
	}
}

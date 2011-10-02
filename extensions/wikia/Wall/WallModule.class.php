<?php
class WallModule extends ArticleCommentsModule {
	public function executeIndex() {
		wfProfileIn(__METHOD__);
		
		$this->getCommentsData();
		
		wfProfileOut(__METHOD__);
	}	
}


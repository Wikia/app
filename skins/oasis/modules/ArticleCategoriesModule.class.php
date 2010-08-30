<?php
class ArticleCategoriesModule extends Module {

	var $categories;
	var $categoriesLink;

	public function executeIndex() {
		wfProfileIn(__METHOD__);

		global $wgOut;

		// get list of categories for current article
		$this->categories = $wgOut->getCategoryLinks();

		if (!empty($this->categories['normal'])) {
			$this->categories = $this->categories['normal'];
		}
		else {
			$this->categories = array();
		}

		// render "Categories:" link
		$msg = wfMsgExt('pagecategories', array('parsemag'), count($this->categories));
		$this->categoriesLink = View::link(Title::newFromText(wfMsgForContent('pagecategorieslink')), $msg);

		wfProfileOut(__METHOD__);
	}
}
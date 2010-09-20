<?php
/**
 * Renders categories box below the article
 *
 * @author Maciej Brencz
 */

class ArticleCategoriesModule extends Module {
	var $catlinks;
	
	var $wgSingleH1;
	
	public function executeIndex() {
		wfProfileIn(__METHOD__);

		global $wgSingleH1;

		wfProfileOut(__METHOD__);
	}
}
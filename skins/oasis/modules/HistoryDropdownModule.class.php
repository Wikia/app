<?php
/**
 * Renders history dropdown
 *
 * @author Maciej Brencz
 */

class HistoryDropdownModule extends Module {

	var $wgBlankImgUrl;

	var $content_actions;

	var $revisions;

	/**
	 * Render history dropdown
	 */
	public function executeIndex($data) {
		wfProfileIn(__METHOD__);

		if (!empty($data['revisions'])) {
			$this->revisions = $data['revisions'];
		}

		wfProfileOut(__METHOD__);
	}
}
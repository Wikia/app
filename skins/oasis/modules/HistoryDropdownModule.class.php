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

	/**
	 * Fetch history dropdown HTML for five previous edits (before the current revision)
	 */
	public function executePreviousEdits() {
		global $wgTitle;

		// use service to get data
		$service = new PageStatsService($wgTitle->getArticleId());

		$this->revisions = $service->getPreviousEdits();

		if (is_array($this->revisions)) {
			foreach($this->revisions as &$revision) {
				if (isset($revision['user'])) {
					$revision['avatarUrl'] = AvatarService::getAvatarUrl($revision['user']);
					$revision['link'] = AvatarService::renderLink($revision['user']);
				}
			}
		}
	}
}
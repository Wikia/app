<?php
/**
 * ReplaceTextTask
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */
 use Wikia\Tasks\Tasks\BaseTask;

class ReplaceTextTask extends BaseTask {
	public function move($params) {
		global $wgUser;

		$currentUser = $wgUser;
		$wgUser = User::newFromId($this->createdBy);
		$currentPageName = $this->title->getText();

		if ($params['use_regex']) {
			$newPageName = preg_replace("/{$params['target_str']}/U", $params['replacement_str'], $currentPageName);
		} else {
			$newPageName = str_replace($params['target_str'], $params['replacement_str'], $currentPageName);
		}

		$newTitle = Title::newFromText($newPageName, $this->title->getNamespace());
		$result = $this->title->moveTo($newTitle, true, $params['edit_summary'], $params['create_redirect']);

		if ($result == true && $params['watch_page']) {
			WatchAction::doWatch($newTitle, $wgUser);
		}

		$wgUser = $currentUser;
		return $result;
	}

	public function replace($params) {
		$message = '"replace" is unimplemented because Wikia stores references to external resources in the "text" database';
		throw new \Exception($message);
	}
}
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
		$message = '"replace" is unimplemented because Wikia stores references to external resources '.
			'in the "text" database, rather than the actual revision text.';
		throw new \Exception($message);

		// if the above ever changes, we have to migrate over the following code
		/*
		 $article = new Article( $this->title, 0 );
			if ( !$article ) {
				$this->error = 'replaceText: Article not found "' . $this->title->getPrefixedDBkey() . '"';
				wfProfileOut( __METHOD__ );
				return false;
			}

			wfProfileIn( __METHOD__ . '-replace' );
			$article_text = $article->fetchContent();
			$target_str = $this->params['target_str'];
			$replacement_str = $this->params['replacement_str'];
			$num_matches;

			if ( $this->params['use_regex'] ) {
				$new_text = preg_replace( '/'.$target_str.'/U', $replacement_str, $article_text, -1, $num_matches );
			} else {
				$new_text = str_replace( $target_str, $replacement_str, $article_text, $num_matches );
			}

			// if there's at least one replacement, modify the page,
			// using the passed-in edit summary
			if ( $num_matches > 0 ) {
				// change global $wgUser variable to the one
				// specified by the job only for the extent of
				// this replacement
				global $wgUser;
				$actual_user = $wgUser;
				$wgUser = User::newFromId( $this->params['user_id'] );
				$edit_summary = $this->params['edit_summary'];
				$flags = EDIT_MINOR;
				if ( $wgUser->isAllowed( 'bot' ) )
					$flags |= EDIT_FORCE_BOT;
				$article->doEdit( $new_text, $edit_summary, $flags );
				$wgUser = $actual_user;
		 */
	}
}

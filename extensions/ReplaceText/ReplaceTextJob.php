<?php

/**
 * Background job to replace text in a given page
 * - based on /includes/RefreshLinksJob.php
 *
 * @author Yaron Koren
 */
class ReplaceTextJob extends Job {

	function __construct( $title, $params = '', $id = 0 ) {
		parent::__construct( 'replaceText', $title, $params, $id );
	}

	/**
	 * Run a replaceText job
	 * @return boolean success
	 */
	function run() {
		wfProfileIn( __METHOD__ );

		if ( is_null( $this->title ) ) {
			$this->error = "replaceText: Invalid title";
			wfProfileOut( __METHOD__ );
			return false;
		}

		$article = new Article($this->title);
		if ( !$article ) {
			$this->error = 'replaceText: Article not found "' . $this->title->getPrefixedDBkey() . '"';
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileIn( __METHOD__.'-replace' );
		$article_text = $article->fetchContent();
		$target_str = $this->params['target_str'];
		$replacement_str = $this->params['replacement_str'];
		$num_matches;
		$new_text = str_replace($target_str, $replacement_str, $article_text, $num_matches);
		// if there's at least one replacement, modify the page,
		// using the passed-in edit summary
		if ($num_matches > 0) {
			global $wgUser;
			$wgUser = User::newFromId($this->params['user_id']);
			$edit_summary = $this->params['edit_summary'];
			$flags = EDIT_MINOR;
			$article->doEdit($new_text, $edit_summary, $flags);
		}
		wfProfileOut( __METHOD__.'-replace' );
		wfProfileOut( __METHOD__ );
		return true;
	}
}


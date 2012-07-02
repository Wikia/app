<?php

/**
 * Background job to replace text in a given page
 * - based on /includes/RefreshLinksJob.php
 *
 * @author Yaron Koren
 * @author Ankit Garg
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

		if ( array_key_exists( 'move_page', $this->params ) ) {
			global $wgUser;
			$actual_user = $wgUser;
			$wgUser = User::newFromId( $this->params['user_id'] );
			$cur_page_name = $this->title->getText();
			if ( $this->params['use_regex'] ) {
				$new_page_name = preg_replace( "/".$this->params['target_str']."/U", $this->params['replacement_str'], $cur_page_name );
			} else {
				$new_page_name = str_replace( $this->params['target_str'], $this->params['replacement_str'], $cur_page_name );
			}

			$new_title = Title::newFromText( $new_page_name, $this->title->getNamespace() );
			$reason = $this->params['edit_summary'];
			$create_redirect = $this->params['create_redirect'];
			$this->title->moveTo( $new_title, true, $reason, $create_redirect );
			if ( $this->params['watch_page'] ) {
				if ( class_exists( 'WatchAction' ) ) {
					// Class was added in MW 1.19
					WatchAction::doWatch( $new_title, $wgUser );
				} elseif ( class_exists( 'Action' ) ) {
					// Class was added in MW 1.18
					Action::factory( 'watch', new Article( $new_title, 0 ) )->execute();
				} else {
					$article = new Article( $new_title, 0 );
					$article->doWatch();
				}
			}
			$wgUser = $actual_user;
		} else {
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
			}
			wfProfileOut( __METHOD__ . '-replace' );
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
}

<?php

/**
 * Background job to create a new page, for use by the 'CreateClass' special page
 *
 * @author Yaron Koren
 */
class SFCreatePageJob extends Job {

	function __construct( $title, $params = '', $id = 0 ) {
		parent::__construct( 'createPage', $title, $params, $id );
	}

	/**
	 * Run a createPage job
	 * @return boolean success
	 */
	function run() {
		wfProfileIn( __METHOD__ );

		if ( is_null( $this->title ) ) {
			$this->error = "createPage: Invalid title";
			wfProfileOut( __METHOD__ );
			return false;
		}
                $article = new Article( $this->title );
                if ( !$article ) {
                        $this->error = 'createPage: Article not found "' . $this->title->getPrefixedDBkey() . '"';
                        wfProfileOut( __METHOD__ );
                        return false;
                }

		$page_text = $this->params['page_text'];
		// change global $wgUser variable to the one
		// specified by the job only for the extent of this
		// replacement
		global $wgUser;
		$actual_user = $wgUser;
		$wgUser = User::newFromId( $this->params['user_id'] );
		$edit_summary = ''; // $this->params['edit_summary'];
		$article->doEdit( $page_text, $edit_summary );
		$wgUser = $actual_user;
		wfProfileOut( __METHOD__ );
		return true;
	}
}


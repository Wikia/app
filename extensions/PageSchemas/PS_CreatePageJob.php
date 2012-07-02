<?php

/**
 * Background job to create a new property page,
 *
 * @author Ankit Garg
 */
class PSCreatePageJob extends Job {

	function __construct( $title, $params = '', $id = 0 ) {
		parent::__construct( 'pageSchemasCreatePage', $title, $params, $id );
	}

	/**
	 * Run a pageSchemasCreatePage job
	 * @return boolean success
	 */
	function run() {
		wfProfileIn( __METHOD__ );

		if ( is_null( $this->title ) ) {
			$this->error = "pageSchemasCreatePage: Invalid title";
			wfProfileOut( __METHOD__ );
			return false;
		}
		$article = new Article( $this->title );
		if ( !$article ) {
			$this->error = 'pageSchemasCreatePage: Article not found "' . $this->title->getPrefixedDBkey() . '"';
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
		$edit_summary = wfMsgForContent( 'ps-generatepages-editsummary' );
		$article->doEdit( $page_text, $edit_summary );
		$wgUser = $actual_user;
		wfProfileOut( __METHOD__ );
		return true;
	}
}


<?php
/**
 *
 * @file
 * @ingroup SF
 */

/**
 * Background job to create a new page, for use by the 'CreateClass' special
 * page.
 *
 * @author Yaron Koren
 * @ingroup SF
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
		if ( is_null( $this->title ) ) {
			$this->error = "createPage: Invalid title";
			return false;
		}
		$article = new Article( $this->title, 0 );
		if ( !$article ) {
			$this->error = 'createPage: Article not found "' . $this->title->getPrefixedDBkey() . '"';
			return false;
		}

		$page_text = $this->params['page_text'];
		// change global $wgUser variable to the one
		// specified by the job only for the extent of this
		// replacement
		global $wgUser;
		$actual_user = $wgUser;
		$wgUser = User::newFromId( $this->params['user_id'] );
		$edit_summary = '';
		if( array_key_exists( 'edit_summary', $this->params ) ) {
			$edit_summary = $this->params['edit_summary'];
		}
		$article->doEdit( $page_text, $edit_summary );
		$wgUser = $actual_user;

		return true;
	}
}


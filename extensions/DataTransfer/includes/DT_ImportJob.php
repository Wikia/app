<?php

/**
 * Background job to import a page into the wiki, for use by Data Transfer
 *
 * @author Yaron Koren
 */
class DTImportJob extends Job {

	function __construct( $title, $params = '', $id = 0 ) {
		parent::__construct( 'dtImport', $title, $params, $id );
	}

	/**
	 * Run a dtImport job
	 * @return boolean success
	 */
	function run() {
		wfProfileIn( __METHOD__ );

		if ( is_null( $this->title ) ) {
			$this->error = "dtImport: Invalid title";
			wfProfileOut( __METHOD__ );
			return false;
		}

		$article = new Article( $this->title );
		if ( !$article ) {
			$this->error = 'dtImport: Article not found "' . $this->title->getPrefixedDBkey() . '"';
			wfProfileOut( __METHOD__ );
			return false;
		}
		$for_pages_that_exist = $this->params['for_pages_that_exist'];
		if ( $for_pages_that_exist == 'skip' && $this->title->exists() ) {
			return true;
		}

		// change global $wgUser variable to the one specified by
		// the job only for the extent of this import
		global $wgUser;
		$actual_user = $wgUser;
		$wgUser = User::newFromId( $this->params['user_id'] );
		$text = $this->params['text'];
		if ( $for_pages_that_exist == 'append' && $this->title->exists() ) {
			$text = $article->getContent() . "\n" . $text;
		}
		$edit_summary = $this->params['edit_summary'];
		$article->doEdit( $text, $edit_summary );
		$wgUser = $actual_user;
		wfProfileOut( __METHOD__ );
		return true;
	}
}

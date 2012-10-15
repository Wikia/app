<?php

class SpecialNewCommentsOnlyQuestion extends UnlistedSpecialPage {

	function __construct() {
		parent::__construct( "NewCommentsOnlyQuestion" );
	}

	function execute( $question ) {
		global $wgRequest, $wgOut, $wgUser;

		if( wfReadOnly() || !$wgUser->isAllowed('edit') || $wgUser->isBlocked() ) {
			return false;
		}

		if( empty( $question ) ) {
			$question = $wgRequest->getVal("question");
		}

		if( empty( $question ) ) {
			return true;
		}

		$title = Title::makeTitleSafe( NS_FORUM, $question );
		if( !$title ) {
			return false;
		}

		$article = new Article( $title );
		$article->doEdit( '[[Category:Forums]]', '', EDIT_NEW );

		$wgOut->redirect( $title->getLocalURL() );

		return true;
	}

}

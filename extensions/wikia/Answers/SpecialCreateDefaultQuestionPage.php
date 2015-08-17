<?php
class CreateQuestionPage extends UnlistedSpecialPage {

	function __construct(){
		parent::__construct("CreateQuestionPage");
	}

	function execute( $question ){
		global $wgRequest, $wgOut, $wgUser;

                if ( wfReadOnly() ) {
                        return false;
                }

                //don't allow blocked users to ask questions, duh
                if( $wgUser->isBlocked() ){
					throw new UserBlockedError( $wgUser->getBlock() );
                }

                if( !$wgUser->isAllowed( 'edit' ) ){
                        return false;
                }

		if( empty( $question ) ) {
			$question = $wgRequest->getVal("questiontitle");
		}

		if( empty( $question ) ) {
			return true;
		}

		$q = new DefaultQuestion( $question );

		if ( !is_object( $q ) ) {
			return false;
		}

		if ( is_object($q->title) && $q->title->exists() ) {
			$wgOut->redirect( $q->title->getFullURL() );
			return false;
		}

		if ( $q->searchTest() ) {
			$wgOut->redirect( SpecialPage::getTitleFor( 'Search' )->getFullURL("search=" . $q->question . "&fulltext=Search") );
			return false;
		}

		$res = $q->create();

		if ( $res ) {
			$wgOut->redirect( $q->title->getFullURL("state=asked") );
		} else {
			$wgOut->redirect( Title::makeTitle( NS_MAIN, wfMsgForContent("question_redirected_help_page") )->getFullURL() );
		}

		return false;
	}
}

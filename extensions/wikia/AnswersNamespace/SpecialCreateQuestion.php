<?php

class SpecialCreateQuestion extends UnlistedSpecialPage {

	function __construct(){
		parent::__construct("CreateQuestion");
	}

	function execute( $question ) {
		global $wgRequest, $wgOut, $wgUser;

		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
                        return false;
                }

                if( $wgUser->isBlocked() ){
                        $wgOut->blockedPage( false );
                        return false;
                }

                if( !$wgUser->isAllowed( 'ask-questions' ) ){
			$wgOut->loginToUse();
                        return false;
                }

		if( empty( $question ) ) {
			$question = $wgRequest->getVal("question");
		}

		if( empty( $question ) ) {
			$wgOut->setArticleRelated( false );
			$wgOut->setRobotPolicy( 'noindex,nofollow' );
			$wgOut->setStatusCode( 404 );
			$wgOut->showErrorPage( 'nosuchspecialpage', 'nospecialpagetext' );
			return false;
		}

		$q = new Question( $question );

		if( !is_object( $q ) ) {
			return false;
		}

		if( is_object($q->getTitle()) && $q->getTitle()->exists() ) {
			$wgOut->redirect( $q->getTitle()->getFullURL() );
			return false;
		}

		if ( $q->searchTest() ) {
			$wgOut->redirect( SpecialPage::getTitleFor( 'Search' )->getFullURL("search=" . $q->getQuestion() . "&ns".NS_QUESTION."=1&fulltext=Search") );
			return false;
		}

		$res = $q->create();

		if ( $res ) {
			$wgOut->redirect( $q->getTitle()->getFullURL("state=asked") );
		} else {
			//$wgOut->redirect( Title::makeTitle( NS_MAIN, wfMsgForContent("question_redirected_help_page") )->getFullURL() );
		}

		return false;
	}

}

<?php
class CreateQuestionPage extends UnlistedSpecialPage {

	const QS_KEY_QUESTION = 'questiontitle';

	function __construct(){
		parent::__construct("CreateQuestionPage");
	}

	function execute( $question ) {
		if ( $this->getRequest()->wasPosted() ) {
			$this->createQuestion();
			return;
		}

		if ( !empty( $question ) ) {
			$this->redirectToHelpPage();
		}
	}

	private function createQuestion() {
		if ( !$this->getUser()->matchEditToken( $this->getRequest()->getVal( 'token' ) ) ) {
			throw new Exception( wfMessage( 'sessionfailure' )->escaped() );
		}

		if ( wfReadOnly() ) {
			return;
		}

		//don't allow blocked users to ask questions, duh
		if ( $this->getUser()->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->getBlock() );
		}

		if ( !$this->getUser()->isAllowed( 'edit' ) ) {
			return;
		}

		$question = $this->getRequest()->getVal( self::QS_KEY_QUESTION, false );
		if ( !$question ) {
			return;
		}

		$q = new DefaultQuestion( $question );

		if ( !is_object( $q ) ) {
			return;
		}

		if ( is_object( $q->title ) && $q->title->exists() ) {
			$this->getOutput()->redirect( $q->title->getFullURL() );
			return;
		}

		if ( $q->searchTest() ) {
			$this->redirectToSearchPage( $q );
			return;
		}

		$res = $q->create();

		if ( $res ) {
			$this->getOutput()->redirect( $q->title->getFullURL( "state=asked" ) );
		} else {
			$this->redirectToHelpPage();
		}
	}

	private function redirectToHelpPage() {
		$this->getOutput()->redirect(
			Title::makeTitle(
				NS_MAIN, wfMessage( 'question_redirected_help_page' )->inContentLanguage()->text()
			)->getFullURL()
		);
	}

	private function redirectToSearchPage( DefaultQuestion $defaultQuestion) {
		$this->getOutput()->redirect(
			SpecialPage::getTitleFor( 'Search' )->getFullURL(
				"search=" . $defaultQuestion->question . "&fulltext=Search" ) );
	}
}

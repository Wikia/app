<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class SpecialNewMessages extends SpecialPage {
	private $user, $output, $request, $title;

	function __construct() {
		SpecialPage::SpecialPage( 'Newmessages' );
		$this->includable( true );
	}

	/**
	* @see SpecialPage::getDescription
	*/
	function getDescription() {
		wfLoadExtensionMessages( 'LiquidThreads' );
		return wfMsg( 'lqt_newmessages' );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest, $wgTitle, $wgUser;
		wfLoadExtensionMessages( 'LiquidThreads' );
		$this->user = $wgUser;
		$this->output = $wgOut;
		$this->request = $wgRequest;
		$this->title = $wgTitle;

		$this->setHeaders();

		$view = new NewUserMessagesView( $this->output, new Article( $this->title ),
			$this->title, $this->user, $this->request );

		$view->showOnce(); // handles POST etc.

		$first_set = NewMessages::newUserMessages( $this->user );
		$second_set = NewMessages::watchedThreadsForUser( $this->user );
		$both_sets = array_merge( $first_set, $second_set );
		if ( count( $both_sets ) == 0 ) {
			$wgOut->addWikitext( wfMsg( 'lqt-no-new-messages' ) );
			return;
		}
		$view->showReadAllButton( $both_sets ); // ugly hack.

		$view->setHeaderLevel( 3 );

		$this->output->addHTML( '<h2 class="lqt_newmessages_section">' . wfMsg ( 'lqt-messages-sent' ) . '</h2>' );
		$view->setThreads( $first_set );
		$view->show();

		$this->output->addHTML( '<h2 class="lqt_newmessages_section">' . wfMsg ( 'lqt-other-messages' ) . '</h2>' );
		$view->setThreads( $second_set );
		$view->show();
	}
}

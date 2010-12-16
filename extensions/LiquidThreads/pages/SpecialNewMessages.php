<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class SpecialNewMessages extends SpecialPage {
	private $user, $output, $request, $title;

	function __construct() {
		SpecialPage::SpecialPage( 'NewMessages' );
		$this->includable( true );
	}

	/**
	* @see SpecialPage::getDescription
	*/
	function getDescription() {
		wfLoadExtensionMessages( 'LiquidThreads' );
		return wfMsg( 'lqt_newmessages-title' );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest, $wgUser;
		wfLoadExtensionMessages( 'LiquidThreads' );
		$this->user = $wgUser;
		$this->output = $wgOut;
		$this->request = $wgRequest;

		$this->setHeaders();

		$article = new Article( $this->getTitle() );
		$title = $this->getTitle();

		// Clear newtalk
		$this->user->setNewtalk( false );

		$view = new NewUserMessagesView( $this->output, $article,
			$title, $this->user, $this->request );

		if ( $this->request->getBool( 'lqt_inline' ) ) {
			$view->doInlineEditForm();
			return;
		}

		$view->showOnce(); // handles POST etc.

		$first_set = NewMessages::newUserMessages( $this->user );
		$second_set = NewMessages::watchedThreadsForUser( $this->user );
		$both_sets = array_merge( $first_set, $second_set );
		if ( count( $both_sets ) == 0 ) {
			$wgOut->addWikitext( wfMsg( 'lqt-no-new-messages' ) );
			return;
		}

		$html = '';

		$html .= $view->getReadAllButton( $both_sets );

		$view->setHeaderLevel( 3 );

		$html .= Xml::tags(
			'h2',
			array( 'class' => 'lqt_newmessages_section' ),
			wfMsgExt( 'lqt-messages-sent', 'parseinline' )
		);
		$wgOut->addHTML( $html );
		$view->setThreads( $first_set );
		$view->show();

		$wgOut->addHTML( Xml::tags(
			'h2',
			array( 'class' => 'lqt_newmessages_section' ),
			wfMsgExt( 'lqt-other-messages', 'parseinline' )
		) );
		$view->setThreads( $second_set );
		$view->show();
	}
}

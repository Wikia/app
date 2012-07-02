<?php

class SpecialNewMessages extends SpecialPage {
	private $user, $output, $request;

	function __construct() {
		parent::__construct( 'NewMessages' );
		$this->mIncludable = true;
	}

	/**
	 * @see SpecialPage::getDescription
	 */
	function getDescription() {
		return wfMsg( 'lqt_newmessages-title' );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest, $wgUser;
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

		$view->show();
	}
}

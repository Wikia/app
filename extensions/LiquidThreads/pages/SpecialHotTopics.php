<?php
class SpecialHotTopics extends SpecialPage {
	function __construct() {
		parent::__construct( 'HotTopics' );
	}

	function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest;

		$this->setHeaders();

		$wgOut->setPageTitle( wfMsg( 'lqt-hot-topics' ) );
		$title = $this->getTitle();
		$view = new LqtView( $wgOut, new Article( $title ), $title, $wgUser, $wgRequest );

		// Get hot topics
		$topics = LqtHotTopicsController::getHotThreads();

		foreach ( $topics as $thread ) {
			$view->showThread( $thread );
		}
	}

	function getPageName() {
		return wfMsg( 'lqt-hot-topics' );
	}
}

<?php
class SpecialHotTopics extends SpecialPage {
	function __construct() {
		parent::__construct( 'HotTopics' );
	}

	function execute( $par ) {
		global $wgOut;

		wfLoadExtensionMessages( 'LiquidThreads' );

		$this->setHeaders();

		$wgOut->setPageTitle( wfMsg( 'lqt-hot-topics' ) );
		$view = LqtView::getView();

		LqtView::addJsAndCss();

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

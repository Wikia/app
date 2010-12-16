<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

class SpecialDeleteQueue extends SpecialPage {
	function __construct() {
		parent::__construct( 'DeleteQueue' );
	}

	function execute( $subpage ) {
		$params = explode( '/', $subpage );

		wfLoadExtensionMessages( 'DeleteQueue' );

		global $wgOut, $wgScriptPath, $wgDeleteQueueStyleVersion;
		$wgOut->addExtensionStyle(
				"$wgScriptPath/extensions/DeleteQueue/deletequeue.css?"
					. $wgDeleteQueueStyleVersion
			);

		// Default
		$viewName = 'DeleteQueueViewList';

		if ( !count( $params ) ) {
			// Default
		} elseif ( $params[0] == 'nominate' && count( $params ) == 3 ) {
			$viewName = 'DeleteQueueViewNominate';
		} elseif ( $params[0] == 'vote' && count( $params ) == 2 ) {
			$viewName = 'DeleteQueueViewVote';
		} elseif ( $params[0] == 'case' && count( $params ) == 2 ) {
			$viewName = 'DeleteQueueViewCase';
		} elseif ( $params[0] == 'case' &&
				count( $params ) == 3 &&
				$params[2] = 'review'
		) {
			$viewName = 'DeleteQueueViewReview';
		}

		$view = new $viewName( $this );
		$view->show( $params );
	}
}

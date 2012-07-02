<?php
/**
 * If wfCommentList in Comments_AjaxFunctions.php would work properly, this
 * silly little special page wouldn't be needed at all. But alas, it doesn't.
 * @file
 * @ingroup Extensions
 */
class CommentListGet extends UnlistedSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'CommentListGet' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgRequest;

		$output = ''; // Prevent E_NOTICE

		// Get new Comment list
		$pid = $wgRequest->getInt( 'pid' );
		$shwform = $wgRequest->getVal( 'shwform' );
		if( $pid ) {
			$comment = new Comment( $pid );
			$comment->setOrderBy( $wgRequest->getInt( 'ord' ) );
			if( $shwform && $shwform == 1 ) {
				$output .= $comment->displayOrderForm(); // misza: added isset check
			}
			$output .= $comment->display();
			if( $shwform && $shwform == 1 ) {
				$output .= $comment->displayForm(); // misza: added isset check
			}
		}
		$wgOut->addHTML( $output );
		$wgOut->setArticleBodyOnly( true );
	}
}
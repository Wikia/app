<?php
/**
 * A special page for displaying the list of users whose comments you're
 * ignoring.
 * @file
 * @ingroup Extensions
 */
class CommentIgnoreList extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'CommentIgnoreList' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest;

		$user_name = $wgRequest->getVal( 'user' );

		/**
		 * Redirect anonymous users to Login Page
		 * It will automatically return them to the CommentIgnoreList page
		 */
		if( $wgUser->getID() == 0 && $user_name == '' ) {
			$loginPage = SpecialPage::getTitleFor( 'Userlogin' );
			$wgOut->redirect( $loginPage->getLocalURL( 'returnto=Special:CommentIgnoreList' ) );
			return false;
		}

		$wgOut->setPageTitle( wfMsg( 'comment-ignore-title' ) );

		$out = ''; // Prevent E_NOTICE

		if( $user_name == '' ) {
			$out .= $this->displayCommentBlockList();
		} else {
			if( $wgRequest->wasPosted() ) {
				$user_name = htmlspecialchars_decode( $user_name );
				$user_id = User::idFromName( $user_name );
				// Anons can be comment-blocked, but idFromName returns nothing
				// for an anon, so...
				if ( !$user_id ) {
					$user_id = 0;
				}
				$c = new Comment( 0 );
				$c->deleteBlock( $wgUser->getID(), $user_id );
				if( $user_id && class_exists( 'UserStatsTrack' ) ) {
					$stats = new UserStatsTrack( $user_id, $user_name );
					$stats->decStatField( 'comment_ignored' );
				}
				$out .= $this->displayCommentBlockList();
			} else {
				$out .= $this->confirmCommentBlockDelete();
			}
		}

		$wgOut->addHTML( $out );
	}

	/**
	 * Displays the list of users whose comments you're ignoring.
	 * @return HTML
	 */
	function displayCommentBlockList() {
		global $wgUser;

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'Comments_block',
			array( 'cb_user_name_blocked', 'cb_date' ),
			array( 'cb_user_id' => $wgUser->getID() ),
			__METHOD__,
			array( 'ORDER BY' => 'cb_user_name' )
		);

		if( $dbr->numRows( $res ) > 0 ) {
			$out = '<ul>';
			foreach( $res as $row ) {
				$user_title = Title::makeTitle( NS_USER, $row->cb_user_name_blocked );
				$out .= '<li>' . wfMsg(
					'comment-ignore-item',
					$user_title->escapeFullURL(),
					$user_title->getText(),
					$row->cb_date,
					$this->getTitle()->escapeFullURL( 'user=' . $user_title->getText() )
				) . '</li>';
			}
			$out .= '</ul>';
		} else {
			$out = '<div class="comment_blocked_user">' .
				wfMsg( 'comment-ignore-no-users' ) . '</div>';
		}
		return $out;
	}

	/**
	 * Asks for a confirmation when you're about to unblock someone's comments.
	 * @return HTML
	 */
	function confirmCommentBlockDelete() {
		global $wgRequest;

		$user_name = $wgRequest->getVal( 'user' );

		$out = '<div class="comment_blocked_user">' .
				wfMsg( 'comment-ignore-remove-message', $user_name ) .
			'</div>
			<div>
				<form action="" method="post" name="comment_block">' .
					Html::hidden( 'user', $user_name ) .
					'<input type="button" class="site-button" value="' . wfMsg( 'comment-ignore-unblock' ) . '" onclick="document.comment_block.submit()" />
					<input type="button" class="site-button" value="' . wfMsg( 'comment-ignore-cancel' ) . '" onclick="history.go(-1)" />
				</form>
			</div>';
		return $out;
	}
}
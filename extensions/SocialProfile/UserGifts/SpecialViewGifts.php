<?php
/**
 * Special:ViewGifts -- a special page for viewing the list of user-to-user
 * gifts a given user has received
 *
 * @file
 * @ingroup Extensions
 */

class ViewGifts extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'ViewGifts' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgUploadPath, $wgUserGiftsScripts;

		$wgOut->addExtensionStyle( $wgUserGiftsScripts . '/UserGifts.css' );

		$user_name = $wgRequest->getVal( 'user' );
		$page = $wgRequest->getInt( 'page', 1 );

		/**
		 * Redirect Non-logged in users to Login Page
		 * It will automatically return them to the ViewGifts page
		 */
		if ( $wgUser->getID() == 0 && $user_name == '' ) {
			$login = SpecialPage::getTitleFor( 'Userlogin' );
			$wgOut->redirect( $login->escapeFullURL( 'returnto=Special:ViewGifts' ) );
			return false;
		}

		/**
		 * If no user is set in the URL, we assume it's the current user
		 */
		if ( !$user_name ) {
			$user_name = $wgUser->getName();
		}
		$user_id = User::idFromName( $user_name );
		$user = Title::makeTitle( NS_USER, $user_name );

		/**
		 * Error message for username that does not exist (from URL)
		 */
		if ( $user_id == 0 ) {
			$wgOut->setPageTitle( wfMsg( 'g-error-title' ) );
			$wgOut->addHTML( wfMsg( 'g-error-message-no-user' ) );
			return false;
		}

		/**
		 * Config for the page
		 */
		$per_page = 10;
		$per_row = 2;

		/**
		 * Get all gifts for this user into the array
		 */
		$rel = new UserGifts( $user_name );

		$gifts = $rel->getUserGiftList( 0, $per_page, $page );
		$total = $rel->getGiftCountByUsername( $user_name );

		/**
		 * Show gift count for user
		 */
		$wgOut->setPageTitle( wfMsg( 'g-list-title', $rel->user_name ) );

		$output = '<div class="back-links">
			<a href="' . $user->getFullURL() . '">' .
				wfMsg( 'g-back-link', $rel->user_name ) .
			'</a>
		</div>
		<div class="g-count">' .
			wfMsgExt( 'g-count', 'parsemag', $rel->user_name, $total ) .
		'</div>';

		if ( $gifts ) {
			$x = 1;

			// Safe links
			$viewGiftLink = SpecialPage::getTitleFor( 'ViewGift' );
			$giveGiftLink = SpecialPage::getTitleFor( 'GiveGift' );
			$removeGiftLink = SpecialPage::getTitleFor( 'RemoveGift' );

			foreach ( $gifts as $gift ) {
				$giftname_length = strlen( $gift['gift_name'] );
				$giftname_space = stripos( $gift['gift_name'], ' ' );

				if ( ( $giftname_space == false || $giftname_space >= "30" ) && $giftname_length > 30 ) {
					$gift_name_display = substr( $gift['gift_name'], 0, 30 ) .
						' ' . substr( $gift['gift_name'], 30, 50 );
				} else {
					$gift_name_display = $gift['gift_name'];
				}

				$user_from = Title::makeTitle( NS_USER, $gift['user_name_from'] );
				$gift_image = "<img src=\"{$wgUploadPath}/awards/" .
					Gifts::getGiftImage( $gift['gift_id'], 'l' ) .
					'" border="0" alt="" />';

				$output .= '<div class="g-item">
					<a href="' . $viewGiftLink->escapeFullURL( 'gift_id=' . $gift['id'] ) . '">' .
						$gift_image .
					'</a>
					<div class="g-title">
						<a href="' . $viewGiftLink->escapeFullURL( 'gift_id=' . $gift['id'] ) . '">' .
							$gift_name_display .
						'</a>';
				if ( $gift['status'] == 1 ) {
					if ( $user_name == $wgUser->getName() ) {
						$rel->clearUserGiftStatus( $gift['id'] );
						$rel->decNewGiftCount( $wgUser->getID() );
					}
					$output .= '<span class="g-new">' .
						wfMsg( 'g-new' ) .
					'</span>';
				}
				$output .= '</div>';

				$output .= '<div class="g-from">' .
					wfMsg( 'g-from', $user_from->escapeFullURL(), $gift['user_name_from'] ) .
				'</div>
					<div class="g-actions">
						<a href="' . $giveGiftLink->escapeFullURL( 'gift_id=' . $gift['gift_id'] ) . '">' .
							wfMsg( 'g-to-another' ) .
						'</a>';
				if ( $rel->user_name == $wgUser->getName() ) {
					$output .= '&#160;';
					$output .= wfMsgExt( 'pipe-separator', 'escapenoentities' );
					$output .= '&#160;';
					$output .= '<a href="' . $removeGiftLink->escapeFullURL( 'gift_id=' . $gift['id'] ) . '">' .
						wfMsg( 'g-remove-gift' ) . '</a>';
				}
				$output .= '</div>
					<div class="cleared"></div>';
				$output .= '</div>';
				if ( $x == count( $gifts ) || $x != 1 && $x % $per_row == 0 ) {
					$output .= '<div class="cleared"></div>';
				}

				$x++;
			}
		}

		/**
		 * Build next/prev nav
		 */
		$numofpages = $total / $per_page;

		$pageLink = SpecialPage::getTitleFor( 'ViewGifts' );

		if ( $numofpages > 1 ) {
			$output .= '<div class="page-nav">';
			if ( $page > 1 ) {
				$output .= '<a href="' . $pageLink->escapeFullURL( 'user=' . $user_name . '&page=' . ( $page - 1 ) ) . '">' .
					wfMsg( 'g-previous' ) . '</a> ';
			}

			if ( ( $total % $per_page ) != 0 ) {
				$numofpages++;
			}
			if ( $numofpages >= 9 && $page < $total ) {
				$numofpages = 9 + $page;
			}
			if ( $numofpages >= ( $total / $per_page ) ) {
				$numofpages = ( $total / $per_page ) + 1;
			}

			for ( $i = 1; $i <= $numofpages; $i++ ) {
				if ( $i == $page ) {
					$output .= ( $i . ' ' );
				} else {
					$output .= '<a href="' . $pageLink->escapeFullURL( 'user=' . $user_name . '&page=' . $i ) . "\">$i</a> ";
				}
			}

			if ( ( $total - ( $per_page * $page ) ) > 0 ) {
				$output .= ' <a href="' . $pageLink->escapeFullURL( 'user=' . $user_name . '&page=' . ( $page + 1 ) ) . '">' .
					wfMsg( 'g-next' ) . '</a>';
			}
			$output .= '</div>';
		}

		$wgOut->addHTML( $output );
	}
}

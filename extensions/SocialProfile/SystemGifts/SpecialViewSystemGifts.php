<?php
/**
 * A special page to view the list of system gifts (awards) a user has.
 *
 * @file
 * @ingroup Extensions
 */

class ViewSystemGifts extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'ViewSystemGifts' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgUploadPath, $wgSystemGiftsScripts;

		$wgOut->addExtensionStyle( $wgSystemGiftsScripts . '/SystemGift.css' );

		$output = '';
		$user_name = $wgRequest->getVal( 'user' );
		$page = $wgRequest->getInt( 'page', 1 );

		/**
		 * Redirect Non-logged in users to Login Page
		 * It will automatically return them to the ViewSystemGifts page
		 */
		if ( $wgUser->getID() == 0 && $user_name == '' ) {
			$wgOut->setPageTitle( wfMsg( 'ga-error-title' ) );
			$login = SpecialPage::getTitleFor( 'Userlogin' );
			$wgOut->redirect( $login->escapeFullURL( 'returnto=Special:ViewSystemGifts' ) );
			return false;
		}

		/**
		 * If no user is set in the URL, we assume it's the current user
		 */
		if ( !$user_name ) {
			$user_name = $wgUser->getName();
		}
		$user_id = User::idFromName( $user_name );

		/**
		 * Error message for username that does not exist (from URL)
		 */
		if ( $user_id == 0 ) {
			$wgOut->setPageTitle( wfMsg( 'ga-error-title' ) );
			$wgOut->addHTML( wfMsg( 'ga-error-message-no-user' ) );
			return false;
		}

		/**
		* Config for the page
		*/
		$per_page = 10;
		$per_row = 2;

		/**
		 * Get all Gifts for this user into the array
		 */
		$rel = new UserSystemGifts( $user_name );

		$gifts = $rel->getUserGiftList( 0, $per_page, $page );
		$total = $rel->getGiftCountByUsername( $user_name );

		/**
		 * Show gift count for user
		 */
		$wgOut->setPageTitle( wfMsg( 'ga-title', $rel->user_name ) );

		$output .= '<div class="back-links">' .
			wfMsg(
				'ga-back-link',
				$wgUser->getUserPage()->escapeFullURL(),
				$rel->user_name
			) . '</div>';

		$output .= '<div class="ga-count">' .
			wfMsgExt( 'ga-count', 'parsemag', $rel->user_name, $total ) .
		'</div>';

		// Safelinks
		$view_system_gift_link = SpecialPage::getTitleFor( 'ViewSystemGift' );

		if ( $gifts ) {
			$x = 1;
			foreach ( $gifts as $gift ) {
				$gift_image = "<img src=\"{$wgUploadPath}/awards/" .
					SystemGifts::getGiftImage( $gift['gift_id'], 'ml' ) .
					'" border="0" alt="" />';

				$output .= "<div class=\"ga-item\">
					{$gift_image}
					<a href=\"" .
						$view_system_gift_link->escapeFullURL( 'gift_id=' . $gift['id'] ) .
						"\">{$gift['gift_name']}</a>";

				if ( $gift['status'] == 1 ) {
					if ( $user_name == $wgUser->getName() ) {
						$rel->clearUserGiftStatus( $gift['id'] );
						$rel->decNewSystemGiftCount( $wgUser->getID() );
					}
					$output .= '<span class="ga-new">' .
						wfMsg( 'ga-new' ) . '</span>';
				}

				$output .= '<div class="cleared"></div>
				</div>';
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

		$page_link = SpecialPage::getTitleFor( 'ViewSystemGifts' );

		if ( $numofpages > 1 ) {
			$output .= '<div class="page-nav">';
			if ( $page > 1 ) {
				$output .= '<a href="' . $page_link->escapeFullURL(
					'user=' . $user_name . '&page=' . ( $page - 1 ) ) . '">' .
					wfMsg( 'ga-previous' ) . '</a> ';
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
					$output .= '<a href="' . $page_link->escapeFullURL(
						'user=' . $user_name . '&page=' . $i ) . "\">$i</a> ";
				}
			}

			if ( ( $total - ( $per_page * $page ) ) > 0 ) {
				$output .= ' <a href="' . $page_link->escapeFullURL(
					'user=' . $user_name . '&page=' . ( $page + 1 ) ) . '">' .
					wfMsg( 'ga-next' ) .
				'</a>';
			}
			$output .= '</div>';
		}

		/**
		 * Build next/prev nav
		 */
		$wgOut->addHTML( $output );
	}
}

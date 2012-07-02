<?php

class RemoveGift extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'RemoveGift' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgMemc, $wgUploadPath, $wgUserGiftsScripts;

		$wgOut->addExtensionStyle( $wgUserGiftsScripts . '/UserGifts.css' );

		$this->gift_id = $wgRequest->getInt( 'gift_id' );
		$rel = new UserGifts( $wgUser->getName() );

		if ( !$this->gift_id || !is_numeric( $this->gift_id ) ) {
			$wgOut->setPageTitle( wfMsg( 'g-error-title' ) );
			$wgOut->addHTML( wfMsg( 'g-error-message-invalid-link' ) );
			return false;
		}

		if ( $rel->doesUserOwnGift( $wgUser->getID(), $this->gift_id ) == false ) {
			$wgOut->setPageTitle( wfMsg( 'g-error-title' ) );
			$wgOut->addHTML( wfMsg( 'g-error-do-not-own' ) );
			return false;
		}

		$gift = $rel->getUserGift( $this->gift_id );
		if ( $wgRequest->wasPosted() && $_SESSION['alreadysubmitted'] == false ) {
			$_SESSION['alreadysubmitted'] = true;

			$user_page_link = Title::makeTitle( NS_USER, $wgUser->getName() );

			if ( $rel->doesUserOwnGift( $wgUser->getID(), $this->gift_id ) == true ) {
				$wgMemc->delete( wfMemcKey( 'user', 'profile', 'gifts', $wgUser->getID() ) );
				$rel->deleteGift( $this->gift_id );
			}

			$gift_image = '<img src="' . $wgUploadPath . '/awards/' .
				Gifts::getGiftImage( $gift['gift_id'], 'l' ) .
				'" border="0" alt="" />';

			$wgOut->setPageTitle( wfMsg( 'g-remove-success-title', $gift['name'] ) );

			$out = '<div class="back-links">
				<a href="' . $wgUser->getUserPage()->escapeFullURL() . '">' .
					wfMsg( 'g-back-link', $gift['user_name_to'] ) . '</a>
			</div>
			<div class="g-container">' .
				$gift_image . wfMsg( 'g-remove-success-message', $gift['name'] ) .
				'<div class="cleared"></div>
			</div>
			<div class="g-buttons">
				<input type="button" class="site-button" value="' . wfMsg( 'g-main-page' ) . '" size="20" onclick="window.location=\'index.php?title=' . wfMsgForContent( 'mainpage' ) . '\'" />
				<input type="button" class="site-button" value="' . wfMsg( 'g-your-profile' ) . '" size="20" onclick="window.location=\'' . $user_page_link->escapeFullURL() . '\'" />
			</div>';

			$wgOut->addHTML( $out );
		} else {
			$_SESSION['alreadysubmitted'] = false;
			$wgOut->addHTML( $this->displayForm() );
		}
	}

	/**
	 * Displays the main form for removing a gift
	 * @return HTML output
	 */
	function displayForm() {
		global $wgUser, $wgOut, $wgUploadPath;

		$rel = new UserGifts( $wgUser->getName() );
		$gift = $rel->getUserGift( $this->gift_id );
		$user = Title::makeTitle( NS_USER, $gift['user_name_from'] );
		$gift_image = '<img src="' . $wgUploadPath . '/awards/' .
			Gifts::getGiftImage( $gift['gift_id'], 'l' ) .
			'" border="0" alt="gift" />';

		$wgOut->setPageTitle( wfMsg( 'g-remove-title', $gift['name'] ) );

		$output = '<div class="back-links">
			<a href="' . $wgUser->getUserPage()->escapeFullURL() . '">' .
				wfMsg( 'g-back-link', $gift['user_name_to'] ) . '</a>
		</div>
		<form action="" method="post" enctype="multipart/form-data" name="form1">
			<div class="g-remove-message">' .
				wfMsg( 'g-remove-message', $gift['name'] ) .
			'</div>
			<div class="g-container">' .
				$gift_image .
				'<div class="g-name">' . $gift['name'] . '</div>
				<div class="g-from">' .
					wfMsg(
						'g-from',
						$user->escapeFullURL(),
						$gift['user_name_from']
					) . '</div>';
		if ( $gift['message'] ) {
			$output .= '<div class="g-user-message">' .
				$gift['message'] . '</div>';
		}
		$output .= '</div>
			<div class="cleared"></div>
			<div class="g-buttons">
				<input type="hidden" name="user" value="' . addslashes( $gift['user_name_from'] ) . '">
				<input type="button" class="site-button" value="' . wfMsg( 'g-remove' ) . '" size="20" onclick="document.form1.submit()" />
				<input type="button" class="site-button" value="' . wfMsg( 'g-cancel' ) . '" size="20" onclick="history.go(-1)" />
			</div>
		</form>';

		return $output;
	}
}

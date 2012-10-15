<?php

class RemoveMasterGift extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'RemoveMasterGift' );
	}

	/**
	 * Deletes a gift image from $wgUploadDirectory/awards/
	 *
	 * @param $id Integer: internal ID number of the gift whose image we want to delete
	 * @param $size String: size of the image to delete (s for small, m for
	 *                      medium, ml for medium-large and l for large)
	 */
	function deleteImage( $id, $size ) {
		global $wgUploadDirectory;
		$files = glob( $wgUploadDirectory . '/awards/' . $id . "_{$size}*" );
		if ( $files && $files[0] ) {
			$img = basename( $files[0] );
			unlink( $wgUploadDirectory . '/awards/' .  $img );
		}
	}

	/**
	 * Checks if a user is allowed to remove gifts.
	 *
	 * @return Boolean: false by default or if the user is blocked, true if
	 *                  user has 'delete' permission or is a member of the
	 *                  giftadmin group
	 */
	function canUserManage() {
		global $wgUser;

		if ( $wgUser->isBlocked() ) {
			return false;
		}

		if ( $wgUser->isAllowed( 'delete' ) || in_array( 'giftadmin', $wgUser->getGroups() ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgUserGiftsScripts;

		// Add CSS
		$wgOut->addExtensionStyle( $wgUserGiftsScripts . '/UserGifts.css' );

		// Check for permissions
		if ( $wgUser->isAnon() || !$this->canUserManage() ) {
			throw new ErrorPageError( 'error', 'badaccess' );
		}

		$this->gift_id = $wgRequest->getInt( 'gift_id' );

		if ( !$this->gift_id || !is_numeric( $this->gift_id ) ) {
			$wgOut->setPageTitle( wfMsg( 'g-error-title' ) );
			$wgOut->addHTML( wfMsg( 'g-error-message-invalid-link' ) );
			return false;
		}

		if ( $wgRequest->wasPosted() && $_SESSION['alreadysubmitted'] == false ) {
			$_SESSION['alreadysubmitted'] = true;

			$dbw = wfGetDB( DB_MASTER );
			$gift = Gifts::getGift( $this->gift_id );

			$dbw->delete(
				'gift',
				array( 'gift_id' => $this->gift_id ),
				__METHOD__
			);
			$dbw->delete(
				'user_gift',
				array( 'ug_gift_id' => $this->gift_id ),
				__METHOD__
			);

			$this->deleteImage( $this->gift_id, 's' );
			$this->deleteImage( $this->gift_id, 'm' );
			$this->deleteImage( $this->gift_id, 'l' );
			$this->deleteImage( $this->gift_id, 'ml' );

			$wgOut->setPageTitle( wfMsg( 'g-remove-success-title', $gift['gift_name'] ) );

			$out = '<div class="back-links">
				<a href="' . SpecialPage::getTitleFor( 'GiftManager' )->escapeFullURL() . '">' . wfMsg( 'g-viewgiftlist' ) . '</a>
			</div>
			<div class="g-container">' .
				wfMsg( 'g-remove-success-message', $gift['gift_name'] ) .
				'<div class="cleared"></div>
			</div>';

			$wgOut->addHTML( $out );
		} else {
			$_SESSION['alreadysubmitted'] = false;
			$wgOut->addHTML( $this->displayForm() );
		}
	}

	/**
	 * Displays the main form for removing a gift permanently
	 *
	 * @return String: HTML output
	 */
	function displayForm() {
		global $wgOut, $wgUploadPath;

		$gift = Gifts::getGift( $this->gift_id );

		$gift_image = '<img src="' . $wgUploadPath . '/awards/' .
			Gifts::getGiftImage( $this->gift_id, 'l' ) .
			'" border="0" alt="gift" />';

		$wgOut->setPageTitle( wfMsg( 'g-remove-title', $gift['gift_name'] ) );

		$output = '<div class="back-links">
			<a href="' . SpecialPage::getTitleFor( 'GiftManager' )->escapeFullURL() . '">' .
				wfMsg( 'g-viewgiftlist' ) . '</a>
		</div>
		<form action="" method="post" enctype="multipart/form-data" name="form1">
			<div class="g-remove-message">' .
				wfMsg( 'g-delete-message', $gift['gift_name'] ) .
			'</div>
			<div class="g-container">' .
				$gift_image .
				'<div class="g-name">' . $gift['gift_name'] . '</div>
			</div>
			<div class="cleared"></div>
			<div class="g-buttons">
				<input type="button" class="site-button" value="' . wfMsg( 'g-remove' ) . '" size="20" onclick="document.form1.submit()" />
				<input type="button" class="site-button" value="' . wfMsg( 'g-cancel' ) . '" size="20" onclick="history.go(-1)" />
			</div>
		</form>';

		return $output;
	}
}

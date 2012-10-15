<?php
/**
 * A special page for removing system gifts permanently.
 *
 * @file
 * @ingroup Extensions
 */
class RemoveMasterSystemGift extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'RemoveMasterSystemGift' );
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
		$files = glob( $wgUploadDirectory . '/awards/sg_' . $id . "_{$size}*" );
		if ( $files && $files[0] ) {
			$img = basename( $files[0] );
			// $img already contains the sg_ prefix
			unlink( $wgUploadDirectory . '/awards/' .  $img );
		}
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgSystemGiftsScripts;

		// If the user doesn't have the required 'awardsmanage' permission, display an error
		if ( !$wgUser->isAllowed( 'awardsmanage' ) ) {
			$wgOut->permissionRequired( 'awardsmanage' );
			return;
		}

		// Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		// If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		// Add CSS
		$wgOut->addExtensionStyle( $wgSystemGiftsScripts . '/SystemGift.css' );

		$this->gift_id = $wgRequest->getInt( 'gift_id', $par );

		if ( !$this->gift_id || !is_numeric( $this->gift_id ) ) {
			$wgOut->setPageTitle( wfMsg( 'ga-error-title' ) );
			$wgOut->addHTML( wfMsg( 'ga-error-message-invalid-link' ) );
			return false;
		}

		if ( $wgRequest->wasPosted() && $_SESSION['alreadysubmitted'] == false ) {
			$_SESSION['alreadysubmitted'] = true;

			$dbw = wfGetDB( DB_MASTER );
			$gift = SystemGifts::getGift( $this->gift_id );

			$dbw->delete(
				'system_gift',
				array( 'gift_id' => $this->gift_id ),
				__METHOD__
			);
			$dbw->delete(
				'user_system_gift',
				array( 'sg_gift_id' => $this->gift_id ),
				__METHOD__
			);

			$this->deleteImage( $this->gift_id, 's' );
			$this->deleteImage( $this->gift_id, 'm' );
			$this->deleteImage( $this->gift_id, 'l' );
			$this->deleteImage( $this->gift_id, 'ml' );

			$wgOut->setPageTitle( wfMsg( 'ga-remove-success-title', $gift['gift_name'] ) );

			$out = '<div class="back-links">
				<a href="' . SpecialPage::getTitleFor( 'SystemGiftManager' )->escapeFullURL() . '">' .
					wfMsg( 'ga-viewlist' ) . '</a>
			</div>
			<div class="ga-container">' .
				wfMsg( 'ga-remove-success-message', $gift['gift_name'] ) .
				'<div class="cleared"></div>
			</div>';

			$wgOut->addHTML( $out );
		} else {
			$_SESSION['alreadysubmitted'] = false;
			$wgOut->addHTML( $this->displayForm() );
		}
	}

	/**
	 * Displays the main form for removing a system gift permanently.
	 *
	 * @return String: HTML output
	 */
	function displayForm() {
		global $wgOut, $wgUploadPath;

		$gift = SystemGifts::getGift( $this->gift_id );

		$giftImage = '<img src="' . $wgUploadPath . '/awards/' .
			SystemGifts::getGiftImage( $this->gift_id, 'l' ) .
			'" border="0" alt="gift" />';

		$wgOut->setPageTitle( wfMsg( 'ga-remove-title', $gift['gift_name'] ) );

		$output = '<div class="back-links">
			<a href="' . SpecialPage::getTitleFor( 'SystemGiftManager' )->escapeFullURL() . '">' .
				wfMsg( 'ga-viewlist' ) . '</a>
		</div>
		<form action="" method="post" enctype="multipart/form-data" name="form1">
			<div class="ga-remove-message">' .
				wfMsg( 'ga-delete-message', $gift['gift_name'] ) .
			'</div>
			<div class="ga-container">' .
				$giftImage .
				'<div class="ga-name">' . $gift['gift_name'] . '</div>
			</div>
			<div class="cleared"></div>
			<div class="ga-buttons">
				<input type="button" class="site-button" value="' . wfMsg( 'ga-remove' ) . '" size="20" onclick="document.form1.submit()" />
				<input type="button" class="site-button" value="' . wfMsg( 'ga-cancel' ) . '" size="20" onclick="history.go(-1)" />
			</div>
		</form>';

		return $output;
	}
}

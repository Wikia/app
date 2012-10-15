<?php

class GiftManager extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'GiftManager'/*class*/, 'giftadmin'/*restriction*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgUserGiftsScripts;

		$wgOut->setPageTitle( wfMsg( 'giftmanager' ) );

		// Make sure that the user is logged in and that they can use this
		// special page
		if ( $wgUser->isAnon() || !$this->canUserManage() ) {
			throw new ErrorPageError( 'error', 'badaccess' );
		}

		// Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		// Add CSS
		$wgOut->addExtensionStyle( $wgUserGiftsScripts . '/UserGifts.css' );

		if ( $wgRequest->wasPosted() ) {
			if ( !$wgRequest->getInt( 'id' ) ) {
				$giftId = Gifts::addGift(
					$wgRequest->getVal( 'gift_name' ),
					$wgRequest->getVal( 'gift_description' ),
					$wgRequest->getInt( 'access' )
				);
				$wgOut->addHTML(
					'<span class="view-status">' .
					wfMsg( 'giftmanager-giftcreated' ) .
					'</span><br /><br />'
				);
			} else {
				$giftId = $wgRequest->getInt( 'id' );
				Gifts::updateGift(
					$giftId,
					$wgRequest->getVal( 'gift_name' ),
					$wgRequest->getVal( 'gift_description' ),
					$wgRequest->getInt( 'access' )
				);
				$wgOut->addHTML(
					'<span class="view-status">' .
					wfMsg( 'giftmanager-giftsaved' ) .
					'</span><br /><br />'
				);
			}

			$wgOut->addHTML( $this->displayForm( $giftId ) );
		} else {
			$giftId = $wgRequest->getInt( 'id' );
			if ( $giftId || $wgRequest->getVal( 'method' ) == 'edit' ) {
				$wgOut->addHTML( $this->displayForm( $giftId ) );
			} else {
				// If the user is allowed to create new gifts, show the
				// "add a gift" link to them
				if ( $this->canUserCreateGift() ) {
					$wgOut->addHTML(
						'<div><b><a href="' .
						$this->getTitle()->escapeFullURL( 'method=edit' ) .
						'">' . wfMsg( 'giftmanager-addgift' ) .
						'</a></b></div>'
					);
				}
				$wgOut->addHTML( $this->displayGiftList() );
			}
		}
	}

	/**
	 * Function to check if the user can manage created gifts
	 * @return Boolean: true if user has 'giftadmin' permission or is
	 *			a member of the giftadmin group, otherwise false
	 */
	function canUserManage() {
		global $wgUser, $wgMaxCustomUserGiftCount;

		if ( $wgUser->isBlocked() ) {
			return false;
		}

		if ( $wgMaxCustomUserGiftCount > 0 ) {
			return true;
		}

		if (
			$wgUser->isAllowed( 'giftadmin' ) ||
			in_array( 'giftadmin', $wgUser->getGroups() )
		)
		{
			return true;
		}

		return false;
	}

	/**
	 * Function to check if the user can delete created gifts
	 * @return Boolean: true if user has 'giftadmin' permission or is
	 *			a member of the giftadmin group, otherwise false
	 */
	function canUserDelete() {
		global $wgUser;

		if ( $wgUser->isBlocked() ) {
			return false;
		}

		if (
			$wgUser->isAllowed( 'giftadmin' ) ||
			in_array( 'giftadmin', $wgUser->getGroups() )
		)
		{
			return true;
		}

		return false;
	}

	/**
	 * Function to check if the user can create new gifts
	 * @return Boolean: true if user has 'giftadmin' permission, is
	 *			a member of the giftadmin group or if $wgMaxCustomUserGiftCount
	 *			has been defined, otherwise false
	 */
	function canUserCreateGift() {
		global $wgUser, $wgMaxCustomUserGiftCount;

		if ( $wgUser->isBlocked() ) {
			return false;
		}

		$createdCount = Gifts::getCustomCreatedGiftCount( $wgUser->getID() );
		if (
			$wgUser->isAllowed( 'giftadmin' ) ||
			in_array( 'giftadmin', ( $wgUser->getGroups() ) ) ||
			( $wgMaxCustomUserGiftCount > 0 && $createdCount < $wgMaxCustomUserGiftCount )
		)
		{
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Display the text list of all existing gifts and a delete link to users
	 * who are allowed to delete gifts.
	 *
	 * @return String: HTML
	 */
	function displayGiftList() {
		$output = ''; // Prevent E_NOTICE
		$page = 0;
		$per_page = 10;
		$gifts = Gifts::getManagedGiftList( $per_page, $page );
		if ( $gifts ) {
			foreach ( $gifts as $gift ) {
				$deleteLink = '';
				if ( $this->canUserDelete() ) {
					$deleteLink = '<a href="' .
						SpecialPage::getTitleFor( 'RemoveMasterGift' )->escapeFullURL( "gift_id={$gift['id']}" ) .
						'" style="font-size:10px; color:red;">' .
						wfMsg( 'delete' ) . '</a>';
				}

				$output .= '<div class="Item">
				<a href="' . $this->getTitle()->escapeFullURL( "id={$gift['id']}" ) . '">' .
					$gift['gift_name'] . '</a> ' .
					$deleteLink . "</div>\n";
			}
		}
		return '<div id="views">' . $output . '</div>';
	}

	function displayForm( $gift_id ) {
		global $wgUser;

		if ( !$gift_id && !$this->canUserCreateGift() ) {
			return $this->displayGiftList();
		}

		$form = '<div><b><a href="' . $this->getTitle()->escapeFullURL() .
			'">' . wfMsg( 'giftmanager-view' ) . '</a></b></div>';

		if ( $gift_id ) {
			$gift = Gifts::getGift( $gift_id );
			if (
				$wgUser->getID() != $gift['creator_user_id'] &&
				(
					!in_array( 'giftadmin', $wgUser->getGroups() ) &&
					!$wgUser->isAllowed( 'delete' )
				)
			)
			{
				throw new ErrorPageError( 'error', 'badaccess' );
			}
		}

		$form .= '<form action="" method="post" enctype="multipart/form-data" name="gift">';
		$form .= '<table border="0" cellpadding="5" cellspacing="0" width="500">';
		$form .= '<tr>
		<td width="200" class="view-form">' . wfMsg( 'g-gift-name' ) . '</td>
		<td width="695"><input type="text" size="45" class="createbox" name="gift_name" value="' .
			( isset( $gift['gift_name'] ) ? $gift['gift_name'] : '' ) . '"/></td>
		</tr>
		<tr>
		<td width="200" class="view-form" valign="top">' . wfMsg( 'giftmanager-description' ) . '</td>
		<td width="695"><textarea class="createbox" name="gift_description" rows="2" cols="30">' .
			( isset( $gift['gift_description'] ) ? $gift['gift_description'] : '' ) . '</textarea></td>
		</tr>';
		if ( $gift_id ) {
			$creator = Title::makeTitle( NS_USER, $gift['creator_user_name'] );
			$form .= '<tr>
			<td class="view-form">' .
				wfMsgExt( 'g-created-by', 'parsemag', $gift['creator_user_name'] ) .
			'</td>
			<td><a href="' . $creator->escapeFullURL() . '">' .
				$gift['creator_user_name'] . '</a></td>
			</tr>';
		}

		// If the user isn't in the gift admin group, they can only create
		// private gifts
		if ( !$wgUser->isAllowed( 'giftadmin' ) ) {
			$form .= '<input type="hidden" name="access" value="1" />';
		} else {
			$publicSelected = $privateSelected = '';
			if ( isset( $gift['access'] ) && $gift['access'] == 0 ) {
				$publicSelected = ' selected="selected"';
			}
			if ( isset( $gift['access'] ) && $gift['access'] == 1 ) {
				$privateSelected = ' selected="selected"';
			}
			$form .= '<tr>
				<td class="view-form">' . wfMsg( 'giftmanager-access' ) . '</td>
				<td>
				<select name="access">
					<option value="0"' . $publicSelected . '>' .
						wfMsg( 'giftmanager-public' ) .
					'</option>
					<option value="1"' . $privateSelected . '>' .
						wfMsg( 'giftmanager-private' ) .
					'</option>
				</select>
				</td>
			</tr>';
		}

		if ( $gift_id ) {
			global $wgUploadPath;
			$gml = SpecialPage::getTitleFor( 'GiftManagerLogo' );
			$gift_image = '<img src="' . $wgUploadPath . '/awards/' .
				Gifts::getGiftImage( $gift_id, 'l' ) . '" border="0" alt="' .
				wfMsg( 'g-gift' ) . '" />';
			$form .= '<tr>
			<td width="200" class="view-form" valign="top">' . wfMsg( 'giftmanager-giftimage' ) . '</td>
			<td width="695">' . $gift_image .
			'<p>
			<a href="' . $gml->escapeFullURL( 'gift_id=' . $gift_id ) . '">' .
				wfMsg( 'giftmanager-image' ) . '</a>
			</td>
			</tr>';
		}

		if ( isset( $gift['gift_id'] ) ) {
			$button = wfMsg( 'edit' );
		} else {
			$button = wfMsg( 'g-create-gift' );
		}

		$form .= '<tr>
			<td colspan="2">
				<input type="hidden" name="id" value="' . ( isset( $gift['gift_id'] ) ? $gift['gift_id'] : '' ) . '" />
				<input type="button" class="createbox" value="' . $button . '" size="20" onclick="document.gift.submit()" />
				<input type="button" class="createbox" value="' . wfMsg( 'cancel' ) . '" size="20" onclick="history.go(-1)" />
			</td>
		</tr>
		</table>

		</form>';
		return $form;
	}
}

<?php

class SystemGiftManager extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct(){
		parent::__construct('SystemGiftManager'/*class*/, 'awardsmanage'/*restriction*/);
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ){
		global $wgUser, $wgOut, $wgRequest, $wgScriptPath, $wgSystemGiftsScripts;
		wfLoadExtensionMessages( 'SystemGifts' );

		$wgOut->setPageTitle( wfMsg( 'systemgiftmanager' ) );

		# If the user doesn't have the required 'awardsmanage' permission, display an error
		if( !$wgUser->isAllowed( 'awardsmanage' ) ) {
			$wgOut->permissionRequired( 'awardsmanage' );
			return;
		}

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		# If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		// Add CSS
		$wgOut->addStyle( $wgSystemGiftsScripts . '/SystemGift.css' );

		if( $wgRequest->wasPosted() ){
			$g = new SystemGifts();

			if( !( $_POST['id'] ) ){
				$gift_id = $g->addGift(
					$wgRequest->getVal( 'gift_name' ), $wgRequest->getVal( 'gift_description' ),
					$wgRequest->getVal( 'gift_category' ), $wgRequest->getVal( 'gift_threshold' )
				);
				$wgOut->addHTML( '<span class="view-status">'.wfMsg( 'ga-created' ).'</span><br /><br />' );
			} else {
				$gift_id = $wgRequest->getVal( 'id' );
				$g->updateGift( $gift_id,
					$wgRequest->getVal( 'gift_name' ), $wgRequest->getVal( 'gift_description' ),
					$wgRequest->getVal( 'gift_category' ), $wgRequest->getVal( 'gift_threshold' )
				);
				$wgOut->addHTML( '<span class="view-status">'.wfMsg( 'ga-saved' ).'</span><br /><br />' );
			}
			$g->update_system_gifts();
			$wgOut->addHTML( $this->displayForm( $gift_id ) );
		} else {
			$gift_id = $wgRequest->getVal( 'id' );
			if( $gift_id || $wgRequest->getVal( 'method' ) == 'edit' ){
				$wgOut->addHTML( $this->displayForm( $gift_id ) );
			} else {
				$wgOut->addHTML( '<div><b><a href="'.$wgScriptPath.'/index.php?title=Special:SystemGiftManager&amp;method=edit">'.wfMsg( 'ga-addnew' ).'</a></b></div>' );
				$wgOut->addHTML( $this->displayGiftList() );
			}
		}
	}

	function displayGiftList(){
		global $wgScriptPath;
		$output = ''; // Prevent E_NOTICE
		$per_page = 10;
		$gifts = SystemGifts::getGiftList( $per_page, $page );
		if( $gifts ){
			foreach( $gifts as $gift ) {
				$output .= '<div class="Item">
						<a href="'.$wgScriptPath.'/index.php?title=Special:SystemGiftManager&amp;id='.$gift['id'].'">'.$gift['gift_name'].'</a>
					</div>'."\n";
			}
		}
		return '<div id="views">' . $output . '</div>';
	}

	function displayForm( $gift_id ){
		global $wgUploadPath, $wgScriptPath;

		$form = '<div><b><a href="'.$wgScriptPath.'/index.php?title=Special:SystemGiftManager">'.wfMsg( 'ga-viewlist' ).'</a></b></div>';

		if( $gift_id ) $gift = SystemGifts::getGift( $gift_id );

		$form .= '<form action="" method="post" enctype="multipart/form-data" name="gift">
		<table border="0" cellpadding="5" cellspacing="0" width="500">
			<tr>
				<td width="200" class="view-form">'.wfMsg( 'ga-giftname' ).'</td>
				<td width="695"><input type="text" size="45" class="createbox" name="gift_name" value="'. $gift['gift_name'] . '"/></td>
			</tr>
			<tr>
				<td width="200" class="view-form" valign="top">'.wfMsg( 'ga-giftdesc' ).'</td>
				<td width="695"><textarea class="createbox" name="gift_description" rows="2" cols="30">'. $gift['gift_description'] . '</textarea></td>
			</tr>
			<tr>
				<td width="200" class="view-form">'.wfMsg( 'ga-gifttype' ).'</td>
				<td width="695">
					<select name="gift_category">';
			$g = new SystemGifts();
			foreach( $g->categories as $category => $id ){
				$form .= '<option' . ( ( $gift['gift_category'] == $id ) ? ' selected="selected"' : '' ) . " value=\"{$id}\">{$category}</option>";
			}
			$form .= '</select>
				</td>
			</tr>
		<tr>
			<td width="200" class="view-form">'.wfMsg( 'ga-threshold' ).'</td>
			<td width="695"><input type="text" size="25" class="createbox" name="gift_threshold" value="'. $gift['gift_threshold'] . '"/></td>
		</tr>';

		if( $gift_id ){
			$gift_image = '<img src="'. $wgUploadPath .'/awards/' . SystemGifts::getGiftImage( $gift_id, 'l' ) . '" border="0" alt="gift" />';
			$form .= '<tr>
			<td width="200" class="view-form" valign="top">'.wfMsg( 'ga-giftimage' ).'</td>
			<td width="695">' . $gift_image . '
			<a href="'.$wgScriptPath.'/index.php?title=Special:SystemGiftManagerLogo&gift_id=' . $gift_id . '">'.wfMsg( 'ga-img' ).'</a>
			</td>
			</tr>';
		}

		$form .= '<tr>
		<td colspan="2">
			<input type="hidden" name="id" value="' . $gift['gift_id'] . '" />
			<input type="button" class="createbox" value="' . ( ( $gift['gift_id'] ) ? wfMsg( 'edit' ) : wfMsg( 'ga-create-gift' ) ) . '" size="20" onclick="document.gift.submit()" />
			<input type="button" class="createbox" value="'.wfMsg( 'cancel' ).'" size="20" onclick="history.go(-1)" />
		</td>
		</tr>
		</table>

		</form>';
		return $form;
	}
}
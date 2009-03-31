<?php

class GiftManager extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct(){
		parent::__construct('GiftManager', 'giftadmin');
	}
	
	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ){
		global $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgScriptPath;
		wfLoadExtensionMessages('UserGifts');

		$wgOut->setPageTitle( wfMsg('giftmanager') );

		if( $wgUser->isAnon() || !$this->canUserManage() ){
			$wgOut->errorpage( 'error', 'badaccess' );
		}

		$css = "<style>
		.view-form { font-weight:800; font-size:12px; font-color:#666666; }
		.view-status { font-weight:800; font-size:12px; background-color:#FFFB9B; color:#666666; padding:5px ;margin-bottom:5px; }
		</style>";
		$wgOut->addHTML($css);

		if( count( $_POST ) ){
			if( !( $_POST['id'] ) ){
				$gift_id = Gifts::addGift($_POST['gift_name'], $_POST['gift_description'], $_POST['access']);
				$wgOut->addHTML('<span class="view-status">'.wfMsg('giftmanager-giftcreated').'</span><br /><br />');
			} else {
				$gift_id = $_POST['id'];
				Gifts::updateGift($gift_id, $_POST['gift_name'], $_POST['gift_description'], $_POST['access']);
				$wgOut->addHTML('<span class="view-status">'.wfMsg('giftmanager-giftsaved').'</span><br /><br />');
			}

			$wgOut->addHTML( $this->displayForm($gift_id) );
		} else {
			$gift_id = $wgRequest->getVal( 'id' );
			if( $gift_id || $wgRequest->getVal( 'method' ) == 'edit' ){
				$wgOut->addHTML( $this->displayForm($gift_id) );
			} else {

				if ( $this->canUserCreateGift() ){
					$wgOut->addHTML('<div><b><a href="'.$wgScriptPath.'/index.php?title=Special:GiftManager&method=edit">'.wfMsg('giftmanager-addgift').'</a></b></div><p>');
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
	function canUserManage(){
		global $wgUser, $wgMaxCustomUserGiftCount;

		if( $wgUser->isBlocked() ){
			return false;
		}

		if( $wgMaxCustomUserGiftCount > 0 ){
			return true;
		}

		if( $wgUser->isAllowed('giftadmin') || in_array( 'giftadmin', $wgUser->getGroups() ) ){
			return true;
		}

		return false;
	}

	/**
	 * Function to check if the user can delete created gifts
	 * @return Boolean: true if user has 'giftadmin' permission or is
	 *			a member of the giftadmin group, otherwise false
	 */
	function canUserDelete(){
		global $wgUser;

		if( $wgUser->isBlocked() ){
			return false;
		}

		if( $wgUser->isAllowed('giftadmin') || in_array( 'giftadmin', $wgUser->getGroups() ) ){
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
	function canUserCreateGift(){
		global $wgUser, $wgMaxCustomUserGiftCount;

		if( $wgUser->isBlocked() ){
			return false;
		}

		$created_count = Gifts::getCustomCreatedGiftCount( $wgUser->getID() );
		if( $wgUser->isAllowed('giftadmin') || in_array( 'giftadmin', ( $wgUser->getGroups() ) ) || ( $wgMaxCustomUserGiftCount > 0 && $created_count < $wgMaxCustomUserGiftCount ) ){
			return true;
		} else {
			return false;
		}
	}

	function displayGiftList(){
		global $wgScriptPath;
		wfLoadExtensionMessages('UserGifts');
		$output = ''; // Prevent E_NOTICE
		$gifts = Gifts::getManagedGiftList($per_page, $page);
		if( $gifts ){
			foreach( $gifts as $gift ) {
				$output .= "<div class=\"Item\">
				<a href=\"".$wgScriptPath."/index.php?title=Special:GiftManager&amp;id={$gift["id"]}\">{$gift["gift_name"]}</a> " . ( ( $this->canUserDelete() ) ? "<a href=\"" . SpecialPage::getTitleFor( 'RemoveMasterGift' )->escapeFulLURL("gift_id={$gift["id"]}") . "\" style=\"font-size:10px;color:red;\">".wfMsg('delete')."</a>" : '' ) . "
					</div>\n";
			}
		}
		return '<div id="views">' . $output . '</div>';
	}

	function displayForm( $gift_id ){
		global $wgUser, $wgOut, $wgScriptPath;
		wfLoadExtensionMessages('UserGifts');

		if( !$gift_id && !$this->canUserCreateGift() ){
			return $this->displayGiftList();
		}
		$form = '<div><b><a href="'.$wgScriptPath.'/index.php?title=Special:GiftManager">'.wfMsg('giftmanager-view').'</a></b></div><p>';

		if( $gift_id ){
			$gift = Gifts::getGift($gift_id);
			if( $wgUser->getID() != $gift['creator_user_id'] && ( !in_array( 'giftadmin', $wgUser->getGroups() ) && !$wgUser->isAllowed('delete') ) ){
				$wgOut->errorpage( 'error', 'badaccess' );
			}
		}

		$form .= '<form action="" method="POST" enctype="multipart/form-data" name="gift">';
		$form .= '<table border="0" cellpadding="5" cellspacing="0" width="500">';
		$form .= '<tr>
		<td width="200" class="view-form">'.wfMsg('g-gift-name').'</td>
		<td width="695"><input type="text" size="45" class="createbox" name="gift_name" value="'. $gift['gift_name'] . '"/></td>
		</tr>
		<tr>
		<td width="200" class="view-form" valign="top">'.wfMsg('giftmanager-description').'</td>
		<td width="695"><textarea class="createbox" name="gift_description" rows="2" cols="30">'. $gift['gift_description'] . '</textarea></td>
		</tr>';
		if( $gift_id ){
			$creator = Title::makeTitle( NS_USER, $gift['creator_user_name'] );
			$form .= '<tr>
			<td class="view-form">'.wfMsg('g-created-by').'</td><td><a href="' . $creator->escapeFullURL() . '">' . $gift['creator_user_name'] . '</a></td>
			</tr>';
		}
		global $wgUploadPath;
		if( !in_array('giftadmin', $wgUser->getGroups() ) ){
			$form .= '<input type="hidden" name="access" value="1">';
		} else {
			$form .= '<tr>
				<td class="view-form">'.wfMsg('giftmanager-access').'</td>
				<td>
				<select name="access">
					<option value=0 ' . ( ( $gift['access'] == 0 ) ? 'selected' : '' ) . '>'.wfMsg('giftmanager-public').'</option>
					<option value=1 ' . ( ( $gift['access'] == 1 ) ? 'selected' : '' ) . '>'.wfMsg('giftmanager-private').'</option>
				</select>
				</td>
			</tr>';
		}

		global $wgScriptPath;
		if( $gift_id ){
			$gift_image = "<img src=\"{$wgUploadPath}/awards/" . Gifts::getGiftImage( $gift_id, 'l' ) . "\" border=\"0\" alt=\"".wfMsg('g-gift')."\" />";
			$form .=  '<tr>
			<td width="200" class="view-form" valign="top">'.wfMsg('giftmanager-giftimage').'</td>
			<td width="695">' . $gift_image . '
			<p>
			<a href="'.$wgScriptPath.'/index.php?title=Special:GiftManagerLogo&gift_id=' . $gift_id . '">'.wfMsg('giftmanager-image').'</a>
			</td>
			</tr>';
		}

		$form .=  '
		<tr>
		<td colspan="2">
		<input type=hidden name="id" value="' . $gift['gift_id'] . '">
		<input type="button" class="createbox" value="' . ( ( $gift['gift_id'] ) ? wfMsg('edit') : wfMsg('g-create-gift') ) . '" size="20" onclick="document.gift.submit()" />
		<input type="button" class="createbox" value="'.wfMsg('cancel').'" size="20" onclick="history.go(-1)" />
		</td>
		</tr>
		</table>

		</form>';
		return $form;
	}
}
<?php

class ViewGift extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct(){
		parent::__construct('ViewGift');
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ){
		global $wgUser, $wgOut, $wgTitle, $wgRequest, $wgDBprefix, $wgUploadPath, $wgUserGiftsScripts;
		wfLoadExtensionMessages('UserGifts');

		$wgOut->addStyle( '../..' . $wgUserGiftsScripts . '/UserGifts.css' );

		$output = ''; // Prevent E_NOTICE
		$user_name = ''; // Prevent E_NOTICE

		$gift_id = $wgRequest->getVal('gift_id');
		if( !$gift_id || !is_numeric($gift_id) ){
			$wgOut->setPageTitle( wfMsg('g-error-title') );
			$wgOut->addHTML( wfMsg('g-error-message-invalid-link') );
			return false;
		}

		if( !$user_name ) $user_name = $wgUser->getName();
		$gift = UserGifts::getUserGift($gift_id);
		$user_safe = urlencode($gift['user_name_to']);
		$id = User::idFromName($user_name);
		$relationship = UserRelationship::getUserRelationshipByID( $id, $wgUser->getID() );

		// DB stuff
		$dbr = wfGetDB( DB_MASTER );

		if( $gift ) {

			if( $gift['status'] == 1 ) {
				if( $gift['user_name_to'] == $wgUser->getName() ){
					$g = new UserGifts( $gift['user_name_to'] );
					$g->clearUserGiftStatus( $gift['id'] );
					$g->decNewGiftCount( $wgUser->getID() );
				}
			}

			$sql = "SELECT DISTINCT ug_user_name_to, ug_user_id_to, ug_date FROM ".$wgDBprefix."user_gift WHERE ug_gift_id={$gift["gift_id"]} AND ug_user_name_to<>'" . addslashes($gift["user_name_to"]) . "' GROUP BY ug_user_name_to ORDER BY ug_date DESC LIMIT 0,6";
			$res = $dbr->query($sql);

			$output .= $wgOut->setPageTitle( wfMsg( 'g-description-title', $gift['user_name_to'], $gift['name'] ) );

			$output .= '<div class="back-links">
				'.wfMsg('g-back-link', Title::makeTitle( NS_USER, $gift['user_name_to'] )->escapeFullURL(), $gift['user_name_to']).'
			</div>';

			$user = Title::makeTitle( NS_USER, $gift['user_name_from'] );
			$remove_gift_link = SpecialPage::getTitleFor( 'RemoveGift' );
			$give_gift_link = SpecialPage::getTitleFor( 'GiveGift');
		
			$avatar = new wAvatar($gift['user_id_from'], 's');
			$avatar_img = "<img src='{$wgUploadPath}/avatars/" . $avatar->getAvatarImage() . "' alt='' border='0'/>";
			$gift_image = "<img src=\"{$wgUploadPath}/awards/" . Gifts::getGiftImage($gift['gift_id'], 'l') . "\" border=\"0\" alt=\"\" />";

			$message = $wgOut->parse( trim( $gift['message'] ), false );

			$output .= '<div class="g-description-container">';

			$gift_image = "<img src=\"{$wgUploadPath}/awards/" . Gifts::getGiftImage($gift['gift_id'], 'l') . "\" border=\"0\" alt=\"\"/>";

				$output .= "<div class=\"g-description\">
					{$gift_image}
					<div class=\"g-name\">{$gift["name"]}</div>
					<div class=\"g-timestamp\">({$gift["timestamp"]})</div>
					<div class=\"g-from\">from <a href=\"".$user->escapeFullURL()."\">{$gift["user_name_from"]}</a></div>";
					if( $message ) $output .= "<div class=\"g-user-message\">\"{$message}\"</div>";
					$output .= "<div class=\"cleared\"></div>
					<div class=\"g-describe\">{$gift["description"]}</div>
					<div class=\"g-actions\">
						<a href=\"".$give_gift_link->escapeFullURL('gift_id='.$gift['gift_id'])."\">".wfMsg('g-to-another')."</a>";
						if( $gift['user_name_to'] == $wgUser->getName() ) $output .= " | <a href=\"".$remove_gift_link->escapeFullURL('gift_id='.$gift['id'])."\">".wfMsg('g-remove-gift')."</a>";
					$output .= '</div>
				</div>';

				$output .= '<div class="g-recent">
					<div class="g-recent-title">'.wfMsg('g-recent-recipients').'</div>
					<div class="g-gift-count">'.wfMsgExt( 'g-given', 'parsemag', $gift['gift_count'] ).'</div>';

					while( $row = $dbr->fetchObject( $res ) ) {

						$user_to_id = $row->ug_user_id_to;
						$avatar = new wAvatar($user_to_id, 'ml');
						$user_name_link = Title::makeTitle( NS_USER, $row->ug_user_name_to );

						$output .= "<a href=\"".$user_name_link->escapeFullURL()."\">
							{$avatar->getAvatarURL()}
						</a>";
					}
					$output .= '<div class="cleared"></div>
				</div>
			</div>';

			$wgOut->addHTML($output);

		} else {
			$wgOut->setPageTitle( wfMsg('g-error-title') );
			$wgOut->addHTML( wfMsg('g-error-message-invalid-link') );
		}
	}
}
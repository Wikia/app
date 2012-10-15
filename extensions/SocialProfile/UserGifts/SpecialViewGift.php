<?php

class ViewGift extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ViewGift' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgUploadPath, $wgUserGiftsScripts;

		$wgOut->addExtensionStyle( $wgUserGiftsScripts . '/UserGifts.css' );

		$giftId = $wgRequest->getInt( 'gift_id' );
		if ( !$giftId || !is_numeric( $giftId ) ) {
			$wgOut->setPageTitle( wfMsg( 'g-error-title' ) );
			$wgOut->addHTML( wfMsg( 'g-error-message-invalid-link' ) );
			return false;
		}

		$gift = UserGifts::getUserGift( $giftId );

		if ( $gift ) {
			if ( $gift['status'] == 1 ) {
				if ( $gift['user_name_to'] == $wgUser->getName() ) {
					$g = new UserGifts( $gift['user_name_to'] );
					$g->clearUserGiftStatus( $gift['id'] );
					$g->decNewGiftCount( $wgUser->getID() );
				}
			}

			// DB stuff
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				'user_gift',
				array( 'DISTINCT ug_user_name_to', 'ug_user_id_to', 'ug_date' ),
				array(
					'ug_gift_id' => $gift['gift_id'],
					"ug_user_name_to <> '" . addslashes( $gift['user_name_to'] ) . "'"
				),
				__METHOD__,
				array(
					'GROUP BY' => 'ug_user_name_to',
					'ORDER BY' => 'ug_date DESC',
					'LIMIT' => 6
				)
			);

			$wgOut->setPageTitle( wfMsgExt(
				'g-description-title',
				'parsemag',
				$gift['user_name_to'],
				$gift['name']
			) );

			$output = '<div class="back-links">
				<a href="' . Title::makeTitle( NS_USER, $gift['user_name_to'] )->escapeFullURL() . '">'
				. wfMsg( 'g-back-link', $gift['user_name_to'] ) . '</a>
			</div>';

			$user = Title::makeTitle( NS_USER, $gift['user_name_from'] );
			$removeGiftLink = SpecialPage::getTitleFor( 'RemoveGift' );
			$giveGiftLink = SpecialPage::getTitleFor( 'GiveGift' );

			$giftImage = '<img src="' . $wgUploadPath . '/awards/' .
				Gifts::getGiftImage( $gift['gift_id'], 'l' ) .
				'" border="0" alt="" />';

			$message = $wgOut->parse( trim( $gift['message'] ), false );

			$output .= '<div class="g-description-container">';
			$output .= '<div class="g-description">' .
					$giftImage .
					'<div class="g-name">' . $gift['name'] . '</div>
					<div class="g-timestamp">(' . $gift['timestamp'] . ')</div>
					<div class="g-from">' . wfMsg(
						'g-from',
						$user->escapeFullURL(),
						$gift['user_name_from']
					) . '</div>';
			if ( $message ) {
				$output .= '<div class="g-user-message">' . $message . '</div>';
			}
			$output .= '<div class="cleared"></div>
					<div class="g-describe">' . $gift['description'] . '</div>
					<div class="g-actions">
						<a href="' . $giveGiftLink->escapeFullURL( 'gift_id=' . $gift['gift_id'] ) . '">' .
							wfMsg( 'g-to-another' ) . '</a>';
			if ( $gift['user_name_to'] == $wgUser->getName() ) {
				$output .= wfMsgExt( 'pipe-separator', 'escapenoentities' );
				$output .= '<a href="' . $removeGiftLink->escapeFullURL( 'gift_id=' . $gift['id'] ) . '">' .
					wfMsg( 'g-remove-gift' ) . '</a>';
			}
			$output .= '</div>
				</div>';

			$output .= '<div class="g-recent">
					<div class="g-recent-title">' .
						wfMsg( 'g-recent-recipients' ) .
					'</div>
					<div class="g-gift-count">' .
						wfMsgExt( 'g-given', 'parsemag', $gift['gift_count'] ) .
					'</div>';

			foreach ( $res as $row ) {
				$userToId = $row->ug_user_id_to;
				$avatar = new wAvatar( $userToId, 'ml' );
				$userNameLink = Title::makeTitle( NS_USER, $row->ug_user_name_to );

				$output .= '<a href="' . $userNameLink->escapeFullURL() . "\">
					{$avatar->getAvatarURL()}
				</a>";
			}
			$output .= '<div class="cleared"></div>
				</div>
			</div>';

			$wgOut->addHTML( $output );
		} else {
			$wgOut->setPageTitle( wfMsg( 'g-error-title' ) );
			$wgOut->addHTML( wfMsg( 'g-error-message-invalid-link' ) );
		}
	}
}

<?php
/**
 * A special page to view an individual system gift (award).
 *
 * @file
 * @ingroup Extensions
 */

class ViewSystemGift extends UnlistedSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'ViewSystemGift' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgUploadPath, $wgSystemGiftsScripts;

		$wgOut->addExtensionStyle( $wgSystemGiftsScripts . '/SystemGift.css' );

		$output = ''; // Prevent E_NOTICE

		// If gift ID wasn't passed in the URL parameters or if it's not
		// numeric, display an error message
		$giftId = $wgRequest->getInt( 'gift_id' );
		if ( !$giftId || !is_numeric( $giftId ) ) {
			$wgOut->setPageTitle( wfMsg( 'ga-error-title' ) );
			$wgOut->addHTML( wfMsg( 'ga-error-message-invalid-link' ) );
			return false;
		}

		$gift = UserSystemGifts::getUserGift( $giftId );

		if ( $gift ) {
			if ( $gift['status'] == 1 ) {
				if ( $gift['user_name'] == $wgUser->getName() ) {
					$g = new UserSystemGifts( $gift['user_name'] );
					$g->clearUserGiftStatus( $gift['id'] );
					$g->decNewSystemGiftCount( $wgUser->getID() );
				}
			}
			// DB stuff
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				'user_system_gift',
				array(
					'DISTINCT sg_user_name', 'sg_user_id', 'sg_gift_id',
					'sg_date'
				),
				array(
					"sg_gift_id = {$gift['gift_id']}",
					"sg_user_name <> '" . $dbr->strencode( $gift['user_name'] ) . "'"
				),
				__METHOD__,
				array(
					'GROUP BY' => 'sg_user_name',
					'ORDER BY' => 'sg_date DESC',
					'OFFSET' => 0,
					'LIMIT' => 6
				)
			);

			$wgOut->setPageTitle( wfMsg( 'ga-gift-title', $gift['user_name'], $gift['name'] ) );

			$profileURL = Title::makeTitle( NS_USER, $gift['user_name'] )->escapeFullURL();
			$output .= '<div class="back-links">' .
				wfMsg( 'ga-back-link', $profileURL, $gift['user_name'] ) .
			'</div>';

			$message = $wgOut->parse( trim( $gift['description'] ), false );
			$output .= '<div class="ga-description-container">';

			$giftImage = "<img src=\"{$wgUploadPath}/awards/" .
				SystemGifts::getGiftImage( $gift['gift_id'], 'l' ) .
				'" border="0" alt=""/>';

			$output .= "<div class=\"ga-description\">
					{$giftImage}
					<div class=\"ga-name\">{$gift['name']}</div>
					<div class=\"ga-timestamp\">({$gift['timestamp']})</div>
					<div class=\"ga-description-message\">\"{$message}\"</div>";
			$output .= '<div class="cleared"></div>
				</div>';

			// If someone else in addition to the current user has gotten this
			// award, then and only then show the "Other recipients of this
			// award" header and the list of avatars
			if ( $gift['gift_count'] > 1 ) {
				$output .= '<div class="ga-recent">
					<div class="ga-recent-title">' .
						wfMsg( 'ga-recent-recipients-award' ) .
					'</div>
					<div class="ga-gift-count">' .
						wfMsgExt(
							'ga-gift-given-count',
							'parsemag',
							$gift['gift_count']
						) .
					'</div>';

				foreach ( $res as $row ) {
					$userToId = $row->sg_user_id;
					$avatar = new wAvatar( $userToId, 'ml' );
					$userNameLink = Title::makeTitle( NS_USER, $row->sg_user_name );

					$output .= '<a href="' . $userNameLink->escapeFullURL() . "\">
					{$avatar->getAvatarURL()}
				</a>";
				}

				$output .= '<div class="cleared"></div>
				</div>'; // .ga-recent
			}

			$output .= '</div>';

			$wgOut->addHTML( $output );
		} else {
			$wgOut->setPageTitle( wfMsg( 'ga-error-title' ) );
			$wgOut->addHTML( wfMsg( 'ga-error-message-invalid-link' ) );
		}
	}
}

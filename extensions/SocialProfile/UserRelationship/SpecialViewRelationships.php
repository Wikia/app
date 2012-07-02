<?php
/**
 * A special page for viewing all relationships by type
 * Example URL: index.php?title=Special:ViewRelationships&user=Pean&rel_type=1 (viewing friends)
 * Example URL: index.php?title=Special:ViewRelationships&user=Pean&rel_type=2 (viewing foes)
 *
 * @file
 * @ingroup Extensions
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialViewRelationships extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'ViewRelationships' );
	}

	/**
	 * Show the special page
	 *
	 * @param $params Mixed: parameter(s) passed to the page or null
	 */
	public function execute( $params ) {
		global $wgUser, $wgOut, $wgRequest, $wgUserRelationshipScripts, $wgLang;

		$wgOut->addExtensionStyle( $wgUserRelationshipScripts . '/UserRelationship.css' );

		$output = '';

		/**
		 * Get query string variables
		 */
		$user_name = $wgRequest->getVal( 'user' );
		$rel_type = $wgRequest->getInt( 'rel_type' );
		$page = $wgRequest->getInt( 'page' );

		/**
		 * Redirect Non-logged in users to Login Page
		 * It will automatically return them to the ViewRelationships page
		 */
		if ( !$wgUser->isLoggedIn() && $user_name == '' ) {
			$wgOut->setPageTitle( wfMsg( 'ur-error-page-title' ) );
			$login = SpecialPage::getTitleFor( 'Userlogin' );
			$wgOut->redirect( $login->escapeFullURL( 'returnto=Special:ViewRelationships' ) );
			return false;
		}

		/**
		 * Set up config for page / default values
		 */
		if ( !$page || !is_numeric( $page ) ) {
			$page = 1;
		}
		if ( !$rel_type || !is_numeric( $rel_type ) ) {
			$rel_type = 1;
		}
		$per_page = 50;
		$per_row = 2;

		/**
		 * If no user is set in the URL, we assume its the current user
		 */
		if ( !$user_name ) {
			$user_name = $wgUser->getName();
		}
		$user_id = User::idFromName( $user_name );
		$userPage = Title::makeTitle( NS_USER, $user_name );

		/**
		 * Error message for username that does not exist (from URL)
		 */
		if ( $user_id == 0 ) {
			$wgOut->setPageTitle( wfMsg( 'ur-error-title' ) );
			$out = '<div class="relationship-error-message">' .
				wfMsg( 'ur-error-message-no-user' ) .
			'</div>
			<div class="relationship-request-buttons">
				<input type="button" class="site-button" value="' . wfMsg( 'ur-main-page' ) . '" onclick=\'window.location="index.php?title=' . wfMsgForContent( 'mainpage' ) . '"\' />';
			if ( $wgUser->isLoggedIn() ) {
				$out .= '<input type="button" class="site-button" value="' . wfMsg( 'ur-your-profile' ) . '" onclick=\'window.location="' . $wgUser->getUserPage()->escapeFullURL() . '"\' />';
			}
			$out .= '</div>';
			$wgOut->addHTML( $out );
			return false;
		}

		/**
		 * Get all relationships
		 */
		$rel = new UserRelationship( $user_name );
		$relationships = $rel->getRelationshipList( $rel_type, $per_page, $page );

		$stats = new UserStats( $rel->user_id, $rel->user_name );
		$stats_data = $stats->getUserStats();
		$friend_count = $stats_data['friend_count'];
		$foe_count = $stats_data['foe_count'];

		$back_link = Title::makeTitle( NS_USER, $rel->user_name );
		$inviteContactsLink = SpecialPage::getTitleFor( 'InviteContacts' );

		if ( $rel_type == 1 ) {
			$output .= $wgOut->setPageTitle( wfMsg( 'ur-title-friend', $rel->user_name ) );
			$total = $friend_count;
			$rem = wfMsg( 'ur-remove-relationship-friend' );
			$output .= '<div class="back-links">
			<a href="' . $back_link->escapeFullURL() . '">' .
				wfMsg( 'ur-backlink', $rel->user_name ) .
			'</a>
		</div>
		<div class="relationship-count">' .
			wfMsgExt(
				'ur-relationship-count-friends',
				'parsemag',
				$rel->user_name,
				$total,
				$inviteContactsLink->escapeFullURL()
			) . '</div>';
		} else {
			$output .= $wgOut->setPageTitle( wfMsg( 'ur-title-foe', $rel->user_name ) );
			$total = $foe_count;
			$rem = wfMsg( 'ur-remove-relationship-foe' );
			$output .= '<div class="back-links">
			<a href="' . $back_link->escapeFullURL() . '">' .
				wfMsg( 'ur-backlink', $rel->user_name ) .
			'</a>
		</div>
		<div class="relationship-count">'
			. wfMsgExt(
				'ur-relationship-count-foes',
				'parsemag',
				$rel->user_name,
				$total,
				$inviteContactsLink->escapeFullURL()
			) . '</div>';
		}

		if ( $relationships ) {
			$x = 1;

			foreach ( $relationships as $relationship ) {
				$indivRelationship = UserRelationship::getUserRelationshipByID(
					$relationship['user_id'],
					$wgUser->getID()
				);

				// Safe titles
				$userPage = Title::makeTitle( NS_USER, $relationship['user_name'] );
				$addRelationshipLink = SpecialPage::getTitleFor( 'AddRelationship' );
				$removeRelationshipLink = SpecialPage::getTitleFor( 'RemoveRelationship' );
				$giveGiftLink = SpecialPage::getTitleFor( 'GiveGift' );

				$avatar = new wAvatar( $relationship['user_id'], 'ml' );

				$avatar_img = $avatar->getAvatarURL();

				$user_safe = urlencode( $relationship['user_name'] );

				$username_length = strlen( $relationship['user_name'] );
				$username_space = stripos( $relationship['user_name'], ' ' );

				if ( ( $username_space == false || $username_space >= "30" ) && $username_length > 30 ) {
					$user_name_display = substr( $relationship['user_name'], 0, 30 ) .
						' ' . substr( $relationship['user_name'], 30, 50 );
				} else {
					$user_name_display = $relationship['user_name'];
				}

				$output .= "<div class=\"relationship-item\">
					<a href=\"{$userPage->escapeFullURL()}\">{$avatar_img}</a>
					<div class=\"relationship-info\">
						<div class=\"relationship-name\">
							<a href=\"{$userPage->escapeFullURL()}\">{$user_name_display}</a>
						</div>
					<div class=\"relationship-actions\">";
				if ( $indivRelationship == false ) {
					$output .= $wgLang->pipeList( array(
						'<a href="' . $addRelationshipLink->escapeFullURL( 'user=' . $user_safe . '&rel_type=1' ) . '">' . wfMsg( 'ur-add-friend' ) . '</a>',
						'<a href="' . $addRelationshipLink->escapeFullURL( 'user=' . $user_safe . '&rel_type=2' ) . '">' . wfMsg( 'ur-add-foe' ) . '</a>',
						''
					) );
				} elseif ( $user_name == $wgUser->getName() ) {
					$output .= '<a href="' . $removeRelationshipLink->escapeFullURL( 'user=' . $user_safe ) . '">' . $rem . '</a>';
					$output .= wfMsgExt( 'pipe-separator', 'escapenoentities' );
				}
				$output .= '<a href="' . $giveGiftLink->escapeFullURL( 'user=' . $user_safe ) . '">' . wfMsg( 'ur-give-gift' ) . '</a>';

				$output .= '</div>
					<div class="cleared"></div>
				</div>';

				$output .= '</div>';
				if ( $x == count( $relationships ) || $x != 1 && $x % $per_row == 0 ) {
					$output .= '<div class="cleared"></div>';
				}
				$x++;
			}
		}

		/**
		 * Build next/prev nav
		 */
		$total = intval( str_replace( ',', '', $total ) );
		$numofpages = $total / $per_page;

		$pageLink = SpecialPage::getTitleFor( 'ViewRelationships' );

		if ( $numofpages > 1 ) {
			$output .= '<div class="page-nav">';
			if ( $page > 1 ) {
				$output .= '<a href="' . $pageLink->escapeFullURL( 'user=' . $user_name . '&rel_type=' . $rel_type . '&page=' . ( $page - 1 ) ) . '">' . wfMsg( 'ur-previous' ) . '</a> ';
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
					$output .= '<a href="' . $pageLink->escapeFullURL( 'user=' . $user_name . '&rel_type=' . $rel_type . '&page=' . $i ) . "\">$i</a> ";
				}
			}

			if ( ( $total - ( $per_page * $page ) ) > 0 ) {
				$output .= ' <a href="' . $pageLink->escapeFullURL( 'user=' . $user_name . '&rel_type=' . $rel_type . '&page=' . ( $page + 1 ) ) . '">' . wfMsg( 'ur-next' ) . '</a>';
			}
			$output .= '</div>';
		}

		$wgOut->addHTML( $output );
	}
}

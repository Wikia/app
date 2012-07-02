<?php
/**
 * Special:UserActivity - a special page for showing recent social activity
 * The class is called "UserHome" because the "UserActivity" class is at
 * UserActivityClass.php.
 *
 * @file
 * @ingroup Extensions
 */

class UserHome extends SpecialPage {
	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'UserActivity' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgScriptPath;

		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SocialProfile/UserActivity/UserActivity.css' );

		$wgOut->setPageTitle( wfMsg( 'useractivity-title' ) );

		$output = '';

		$rel_type = $wgRequest->getVal( 'rel_type' );
		$item_type = $wgRequest->getVal( 'item_type' );

		if ( !$rel_type ) {
			$rel_type = 1;
		}
		if ( !$item_type ) {
			$item_type = 'all';
		}

		// If not otherwise specified, display everything but votes in the feed
		if ( $item_type == 'edits' || $item_type == 'all' ) {
			$edits = 1;
		}
		if ( $item_type == 'votes' || $item_type == 'all' ) {
			$votes = 0;
		}
		if ( $item_type == 'comments' || $item_type == 'all' ) {
			$comments = 1;
		}
		if ( $item_type == 'gifts' || $item_type == 'all' ) {
			$gifts = 1;
		}
		if ( $item_type == 'relationships' || $item_type == 'all' ) {
			$relationships = 1;
		}
		if ( $item_type == 'advancements' || $item_type == 'all' ) {
			$messages = 1;
		}
		if ( $item_type == 'awards' || $item_type == 'all' ) {
			$system_gifts = 1;
		}
		if ( $item_type == 'messages' || $item_type == 'all' ) {
			$messages_sent = 1;
		}

		$output .= '<div class="user-home-feed">';

		$rel = new UserActivity( $wgUser->getName(), ( ( $rel_type == 1 ) ? ' friends' : 'foes' ), 50 );
		$rel->setActivityToggle( 'show_edits', $edits );
		$rel->setActivityToggle( 'show_votes', $votes );
		$rel->setActivityToggle( 'show_comments', $comments );
		$rel->setActivityToggle( 'show_gifts_rec', $gifts );
		$rel->setActivityToggle( 'show_relationships', $relationships );
		$rel->setActivityToggle( 'show_system_messages', $messages );
		$rel->setActivityToggle( 'show_system_gifts', $system_gifts );
		$rel->setActivityToggle( 'show_messages_sent', $messages_sent );

		/**
		 * Get all relationship activity
		 */
		$activity = $rel->getActivityListGrouped();
		$border_fix = '';

		if ( $activity ) {
			$x = 1;

			foreach ( $activity as $item ) {
				if ( $x < 40 ) {
					if (
						( ( count( $activity ) > 40 ) && ( $x == 39 ) ) ||
						( ( count( $activity ) < 40 ) && ( $x == ( count( $activity ) - 1 ) ) )
					) {
						$border_fix = ' border-fix';
					}

					$typeIcon = UserActivity::getTypeIcon( $item['type'] );
					$output .= "<div class=\"user-home-activity{$border_fix}\">
						<img src=\"{$wgScriptPath}/extensions/SocialProfile/images/" . $typeIcon . "\" alt=\"\" border=\"0\" />
						{$item['data']}
					</div>";
					$x++;
				}
			}
		}

		$output .= '</div>
		<div class="cleared"></div>';
		$wgOut->addHTML( $output );
	}
}

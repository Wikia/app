<?php

class ViewFans extends UnlistedSpecialPage {

	public $network;

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'ViewFans' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgScriptPath, $wgUploadPath;

		$output = '';

		/**
		 * Get query string variables
		 */
		$page = $wgRequest->getInt( 'page', 1 );
		$sport_id = $wgRequest->getVal( 'sport_id' );
		$team_id = $wgRequest->getVal( 'team_id' );

		/**
		 * Error message for teams/sports that do not exist (from URL)
		 */
		if( !$team_id && !$sport_id ) {
			$wgOut->setPageTitle( wfMsg( 'sportsteams-network-woops-title' ) );
			$out = '<div class="relationship-request-message">' .
				wfMsg( 'sportsteams-network-woops-text' ) . '</div>';
			$out .= '<div class="relationship-request-buttons">';
			$out .= '<input type="button" class="site-button" value="' .
				wfMsg( 'sportsteams-network-main-page' ) .
				"\" onclick=\"window.location='" .
				Title::newMainPage()->escapeFullURL() . "'\"/>";
			if ( $wgUser->isLoggedIn() ) {
				$out .= ' <input type="button" class="site-button" value="' .
					wfMsg( 'sportsteams-network-your-profile' ) .
					"\" onclick=\"window.location='" .
					Title::makeTitle( NS_USER, $wgUser->getName() )->escapeFullURL() . "'\"/>";
			}
		  	$out .= '</div>';
			$wgOut->addHTML( $out );
			return false;
		}

		// Add CSS
		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$wgOut->addModuleStyles( 'ext.sportsTeams' );
		} else {
			$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SportsTeams/SportsTeams.css' );
		}

		$relationships = array();
		$friends = array();
		$foes = array();
		if( $wgUser->isLoggedIn() ) {
			$friends = $this->getRelationships( 1 );
			$foes = $this->getRelationships( 2 );
			$relationships = array_merge( $friends, $foes );
		}

		/**
		 * Set up config for page / default values
		 */
		$per_page = 50;
		$per_row = 2;

		if( $team_id ) {
			$team = SportsTeams::getTeam( $team_id );
			$this->network = $team['name'];
			$team_image = "<img src=\"{$wgUploadPath}/team_logos/" .
				SportsTeams::getTeamLogo( $team_id, 'l' ) .
				'" border="0" alt="' . wfMsg( 'sportsteams-network-alt-logo' ) . '" />';
		} else {
			$sport = SportsTeams::getSport( $sport_id );
			$this->network = $team['name'];
			$team_image = "<img src=\"{$wgUploadPath}/team_logos/" .
				SportsTeams::getSportLogo( $sport_id, 'l' ) .
				'" border="0" alt="' . wfMsg( 'sportsteams-network-alt-logo' ) . '" />';
		}
		$homepage_title = SpecialPage::getTitleFor( 'FanHome' );

		$total = SportsTeams::getUserCount( $sport_id, $team_id );

		/* Get all fans */
		$fans = SportsTeams::getUsersByFavorite(
			$sport_id, $team_id, $per_page, $page
		);

		$wgOut->setPageTitle( wfMsg( 'st-network-network-fans', $this->network ) );

		$output .= '<div class="friend-links">';
		$output .= "<a href=\"". $homepage_title->getFullURL(
			"sport_id={$sport_id}&team_id={$team_id}"
		) . '">' . wfMsg( 'sportsteams-network-back-to-network', $this->network ) . '</a>';
		$output .= '</div>';

		/* Show total fan count */
		$output .= '<div class="friend-message">' .
			wfMsgExt(
				'sportsteams-network-num-fans',
				'parsemag',
				$this->network,
				$total,
				SpecialPage::getTitleFor( 'InviteContacts' )->escapeFullURL()
			);
		$output .= '</div>';

		if( $fans ) {
			$x = 1;

			foreach ( $fans as $fan ) {
				$user = Title::makeTitle( NS_USER, $fan['user_name'] );
				$avatar = new wAvatar( $fan['user_id'], 'l' );
				$avatar_img = $avatar->getAvatarURL();

				$output .= "<div class=\"relationship-item\">
						<div class=\"relationship-image\"><a href=\"{$user->getFullURL()}\">{$avatar_img}</a></div>
						<div class=\"relationship-info\">
						<div class=\"relationship-name\">
							<a href=\"{$user->getFullURL()}\">{$fan['user_name']}</a>";

				$output .= '</div>
					<div class="relationship-actions">';
				if( in_array( $fan['user_id'], $friends ) ) {
					$output .= '	<span class="profile-on">' . wfMsg( 'sportsteams-your-friend' ) . '</span> ';
				}
				if( in_array( $fan['user_id'], $foes ) ) {
					$output .= '	<span class="profile-on">' . wfMsg( 'sportsteams-your-foe' ) . '</span> ';
				}
				if( $fan['user_name'] != $wgUser->getName() ) {
					if( !in_array( $fan['user_id'], $relationships ) ) {
						$ar = SpecialPage::getTitleFor( 'AddRelationship' );
						$output .= '<a href="' . $ar->escapeFullURL( "user={$fan['user_name']}&rel_type=1" ) . '">' .
							wfMsg( 'sportsteams-add-as-friend' ) . '</a> | ';
						$output .= '<a href="' . $ar->escapeFullURL( "user={$fan['user_name']}&rel_type=2" ) . '">' .
							wfMsg( 'sportsteams-add-as-foe' ) . '</a> | ';
					}
					$output .= '<a href="' . SpecialPage::getTitleFor( 'GiveGift' )->escapeFullURL( "user={$fan['user_name']}" ) . '">' .
						wfMsg( 'sportsteams-give_a_gift' ) . '</a> ';
					//$output .= "<p class=\"relationship-link\"><a href=\"index.php?title=Special:ChallengeUser&user={$fan['user_name']}\"><img src=\"images/common/challengeIcon.png\" border=\"0\" alt=\"issue challenge\"/> issue challenge</a></p>";
					$output .= '<div class="cleared"></div>';
				}
				$output .= '</div>';

				$output .= '<div class="cleared"></div></div>';

				$output .= '</div>';
				if( $x == count( $fans ) || $x != 1 && $x % $per_row == 0 ) {
					$output .= '<div class="cleared"></div>';
				}
				$x++;
			}
		}

		/**
		 * Build next/prev navigation
		 */
		$numofpages = $total / $per_page;

		if ( $numofpages > 1 ) {
			$output .= '<div class="page-nav">';
			if( $page > 1 ) {
				$output .= '<a href="' . $this->getTitle()->escapeFullURL(
					'page=' . ( $page - 1 ) . "&sport_id={$sport_id}&team_id={$team_id}"
				) . '">' . wfMsg( 'sportsteams-prev' ) . '</a> ';
			}

			if( ( $total % $per_page ) != 0 ) {
				$numofpages++;
			}
			if( $numofpages >= 9 ) {
				$numofpages = 9 + $page;
			}

			for( $i = 1; $i <= $numofpages; $i++ ) {
				if( $i == $page ) {
				    $output .= ( $i . ' ' );
				} else {
				    $output .= '<a href="' . $this->getTitle()->escapeFullURL(
						'page=' . ( $i ) . "&sport_id={$sport_id}&team_id={$team_id}"
					) . "\">$i</a> ";
				}
			}

			if( ( $total - ( $per_page * $page ) ) > 0 ) {
				$output .= ' <a href="' . $this->getTitle()->escapeFullURL(
					'page=' . ( $page + 1 ) . "&sport_id={$sport_id}&team_id={$team_id}"
				) . '">' . wfMsg( 'sportsteams-next' ) . '</a>';
			}
			$output .= '</div>';
		}

		$wgOut->addHTML( $output );
	}

	function getRelationships( $rel_type ) {
		global $wgUser;
		$rel = new UserRelationship( $wgUser->getName() );
		$relationships = $rel->getRelationshipIDs( $rel_type );
		return $relationships;
	}
}
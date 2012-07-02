<?php

class SimilarFans extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'SimilarFans' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgLang, $wgScriptPath;

		/**
		 * Redirect non-logged in users to Login Page
		 * It will automatically return them to the SimilarFans page
		 */
		if( $wgUser->getID() == 0 ) {
			$wgOut->setPageTitle( wfMsg( 'sportsteams-woops' ) );
			$login = SpecialPage::getTitleFor( 'Userlogin' );
			$wgOut->redirect( $login->getFullURL( 'returnto=Special:SimilarFans' ) );
			return false;
		}

		// Add CSS
		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$wgOut->addModuleStyles( 'ext.sportsTeams' );
		} else {
			$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SportsTeams/SportsTeams.css' );
		}

		$output = '';

		/**
		 * Get query string variables
		 */
		$page = $wgRequest->getInt( 'page', 1 );

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

		$total = SportsTeams::getSimilarUserCount( $wgUser->getID() );

		/* Get all fans */
		$fans = SportsTeams::getSimilarUsers( $wgUser->getID(), $per_page, $page );

		$wgOut->setPageTitle( wfMsg( 'sportsteams-similar-fans' ) );

		//$output .= '<div class="friend-links">';
		//$output .= "<a href=\"{$homepage_title->getFullURL()}&sport_id={$sport_id}&team_id={$team_id}\">< Back to Network Home</a>";
		//$output .= '</div>';

		/* Show total fan count */
		$output .= '<div class="relationship-count">' .
			wfMsgExt( 'sportsteams-num-similar', 'parsemag', $total ) .
			' <a href="' . SpecialPage::getTitleFor( 'InviteContacts' )->escapeFullURL() . '">' .
				wfMsg( 'sportsteams-invite-friends' ) . '</a>.';
		$output .= '</div>';

		if( $fans ) {
			$x = 1;

			foreach ( $fans as $fan ) {
				$user_name_display = $wgLang->truncate( $fan['user_name'], 30 );

				$user = Title::makeTitle( NS_USER, $fan['user_name'] );
				$avatar = new wAvatar( $fan['user_id'], 'ml' );
				$avatar_img = $avatar->getAvatarURL();

				$output .= "<div class=\"relationship-item\">
							<div class=\"relationship-image\"><a href=\"{$user->getFullURL()}\">{$avatar_img}</a></div>
							<div class=\"relationship-info\">
								<div class=\"relationship-name\"><a href=\"{$user->getFullURL()}\">{$user_name_display}</a>";

				$output .= '</div>
					<div class="relationship-actions">';
				$rr = SpecialPage::getTitleFor( 'RemoveRelationship' );
				$ar = SpecialPage::getTitleFor( 'AddRelationship' );
				if( in_array( $fan['user_id'], $friends ) ) {
					$output .= ' <a href="' . $rr->escapeFullURL( "user={$user->getText()}" ) . '">' .
						wfMsg( 'sportsteams-remove-as-friend' ) . '</a> | ';
				}
				if( in_array( $fan['user_id'], $foes ) ) {
					$output .= ' <a href="' . $rr->escapeFullURL( "user={$user->getText()}" ) . '">' .
						wfMsg( 'sportsteams-remove-as-foe' ) . '</a> | ';
				}
				if( $fan['user_name'] != $wgUser->getName() ) {
					if( !in_array( $fan['user_id'], $relationships ) ) {
						$output .= '<a href="' . $ar->escapeFullURL( "user={$fan['user_name']}&rel_type=1" ) . '">' .
							wfMsg( 'sportsteams-add-as-friend' ) . '</a> | ';
						$output .= '<a href="' . $ar->escapeFullURL( "user={$fan['user_name']}&rel_type=2" ) . '">' .
							wfMsg( 'sportsteams-add-as-foe' ) . '</a> | ';
					}
					$output .= '<a href="' . SpecialPage::getTitleFor( 'GiveGift' )->escapeFullURL( "user={$fan['user_name']}" ) . '">' .
						wfMsg( 'sportsteams-give-a-gift' ) . '</a> ';
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

		if( $numofpages > 1 ) {
			$output .= '<div class="page-nav">';
			if( $page > 1 ) {
				$output .= '<a href="' .
					$this->getTitle()->getFullURL( 'page=' . ( $page - 1 ) ) .
					'">' . wfMsg( 'sportsteams-prev' ) . "</a> ";
			}

			if( ( $total % $per_page ) != 0 ) {
				$numofpages++;
			}
			if( $numofpages >= 9 ) {
				$numofpages = 9 + $page;
			}

			for( $i = 1; $i <= $numofpages; $i++ ) {
				if( $i == $page ) {
					$output .= ( $i . ' ');
				} else {
					$output .= '<a href="' . $this->getTitle()->getFullURL( "page=$i" ) . "\">$i</a> ";
				}
			}

			if( ( $total - ( $per_page * $page ) ) > 0 ) {
				$output .= ' <a href="' . 
					$this->getTitle()->getFullURL( 'page=' . ( $page + 1 ) ) .
					'">' . wfMsg( 'sportsteams-next' ) . '</a>';
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
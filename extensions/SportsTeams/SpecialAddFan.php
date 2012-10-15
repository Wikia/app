<?php

class AddFan extends UnlistedSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'AddFan' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgRequest, $wgScriptPath, $wgUser;

		$output = '';

		/**
		 * Get query string variables
		 */
		$sport_id = $wgRequest->getVal( 'sport_id' );
		$team_id = $wgRequest->getVal( 'team_id' );

		// Add CSS
		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$wgOut->addModuleStyles( 'ext.sportsTeams' );
		} else {
			$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SportsTeams/SportsTeams.css' );
		}

		/**
		 * Error message for URL with no team and sport specified
		 */
		if( !$team_id && !$sport_id ) {
			$wgOut->setPageTitle( wfMsg( 'sportsteams-network-woops-title' ) );
			$out .= '<div class="relationship-request-message">' .
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

		// If the database is in read-only mode, bail out
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return true;
		}

		if( $team_id ) {
			$team = SportsTeams::getTeam( $team_id );
			$name = $team['name'];
		} else {
			$sport = SportsTeams::getSport( $sport_id );
			$name = $sport['name'];
		}

		if( $wgRequest->wasPosted() ) {
			$s = new SportsTeams();
			$s->addFavorite(
				$wgUser->getID(),
				$wgRequest->getVal( 's_id' ),
				$wgRequest->getVal( 't_id' )
			);

			$view_fans_title = SpecialPage::getTitleFor( 'ViewFans' );
			$invite_title = SpecialPage::getTitleFor( 'InviteContacts' );

			$wgOut->setPageTitle( wfMsg( 'sportsteams-network-now-member', $name ) );
			$output .= '<div class="give-gift-message">
				<input type="button" class="site-button" value="' .
					wfMsg( 'sportsteams-network-invite-more', $name ) .
					" \" onclick=\"window.location='{$invite_title->getFullURL()}'\"/>
				<input type=\"button\" class=\"site-button\" value=\"" .
					wfMsg( 'sportsteams-network-find-other', $name ) .
					" \" onclick=\"window.location='" .
					$view_fans_title->getFullURL( "sport_id={$sport_id}&team_id={$team_id}" ) . "'\"/>
			</div>";
		} else {
			/**
			 * Error message if you are already a fan
			 */
			if( SportsTeams::isFan( $wgUser->getID(), $sport_id, $team_id ) == true ) {
				$wgOut->setPageTitle( wfMsg( 'sportsteams-network-already-member', $name ) );
				$out .= '<div class="relationship-request-message">' .
					wfMsg( 'sportsteams-network-no-need-join' ) . '</div>';
				$out .= "<div class=\"relationship-request-buttons\">";
				$out .= "<input type=\"button\" class=\"site-button\" value=\"" .
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

			$wgOut->setPageTitle( wfMsg( 'sportsteams-network_join_named_network', $name ) );

			$output .= '<form action="" method="post" enctype="multipart/form-data" name="form1">

				<div class="give-gift-message" style="margin:0px 0px 0px 0px;">' .
					wfMsg( 'sportsteams-network-join-are-you-sure', $name ) .
				"</div>

				<div class=\"cleared\"></div>
				<div class=\"give-gift-buttons\">
					<input type=\"hidden\" name=\"s_id\" value=\"{$sport_id}\" />
					<input type=\"hidden\" name=\"t_id\" value=\"{$team_id}\" />
					<input type=\"button\" class=\"site-button\" value=\"" . wfMsg( 'sportsteams-network-join-network' ) . "\" size=\"20\" onclick=\"document.form1.submit()\" />
					<input type=\"button\" class=\"site-button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"20\" onclick=\"history.go(-1)\" />
				</div>
			</form>";
		}

		$wgOut->addHTML( $output );
	}
}
<?php

class RemoveFan extends UnlistedSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'RemoveFan' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgTitle, $wgScriptPath;

		$output = '';

		/**
		 * Get query string variables
		 */
		$sport_id = $wgRequest->getInt( 'sport_id' );
		$team_id = $wgRequest->getInt( 'team_id' );

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
			$out = '<div class="relationship-request-message">' .
				wfMsg( 'sportsteams-network-woops-text' ) . '</div>';
			$out .= '<div class="relationship-request-buttons">';
			$out .= '<input type="button" class="site-button" value="' .
				wfMsg( 'sportsteams-network-main-page' ) . "\" onclick=\"window.location='" .
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
			$s->removeFavorite(
				$wgUser->getID(),
				$wgRequest->getVal( 's_id' ),
				$wgRequest->getVal( 't_id' )
			);

			$wgOut->setPageTitle( wfMsg( 'sportsteams-network-no-longer-member', $name ) );
			$output .= '<div class="give-gift-message">
				<input type="button" class="site-button" value="' .
					wfMsg( 'sportsteams-network-main-page' ) .
					"\" onclick=\"window.location='" .
					Title::newMainPage()->escapeFullURL() . "'\"/>
				<input type=\"button\" class=\"site-button\" value=\"" .
					wfMsg( 'sportsteams-network-your-profile' ) .
					"\" onclick=\"window.location='" .
					Title::makeTitle( NS_USER, $wgUser->getName() )->escapeFullURL() . "'\"/>
			</div>";
		} else {
			/**
			 * Error message if the user is not a fan
			 */
			if( !SportsTeams::isFan( $wgUser->getID(), $sport_id, $team_id ) == true ) {
				$wgOut->setPageTitle( wfMsg( 'sportsteams-network-not-member', $name ) );
				//out .= '<div class="relationship-request-message">' . wfMsg( 'sportsteams-network-no-need-join' ) . '</div>';
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
			$wgOut->setPageTitle( wfMsg( 'sportsteams-network-leave', $name ) );

			$output .= '<form action="" method="post" enctype="multipart/form-data" name="form1">

				<div class="give-gift-message" style="margin:0px 0px 0px 0px;">' .
					wfMsg( 'sportsteams-network-leave-are-you-sure', $name ) .
				"</div>

				<div class=\"cleared\"></div>
				<div class=\"give-gift-buttons\">
					<input type=\"hidden\" name=\"s_id\" value=\"{$sport_id}\" />
					<input type=\"hidden\" name=\"t_id\" value=\"{$team_id}\" />
					<input type=\"button\" class=\"site-button\" value=\"" . wfMsg( 'sportsteams-network-remove-me' ) . "\" size=\"20\" onclick=\"document.form1.submit()\" />
					<input type=\"button\" class=\"site-button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"20\" onclick=\"history.go(-1)\" />
				</div>
			</form>";
		}

		$wgOut->addHTML( $output );
	}
}
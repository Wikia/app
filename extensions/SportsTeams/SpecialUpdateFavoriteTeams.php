<?php
/**
 * The messages used by this special page are provided by SocialProfile's
 * UserProfile, since this file used to be originally a part of UserProfile and
 * the messages in question weren't taken out when SocialProfile was released.
 * I should probably move 'em to SportsTeams' i18n file one day.
 *
 * @file
 * @version r25
 */
class UpdateFavoriteTeams extends UnlistedSpecialPage {

	var $favorite_counter = 1;
	var $sports = array();

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'UpdateFavoriteTeams' );
	}

	/**
	 * Get all sports from the database and set them into the sports class
	 * member variable.
	 */
	function getSports() {
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			'sport',
			array( 'sport_id', 'sport_name' ),
			array(),
			__METHOD__,
			array( 'ORDER BY' => 'sport_order' )
		);

		foreach ( $res as $row ) {
			$this->sports[] = array(
				'id' => $row->sport_id,
				'name' => $row->sport_name
			);
		}

		return $this->sports;
	}

	/**
	 * Get all sports teams from the database.
	 *
	 * @param $sportId Integer: sport ID number for which to get the teams
	 * @return Array: array of teams, containing each team's ID and name
	 */
	function getTeams( $sportId ) {
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			'sport_team',
			array( 'team_id', 'team_name' ),
			array( 'team_sport_id' => $sportId ),
			__METHOD__,
			array( 'ORDER BY' => 'team_name' )
		);

		$teams = array();

		foreach ( $res as $row ) {
			$teams[] = array(
				'id' => $row->team_id,
				'name' => $row->team_name
			);
		}

		return $teams;
	}

	function getFavorites() {
		global $wgUser;

		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			'sport_favorite',
			array( 'sf_sport_id', 'sf_team_id' ),
			array( 'sf_user_id' => $wgUser->getId() ),
			__METHOD__,
			array( 'ORDER BY' => 'sf_order' )
		);

		$favorites = array();

		foreach ( $res as $row ) {
			$favorites[] = array(
				'sport_id' => $row->sf_sport_id,
				'team_id' => $row->sf_team_id
			);
		}

		return $favorites;
	}

	function getSportsDropdown( $selected_sport_id = 0, $selected_team_id = 0 ) {
		global $wgScriptPath;

		// Set Current Sport Dropdown - show first one, or saved team
		if( $this->favorite_counter == 1 || $selected_sport_id > 0 ) {
			$style = 'display: block;';
		} else {
			$style = 'display: none;';
		}

		$output = '';

		$remove_link = '';
		if( $selected_sport_id || $selected_team_id ) {
			$remove_link = "<a href=\"javascript:void(0)\" onclick=\"javascript:UpdateFavoriteTeams.removeFan({$selected_sport_id},{$selected_team_id})\">
				<img src=\"{$wgScriptPath}/extensions/SportsTeams/closeIcon.gif\" border=\"0\"/>
			</a>";
		}

		$output .= "<div id=\"fav_{$this->favorite_counter}\" style=\"{$style};padding-bottom: 15px;\">
			<p class=\"profile-update-title\">" .
				wfMsgExt(
					'sportsteams-updatefavoriteteams-favorite',
					'parsemag',
					$this->favorite_counter
				) . " {$remove_link}</p>
				<p class=\"profile-update-unit-left\"> " .
					wfMsg( 'user-profile-sports-sport' ) .
				" </p>
				<p class=\"profile-update-unit-right\">
				<select name=\"sport_{$this->favorite_counter}\" id=\"sport_{$this->favorite_counter}\" onchange=\"DoubleCombo.update('team_{$this->favorite_counter}','wfGetSportTeams',this.value)\" />
					<option value=\"0\">-</option>
				</p>
				<div class=\"cleared\"></div>";

		// Build Sport Option HTML
		$sports = $this->sports;
		foreach( $sports as $sport ) {
			$output .= "<option value=\"{$sport['id']}\"" .
				( ( $sport['id'] == $selected_sport_id ) ? ' selected' : '' ) .
				">{$sport['name']}</option>\n";
		}
		$output .= '</select>';

		// If loading previously saved teams, we need to build the options for
		// the associated sport to show the team they already have selected
		$team_opts = '';
		$teams = array();

		if( $selected_team_id > 0 ) {
			$teams = $this->getTeams( $selected_sport_id );
		}

		foreach( $teams as $team ) {
			$team_opts.= "<option value=\"{$team['id']}\"" .
				( ( $team['id'] == $selected_team_id ) ? ' selected' : '' ) .
				">{$team['name']}</option>";
		}

		$output .= '<p class="profile-update-unit-left">' .
			wfMsg( 'sportsteams-updatefavoriteteams-team' ) . "</p>
				<p class=\"profile-update-unit\">
				<select name=\"team_{$this->favorite_counter}\" id=\"team_{$this->favorite_counter}\" onchange=\"UpdateFavoriteTeams.showNext();\" />
					{$team_opts}
				</select>
			    </p>
				<div class=\"cleared\"></div>

			</div>";

		$this->favorite_counter++;

		return $output;
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgRequest, $wgScriptPath, $wgUser;

		if( !$wgUser->isLoggedIn() ) {
			$wgOut->setPageTitle( wfMsg( 'user-profile-sports-notloggedintitle' ) );
			$wgOut->addHTML( wfMsg( 'user-profile-sports-notloggedintitle' ) );
			return;
		}

		// If the database is in read-only mode, bail out
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return true;
		}

		$sports = $this->getSports();
		// Error message when there are no sports in the database
		if ( empty( $sports ) ) {
			$wgOut->setPageTitle( wfMsg( 'sportsteams-error-no-sports-title' ) );
			$wgOut->addWikiMsg( 'sportsteams-error-no-sports-message' );
			return;
		}

		// Set the page title
		$wgOut->setPageTitle( wfMsg( 'user-profile-sports-title' ) );

		// Add CSS and JS
		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SocialProfile/UserProfile/UserProfile.css' );

		// This JS file was originally in its own directory (it was and is used
		// only by this special page and the LoginReg extension)...how silly.
		$wgOut->addScriptFile( $wgScriptPath . '/extensions/SportsTeams/DoubleCombo.js' );

		// This JS file originally didn't even exist
		$wgOut->addScriptFile( $wgScriptPath . '/extensions/SportsTeams/UpdateFavoriteTeams.js' );

		// This is annoying so I took it out for now.
		//$output = '<h1>' . wfMsg( 'user-profile-sports-title' ) . '</h1>';

		// Build the top navigation tabs
		// @todo CHECKME: there should be a UserProfile method for building all
		// this, I think
		$output = '<div class="profile-tab-bar">';
		$output .= '<div class="profile-tab">';
		$output .= '<a href="' . SpecialPage::getTitleFor( 'UpdateProfile', 'basic' )->escapeFullURL() . '">' .
			wfMsg( 'user-profile-section-personal' ) . '</a>';
		$output .= '</div>';
		$output .= '<div class="profile-tab-on">';
		$output .= wfMsg( 'user-profile-section-sportsteams' );
		$output .= '</div>';
		$output .= '<div class="profile-tab">';
		$output .= '<a href="' . SpecialPage::getTitleFor( 'UpdateProfile', 'custom' )->escapeFullURL() . '">' .
			/*wfMsg( 'user-profile-section-sportstidbits' )*/wfMsg( 'custom-info-title' ) . '</a>';
		$output .= '</div>';
		$output .= '<div class="profile-tab">';
		$output .= '<a href="' . SpecialPage::getTitleFor( 'UpdateProfile', 'personal' )->escapeFullURL() . '">' .
			wfMsg( 'user-profile-section-interests' ) . '</a>';
		$output .= '</div>';
		$output .= '<div class="profile-tab">';
		$output .= '<a href="' . SpecialPage::getTitleFor( 'UploadAvatar' )->escapeFullURL() . '">' .
			wfMsg( 'user-profile-section-picture' ) . '</a>';
		$output .= '</div>';
		$output .= '<div class="profile-tab">';
		$output .= '<a href="' . SpecialPage::getTitleFor( 'UpdateProfile', 'preferences' )->escapeFullURL() . '">' .
			wfMsg( 'user-profile-section-preferences' ) . '</a>';
		$output .= '</div>';

		$output .= '<div class="cleared"></div>';
		$output .= '</div>';

		$output .= '<div class="profile-info">';

		// If the request was POSTed, add/delete teams accordingly
		if( $wgRequest->wasPosted() ) {
			if( $wgRequest->getVal( 'action' ) == 'delete' ) {
				SportsTeams::removeFavorite(
					$wgUser->getId(),
					$wgRequest->getVal( 's_id' ),
					$wgRequest->getVal( 't_id' )
				);
				SportsTeams::clearUserCache( $wgUser->getId() );
				$wgOut->addHTML(
					'<br /><br /><span class="profile-on">' .
						wfMsg( 'user-profile-sports-teamremoved' ) .
					'</span><br /><br />'
				);
			}

			if( $wgRequest->getVal( 'favorites' ) ) {
				// Clear user cache
				SportsTeams::clearUserCache( $wgUser->getId() );

				$dbw = wfGetDB( DB_MASTER );
				// Reset old favorites
				$res = $dbw->delete(
					'sport_favorite',
					array( 'sf_user_id' => $wgUser->getId() ),
					__METHOD__
				);

				$items = explode( '|', $wgRequest->getVal( 'favorites' ) );
				foreach( $items as $favorite ) {
					if( $favorite ) {
						$atts = explode( ',', $favorite );
						$sport_id = $atts[0];
						$team_id = $atts[1];

						if( !$team_id ) {
							$team_id = 0;
						}
						$s = new SportsTeams();
						$s->addFavorite( $wgUser->getId(), $sport_id, $team_id );
					}
				}
				$wgOut->addHTML(
					'<br /><br /><span class="profile-on">' .
						wfMsg( 'user-profile-sports-teamsaved' ) .
					'</span><br /><br />'
				);
			}
		}

		$favorites = $this->getFavorites();
		foreach( $favorites as $favorite ) {
			$output .= $this->getSportsDropdown(
				$favorite['sport_id'],
				$favorite['team_id']
			);
		}

		$output .= '<div>';
		if( count( $favorites ) > 0 ) {
			$output .= '<div style="display: block" id="add_more"></div>';
		}

		for( $x = 0; $x <= ( 20 - count( $favorites ) ); $x++ ) {
			$output .= $this->getSportsDropdown();
		}

		$output .= '<form action="" name="sports" method="post">
			<input type="hidden" value="" name="favorites" />
			<input type="hidden" value="save" name="action" />';

		if( count( $favorites ) > 0 ) {
			$output .= '<input type="button" class="profile-update-button" onclick="UpdateFavoriteTeams.showNext()" value="' .
				wfMsg( 'user-profile-sports-addmore' ) . '" />';
		}

		$output .= '<input type="button" class="profile-update-button" value="' .
			wfMsg( 'user-profile-update-button' ) . '" onclick="UpdateFavoriteTeams.saveTeams()" id="update-favorite-teams-save-button" />
			</form>
			<form action="" name="sports_remove" method="post">
				<input type="hidden" value="delete" name="action" />
				<input type="hidden" value="" name="s_id" />
				<input type="hidden" value="" name="t_id" />
			</form>
			<script>
				UpdateFavoriteTeams.fav_count = ' . ( ( count( $favorites ) ) ? count( $favorites ) : 1 ) . ';
			</script>
			</div>
		</div>';

		$wgOut->addHTML( $output );
	}
}
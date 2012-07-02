<?php
/**
 * A special page to add new networks and edit existing ones.
 *
 * @file
 * @ingroup Extensions
 */
class SportsTeamsManager extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'SportsTeamsManager', 'sportsteamsmanager' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest;

		// If the user isn't allowed to access this page, display an error
		if( !$wgUser->isAllowed( 'sportsteamsmanager' ) ) {
			$wgOut->permissionRequired( 'sportsteamsmanager' );
			return;
		}

		// Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		// If the user is blocked, s/he doesn't need to access this page
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage( false );
			return false;
		}

		// Set the page title
		$wgOut->setPageTitle( wfMsg( 'sportsteams-team-manager-title' ) );

		$css = '<style>
			.view-form {
				font-weight: 800;
				font-size: 12px;
				font-color: #666666;
			}
			.view-status {
				font-weight: 800;
				font-size: 12px;
				background-color: #FFFB9B;
				color: #666666;
				padding: 5px;
				margin-bottom: 5px;
			}
		</style>';
		$wgOut->addHTML( $css );

 		if( $wgRequest->wasPosted() ) {
			if( !( $wgRequest->getInt( 'id' ) ) ) {
				$dbw = wfGetDB( DB_MASTER );
				$dbw->insert(
					'sport_team',
					array(
						'team_sport_id' => $wgRequest->getInt( 's_id' ),
						'team_name' => $wgRequest->getVal( 'team_name' )
					),
					__METHOD__
				);

				$id = $dbw->insertId();
				$wgOut->addHTML(
					'<span class="view-status">' .
					wfMsg( 'sportsteams-team-manager-created' ) .
					'</span><br /><br />'
				);
			} else {
				$id = $wgRequest->getInt( 'id' );
				$dbw = wfGetDB( DB_MASTER );
				$dbw->update(
					'sport_team',
				/* SET */array(
						'team_sport_id' => $wgRequest->getInt( 's_id' ),
						'team_name' => $wgRequest->getVal( 'team_name' )
					),
				/* WHERE */array(
						'team_id' => $id
					),
					__METHOD__
				);

				$wgOut->addHTML(
					'<span class="view-status">' .
					wfMsg( 'sportsteams-team-manager-saved' ) .
					'</span><br /><br />'
				);
			}

			$wgOut->addHTML( $this->displayForm( $id ) );
		} else {
			$id = $wgRequest->getInt( 'id' );
			$sport_id = $wgRequest->getInt( 'sport_id' );
			if( $id || $wgRequest->getVal( 'method' ) == 'edit' ) {
				$wgOut->addHTML( $this->displayForm( $id ) );
			} else {
				if( !$sport_id ) {
					$wgOut->addHTML( $this->displaySportsList() );
				} else {
					$wgOut->addHTML(
						'<div><b><a href="' .
						$this->getTitle()->escapeFullURL() . '">' .
						wfMsg( 'sportsteams-team-manager-view-sports' ) .
						'</a></b> | <b><a href="' . $this->getTitle()->escapeFullURL(
							array( 'sport_id' => $sport_id, 'method' => 'edit' )
						) . '">' .
						wfMsg( 'sportsteams-team-manager-add-new-team' ) . '</a></b></div><p>'
					);
					$wgOut->addHTML( $this->displayTeamList( $sport_id ) );
				}
			}
		}
	}

	function displaySportsList() {
		$output = '<div>';
		$sports = SportsTeams::getSports();
		if ( $sports ) {
			foreach ( $sports as $sport ) {
				$output .= '<div class="Item">
				<a href="' . $this->getTitle()->escapeFullURL( "sport_id={$sport['id']}" ) . "\">{$sport['name']}</a>
			</div>\n";
			}
		}/* else {
			$output .= 'There are no sports in the database. Create one!';
		}*/

		$output .= '</div>';
		return '<div id="views">' . $output . '</div>';
	}

	function displayTeamList( $sport_id ) {
		$output = '<div>';
		$teams = SportsTeams::getTeams( $sport_id );
		foreach ( $teams as $team ) {
			$output .= '<div class="Item">
				<a href="' . $this->getTitle()->escapeFullURL( "method=edit&sport_id={$sport_id}&id={$team['id']}" ) .
				"\">{$team['name']}</a>
			</div>\n";
		}

		$output .= '</div>';
		return '<div id="views">' . $output . '</div>';
	}

	function displayForm( $id ) {
		global $wgUser, $wgRequest, $wgUploadPath;

		$form = '<div><b><a href="' . $this->getTitle()->escapeFullURL( 'sport_id=' . $wgRequest->getInt( 'sport_id' ) ) . '">' .
			wfMsg( 'sportsteams-team-manager-view-teams' ) . '</a></b></div><p>';

		if( $id ) {
			$team = SportsTeams::getTeam( $id );
		} else {
			$team = array( 'id' => '', 'name' => '' ); // prevent notices
		}

		// @todo FIXME: rename the form from gift to something else and update line 225 accordingly
		$form .= '<form action="" method="post" enctype="multipart/form-data" name="gift">';

		$form .= '<table border="0" cellpadding="5" cellspacing="0" width="500">';

		$form .= '

			<tr>
			<td width="200" class="view-form">' . wfMsg( 'sportsteams-team-manager-sport' ) . '</td>
			<td width="695">
				<select name="s_id">';
		$sports = SportsTeams::getSports();
		foreach( $sports as $sport ) {
			$selected = '';
			if (
				$wgRequest->getInt( 'sport_id' ) == $sport['id'] ||
				$sport['id'] == $team['sport_id']
			)
			{
				$selected = ' selected';
			}
			$form .= "<option{$selected} value=\"{$sport['id']}\">{$sport['name']}</option>";
		}
		$form .= '</select>

			</tr>
			<tr>
				<td width="200" class="view-form">' .
					wfMsg( 'sportsteams-team-manager-teamname' ) .
				'</td>
				<td width="695">
					<input type="text" size="45" class="createbox" name="team_name" value="' . $team['name'] . '" />
				</td>
			</tr>
			';

		if( $id ) {
			$team_image = "<img src=\"{$wgUploadPath}/team_logos/" .
				SportsTeams::getTeamLogo( $id, 'l' ) .
				'" border="0" alt="logo" />';
			$form .= '<tr>
					<td width="200" class="view-form" valign="top">' .
						wfMsg( 'sportsteams-team-manager-team' ) .
					'</td>
					<td width="695">' . $team_image . '
						<p>
						<a href="' . SpecialPage::getTitleFor( 'SportsTeamsManagerLogo' )->escapeFullURL( "id={$id}" ) . '">' .
							wfMsg( 'sportsteams-team-manager-add-replace-logo' ) .
						'</a>
					</td>
				</tr>';
			}

		if ( $id ) {
			$msg = wfMsg( 'sportsteams-team-manager-edit' );
		} else {
			$msg = wfMsg( 'sportsteams-team-manager-add-team' );
		}

		$form .= '<tr>
				<td colspan="2">
					<input type="hidden" name="id" value="' . $id . '" />
					<input type="button" class="site-button" value="' . $msg . '" size="20" onclick="document.gift.submit()" />
					<input type="button" class="site-button" value="' . wfMsg( 'cancel' ) . '" size="20" onclick="history.go(-1)" />
				</td>
			</tr>
		</table>

		</form>';
		return $form;
	}
}
<?php
/**
 * A special page that lists the most popular networks.
 *
 * @file
 * @ingroup Extensions
 * @author Aaron Wright <aaron.wright@gmail.com>
 */

class TopNetworks extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'TopNetworks' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgRequest, $wgScriptPath, $wgUploadPath;

		// Variables
		$output = '';
		$direction = $wgRequest->getVal( 'direction' );
		$type = $wgRequest->getVal( 'type' );
		$sport = $wgRequest->getInt( 'sport' );

		// Direction
		if ( $direction == 'worst' ) {
			$order = 'ASC';
			$adj = 'least';
		} else {
			$order = 'DESC';
			$adj = 'most';
		}

		// Type
		if ( $type == 'sport' ) {
			$type_title = 'sports';
		} else {
			$type_title = 'teams';
		}

		// Sport
		$where = array();
		if ( $sport ) {
			$where['team_sport_id'] = $sport;
		}

		// Set the page title
		// For grep: sportsteams-top-network-team-title-least-sports,
		// sportsteams-top-network-team-title-least-teams,
		// sportsteams-top-network-team-title-most-sports,
		// sportsteams-top-network-team-title-most-teams
		$wgOut->setPageTitle( wfMsg( 'sportsteams-top-network-team-title-' . $adj . '-' . $type_title ) );

		// Add CSS
		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$wgOut->addModuleStyles( 'ext.sportsTeams' );
		} else {
			$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SportsTeams/SportsTeams.css' );
		}

		// Database handler
		$dbr = wfGetDB( DB_MASTER );

		// Teams
		$res = $dbr->select(
			array( 'sport_favorite', 'sport_team' ),
			array(
				'COUNT(sf_team_id) AS network_user_count',
				'sf_team_id', 'team_name', 'team_sport_id'
			),
			$where,
			__METHOD__,
			array(
				'GROUP BY' => 'team_id',
				'ORDER BY' => "network_user_count {$order}",
				'LIMIT' => 50
			),
			array(
				'sport_team' => array( 'INNER JOIN', 'sf_team_id = team_id' )
			)
		);

		// Sports
		$res_sport = $dbr->select(
			array( 'sport_favorite', 'sport' ),
			array(
				'COUNT(sf_sport_id) AS sport_count', 'sf_sport_id',
				'sport_name'
			),
			array(),
			__METHOD__,
			array(
				'GROUP BY' => 'sf_sport_id',
				'ORDER BY' => "sport_count {$order}",
				'LIMIT' => 50
			),
			array( 'sport' => array( 'INNER JOIN', 'sf_sport_id = sport_id' ) )
		);

		// Navigation
		$res_sport_nav = $dbr->select(
			array( 'sport', 'sport_team' ),
			array( 'sport_id', 'sport_name', 'team_sport_id' ),
			array(),
			__METHOD__,
			array(
				'GROUP BY' => 'sport_name',
				'ORDER BY' => 'sport_id'
			),
			array(
				'sport_team' => array( 'INNER JOIN', 'sport_id = team_sport_id' )
			)
		);

		// Navigation
		$output .= '<div class="top-networks-navigation">
			<h1>' . wfMsg( 'sportsteams-top-network-most-popular' ) . '</h1>';

		if ( !( $sport ) && !( $type ) && !( $direction ) ) {
			$output .= '<p><b>' . wfMsg( 'sportsteams-top-network-teams' ) . '</b></p>';
		} elseif ( !( $sport ) && !( $type ) && ( $direction == 'best' ) ) {
			$output .= '<p><b>' . wfMsg( 'sportsteams-top-network-teams' ) . '</b></p>';
		} else {
			$output .= '<p><a href="' . $this->getTitle()->escapeFullURL(
				array( 'direction' => 'best' )
			) . '">' . wfMsg( 'sportsteams-top-network-teams' ) . '</a></p>';
		}

		if ( !( $sport ) && ( $type == 'sport' ) && ( $direction == 'best' ) ) {
			$output .= '<p><b>' . wfMsg( 'sportsteams-top-network-sports' ) . '</b></p>';
		} else {
			$output .= '<p><a href="' . $this->getTitle()->escapeFullURL(
				array( 'type' => 'sport', 'direction' => 'best' )
			) . '">' . wfMsg( 'sportsteams-top-network-sports' ) . '</a></p>';
		}

		$output .= '<h1 style="margin-top:15px !important;">' .
			wfMsg( 'sportsteams-top-network-least-popular' ) . '</h1>';

		if ( !( $sport ) && !( $type ) && ( $direction == 'worst' ) ) {
			$output .= '<p><b>' . wfMsg( 'sportsteams-top-network-teams' ) . '</b></p>';
		} else {
			$output .= '<p><a href="' . $this->getTitle()->escapeFullURL(
				array( 'direction' => 'worst' )
			) . '">' . wfMsg( 'sportsteams-top-network-teams' ) . '</a></p>';
		}

		if ( !( $sport ) && ( $type == 'sport' ) && ( $direction == 'worst' ) ) {
			$output .= '<p><b>' . wfMsg( 'sportsteams-top-network-sports' ) . '</b></p>';
		} else {
			$output .= '<p><a href="' . $this->getTitle()->escapeFullURL(
				array( 'type' => 'sport', 'direction' => 'worst' )
			) . '">' . wfMsg( 'sportsteams-top-network-sports' ) . "</a></p>";
		}

		// for grep: sportsteams-top-network-most-pop-by-sport,
		// sportsteams-top-network-least-pop-by-sport
		$output .= '<h1 style="margin-top:15px !important;">' .
			wfMsg( 'sportsteams-top-network-' . strtolower( $adj ) . '-pop-by-sport' ) . '</h1>';

		foreach ( $res_sport_nav as $row_sport_nav ) {
			$sport_id = $row_sport_nav->sport_id;
			$sport_name = $row_sport_nav->sport_name;

			if ( $sport_id == $sport ) {
				$output .= "<p><b>{$sport_name}</b></p>";
				// For grep: sportsteams-top-network-least-team-title,
				// sportsteams-top-network-most-team-title
				$wgOut->setPageTitle(
					wfMsg( 'sportsteams-top-network-' . strtolower( $adj ) . '-team-title',
						$sport_name )
				);
			} else {
				$output .= '<p><a href="' . $this->getTitle()->escapeFullURL(
					array( 'direction' => $direction, 'sport' => $sport_id )
				) . '">' . $sport_name . '</a></p>';
			}
		}

		$output .= '</div>';

		// List Networks
		$output .= '<div class="top-networks">';

		// Set counter
		$x = 1;

		if ( $type == 'sport' ) {
			$fanHome = SpecialPage::getTitleFor( 'FanHome' );
			foreach ( $res_sport as $row_sport ) {
				// More variables
				$user_count = $row_sport->sport_count;
				$sport = $row_sport->sport_name;
				$sport_id = $row_sport->sf_sport_id;

				// Get team logo
				$sport_image = '<img src="' . $wgUploadPath . '/sport_logos/' .
					SportsTeams::getSportLogo( $sport_id, 's' ) .
					'" border="0" alt="logo" />';

				$output .= "<div class=\"network-row\">
					<span class=\"network-number\">{$x}.</span>
					<span class=\"network-team\">
						{$sport_image}
						<a href=\"" . $fanHome->escapeFullURL( array( 'sport_id' => $sport_id ) ) . "\">{$sport}</a>
					</span>
					<span class=\"network-count\">" .
						wfMsgExt(
							'sportsteams-count-fans',
							array( 'parse', 'parsemag' ),
							$user_count
						) .
					'</span>
					<div class="cleared"></div>
				</div>';
				$x++;
			}
		} else {
			foreach ( $res as $row ) {
				// More variables
				$user_count = $row->network_user_count;
				$team = $row->team_name;
				$team_id = $row->sf_team_id;
				$sport_id = $row->team_sport_id;

				// Get team logo
				$team_image = '<img src="' . $wgUploadPath . '/team_logos/' .
					SportsTeams::getTeamLogo( $team_id, 's' ) .
					'" border="0" alt="logo" />';

				$fanHome = SpecialPage::getTitleFor( 'FanHome' );
				$output .= "<div class=\"network-row\">
					<span class=\"network-number\">{$x}.</span>
					<span class=\"network-team\">
						{$team_image}
						<a href=\"" . $fanHome->escapeFullURL( array(
							'sport_id' => $sport_id,
							'team_id' => $team_id
						) ) . "\">{$team}</a>
					</span>
					<span class=\"network-count\">" .
						wfMsgExt(
							'sportsteams-count-fans',
							array( 'parsemag', 'parse' ),
							$user_count
						) .
					'</span>
					<div class="cleared"></div>
				</div>';
				$x++;
			}
		}

		$output .= '</div>
		<div class="cleared"></div>';

		$wgOut->addHTML( $output );
	}

}
<?php
/**
 * User profile Wiki Page
 *
 * @file
 * @ingroup Extensions
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class UserProfilePage extends Article {

	public $title = null;

	/**
	 * Constructor
	 */
	function __construct( $title ) {
		global $wgUser;
		parent::__construct( $title );
		$this->user_name = $title->getText();
		$this->user_id = User::idFromName( $this->user_name );
		$this->user = User::newFromId( $this->user_id );
		$this->user->loadFromDatabase();

		$this->is_owner = ( $this->user_name == $wgUser->getName() );

		$profile = new UserProfile( $this->user_name );
		$this->profile_data = $profile->getProfile();
	}

	function isOwner() {
		return $this->is_owner;
	}

	function view() {
		global $wgOut, $wgTitle;

		$wgOut->setPageTitle( $this->mTitle->getPrefixedText() );

		// No need to display noarticletext, we use our own message
		if ( !$this->user_id ) {
			parent::view();
			return '';
		}

		$wgOut->addHTML( '<div id="profile-top">' );
		$wgOut->addHTML( $this->getProfileTop( $this->user_id, $this->user_name ) );
		$wgOut->addHTML( '<div class="cleared"></div></div>' );

		// User does not want social profile for User:user_name, so we just
		// show header + page content
		if (
			$wgTitle->getNamespace() == NS_USER &&
			$this->profile_data['user_id'] &&
			$this->profile_data['user_page_type'] == 0
		)
		{
			parent::view();
			return '';
		}

		// Left side
		$wgOut->addHTML( '<div id="user-page-left" class="clearfix">' );

		if ( !wfRunHooks( 'UserProfileBeginLeft', array( &$this ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileBeginLeft messed up profile!\n" );
		}

		$wgOut->addHTML( $this->getRelationships( $this->user_name, 1 ) );
		$wgOut->addHTML( $this->getRelationships( $this->user_name, 2 ) );
		$wgOut->addHTML( $this->getGifts( $this->user_name ) );
		$wgOut->addHTML( $this->getAwards( $this->user_name ) );
		$wgOut->addHTML( $this->getCustomInfo( $this->user_name ) );
		$wgOut->addHTML( $this->getInterests( $this->user_name ) );
		$wgOut->addHTML( $this->getFanBoxes( $this->user_name ) );
		$wgOut->addHTML( $this->getUserStats( $this->user_id, $this->user_name ) );

		if ( !wfRunHooks( 'UserProfileEndLeft', array( &$this ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileEndLeft messed up profile!\n" );
		}

		$wgOut->addHTML( '</div>' );

		wfDebug( "profile start right\n" );

		// Right side
		$wgOut->addHTML( '<div id="user-page-right" class="clearfix">' );

		if ( !wfRunHooks( 'UserProfileBeginRight', array( &$this ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileBeginRight messed up profile!\n" );
		}

		$wgOut->addHTML( $this->getPersonalInfo( $this->user_id, $this->user_name ) );
		$wgOut->addHTML( $this->getActivity( $this->user_name ) );
		// Hook for BlogPage
		if ( !wfRunHooks( 'UserProfileRightSideAfterActivity', array( $this ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileRightSideAfterActivity hook messed up profile!\n" );
		}
		$wgOut->addHTML( $this->getCasualGames( $this->user_id, $this->user_name ) );
		$wgOut->addHTML( $this->getUserBoard( $this->user_id, $this->user_name ) );

		if ( !wfRunHooks( 'UserProfileEndRight', array( &$this ) ) ) {
			wfDebug( __METHOD__ . ": UserProfileEndRight messed up profile!\n" );
		}

		$wgOut->addHTML( '</div><div class="cleared"></div>' );
	}

	function getUserStatsRow( $label, $value ) {
		$output = ''; // Prevent E_NOTICE

		if ( $value != 0 ) {
			$output = "<div>
					<b>{$label}</b>
					{$value}
			</div>";
		}

		return $output;
	}

	function getUserStats( $user_id, $user_name ) {
		global $wgUserProfileDisplay;

		if ( $wgUserProfileDisplay['stats'] == false ) {
			return '';
		}

		$output = ''; // Prevent E_NOTICE

		$stats = new UserStats( $user_id, $user_name );
		$stats_data = $stats->getUserStats();

		$total_value = $stats_data['edits'] . $stats_data['votes'] .
						$stats_data['comments'] . $stats_data['recruits'] .
						$stats_data['poll_votes'] .
						$stats_data['picture_game_votes'] .
						$stats_data['quiz_points'];

		if ( $total_value != 0 ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' .
					wfMsg( 'user-stats-title' ) .
				'</div>
				<div class="user-section-actions">
					<div class="action-right">
					</div>
					<div class="action-left">
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="profile-info-container bold-fix">' .
				$this->getUserStatsRow(
					wfMsgExt( 'user-stats-edits', 'parsemag', $stats_data['edits'] ),
					$stats_data['edits']
				) .
				$this->getUserStatsRow(
					wfMsgExt( 'user-stats-votes', 'parsemag', $stats_data['votes'] ),
					$stats_data['votes']
				) .
				$this->getUserStatsRow(
					wfMsgExt( 'user-stats-comments', 'parsemag', $stats_data['comments'] ),
					$stats_data['comments'] ) .
				$this->getUserStatsRow(
					wfMsgExt( 'user-stats-recruits', 'parsemag', $stats_data['recruits'] ),
					$stats_data['recruits']
				) .
				$this->getUserStatsRow(
					wfMsgExt( 'user-stats-poll-votes', 'parsemag', $stats_data['poll_votes'] ),
					$stats_data['poll_votes']
				) .
				$this->getUserStatsRow(
					wfMsgExt( 'user-stats-picture-game-votes', 'parsemag', $stats_data['picture_game_votes'] ),
					$stats_data['picture_game_votes']
				) .
				$this->getUserStatsRow(
					wfMsgExt( 'user-stats-quiz-points', 'parsemag', $stats_data['quiz_points'] ),
					$stats_data['quiz_points']
				);
			if ( $stats_data['currency'] != '10,000' ) {
				$output .= $this->getUserStatsRow(
					wfMsgExt( 'user-stats-pick-points', 'parsemag', $stats_data['currency'] ),
					$stats_data['currency']
				);
			}
			$output .= '</div>';
		}

		return $output;
	}

	/**
	 * Get three of the polls the user has created and cache the data in
	 * memcached.
	 *
	 * @return Array
	 */
	function getUserPolls() {
		global $wgMemc;

		$polls = array();

		// Try cache
		$key = wfMemcKey( 'user', 'profile', 'polls', $this->user_id );
		$data = $wgMemc->get( $key );

		if( $data ) {
			wfDebug( "Got profile polls for user {$this->user_id} from cache\n" );
			$polls = $data;
		} else {
			wfDebug( "Got profile polls for user {$this->user_id} from DB\n" );
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'poll_question', 'page' ),
				array(
					'page_title', 'UNIX_TIMESTAMP(poll_date) AS poll_date'
				),
				/* WHERE */array( 'poll_user_id' => $this->user_id ),
				__METHOD__,
				array( 'ORDER BY' => 'poll_id DESC', 'LIMIT' => 3 ),
				array( 'page' => array( 'INNER JOIN', 'page_id = poll_page_id' ) )
			);
			foreach( $res as $row ) {
				$polls[] = array(
					'title' => $row->page_title,
					'timestamp' => $row->poll_date
				);
			}
			$wgMemc->set( $key, $polls );
		}
		return $polls;
	}

	/**
	 * Get three of the quiz games the user has created and cache the data in
	 * memcached.
	 *
	 * @return Array
	 */
	function getUserQuiz() {
		global $wgMemc;

		$quiz = array();

		// Try cache
		$key = wfMemcKey( 'user', 'profile', 'quiz', $this->user_id );
		$data = $wgMemc->get( $key );

		if( $data ) {
			wfDebug( "Got profile quizzes for user {$this->user_id} from cache\n" );
			$quiz = $data;
		} else {
			wfDebug( "Got profile quizzes for user {$this->user_id} from DB\n" );
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				'quizgame_questions',
				array(
					'q_id', 'q_text', 'UNIX_TIMESTAMP(q_date) AS quiz_date'
				),
				array(
					'q_user_id' => $this->user_id,
					'q_flag' => 0 // the same as QUIZGAME_FLAG_NONE
				),
				__METHOD__,
				array(
					'ORDER BY' => 'q_id DESC',
					'LIMIT' => 3
				)
			);
			foreach( $res as $row ) {
				$quiz[] = array(
					'id' => $row->q_id,
					'text' => $row->q_text,
					'timestamp' => $row->quiz_date
				);
			}
			$wgMemc->set( $key, $quiz );
		}

		return $quiz;
	}

	/**
	 * Get three of the picture games the user has created and cache the data
	 * in memcached.
	 *
	 * @return Array
	 */
	function getUserPicGames() {
		global $wgMemc;

		$pics = array();

		// Try cache
		$key = wfMemcKey( 'user', 'profile', 'picgame', $this->user_id );
		$data = $wgMemc->get( $key );
		if( $data ) {
			wfDebug( "Got profile picgames for user {$this->user_id} from cache\n" );
			$pics = $data;
		} else {
			wfDebug( "Got profile picgames for user {$this->user_id} from DB\n" );
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				'picturegame_images',
				array(
					'id', 'title', 'img1', 'img2',
					'UNIX_TIMESTAMP(pg_date) AS pic_game_date'
				),
				array(
					'userid' => $this->user_id,
					'flag' => 0 // PICTUREGAME_FLAG_NONE
				),
				__METHOD__,
				array(
					'ORDER BY' => 'id DESC',
					'LIMIT' => 3
				)
			);
			foreach( $res as $row ) {
				$pics[] = array(
					'id' => $row->id,
					'title' => $row->title,
					'img1' => $row->img1,
					'img2' => $row->img2,
					'timestamp' => $row->pic_game_date
				);
			}
			$wgMemc->set( $key, $pics );
		}

		return $pics;
	}

	/**
	 * Get the casual games (polls, quizzes and picture games) that the user
	 * has created if $wgUserProfileDisplay['games'] is set to true and the
	 * PictureGame, PollNY and QuizGame extensions have been installed.
	 *
	 * @param $user_id Integer: user ID number
	 * @param $user_name String: user name
	 * @return String: HTML or nothing if this feature isn't enabled
	 */
	function getCasualGames( $user_id, $user_name ) {
		global $wgUser, $wgTitle, $wgOut, $wgUserProfileDisplay;

		if ( $wgUserProfileDisplay['games'] == false ) {
			return '';
		}

		$output = '';

		// Safe titles
		$quiz_title = SpecialPage::getTitleFor( 'QuizGameHome' );
		$pic_game_title = SpecialPage::getTitleFor( 'PictureGameHome' );

		// Combine the queries
		$combined_array = array();

		$quizzes = $this->getUserQuiz();
		foreach( $quizzes as $quiz ) {
			$combined_array[] = array(
				'type' => 'Quiz',
				'id' => $quiz['id'],
				'text' => $quiz['text'],
				'timestamp' => $quiz['timestamp']
			);
		}

		$polls = $this->getUserPolls();
		foreach( $polls as $poll ) {
			$combined_array[] = array(
				'type' => 'Poll',
				'title' => $poll['title'],
				'timestamp' => $poll['timestamp']
			);
		}

		$pics = $this->getUserPicGames();
		foreach( $pics as $pic ) {
			$combined_array[] = array(
				'type' => 'Picture Game',
				'id' => $pic['id'],
				'title' => $pic['title'],
				'img1' => $pic['img1'],
				'img2' => $pic['img2'],
				'timestamp' => $pic['timestamp']
			);
		}

		usort( $combined_array, array( 'UserProfilePage', 'sortItems' ) );

		if ( count( $combined_array ) > 0 ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' .
					wfMsg('casual-games-title').'
				</div>
				<div class="user-section-actions">
					<div class="action-right">
					</div>
					<div class="action-left">
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="casual-game-container">';

			$x = 1;

			foreach( $combined_array as $item ) {
				$output .= ( ( $x == 1 ) ? '<p class="item-top">' : '<p>' );

				if ( $item['type'] == 'Poll' ) {
					$ns = ( defined( 'NS_POLL' ) ? NS_POLL : 300 );
					$poll_title = Title::makeTitle( $ns, $item['title'] );
					$casual_game_title = wfMsg( 'casual-game-poll' );
					$output .= '<a href="' . $poll_title->escapeFullURL() .
						"\" rel=\"nofollow\">
							{$poll_title->getText()}
						</a>
						<span class=\"item-small\">{$casual_game_title}</span>";
				}

				if ( $item['type'] == 'Quiz' ) {
					$casual_game_title = wfMsg( 'casual-game-quiz' );
					$output .= '<a href="' .
						$quiz_title->escapeFullURL( 'questionGameAction=renderPermalink&permalinkID=' . $item['id'] ) .
						"\" rel=\"nofollow\">
							{$item['text']}
						</a>
						<span class=\"item-small\">{$casual_game_title}</span>";
				}

				if ( $item['type'] == 'Picture Game' ) {
					if( $item['img1'] != '' && $item['img2'] != '' ) {
						$image_1 = $image_2 = '';
						$render_1 = wfFindFile( $item['img1'] );
						if ( is_object( $render_1 ) ) {
							$thumb_1 = $render_1->transform( array( 'width' =>  25 ) );
							$image_1 = $thumb_1->toHtml();
						}

						$render_2 = wfFindFile( $item['img2'] );
						if ( is_object( $render_2 ) ) {
							$thumb_2 = $render_2->transform( array( 'width' => 25 ) );
							$image_2 = $thumb_2->toHtml();
						}

						$casual_game_title = wfMsg( 'casual-game-picture-game' );

						$output .= '<a href="' .
							$pic_game_title->escapeFullURL( 'picGameAction=renderPermalink&id=' . $item['id'] ) .
							"\" rel=\"nofollow\">
								{$image_1}
								{$image_2}
								{$item['title']}
							</a>
							<span class=\"item-small\">{$casual_game_title}</span>";
					}
				}

				$output .= '</p>';

				$x++;
			}

			$output .= '</div>';
		}

		return $output;
	}

	function sortItems( $x, $y ) {
		if ( $x['timestamp'] == $y['timestamp'] ) {
			return 0;
		} elseif ( $x['timestamp'] > $y['timestamp'] ) {
			return - 1;
		} else {
			return 1;
		}
	}

	function getProfileSection( $label, $value, $required = true ) {
		global $wgUser, $wgTitle, $wgOut;

		$output = '';
		if ( $value || $required ) {
			if ( !$value ) {
				if ( $wgUser->getName() == $wgTitle->getText() ) {
					$value = wfMsg( 'profile-updated-personal' );
				} else {
					$value = wfMsg( 'profile-not-provided' );
				}
			}

			$value = $wgOut->parse( trim( $value ), false );

			$output = "<div><b>{$label}</b>{$value}</div>";
		}
		return $output;
	}

	function getPersonalInfo( $user_id, $user_name ) {
		global $wgUser, $wgUserProfileDisplay;

		if ( $wgUserProfileDisplay['personal'] == false ) {
			return '';
		}

		$stats = new UserStats( $user_id, $user_name );
		$stats_data = $stats->getUserStats();
		$user_level = new UserLevel( $stats_data['points'] );
		$level_link = Title::makeTitle( NS_HELP, wfMsgForContent( 'user-profile-userlevels-link' ) );

		$this->initializeProfileData( $user_name );
		$profile_data = $this->profile_data;

		$defaultCountry = wfMsgForContent( 'user-profile-default-country' );

		// Current location
		$location = $profile_data['location_city'] . ', ' . $profile_data['location_state'];
		if ( $profile_data['location_country'] != $defaultCountry ) {
			if ( $profile_data['location_city'] && $profile_data['location_state'] ) { // city AND state
				$location = $profile_data['location_city'] . ', ' .
							$profile_data['location_state'] . ', ' .
							$profile_data['location_country'];
			} elseif ( $profile_data['location_city'] && !$profile_data['location_state'] ) { // city, but no state
				$location = $profile_data['location_city'] . ', ' . $profile_data['location_country'];
			} elseif ( $profile_data['location_state'] && !$profile_data['location_city'] ) { // state, but no city
				$location = $profile_data['location_state'] . ', ' . $profile_data['location_country'];
			} else {
				$location = '';
				$location .= $profile_data['location_country'];
			}
		}

		if ( $location == ', ' ) {
			$location = '';
		}

		// Hometown
		$hometown = $profile_data['hometown_city'] . ', ' . $profile_data['hometown_state'];
		if ( $profile_data['hometown_country'] != $defaultCountry ) {
			if ( $profile_data['hometown_city'] && $profile_data['hometown_state'] ) { // city AND state
				$hometown = $profile_data['hometown_city'] . ', ' .
							$profile_data['hometown_state'] . ', ' .
							$profile_data['hometown_country'];
			} elseif ( $profile_data['hometown_city'] && !$profile_data['hometown_state'] ) { // city, but no state
				$hometown = $profile_data['hometown_city'] . ', ' . $profile_data['hometown_country'];
			} elseif ( $profile_data['hometown_state'] && !$profile_data['hometown_city'] ) { // state, but no city
				$hometown = $profile_data['hometown_state'] . ', ' . $profile_data['hometown_country'];
			} else {
				$hometown = '';
				$hometown .= $profile_data['hometown_country'];
			}
		}

		if ( $hometown == ', ' ) {
			$hometown = '';
		}

		$joined_data = $profile_data['real_name'] . $location . $hometown .
						$profile_data['birthday'] . $profile_data['occupation'] .
						$profile_data['websites'] . $profile_data['places_lived'] .
						$profile_data['schools'] . $profile_data['about'];
		$edit_info_link = SpecialPage::getTitleFor( 'UpdateProfile' );

		$output = '';
		if ( $joined_data ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' .
					wfMsg( 'user-personal-info-title' ) .
				'</div>
				<div class="user-section-actions">
					<div class="action-right">';
			if ( $wgUser->getName() == $user_name ) {
				$output .= '<a href="' . $edit_info_link->escapeFullURL() . '">' .
					wfMsg( 'user-edit-this' ) . '</a>';
			}
			$output .= '</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="profile-info-container">' .
				$this->getProfileSection( wfMsg( 'user-personal-info-real-name' ), $profile_data['real_name'], false ) .
				$this->getProfileSection( wfMsg( 'user-personal-info-location' ), $location, false ) .
				$this->getProfileSection( wfMsg( 'user-personal-info-hometown' ), $hometown, false ) .
				$this->getProfileSection( wfMsg( 'user-personal-info-birthday' ), $profile_data['birthday'], false ) .
				$this->getProfileSection( wfMsg( 'user-personal-info-occupation' ), $profile_data['occupation'], false ) .
				$this->getProfileSection( wfMsg( 'user-personal-info-websites' ), $profile_data['websites'], false ) .
				$this->getProfileSection( wfMsg( 'user-personal-info-places-lived' ), $profile_data['places_lived'], false ) .
				$this->getProfileSection( wfMsg( 'user-personal-info-schools' ), $profile_data['schools'], false ) .
				$this->getProfileSection( wfMsg( 'user-personal-info-about-me' ), $profile_data['about'], false ) .
			'</div>';
		} elseif ( $wgUser->getName() == $user_name ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' .
					wfMsg( 'user-personal-info-title' ) .
				'</div>
				<div class="user-section-actions">
					<div class="action-right">
						<a href="' . $edit_info_link->escapeFullURL() . '">' .
							wfMsg( 'user-edit-this' ) .
						'</a>
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="no-info-container">' .
				wfMsg( 'user-no-personal-info' ) .
			'</div>';
		}

		return $output;
	}

	/**
	 * Get the custom info (site-specific stuff) for a given user.
	 *
	 * @param $user_name String: user name whose custom info we should fetch
	 * @return String: HTML
	 */
	function getCustomInfo( $user_name ) {
		global $wgUser, $wgUserProfileDisplay;

		if ( $wgUserProfileDisplay['custom'] == false ) {
			return '';
		}

		$this->initializeProfileData( $user_name );

		$profile_data = $this->profile_data;

		$joined_data = $profile_data['custom_1'] . $profile_data['custom_2'] .
						$profile_data['custom_3'] . $profile_data['custom_4'];
		$edit_info_link = SpecialPage::getTitleFor( 'UpdateProfile' );

		$output = '';
		if ( $joined_data ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' .
					wfMsg( 'custom-info-title' ) .
				'</div>
				<div class="user-section-actions">
					<div class="action-right">';
			if ( $wgUser->getName() == $user_name ) {
				$output .= '<a href="' . $edit_info_link->escapeFullURL() . '/custom">' .
					wfMsg( 'user-edit-this' ) . '</a>';
			}
			$output .= '</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="profile-info-container">' .
				$this->getProfileSection( wfMsg( 'custom-info-field1' ), $profile_data['custom_1'], false ) .
				$this->getProfileSection( wfMsg( 'custom-info-field2' ), $profile_data['custom_2'], false ) .
				$this->getProfileSection( wfMsg( 'custom-info-field3' ), $profile_data['custom_3'], false ) .
				$this->getProfileSection( wfMsg( 'custom-info-field4' ), $profile_data['custom_4'], false ) .
			'</div>';
		} elseif ( $wgUser->getName() == $user_name ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' .
					wfMsg( 'custom-info-title' ) .
				'</div>
				<div class="user-section-actions">
					<div class="action-right">
						<a href="' . $edit_info_link->escapeFullURL() . '/custom">' .
							wfMsg( 'user-edit-this' ) .
						'</a>
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="no-info-container">' .
				wfMsg( 'custom-no-info' ) .
			'</div>';
		}

		return $output;
	}

	/**
	 * Get the interests (favorite movies, TV shows, music, etc.) for a given
	 * user.
	 *
	 * @param $user_name String: user name whose interests we should fetch
	 * @return String: HTML
	 */
	function getInterests( $user_name ) {
		global $wgUser, $wgUserProfileDisplay;

		if ( $wgUserProfileDisplay['interests'] == false ) {
			return '';
		}

		$this->initializeProfileData( $user_name );

		$profile_data = $this->profile_data;
		$joined_data = $profile_data['movies'] . $profile_data['tv'] .
						$profile_data['music'] . $profile_data['books'] .
						$profile_data['video_games'] .
						$profile_data['magazines'] . $profile_data['drinks'] .
						$profile_data['snacks'];
		$edit_info_link = SpecialPage::getTitleFor( 'UpdateProfile' );

		$output = '';
		if ( $joined_data ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' .
					wfMsg( 'other-info-title' ) .
				'</div>
				<div class="user-section-actions">
					<div class="action-right">';
			if ( $wgUser->getName() == $user_name ) {
				$output .= '<a href="' . $edit_info_link->escapeFullURL() . '/personal">' .
					wfMsg( 'user-edit-this' ) . '</a>';
			}
			$output .= '</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="profile-info-container">' .
				$this->getProfileSection( wfMsg( 'other-info-movies' ), $profile_data['movies'], false ) .
				$this->getProfileSection( wfMsg( 'other-info-tv' ), $profile_data['tv'], false ) .
				$this->getProfileSection( wfMsg( 'other-info-music' ), $profile_data['music'], false ) .
				$this->getProfileSection( wfMsg( 'other-info-books' ), $profile_data['books'], false ) .
				$this->getProfileSection( wfMsg( 'other-info-video-games' ), $profile_data['video_games'], false ) .
				$this->getProfileSection( wfMsg( 'other-info-magazines' ), $profile_data['magazines'], false ) .
				$this->getProfileSection( wfMsg( 'other-info-snacks' ), $profile_data['snacks'], false ) .
				$this->getProfileSection( wfMsg( 'other-info-drinks' ), $profile_data['drinks'], false ) .
			'</div>';
		} elseif ( $this->isOwner() ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' .
					wfMsg( 'other-info-title' ) .
				'</div>
				<div class="user-section-actions">
					<div class="action-right">
						<a href="' . $edit_info_link->escapeFullURL() . '/personal">' .
							wfMsg( 'user-edit-this' ) .
						'</a>
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="no-info-container">' .
				wfMsg( 'other-no-info' ) .
			'</div>';
		}
		return $output;
	}

	/**
	 * Get the header for the social profile page, which includes the user's
	 * points and user level (if enabled in the site configuration) and lots
	 * more.
	 *
	 * @param $user_id Integer: user ID
	 * @param $user_name String: user name
	 */
	function getProfileTop( $user_id, $user_name ) {
		global $wgTitle, $wgUser, $wgLang;
		global $wgUserLevels;

		$stats = new UserStats( $user_id, $user_name );
		$stats_data = $stats->getUserStats();
		$user_level = new UserLevel( $stats_data['points'] );
		$level_link = Title::makeTitle( NS_HELP, wfMsgForContent( 'user-profile-userlevels-link' ) );

		$this->initializeProfileData( $user_name );
		$profile_data = $this->profile_data;

		// Variables and other crap
		$page_title = $wgTitle->getText();
		$title_parts = explode( '/', $page_title );
		$user = $title_parts[0];
		$id = User::idFromName( $user );
		$user_safe = urlencode( $user );

		// Safe urls
		$add_relationship = SpecialPage::getTitleFor( 'AddRelationship' );
		$remove_relationship = SpecialPage::getTitleFor( 'RemoveRelationship' );
		$give_gift = SpecialPage::getTitleFor( 'GiveGift' );
		$send_board_blast = SpecialPage::getTitleFor( 'SendBoardBlast' );
		$update_profile = SpecialPage::getTitleFor( 'UpdateProfile' );
		$watchlist = SpecialPage::getTitleFor( 'Watchlist' );
		$contributions = SpecialPage::getTitleFor( 'Contributions', $user );
		$send_message = SpecialPage::getTitleFor( 'UserBoard' );
		$upload_avatar = SpecialPage::getTitleFor( 'UploadAvatar' );
		$user_page = Title::makeTitle( NS_USER, $user );
		$user_social_profile = Title::makeTitle( NS_USER_PROFILE, $user );
		$user_wiki = Title::makeTitle( NS_USER_WIKI, $user );

		if ( $id != 0 ) {
			$relationship = UserRelationship::getUserRelationshipByID( $id, $wgUser->getID() );
		}
		$avatar = new wAvatar( $this->user_id, 'l' );

		wfDebug( 'profile type: ' . $profile_data['user_page_type'] . "\n" );
		$output = '';

		if ( $this->isOwner() ) {
			$toggle_title = SpecialPage::getTitleFor( 'ToggleUserPage' );
			if ( $this->profile_data['user_page_type'] == 1 ) {
				$toggleMessage = wfMsg( 'user-type-toggle-old' );
			} else {
				$toggleMessage = wfMsg( 'user-type-toggle-new' );
			}
			$output .= '<div id="profile-toggle-button">
				<a href="' . $toggle_title->escapeFullURL() . '" rel="nofollow">' .
					$toggleMessage . '</a>
			</div>';
		}

		$output .= '<div id="profile-image">' . $avatar->getAvatarURL() .
			'</div>';

		$output .= '<div id="profile-right">';

		$output .= '<div id="profile-title-container">
				<div id="profile-title">' .
					$user_name .
				'</div>';
		// Show the user's level and the amount of points they have if
		// UserLevels has been configured
		if ( $wgUserLevels ) {
			$output .= '<div id="points-level">
					<a href="' . $level_link->escapeFullURL() . '">' .
						wfMsgExt(
							'user-profile-points',
							'parsemag',
							$wgLang->formatNum( $stats_data['points'] )
						) .
					'</a>
					</div>
					<div id="honorific-level">
						<a href="' . $level_link->escapeFullURL() . '" rel="nofollow">(' . $user_level->getLevelName() . ')</a>
					</div>';
		}
		$output .= '<div class="cleared"></div>
			</div>
			<div class="profile-actions">';

		if ( $this->isOwner() ) {
			$output .= $wgLang->pipeList( array(
				'<a href="' . $update_profile->escapeFullURL() . '">' . wfMsg( 'user-edit-profile' ) . '</a>',
				'<a href="' . $upload_avatar->escapeFullURL() . '">' . wfMsg( 'user-upload-avatar' ) . '</a>',
				'<a href="' . $watchlist->escapeFullURL() . '">' . wfMsg( 'user-watchlist' ) . '</a>',
				''
			) );
		} elseif ( $wgUser->isLoggedIn() ) {
			if ( $relationship == false ) {
				$output .= $wgLang->pipeList( array(
					'<a href="' . $add_relationship->escapeFullURL( 'user=' . $user_safe . '&rel_type=1' ) . '" rel="nofollow">' . wfMsg( 'user-add-friend' ) . '</a>',
					'<a href="' . $add_relationship->escapeFullURL( 'user=' . $user_safe . '&rel_type=2' ) . '" rel="nofollow">' . wfMsg( 'user-add-foe' ) . '</a>',
					''
				) );
			} else {
				if ( $relationship == 1 ) {
					$output .= $wgLang->pipeList( array(
						'<a href="' . $remove_relationship->escapeFullURL( 'user=' . $user_safe ) . '">' . wfMsg( 'user-remove-friend' ) . '</a>',
						''
					) );
				}
				if ( $relationship == 2 ) {
					$output .= $wgLang->pipeList( array(
						'<a href="' . $remove_relationship->escapeFullURL( 'user=' . $user_safe ) . '">' . wfMsg( 'user-remove-foe' ) . '</a>',
						''
					) );
				}
			}

			global $wgUserBoard;
			if ( $wgUserBoard ) {
				$output .= '<a href="' . $send_message->escapeFullURL( 'user=' . $wgUser->getName() . '&conv=' . $user_safe ) . '" rel="nofollow">' .
					wfMsg( 'user-send-message' ) . '</a>';
				$output .= wfMsgExt( 'pipe-separator', 'escapenoentities' );
			}
			$output .= '<a href="' . $give_gift->escapeFullURL( 'user=' . $user_safe ) . '" rel="nofollow">' .
				wfMsg( 'user-send-gift' ) . '</a>';
			$output .= wfMsgExt( 'pipe-separator', 'escapenoentities' );
		}

		$output .= '<a href="' . $contributions->escapeFullURL() . '" rel="nofollow">' . wfMsg( 'user-contributions' ) . '</a> ';

		// Links to User:user_name from User_profile:
		if ( $wgTitle->getNamespace() == NS_USER_PROFILE && $this->profile_data['user_id'] && $this->profile_data['user_page_type'] == 0 ) {
			$output .= '| <a href="' . $user_page->escapeFullURL() . '" rel="nofollow">' .
				wfMsg( 'user-page-link' ) . '</a> ';
		}

		// Links to User:user_name from User_profile:
		if ( $wgTitle->getNamespace() == NS_USER && $this->profile_data['user_id'] && $this->profile_data['user_page_type'] == 0 ) {
			$output .= '| <a href="' . $user_social_profile->escapeFullURL() . '" rel="nofollow">' .
				wfMsg( 'user-social-profile-link' ) . '</a> ';
		}

		if ( $wgTitle->getNamespace() == NS_USER && ( !$this->profile_data['user_id'] || $this->profile_data['user_page_type'] == 1 ) ) {
			$output .= '| <a href="' . $user_wiki->escapeFullURL() . '" rel="nofollow">' .
				wfMsg( 'user-wiki-link' ) . '</a>';
		}

		$output .= '</div>

		</div>';

		return $output;
	}

	/**
	 * This is currently unused, seems to be a leftover from the ArmchairGM
	 * days.
	 *
	 * @param $user_name String: user name
	 * @return String: HTML
	 */
	function getProfileImage( $user_name ) {
		global $wgUser;

		$avatar = new wAvatar( $this->user_id, 'l' );
		$avatarTitle = SpecialPage::getTitleFor( 'UploadAvatar' );

		$output = '<div class="profile-image">';
		if ( $wgUser->getName() == $this->user_name ) {
			if ( strpos( $avatar->getAvatarImage(), 'default_' ) != false ) {
				$caption = 'upload image';
			} else {
				$caption = 'new image';
			}
			$output .= '<a href="' . $avatarTitle->escapeFullURL() . '" rel="nofollow">' .
						$avatar->getAvatarURL() . '<br />
					(' . $caption . ')
				</a>';
		} else {
			$output .= $avatar->getAvatarURL();
		}
		$output .= '</div>';

		return $output;
	}

	/**
	 * Get the relationships for a given user.
	 *
	 * @param $user_name String: name of the user whose relationships we want
	 *                           to fetch
	 * @param $rel_type Integer: 1 for friends, 2 (or anything else than 1) for
	 *                           foes
	 */
	function getRelationships( $user_name, $rel_type ) {
		global $wgMemc, $wgUser, $wgUserProfileDisplay, $wgLang;

		// If not enabled in site settings, don't display
		if ( $rel_type == 1 ) {
			if ( $wgUserProfileDisplay['friends'] == false ) {
				return '';
			}
		} else {
			if ( $wgUserProfileDisplay['foes'] == false ) {
				return '';
			}
		}

		$output = ''; // Prevent E_NOTICE

		$count = 4;
		$rel = new UserRelationship( $user_name );
		$key = wfMemcKey( 'relationship', 'profile', "{$rel->user_id}-{$rel_type}" );
		$data = $wgMemc->get( $key );

		// Try cache
		if ( !$data ) {
			$friends = $rel->getRelationshipList( $rel_type, $count );
			$wgMemc->set( $key, $friends );
		} else {
			wfDebug( "Got profile relationship type {$rel_type} for user {$user_name} from cache\n" );
			$friends = $data;
		}

		$stats = new UserStats( $rel->user_id, $user_name );
		$stats_data = $stats->getUserStats();
		$view_all_title = SpecialPage::getTitleFor( 'ViewRelationships' );

		if ( $rel_type == 1 ) {
			$relationship_count = $stats_data['friend_count'];
			$relationship_title = wfMsg( 'user-friends-title' );
		} else {
			$relationship_count = $stats_data['foe_count'];
			$relationship_title = wfMsg( 'user-foes-title' );
		}

		if ( count( $friends ) > 0 ) {
			$x = 1;
			$per_row = 4;

			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' . $relationship_title . '</div>
				<div class="user-section-actions">
					<div class="action-right">';
			if ( intval( str_replace( ',', '', $relationship_count ) ) > 4 ) {
				$output .= '<a href="' . $view_all_title->escapeFullURL( 'user=' . $user_name . '&rel_type=' . $rel_type ) .
					'" rel="nofollow">' . wfMsg( 'user-view-all' ) . '</a>';
			}
			$output .= '</div>
					<div class="action-left">';
			if ( intval( str_replace( ',', '', $relationship_count ) ) > 4 ) {
				$output .= wfMsg( 'user-count-separator', $per_row, $relationship_count );
			} else {
				$output .= wfMsg( 'user-count-separator', $relationship_count, $relationship_count );
			}
			$output .= '</div>
				</div>
				<div class="cleared"></div>
			</div>
			<div class="cleared"></div>
			<div class="user-relationship-container">';

			foreach ( $friends as $friend ) {
				$user = Title::makeTitle( NS_USER, $friend['user_name'] );
				$avatar = new wAvatar( $friend['user_id'], 'ml' );

				// Chop down username that gets displayed
				$user_name = $wgLang->truncate( $friend['user_name'], 9, '..' );

				$output .= "<a href=\"" . $user->escapeFullURL() . "\" title=\"{$friend['user_name']}\" rel=\"nofollow\">
					{$avatar->getAvatarURL()}<br />
					{$user_name}
				</a>";

				if ( $x == count( $friends ) || $x != 1 && $x % $per_row == 0 ) {
					$output .= '<div class="cleared"></div>';
				}

				$x++;
			}

			$output .= '</div>';
		}

		return $output;
	}

	/**
	 * Gets the recent social activity for a given user.
	 *
	 * @param $user_name String: name of the user whose activity we want to fetch
	 */
	function getActivity( $user_name ) {
		global $wgUser, $wgUserProfileDisplay, $wgScriptPath, $wgUploadPath;

		// If not enabled in site settings, don't display
		if ( $wgUserProfileDisplay['activity'] == false ) {
			return '';
		}

		$output = '';

		$limit = 8;
		$rel = new UserActivity( $user_name, 'user', $limit );
		$rel->setActivityToggle( 'show_votes', 0 );
		$rel->setActivityToggle( 'show_gifts_sent', 1 );

		/**
		 * Get all relationship activity
		 */
		$activity = $rel->getActivityList();

		if ( $activity ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' .
					wfMsg( 'user-recent-activity-title' ) .
				'</div>
				<div class="user-section-actions">
					<div class="action-right">
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>';

			$x = 1;

			if ( count( $activity ) < $limit ) {
				$style_limit = count( $activity );
			} else {
				$style_limit = $limit;
			}

			foreach ( $activity as $item ) {
				$item_html = '';
				$title = Title::makeTitle( $item['namespace'], $item['pagetitle'] );
				$user_title = Title::makeTitle( NS_USER, $item['username'] );
				$user_title_2 = Title::makeTitle( NS_USER, $item['comment'] );

				if ( $user_title_2 ) {
					$user_link_2 = '<a href="' . $user_title_2->escapeFullURL() .
						'" rel="nofollow">' . $item['comment'] . '</a>';
				}

				$comment_url = '';
				if ( $item['type'] == 'comment' ) {
					$comment_url = "#comment-{$item['id']}";
				}

				$page_link = '<b><a href="' . $title->escapeFullURL() .
					"{$comment_url}\">" . $title->getPrefixedText() . '</a></b> ';
				$b = new UserBoard(); // Easier than porting the time-related functions here
				$item_time = '<span class="item-small">' .
					wfMsg( 'user-time-ago', $b->getTimeAgo( $item['timestamp'] ) ) .
				'</span>';

				if ( $x < $style_limit ) {
					$item_html .= '<div class="activity-item">
						<img src="' . $wgScriptPath . '/extensions/SocialProfile/images/' .
							UserActivity::getTypeIcon( $item['type'] ) . '" alt="" border="0" />';
				} else {
					$item_html .= '<div class="activity-item-bottom">
						<img src="' . $wgScriptPath . '/extensions/SocialProfile/images/' .
							UserActivity::getTypeIcon( $item['type'] ) . '" alt="" border="0" />';
				}

				$viewGift = SpecialPage::getTitleFor( 'ViewGift' );

				switch( $item['type'] ) {
					case 'edit':
						$item_html .= wfMsg( 'user-recent-activity-edit' ) . " {$page_link} {$item_time}
							<div class=\"item\">";
						if ( $item['comment'] ) {
							$item_html .= "\"{$item['comment']}\"";
						}
						$item_html .= '</div>';
						break;
					case 'vote':
						$item_html .= wfMsg( 'user-recent-activity-vote' ) . " {$page_link} {$item_time}";
						break;
					case 'comment':
						$item_html .= wfMsg( 'user-recent-activity-comment' ) . " {$page_link} {$item_time}
							<div class=\"item\">
								\"{$item['comment']}\"
							</div>";
						break;
					case 'gift-sent':
						$gift_image = "<img src=\"{$wgUploadPath}/awards/" .
							Gifts::getGiftImage( $item['namespace'], 'm' ) .
							'" border="0" alt="" />';
						$item_html .= wfMsg( 'user-recent-activity-gift-sent' ) . " {$user_link_2} {$item_time}
						<div class=\"item\">
							<a href=\"" . $viewGift->escapeFullURL( "gift_id={$item['id']}" ) . "\" rel=\"nofollow\">
								{$gift_image}
								{$item['pagetitle']}
							</a>
						</div>";
						break;
					case 'gift-rec':
						$gift_image = "<img src=\"{$wgUploadPath}/awards/" .
							Gifts::getGiftImage( $item['namespace'], 'm' ) .
							'" border="0" alt="" />';
						$item_html .= wfMsg( 'user-recent-activity-gift-rec' ) . " {$user_link_2} {$item_time}</span>
								<div class=\"item\">
									<a href=\"" . $viewGift->escapeFullURL( "gift_id={$item['id']}" ) . "\" rel=\"nofollow\">
										{$gift_image}
										{$item['pagetitle']}
									</a>
								</div>";
						break;
					case 'system_gift':
						$gift_image = "<img src=\"{$wgUploadPath}/awards/" .
							SystemGifts::getGiftImage( $item['namespace'], 'm' ) .
							'" border="0" alt="" />';
						$viewSystemGift = SpecialPage::getTitleFor( 'ViewSystemGift' );
						$item_html .= wfMsg( 'user-recent-system-gift' ) . " {$item_time}
								<div class=\"user-home-item-gift\">
									<a href=\"" . $viewSystemGift->escapeFullURL( "gift_id={$item['id']}" ) . "\" rel=\"nofollow\">
										{$gift_image}
										{$item['pagetitle']}
									</a>
								</div>";
						break;
					case 'friend':
						$item_html .= wfMsg( 'user-recent-activity-friend' ) .
							" <b>{$user_link_2}</b> {$item_time}";
						break;
					case 'foe':
						$item_html .= wfMsg( 'user-recent-activity-foe' ) .
							" <b>{$user_link_2}</b> {$item_time}";
						break;
					case 'system_message':
						$item_html .= "{$item['comment']} {$item_time}";
						break;
					case 'user_message':
						$item_html .= wfMsg( 'user-recent-activity-user-message' ) .
							" <b><a href=\"" . UserBoard::getUserBoardURL( $user_title_2->getText() ) .
								"\" rel=\"nofollow\">{$item['comment']}</a></b>  {$item_time}
								<div class=\"item\">
								\"{$item['namespace']}\"
								</div>";
						break;
					}

					$item_html .= '</div>';

					if ( $x <= $limit ) {
						$items_html_type['all'][] = $item_html;
					}
					$items_html_type[$item['type']][] = $item_html;

				$x++;
			}

			$by_type = '';
			foreach ( $items_html_type['all'] as $item ) {
				$by_type .= $item;
			}
			$output .= "<div id=\"recent-all\">$by_type</div>";
		}

		return $output;
	}

	function getGifts( $user_name ) {
		global $wgUser, $wgMemc, $wgUserProfileDisplay, $wgUploadPath;

		// If not enabled in site settings, don't display
		if ( $wgUserProfileDisplay['gifts'] == false ) {
			return '';
		}

		$output = '';

		// User to user gifts
		$g = new UserGifts( $user_name );
		$user_safe = urlencode( $user_name );

		// Try cache
		$key = wfMemcKey( 'user', 'profile', 'gifts', "{$g->user_id}" );
		$data = $wgMemc->get( $key );

		if ( !$data ) {
			wfDebug( "Got profile gifts for user {$user_name} from DB\n" );
			$gifts = $g->getUserGiftList( 0, 4 );
			$wgMemc->set( $key, $gifts, 60 * 60 * 4 );
		} else {
			wfDebug( "Got profile gifts for user {$user_name} from cache\n" );
			$gifts = $data;
		}

		$gift_count = $g->getGiftCountByUsername( $user_name );
		$gift_link = SpecialPage::getTitleFor( 'ViewGifts' );
		$per_row = 4;

		if ( $gifts ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' .
					wfMsg( 'user-gifts-title' ) .
				'</div>
				<div class="user-section-actions">
					<div class="action-right">';
			if ( $gift_count > 4 ) {
				$output .= '<a href="' . $gift_link->escapeFullURL( 'user=' . $user_safe ) . '" rel="nofollow">' .
					wfMsg( 'user-view-all' ) . '</a>';
			}
			$output .= '</div>
					<div class="action-left">';
			if ( $gift_count > 4 ) {
				$output .= wfMsg( 'user-count-separator', '4', $gift_count );
			} else {
				$output .= wfMsg( 'user-count-separator', $gift_count, $gift_count );
			}
			$output .= '</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="user-gift-container">';

			$x = 1;

			foreach ( $gifts as $gift ) {
				if ( $gift['status'] == 1 && $user_name == $wgUser->getName() ) {
					$g->clearUserGiftStatus( $gift['id'] );
					$wgMemc->delete( $key );
					$g->decNewGiftCount( $wgUser->getID() );
				}

				$user = Title::makeTitle( NS_USER, $gift['user_name_from'] );
				$gift_image = '<img src="' . $wgUploadPath . '/awards/' .
					Gifts::getGiftImage( $gift['gift_id'], 'ml' ) .
					'" border="0" alt="" />';
				$gift_link = $user = SpecialPage::getTitleFor( 'ViewGift' );
				$class = '';
				if ( $gift['status'] == 1 ) {
					$class = 'class="user-page-new"';
				}
				$output .= '<a href="' . $gift_link->escapeFullURL( 'gift_id=' . $gift['id'] ) . '" ' .
					$class . " rel=\"nofollow\">{$gift_image}</a>";
				if ( $x == count( $gifts ) || $x != 1 && $x % $per_row == 0 ) {
					$output .= '<div class="cleared"></div>';
				}

				$x++;
			}

			$output .= '</div>';
		}

		return $output;
	}

	function getAwards( $user_name ) {
		global $wgUser, $wgMemc, $wgUserProfileDisplay, $wgUploadPath;

		// If not enabled in site settings, don't display
		if ( $wgUserProfileDisplay['awards'] == false ) {
			return '';
		}

		$output = '';

		// System gifts
		$sg = new UserSystemGifts( $user_name );

		// Try cache
		$sg_key = wfMemcKey( 'user', 'profile', 'system_gifts', "{$sg->user_id}" );
		$data = $wgMemc->get( $sg_key );
		if ( !$data ) {
			wfDebug( "Got profile awards for user {$user_name} from DB\n" );
			$system_gifts = $sg->getUserGiftList( 0, 4 );
			$wgMemc->set( $sg_key, $system_gifts, 60 * 60 * 4 );
		} else {
			wfDebug( "Got profile awards for user {$user_name} from cache\n" );
			$system_gifts = $data;
		}

		$system_gift_count = $sg->getGiftCountByUsername( $user_name );
		$system_gift_link = SpecialPage::getTitleFor( 'ViewSystemGifts' );
		$per_row = 4;

		if ( $system_gifts ) {
			$x = 1;

			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' .
					wfMsg( 'user-awards-title' ) .
				'</div>
				<div class="user-section-actions">
					<div class="action-right">';
			if ( $system_gift_count > 4 ) {
				$output .= '<a href="' . $system_gift_link->escapeFullURL( 'user=' . $user_name ) . '" rel="nofollow">' .
					wfMsg( 'user-view-all' ) . '</a>';
			}
			$output .= '</div>
					<div class="action-left">';
			if ( $system_gift_count > 4 ) {
				$output .= wfMsg( 'user-count-separator', '4', $system_gift_count );
			} else {
				$output .= wfMsg( 'user-count-separator', $system_gift_count, $system_gift_count );
			}
			$output .= '</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<div class="user-gift-container">';

			foreach ( $system_gifts as $gift ) {
				if ( $gift['status'] == 1 && $user_name == $wgUser->getName() ) {
					$sg->clearUserGiftStatus( $gift['id'] );
					$wgMemc->delete( $sg_key );
					$sg->decNewSystemGiftCount( $wgUser->getID() );
				}

				$gift_image = '<img src="' . $wgUploadPath . '/awards/' .
					SystemGifts::getGiftImage( $gift['gift_id'], 'ml' ) .
					'" border="0" alt="" />';
				$gift_link = $user = SpecialPage::getTitleFor( 'ViewSystemGift' );

				$class = '';
				if ( $gift['status'] == 1 ) {
					$class = 'class="user-page-new"';
				}
				$output .= '<a href="' . $gift_link->escapeFullURL( 'gift_id=' . $gift['id'] ) .
					'" ' . $class . " rel=\"nofollow\">
					{$gift_image}
				</a>";

				if ( $x == count( $system_gifts ) || $x != 1 && $x % $per_row == 0 ) {
					$output .= '<div class="cleared"></div>';
				}
				$x++;
			}

			$output .= '</div>';
		}

		return $output;
	}

	/**
	 * Get the user board for a given user.
	 *
	 * @param $user_id Integer: user's ID number
	 * @param $user_name String: user name
	 */
	function getUserBoard( $user_id, $user_name ) {
		global $wgUser, $wgOut, $wgUserProfileDisplay, $wgUserProfileScripts;

		// Anonymous users cannot have user boards
		if ( $user_id == 0 ) {
			return '';
		}

		// Don't display anything if user board on social profiles isn't
		// enabled in site configuration
		if ( $wgUserProfileDisplay['board'] == false ) {
			return '';
		}

		$output = ''; // Prevent E_NOTICE

		$wgOut->addScriptFile( $wgUserProfileScripts . '/UserProfilePage.js' );

		$rel = new UserRelationship( $user_name );
		$friends = $rel->getRelationshipList( 1, 4 );

		$stats = new UserStats( $user_id, $user_name );
		$stats_data = $stats->getUserStats();
		$total = $stats_data['user_board'];

		// If the user is viewing their own profile or is allowed to delete
		// board messages, add the amount of private messages to the total
		// sum of board messages.
		if ( $wgUser->getName() == $user_name || $wgUser->isAllowed( 'userboard-delete' ) ) {
			$total = $total + $stats_data['user_board_priv'];
		}

		$output .= '<div class="user-section-heading">
			<div class="user-section-title">' .
				wfMsg( 'user-board-title' ) .
			'</div>
			<div class="user-section-actions">
				<div class="action-right">';
		if ( $wgUser->getName() == $user_name ) {
			if ( $friends ) {
				$output .= '<a href="' . UserBoard::getBoardBlastURL() . '">' .
					wfMsg( 'user-send-board-blast' ) . '</a>';
			}
			if ( $total > 10 ) {
				$output .= wfMsgExt( 'pipe-separator', 'escapenoentities' );
			}
		}
		if ( $total > 10 ) {
			$output .= '<a href="' . UserBoard::getUserBoardURL( $user_name ) . '">' .
				wfMsg( 'user-view-all' ) . '</a>';
		}
		$output .= '</div>
				<div class="action-left">';
		if ( $total > 10 ) {
			$output .= wfMsg( 'user-count-separator', '10', $total );
		} elseif ( $total > 0 ) {
			$output .= wfMsg( 'user-count-separator', $total, $total );
		}
		$output .= '</div>
				<div class="cleared"></div>
			</div>
		</div>
		<div class="cleared"></div>';

		if ( $wgUser->getName() !== $user_name ) {
			if ( $wgUser->isLoggedIn() && !$wgUser->isBlocked() ) {
				$output .= '<div class="user-page-message-form">
						<input type="hidden" id="user_name_to" name="user_name_to" value="' . addslashes( $user_name ) . '" />
						<span class="profile-board-message-type">' .
							wfMsgHtml( 'userboard_messagetype' ) .
						'</span>
						<select id="message_type">
							<option value="0">' .
								wfMsgHtml( 'userboard_public' ) .
							'</option>
							<option value="1">' .
								wfMsgHtml( 'userboard_private' ) .
							'</option>
						</select><p>
						<textarea name="message" id="message" cols="43" rows="4"/></textarea>
						<div class="user-page-message-box-button">
							<input type="button" value="' . wfMsg( 'userboard_sendbutton' ) . '" class="site-button" onclick="javascript:send_message();" />
						</div>
					</div>';
			} else {
				$login_link = SpecialPage::getTitleFor( 'Userlogin' );
				$output .= '<div class="user-page-message-form">' .
					wfMsg( 'user-board-login-message', $login_link->escapeFullURL() ) .
				'</div>';
			}
		}

		$output .= '<div id="user-page-board">';
		$b = new UserBoard();
		$output .= $b->displayMessages( $user_id, 0, 10 );
		$output .= '</div>';

		return $output;
	}

	/**
	 * Gets the user's fanboxes if $wgEnableUserBoxes = true; and
	 * $wgUserProfileDisplay['userboxes'] = true; and the FanBoxes extension is
	 * installed.
	 *
	 * @param $user_name String: user name
	 * @return String: HTML
	 */
	function getFanBoxes( $user_name ) {
		global $wgOut, $wgUser, $wgTitle, $wgMemc, $wgUserProfileDisplay, $wgFanBoxScripts, $wgEnableUserBoxes;

		if ( !$wgEnableUserBoxes || $wgUserProfileDisplay['userboxes'] == false ) {
			return '';
		}

		$wgOut->addScriptFile( $wgFanBoxScripts . '/FanBoxes.js' );
		$wgOut->addExtensionStyle( $wgFanBoxScripts . '/FanBoxes.css' );

		$output = '';
		$f = new UserFanBoxes( $user_name );

		// Try cache
		/*
		$key = wfMemcKey( 'user', 'profile', 'fanboxes', "{$f->user_id}" );
		$data = $wgMemc->get( $key );

		if( !$data ) {
			wfDebug( "Got profile fanboxes for user {$user_name} from DB\n" );
			$fanboxes = $f->getUserFanboxes( 0, 10 );
			$wgMemc->set( $key, $fanboxes );
		} else {
			wfDebug( "Got profile fanboxes for user {$user_name} from cache\n" );
			$fanboxes = $data;
		}
		*/

		$fanboxes = $f->getUserFanboxes( 0, 10 );

		$fanbox_count = $f->getFanBoxCountByUsername( $user_name );
		$fanbox_link = SpecialPage::getTitleFor( 'ViewUserBoxes' );
		$per_row = 1;

		if ( $fanboxes ) {
			$output .= '<div class="user-section-heading">
				<div class="user-section-title">' .
					wfMsg( 'user-fanbox-title' ) .
				'</div>
				<div class="user-section-actions">
					<div class="action-right">';
			// If there are more than ten fanboxes, display a "View all" link
			// instead of listing them all on the profile page
			if ( $fanbox_count > 10 ) {
				$output .= '<a href="' . $fanbox_link->escapeFullURL( 'user=' . $user_name ) . '" rel="nofollow">' .
					wfMsg( 'user-view-all' ) . '</a>';
			}
			$output .= '</div>
					<div class="action-left">';
			if ( $fanbox_count > 10 ) {
				$output .= wfMsg( 'user-count-separator', '10', $fanbox_count );
			} else {
				$output .= wfMsg( 'user-count-separator', $fanbox_count, $fanbox_count );
			}
			$output .= '</div>
					<div class="cleared"></div>

				</div>
			</div>
			<div class="cleared"></div>

			<div class="user-fanbox-container clearfix">';

			$x = 1;
			$tagParser = new Parser();
			foreach ( $fanboxes as $fanbox ) {
				$check_user_fanbox = $f->checkIfUserHasFanbox( $fanbox['fantag_id'] );

				if ( $fanbox['fantag_image_name'] ) {
					$fantag_image_width = 45;
					$fantag_image_height = 53;
					$fantag_image = wfFindFile( $fanbox['fantag_image_name'] );
					$fantag_image_url = '';
					if ( is_object( $fantag_image ) ) {
						$fantag_image_url = $fantag_image->createThumb(
							$fantag_image_width,
							$fantag_image_height
						);
					}
					$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '" />';
				}

				if ( $fanbox['fantag_left_text'] == '' ) {
					$fantag_leftside = $fantag_image_tag;
				} else {
					$fantag_leftside = $fanbox['fantag_left_text'];
					$fantag_leftside = $tagParser->parse(
						$fantag_leftside, $wgTitle,
						$wgOut->parserOptions(), false
					);
					$fantag_leftside = $fantag_leftside->getText();
				}

				$leftfontsize = '10px';
				$rightfontsize = '11px';
				if ( $fanbox['fantag_left_textsize'] == 'mediumfont' ) {
					$leftfontsize = '11px';
				}

				if ( $fanbox['fantag_left_textsize'] == 'bigfont' ) {
					$leftfontsize = '15px';
				}

				if ( $fanbox['fantag_right_textsize'] == 'smallfont' ) {
					$rightfontsize = '10px';
				}

				if ( $fanbox['fantag_right_textsize'] == 'mediumfont' ) {
					$rightfontsize = '11px';
				}

				// Get permalink
				$fantag_title = Title::makeTitle( NS_FANTAG, $fanbox['fantag_title'] );
				$right_text = $fanbox['fantag_right_text'];
				$right_text = $tagParser->parse(
					$right_text, $wgTitle, $wgOut->parserOptions(), false
				);
				$right_text = $right_text->getText();

				// Output fanboxes
				$output .= "<div class=\"fanbox-item\">
					<div class=\"individual-fanbox\" id=\"individualFanbox" . $fanbox['fantag_id'] . "\">
						<div class=\"show-message-container-profile\" id=\"show-message-container" . $fanbox['fantag_id'] . "\">
							<a class=\"perma\" style=\"font-size:8px; color:" . $fanbox['fantag_right_textcolor'] . "\" href=\"" . $fantag_title->escapeFullURL() . "\" title=\"{$fanbox['fantag_title']}\">" . wfMsg( 'fanbox-perma' ) . "</a>
							<table class=\"fanBoxTableProfile\" onclick=\"javascript:FanBoxes.openFanBoxPopup('fanboxPopUpBox{$fanbox['fantag_id']}', 'individualFanbox{$fanbox['fantag_id']}')\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
								<tr>
									<td id=\"fanBoxLeftSideOutputProfile\" style=\"color:" . $fanbox['fantag_left_textcolor'] . "; font-size:$leftfontsize\" bgcolor=\"" . $fanbox['fantag_left_bgcolor'] . "\">" . $fantag_leftside . "</td>
									<td id=\"fanBoxRightSideOutputProfile\" style=\"color:" . $fanbox['fantag_right_textcolor'] . "; font-size:$rightfontsize\" bgcolor=\"" . $fanbox['fantag_right_bgcolor'] . "\">" . $right_text . "</td>
								</tr>
							</table>
						</div>
					</div>";

				if ( $wgUser->isLoggedIn() ) {
					if ( $check_user_fanbox == 0 ) {
						$output .= "<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox" . $fanbox['fantag_id'] . "\">
							<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
								<tr>
									<td style=\"font-size:10px\">" . wfMsg( 'fanbox-add-fanbox' ) . "</td>
								</tr>
								<tr>
									<td align=\"center\">
										<input type=\"button\" value=\"" . wfMsg( 'fanbox-add' ) . "\" size=\"10\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$fanbox['fantag_id']}', 'individualFanbox{$fanbox['fantag_id']}'); FanBoxes.showAddRemoveMessageUserPage(1, {$fanbox['fantag_id']}, 'show-addremove-message-half')\" />
										<input type=\"button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"10\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$fanbox['fantag_id']}', 'individualFanbox{$fanbox['fantag_id']}')\" />
									</td>
								</tr>
							</table>
						</div>";
					} else {
						$output .= "<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox" . $fanbox['fantag_id'] . "\">
							<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
								<tr>
									<td style=\"font-size:10px\">" . wfMsg( 'fanbox-remove-fanbox' ) . "</td>
								</tr>
								<tr>
									<td align=\"center\">
										<input type=\"button\" value=\"" . wfMsg( 'fanbox-remove' ) . "\" size=\"10\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$fanbox['fantag_id']}', 'individualFanbox{$fanbox['fantag_id']}'); FanBoxes.showAddRemoveMessageUserPage(2, {$fanbox['fantag_id']}, 'show-addremove-message-half')\" />
										<input type=\"button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"10\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$fanbox['fantag_id']}', 'individualFanbox{$fanbox['fantag_id']}')\" />
									</td>
								</tr>
							</table>
						</div>";
					}
				}

				if ( $wgUser->getID() == 0 ) {
					$login = SpecialPage::getTitleFor( 'Userlogin' );
					$output .= "<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox" . $fanbox['fantag_id'] . "\">
						<table cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
							<tr>
								<td style=\"font-size:10px\">" .
									wfMsg( 'fanbox-add-fanbox-login' ) .
									"<a href=\"{$login->getFullURL()}\">" .
									wfMsg( 'fanbox-login' ) . "</a></td>
							</tr>
							<tr>
								<td align=\"center\">
									<input type=\"button\" value=\"" . wfMsg( 'cancel' ) . "\" size=\"10\" onclick=\"FanBoxes.closeFanboxAdd('fanboxPopUpBox{$fanbox['fantag_id']}', 'individualFanbox{$fanbox['fantag_id']}')\" />
								</td>
							</tr>
						</table>
					</div>";
				}

				$output .= '</div>';

				$x++;
			}
			$output .= '</div>';
		}

		return $output;
	}

	private function initializeProfileData( $username ) {
		if ( !$this->profile_data ) {
			$profile = new UserProfile( $username );
			$this->profile_data = $profile->getProfile();
		}
	}
}

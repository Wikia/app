<?php

class PollPage extends Article {

	var $title = null;

	/**
	 * Constructor and clear the article
	 * @param $title Object: reference to a Title object.
	 */
	public function __construct( Title $title ) {
		parent::__construct( $title );
	}

	/**
	 * Called on every poll page view.
	 */
	public function view() {
		global $wgUser, $wgTitle, $wgOut, $wgRequest, $wgScriptPath, $wgUploadPath, $wgLang;
		global $wgSupressPageTitle, $wgNameSpacesWithEditMenu;

		// Perform no custom handling if the poll in question has been deleted
		if ( !$this->getID() ) {
			parent::view();
		}

		$wgSupressPageTitle = true;
		$wgOut->setHTMLTitle( $wgTitle->getText() );
		$wgOut->setPageTitle( $wgTitle->getText() );

		$wgNameSpacesWithEditMenu[] = NS_POLL;

		$wgOut->addScript("<script type=\"text/javascript\">
			$( function() { LightBox.init(); PollNY.show(); } );
		</script>\n");

		$createPollObj = SpecialPage::getTitleFor( 'CreatePoll' );
		$wgOut->addHTML("<script type=\"text/javascript\">
			var _POLL_OPEN_MESSAGE = \"" . addslashes( wfMsg( 'poll-open-message' ) ) . "\";
			var _POLL_CLOSE_MESSAGE = \"" . addslashes( wfMsg( 'poll-close-message' ) ) . "\";
			var _POLL_FLAGGED_MESSAGE = \"" . addslashes( wfMsg( 'poll-flagged-message' ) ) . "\";
			var _POLL_FINISHED = \"" . addslashes( wfMsg( 'poll-finished', $createPollObj->getFullURL(), $wgTitle->getFullURL() ) ) . "\";
		</script>");

		// Get total polls count so we can tell the user how many they have
		// voted for out of total
		$dbr = wfGetDB( DB_MASTER );
		$total_polls = 0;
		$s = $dbr->selectRow(
			'poll_question',
			array( 'COUNT(*) AS count' ),
			array(),
			__METHOD__
		);
		if ( $s !== false ) {
			$total_polls = number_format( $s->count );
		}

		$stats = new UserStats( $wgUser->getID(), $wgUser->getName() );
		$stats_current_user = $stats->getUserStats();

		$sk = $wgUser->getSkin();

		$p = new Poll();
		$poll_info = $p->getPoll( $wgTitle->getArticleID() );

		if( !isset( $poll_info['id'] ) ) {
			return '';
		}

		// Set up submitter data
		$user_title = Title::makeTitle( NS_USER, $poll_info['user_name'] );
		$avatar = new wAvatar( $poll_info['user_id'], 'l' );
		$avatarID = $avatar->getAvatarImage();
		$stats = new UserStats( $poll_info['user_id'], $poll_info['user_name'] );
		$stats_data = $stats->getUserStats();
		$user_name_short = $wgLang->truncate( $poll_info['user_name'], 27 );

		$output = '<div class="poll-right">';
		// Show the "create a poll" link to registered users
		if( $wgUser->isLoggedIn() ) {
			$output .= '<div class="create-link">
				<a href="' . $createPollObj->escapeFullURL() . '">
					<img src="' . $wgScriptPath . '/extensions/PollNY/images/addIcon.gif" alt="" />'
					. wfMsg( 'poll-create' ) .
				'</a>
			</div>';
		}
		$output .= '<div class="credit-box">
					<h1>' . wfMsg( 'poll-submitted-by' ) . "</h1>
					<div class=\"submitted-by-image\">
						<a href=\"{$user_title->getFullURL()}\">
							<img src=\"{$wgUploadPath}/avatars/{$avatarID}\" style=\"border:1px solid #d7dee8; width:50px; height:50px;\"/>
						</a>
					</div>
					<div class=\"submitted-by-user\">
						<a href=\"{$user_title->getFullURL()}\">{$user_name_short}</a>
						<ul>
							<li>
								<img src=\"{$wgScriptPath}/extensions/PollNY/images/voteIcon.gif\" alt=\"\" />
								{$stats_data['votes']}
							</li>
							<li>
								<img src=\"{$wgScriptPath}/extensions/PollNY/images/pencilIcon.gif\" alt=\"\" />
								{$stats_data['edits']}
							</li>
							<li>
								<img src=\"{$wgScriptPath}/extensions/PollNY/images/commentsIcon.gif\" alt=\"\" />
								{$stats_data['comments']}
							</li>
						</ul>
					</div>
					<div class=\"cleared\"></div>

					<a href=\"" . SpecialPage::getTitleFor( 'ViewPoll' )->escapeFullURL( 'user=' . $poll_info['user_name'] ) . '">'
						. wfMsgExt( 'poll-view-all-by', 'parsemag', $user_name_short ) . '</a>

				</div>';

		$output .= '<div class="poll-stats">';

		if( $wgUser->isLoggedIn() ) {
			$output .= wfMsgExt(
				'poll-voted-for',
				'parsemag',
				'<b>' . $stats_current_user['poll_votes'] . '</b>',
				$total_polls,
				number_format( $stats_current_user['poll_votes'] * 5 )
			);
		} else {
			$output .= wfMsgExt(
				'poll-would-have-earned',
				'parse',
				number_format( $total_polls * 5 )
			);
		}

		$output .= '</div>' . "\n";

		$toggle_flag_label = ( ( $poll_info['status'] == 1 ) ? wfMsg( 'poll-flag-poll' ) : wfMsg( 'poll-unflag-poll' ) );
		$toggle_flag_status = ( ( $poll_info['status'] == 1 ) ? 2 : 1 );

		if( $poll_info['status'] == 1 ) {
			// Creator and admins can change the status of a poll
			$toggle_label = ( ( $poll_info['status'] == 1 ) ? wfMsg( 'poll-close-poll' ) : wfMsg( 'poll-open-poll' ) );
			$toggle_status = ( ( $poll_info['status'] == 1 ) ? 0 : 1 );
		}

		$output .= '<div class="poll-links">' . "\n";

		// Poll administrators can access the poll admin panel
		if( $wgUser->isAllowed( 'polladmin' ) ) {
			$output .= '<a href="' . SpecialPage::getTitleFor( 'AdminPoll' )->escapeFullURL() . '">' . wfMsg( 'poll-admin-panel' ) . '</a> | ';
		}
		if( $poll_info['status'] == 1 && ( $poll_info['user_id'] == $wgUser->getID() || $wgUser->isAllowed( 'polladmin' ) ) ) {
			$output .= "<a href=\"javascript:void(0)\" onclick=\"PollNY.toggleStatus({$toggle_status});\">{$toggle_label}</a> |";
		}
		if( $poll_info['status'] == 1 || $wgUser->isAllowed( 'polladmin' ) ) {
			$output .= " <a href=\"javascript:void(0)\" onclick=\"PollNY.toggleStatus({$toggle_flag_status});\">{$toggle_flag_label}</a>";
		}
		$output .= "\n" . '</div>' . "\n"; // .poll-links

		$output .= '</div>' . "\n"; // .poll-right
		$output .= '<div class="poll">' . "\n";

		$output .= "<h1 class=\"pagetitle\">{$wgTitle->getText()}</h1>\n";

		if( $poll_info['image'] ) {
			$poll_image_width = 150;
			$poll_image = wfFindFile( $poll_info['image'] );
			$poll_image_url = $width = '';
			if ( is_object( $poll_image ) ) {
				$poll_image_url = $poll_image->createThumb( $poll_image_width );
				if ( $poll_image->getWidth() >= $poll_image_width ) {
					$width = $poll_image_width;
				} else {
					$width = $poll_image->getWidth();
				}
			}
			$poll_image_tag = '<img width="' . $width . '" alt="" src="' . $poll_image_url . '"/>';
			$output .= "<div class=\"poll-image\">{$poll_image_tag}</div>";
		}

		// Display question and let user vote
		if( !$p->userVoted( $wgUser->getName(), $poll_info['id'] ) && $poll_info['status'] == 1 ) {
			$output .= '<div id="loading-poll">' . wfMsg( 'poll-js-loading' ) . '</div>' . "\n";
			$output .= '<div id="poll-display" style="display:none;">' . "\n";
			$output .= '<form name="poll"><input type="hidden" id="poll_id" name="poll_id" value="' . $poll_info['id'] . '"/>' . "\n";

			foreach( $poll_info['choices'] as $choice ) {
				$output .= '<div class="poll-choice">
					<input type="radio" name="poll_choice" onclick="PollNY.vote()" id="poll_choice" value="' . $choice['id'] . '" />'
						. $choice['choice'] .
				'</div>';
			}

			$output .= '</form>
					</div>' . "\n";

			$output .= '<div class="poll-timestamp">' .
					wfMsg( 'poll-createdago', Poll::getTimeAgo( $poll_info['timestamp'] ) ) .
				'</div>' . "\n";

			$output .= "\t\t\t\t\t" . '<div class="poll-button">
					<a href="javascript:PollNY.skip();">' .
						wfMsg( 'poll-skip' ) . '</a>
				</div>';

			if( $wgRequest->getInt( 'prev_id' ) ) {
				$p = new Poll();
				$poll_info_prev = $p->getPoll( $wgRequest->getInt( 'prev_id' ) );
				$poll_title = Title::makeTitle( NS_POLL, $poll_info_prev['question'] );
				$output .= '<div class="previous-poll">';

				$output .= '<div class="previous-poll-title">' . wfMsg( 'poll-previous-poll' ) .
					" - <a href=\"{$poll_title->getFullURL()}\">{$poll_info_prev['question']}</a></div>
					<div class=\"previous-sub-title\">"
						. wfMsgExt( 'poll-view-answered-times', 'parsemag', $poll_info_prev['votes'] ) .
					'</div>';

				$x = 1;

				foreach( $poll_info_prev['choices'] as $choice ) {
					if( $poll_info_prev['votes']  > 0 ) {
						$percent = round( $choice['votes'] / $poll_info_prev['votes'] * 100 );
						$bar_width = floor( 360 * ( $choice['votes'] / $poll_info_prev['votes'] ) );
					} else {
						$percent = 0;
						$bar_width = 0;
					}

					if ( empty( $choice['votes'] ) ) {
						$choice['votes'] = 0;
					}

					$bar_img = '<img src="' . $wgScriptPath . '/extensions/PollNY/images/vote-bar-' . $x .
						'.gif" class="image-choice-' . $x .
						'" style="width:' . $bar_width . 'px;height:11px;"/>';
					$output .= "<div class=\"previous-poll-choice\">
								<div class=\"previous-poll-choice-left\">{$choice['choice']} ({$percent}%)</div>";

					$output .= "<div class=\"previous-poll-choice-right\">{$bar_img} <span class=\"previous-poll-choice-votes\">" .
							wfMsgExt( 'poll-votes', 'parsemag', $choice['votes'] ) .
						'</span></div>';

					$output .= '</div>';

					$x++;
				}
				$output .= '</div>';
			}

		} else {
			$show_results = true;
			// Display message if poll has been closed for voting
			if( $poll_info['status'] == 0 ) {
				$output .= '<div class="poll-closed">' .
					wfMsg( 'poll-closed' ) . '</div>';
			}

			// Display message if poll has been flagged
			if( $poll_info['status'] == 2 ) {
				$output .= '<div class="poll-closed">' .
					wfMsg( 'poll-flagged' ) . '</div>';
				if( !$wgUser->isAllowed( 'polladmin' ) ) {
					$show_results = false;
				}
			}

			if( $show_results ) {
				$x = 1;

				foreach( $poll_info['choices'] as $choice ) {
					if( $poll_info['votes'] > 0 ) {
						$percent = round( $choice['votes'] / $poll_info['votes'] * 100 );
						$bar_width = floor( 480 * ( $choice['votes'] / $poll_info['votes'] ) );
					} else {
						$percent = 0;
						$bar_width = 0;
					}

					// If it's not set, it means that no-one has voted for that
					// choice yet...it also means that we need to set it
					// manually here so that i18n displays properly
					if ( empty( $choice['votes'] ) ) {
						$choice['votes'] = 0;
					}
					$bar_img = "<img src=\"{$wgScriptPath}/extensions/PollNY/images/vote-bar-{$x}.gif\" class=\"image-choice-{$x}\" style=\"width:{$bar_width}px;height:12px;\"/>";

					$output .= "<div class=\"poll-choice\">
					<div class=\"poll-choice-left\">{$choice['choice']} ({$percent}%)</div>";

					$output .= "<div class=\"poll-choice-right\">{$bar_img} <span class=\"poll-choice-votes\">"
						. wfMsgExt( 'poll-votes', 'parsemag', $choice['votes'] ) .
					'</span></div>';
					$output .= '</div>';

					$x++;
				}
			}

			$output .= '<div class="poll-total-votes">(' .
				wfMsgExt( 'poll-based-on-votes', 'parsemag', $poll_info['votes'] ) .
			')</div>
			<div class="poll-timestamp">' .
				wfMsg( 'poll-createdago', Poll::getTimeAgo( $poll_info['timestamp'] ) ) .
			'</div>


			<div class="poll-button">
				<input type="hidden" id="poll_id" name="poll_id" value="' . $poll_info['id'] . '" />
				<a href="javascript:PollNY.loadingLightBox();PollNY.goToNewPoll();">' .
					wfMsg( 'poll-next-poll' ) . '</a>
			</div>';
		}

		// "Embed this on a wiki page" feature
		$poll_embed_name = htmlspecialchars( $wgTitle->getText(), ENT_QUOTES );
		$output .= '<br />
			<table cellpadding="0" cellspacing="2" border="0">
				<tr>
					<td>
						<b>' . wfMsg( 'poll-embed' ) . "</b>
					</td>
					<td>
						<form name=\"embed_poll\">
							<input name='embed_code' style='width:300px;font-size:10px;' type='text' value='<pollembed title=\"{$poll_embed_name}\" />' onclick='javascript:document.embed_poll.embed_code.focus();document.embed_poll.embed_code.select();' readonly='readonly' />
						</form>
					</td>
				</tr>
			</table>\n";

		$output .= '</div>' . "\n"; // .poll

		$output .= '<div class="cleared"></div>';

		$wgOut->addHTML( $output );

		global $wgPollDisplay;
		if( $wgPollDisplay['comments'] ) {
			$wgOut->addWikiText( '<comments/>' );
		}
	}
}
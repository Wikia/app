<?php

class QuizGameHome extends UnlistedSpecialPage {

	/**
	 * @var String: salt used to generate MD5-hashed keys; this is set to
	 * 'SALT' in execute()
	 */
	private $SALT;

	/**
	 * Construct the MediaWiki special page
	 */
	public function __construct() {
		parent::__construct( 'QuizGameHome' );
	}

	/**
	 * Show the special page
	 *
	 * @param $permalink Mixed: parameter passed to the page or null
	 */
	public function execute( $permalink ) {
		global $wgRequest, $wgUser, $wgOut, $wgSupressPageTitle, $wgScriptPath;

		// Is the database locked? If so, we can't do much since answering a
		// question changes database state...and so does creating a new
		// question
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return false;
		}

		// Blocked through Special:Block? No access for you either!
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage( false );
			return false;
		}

		// If a parameter was passed to the special page, assume that it's the
		// permalink ID and forward the user to the question with that ID
		if( $permalink ) {
			$wgOut->redirect(
				$this->getTitle()->getFullURL(
					"questionGameAction=renderPermalink&permalinkID={$permalink}"
				)
			);
		}

		$wgSupressPageTitle = true;

		// Add CSS & JS
		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$wgOut->addModules( 'ext.quizGame' );
		} else {
			$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/QuizGame/questiongame.css' );
			$wgOut->addScriptFile( $wgScriptPath . '/extensions/QuizGame/js/QuizGame.js' );
		}

		// salt at will
		$this->SALT = 'SALT';

		// What we should do depends on the given action parameter
		$action = $wgRequest->getVal( 'questionGameAction' );

		switch( $action ) {
			case 'adminPanel':
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed( 'quizadmin' ) ) {
					$this->adminPanel();
				} else {
					$this->renderWelcomePage();
				}
				break;
			case 'completeEdit':
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed( 'quizadmin' ) ) {
					$this->completeEdit();
				} else {
					$this->renderWelcomePage();
				}
				break;
			case 'createForm':
				if( !$wgUser->isLoggedIn() ) {
					$this->renderLoginPage();
					return;
				}
				$this->renderWelcomePage();
				break;
			case 'createGame':
				$this->createQuizGame();
				break;
			case 'editItem':
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed( 'quizadmin' ) ) {
					$this->editItem();
				} else {
					$this->renderWelcomePage();
				}
				break;
			case 'launchGame':
				$this->launchGame();
				break;
			case 'renderPermalink':
				$this->launchGame();
				break;
		default:
			$this->launchGame();
			break;
		}
	}

	public function userAnswered( $user_name, $q_id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'quizgame_answers',
			array( 'a_choice_id' ),
			array(
				'a_q_id' => intval( $q_id ),
				'a_user_name' => $user_name
			),
			__METHOD__
		);
		if ( $s !== false ) {
			if( $s->a_choice_id == 0 ) {
				return -1;
			} else {
				return $s->a_choice_id;
			}
		}
		return false;
	}

	public function getAnswerPoints( $user_name, $q_id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'quizgame_answers',
			array( 'a_points' ),
			array(
				'a_q_id' => intval( $q_id ),
				'a_user_name' => $user_name
			),
			__METHOD__
		);
		if ( $s !== false ) {
			return $s->a_points;
		}
		return false;
	}

	public function getNextQuestion() {
		global $wgUser;
		$dbr = wfGetDB( DB_SLAVE );
		$use_index = $dbr->useIndexClause( 'q_random' );
		$randstr = wfRandom();

		$q_id = 0;
		$sql = "SELECT q_id FROM {$dbr->tableName( 'quizgame_questions' )} {$use_index} WHERE q_id NOT IN
				(SELECT a_q_id FROM {$dbr->tableName( 'quizgame_answers' )} WHERE a_user_name = '" . $dbr->strencode( $wgUser->getName() ) . "')
				AND q_flag != " . QUIZGAME_FLAG_FLAGGED . " AND q_user_id <> " . $wgUser->getID() . " AND q_random>$randstr ORDER by q_random LIMIT 1";
		$res = $dbr->query( $sql, __METHOD__ );
		$row = $dbr->fetchObject( $res );
		if( $row ) {
			$q_id = $row->q_id;
		}
		if( $q_id == 0 ) {
			$sql = "SELECT q_id FROM {$dbr->tableName( 'quizgame_questions' )} {$use_index} WHERE q_id NOT IN
					(SELECT a_q_id FROM {$dbr->tableName( 'quizgame_answers' )} WHERE a_user_name = '" . $dbr->strencode( $wgUser->getName() ) . "')
					AND q_flag != " . QUIZGAME_FLAG_FLAGGED . " AND q_user_id <> " . $wgUser->getID() . " AND q_random<$randstr ORDER by q_random LIMIT 1";
			$res = $dbr->query( $sql, __METHOD__ );
			$row = $dbr->fetchObject( $res );
			if( $row ) {
				$q_id = $row->q_id;
			}
		}
		return $q_id;
	}

	/**
	 * Get information about an individual question.
	 *
	 * @param $questionId Integer: question ID
	 * @param $skipId Integer: if defined, the question ID (q_id) must *not* be
	 *                         this
	 * @return Array
	 */
	public function getQuestion( $questionId, $skipId = 0 ) {
		global $wgUser;

		$dbr = wfGetDB( DB_SLAVE );
		$where = array();
		$where['q_id'] = intval( $questionId );
		if( $skipId > 0 ) {
			$where[] = "q_id <> {$skipId}";
		}
		$res = $dbr->select(
			'quizgame_questions',
			array(
				'q_id', 'q_user_id', 'q_user_name', 'q_text', 'q_flag',
				'q_answer_count', 'q_answer_correct_count', 'q_picture',
				'q_date'
			),
			$where,
			__METHOD__,
			array( 'LIMIT' => 1 )
		);
		$row = $dbr->fetchObject( $res );
		$quiz = array();
		if( $row ) {
			$quiz['text'] = $row->q_text;
			$quiz['image'] = $row->q_picture;
			$quiz['user_name'] = $row->q_user_name;
			$quiz['user_id'] = $row->q_user_id;
			$quiz['answer_count'] = $row->q_answer_count;
			$quiz['id'] = $row->q_id;
			$quiz['status'] = $row->q_flag;

			if( $row->q_answer_count > 0 ) {
				$correct_percent = str_replace( '.0', '', number_format( $row->q_answer_correct_count / $row->q_answer_count * 100, 1 ) );
			} else {
				$correct_percent = 0;
			}
			$quiz['correct_percent'] = $correct_percent;
			$quiz['user_answer'] = $this->userAnswered( $wgUser->getName(), $row->q_id );

			if( $quiz['user_answer'] ) {
				$quiz['points'] = $this->getAnswerPoints( $wgUser->getName(), $questionId );
			}
			$choices = $this->getQuestionChoices( $questionId, $row->q_answer_count );
			foreach( $choices as $choice ) {
				if( $choice['is_correct'] ) {
					$quiz['correct_answer'] = $choice['id'];
				}
			}
			$quiz['choices'] = $choices;
		}
		return $quiz;
	}

	/**
	 * Get the answer options for a question when we know its ID number.
	 *
	 * @param $questionId Integer: question ID
	 * @param $question_answer_count Integer: amount of answers on the question
	 * @return Array
	 */
	public function getQuestionChoices( $questionId, $question_answer_count = 0 ) {
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			'quizgame_choice',
			array(
				'choice_id', 'choice_text', 'choice_order',
				'choice_answer_count', 'choice_is_correct'
			),
			array( 'choice_q_id' => intval( $questionId ) ),
			__METHOD__,
			array( 'ORDER BY' => 'choice_order' )
		);

		$choices = array();
		foreach( $res as $row ) {
			if( $question_answer_count ) {
				$percent = str_replace( '.0', '', number_format( $row->choice_answer_count / $question_answer_count * 100, 1 ) );
			} else {
				$percent = 0;
			}

			$choices[] = array(
				'id' => $row->choice_id,
				'text' => $row->choice_text,
				'is_correct' => $row->choice_is_correct,
				'answers' => $row->choice_answer_count,
				'percent' => $percent
			);
		}

		return $choices;
	}

	function adminPanel() {
		global $wgOut;

		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			'quizgame_questions',
			array( 'q_id', 'q_text', 'q_flag', 'q_picture', 'q_comment' ),
			array(
				// I'd like to know the ideal way of doing this.
				// Database::makeList() has a tendency of making the world
				// explode (see my notes on VideoHooks::onVideoDelete to find
				// out what I mean)
				'q_flag = ' . QUIZGAME_FLAG_FLAGGED . ' OR q_flag = ' .
					QUIZGAME_FLAG_PROTECT
			),
			__METHOD__
		);

		// Define variables to avoid E_NOTICEs
		$flaggedQuestions = '';
		$protectedQuestions = '';

		foreach( $res as $row ) {
			$options = '<ul>';
			$choices = $this->getQuestionChoices( $row->q_id );
			foreach( $choices as $choice ) {
				$options .= '<li>' . $choice['text'] . ' ' .
					( ( $choice['is_correct'] == 1 ) ? ' — ' . wfMsg( 'quiz-correct-answer' ) : '' ) .
					'</li>';
			}
			$options .= '</ul>';

			$thumbnail = '';
			if ( strlen( $row->q_picture ) > 0 ) {
				$image = wfFindFile( $row->q_picture );
				// You know why this check is here, just grep for the function
				// name (I'm too lazy to copypaste it here for the third time).
				if ( is_object( $image ) ) {
					$thumb = $image->transform( array( 'width' => 80, 'height' => 0 ) );
					$thumbnail = $thumb->toHtml();
				}
			}

			$key = md5( $this->SALT . $row->q_id );
			$buttons = '<a href="' . $this->getTitle()->escapeFullURL( "questionGameAction=editItem&quizGameId={$row->q_id}&quizGameKey={$key}" ) .
				"\">" . wfMsg( 'quiz-edit' ) . "</a> -
					<a href=\"javascript:QuizGame.deleteById('{$row->q_id}', '{$key}')\">" .
					wfMsg( 'quiz-delete' ) . '</a> - ';

			if ( $row->q_flag == QUIZGAME_FLAG_FLAGGED ) {
				$buttons .= "<a href=\"javascript:QuizGame.protectById('{$row->q_id}', '{$key}')\">" .
					wfMsg( 'quiz-protect' ) . "</a>
						 - <a href=\"javascript:QuizGame.unflagById('{$row->q_id}', '{$key}')\">" .
						 wfMsg( 'quiz-reinstate' ) . "</a>";
			} else {
				$buttons .= "<a href=\"javascript:QuizGame.unprotectById({$row->q_id}, '{$key}')\">" .
					wfMsg( 'quiz-unprotect' ) . "</a>";
			}

			if( $row->q_flag == QUIZGAME_FLAG_FLAGGED ) {
				$reason = '';
				if( $row->q_comment != '' ) {
					$reason = "<div class=\"quizgame-flagged-answers\" id=\"quizgame-flagged-reason-{$row->q_id}\">
						<b>" . wfMsg( 'quiz-flagged-reason' ) . "</b>: {$row->q_comment}
					</div><p>";
				}

				$flaggedQuestions .= "<div class=\"quizgame-flagged-item\" id=\"items[{$row->q_id}]\">

				<h3>{$row->q_text}</h3>

				<div class=\"quizgame-flagged-picture\" id=\"quizgame-flagged-picture-{$row->q_id}\">
					{$thumbnail}
				</div>

				<div class=\"quizgame-flagged-answers\" id=\"quizgame-flagged-answers-{$row->q_id}\">
					{$options}
				</div>
				{$reason}
				<div class=\"quizgame-flagged-buttons\" id=\"quizgame-flagged-buttons\">
					{$buttons}
				</div>

			</div>";
			} else {
				$protectedQuestions .= "<div class=\"quizgame-protected-item\" id=\"items[{$row->q_id}]\">

			   	<h3>{$row->q_text}</h3>

				<div class=\"quizgame-flagged-picture\" id=\"quizgame-flagged-picture-{$row->q_id}\">
					{$thumbnail}
				</div>

				<div class=\"quizgame-flagged-answers\" id=\"quizgame-flagged-answers-{$row->q_id}\">
					{$options}
				</div>

				<div class=\"quizgame-flagged-buttons\" id=\"quizgame-flagged-buttons\">
					{$buttons}
				</div>

			</div>";
			}
		}

		$wgOut->setPageTitle( wfMsg( 'quiz-admin-panel-title' ) );

		$output = '<div class="quizgame-admin" id="quizgame-admin">

				<div class="ajax-messages" id="ajax-messages" style="margin:0px 0px 15px 0px;"></div>

				<div class="quizgame-admin-top-links">
					<a href="' . $this->getTitle()->escapeFullURL( 'questionGameAction=launchGame' ) . '">' .
						wfMsg( 'quiz-admin-back' ) . '</a>
				</div>

				<h1>' . wfMsg( 'quiz-admin-flagged' ) . "</h1>
				{$flaggedQuestions}

				<h1>" . wfMsg( 'quiz-admin-protected' ) . "</h1>
				{$protectedQuestions}

			</div>";

		$wgOut->addHTML( $output );
	}

	/**
	 * Completes an edit of a question
	 * Updates the SQL and then forwards to the permalink
	 */
	function completeEdit() {
		global $wgRequest, $wgUser, $wgOut;

		$key = $wgRequest->getVal( 'quizGameKey' );
		$id = $wgRequest->getInt( 'quizGameId' );

		// Only Quiz Administrators can perform this operation.
		if( !$wgUser->isAllowed( 'quizadmin' ) ) {
			$wgOut->addHTML( wfMsg( 'quiz-admin-permission' ) );
			return;
		}

		$question = $wgRequest->getVal( 'quizgame-question' );
		$choices_count = $wgRequest->getInt( 'choices_count' );
		$old_correct_id = $wgRequest->getInt( 'old_correct' );

		$picture = $wgRequest->getVal( 'quizGamePicture' );

		// Updated quiz choices
		$dbw = wfGetDB( DB_MASTER );
		for( $x = 1; $x <= $choices_count; $x++ ) {
			if( $wgRequest->getVal( "quizgame-answer-{$x}" ) ) {
				if( $wgRequest->getVal( "quizgame-isright-{$x}" ) == 'on' ) {
					$is_correct = 1;
				} else {
					$is_correct = 0;
				}

				$dbw->update(
					'quizgame_choice',
					array(
						'choice_text' => $wgRequest->getVal( "quizgame-answer-{$x}" ),
						'choice_is_correct' => $is_correct
					),
					array( 'choice_q_id' => $id, 'choice_order' => $x ),
					__METHOD__
				);
			}
		}

		$dbw->update(
			'quizgame_questions',
			array( 'q_text' => $question, 'q_picture' => $picture ),
			array( 'q_id' => $id ),
			__METHOD__
		);

		// Get new correct answer to see if it's different, and if so,
		// we have to update any user stats
		$s = $dbw->selectRow(
			'quizgame_choice',
			array( 'choice_id' ),
			array( 'choice_q_id' => $id, 'choice_is_correct' => 1 ),
			__METHOD__
		);
		if ( $s !== false ) {
			$new_correct_id = $s->choice_id;
		}

		// Ruh roh rorge...we have to fix stats
		if( $new_correct_id != $old_correct_id ) {
			// Those who had the old answer ID correct need their total to be decremented
			$sql = "UPDATE {$dbw->tableName( 'user_stats' )}
				SET stats_quiz_questions_correct=stats_quiz_questions_correct-1
				WHERE stats_user_id IN
				(
					SELECT a_user_id
					FROM {$dbw->tableName( 'quizgame_answers' )}
					WHERE a_choice_id = {$old_correct_id}
				)";
			$res = $dbw->query( $sql, __METHOD__ );

			// Those who had the new answer ID correct need their total to be increased
			$sql = "UPDATE {$dbw->tableName( 'user_stats' )}
				SET stats_quiz_questions_correct=stats_quiz_questions_correct+1
				WHERE stats_user_id IN
				(
					SELECT a_user_id
					FROM {$dbw->tableName( 'quizgame_answers' )}
					WHERE a_choice_id = {$new_correct_id}
				)";
			$res = $dbw->query( $sql, __METHOD__ );

			// Finally, we need to adjust everyone's %'s who have been affected by this switch
			$sql = "UPDATE {$dbw->tableName( 'user_stats' )}
				SET stats_quiz_questions_correct_percent=stats_quiz_questions_correct /stats_quiz_questions_answered
				WHERE stats_user_id IN
				(
					SELECT a_user_id
					FROM {$dbw->tableName( 'quizgame_answers' )}
					WHERE a_choice_id = {$new_correct_id} OR a_choice_id = {$old_correct_id}
				)";
			$res = $dbw->query( $sql, __METHOD__ );

			// Also, we need to adjust the question table and fix how many answered it correctly
			/*
			$howMany = $dbw->selectField(
				'quizgame_answers',
				'COUNT(*)',
				array( 'a_choice_id' => $new_correct_id ),
				__METHOD__
			);
			$res = $dbw->update(
				'quizgame_questions',
				array( 'q_answer_correct_count' => intval( $howMany ) ),
				array( 'q_id' => $id ),
				__METHOD__
			);
			*/
			$sql = "UPDATE {$dbw->tableName( 'quizgame_questions' )}
				SET q_answer_correct_count=
				(
					SELECT COUNT(*)
					FROM {$dbw->tableName( 'quizgame_answers' )}
					WHERE a_choice_id = {$new_correct_id}
				)
				WHERE q_id={$id} ";
			$res = $dbw->query( $sql, __METHOD__ );
		}

		header( 'Location: ' . $this->getTitle()->getFullURL( "renderPermalink&permalinkID={$id}" ) );
	}

	/**
	 * Shows the edit panel for a single question
	 */
	function editItem() {
		global $wgRequest, $wgOut, $wgScriptPath, $wgUploadPath, $wgQuizID;

		$key = $wgRequest->getVal( 'quizGameKey' );
		$id = $wgRequest->getInt( 'quizGameId' );

		$wgQuizID = $id;

		if( $key != md5( $this->SALT . $id ) ) {
			// @todo FIXME/CHECKME: why is this commented out?
			//$wgOut->addHTML( wfMsg( 'quiz-admin-permission' ) );
			//return;
		}

		$question = $this->getQuestion( $id );

		$wgOut->setPageTitle( wfMsg( 'quiz-edit-title', $question['text'] ) );

		$user_name = $question['user_name'];
		$user_id = $question['user_id'];
		$user_title = Title::makeTitle( NS_USER, $question['user_name'] );
		$avatar = new wAvatar( $user_id, 'l' );
		$avatarID = $avatar->getAvatarImage();
		$stats = new UserStats( $user_id, $user_name );
		$stats_data = $stats->getUserStats();

		$uploadPage = SpecialPage::getTitleFor( 'QuestionGameUpload' );

		if( strlen( $question['image'] ) > 0 ) {
			$image = wfFindFile( $question['image'] );
			$thumbtag = '';
			// If a file that is still being used on a quiz game is
			// independently deleted from the quiz game, poor users will
			// stumble upon nasty fatals without this check here.
			if ( is_object( $image ) ) {
				$thumb = $image->transform( array( 'width' => 80 ) );
				$thumbtag = $thumb->toHtml();
			}

			$pictag = '<div id="quizgame-picture" class="quizgame-picture">' . $thumbtag . '</div>
					<p id="quizgame-editpicture-link"><a href="javascript:QuizGame.showUpload()">' .
						wfMsg( 'quiz-edit-picture-link' ) . '</a></p>
					<div id="quizgame-upload" class="quizgame-upload" style="display:none">
						<iframe id="imageUpload-frame" class="imageUpload-frame" width="650" scrolling="no" frameborder="0" src="' .
							$uploadPage->escapeFullURL( wfArrayToCGI( array(
								'wpThumbWidth' => '80',
								'wpCategory' => 'Quizgames',
								'wpOverwriteFile' => 'true',
								'wpDestFile' => $question['image']
							) ) ) . '">
						</iframe>
					</div>';

		} else {
			$pictag = '<div id="quizgame-picture" class="quizgame-picture"></div>
					<div id="quizgame-editpicture-link"></div>

					<div id="quizgame-upload" class="quizgame-upload">
						<iframe id="imageUpload-frame" class="imageUpload-frame" width="650" scrolling="no" frameborder="0" src="' .
							$uploadPage->escapeFullURL( wfArrayToCGI( array(
								'wpThumbWidth' => '80',
								'wpCategory' => 'Quizgames'
							) ) ) . '">
						</iframe>
					</div>';
		}

		$x = 1;
		$choices_count = count( $question['choices'] );
		$quizOptions = '';
		foreach( $question['choices'] as $choice ) {
			if( $choice['is_correct'] ) {
				$old_correct = $choice['id'];
			}
			$quizOptions .= "<div id=\"quizgame-answer-container-{$x}\" class=\"quizgame-answer\">
							<span class=\"quizgame-answer-number\">{$x}.</span>
							<input name=\"quizgame-answer-{$x}\" id=\"quizgame-answer-{$x}\" type=\"text\" value=\"" .
								htmlspecialchars( $choice['text'], ENT_QUOTES ) . "\" size=\"32\" />
							<input type=\"checkbox\" onclick=\"javascript:QuizGame.toggleCheck(this)\" id=\"quizgame-isright-{$x}\" " .
								( ( $choice['is_correct'] ) ? 'checked="checked"' : '' ) .
								" name=\"quizgame-isright-{$x}\">
						</div>";

			$x++;
		}

		// As nice as it'd be to move this variable to a function that is
		// hooked to MakeGlobalVariablesScript, it's impossible. So don't even
		// bother trying, mmmkay?
		$output = "<div class=\"quizgame-edit-container\" id=\"quizgame-edit-container\">

				<script type=\"text/javascript\">
				var __choices_count__ = {$choices_count};
				</script>";

		global $wgRightsText;
		if ( $wgRightsText ) {
			$copywarnMsg = 'copyrightwarning';
			$copywarnMsgParams = array(
				'[[' . wfMsgForContent( 'copyrightpage' ) . ']]',
				$wgRightsText
			);
		} else {
			$copywarnMsg = 'copyrightwarning2';
			$copywarnMsgParams = array(
				'[[' . wfMsgForContent( 'copyrightpage' ) . ']]'
			);
		}

		$output .= "
				<div class=\"quizgame-edit-question\" id=\"quizgame-edit-question\">
					<form name=\"quizGameEditForm\" id=\"quizGameEditForm\" method=\"post\" action=\"" .
						$this->getTitle()->escapeFullURL( 'questionGameAction=completeEdit' ) .
						'">

						<div class="credit-box" id="creditBox">
							<h1>' . wfMsg( 'quiz-submitted-by' ) . "</h1>

							<div id=\"submitted-by-image\" class=\"submitted-by-image\">
							<a href=\"{$user_title->getFullURL()}\">
								<img src=\"{$wgUploadPath}/avatars/{$avatarID}\" style=\"border:1px solid #d7dee8; width:50px; height:50px;\" alt=\"\" /></a>
							</div>

							<div id=\"submitted-by-user\" class=\"submitted-by-user\">
								<div id=\"submitted-by-user-text\">
									<a href=\"{$user_title->getFullURL()}\">{$user_name}</a>
								</div>
								<ul>
									<li id=\"userstats-votes\">
										<img src=\"{$wgScriptPath}/extensions/QuizGame/images/voteIcon.gif\" border=\"0\" alt=\"\" />
										{$stats_data['votes']}
									</li>
									<li id=\"userstats-edits\">
										<img src=\"{$wgScriptPath}/extensions/QuizGame/images/pencilIcon.gif\" border=\"0\" alt=\"\" />
										{$stats_data['edits']}
									</li>
									<li id=\"userstats-comments\">
										<img src=\"{$wgScriptPath}/extensions/QuizGame/images/commentsIcon.gif\" border=\"0\" alt=\"\" />
										{$stats_data['comments']}
									</li>
								</ul>
							</div>
							<div class=\"cleared\"></div>
						</div>

						<div class=\"ajax-messages\" id=\"ajax-messages\" style=\"margin:20px 0px 15px 0px;\"></div>

						<h1>" . wfMsg( 'quiz-question' ) . "</h1>
						<input name=\"quizgame-question\" id=\"quizgame-question\" type=\"text\" value=\"" .
							htmlspecialchars( $question['text'], ENT_QUOTES ) . "\" size=\"64\" />
						<h1>" . wfMsg( 'quiz-answers' ) . "</h1>
						<div style=\"margin:10px 0px;\">" . wfMsg( 'quiz-correct-answer-checked' ) . "</div>
						{$quizOptions}
						<h1>" . wfMsg( 'quiz-picture' ) . "</h1>
						<div class=\"quizgame-edit-picture\" id=\"quizgame-edit-picture\">
							{$pictag}
						</div>

						<input id=\"quizGamePicture\" name=\"quizGamePicture\" type=\"hidden\" value=\"{$question['image']}\" />

						<input id=\"quizGameId\" name=\"quizGameId\" type=\"hidden\" value=\"{$question['id']}\" />
						<input id=\"quizGameKey\" name=\"quizGameKey\" type=\"hidden\" value=\"{$key}\" />
						<input name=\"choices_count\" type=\"hidden\" value=\"{$choices_count}\" />
						<input id=\"old_correct\" name=\"old_correct\" type=\"hidden\" value=\"{$old_correct}\" />
					</form>
				</div>

				<div class=\"quizgame-copyright-warning\">" .
					wfMsgExt( $copywarnMsg, 'parse', $copywarnMsgParams ) .
				"</div>

				<div class=\"quizgame-edit-buttons\" id=\"quizgame-edit-buttons\">
					<input type=\"button\" class=\"site-button\" value=\"" . wfMsg( 'quiz-save-page-button' ) . "\" onclick=\"javascript:document.quizGameEditForm.submit()\"/>
					<input type=\"button\" class=\"site-button\" value=\"" . wfMsg( 'quiz-cancel-button' ) . "\" onclick=\"javascript:document.location='" .
						$this->getTitle()->escapeFullURL( 'questionGameAction=launchGame' ) . '\'" />
				</div>
			</div>';

		$wgOut->addHTML( $output );
	}

	/**
	 * Present a "log in" message
	 */
	function renderLoginPage() {
		global $wgOut;

		$wgOut->setPageTitle( wfMsg( 'quiz-login-title' ) );

		$output = wfMsg( 'quiz-login-text' ) . '<p>';
		$output .= '<div>
			<input type="button" class="site-button" value="' .
				wfMsg( 'quiz-main-page-button' ) . '" onclick="window.location=\'' .
				Title::newMainPage()->escapeFullURL() . '\'" />
			<input type="button" class="site-button" value="' .
			wfMsg( 'quiz-login-button' ) . '" onclick="window.location=\'' .
			SpecialPage::getTitleFor( 'Userlogin' )->escapeFullURL() . '\'" />
		</div>';
		$wgOut->addHTML( $output );
	}

	/**
	 * Present "No more quizzes" message to the user
	 */
	function renderQuizOver() {
		global $wgOut, $wgSupressPageTitle;

		$wgSupressPageTitle = false;

		$wgOut->setPageTitle( wfMsg( 'quiz-nomore-questions' ) );

		$output = wfMsgExt( 'quiz-ohnoes', 'parse' );
		$output .= '<div>
		<input type="button" class="site-button" value="' .
			wfMsg( 'quiz-create-button' ) . '" onclick="window.location=\'' .
			$this->getTitle()->escapeFullURL( 'questionGameAction=createForm' ) .
			'\'"/>

		</div>';
		$wgOut->addHTML( $output );
		return '';
	}

	/**
	 * Renders the "permalink is not available" error message.
	 */
	function renderPermalinkError() {
		global $wgOut, $wgSupressPageTitle;

		$wgSupressPageTitle = false;

		$wgOut->setPageTitle( wfMsg( 'quiz-title' ) );
		$wgOut->addWikiMsg( 'quiz-unavailable' );
	}

	function renderStart() {
		global $wgOut;

		$wgOut->setPageTitle( wfMsg( 'quiz-title' ) );
		$url = $this->getTitle()->escapeFullURL( 'questionGameAction=launchGame' );
		$output = wfMsg( 'quiz-intro' ) . '  <a href="' . $url . '">' .
			wfMsg( 'quiz-introlink' ) . '</a>';
		$wgOut->addHTML( $output );
	}

	/**
	 * Main function to render a quiz game.
	 * Also handles rendering a permalink.
	 */
	function launchGame() {
		global $wgRequest, $wgUser, $wgOut, $wgUploadPath, $wgScriptPath, $wgHooks;

		$on_load = 'QuizGame.showAnswers();';

		// controls the maximum length of the previous game bar graphs
		$dbr = wfGetDB( DB_MASTER );

		// previously this used to use addslashes + getVal and there was a var
		// called $isPermalink which was just an is_numeric() on this var
		// The if() loop around line 778 checked for $isPermalink instead of
		// $permalinkID...which caused a bug (wrong msg) to be displayed when
		// there were no questions *at all* in the DB (the permalink error msg
		// does not have a link that allows you to *create* a quiz...)
		$permalinkID = $wgRequest->getInt( 'permalinkID', 0 );

		$lastid = addslashes( $wgRequest->getVal( 'lastid' ) );
		$skipid = addslashes( $wgRequest->getVal( 'skipid' ) );

		$isFixedlink = false;
		$permalinkOptions = -1;
		$backButton = '';
		$editMenu = '';
		$editLinks = '';

		// Logged in user's stats
		$stats = new UserStats( $wgUser->getID(), $wgUser->getName() );
		$current_user_stats = $stats->getUserStats();
		if( !$current_user_stats['quiz_points'] ) {
			$current_user_stats['quiz_points'] = 0;
		}

		// Get users rank
		$quiz_rank = 0;
		$s = $dbr->selectRow(
			'user_stats',
			array( 'COUNT(*) AS count' ),
			array( 'stats_quiz_points > ' . str_replace( ',', '', $current_user_stats['quiz_points'] ) ),
			__METHOD__
		);
		if ( $s !== false ) {
			$quiz_rank = $s->count + 1;
		}

		// This is assuming that lastId and permalinkId
		// are mutually exclusive
		if( $permalinkID ) {
			$question = $this->getQuestion( $permalinkID );
			if( !$question ) {
				$this->renderPermalinkError();
				return '';
			}
		} else {
			$question = $this->getQuestion( $this->getNextQuestion(), $skipid );
			if( !$question ) {
				$this->renderQuizOver();
				return '';
			}
		}

		global $wgQuizID;
		$wgQuizID = $question['id'];

		$timestampedViewed = 0;
		if( $wgUser->getName() != $question['user_name'] ) {
			// check to see if the user already had viewed this question
			global $wgMemc;
			$key = wfMemcKey( 'quizgame-user-view', $wgUser->getID(), $question['id'] );
			$data = $wgMemc->get( $key );
			if( $data > 0 ) {
				$timestampedViewed = $data;
			} else {
				// mark that they viewed for first time
				$wgMemc->set( $key, time() );
			}
			$on_load .= "QuizGame.countDown({$timestampedViewed});";
		}

		if ( is_numeric( $lastid ) ) {
			$prev_question = $this->getQuestion( $lastid );
		}

		$wgOut->addScript( "<script type=\"text/javascript\">$( function() {" . $on_load . "} );</script>\n" );

		$gameid = $question['id'];
		$wgOut->setPageTitle( $question['text'] );
		if( strlen( $question['image'] ) > 0 ) {
			$image = wfFindFile( $question['image'] );
			$imageThumb = '';
			$imgWidth = 0;
			// If a file that is still being used on a quiz game is
			// independently deleted from the quiz game, poor users will
			// stumble upon nasty fatals without this check here.
			if ( is_object( $image ) ) {
				$imageThumb = $image->createThumb( 160 );
				$imageThumb .= '?' . time();
				if ( $image->getWidth() >= 160 ) {
					$imgWidth = 160;
				} else {
					$imgWidth = $image->getWidth();
				}
			}
			$imageTag = "
			<div id=\"quizgame-picture\" class=\"quizgame-picture\">
				<img src='" . $imageThumb . "' width='" . $imgWidth . "'></div>";
		} else {
			$imageTag = '';
		}

		$key = md5( $this->SALT . $gameid );

		$user_name = $question['user_name'];
		$user_title = Title::makeTitle( NS_USER, $user_name );
		$id = $question['user_id'];
		$avatar = new wAvatar( $id, 'l' );
		$avatarID = $avatar->getAvatarImage();
		$stats = new UserStats( $id, $user_name );
		$stats_data = $stats->getUserStats();

		$user_answer = $this->userAnswered( $wgUser->getName(), $gameid );

		global $wgUseEditButtonFloat;
		if ( ( $wgUser->getID() == $question['user_id'] ||
			( $user_answer && $wgUser->isLoggedIn() && $wgUser->isAllowed( 'quizadmin' ) )
			|| $wgUser->isAllowed( 'quizadmin' ) ) && ( $wgUseEditButtonFloat == true )
		) {
			$editMenu = "
				<div class=\"edit-menu-quiz-game\">
					<div class=\"edit-button-quiz-game\">
						<img src=\"{$wgScriptPath}/extensions/QuizGame/images/editIcon.gif\" alt=\"\" />
						<a href=\"javascript:QuizGame.showEditMenu()\">" . wfMsg( 'quiz-edit' ) . "</a>
					</div>
				</div>";

			$editLinks = '
				<a href="' . $this->getTitle()->escapeFullURL( 'questionGameAction=adminPanel' ) . '">' .
					wfMsg( 'quiz-admin-panel-title' ) . '</a> -
				<a href="javascript:QuizGame.protectImage()">' . wfMsg( 'quiz-protect' ) . '</a> -
				<a href="javascript:QuizGame.deleteQuestion()">' . wfMsg( 'quiz-delete' ) . '</a> -';
		}

		if( $wgUser->isLoggedIn() ) {
			$leaderboard_title = SpecialPage::getTitleFor( 'QuizLeaderboard' );
			$stats_box = '<div class="user-rank">
					<h2>' . wfMsg( 'quiz-leaderboard-scoretitle' ) . '</h2>

					<p><b>' . wfMsg( 'quiz-leaderboard-quizpoints' ) . "</b></p>
					<p class=\"user-rank-points\">{$current_user_stats['quiz_points']}</p>
					<div class=\"cleared\"></div>

					<p><b>" . wfMsg( 'quiz-leaderboard-correct' ) . "</b></p>
					<p>{$current_user_stats['quiz_correct']}</p>
					<div class=\"cleared\"></div>

					<p><b>" . wfMsg( 'quiz-leaderboard-answered' ) . "</b></p>
					<p>{$current_user_stats['quiz_answered']}</p>
					<div class=\"cleared\"></div>

					<p><b>" . wfMsg( 'quiz-leaderboard-pctcorrect' ) . "</b></p>
					<p>{$current_user_stats['quiz_correct_percent']}%</p>
					<div class=\"cleared\"></div>

					<p><b>" . wfMsg( 'quiz-leaderboard-rank' ) . "</b></p>
					<p>{$quiz_rank} <span class=\"user-rank-link\">
						<a href=\"{$leaderboard_title->getFullURL()}\">(" . wfMsg( 'quiz-leaderboard-link' ) . ")</a>
					</span></p>
					<div class=\"cleared\"></div>

				</div>";
		} else {
			$stats_box = '<div class="user-rank">
				<h2>' . wfMsg( 'quiz-leaderboard-scoretitle' ) . '</h2>'
					. wfMsgExt( 'quiz-login-or-create-to-climb', 'parse' ) .
			'</div>';
		}

		$answers = '';
		if( $user_answer ) {
			$answers .= "<div class=\"answer-percent-correct\">{$question['correct_percent']}" .
				wfMsg( 'quiz-pct-answered-correct' ) . '</div>';
			if( $user_answer == $question['correct_answer'] ) {
				$answers .= '<div class="answer-message-correct">' .
					wfMsg( 'quiz-answered-correctly' ) . '</div>';
			} else {
				if( $user_answer == -1 ) {
					$answers .= '<div class="answer-message-incorrect">' .
						wfMsg( 'quiz-skipped' ) . '</div>';
				} else {
					$answers .= '<div class="answer-message-incorrect">' .
						wfMsg( 'quiz-answered-incorrectly' ) . '</div>';
				}
			}
		}

		// User hasn't answered yet, so display the quiz options with the ability to play the question
		if( !$user_answer && $wgUser->getName() != $question['user_name'] ) {
			$answers .= '<ul>';
			$x = 1;
			foreach( $question['choices'] as $choice ) {
				$answers .= "<li id=\"{$x}\"><a href=\"javascript:QuizGame.vote({$choice['id']});\">{$choice['text']}</a></li>";
				$x++;
			}
			$answers .= '</ul>';
		} else {
			// User has answered, so display the right answer, and how many
			// people picked what
			$x = 1;
			foreach( $question['choices'] as $choice ) {
				$bar_width = floor( 220 * ( $choice['percent'] / 100 ) );
				if ( $choice['is_correct'] == 1 ) {
					$barColor = 'green';
				} else {
					$barColor = 'red';
				}
				$incorrectMsg = $correctMsg = '';
				if ( $user_answer == $choice['id'] && $question['correct_answer'] != $choice['id'] ) {
					$incorrectMsg = '- <span class="answer-message-incorrect">' .
						wfMsg( 'quiz-your-answer' ) . '</span>';
				}
				if ( $question['correct_answer'] == $choice['id'] ) {
					$correctMsg = '- <span class="answer-message-correct">' .
						wfMsg( 'quiz-correct-answer' ) . '</span>';
				}
				$answers .= "<div id=\"{$x}\" class=\"answer-choice\">{$choice['text']}" .
						$incorrectMsg . $correctMsg .
					'</div>';
				$answers .= "<div id=\"one-answer-bar\" style=\"margin-bottom:10px;\" class=\"answer-" . $barColor . "\">
						<img border=\"0\" style=\"width:{$bar_width}px; height: 9px;\" id=\"one-answer-width\" src=\"{$wgScriptPath}/extensions/QuizGame/images/vote-bar-" . $barColor . ".gif\"/>
						<span class=\"answer-percent\">{$choice['percent']}%</span>
					</div>";
				$x++;
			}
		}

		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$wgOut->addModules( 'ext.quizGame.lightBox' );
		} else {
			$wgOut->addScriptFile( $wgScriptPath . '/extensions/QuizGame/js/LightBox.js' );
		}
		$wgHooks['MakeGlobalVariablesScript'][] = 'QuizGameHome::addJSGlobals';

		$output = "
		<div id=\"quizgame-container\" class=\"quizgame-container\">
			{$editMenu}";

		$output .= "<div class=\"quizgame-left\">
				<div id=\"quizgame-title\" class=\"quizgame-title\">
					{$question['text']}
				</div>";

		if( !$user_answer && $wgUser->getName() != $question['user_name'] ) {
			global $wgUserStatsPointValues;
			$output .= '<div class="time-box">
					<div class="quiz-countdown">
						<span id="time-countdown">-</span> ' . wfMsg( 'quiz-js-seconds' ) .
					'</div>

					<div class="quiz-points" id="quiz-points">' .
						wfMsg( 'quiz-points', $wgUserStatsPointValues['quiz_points'] ) .
					'</div>
					<div class="quiz-notime" id="quiz-notime"></div>
					</div>';
		}

		$output .= '<div class="ajax-messages" id="ajax-messages"></div>';

		$output .= "

					{$imageTag}

					<div id=\"loading-answers\">" . wfMsg( 'quiz-js-loading' ) . "</div>
					<div id=\"quizgame-answers\" style=\"display:none;\" class=\"quizgame-answers\">
						{$answers}
					</div>

					<form name=\"quizGameForm\" id=\"quizGameForm\">
						<input id=\"quizGameId\" name=\"quizGameId\" type=\"hidden\" value=\"{$gameid}\" />
						<input id=\"quizGameKey\" name=\"quizGameKey\" type=\"hidden\" value=\"{$key}\" />
					</form>

					<div class=\"navigation-buttons\">
						{$backButton}";

		if( !$user_answer && $wgUser->getName() != $question['user_name'] ) {
			$output .= '<a href="javascript:void(0);" onclick="javascript:QuizGame.skipQuestion();">' .
				wfMsg( 'quiz-skip' ) . '</a>';
		} else {
			$output .= '<a href="' . $this->getTitle()->escapeFullURL( 'questionGameAction=launchGame' ) . '">' .
				wfMsg( 'quiz-next' ) . '</a>';
		}
		$output .= '</div>';

		if( !empty( $prev_question['id'] ) && !empty( $prev_question['user_answer'] ) ) {
			$output .= '<div id="answer-stats" class="answer-stats" style="display:block">

							<div class="last-game">

							<div class="last-question-heading">'
								. wfMsg( 'quiz-last-question' ) . ' - <a href="' .
								$this->getTitle()->escapeFullURL( "questionGameAction=renderPermalink&permalinkID={$prev_question['id']}" ) .
								"\">{$prev_question['text']}</a>
								<div class=\"last-question-count\">" .
									wfMsg( 'quiz-times-answered', $prev_question['answer_count'] ) .
								'</div>
							</div>';

			$your_answer_status = '';
			if( $prev_question['id'] && $prev_question['user_answer'] ) {
				// Get the choice text of what the user picked (and show how many points they got)
				foreach( $prev_question['choices'] as $choice ) {
					if( $choice['id'] == $prev_question['user_answer'] ) {
						$your_answer = $choice['text'];
						if( $choice['is_correct'] == 1 ) {
							$your_answer_status = '<div class="answer-status-correct">' .
								wfMsg( 'quiz-chose-correct', $prev_question['points'] ) .
							'</div>';
						} else {
							$your_answer_status = '<div class="answer-status-incorrect">' .
								wfMsg( 'quiz-chose-incorrect' ) .
							'</div>';
						}
					}
				}
			}

			$output .= "<div class=\"user-answer-status\">
							{$your_answer_status}
						</div>";

			foreach( $prev_question['choices'] as $choice ) {
				$bar_width = floor( 460 * ( $choice['percent'] / 100 ) );
				if ( $choice['is_correct'] == 1 ) {
					$answerClass = 'correct';
					$answerColor = 'green';
				} else {
					$answerClass = 'incorrect';
					$answerColor = 'red';
				}
				$output .= "<div class=\"answer-bar\" id=\"answer-bar-one\" style=\"display:block\">
						<div id=\"one-answer\" class=\"small-answer-" . $answerClass . "\">{$choice['text']}</div>
						<span id=\"one-answer-bar\" class=\"answer-" . $answerColor . "\">
							<img border=\"0\" style=\"width:{$bar_width}px; height: 11px;\" id=\"one-answer-width\" src=\"{$wgScriptPath}/extensions/QuizGame/images/vote-bar-" . $answerColor . ".gif\"/>
							<span id=\"one-answer-percent\" class=\"answer-percent\">{$choice['percent']}%</span>
						</span>
					</div>";
			}

			$output .= '</div>
							</div>';
		}

		$output .= "</div>

				<div class=\"quizgame-right\">

					<div class=\"create-link\">
						<img border=\"0\" src=\"{$wgScriptPath}/extensions/QuizGame/images/addIcon.gif\" alt=\"\" />
						<a href=\"" . $this->getTitle()->escapeFullURL( 'questionGameAction=createForm' ) . '">'
							. wfMsg( 'quiz-create-title' ) .
						"</a>
					</div>
					<div class=\"credit-box\" id=\"creditBox\">
						<h1>" . wfMsg( 'quiz-submitted-by' ) . "</h1>

						<div id=\"submitted-by-image\" class=\"submitted-by-image\">
							<a href=\"{$user_title->getFullURL()}\">
								<img src=\"{$wgUploadPath}/avatars/{$avatarID}\" style=\"border:1px solid #d7dee8; width:50px; height:50px;\" alt=\"\" />
							</a>
						</div>

						<div id=\"submitted-by-user\" class=\"submitted-by-user\">
							<div id=\"submitted-by-user-text\">
								<a href=\"" . Title::makeTitle( NS_USER, $user_name )->escapeFullURL() . "\">{$user_name}</a>
							</div>
							<ul>
								<li id=\"userstats-votes\">
									<img src=\"{$wgScriptPath}/extensions/QuizGame/images/voteIcon.gif\" border=\"0\" alt=\"\" />
									{$stats_data['votes']}
								</li>
								<li id=\"userstats-edits\">
									<img src=\"{$wgScriptPath}/extensions/QuizGame/images/pencilIcon.gif\" border=\"0\" alt=\"\" />
									{$stats_data['edits']}
								</li>
								<li id=\"userstats-comments\">
									<img src=\"{$wgScriptPath}/extensions/QuizGame/images/commentsIcon.gif\" border=\"0\" alt=\"\" />
									{$stats_data['comments']}
								</li>
							</ul>
						</div>
						<div class=\"cleared\"></div>
						{$stats_box}
					</div>
						<div class=\"bottom-links\" id=\"utility-buttons\">
							<a href=\"javascript:QuizGame.flagQuestion()\">" .
								wfMsg( 'quiz-flag' ) . '</a> - ';

		// Protect & delete links for quiz administrators
		if ( $wgUser->isAllowed( 'quizadmin' ) ) {
			$output .= '<a href="' . $this->getTitle()->escapeFullURL( 'questionGameAction=adminPanel' ) . '">'
					. wfMsg( 'quiz-admin-panel-title' ) .
				'</a> - <a href="javascript:QuizGame.protectImage()">' .
					wfMsg( 'quiz-protect' ) . '</a> -' .
				'<a href="javascript:QuizGame.deleteQuestion()">' .
					wfMsg( 'quiz-delete' ) . '</a> - ';
		}

		$output .= "<a href=\"javascript:document.location='" .
			$this->getTitle()->escapeFullURL( 'questionGameAction=renderPermalink' ) .
			"&permalinkID=' + document.getElementById( 'quizGameId' ).value\">" .
				wfMsg( 'quiz-permalink' ) . "</a>

							<div id=\"flag-comment\" style=\"display:none;margin-top:5px;\">" .
							wfMsg( 'quiz-flagged-reason' ) . ": <input type=\"text\" size=\"20\" id=\"flag-reason\" />
							<input type=\"button\" onclick=\"QuizGame.doFlagQuestion()\" value=\"" . wfMsg( 'quiz-submit' ) . "\" /></div>
						</div>
				</div>
			</div>

			<div class=\"cleared\"/>
			<div class=\"hiddendiv\" style=\"display:none\">
				<img src=\"{$wgScriptPath}/extensions/QuizGame/images/overlay.png\" alt=\"\" />
			</div>
		</div>";

		$wgOut->addHTML( $output );
	}

	// Function that inserts questions into the database
	function createQuizGame() {
		global $wgRequest, $wgUser, $wgMemc, $wgQuizLogs;

		$key = $wgRequest->getText( 'key' );
		$chain = $wgRequest->getText( 'chain' );

		$max_answers = 8;

		if( $key != md5( $this->SALT . $chain ) ) {
			header( 'Location: ' . $this->getTitle()->getFullURL() );
			return;
		}

		$question = $wgRequest->getText( 'quizgame-question' );
		$imageName = $wgRequest->getText( 'quizGamePictureName' );

		// Add quiz question
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'quizgame_questions',
			array(
				'q_user_id' => $wgUser->getID(),
				'q_user_name' => $wgUser->getName(),
				'q_text' => strip_tags( $question ), // make sure nobody inserts malicious code
				'q_picture' => $imageName,
				'q_date' => date( 'Y-m-d H:i:s' ),
				'q_random' => wfRandom()
			),
			__METHOD__
		);
		$questionId = $dbw->insertId();

		// Add Quiz Choices
		for( $x = 1; $x <= $max_answers; $x++ ) {
			if( $wgRequest->getVal( "quizgame-answer-{$x}" ) ) {
				if( $wgRequest->getVal( "quizgame-isright-{$x}" ) == 'on' ) {
					$is_correct = 1;
				} else {
					$is_correct = 0;
				}
				$dbw->insert(
					'quizgame_choice',
					array(
						'choice_q_id' => $questionId,
						'choice_text' => strip_tags( $wgRequest->getVal( "quizgame-answer-{$x}" ) ), // make sure nobody inserts malicious code
						'choice_order' => $x,
						'choice_is_correct' => $is_correct
					),
					__METHOD__
				);
				$dbw->commit();
			}
		}
		$stats = new UserStatsTrack( $wgUser->getID(), $wgUser->getName() );
		$stats->incStatField( 'quiz_created' );

		// Add a log entry if quiz logging is enabled
		if( $wgQuizLogs ) {
			$message = wfMsgForContent(
				'quiz-questions-log-create-text',
				"Special:QuizGameHome/{$questionId}"
			);
			$log = new LogPage( 'quiz' );
			$log->addEntry( 'create', $wgUser->getUserPage(), $message );
		}

		// Delete memcached key
		$key = wfMemcKey( 'user', 'profile', 'quiz', $wgUser->getID() );
		$wgMemc->delete( $key );

		// Redirect the user
		header( 'Location: ' . $this->getTitle()->getFullURL( "questionGameAction=renderPermalink&permalinkID={$questionId}" ) );
	}

	function renderWelcomePage() {
		global $wgRequest, $wgUser, $wgOut, $wgHooks;

		// No access for blocked users
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage( false );
			return false;
		}

		/**
		 * Create Quiz Thresholds based on User Stats
		 */
		global $wgCreateQuizThresholds;
		if( is_array( $wgCreateQuizThresholds ) && count( $wgCreateQuizThresholds ) > 0 ) {
			$can_create = true;

			$stats = new UserStats( $wgUser->getID(), $wgUser->getName() );
			$stats_data = $stats->getUserStats();

			$threshold_reason = '';
			foreach( $wgCreateQuizThresholds as $field => $threshold ) {
				if ( $stats_data[$field] < $threshold ) {
					$can_create = false;
					$threshold_reason .= ( ( $threshold_reason ) ? ', ' : '' ) . "$threshold $field";
				}
			}

			if( $can_create == false ) {
				global $wgSupressPageTitle;
				$wgSupressPageTitle = false;
				$wgOut->setPageTitle( wfMsg( 'quiz-create-threshold-title' ) );
				$wgOut->addHTML( wfMsg( 'quiz-create-threshold-reason', $threshold_reason ) );
				return '';
			}
		}

		$chain = time();
		$key = md5( $this->SALT . $chain );
		$max_answers = 8;

		// Add i18n messages (and max_answers) for the JS file
		$wgHooks['MakeGlobalVariablesScript'][] = 'QuizGameHome::addJSGlobalsForRenderWelcomePage';

		$wgOut->setPageTitle( wfMsg( 'quiz-create-title' ) );

		$output = '<div id="quiz-container" class="quiz-container">

			<div class="create-message">
				<h1>' . wfMsg( 'quiz-create-title' ) . '</h1>
				<p>' . wfMsgExt( 'quiz-create-message', 'parse' ) . '</p>
				<p><input class="site-button" type="button" onclick="document.location=\'' .
					$this->getTitle()->escapeFullURL( 'questionGameAction=launchGame' ) .
					'\'" value="' . wfMsg( 'quiz-play-quiz' ) . '" /></p>
			</div>

			<div class="quizgame-create-form" id="quizgame-create-form">
				<form id="quizGameCreate" name="quizGameCreate" method="post" action="' .
					$this->getTitle()->escapeFullURL( 'questionGameAction=createGame' ) . '">
				<div id="quiz-game-errors" style="color:red"></div>

				<h1>' . wfMsg( 'quiz-create-write-question' ) . '</h1>
				<input name="quizgame-question" id="quizgame-question" type="text" value="" size="64" />
				<h1 class="write-answer">' . wfMsg( 'quiz-create-write-answers' ) . '</h1>
				<span style="margin-top:10px;">' . wfMsg( 'quiz-create-check-correct' ) . '</span>';

		for( $x = 1; $x <= $max_answers; $x++ ) {
			$output .= "<div id=\"quizgame-answer-container-{$x}\" class=\"quizgame-answer\"" .
				( ( $x > 2 ) ? ' style="display:none;"' : '' ) . ">
				<span class=\"quizgame-answer-number\">{$x}.</span>
				<input name=\"quizgame-answer-{$x}\" id=\"quizgame-answer-{$x}\" type=\"text\" value=\"\" size=\"32\" onkeyup=\"QuizGame.updateAnswerBoxes();\" />
				<input type=\"checkbox\" onclick=\"javascript:QuizGame.welcomePage_toggleCheck(this)\" id=\"quizgame-isright-{$x}\" name=\"quizgame-isright-{$x}\">
			</div>";
		}

		$output .= '<input id="quizGamePictureName" name="quizGamePictureName" type="hidden" value="" />
				<input id="key" name="key" type="hidden" value="' . $key . '" />
				<input id="chain" name="chain" type="hidden" value="' . $chain . '" />

			</form>

			<h1 style="margin-top:20px">' .
				wfMsg( 'quiz-create-add-picture' ) . '</h1>
			<div id="quizgame-picture-upload" style="display:block;">

				<div id="real-form" style="display:block; height:90px;">
					<iframe id="imageUpload-frame" class="imageUpload-frame" width="650"
						scrolling="no" border="0" frameborder="0" src="' .
						SpecialPage::getTitleFor( 'QuestionGameUpload' )->escapeFullURL( 'wpThumbWidth=75&wpCategory=Quizgames' ) . '">
					</iframe>
				</div>
			</div>
			<div id="quizgame-picture-preview" class="quizgame-picture-preview"></div>
			<p id="quizgame-picture-reupload" style="display:none">
				<a href="javascript:QuizGame.showAttachPicture()">' .
					wfMsg( 'quiz-create-edit-picture' ) . '</a>
			</p>
			</div>

			<div id="startButton" class="startButton">
				<input type="button" class="site-button" onclick="QuizGame.startGame()" value="' . wfMsg( 'quiz-create-play' ) . '" />
			</div>

			</div>';

		$wgOut->addHTML( $output );
	}

	/**
	 * Add some new JS globals into the page output. Most of this can be
	 * replaced by ResourceLoader in the future.
	 *
	 * @see QuizGameHome::renderWelcomePage()
	 *
	 * @param $vars Array: array of pre-existing JS globals
	 * @return Boolean: true
	 */
	public static function addJSGlobalsForRenderWelcomePage( &$vars ) {
		$vars['__quiz_max_answers__'] = 8; // there's no way to retrieve this so we just hardcode it here
		$vars['__quiz_create_error_numanswers__'] = wfMsg( 'quiz-create-error-numanswers' );
		$vars['__quiz_create_error_noquestion__'] = wfMsg( 'quiz-create-error-noquestion' );
		$vars['__quiz_create_error_numcorrect__'] = wfMsg( 'quiz-create-error-numcorrect' );
		return true;
	}

	/**
	 * Add some new JS globals into the page output. This can be replaced by
	 * ResourceLoader in the future.
	 *
	 * @see QuizGameHome::launchGame()
	 *
	 * @param $vars Array: array of pre-existing JS globals
	 * @return Boolean: true
	 */
	public static function addJSGlobals( &$vars ) {
		$vars['__quiz_js_reloading__'] = wfMsg( 'quiz-js-reloading' );
		$vars['__quiz_js_errorwas__'] = wfMsg( 'quiz-js-errorwas' );
		$vars['__quiz_js_timesup__'] = wfMsg( 'quiz-js-timesup' );
		$vars['__quiz_js_points__'] = wfMsg( 'quiz-js-points' );
		$vars['__quiz_pause_continue__'] = wfMsg( 'quiz-pause-continue' );
		$vars['__quiz_pause_view_leaderboard__'] = wfMsg( 'quiz-pause-view-leaderboard' );
		$vars['__quiz_pause_create_question__'] = wfMsg( 'quiz-pause-create-question' );
		$vars['__quiz_main_page_button__'] = wfMsg( 'quiz-main-page-button' );
		$vars['__quiz_js_loading__'] = wfMsg( 'quiz-js-loading' );
		$vars['__quiz_lightbox_pause_quiz__'] = wfMsg( 'quiz-lightbox-pause-quiz' );
		$vars['__quiz_lightbox_breakdown__'] = wfMsg( 'quiz-lightbox-breakdown' );
		$vars['__quiz_lightbox_breakdown_percent__'] = wfMsg( 'quiz-lightbox-breakdown-percent' );
		$vars['__quiz_lightbox_correct__'] = wfMsg( 'quiz-lightbox-correct' );
		$vars['__quiz_lightbox_incorrect__'] = wfMsg( 'quiz-lightbox-incorrect' );
		$vars['__quiz_lightbox_correct_points__'] = wfMsg( 'quiz-lightbox-correct-points' );
		$vars['__quiz_lightbox_incorrect_correct__'] = wfMsg( 'quiz-lightbox-incorrect-correct' );
		return true;
	}
}

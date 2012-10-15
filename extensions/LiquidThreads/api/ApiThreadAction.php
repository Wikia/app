<?php

class ApiThreadAction extends ApiEditPage {

	public function execute() {
		$params = $this->extractRequestParams();

		if ( isset( $params['gettoken'] ) ) {
			global $wgUser;
			$result = array( 'token' => $wgUser->editToken() );
			$this->getResult()->addValue( null, 'threadaction', $result );
			return;
		}

		if ( !count( $params['threadaction'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'action' ) );
		}

		$allowedAllActions = array( 'markread' );
		$action = $params['threadaction'];

		// Pull the threads from the parameters
		$threads = array();
		if ( !empty( $params['thread'] ) ) {
			foreach ( $params['thread'] as $thread ) {
				$threadObj = null;
				if ( is_numeric( $thread ) ) {
					$threadObj = Threads::withId( $thread );
				} elseif ( $thread == 'all' &&
						in_array( $action, $allowedAllActions ) ) {
					$threads = array( 'all' );
				} else {
					$title = Title::newFromText( $thread );
					$article = new Article( $title, 0 );
					$threadObj = Threads::withRoot( $article );
				}

				if ( $threadObj instanceof Thread ) {
					$threads[] = $threadObj;
				}
			}
		}

		// Find the appropriate module
		$actions = $this->getActions();

		$method = $actions[$action];

		call_user_func_array( array( $this, $method ), array( $threads, $params ) );
	}

	public function actionMarkRead( $threads, $params ) {
		global $wgUser;

		$result = array();

		if ( in_array( 'all', $threads ) ) {
			NewMessages::markAllReadByUser( $wgUser );
			$result[] = array(
				'result' => 'Success',
				'action' => 'markread',
				'threads' => 'all',
			);
		} else {
			foreach ( $threads as $t ) {
				NewMessages::markThreadAsReadByUser( $t, $wgUser );
				$result[] = array(
					'result' => 'Success',
					'action' => 'markread',
					'id' => $t->id(),
					'title' => $t->title()->getPrefixedText()
				);
			}
		}

		$this->getResult()->setIndexedTagName( $result, 'thread' );
		$this->getResult()->addValue( null, 'threadactions', $result );
	}

	public function actionMarkUnread( $threads, $params ) {
		global $wgUser;

		$result = array();

		foreach ( $threads as $t ) {
			NewMessages::markThreadAsUnreadByUser( $t, $wgUser );

			$result[] = array(
				'result' => 'Success',
				'action' => 'markunread',
				'id' => $t->id(),
				'title' => $t->title()->getPrefixedText()
			);
		}


		$this->getResult()->setIndexedTagName( $result, 'thread' );
		$this->getResult()->addValue( null, 'threadaction', $result );
	}

	public function actionSplit( $threads, $params ) {
		if ( count( $threads ) > 1 ) {
			$this->dieUsage( 'You may only split one thread at a time',
					'too-many-threads' );
		} elseif ( count( $threads ) < 1 ) {
			$this->dieUsage( 'You must specify a thread to split',
					'no-specified-threads' );
		}

		$thread = array_pop( $threads );

		global $wgUser;
		$errors = $thread->title()->getUserPermissionsErrors( 'lqt-split', $wgUser );
		if ( $errors ) {
			// We don't care about multiple errors, just report one of them
			$this->dieUsageMsg( reset( $errors ) );
		}

		if ( $thread->isTopmostThread() ) {
			$this->dieUsage( 'This thread is already a top-level thread.',
				'already-top-level' );
		}

		$title = null;
		$article = $thread->article();
		if ( empty( $params['subject'] ) ||
			! Thread::validateSubject( $params['subject'], $title, null, $article ) ) {

			$this->dieUsage( 'No subject, or an invalid subject, was specified',
				'no-valid-subject' );
		}

		$subject = $params['subject'];

		// Pull a reason, if applicable.
		$reason = '';
		if ( !empty( $params['reason'] ) ) {
			$reason = $params['reason'];
		}

		// Check if they specified a sortkey
		$sortkey = null;
		if ( !empty( $params['sortkey'] ) ) {
			$ts = $params['sortkey'];
			$ts = wfTimestamp( TS_MW, $ts );

			$sortkey = $ts;
		}

		// Do the split
		$thread->split( $subject, $reason, $sortkey );

		$result = array();
		$result[] = array(
			'result' => 'Success',
			'action' => 'split',
			'id' => $thread->id(),
			'title' => $thread->title()->getPrefixedText(),
			'newsubject' => $subject,
		);

		$this->getResult()->setIndexedTagName( $result, 'thread' );
		$this->getResult()->addValue( null, 'threadaction', $result );
	}

	public function actionMerge( $threads, $params ) {
		if ( count( $threads ) < 1 ) {
			$this->dieUsage( 'You must specify a thread to merge',
				'no-specified-threads' );
		}

		if ( empty( $params['newparent'] ) ) {
			$this->dieUsage( 'You must specify a new parent thread to merge beneath',
				'no-parent-thread' );
		}

		$newParent = $params['newparent'];
		if ( is_numeric( $newParent ) ) {
			$newParent = Threads::withId( $newParent );
		} else {
			$title = Title::newFromText( $newParent );
			$article = new Article( $title, 0 );
			$newParent = Threads::withRoot( $article );
		}

		global $wgUser;
		$errors = $newParent->title()->getUserPermissionsErrors( 'lqt-merge', $wgUser );
		if ( $errors ) {
			// We don't care about multiple errors, just report one of them
			$this->dieUsageMsg( reset( $errors ) );
		}

		if ( !$newParent ) {
			$this->dieUsage( 'The parent thread you specified was neither the title ' .
					'of a thread, nor a thread ID.', 'invalid-parent-thread' );
		}

		// Pull a reason, if applicable.
		$reason = '';
		if ( !empty( $params['reason'] ) ) {
			$reason = $params['reason'];
		}

		$result = array();

		foreach ( $threads as $thread ) {
			$thread->moveToParent( $newParent, $reason );
			$result[] = array(
				'result' => 'Success',
				'action' => 'merge',
				'id' => $thread->id(),
				'title' => $thread->title()->getPrefixedText(),
				'new-parent-id' => $newParent->id(),
				'new-parent-title' => $newParent->title()->getPrefixedText(),
				'new-ancestor-id' => $newParent->topmostThread()->id(),
				'new-ancestor-title' => $newParent->topmostThread()->title()->getPrefixedText(),
			);
		}

		$this->getResult()->setIndexedTagName( $result, 'thread' );
		$this->getResult()->addValue( null, 'threadaction', $result );
	}

	public function actionNewThread( $threads, $params ) {
		global $wgUser;

		// Validate talkpage parameters
		if ( !count( $params['talkpage'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'talkpage' ) );
		}

		$talkpageTitle = Title::newFromText( $params['talkpage'] );

		if ( !$talkpageTitle || !LqtDispatch::isLqtPage( $talkpageTitle ) ) {
			$this->dieUsage( 'The talkpage you specified is invalid, or does not ' .
				'have discussion threading enabled.', 'invalid-talkpage' );
		}
		$talkpage = new Article( $talkpageTitle, 0 );

		// Check if we can post.
		if ( Thread::canUserPost( $wgUser, $talkpage ) !== true ) {
			$this->dieUsage( 'You cannot post to the specified talkpage, ' .
				'because it is protected from new posts', 'talkpage-protected' );
		}

		// Validate subject, generate a title
		if ( empty( $params['subject'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'subject' ) );
		}

		$bump = isset( $params['bump'] ) ? $params['bump'] : null;

		$subject = $params['subject'];
		$title = null;
		$subjectOk = Thread::validateSubject( $subject, $title, null, $talkpage );

		if ( !$subjectOk ) {
			$this->dieUsage( 'The subject you specified is not valid',
				'invalid-subject' );
		}
		$article = new Article( $title, 0 );

		// Check for text
		if ( empty( $params['text'] ) ) {
			$this->dieUsage( 'You must include text in your post', 'no-text' );
		}
		$text = $params['text'];

		// Generate or pull summary
		$summary = wfMsgForContent( 'lqt-newpost-summary', $subject );
		if ( !empty( $params['reason'] ) ) {
			$summary = $params['reason'];
		}

		$signature = null;
		if ( isset( $params['signature'] ) ) {
			$signature = $params['signature'];
		}

		// Inform hooks what we're doing
		LqtHooks::$editTalkpage = $talkpage;
		LqtHooks::$editArticle = $article;
		LqtHooks::$editThread = null;
		LqtHooks::$editType = 'new';
		LqtHooks::$editAppliesTo = null;

		$token = $params['token'];

		// All seems in order. Construct an API edit request
		$requestData = array(
			'action' => 'edit',
			'title' => $title->getPrefixedText(),
			'text' => $text,
			'summary' => $summary,
			'token' => $token,
			'basetimestamp' => wfTimestampNow(),
			'minor' => 0,
			'format' => 'json',
		);

		if ( $wgUser->isAllowed('bot') ) {
			$requestData['bot'] = true;
		}

		$editReq = new FauxRequest( $requestData, true );
		LqtView::fixFauxRequestSession( $editReq );
		$internalApi = new ApiMain( $editReq, true );
		$internalApi->execute();

		$editResult = $internalApi->getResultData();

		if ( $editResult['edit']['result'] != 'Success' ) {
			$result = array( 'result' => 'EditFailure', 'details' => $editResult );
			$this->getResult()->addValue( null, $this->getModuleName(), $result );
			return;
		}

		$articleId = $editResult['edit']['pageid'];

		$article->getTitle()->resetArticleID( $articleId );
		$title->resetArticleID( $articleId );

		$thread = LqtView::newPostMetadataUpdates(
			array(
				'root' => $article,
				'talkpage' => $talkpage,
				'subject' => $subject,
				'signature' => $signature,
				'summary' => $summary,
				'text' => $text,
			) );

		$result = array(
			'result' => 'Success',
			'thread-id' => $thread->id(),
			'thread-title' => $title->getPrefixedText(),
			'modified' => $thread->modified(),
		);

		if ( !empty( $params['render'] ) ) {
			$result['html'] = self::renderThreadPostAction( $thread );
		}

		$result = array( 'thread' => $result );

		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	public function actionEdit( $threads, $params ) {
		if ( count( $threads ) > 1 ) {
			$this->dieUsage( 'You may only edit one thread at a time',
					'too-many-threads' );
		} elseif ( count( $threads ) < 1 ) {
			$this->dieUsage( 'You must specify a thread to edit',
					'no-specified-threads' );
		}

		$thread = array_pop( $threads );
		$talkpage = $thread->article();

		$bump = isset( $params['bump'] ) ? $params['bump'] : null;

		// Validate subject
		$subjectOk = true;
		if ( !empty( $params['subject'] ) ) {
			$subject = $params['subject'];
			$title = null;
			$subjectOk = empty( $subject ) ||
				Thread::validateSubject( $subject, $title, null, $talkpage );
		} else {
			$subject = $thread->subject();
		}

		if ( !$subjectOk ) {
			$this->dieUsage( 'The subject you specified is not valid',
				'invalid-subject' );
		}

		// Check for text
		if ( empty( $params['text'] ) ) {
			$this->dieUsage( 'You must include text in your post', 'no-text' );
		}
		$text = $params['text'];

		$summary = '';
		if ( !empty( $params['reason'] ) ) {
			$summary = $params['reason'];
		}

		$article = $thread->root();
		$title = $article->getTitle();

		$signature = null;
		if ( isset( $params['signature'] ) ) {
			$signature = $params['signature'];
		}

		// Inform hooks what we're doing
		LqtHooks::$editTalkpage = $talkpage;
		LqtHooks::$editArticle = $article;
		LqtHooks::$editThread = $thread;
		LqtHooks::$editType = 'edit';
		LqtHooks::$editAppliesTo = null;

		$token = $params['token'];

		// All seems in order. Construct an API edit request
		$requestData = array(
			'action' => 'edit',
			'title' => $title->getPrefixedText(),
			'text' => $text,
			'summary' => $summary,
			'token' => $token,
			'minor' => 0,
			'basetimestamp' => wfTimestampNow(),
			'format' => 'json',
		);

		global $wgUser;

		if ( $wgUser->isAllowed('bot') ) {
			$requestData['bot'] = true;
		}

		$editReq = new FauxRequest( $requestData, true );
		LqtView::fixFauxRequestSession( $editReq );
		$internalApi = new ApiMain( $editReq, true );
		$internalApi->execute();

		$editResult = $internalApi->getResultData();

		if ( $editResult['edit']['result'] != 'Success' ) {
			$result = array( 'result' => 'EditFailure', 'details' => $editResult );
			$this->getResult()->addValue( null, $this->getModuleName(), $result );
			return;
		}

		$thread = LqtView::editMetadataUpdates(
			array(
				'root' => $article,
				'thread' => $thread,
				'subject' => $subject,
				'signature' => $signature,
				'summary' => $summary,
				'text' => $text,
				'bump' => $bump,
			) );

		$result = array(
			'result' => 'Success',
			'thread-id' => $thread->id(),
			'thread-title' => $title->getPrefixedText(),
			'modified' => $thread->modified(),
		);

		if ( !empty( $params['render'] ) ) {
			$result['html'] = self::renderThreadPostAction( $thread );
		}

		$result = array( 'thread' => $result );

		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	public function actionReply( $threads, $params ) {
		global $wgUser;

		// Validate thread parameter
		if ( count( $threads ) > 1 ) {
			$this->dieUsage( 'You may only reply to one thread at a time',
					'too-many-threads' );
		} elseif ( count( $threads ) < 1 ) {
			$this->dieUsage( 'You must specify a thread to reply to',
					'no-specified-threads' );
		}
		$replyTo = array_pop( $threads );

		// Check if we can reply to that thread.
		$perm_result = $replyTo->canUserReply( $wgUser );
		if ( $perm_result !== true ) {
			$this->dieUsage( "You cannot reply to this thread, because the " .
				$perm_result . " is protected from replies.",
				$perm_result . '-protected' );
		}

		// Validate text parameter
		if ( empty( $params['text'] ) ) {
			$this->dieUsage( 'You must include text in your post', 'no-text' );
		}

		$text = $params['text'];

		$bump = isset( $params['bump'] ) ? $params['bump'] : null;

		// Generate/pull summary
		$summary = wfMsgForContent( 'lqt-reply-summary', $replyTo->subject(),
				$replyTo->title()->getPrefixedText() );

		if ( !empty( $params['reason'] ) ) {
			$summary = $params['reason'];
		}

		$signature = null;
		if ( isset( $params['signature'] ) ) {
			$signature = $params['signature'];
		}

		// Grab data from parent
		$talkpage = $replyTo->article();
		$subject = $replyTo->subject();

		// Generate a reply title.
		$title = Threads::newReplyTitle( $replyTo, $wgUser );
		$article = new Article( $title, 0 );

		// Inform hooks what we're doing
		LqtHooks::$editTalkpage = $talkpage;
		LqtHooks::$editArticle = $article;
		LqtHooks::$editThread = null;
		LqtHooks::$editType = 'reply';
		LqtHooks::$editAppliesTo = $replyTo;

		// Pull token in
		$token = $params['token'];

		// All seems in order. Construct an API edit request
		$requestData = array(
			'action' => 'edit',
			'title' => $title->getPrefixedText(),
			'text' => $text,
			'summary' => $summary,
			'token' => $token,
			'basetimestamp' => wfTimestampNow(),
			'minor' => 0,
			'format' => 'json',
		);

		if ( $wgUser->isAllowed('bot') ) {
			$requestData['bot'] = true;
		}

		$editReq = new FauxRequest( $requestData, true );
		LqtView::fixFauxRequestSession( $editReq );
		$internalApi = new ApiMain( $editReq, true );
		$internalApi->execute();

		$editResult = $internalApi->getResultData();

		if ( $editResult['edit']['result'] != 'Success' ) {
			$result = array( 'result' => 'EditFailure', 'details' => $editResult );
			$this->getResult()->addValue( null, $this->getModuleName(), $result );
			return;
		}

		$articleId = $editResult['edit']['pageid'];
		$article->getTitle()->resetArticleID( $articleId );
		$title->resetArticleID( $articleId );

		$thread = LqtView::replyMetadataUpdates(
			array(
				'root' => $article,
				'replyTo' => $replyTo,
				'signature' => $signature,
				'summary' => $summary,
				'text' => $text,
				'bump' => $bump,
			) );

		$result = array(
			'action' => 'reply',
			'result' => 'Success',
			'thread-id' => $thread->id(),
			'thread-title' => $title->getPrefixedText(),
			'parent-id' => $replyTo->id(),
			'parent-title' => $replyTo->title()->getPrefixedText(),
			'ancestor-id' => $replyTo->topmostThread()->id(),
			'ancestor-title' => $replyTo->topmostThread()->title()->getPrefixedText(),
			'modified' => $thread->modified(),
		);

		if ( !empty( $params['render'] ) ) {
			$result['html'] = self::renderThreadPostAction( $thread );
		}

		$result = array( 'thread' => $result );

		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	static function renderThreadPostAction( $thread ) {
		$thread = $thread->topmostThread();

		// Set up OutputPage
		global $wgOut, $wgUser, $wgRequest;
		$oldOutputText = $wgOut->getHTML();
		$wgOut->clearHTML();

		// Setup
		$article = $thread->root();
		$title = $article->getTitle();
		$view = new LqtView( $wgOut, $article, $title, $wgUser, $wgRequest );

		$view->showThread( $thread );

		$result = $wgOut->getHTML();
		$wgOut->clearHTML();
		$wgOut->addHTML( $oldOutputText );

		return $result;
	}

	public function actionSetSubject( $threads, $params ) {
		// Validate thread parameter
		if ( count( $threads ) > 1 ) {
			$this->dieUsage( 'You may only change the subject of one thread at a time',
					'too-many-threads' );
		} elseif ( count( $threads ) < 1 ) {
			$this->dieUsage( 'You must specify a thread to change the subject of',
					'no-specified-threads' );
		}
		$thread = array_pop( $threads );

		global $wgUser;
		$errors = $thread->title()->getUserPermissionsErrors( 'edit', $wgUser );
		if ( $errors ) {
			// We don't care about multiple errors, just report one of them
			$this->dieUsageMsg( reset( $errors ) );
		}

		// Validate subject
		if ( empty( $params['subject'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'subject' ) );
		}

		$talkpage = $thread->article();

		$subject = $params['subject'];
		$title = null;
		$subjectOk = Thread::validateSubject( $subject, $title, null, $talkpage );

		if ( !$subjectOk ) {
			$this->dieUsage( 'The subject you specified is not valid',
				'invalid-subject' );
		}

		$reason = null;

		if ( isset( $params['reason'] ) ) {
			$reason = $params['reason'];
		}

		$thread->setSubject( $subject );
		$thread->commitRevision( Threads::CHANGE_EDITED_SUBJECT, $thread, $reason );

		$result = array(
			'action' => 'setsubject',
			'result' => 'success',
			'thread-id' => $thread->id(),
			'thread-title' => $thread->title()->getPrefixedText(),
			'new-subject' => $subject,
		);

		$result = array( 'thread' => $result );

		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	public function actionSetSortkey( $threads, $params ) {
		// First check for threads
		if ( !count( $threads ) ) {
			$this->dieUsage( 'You must specify a thread to set the sortkey of',
					'no-specified-threads' );
		}

		// Validate timestamp
		if ( empty( $params['sortkey'] ) ) {
			$this->dieUsage( 'You must specify a valid timestamp for the sortkey ' .
				'parameter. It should be in the form YYYYMMddhhmmss, a ' .
				'unix timestamp or "now".', 'invalid-sortkey' );
		}

		$ts = $params['sortkey'];

		if ( $ts == 'now' ) $ts = wfTimestampNow();

		$ts = wfTimestamp( TS_MW, $ts );

		if ( !$ts ) {
			$this->dieUsage( 'You must specify a valid timestamp for the sortkey' .
				'parameter. It should be in the form YYYYMMddhhmmss, a ' .
				'unix timestamp or "now".', 'invalid-sortkey' );
		}

		$reason = null;

		if ( isset( $params['reason'] ) ) {
			$reason = $params['reason'];
		}

		$thread = array_pop( $threads );

		global $wgUser;
		$errors = $thread->title()->getUserPermissionsErrors( 'edit', $wgUser );
		if ( $errors ) {
			// We don't care about multiple errors, just report one of them
			$this->dieUsageMsg( reset( $errors ) );
		}

		$thread->setSortkey( $ts );
		$thread->commitRevision( Threads::CHANGE_ADJUSTED_SORTKEY, null, $reason );

		$result = array(
			'action' => 'setsortkey',
			'result' => 'success',
			'thread-id' => $thread->id(),
			'thread-title' => $thread->title()->getPrefixedText(),
			'new-sortkey' => $ts,
		);

		$result = array( 'thread' => $result );

		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	public function actionAddReaction( $threads, $params ) {
		global $wgUser;

		if ( !count( $threads ) ) {
			$this->dieUsage( 'You must specify a thread to add a reaction for',
					'no-specified-threads' );
		}

		if ( ! $wgUser->isAllowed( 'lqt-react' ) ) {
			$this->dieUsage( 'You are not allowed to react to threads.', 'permission-denied' );
		}

		$required = array( 'type', 'value' );

		if ( count( array_diff( $required, array_keys($params) ) ) ) {
			$this->dieUsage( 'You must specify both a type and a value for the reaction',
						'missing-parameter' );
		}

		$result = array();

		foreach( $threads as $thread ) {
			$thread->addReaction( $wgUser, $params['type'], $params['value'] );

			$result[] = array(
				'result' => 'Success',
				'action' => 'addreaction',
				'id' => $thread->id(),
			);
		}

		$this->getResult()->setIndexedTagName( $result, 'thread' );
		$this->getResult()->addValue( null, 'threadaction', $result );
	}

	public function actionDeleteReaction( $threads, $params ) {
		global $wgUser;

		if ( !count( $threads ) ) {
			$this->dieUsage( 'You must specify a thread to delete a reaction for',
					'no-specified-threads' );
		}

		if ( ! $wgUser->isAllowed( 'lqt-react' ) ) {
			$this->dieUsage( 'You are not allowed to react to threads.', 'permission-denied' );
		}

		$required = array( 'type', 'value' );

		if ( count( array_diff( $required, array_keys($params) ) ) ) {
			$this->dieUsage( 'You must specify both a type for the reaction',
						'missing-parameter' );
		}

		$result = array();

		foreach( $threads as $thread ) {
			$thread->deleteReaction( $wgUser, $params['type'] );

			$result[] = array(
				'result' => 'Success',
				'action' => 'deletereaction',
				'id' => $thread->id(),
			);
		}

		$this->getResult()->setIndexedTagName( $result, 'thread' );
		$this->getResult()->addValue( null, 'threadaction', $result );
	}

	public function actionInlineEditForm( $threads, $params ) {
		$method = $talkpage = $operand = null;

		if ( isset($params['method']) ) {
			$method = $params['method'];
		}

		if ( isset( $params['talkpage'] ) ) {
			$talkpage = $params['talkpage'];
		}

		if ( $talkpage ) {
			$talkpage = new Article( Title::newFromText( $talkpage ), 0 );
		} else {
			$talkpage = null;
		}

		if ( count($threads) ) {
			$operand = $threads[0];
			$operand = $operand->id();
		}

		$output = LqtView::getInlineEditForm( $talkpage, $method, $operand );

		$result = array( 'inlineeditform' => array( 'html' => $output ) );

		/* FIXME
		$result['resources'] = LqtView::getJSandCSS();
		$result['resources']['messages'] = LqtView::exportJSLocalisation();
		*/

		$this->getResult()->addValue( null, 'threadaction', $result );
	}

	public function getDescription() {
		return 'Allows actions to be taken on threads and posts in threaded discussions.';
	}

	public function getActions() {
		return array(
			'markread' => 'actionMarkRead',
			'markunread' => 'actionMarkUnread',
			'split' => 'actionSplit',
			'merge' => 'actionMerge',
			'reply' => 'actionReply',
			'newthread' => 'actionNewThread',
			'setsubject' => 'actionSetSubject',
			'setsortkey' => 'actionSetSortkey',
			'edit' => 'actionEdit',
			'addreaction' => 'actionAddReaction',
			'deletereaction' => 'actionDeleteReaction',
			'inlineeditform' => 'actionInlineEditForm',
		);
	}

	public function getParamDescription() {
		return array(
			'thread' => 'A list (pipe-separated) of thread IDs or titles to act on',
			'threadaction' => 'The action to take',
			'token' => 'An edit token (from ?action=query&prop=info&intoken=edit)',
			'talkpage' => 'The talkpage to act on (if applicable)',
			'subject' => 'The subject to set for the new or split thread',
			'reason' => 'If applicable, the reason/summary for the action',
			'newparent' => 'If merging a thread, the ID or title for its new parent',
			'text' => 'The text of the post to create',
			'render' => 'If set, on post/reply methods, the top-level thread ' .
				'after the change will be rendered and returned in the result.',
			'bump' => 'If set, overrides default behaviour as to whether or not to ',
				"increase the thread's sort key. If true, sets it to current " .
				"timestamp. If false, does not set it. Default depends on " .
				"the action being taken. Presently only works for newthread " .
				"and reply actions.",
			'sortkey' => "Specifies the timestamp to which to set a thread's " .
					"sort key. Must be in the form YYYYMMddhhmmss, " .
					"a unix timestamp or 'now'.",
			'signature' => 'Specifies the signature to use for that post. Can be ' .
					'NULL to specify the default signature',
			'type' => 'Specifies the type of reaction to add',
			'value' => 'Specifies the value associated with the reaction to add',
			'method' => 'For getting inline edit forms, the method to get a form for',
			'operand' => '',
			'gettoken' => 'Gets a thread token',
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'action' ),
			array( 'missingparam', 'talkpage' ),
			array( 'missingparam', 'subject' ),
			array( 'code' => 'too-many-threads', 'info' => 'You may only split one thread at a time' ),
			array( 'code' => 'no-specified-threads', 'info' => 'You must specify a thread to split' ),
			array( 'code' => 'already-top-level', 'info' => 'This thread is already a top-level thread.' ),
			array( 'code' => 'no-valid-subject', 'info' => 'No subject, or an invalid subject, was specified' ),
			array( 'code' => 'no-specified-threads', 'info' => 'You must specify a thread to merge' ),
			array( 'code' => 'no-parent-thread', 'info' => 'You must specify a new parent thread to merge beneath' ),
			array( 'code' => 'invalid-parent-thread', 'info' => 'The parent thread you specified was neither the title of a thread, nor a thread ID.' ),
			array( 'code' => 'invalid-talkpage', 'info' => 'The talkpage you specified is invalid, or does not have discussion threading enabled.' ),
			array( 'code' => 'talkpage-protected', 'info' => 'You cannot post to the specified talkpage, because it is protected from new posts' ),
			array( 'code' => 'invalid-subject', 'info' => 'The subject you specified is not valid' ),
			array( 'code' => 'no-text', 'info' => 'You must include text in your post' ),
			array( 'code' => 'too-many-threads', 'info' => 'You may only edit one thread at a time' ),
			array( 'code' => 'invalid-subject', 'info' => 'You must specify a thread to edit' ),
			array( 'code' => 'no-specified-threads', 'info' => 'You must specify a thread to reply to' ),
			array( 'code' => 'perm_result-protected', 'info' => 'You cannot reply to this thread, because the perm_result is protected from replies.' ),
			array( 'code' => 'too-many-threads', 'info' => 'You may only change the subject of one thread at a time' ),
			array( 'code' => 'no-specified-threads', 'info' => 'You must specify a thread to change the subject of' ),
			array( 'code' => 'no-specified-threads', 'info' => 'You must specify a thread to set the sortkey of' ),
			array( 'code' => 'invalid-sortkey', 'info' => 'You must specify a valid timestamp for the sortkey parameter. It should be in the form YYYYMMddhhmmss, a unix timestamp or "now".' ),
		) );
	}

	public function getExamples() {
		return array(
		);
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getAllowedParams() {
		return array(
			'thread' => array(
				ApiBase::PARAM_ISMULTI => true,
			),
			'talkpage' => null,
			'threadaction' => array(
				ApiBase::PARAM_TYPE => array_keys( $this->getActions() ),
			),
			'token' => null,
			'subject' => null,
			'reason' => null,
			'newparent' => null,
			'text' => null,
			'render' => null,
			'bump' => null,
			'sortkey' => null,
			'signature' => null,
			'type' => null,
			'value' => null,
			'method' => null,
			'operand' => null,
			'gettoken' => null,
		);
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiThreadAction.php 104467 2011-11-28 18:55:51Z reedy $';
	}
}

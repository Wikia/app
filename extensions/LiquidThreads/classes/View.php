<?php
/**
* @file
* @ingroup LiquidThreads
* @author David McCabe <davemccabe@gmail.com>
* @licence GPL2
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( - 1 );
}

class LqtView {
	public $article;
	public $output;
	public $user;
	public $title;
	public $request;

	protected $headerLevel = 2; /* h1, h2, h3, etc. */
	protected $lastUnindentedSuperthread;

	public $threadNestingLevel = 0;

	protected $sort_order = LQT_NEWEST_CHANGES;

	static $stylesAndScriptsDone = false;

	function __construct( &$output, &$article, &$title, &$user, &$request ) {
		$this->article = $article;
		$this->output = $output;
		$this->user = $user;
		$this->title = $title;
		$this->request = $request;
		$this->user_colors = array();
		$this->user_color_index = 1;
	}

	function setHeaderLevel( $int ) {
		$this->headerLevel = $int;
	}

	/*************************
	 * (1) linking to liquidthreads pages and
	 * (2) figuring out what page you're on and what you need to do.
	*************************/

	function methodAppliesToThread( $method, $thread ) {
		return $this->request->getVal( 'lqt_method' ) == $method &&
			$this->request->getVal( 'lqt_operand' ) == $thread->id();
	}
	function methodApplies( $method ) {
		return $this->request->getVal( 'lqt_method' ) == $method;
	}

	static function permalinkUrl( $thread, $method = null, $operand = null,
									$uquery = array(), $relative = true ) {
		list ( $title, $query ) = self::permalinkData( $thread, $method, $operand );

		$query = array_merge( $query, $uquery );

		$queryString = wfArrayToCGI( $query );

		if( $relative ) {
			return $title->getLocalUrl( $queryString );
		} else {
			return $title->getCanonicalUrl( $queryString );
		}
	}

	/** Gets an array of (title, query-parameters) for a permalink **/
	static function permalinkData( $thread, $method = null, $operand = null ) {
		$query = array();

		if ( $method ) {
			$query['lqt_method'] = $method;
		}
		if ( $operand ) {
			$query['lqt_operand'] = $operand;
		}

		if ( ! $thread ) {
			throw new MWException( "Empty thread passed to ".__METHOD__ );
		}

		return array( $thread->root()->getTitle(), $query );
	}

	/* This is used for action=history so that the history tab works, which is
	   why we break the lqt_method paradigm. */
	static function permalinkUrlWithQuery( $thread, $query, $relative = true ) {
		if ( !is_array( $query ) ) {
			$query = wfCGIToArray( $query );
		}

		return self::permalinkUrl( $thread, null, null, $query, $relative );
	}

	static function permalink( $thread, $text = null, $method = null, $operand = null,
					$linker = null, $attribs = array(), $uquery = array() ) {
		if ( is_null( $linker ) ) {
			$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();
		}

		list( $title, $query ) = self::permalinkData( $thread, $method, $operand );

		$query = array_merge( $query, $uquery );

		return $linker->link( $title, $text, $attribs, $query );
	}

	static function linkInContextData( $thread, $contextType = 'page' ) {
		$query = array();

		if ( ! $thread ) {
			throw new MWException( "Null thread passed to linkInContextData" );
		}

		if ( $contextType == 'page' ) {
			$title = clone $thread->getTitle();

			$dbr = wfGetDB( DB_SLAVE );
			$offset = $thread->topmostThread()->sortkey();
			$offset = wfTimestamp( TS_UNIX, $offset ) + 1;
			$offset = $dbr->timestamp( $offset );
			$query['offset'] = $offset;
		} else {
			$title = clone $thread->title();
		}

		$query['lqt_mustshow'] = $thread->id();

		$title->setFragment( '#' . $thread->getAnchorName() );

		return array( $title, $query );
	}

	static function linkInContext( $thread, $contextType = 'page', $text = null ) {
		list( $title, $query ) = self::linkInContextData( $thread, $contextType );

		if ( is_null( $text ) ) {
			$text = Threads::stripHTML( $thread->formattedSubject() );
		}

		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();

		return $linker->link( $title, $text, array(), $query );
	}

	static function linkInContextURL( $thread, $contextType = 'page' ) {
		list( $title, $query ) = self::linkInContextData( $thread, $contextType );

		return $title->getLocalURL( $query );
	}

	static function linkInContextFullURL( $thread, $contextType = 'page' ) {
		list( $title, $query ) = self::linkInContextData( $thread, $contextType );

		return $title->getFullURL( $query );
	}
	
	static function linkInContextCanonicalURL( $thread, $contextType = 'page' ) {
		list( $title, $query ) = self::linkInContextData( $thread, $contextType );

		return $title->getCanonicalURL( $query );
	}

	static function diffQuery( $thread, $revision ) {
		$changed_thread = $revision->getChangeObject();
		$curr_rev_id = $changed_thread->rootRevision();
		$curr_rev = Revision::newFromId( $curr_rev_id );

		$oldid = '';
		if ( $curr_rev ) {
			$prev_rev = $curr_rev->getPrevious();
			$oldid = $prev_rev ? $prev_rev->getId() : '';
		}

		$query = array(
			'lqt_method' => 'diff',
			'diff' => $curr_rev_id,
			'oldid' => $oldid
		);

		return $query;
	}

	static function diffPermalinkURL( $thread, $revision ) {
		$query = self::diffQuery( $thread, $revision );
		return self::permalinkUrl( $thread, null, null, $query, false );
	}

	static function diffPermalink( $thread, $text, $revision ) {
		$query = self::diffQuery( $thread, $revision );
		return self::permalink( $thread, $text, null, null, null, array(), $query );
	}

	static function talkpageLink( $title, $text = null , $method = null, $operand = null,
					$includeFragment = true, $attribs = array(),
					$options = array(), $perpetuateOffset = true )
	{
		list( $title, $query ) = self::talkpageLinkData(
			$title, $method, $operand,
			$includeFragment,
			$perpetuateOffset
		);

		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();

		return $linker->link( $title, $text, $attribs, $query, $options );
	}

	static function talkpageLinkData( $title, $method = null, $operand = null,
		$includeFragment = true, $perpetuateOffset = true )
	{
		global $wgRequest;
		$query = array();

		if ( $method ) {
			$query['lqt_method'] = $method;
		}

		if ( $operand ) {
			$query['lqt_operand'] = $operand->id();
		}

		$oldid = $wgRequest->getVal( 'oldid', null );

		if ( $oldid !== null ) {
			// this is an immensely ugly hack to make editing old revisions work.
			$query['oldid'] = $oldid;
		}

		$request = $perpetuateOffset;
		if ( $request === true ) {
			global $wgRequest;
			$request = $wgRequest;
		}

		if ( $perpetuateOffset ) {
			$offset = $request->getVal( 'offset' );

			if ( $offset ) {
				$query['offset'] = $offset;
			}
		}

		// Add fragment if appropriate.
		if ( $operand && $includeFragment ) {
			$title->mFragment = $operand->getAnchorName();
		}

		return array( $title, $query );
	}

	/**
	 * If you want $perpetuateOffset to perpetuate from a specific request,
	 * pass that instead of true
	 */
	static function talkpageUrl( $title, $method = null, $operand = null,
		$includeFragment = true, $perpetuateOffset = true )
	{
		list( $title, $query ) =
			self::talkpageLinkData( $title, $method, $operand, $includeFragment,
						$perpetuateOffset );

		return $title->getLinkUrl( $query );
	}


	/**
	 * Return a URL for the current page, including Title and query vars,
	 * with the given replacements made.
	 * @param $repls array( 'name'=>new_value, ... )
	 */
	function queryReplaceLink( $repls ) {
		$query = $this->getReplacedQuery( $repls );

		return $this->title->getLocalURL( wfArrayToCGI( $query ) );
	}

	function getReplacedQuery( $replacements ) {
		$values = $this->request->getValues();

		foreach ( $replacements as $k => $v ) {
			$values[$k] = $v;
		}

		return $values;
	}

	/*************************************************************
	 * Editing methods (here be dragons)						  *
	 * Forget dragons: This section distorts the rest of the code *
	 * like a star bending spacetime around itself.				  *
	 *************************************************************/

	/**
	 * Return an HTML form element whose value is gotten from the request.
	 * TODO: figure out a clean way to expand this to other forms.
	 */
	function perpetuate( $name, $as = 'hidden' ) {
		$value = $this->request->getVal( $name, '' );
		if ( $as == 'hidden' ) {
			return Html::hidden( $name, $value );
		}
	}

	function showReplyProtectedNotice( $thread ) {
		$log_url = SpecialPage::getTitleFor( 'Log' )->getLocalURL(
			"type=protect&user=&page={$thread->title()->getPrefixedURL()}" );
		$this->output->addHTML( '<p>' . wfMsg( 'lqt_protectedfromreply',
			'<a href="' . $log_url . '">' . wfMsg( 'lqt_protectedfromreply_link' ) . '</a>' ) );
	}

	function doInlineEditForm() {
		$method = $this->request->getVal( 'lqt_method' );
		$operand = $this->request->getVal( 'lqt_operand' );

		$thread = Threads::withId( intval( $operand ) );

		// Yuck.
		global $wgOut, $wgRequest, $wgTitle;
		$oldOut = $wgOut;
		$oldRequest = $wgRequest;
		$oldTitle = $wgTitle;
		$wgOut = $this->output;
		$wgRequest = $this->request;
		$wgTitle = $this->title;

		$hookResult = wfRunHooks( 'LiquidThreadsDoInlineEditForm',
					array(
						$thread,
						$this->request,
						&$this->output
					) );

		if ( !$hookResult ) {
			// Handled by a hook.
		} elseif ( $method == 'reply' ) {
			$this->showReplyForm( $thread );
		} elseif ( $method == 'talkpage_new_thread' ) {
			$this->showNewThreadForm( $this->article );
		} elseif ( $method == 'edit' ) {
			$this->showPostEditingForm( $thread );
		} else {
			throw new MWException( "Invalid thread method $method" );
		}

		$wgOut = $oldOut;
		$wgRequest = $oldRequest;
		$wgTitle = $oldTitle;

		$this->output->setArticleBodyOnly( true );
	}

	/**
	 * Workaround for bug 27887 caused by r82686
	 * @param $request FauxRequest object to have session data injected into.
	 */
	static function fixFauxRequestSession( $request ) {
		foreach( (array)$_SESSION as $k => $v ) {
			$request->setSessionData( $k, $v );
		}
	}

	static function getInlineEditForm( $talkpage, $method, $operand ) {
		$req = new RequestContext;
		$output = $req->getOutput();
		$request = new FauxRequest( array() );

		// Workaround for loss of session data when using FauxRequest
		global $wgRequest;
		self::fixFauxRequestSession( $request );

		$title = null;

		if ( $talkpage ) {
			$title = $talkpage->getTitle();
		} elseif ( $operand ) {
			$thread = Threads::withId( $operand );
			if ( $thread ) {
				$talkpage = $thread->article();
				$title = $talkpage->getTitle();
			}
		}

		$output->setTitle( $title );
		$request->setVal( 'lqt_method', $method );
		$request->setVal( 'lqt_operand', $operand );

		global $wgUser;
		$view = new LqtView( $output, $talkpage, $title, $wgUser, $request );

		$view->doInlineEditForm();

		foreach( $request->getSessionArray() as $k => $v ) {
			$wgRequest->setSessionData( $k, $v );
		}

		return $output->getHTML();
	}

	function showNewThreadForm( $talkpage ) {
		$submitted_nonce = $this->request->getVal( 'lqt_nonce' );
		$nonce_key = wfMemcKey( 'lqt-nonce', $submitted_nonce, $this->user->getName() );
		if ( ! $this->handleNonce( $submitted_nonce, $nonce_key ) ) return;

		if ( Thread::canUserPost( $this->user, $this->article ) !== true ) {
			$this->output->addWikiMsg( 'lqt-protected-newthread' );
			return;
		}
		$subject = $this->request->getVal( 'lqt_subject_field', false );

		$t = null;

		$subjectOk = Thread::validateSubject( $subject, $t,
					null, $this->article );
		if ( ! $subjectOk ) {
			try {
				$t = $this->newThreadTitle( $subject );
			} catch ( MWException $excep ) {
				$t = $this->scratchTitle();
			}
		}

		$article = new Article( $t );

		LqtHooks::$editTalkpage = $talkpage;
		LqtHooks::$editArticle = $article;
		LqtHooks::$editThread = null;
		LqtHooks::$editType = 'new';
		LqtHooks::$editAppliesTo = null;

		$e = new EditPage( $article );
		wfRunHooks( 'LiquidThreadsShowNewThreadForm', array( &$e, $talkpage ) );

		global $wgRequest;
		// Quietly force a preview if no subject has been specified.
		if ( !$subjectOk ) {
			// Dirty hack to prevent saving from going ahead
			$wgRequest->setVal( 'wpPreview', true );

			if ( $this->request->wasPosted() ) {
				if ( !$subject ) {
					$msg = 'lqt_empty_subject';
				} else {
					$msg = 'lqt_invalid_subject';
				}

				$e->editFormPageTop .=
					Xml::tags( 'div', array( 'class' => 'error' ),
						wfMsgExt( $msg, 'parse' ) );
			}
		}

		$e->suppressIntro = true;
		$e->editFormTextBeforeContent .=
			$this->perpetuate( 'lqt_method', 'hidden' ) .
			$this->perpetuate( 'lqt_operand', 'hidden' ) .
			Html::hidden( 'lqt_nonce', wfGenerateToken() );

		$e->mShowSummaryField = false;

		$summary = wfMsgForContent( 'lqt-newpost-summary', $subject );
		$wgRequest->setVal( 'wpSummary', $summary );

		list( $signatureEditor, $signatureHTML ) = $this->getSignatureEditor( $this->user );

		$e->editFormTextAfterContent .=
			$signatureEditor;
		$e->previewTextAfterContent .=
			Xml::tags( 'p', null, $signatureHTML );

		$e->editFormTextBeforeContent .= $this->getSubjectEditor( '', $subject );

		wfRunHooks( 'LiquidThreadsAfterShowNewThreadForm', array( &$e, $talkpage ) );

		$e->edit();

		if ( $e->didSave ) {
			$signature = $this->request->getVal( 'wpLqtSignature', null );

			$info =
				array(
					'talkpage' => $talkpage,
					'text' => $e->textbox1,
					'summary' => $e->summary,
					'signature' => $signature,
					'root' => $article,
					'subject' => $subject,
				);

			wfRunHooks( 'LiquidThreadsSaveNewThread',
					array( &$info, &$e, &$talkpage ) );

			$thread = LqtView::newPostMetadataUpdates( $info );

			if ( $submitted_nonce && $nonce_key ) {
				global $wgMemc;
				$wgMemc->set( $nonce_key, 1, 3600 );
			}
		}

		if ( $this->output->getRedirect() != '' ) {
			   $redirectTitle = clone $talkpage->getTitle();
			   if ( !empty($thread) ) {
				   $redirectTitle->setFragment( '#' . $this->anchorName( $thread ) );
			   }
			   $this->output->redirect( $this->title->getLocalURL() );
		}

	}

	function showReplyForm( $thread ) {
		global $wgRequest;

		$submitted_nonce = $this->request->getVal( 'lqt_nonce' );
		$nonce_key = wfMemcKey( 'lqt-nonce', $submitted_nonce, $this->user->getName() );
		if ( ! $this->handleNonce( $submitted_nonce, $nonce_key ) ) return;

		$perm_result = $thread->canUserReply( $this->user );
		if ( $perm_result !== true ) {
			$this->showReplyProtectedNotice( $thread );
			return;
		}

		$html = Xml::openElement( 'div',
					array( 'class' => 'lqt-reply-form' ) );
		$this->output->addHTML( $html );


		try {
			$t = $this->newReplyTitle( null, $thread );
		} catch ( MWException $excep ) {
			$t = $this->scratchTitle();
			$valid_subject = false;
		}

		$article = new Article( $t );
		$talkpage = $thread->article();

		LqtHooks::$editTalkpage = $talkpage;
		LqtHooks::$editArticle = $article;
		LqtHooks::$editThread = $thread;
		LqtHooks::$editType = 'reply';
		LqtHooks::$editAppliesTo = $thread;

		$e = new EditPage( $article );

		$e->mShowSummaryField = false;

		$reply_subject = $thread->subject();
		$reply_title = $thread->title()->getPrefixedText();
		$summary = wfMsgForContent(
			'lqt-reply-summary',
			$reply_subject,
			$reply_title
		);
		$wgRequest->setVal( 'wpSummary', $summary );

		// Add an offset so it works if it's on the wrong page.
		$dbr = wfGetDB( DB_SLAVE );
		$offset = wfTimestamp( TS_UNIX, $thread->topmostThread()->sortkey() );
		$offset++;
		$offset = $dbr->timestamp( $offset );

		$e->suppressIntro = true;
		$e->editFormTextBeforeContent .=
			$this->perpetuate( 'lqt_method', 'hidden' ) .
			$this->perpetuate( 'lqt_operand', 'hidden' ) .
			Html::hidden( 'lqt_nonce', wfGenerateToken() ) .
			Html::hidden( 'offset', $offset ) .
			Html::hidden( 'wpMinorEdit', '' );

		list( $signatureEditor, $signatureHTML ) = $this->getSignatureEditor( $this->user );

		$e->editFormTextAfterContent .=
			$signatureEditor;
		$e->previewTextAfterContent .=
			Xml::tags( 'p', null, $signatureHTML );

		$wgRequest->setVal( 'wpWatchThis', false );

		wfRunHooks( 'LiquidThreadsShowReplyForm', array( &$e, $thread ) );

		$e->edit();

		if ( $e->didSave ) {
			$bump = !$this->request->getCheck('wpBumpThread') ||
				$this->request->getBool( 'wpBumpThread' );
			$signature = $this->request->getVal( 'wpLqtSignature', null );

			$info = array(
					'replyTo' => $thread,
					'text' => $e->textbox1,
					'summary' => $e->summary,
					'bump' => $bump,
					'signature' => $signature,
					'root' => $article,
				);

			wfRunHooks( 'LiquidThreadsSaveReply',
					array( &$info, &$e, &$thread ) );

			$newThread = LqtView::replyMetadataUpdates( $info );

			if ( $submitted_nonce && $nonce_key ) {
				global $wgMemc;
				$wgMemc->set( $nonce_key, 1, 3600 );
			}
		}

		if ( $this->output->getRedirect() != '' ) {
			   $redirectTitle = clone $talkpage->getTitle();
			   if ( !empty( $newThread ) ) {
				   $redirectTitle->setFragment( '#' .
					$this->anchorName( $newThread ) );
			   }
			   $this->output->redirect( $this->title->getLocalURL() );
		}

		$this->output->addHTML( '</div>' );
	}

	function showPostEditingForm( $thread ) {
		$submitted_nonce = $this->request->getVal( 'lqt_nonce' );
		$nonce_key = wfMemcKey( 'lqt-nonce', $submitted_nonce, $this->user->getName() );
		if ( ! $this->handleNonce( $submitted_nonce, $nonce_key ) ) return;

		$subject_expected = $thread->isTopmostThread();
		$subject = $this->request->getVal( 'lqt_subject_field', '' );

		if ( !$subject ) {
			$subject = $thread->subject();
		}

		$t = null;
		$subjectOk = Thread::validateSubject( $subject, $t,
					$thread->superthread(), $this->article );
		if ( ! $subjectOk ) {
			$subject = false;
		}

		$article = $thread->root();
		$talkpage = $thread->article();

		wfRunHooks( 'LiquidThreadsEditFormContent', array( $thread, &$article, $talkpage ) );

		LqtHooks::$editTalkpage = $talkpage;
		LqtHooks::$editArticle = $article;
		LqtHooks::$editThread = $thread;
		LqtHooks::$editType = 'edit';
		LqtHooks::$editAppliesTo = $thread;

		$e = new EditPage( $article );

		global $wgRequest;
		// Quietly force a preview if no subject has been specified.
		if ( !$subjectOk ) {
			// Dirty hack to prevent saving from going ahead
			$wgRequest->setVal( 'wpPreview', true );

			if ( $this->request->wasPosted() ) {
				$e->editFormPageTop .=
					Xml::tags( 'div', array( 'class' => 'error' ),
						wfMsgExt( 'lqt_invalid_subject', 'parse' ) );
			}
		}

		// Add an offset so it works if it's on the wrong page.
		$dbr = wfGetDB( DB_SLAVE );
		$offset = wfTimestamp( TS_UNIX, $thread->topmostThread()->sortkey() );
		$offset++;
		$offset = $dbr->timestamp( $offset );

		$e->suppressIntro = true;
		$e->editFormTextBeforeContent .=
			$this->perpetuate( 'lqt_method', 'hidden' ) .
			$this->perpetuate( 'lqt_operand', 'hidden' ) .
			Html::hidden( 'lqt_nonce', wfGenerateToken() ) .
			Html::hidden( 'offset', $offset );

		list( $signatureEditor, $signatureHTML ) = $this->getSignatureEditor( $thread );

		$e->editFormTextAfterContent .=
			$signatureEditor;
		$e->previewTextAfterContent .=
			Xml::tags( 'p', null, $signatureHTML );

		if ( $thread->isTopmostThread() ) {
			$e->editFormTextBeforeContent .=
				$this->getSubjectEditor( $thread->subject(), $subject );
		}

		$e->edit();

		if ( $e->didSave ) {
			$bump = !$this->request->getCheck('wpBumpThread') ||
				$this->request->getBool( 'wpBumpThread' );
			$signature = $this->request->getVal( 'wpLqtSignature', null );

			LqtView::editMetadataUpdates(
				array(
					'thread' => $thread,
					'text' => $e->textbox1,
					'summary' => $e->summary,
					'bump' => $bump,
					'subject' => $subject,
					'signature' => $signature,
					'root' => $article,
				)
			);

			if ( $submitted_nonce && $nonce_key ) {
				global $wgMemc;
				$wgMemc->set( $nonce_key, 1, 3600 );
			}
		}

		if ( $this->output->getRedirect() != '' ) {
			   $redirectTitle = clone $talkpage->getTitle();
			   $redirectTitle->setFragment( '#' . $this->anchorName( $thread ) );
			   $this->output->redirect( $this->title->getLocalURL() );
		}

	}

	function showSummarizeForm( $thread ) {
		$submitted_nonce = $this->request->getVal( 'lqt_nonce' );
		$nonce_key = wfMemcKey( 'lqt-nonce', $submitted_nonce, $this->user->getName() );
		if ( ! $this->handleNonce( $submitted_nonce, $nonce_key ) ) return;

		if ( $thread->summary() ) {
			$article = $thread->summary();
		} else {
			$t = $this->newSummaryTitle( $thread );
			$article = new Article( $t );
		}

		$this->output->addWikiMsg( 'lqt-summarize-intro' );

		$talkpage = $thread->article();

		LqtHooks::$editTalkpage = $talkpage;
		LqtHooks::$editArticle = $article;
		LqtHooks::$editThread = $thread;
		LqtHooks::$editType = 'summarize';
		LqtHooks::$editAppliesTo = $thread;

		$e = new EditPage( $article );

		// Add an offset so it works if it's on the wrong page.
		$dbr = wfGetDB( DB_SLAVE );
		$offset = wfTimestamp( TS_UNIX, $thread->topmostThread()->sortkey() );
		$offset++;
		$offset = $dbr->timestamp( $offset );

		$e->suppressIntro = true;
		$e->editFormTextBeforeContent .=
			$this->perpetuate( 'lqt_method', 'hidden' ) .
			$this->perpetuate( 'lqt_operand', 'hidden' ) .
			Html::hidden( 'lqt_nonce', wfGenerateToken() ) .
			Html::hidden( 'offset', $offset );

		$e->edit();

		if ( $e->didSave ) {
			$bump = !$this->request->getCheck('wpBumpThread') ||
				$this->request->getBool( 'wpBumpThread' );

			LqtView::summarizeMetadataUpdates(
				array(
					'thread' => $thread,
					'article' => $article,
					'summary' => $e->summary,
					'bump' => $bump,
				)
			);

			if ( $submitted_nonce && $nonce_key ) {
				global $wgMemc;
				$wgMemc->set( $nonce_key, 1, 3600 );
			}
		}

		if ( $this->output->getRedirect() != '' ) {
			   $redirectTitle = clone $talkpage->getTitle();
			   $redirectTitle->setFragment( '#' . $this->anchorName( $thread ) );
			   $this->output->redirect( $this->title->getLocalURL() );
		}

	}

	public function handleNonce( $submitted_nonce, $nonce_key ) {
		// Add a one-time random string to a hidden field. Store the random string
		//	in memcached on submit and don't allow the edit to go ahead if it's already
		//	been added.
		if ( $submitted_nonce ) {
			global $wgMemc;

			if ( $wgMemc->get( $nonce_key ) ) {
				$this->output->redirect( $this->article->getTitle()->getLocalURL() );
				return false;
			}
		}

		return true;
	}

	public function getSubjectEditor( $db_subject, $subject ) {
		if ( $subject === false ) $subject = $db_subject;

		$subject_label = wfMsg( 'lqt_subject' );

		$attr = array( 'tabindex' => 1 );

		return Xml::inputLabel( $subject_label, 'lqt_subject_field',
				'lqt_subject_field', 60, $subject, $attr ) .
			Xml::element( 'br' );
	}

	public function getSignatureEditor( $from ) {
		$signatureText = $this->request->getVal( 'wpLqtSignature', null );

		if ( is_null( $signatureText ) ) {
			if ( $from instanceof User ) {
				$signatureText = LqtView::getUserSignature( $from );
			} elseif ( $from instanceof Thread ) {
				$signatureText = $from->signature();
			}
		}

		$signatureHTML = LqtView::parseSignature( $signatureText );

		// Signature edit box
		$signaturePreview = Xml::tags(
			'span',
			array(
				'class' => 'lqt-signature-preview',
				'style' => 'display: none;'
			),
			$signatureHTML
		);
		$signatureEditBox = Xml::input(
			'wpLqtSignature', 45, $signatureText,
			array( 'class' => 'lqt-signature-edit' )
		);

		$signatureEditor = $signaturePreview . $signatureEditBox;

		return array( $signatureEditor, $signatureHTML );
	}

	static function replyMetadataUpdates( $data = array() ) {
		$requiredFields = array( 'replyTo', 'root', 'text' );

		foreach ( $requiredFields as $f ) {
			if ( !isset( $data[$f] ) ) {
				throw new MWException( "Missing required field $f" );
			}
		}

		if ( isset( $data['signature'] ) ) {
			$signature = $data['signature'];
		} else {
			global $wgUser;
			$signature = LqtView::getUserSignature( $wgUser );
		}

		$summary = isset( $data['summary'] ) ? $data['summary'] : '';

		$replyTo = $data['replyTo'];
		$root = $data['root'];
		$text = $data['text'];
		$bump = !empty( $data['bump'] );

		$subject = $replyTo->subject();
		$talkpage = $replyTo->article();

		$thread = Thread::create(
			$root, $talkpage, $replyTo, Threads::TYPE_NORMAL, $subject,
			$summary, $bump, $signature
		);

		wfRunHooks( 'LiquidThreadsAfterReplyMetadataUpdates', array( &$thread ) );

		return $thread;
	}

	static function summarizeMetadataUpdates( $data = array() ) {
		$requiredFields = array( 'thread', 'article', 'summary' );

		foreach ( $requiredFields as $f ) {
			if ( !isset( $data[$f] ) ) {
				throw new MWException( "Missing required field $f" );
			}
		}

		$thread = $data["thread"];
		$article = $data["article"];
		$summary = $data["summary"];

		$bump = isset( $bump ) ? $bump : null;

		$thread->setSummary( $article );
		$thread->commitRevision(
			Threads::CHANGE_EDITED_SUMMARY, $thread, $summary, $bump );

		return $thread;
	}

	static function editMetadataUpdates( $data = array() ) {
		$requiredFields = array( 'thread', 'text', 'summary' );

		foreach ( $requiredFields as $f ) {
			if ( !isset( $data[$f] ) ) {
				throw new MWException( "Missing required field $f" );
			}
		}

		$thread = $data['thread'];

		// Use a separate type if the content is blanked.
		$type = strlen( trim( $data['text'] ) )
				? Threads::CHANGE_EDITED_ROOT
				: Threads::CHANGE_ROOT_BLANKED;

		if ( isset( $data['signature'] ) ) {
			$thread->setSignature( $data['signature'] );
		}

		$bump = !empty( $data['bump'] );

		// Add the history entry.
		$thread->commitRevision( $type, $thread, $data['summary'], $bump );

		// Update subject if applicable.
		if ( $thread->isTopmostThread() && !empty( $data['subject'] ) &&
				$data['subject'] != $thread->subject() ) {
			$thread->setSubject( $data['subject'] );
			$thread->commitRevision( Threads::CHANGE_EDITED_SUBJECT,
						$thread, $data['summary'] );

			// Disabled page-moving for now.
			// $this->renameThread( $thread, $subject, $e->summary );
		}

		return $thread;
	}

	static function newPostMetadataUpdates( $data )
	{
		$requiredFields = array( 'talkpage', 'root', 'text', 'subject' );

		foreach ( $requiredFields as $f ) {
			if ( !isset( $data[$f] ) ) {
				throw new MWException( "Missing required field $f" );
			}
		}

		if ( isset( $data['signature'] ) ) {
			$signature = $data['signature'];
		} else {
			global $wgUser;
			$signature = LqtView::getUserSignature( $wgUser );
		}

		$summary = isset( $data['summary'] ) ? $data['summary'] : '';

		$talkpage = $data['talkpage'];
		$root = $data['root'];
		$text = $data['text'];
		$subject = $data['subject'];

		$thread = Thread::create(
			$root, $talkpage, null,
			Threads::TYPE_NORMAL, $subject,
			$summary, null, $signature
		);

		wfRunHooks( 'LiquidThreadsAfterNewPostMetadataUpdates', array( &$thread ) );

		return $thread;
	}

	function renameThread( $t, $s, $reason ) {
		$this->simplePageMove( $t->root()->getTitle(), $s, $reason );
		// TODO here create a redirect from old page to new.

		foreach ( $t->subthreads() as $st ) {
			$this->renameThread( $st, $s, $reason );
		}
	}

	function newThreadTitle( $subject ) {
		return Threads::newThreadTitle( $subject, $this->article );
	}

	function newSummaryTitle( $thread ) {
		return Threads::newSummaryTitle( $thread );
	}

	function newReplyTitle( $unused, $thread ) {
		return Threads::newReplyTitle( $thread, $this->user );
	}

	/* Adapted from MovePageForm::doSubmit in SpecialMovepage.php. */
	function simplePageMove( $old_title, $new_subject, $reason ) {
		if ( $this->user->pingLimiter( 'move' ) ) {
			$this->out->rateLimited();
			return false;
		}

		# Variables beginning with 'o' for old article 'n' for new article
		$ot = $old_title;
		$nt = $this->incrementedTitle( $new_subject, $old_title->getNamespace() );

		self::$occupied_titles[] = $nt->getPrefixedDBkey();

		$error = $ot->moveTo( $nt, true, "Changed thread subject: $reason" );
		if ( $error !== true ) {
			throw new MWException( "Got error $error trying to move pages." );
		}

		# Move the talk page if relevant, if it exists, and if we've been told to
		 // TODO we need to implement correct moving of talk pages everywhere later.
		// Snipped.

		return true;
	}

	function scratchTitle() {
		return Title::makeTitle( NS_LQT_THREAD, wfGenerateToken() );
	}

	/**
	* Example return value:
	*	array (
	*		edit => array( 'label'	 => 'Edit',
	*					'href'	  => 'http...',
	*					'enabled' => false ),
	*		reply => array( 'label'	  => 'Reply',
	*					'href'	  => 'http...',
	*					'enabled' => true )
	*	)
	*/
	function threadCommands( $thread ) {
		$commands = array();

		$history_url = self::permalinkUrlWithQuery( $thread, array( 'action' => 'history' ) );
		$commands['history'] = array( 'label' => wfMsgExt(
			'history_short', 'parseinline' ),
			 'href' => $history_url,
			 'enabled' => true
		);

		if ( $thread->isHistorical() ) {
			return array();
		}
		$user_can_edit = $thread->root()->getTitle()->quickUserCan( 'edit' );
		$editMsg = $user_can_edit ? 'edit' : 'viewsource';

		$commands['edit'] = array(
			'label' => wfMsgExt( $editMsg, 'parseinline' ),
			'href' => $this->talkpageUrl(
				$this->title,
				'edit', $thread,
				true, /* include fragment */
				$this->request
			),
			'enabled' => true
		);

		if ( $this->user->isAllowed( 'delete' ) ) {
			$delete_url = $thread->title()->getLocalURL( 'action=delete' );
			$deleteMsg = $thread->type() == Threads::TYPE_DELETED ? 'lqt_undelete' : 'delete';

			$commands['delete'] = array(
				'label' => wfMsgExt( $deleteMsg, 'parseinline' ),
				 'href' => $delete_url,
				 'enabled' => true
				);
		}

		if ( !$thread->isTopmostThread() && $this->user->isAllowed( 'lqt-split' ) ) {
			$splitUrl = SpecialPage::getTitleFor( 'SplitThread',
					$thread->title()->getPrefixedText() )->getLocalURL();
			$commands['split'] = array(
				'label' => wfMsgExt( 'lqt-thread-split', 'parseinline' ),
				'href' => $splitUrl,
				'enabled' => true
			);
		}

		if ( $this->user->isAllowed( 'lqt-merge' ) ) {
			$mergeParams = $_GET;
			$mergeParams['lqt_merge_from'] = $thread->id();

			unset( $mergeParams['title'] );

			$mergeUrl = $this->title->getLocalURL( wfArrayToCGI( $mergeParams ) );
			$label = wfMsgExt( 'lqt-thread-merge', 'parseinline' );

			$commands['merge'] = array(
				'label' => $label,
				'href' => $mergeUrl,
				'enabled' => true
			);
		}

		$commands['link'] = array(
			'label' => wfMsgExt( 'lqt_permalink', 'parseinline' ),
			'href' => $thread->title()->getLocalURL(),
			'enabled' => true,
			'showlabel' => true,
			'tooltip' => wfMsgExt( 'lqt_permalink', 'parseinline' )
		);

		wfRunHooks( 'LiquidThreadsThreadCommands', array( $thread, &$commands ) );

		return $commands;
	}

	// Commands for the bottom.
	function threadMajorCommands( $thread ) {
		if ( $thread->isHistorical() ) {
			// No links for historical threads.
			$history_url = self::permalinkUrlWithQuery( $thread,
					array( 'action' => 'history' ) );
			$commands = array();

			$commands['history'] = array(
				'label' => wfMsgExt( 'history_short', 'parseinline' ),
				 'href' => $history_url,
				 'enabled' => true );

			return $commands;
		}

		$commands = array();

		if ( $this->user->isAllowed( 'lqt-merge' ) &&
				$this->request->getCheck( 'lqt_merge_from' ) ) {
			$srcThread = Threads::withId( $this->request->getVal( 'lqt_merge_from' ) );
			$par = $srcThread->title()->getPrefixedText();
			$mergeTitle = SpecialPage::getTitleFor( 'MergeThread', $par );
			$mergeUrl = $mergeTitle->getLocalURL( 'dest=' . $thread->id() );
			$label = wfMsgExt( 'lqt-thread-merge-to', 'parseinline' );

			$commands['merge-to'] = array(
				'label' => $label, 'href' => $mergeUrl,
				'enabled' => true,
				'tooltip' => $label
			);
		}

		if ( $thread->canUserReply( $this->user ) === true ) {
			$commands['reply'] = array(
				'label' => wfMsgExt( 'lqt_reply', 'parseinline' ),
				 'href' => $this->talkpageUrl( $this->title, 'reply', $thread,
					true /* include fragment */, $this->request ),
				 'enabled' => true,
				 'showlabel' => 1,
				 'tooltip' => wfMsg( 'lqt_reply' ),
				 'icon' => 'reply.png',
			);
		}

		// Parent post link
		if ( !$thread->isTopmostThread() ) {
			$parent = $thread->superthread();
			$anchor = $parent->getAnchorName();

			$commands['parent'] = array(
				'label' => wfMsgExt( 'lqt-parent', 'parseinline' ),
				'href' => '#' . $anchor,
				'enabled' => true,
				'showlabel' => 1,
			);
		}

		wfRunHooks( 'LiquidThreadsThreadMajorCommands',
				array( $thread, &$commands ) );

		return $commands;
	}

	function topLevelThreadCommands( $thread ) {
		$commands = array();

		$commands['history'] = array(
			'label' => wfMsg( 'history_short' ),
			'href' => self::permalinkUrl( $thread, 'thread_history' ),
			'enabled' => true
		);

		if ( $this->user->isAllowed( 'move' ) ) {
			$move_href = SpecialPage::getTitleFor( 'MoveThread', $thread->title()->getPrefixedText() )->getLocalURL();
			$commands['move'] = array(
				'label' => wfMsg( 'lqt-movethread' ),
				'href' => $move_href,
				'enabled' => true
			);
		}

		if ( $this->user->isAllowed( 'protect' ) ) {
			$protect_href = $thread->title()->getLocalURL( 'action=protect' );

			// Check if it's already protected
			if ( !$thread->title()->isProtected() ) {
				$label = wfMsg( 'protect' );
			} else {
				$label = wfMsg( 'unprotect' );
			}

			$commands['protect'] = array(
				'label' => $label,
				'href' => $protect_href,
				'enabled' => true
			);
		}

		if ( !$this->user->isAnon() && !$thread->title()->userIsWatching() ) {
			$commands['watch'] = array(
				'label' => wfMsg( 'watch' ),
				'href' => self::permalinkUrlWithQuery( $thread, 'action=watch' ),
				'enabled' => true
			);
		} elseif ( !$this->user->isAnon() ) {
			$commands['unwatch'] = array(
				'label' => wfMsg( 'unwatch' ),
				'href' => self::permalinkUrlWithQuery( $thread, 'action=unwatch' ),
				'enabled' => true
			);
		}

		$summarizeUrl = self::permalinkUrl( $thread, 'summarize', $thread->id() );
		$commands['summarize'] = array(
			'label' => wfMsgExt( 'lqt_summarize_link', 'parseinline' ),
			'href' => $summarizeUrl,
			'enabled' => true,
		);

		wfRunHooks( 'LiquidThreadsTopLevelCommands', array( $thread, &$commands ) );

		return $commands;
	}

	/* @return False if the article and revision do not exist. The HTML of the page to
	 * display if it exists. Note that this impacts the state out OutputPage by adding
	 * all the other relevant parts of the parser output. If you don't want this, call
	 * $post->getParserOutput. */
	function showPostBody( $post, $oldid = null ) {
		global $wgOut;

		$parserOutput = $post->getParserOutput( $oldid );

		if ( $parserOutput === false ) {
			return false;
		}

		// Remove title, so that it stays set correctly.
		$parserOutput->setTitleText( '' );


		$wgOut->addParserOutputNoText( $parserOutput );

		return $parserOutput->getText();
	}

	function showThreadToolbar( $thread ) {
		$html = '';

		$headerParts = array();

		foreach ( $this->threadMajorCommands( $thread ) as $key => $cmd ) {
			$content = $this->contentForCommand( $cmd, false /* No icon divs */ );
			$headerParts[] = Xml::tags( 'li',
						array( 'class' => "lqt-command lqt-command-$key" ),
						$content );
		}

		// Drop-down menu
		$commands = $this->threadCommands( $thread );
		$menuHTML = Xml::tags( 'ul', array( 'class' => 'lqt-thread-toolbar-command-list' ),
					$this->listItemsForCommands( $commands ) );

		$triggerText =	Xml::tags( 'a', array( 'class' => 'lqt-thread-actions-icon',
							'href' => '#' ),
					wfMsgHTML( 'lqt-menu-trigger' ) );
		$dropDownTrigger = Xml::tags( 'div',
				array( 'class' => 'lqt-thread-actions-trigger ' .
					'lqt-command-icon', 'style' => 'display: none;' ),
				$triggerText );

		if ( count( $commands ) ) {
			$headerParts[] = Xml::tags( 'li',
						array( 'class' => 'lqt-thread-toolbar-menu' ),
						$dropDownTrigger );
		}

		$html .= implode( ' ', $headerParts );

		$html = Xml::tags( 'ul', array( 'class' => 'lqt-thread-toolbar-commands' ), $html );

		$html = Xml::tags( 'div', array( 'class' => 'lqt-thread-toolbar' ), $html ) .
				$menuHTML;

		return $html;
	}

	function listItemsForCommands( $commands ) {
		$result = array();
		foreach ( $commands as $key => $command ) {
			$thisCommand = $this->contentForCommand( $command );

			$thisCommand = Xml::tags(
				'li',
				array( 'class' => 'lqt-command lqt-command-' . $key ),
				$thisCommand
			);

			$result[] = $thisCommand;
		}
		return join( ' ', $result );
	}

	function contentForCommand( $command, $icon_divs = true ) {
		$label = $command['label'];
		$href = $command['href'];
		$enabled = $command['enabled'];
		$tooltip = isset( $command['tooltip'] ) ? $command['tooltip'] : '';

		if ( isset( $command['icon'] ) ) {
			$icon = Xml::tags( 'div', array( 'title' => $label,
					'class' => 'lqt-command-icon' ), '&#160;' );
			if ( $icon_divs ) {
				if ( !empty( $command['showlabel'] ) ) {
					$label = $icon . '&#160;' . $label;
				} else {
					$label = $icon;
				}
			} else {
				if ( empty( $command['showlabel'] ) ) {
					$label = '';
				}
			}
		}

		if ( $enabled ) {
			$thisCommand = Xml::tags( 'a', array( 'href' => $href, 'title' => $tooltip ),
					$label );
		} else {
			$thisCommand = Xml::tags( 'span', array( 'class' => 'lqt_command_disabled',
						'title' => $tooltip ), $label );
		}

		return $thisCommand;
	}

	/** Shows a normal (i.e. not deleted or moved) thread body */
	function showThreadBody( $thread ) {

		// Remove 'editsection', it won't work.
		$popts = $this->output->parserOptions();
		$previous_editsection = $popts->getEditSection();
		$popts->setEditSection( false );
		$this->output->parserOptions( $popts );

		$post = $thread->root();

		$divClass = $this->postDivClass( $thread );
		$html = '';

		// This is a bit of a hack to have individual histories work.
		// We can grab oldid either from lqt_oldid (which is a thread rev),
		// or from oldid (which is a page rev). But oldid only applies to the
		// thread being requested, not any replies.
		$page_rev = $this->request->getVal( 'oldid', null );
		if ( $page_rev !== null && $this->title->equals( $thread->root()->getTitle() ) ) {
			$oldid = $page_rev;
		} else {
			$oldid = $thread->isHistorical() ? $thread->rootRevision() : null;
		}

		// If we're editing the thread, show the editing form.
		$showAnything = wfRunHooks( 'LiquidThreadsShowThreadBody',
					array( $thread ) );
		if ( $this->methodAppliesToThread( 'edit', $thread ) && $showAnything ) {
			$html = Xml::openElement( 'div', array( 'class' => $divClass ) );
			$this->output->addHTML( $html );
			$html = '';

			// No way am I refactoring EditForm to return its output as HTML.
			//	so I'm just flushing the HTML and displaying it as-is.
			$this->showPostEditingForm( $thread );
			$html .= Xml::closeElement( 'div' );
		} elseif ( $showAnything ) {
			$html .= Xml::openElement( 'div', array( 'class' => $divClass ) );

			$show = wfRunHooks( 'LiquidThreadsShowPostContent',
						array( $thread, &$post ) );
			if ( $show ) {
				$html .= $this->showPostBody( $post, $oldid );
			}
			$html .= Xml::closeElement( 'div' );
			wfRunHooks( 'LiquidThreadsShowPostThreadBody',
				array( $thread, $this->request, &$html ) );


			$html .= $this->showThreadToolbar( $thread );
			$html .= $this->threadSignature( $thread );
		}

		$this->output->addHTML( $html );

		$popts->setEditSection( $previous_editsection );
		$this->output->parserOptions( $popts );
	}

	function threadSignature( $thread ) {
		global $wgLang;

		$signature = $thread->signature();
		$signature = LqtView::parseSignature( $signature );

		$signature = Xml::tags( 'span', array( 'class' => 'lqt-thread-user-signature' ),
					$signature );

		$signature .= $wgLang->getDirMark();

		$timestamp = $wgLang->timeanddate( $thread->created(), true );
		$signature .= Xml::element( 'span',
					array( 'class' => 'lqt-thread-toolbar-timestamp' ),
					$timestamp );

		wfRunHooks( 'LiquidThreadsThreadSignature', array( $thread, &$signature ) );

		$signature = Xml::tags( 'div', array( 'class' => 'lqt-thread-signature' ),
					$signature );

		return $signature;
	}

	function threadInfoPanel( $thread ) {
		global $wgLang;

		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();

		$infoElements = array();

		// Check for edited flag.
		$editedFlag = $thread->editedness();
		$ebLookup = array( Threads::EDITED_BY_AUTHOR => 'author',
					Threads::EDITED_BY_OTHERS => 'others' );
		$lastEdit = $thread->root()->getTimestamp();
		$lastEditTime = $wgLang->time( $lastEdit, false, true, true );
		$lastEditDate = $wgLang->date( $lastEdit, false, true, true );
		$lastEdit = $wgLang->timeanddate( $lastEdit, true );
		$editors = '';
		$editorCount = 0;

		if ( $editedFlag > Threads::EDITED_BY_AUTHOR ) {
			$editors = $thread->editors();
			$editorCount = count( $editors );
			$formattedEditors = array();

			foreach ( $editors as $ed ) {
				$id = IP::isIPAddress( $ed ) ? 0 : 1;
				$fEditor = $linker->userLink( $id, $ed ) .
					$linker->userToolLinks( $id, $ed );
				$formattedEditors[] = $fEditor;
			}

			$editors = $wgLang->commaList( $formattedEditors );
		}

		if ( isset( $ebLookup[$editedFlag] ) ) {
			$editedBy = $ebLookup[$editedFlag];
			// Used messages: lqt-thread-edited-author, lqt-thread-edited-others
			$editedNotice = wfMsgExt( 'lqt-thread-edited-' . $editedBy,
					array( 'parseinline' ),
					array( $lastEdit, $editorCount, $lastEditTime,
						$lastEditDate ) );
			$editedNotice = str_replace( '$3', $editors, $editedNotice );
			$infoElements[] = Xml::tags( 'div', array( 'class' =>
						'lqt-thread-toolbar-edited-' . $editedBy ),
						$editedNotice );
		}

		wfRunHooks( 'LiquidThreadsThreadInfoPanel', array( $thread, &$infoElements ) );

		if ( ! count( $infoElements ) ) {
			return '';
		}

		return Xml::tags( 'div', array( 'class' => 'lqt-thread-info-panel' ),
							implode( "\n", $infoElements ) );
	}

	/** Shows the headING for a thread (as opposed to the headeER for a post within
		a thread). */
	function showThreadHeading( $thread ) {
		global $wgContLang;
		if ( $thread->hasDistinctSubject() ) {
			if ( $thread->hasSuperthread() ) {
				$commands_html = "";
			} else {
				$commands = $this->topLevelThreadCommands( $thread );
				$lis = $this->listItemsForCommands( $commands );
				$id = 'lqt-threadlevel-commands-' . $thread->id();
				$commands_html = Xml::tags( 'ul',
						array( 'class' => 'lqt_threadlevel_commands',
							'id' => $id ),
						$lis );
			}

			$id = 'lqt-header-' . $thread->id();

			$html = $thread->formattedSubject();

			$show = wfRunHooks( 'LiquidThreadsShowThreadHeading',
					array( $thread, &$html ) );

			if ( $show ) {
				$html = Xml::tags( 'span', array( 'class' => 'mw-headline' ), $html );
				$html .= Html::hidden( 'raw-header', $thread->subject() );
				$html = Xml::tags( 'h' . $this->headerLevel,
						array( 'class' => 'lqt_header', 'id' => $id, 'dir' => $wgContLang->getDir() ),
						$html ) . $commands_html;
			}

			// wrap it all in a container
			$html = Xml::tags( 'div',
					array( 'class' => 'lqt_thread_heading' ),
					$html );
			return $html;
		}

		return '';
	}

	function postDivClass( $thread ) {
		global $wgContLang;
		$levelClass = 'lqt-thread-nest-' . $this->threadNestingLevel;
		$alternatingType = ( $this->threadNestingLevel % 2 ) ? 'odd' : 'even';
		$alternatingClass = "lqt-thread-$alternatingType";
		$dir = $wgContLang->getDir();

		return "lqt_post $levelClass $alternatingClass mw-content-$dir";
	}

	static function anchorName( $thread ) {
		return $thread->getAnchorName();
	}

	// Display a moved thread
	function showMovedThread( $thread ) {
		global $wgLang;

		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();

		// Grab target thread
		if ( !$thread->title() ) {
			return; // Odd case: moved thread with no title?
		}

		$article = new Article( $thread->title() );
		$target = Title::newFromRedirect( $article->getContent() );

		if ( !$target ) {
			throw new MWException( "Thread " . $thread->id() . ' purports to be moved, ' .
				'but no redirect found in text (' . $article->getContent() . ') of ' .
				$thread->root()->getTitle()->getPrefixedText() . '. Dying.' );
		}

		$t_thread = Threads::withRoot( new Article( $target ) );

		// Grab data about the new post.
		$author = $thread->author();
		$sig = $linker->userLink( $author->getID(), $author->getName() ) .
			$linker->userToolLinks( $author->getID(), $author->getName() );
		$newTalkpage = is_object( $t_thread ) ? $t_thread->getTitle() : '';

		$html = wfMsgExt( 'lqt_move_placeholder',
			array( 'parseinline', 'replaceafter' ),
			$linker->link( $target ),
			$sig,
			$wgLang->date( $thread->modified() ),
			$wgLang->time( $thread->modified() ),
			$linker->link( $newTalkpage )
		);

		$this->output->addHTML( $html );
	}

	/** Shows a deleted thread. Returns true to show the thread body */
	function showDeletedThread( $thread ) {
		if ( $this->user->isAllowed( 'deletedhistory' ) ) {
			$this->output->addWikiMsg( 'lqt_thread_deleted_for_sysops' );
			return true;
		} else {
			$msg = wfMsgExt( 'lqt_thread_deleted', 'parseinline' );
			$msg = Xml::tags( 'em', null, $msg );
			$msg = Xml::tags( 'p', null, $msg );

			$this->output->addHTML( $msg );
			return false;
		}
	}

	// Shows a single thread, rather than a thread tree.
	function showSingleThread( $thread ) {
		$html = '';

		// If it's a 'moved' thread, show the placeholder
		if ( $thread->type() == Threads::TYPE_MOVED ) {
			$this->showMovedThread( $thread );
			return;
		} elseif ( $thread->type() == Threads::TYPE_DELETED ) {
			$res = $this->showDeletedThread( $thread );

			if ( !$res ) return;
		}

		$this->output->addHTML( $this->threadInfoPanel( $thread ) );

		if ( $thread->summary() ) {
			$html .= $this->getSummary( $thread );
		}

		// Unfortunately, I can't rewrite showRootPost() to pass back HTML
		// as it would involve rewriting EditPage, which I do NOT intend to do.

		$this->output->addHTML( $html );

		$this->showThreadBody( $thread );
	}

	function getMustShowThreads( $threads = array() ) {
		if ( $this->request->getCheck( 'lqt_operand' ) ) {
			$operands = explode( ',', $this->request->getVal( 'lqt_operand' ) );
			$threads = array_merge( $threads, $operands );
		}

		if ( $this->request->getCheck( 'lqt_mustshow' ) ) {
			// Check for must-show in the request
			$specifiedMustShow = $this->request->getVal( 'lqt_mustshow' );
			$specifiedMustShow = explode( ',', $specifiedMustShow );

			$threads = array_merge( $threads, $specifiedMustShow );
		}

		foreach ( $threads as $walk_thread ) {
			do {
				if ( !is_object( $walk_thread ) ) {
					$old_walk_thread = $walk_thread;
					$walk_thread = Threads::withId( $walk_thread );
				}

				if ( !is_object( $walk_thread ) ) {
					continue;
				}

				$threads[$walk_thread->id()] = $walk_thread;
				$walk_thread = $walk_thread->superthread();
			} while ( $walk_thread );
		}

		return $threads;
	}

	function getShowMore( $thread, $st, $i ) {
		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();

		$linkText = wfMsgExt( 'lqt-thread-show-more', 'parseinline' );
		$linkTitle = clone $thread->topmostThread()->title();
		$linkTitle->setFragment( '#' . $st->getAnchorName() );

		$link = $linker->link( $linkTitle, $linkText,
				array( 'class' => 'lqt-show-more-posts' ) );
		$link .= Html::hidden( 'lqt-thread-start-at', $i,
				array( 'class' => 'lqt-thread-start-at' ) );

		return $link;
	}

	function getShowReplies( $thread ) {
		global $wgLang;

		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();

		$replyCount = $wgLang->formatNum( $thread->replyCount() );
		$linkText = wfMsgExt( 'lqt-thread-show-replies', 'parseinline', $replyCount );
		$linkTitle = clone $thread->topmostThread()->title();
		$linkTitle->setFragment( '#' . $thread->getAnchorName() );

		$link = $linker->link( $linkTitle, $linkText,
				array( 'class' => 'lqt-show-replies' ) );
		$link = Xml::tags( 'div', array( 'class' => 'lqt-thread-replies' ), $link );

		return $link;
	}

	static function threadContainsRepliesWithContent( $thread ) {
		$replies = $thread->replies();

		foreach ( $replies as $reply ) {
			$content = '';
			if ( $reply->root() ) $content = $reply->root()->getContent();

			if ( trim( $content ) != '' ) {
				return true;
			}

			if ( self::threadContainsRepliesWithContent( $reply ) ) {
				return true;
			}

			if ( $reply->type() == Threads::TYPE_MOVED ) {
				return true;
			}
		}

		return false;
	}

	function showThreadReplies( $thread, $startAt, $maxCount, $showThreads,
			$cascadeOptions, $interruption = false ) {
		$repliesClass = 'lqt-thread-replies lqt-thread-replies-' .
					$this->threadNestingLevel;

		if ( $interruption ) {
			$repliesClass .= ' lqt-thread-replies-interruption';
		}

		$div = Xml::openElement( 'div', array( 'class' => $repliesClass ) );

		$subthreadCount = count( $thread->subthreads() );
		$i = 0;
		$showCount = 0;
		$showThreads = true;

		$mustShowThreads = $cascadeOptions['mustShowThreads'];

		$replies = $thread->subthreads();
		usort( $replies, array( 'Thread', 'createdSortCallback' ) );

		foreach ( $replies as $st ) {
			++$i;

			// Only show undeleted threads that are above our 'startAt' index.
			$shown = false;
			if ( $st->type() != Threads::TYPE_DELETED &&
					$i >= $startAt &&
					$showThreads ) {
				if ( $showCount > $maxCount && $maxCount > 0 ) {
					// We've shown too many threads.
					$link = $this->getShowMore( $thread, $st, $i );

					$this->output->addHTML( $div . $link );
					$showThreads = false;
					continue;
				}

				++$showCount;
				if ( $showCount == 1 ) {
					// There's a post sep before each reply group to
					//	separate from the parent thread.
					$this->output->addHTML( $div );
				}

				$this->showThread( $st, $i, $subthreadCount, $cascadeOptions );
				$shown = true;
			}

			// Handle must-show threads.
			// FIXME this thread will be duplicated if somebody clicks the
			//	"show more" link (probably needs fixing in the JS)
			if ( $st->type() != Threads::TYPE_DELETED && !$shown &&
					array_key_exists( $st->id(), $mustShowThreads ) ) {

				$this->showThread( $st, $i, $subthreadCount, $cascadeOptions );
			}
		}

		// Show reply stuff
		$this->showReplyBox( $thread );

		$finishDiv = '';
		$finishDiv .= Xml::tags(
			'div',
			array( 'class' => 'lqt-replies-finish' ),
			'&#160;'
		);

		$this->output->addHTML( $finishDiv . Xml::CloseElement( 'div' ) );
	}

	function showThread( $thread, $levelNum = 1, $totalInLevel = 1,
			$options = array() ) {

		// Safeguard
		if ( $thread->type() & Threads::TYPE_DELETED ||
				!$thread->root() ) {
			return;
		}

		$this->threadNestingLevel++;

		// Figure out which threads *need* to be shown because they're involved in an
		//	operation
		$mustShowOption = array();
		if ( isset( $options['mustShowThreads'] ) ) {
			$mustShowOption = $options['mustShowThreads' ];
		}
		$mustShowThreads = $this->getMustShowThreads( $mustShowOption );

		// For cascading.
		$options['mustShowThreads'] = $mustShowThreads;

		// Don't show blank posts unless we have to
		$content = '';
		if ( $thread->root() ) $content = $thread->root()->getContent();

		if (
			trim( $content ) == '' &&
			$thread->type() != Threads::TYPE_MOVED &&
			! self::threadContainsRepliesWithContent( $thread ) &&
			! array_key_exists( $thread->id(), $mustShowThreads )
		) {
			$this->threadNestingLevel--;
			return;
		}

		// Grab options
		if ( isset( $options['maxDepth'] ) ) {
			$maxDepth = $options['maxDepth'];
		} else {
			$maxDepth = $this->user->getOption( 'lqtdisplaydepth' );
		}

		if ( isset( $options['maxCount'] ) ) {
			$maxCount = $options['maxCount'];
		} else {
			$maxCount = $this->user->getOption( 'lqtdisplaycount' );
		}

		if ( isset( $options['startAt'] ) ) {
			$startAt = $options['startAt'];
		} else {
			$startAt = 0;
		}

		// Figure out if we have replies to show or not.
		$showThreads = ( $maxDepth == - 1 ) ||
				( $this->threadNestingLevel <= $maxDepth );
		$mustShowThreadIds = array_keys( $mustShowThreads );
		$subthreadIds = array_keys( $thread->replies() );
		$mustShowSubthreadIds = array_intersect( $mustShowThreadIds, $subthreadIds );

		$hasSubthreads = self::threadContainsRepliesWithContent( $thread );
		$hasSubthreads = $hasSubthreads || count( $mustShowSubthreadIds );
		// Show subthreads if one of the subthreads is on the must-show list
		$showThreads = $showThreads ||
			count( array_intersect(
				array_keys( $mustShowThreads ), array_keys( $thread->replies() )
			) );
		$replyTo = $this->methodAppliesToThread( 'reply', $thread );

		$this->output->addModules( 'ext.liquidThreads' );

		$html = '';
		wfRunHooks( 'EditPageBeforeEditToolbar', array( &$html ) );

		$class = $this->threadDivClass( $thread );
		if ( $levelNum == 1 ) {
			$class .= ' lqt-thread-first';
		} elseif ( $levelNum == $totalInLevel ) {
			$class .= ' lqt-thread-last';
		}

		if ( $hasSubthreads && $showThreads ) {
			$class .= ' lqt-thread-with-subthreads';
		} else {
			$class .= ' lqt-thread-no-subthreads';
		}

		if ( ! $thread->title()->userCan('edit') ) {
			$class .= ' lqt-thread-uneditable';
		}

		$class .= ' lqt-thread-wrapper';

		$html .= Xml::openElement(
			'div',
			array(
				'class' => $class,
				'id' => 'lqt_thread_id_' . $thread->id()
			)
		);

		$html .= Xml::element( 'a', array( 'name' => $this->anchorName( $thread ) ), ' ' );
		$html .= $this->showThreadHeading( $thread );

		// Metadata stuck in the top of the lqt_thread div.
		// Modified time for topmost threads...
		if ( $thread->isTopmostThread() ) {
			$html .= Html::hidden(
				'lqt-thread-modified-' . $thread->id(),
				wfTimestamp( TS_MW, $thread->modified() ),
				array(
					'id' => 'lqt-thread-modified-' . $thread->id(),
					'class' => 'lqt-thread-modified'
				)
			);
			$html .= Html::hidden(
				'lqt-thread-sortkey',
				$thread->sortkey(),
				array( 'id' => 'lqt-thread-sortkey-' . $thread->id() )
			);

			$html .= Html::hidden(
				'lqt-thread-talkpage-' . $thread->id(),
				$thread->article()->getTitle()->getPrefixedText(),
				array(
					'class' => 'lqt-thread-talkpage-metadata',
				)
			);
		}

		if ( ! $thread->title() ) {
			throw new MWException( "Thread " . $thread->id() . " has null title" );
		}

		// Add the thread's title
		$html .= Html::hidden(
			'lqt-thread-title-' . $thread->id(),
			$thread->title()->getPrefixedText(),
			array(
				'id' => 'lqt-thread-title-' . $thread->id(),
				'class' => 'lqt-thread-title-metadata'
			)
		);

		// Flush output to display thread
		$this->output->addHTML( $html );
		$this->output->addHTML( Xml::openElement( 'div',
					array( 'class' => 'lqt-post-wrapper' ) ) );
		$this->showSingleThread( $thread );
		$this->output->addHTML( Xml::closeElement( 'div' ) );

		$cascadeOptions = $options;
		unset( $cascadeOptions['startAt'] );

		$replyInterruption = $levelNum < $totalInLevel;

		if ( ( $hasSubthreads && $showThreads ) ) {
			// If the thread has subthreads, and we want to show them, we should do so.
			$this->showThreadReplies( $thread, $startAt, $maxCount, $showThreads,
				$cascadeOptions, $replyInterruption );
		} elseif ( $hasSubthreads && !$showThreads ) {
			// If the thread has subthreads, but we don't want to show them, then
			//	show the reply form if necessary, and add the "Show X replies" link.
			if ( $replyTo ) {
				$this->showReplyForm( $thread );
			}

			// Add a "show subthreads" link.
			$link = $this->getShowReplies( $thread );

			$this->output->addHTML( $link );

			if ( $levelNum < $totalInLevel ) {
				$this->output->addHTML(
					Xml::tags( 'div', array( 'class' => 'lqt-post-sep' ), '&#160;' ) );
			}
		} elseif ( $levelNum < $totalInLevel ) {
			// If we have no replies, and we're not at the end of this level, add the post separator
			//	and a reply box if necessary.
			$this->output->addHTML(
				Xml::tags( 'div', array( 'class' => 'lqt-post-sep' ), '&#160;' ) );

			if ( $replyTo ) {
				$class = 'lqt-thread-replies lqt-thread-replies-' .
						$this->threadNestingLevel;
				$html = Xml::openElement( 'div', array( 'class' => $class ) );
				$this->output->addHTML( $html );

				$this->showReplyForm( $thread );

				$finishDiv = Xml::tags( 'div',
						array( 'class' => 'lqt-replies-finish' ),
						'&#160;' );
				// Layout plus close div.lqt-thread-replies

				$finishHTML = Xml::closeElement( 'div' ); // lqt-reply-form
				$finishHTML .= $finishDiv; // Layout
				$finishHTML .= Xml::closeElement( 'div' ); // lqt-thread-replies
				$this->output->addHTML( $finishHTML );
			}
		} elseif ( !$hasSubthreads && $replyTo ) {
			// If we have no replies, we're at the end of this level, and we want to reply,
			//	show the reply box.
			$class = 'lqt-thread-replies lqt-thread-replies-' .
					$this->threadNestingLevel;
			$html = Xml::openElement( 'div', array( 'class' => $class ) );
			$this->output->addHTML( $html );

			$this->showReplyForm( $thread );

			$html = Xml::tags( 'div',
					array( 'class' => 'lqt-replies-finish' ),
					Xml::tags( 'div',
						array( 'class' =>
							'lqt-replies-finish-corner'
						), '&#160;' ) );
			$html .= Xml::closeElement( 'div' );
			$this->output->addHTML( $html );
		}

		// I don't remember why this is here, commenting out.
//		if ( $this->threadNestingLevel == 1 ) {
//			if ( !( $hasSubthreads && $showThreads && !$replyTo ) ) {
//				$this->showReplyBox( $thread );
//				$finishDiv = '';
//				$finishDiv .= Xml::tags( 'div', array( 'class' => 'lqt-replies-finish' ),
//					Xml::tags( 'div', array( 'class' => 'lqt-replies-finish-corner' ), '&#160;' ) );
//
//				$this->output->addHTML( $finishDiv );
//			}
//		}

		$this->output->addHTML( Xml::closeElement( 'div' ) );

		$this->threadNestingLevel--;
	}

	function showReplyBox( $thread ) {
		// Check if we're actually replying to this thread.
		if ( $this->methodAppliesToThread( 'reply', $thread ) ) {
			$this->showReplyForm( $thread );
			return;
		} elseif ( !$thread->canUserReply( $this->user ) ) {
			return;
		}

		$html = '';
		$html .= Xml::tags( 'div',
				array( 'class' => 'lqt-reply-form lqt-edit-form',
					'style' => 'display: none;'	 ),
				'' );

		$this->output->addHTML( $html );
	}

	function threadDivClass( $thread ) {
		$levelClass = 'lqt-thread-nest-' . $this->threadNestingLevel;
		$alternatingType = ( $this->threadNestingLevel % 2 ) ? 'odd' : 'even';
		$alternatingClass = "lqt-thread-$alternatingType";
		$topmostClass = $thread->isTopmostThread() ? ' lqt-thread-topmost' : '';

		return "lqt_thread $levelClass $alternatingClass$topmostClass";
	}

	function getSummary( $t ) {
		if ( !$t->summary() ) {
			return;
		}
		if ( !$t->summary()->getContent() ) {
			return; // Blank summary
		}
		
		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();

		$label = wfMsgExt( 'lqt_summary_label', 'parseinline' );
		$edit_text = wfMsgExt( 'edit', 'parseinline' );
		$link_text = wfMsg( 'lqt_permalink', 'parseinline' );

		$html = '';

		$html .= Xml::tags(
			'span',
			array( 'class' => 'lqt_thread_permalink_summary_title' ),
			$label
		);

		$link = $linker->link( $t->summary()->getTitle(), $link_text,
				array( 'class' => 'lqt-summary-link' ) );
		$link .= Html::hidden( 'summary-title', $t->summary()->getTitle()->getPrefixedText() );
		$edit_link = self::permalink( $t, $edit_text, 'summarize', $t->id() );
		$links = "[$link]\n[$edit_link]";
		$html .= Xml::tags(
			'span',
			array( 'class' => 'lqt_thread_permalink_summary_actions' ),
			$links
		);

		$summary_body = $this->showPostBody( $t->summary() );
		$html .= Xml::tags(
			'div',
			array( 'class' => 'lqt_thread_permalink_summary_body' ),
			$summary_body
		);

		$html = Xml::tags(
			'div',
			array( 'class' => 'lqt_thread_permalink_summary' ),
			$html
		);

		return $html;
	}

	function showSummary( $t ) {
		$this->output->addHTML( $this->getSummary( $t ) );
	}

	function getSignature( $user ) {
		if ( is_object( $user ) ) {
			$uid = $user->getId();
			$name = $user->getName();
		} elseif ( is_integer( $user ) ) {
			$uid = $user;
			$user = User::newFromId( $uid );
			$name = $user->getName();
		} else {
			$user = User::newFromName( $user );
			$name = $user->getName();
			$uid = $user->getId();
		}

		if ( $this->user->getOption( 'lqtcustomsignatures' ) ) {
			return $this->getUserSignature( $user, $uid, $name );
		} else {
			return $this->getBoringSignature( $user, $uid, $name );
		}
	}

	static function getUserSignature( $user, $uid = null ) {
		global $wgParser;
		if ( !$user ) {
			$user = User::newFromId( $uid );
		}

		$wgParser->Options( new ParserOptions );

		$sig = $wgParser->getUserSig( $user );

		return $sig;
	}

	static function parseSignature( $sig ) {
		global $wgOut;

		static $parseCache = array();
		$sigKey = md5( $sig );

		if ( isset( $parseCache[$sigKey] ) ) {
			return $parseCache[$sigKey];
		}

		$sig = $wgOut->parseInline( $sig );

		$parseCache[$sigKey] = $sig;

		return $sig;
	}

	static function signaturePST( $sig, $user ) {
		global $wgParser, $wgTitle;

		$title = $wgTitle ? $wgTitle : $user->getUserPage();

		$sig = $wgParser->preSaveTransform(
			$sig,
			$title,
			$user,
			new ParserOptions,
			true
		);

		return $sig;
	}

	function customizeTabs( $skin, &$links ) {
		// No-op
	}

	function customizeNavigation( $skin, &$links ) {
		// No-op
	}

	function show() {
		return true; // No-op
	}

	// Copy-and-modify of Linker::formatComment
	static function formatSubject( $s ) {
		wfProfileIn( __METHOD__ );
		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();

		# Sanitize text a bit:
		$s = str_replace( "\n", " ", $s );
		# Allow HTML entities
		$s = Sanitizer::escapeHtmlAllowEntities( $s );

		# Render links:
		$s = $linker->formatLinksInComment( $s, null, false );

		wfProfileOut( __METHOD__ );
		return $s;
	}
}

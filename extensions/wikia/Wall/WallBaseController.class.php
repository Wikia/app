<?php

/**
 * A class which represents a user wall. A Wall is a replacement for the main part of the User_talk page.
 * A Wall consists of "Bricks" which are each a single topic/thread/conversation.
 * In typical use, a Wall will only load a subset of Bricks because there will be a TON of bricks as time goes on.
 */
class WallBaseController extends WikiaService {
	const WALL_MESSAGE_RELATIVE_TIMESTAMP = 604800; // relative message timestamp for 7 days (improvement 20178)
	const DEFAULT_MESSAGES_PER_PAGE = 10; // how many messages should appear per page if not specified otherwise
	protected $helper;
	// use for controlling if we are not adding the some css/js head two time
	static $uniqueHead = [ ];

	public function __construct() {
		parent::__construct();
		$this->helper = new WallHelper();
	}

	public function addAsset() {
		JSMessages::enqueuePackage( 'Wall', JSMessages::EXTERNAL );

		$this->response->addAsset( 'wall_topic_js' );    // need to load on thread only
		$this->response->addAsset( 'wall_js' );
		$this->response->addAsset( 'extensions/wikia/Wall/css/Wall.scss' );
		$this->response->addAsset( 'extensions/wikia/Wall/css/MessageTopic.scss' );    // need to load on thread only

		// Load MiniEditor assets, if enabled
		if ( $this->wg->EnableMiniEditorExtForWall ) {
			$this->sendRequest( 'MiniEditor', 'loadAssets', [
				'additionalAssets' => [
					'wall_mini_editor_js',
					'extensions/wikia/MiniEditor/css/Wall/Wall.scss'
				]
			] );
		}
	}

	public function thread() {
		wfProfileIn( __METHOD__ );

		$context = $this->getContext();

		$this->addAsset();

		$id = $this->request->getVal( 'id', null );

		$wallThread = WallThread::newFromId( $id );
		$wallThread->loadIfCached();

		$threadMainMsg = $wallThread->getThreadMainMsg();

		$this->response->setVal( 'thread', $wallThread );
		$this->response->setVal( 'threadMainMsg', $threadMainMsg );

		$this->response->setVal( 'showNewMessage', false );
		$this->response->setVal( 'type', 'Thread' );
		$this->response->setVal( 'condenseMessage', false );

		$user = $context->getUser();
		// SUS-3281: Only mark wall notifications as read for logged in user
		if ( $user->isLoggedIn() ) {
			global $wgCityId;
			( new WallNotifications() )->markRead( $user->getId(), $wgCityId, $id );
		}

		$this->response->setVal( 'renderUserTalkArchiveAnchor', false );
		$this->response->setVal( 'greeting', '' );

		if ( $threadMainMsg ) {
			$threadMainMsg->load();
			$context->getOutput()->setPageTitle( $threadMainMsg->getMetaTitle() );
		}

		// TODO: keep the varnish cache and do purging on post (+1)
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );

		wfProfileOut( __METHOD__ );
	}

	public function index( $wallMessagesPerPage = null ) {
		wfProfileIn( __METHOD__ );

		$this->addAsset();

		$title = $this->request->getVal( 'title', $this->app->wg->Title );
		$page = $this->request->getVal( 'page', 1 );

		/* for some reason nirvana passes null to this function we need to force default value */
		if ( empty( $wallMessagesPerPage ) ) {
			$wallMessagesPerPage = self::DEFAULT_MESSAGES_PER_PAGE;
		}

		/* @var Wall wall */
		$wall = $this->getWallForIndexPage( $title );
		$wall->setMaxPerPage( $wallMessagesPerPage );
		$wall->setSorting( $this->getSortingSelected() );

		$threads = $wall->getThreads( $page );
		$countComments = $wall->getThreadCount();

		$renderUserTalkArchiveAnchor = $this->request->getVal( 'dontRenderUserTalkArchiveAnchor', false ) != true;

		$this->response->setVal( 'type', 'Board' );
		$this->response->setVal( 'showNewMessage', true );
		$this->response->setVal( 'condenseMessage', true );

		$this->response->setVal( 'wall', $wall );
		$this->response->setVal( 'threads', $threads );
		$this->response->setVal( 'renderUserTalkArchiveAnchor', $renderUserTalkArchiveAnchor );
		$this->response->setVal( 'greeting', $this->getGreetingText( $title ) );
		$this->response->setVal( 'sortingOptions', $this->getSortingOptions() );
		$this->response->setVal( 'sortingSelected', $this->getSortingSelectedText() );
		$this->response->setVal( 'title', $this->wg->Title );
		$this->response->setVal( 'countComments', $countComments );
		$this->response->setVal( 'totalItems', $countComments );
		$this->response->setVal( 'itemsPerPage', $wallMessagesPerPage );
		$this->response->setVal( 'showPager', ( $countComments > $wallMessagesPerPage ) );
		$this->response->setVal( 'currentPage', $page );

		Transaction::setSizeCategoryByDistributionOffset( $countComments, 0, self::DEFAULT_MESSAGES_PER_PAGE );

		// TODO: keep the varnish cache and do purging on post
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );

		wfProfileOut( __METHOD__ );
	}

	public function reply() {
		if ( self::shouldHideIfForumReadOnly() ) {
			$this->request->setVal( 'showReplyForm', false );
		}
		$this->response->setVal( 'username', $this->wg->User->getName() );
		$this->response->setVal( 'showReplyForm', $this->request->getVal( 'showReplyForm', true ) );
		$this->checkAndSetUserBlockedStatus( $this->helper->getUser() );
	}

	public function messageButtons() {
		$wallMessage = $this->getWallMessage();
		$showIfForum = !self::shouldHideIfForumReadOnly();
		$canEdit = $showIfForum && $wallMessage->canEdit( $this->wg->User, false );
		$canDelete = $showIfForum && $wallMessage->canDelete( $this->wg->User, false );
		$canAdminDelete = $showIfForum && $wallMessage->canAdminDelete( $this->wg->User, false ) && $wallMessage->isRemove();
		$canFastAdminDelete = $showIfForum && $wallMessage->canFastAdminDelete( $this->wg->User, false );
		$canRemove = $showIfForum && $wallMessage->canRemove( $this->wg->User, false ) && !$wallMessage->isRemove();
		$canArchive = $showIfForum && $wallMessage->canArchive( $this->wg->User, false );
		$canReopen = $showIfForum && $wallMessage->canReopen( $this->wg->User, false );
		$canMove = $showIfForum && $wallMessage->canMove( $this->wg->User, false );
		$canQuote = $showIfForum;

		$this->response->setVal( 'canEdit', $canEdit );
		$this->response->setVal( 'canDelete', $canDelete );
		$this->response->setVal( 'canAdminDelete', $canAdminDelete );
		$this->response->setVal( 'canFastAdminDelete', $canFastAdminDelete );
		$this->response->setVal( 'canRemove', $canRemove );
		$this->response->setVal( 'canClose', $canArchive );
		$this->response->setVal( 'canReopen', $canReopen );
		$this->response->setVal( 'showViewSource', $this->wg->User->getGlobalPreference( 'wallshowsource', false ) );
		$this->response->setVal( 'threadHistoryLink', $wallMessage->getMessagePageUrl( true ) . '?action=history' );
		$this->response->setVal( 'wgBlankImgUrl', $this->wg->BlankImgUrl );
		$this->response->setVal( 'isRemoved', $wallMessage->isRemove() );
		$this->response->setVal( 'isAnon', $this->wg->User->isAnon() );
		$this->response->setVal( 'canMove', $canMove );
		$this->response->setVal( 'canQuote', $canQuote );

		$wallThread = $wallMessage;
		if ( !$wallMessage->isMain() ) {
			$wallThread = $wallMessage->getTopParentObj();
		}
		$this->response->setVal( 'isClosed', $wallThread->isArchive() );
	}

	public function message() {
		wfProfileIn( __METHOD__ );

		$wallMessage = $this->getWallMessage();

		if ( !( $wallMessage instanceof WallMessage ) || !WallMessage::isWallMessage( $wallMessage->getTitle() ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$head = '';

		/**
		 * Some of the wiki text returns also style and script
		 * let's take this items and add them to text
		 */
		foreach ( $wallMessage->getHeadItems() as $key => $val ) {
			if ( empty( self::$uniqueHead[ $key ] ) ) {
				$head .= $val;
				self::$uniqueHead[ $key ] = true;
			}
		}

		$this->response->setVal( 'head', $head );
		$this->response->setVal( 'comment', $wallMessage );
		$this->response->setVal( 'collapsed', false );
		$this->response->setVal( 'showReplyForm', false );
		$this->response->setVal( 'removedOrDeletedMessage', false );


		$isThreadPage = $this->request->getVal( 'isThreadPage', false );

		$this->response->setVal( 'showDeleteOrRemoveInfo', $isThreadPage );
		$this->response->setVal( 'showClosedBox', $wallMessage->isArchive() & !$isThreadPage );

		if ( !$this->getVal( 'isreply', false ) ) {
			$this->response->setVal( 'feedtitle', htmlspecialchars( $wallMessage->getMetaTitle() ) );
			$this->response->setVal( 'body', $wallMessage->getText() );
			$this->response->setVal( 'isreply', false );
			$this->response->setVal( 'isThreadPage', $isThreadPage );

			$wallMaxReplies = 4;
			if ( !empty( $this->app->wg->WallMaxReplies ) ) {
				$wallMaxReplies = $this->app->wg->WallMaxReplies;
			}

			$replies = $this->getVal( 'replies', [ ] );
			$repliesCount = count( $replies );
			$this->response->setVal( 'repliesNumber', $repliesCount );
			$this->response->setVal( 'repliesLimit', WallThread::FETCHED_REPLIES_LIMIT );
			$this->response->setVal( 'showRepliesNumber', $repliesCount );
			$this->response->setVal( 'showLoadMore', false );

			if ( $this->request->getVal( 'condense', true ) && $repliesCount > $wallMaxReplies ) {
				$this->response->setVal( 'showRepliesNumber', $wallMaxReplies - 2 );
				$this->response->setVal( 'showLoadMore', true );
			}
			$this->response->setVal( 'isWatched', $wallMessage->isWatched( $this->wg->User ) || $this->request->getVal( 'new', false ) );
			$this->response->setVal( 'replies', $replies );

			$this->response->setVal( 'linkid', '1' );

			$this->response->setVal( 'showReplyForm', ( !$wallMessage->isRemove() && !$wallMessage->isAdminDelete() && !$wallMessage->isArchive() ) );

			$this->response->setVal( 'relatedTopics', $wallMessage->getRelatedTopics() );
		} else {
			$showFrom = $this->request->getVal( 'repliesNumber', 0 ) - $this->request->getVal( 'showRepliesNumber', 0 );
			// $current = $this->request->getVal('current', false);
			if ( $showFrom > $this->request->getVal( 'current' ) ) {
				$this->response->setVal( 'collapsed', true );
			}

			$this->response->setVal( 'body', $wallMessage->getText() );
			$this->response->setVal( 'isreply', true );
			$this->response->setVal( 'replies', false );

			$this->response->setVal( 'linkid', $wallMessage->getPageUrlPostFix() );
		}

		$this->response->setVal( 'id', $wallMessage->getId() );

		if ( $wallMessage->isEdited() ) {
			if ( time() - $wallMessage->getEditTime( TS_UNIX ) < self::WALL_MESSAGE_RELATIVE_TIMESTAMP ) {
				$this->response->setVal( 'iso_timestamp', $wallMessage->getEditTime( TS_ISO_8601 ) );
			} else {
				$this->response->setVal( 'iso_timestamp', null );
			}
			$this->response->setVal( 'fmt_timestamp', $this->wg->Lang->timeanddate( $wallMessage->getEditTime( TS_MW ) ) );
			$this->response->setVal( 'showEditedTS', true );
			$editorName = $wallMessage->getEditor()->getName();
			$this->response->setVal( 'editorName', $editorName );
			$editorUrl = Title::newFromText( $editorName, $this->wg->EnableWallExt ? NS_USER_WALL : NS_USER_TALK )->getFullUrl();
			$this->response->setVal( 'editorUrl', $editorUrl );
			$this->response->setVal( 'isEdited', true );

			$query = [
				'diff' => 'prev',
				'oldid' => $wallMessage->getTitle()->getLatestRevID(),
			];

			$this->response->setVal( 'historyUrl', $wallMessage->getTitle()->getFullUrl( $query ) );
		} else {
			$this->response->setVal( 'showEditedTS', false );
			if ( time() - $wallMessage->getEditTime( TS_UNIX ) < self::WALL_MESSAGE_RELATIVE_TIMESTAMP ) {
				$this->response->setVal( 'iso_timestamp', $wallMessage->getCreatTime( TS_ISO_8601 ) );
			} else {
				$this->response->setVal( 'iso_timestamp', null );
			}
			$this->response->setVal( 'fmt_timestamp', $this->wg->Lang->timeanddate( $wallMessage->getCreatTime( TS_MW ) ) );
			$this->response->setVal( 'isEdited', false );
		}


		$this->response->setVal( 'fullpageurl', $wallMessage->getMessagePageUrl() );
		$this->response->setVal( 'wgBlankImgUrl', $this->wg->BlankImgUrl );

		$this->response->setVal( 'id', $wallMessage->getId() );

		if ( $this->wg->User->getId() > 0 && !$wallMessage->isWallOwner( $this->wg->User ) ) {
			$this->response->setVal( 'showFollowButton', !self::shouldHideIfForumReadOnly() );
		} else {
			$this->response->setVal( 'showFollowButton', false );
		}

		if ( $wallMessage->isRemove() && !$wallMessage->isMain() ) {
			$this->response->setVal( 'removedOrDeletedMessage', true );
		}


		$name = $wallMessage->getUser()->getName();

		$this->response->setVal( 'isStaff', $wallMessage->showWikiaEmblem() );
		$this->response->setVal( 'username', $name );

		$displayname = $wallMessage->getUserDisplayName();
		$displayname2 = '';

		$url = $wallMessage->getUserWallUrl();

		if ( $wallMessage->getUser()->getId() == 0 ) { // anonymous contributor
			$displayname2 = $wallMessage->getUser()->getName();
		}

		$this->response->setVal( 'displayname', $displayname );
		$this->response->setVal( 'displayname2', $displayname2 );

		if ( $wallMessage->showVotes() ) {
			$this->response->setVal( 'showVotes', true );
			$this->response->setVal( 'votes', $wallMessage->getVoteCount() );
			$this->response->setVal( 'isVoted', $wallMessage->isVoted() );
			$canVotes = !self::shouldHideIfForumReadOnly() && ( $wallMessage->canVotes( $this->wg->User ) ||
																!$this->wg->User->isLoggedIn() );
			$this->response->setVal( 'canVotes', $canVotes );
		} else {
			$this->response->setVal( 'showVotes', false );
		}

		$this->response->setVal( 'showTopics', $wallMessage->showTopics() );
		$this->response->setVal( 'showEditTopics', !self::shouldHideIfForumReadOnly() );

		$this->response->setVal( 'user_author_url', $url );

		$this->response->setVal( 'quote_of', false );

		$quoteOf = $wallMessage->getQuoteOf();

		if ( !empty( $quoteOf ) ) {
			$this->response->setVal( 'quote_of', true );
			$this->response->setVal( 'quote_of_url', $quoteOf->getMessagePageUrl() );

			$postfix = $quoteOf->getPageUrlPostFix();
			if ( empty( $postfix ) ) {
				$postfix = 1;
			}

			$this->response->setVal( 'quote_of_postfix', $postfix );
		}

		wfProfileOut( __METHOD__ );
	}

	public function statusInfoBox() {
		$wallMessage = $this->getWallMessage();
		$this->response->setVal( 'statusInfo', false );

		if ( !$this->request->getVal( 'showDeleteOrRemoveInfo', false ) ) {
			return true;
		}

		$showRemoveOrDeleteInfo = $wallMessage->isRemove() || $wallMessage->isAdminDelete();
		$showArchiveInfo = !$showRemoveOrDeleteInfo && $wallMessage->isArchive();

		if ( $showRemoveOrDeleteInfo || $showArchiveInfo ) {
			$info = $wallMessage->getLastActionReason();

			if ( !empty( $info ) ) {
				$info[ 'fmttime' ] = $this->wg->Lang->timeanddate( $info[ 'mwtime' ] );
				$this->response->setVal( 'statusInfo', $info );
				$this->response->setVal( 'id', $wallMessage->getId() );
				if ( $showRemoveOrDeleteInfo ) {
					$this->response->setVal( 'canRestore', $wallMessage->canRestore( $this->app->wg->User, false ) );
					$this->response->setVal( 'fastrestore', $wallMessage->canFastRestore( $this->app->wg->User, false ) );
					$this->response->setVal( 'isreply', !$wallMessage->isMain() );
				}
			}
		}

		$this->response->setVal( 'showRemoveOrDeleteInfo', $showRemoveOrDeleteInfo );
		$this->response->setVal( 'showArchiveInfo', $showArchiveInfo );
	}

	protected function getWallMessage() {
		$comment = $this->request->getVal( 'comment' );

		if ( $comment instanceof ArticleComment ) {
			$wallMessage = WallMessage::newFromArticleComment( $comment );
			$wallMessage->load();

			return $wallMessage;
		}

		if ( $comment instanceof WallMessage ) {
			$comment->load();

			return $comment;
		}

		return $comment;
	}

	public function getWallForIndexPage( $title ) {
		$wall = Wall::newFromTitle( ( $title ) );
		return $wall;
	}


	protected function getSortingOptions() {
		$title = $this->request->getVal( 'title', $this->app->wg->Title );

		$output = [ ];
		$selected = $this->getSortingSelected();

		// $id's are names of DOM elements' classes
		// which are needed to click tracking
		// if you change them here, do so in Wall.js file, please
		foreach ( $this->getSortingOptionsText() as $id => $option ) {
			if ( $this->sortingType === 'history' ) {
				$href = $title->getFullURL( [ 'action' => 'history', 'sort' => $id ] );
			} else {
				$href = $title->getFullURL( [ 'sort' => $id ] );
			}

			if ( $id == $selected ) {
				$output[] = [ 'id' => $id, 'text' => $option, 'href' => $href, 'selected' => true ];
			} else {
				$output[] = [ 'id' => $id, 'text' => $option, 'href' => $href ];
			}
		}

		return $output;
	}

	protected function getSortingSelected() {
		$selected = $this->wg->request->getVal( 'sort' );

		if ( empty( $selected ) ) {
			$selected = $this->app->wg->User->getGlobalPreference( 'wall_sort_' . $this->sortingType );
		} else {
			$selectedDB = $this->app->wg->User->getGlobalPreference( 'wall_sort_' . $this->sortingType );

			if ( $selectedDB != $selected ) {
				$this->app->wg->User->setGlobalPreference( 'wall_sort_' . $this->sortingType, $selected );
				$this->app->wg->User->saveSettings();
			}
		}

		if ( empty( $selected ) || !array_key_exists( $selected, $this->getSortingOptionsText() ) ) {
			$selected = ( $this->sortingType === 'history' ) ? 'of' : 'nt';
		}

		return $selected;
	}

	protected function getSortingOptionsText() {
		switch ( $this->sortingType ) {
			case 'history':
				// keys of sorting array are names of DOM elements' classes
				// which are needed to click tracking
				// if you change those keys here, do so in Wall.js file, please
				$options = [
					'nf' => wfMessage( 'wall-history-sorting-newest-first' )->escaped(),
					'of' => wfMessage( 'wall-history-sorting-oldest-first' )->escaped(),
				];
				break;
			case 'index':
			default:
				$options = [
					'nt' => wfMessage( 'wall-sorting-newest-threads' )->escaped(),
					'ot' => wfMessage( 'wall-sorting-oldest-threads' )->escaped(),
					'nr' => wfMessage( 'wall-sorting-newest-replies' )->escaped(),
					// 'ma' => wfMessage( 'wall-sorting-most-active' )->escaped(),
					// 'a' => wfMessage( 'wall-sorting-archived' )->escaped()
				];
				break;
		}

		return $options;
	}

	protected function getSortingSelectedText() {
		$selected = $this->getSortingSelected();
		$options = $this->getSortingOptionsText();
		return $options[ $selected ];
	}

	public function brickHeader() {

		$this->wg->SuppressPageTitle = true;

		$this->response->setVal( 'isRemoved', false );
		$this->response->setVal( 'isAdminDeleted', false );

		$this->response->setVal( 'isClosed', false );

		$path = [ ];
		$this->response->setVal( 'path', $path );
		$this->response->setVal( 'className', $this->request->getVal( 'className' ) );

		$title = Title::newFromId( $this->request->getVal( 'id' ) );
		if ( empty( $title ) ) {
			$title = Title::newFromID( $this->request->getVal( 'id' ), Title::GAID_FOR_UPDATE );
		}

		if ( !empty( $title ) && $title->isTalkPage() ) {
			$wallMessage = WallMessage::newFromTitle( $title );

			$wallMessageParent = $wallMessage->getTopParentObj();
			if ( !empty( $wallMessageParent ) ) {
				$wallMessage = $wallMessageParent;
			}

			$wallMessage->load();

			if ( $wallMessage->isWallOwner( $this->wg->User ) ) {
				$wallName = wfMessage( 'wall-message-mywall' )->escaped();
			} else {

				$wallOwner = $wallMessage->getWallOwner()->getName();

				$wallName = wfMessage( 'wall-message-elseswall', $wallOwner )->text();
			}

			$wallUrl = $wallMessage->getWallUrl();

			$messageTitle = htmlspecialchars( $wallMessage->getMetaTitle() );
			$isRemoved = $wallMessage->isRemove();
			$isDeleted = $wallMessage->isAdminDelete();
			$this->response->setVal( 'isRemoved', $isRemoved );
			$this->response->setVal( 'isAdminDeleted', $isDeleted );

			$this->response->setVal( 'isClosed', $wallMessage->isArchive() );


			if ( $isRemoved || $isDeleted ) {
				$this->wg->Out->setRobotPolicy( "noindex,nofollow" );
			}

			$user = $this->app->wg->User;
			// remove admin notification for it if Admin just checked it
			if ( in_array( 'sysop', $user->getEffectiveGroups() ) ||
				in_array( 'staff', $user->getEffectiveGroups() )
			) {
				$wna = new WallNotificationsAdmin;
				$wna->removeForThread( $this->app->wg->CityId, $wallMessage->getId() );
			}

			$wno = new WallNotificationsOwner;
			$wno->removeForThread( $this->app->wg->CityId, $user->getId(), $wallMessage->getId() );

			$path[] = [
				'title' => $wallName,
				'url' => $wallUrl
			];

			$path[] = [
				'title' => $messageTitle
			];

			$this->getContext()->getOutput()->setRobotPolicy( 'index,follow' );

			Hooks::run( 'WallThreadHeader', [ $title, $wallMessage, &$path, &$this->response, &$this->request ] );
		} else {
			Hooks::run( 'WallHeader', [ $this->wg->Title, &$path, &$this->response, &$this->request ] );
		}
		$this->response->setVal( 'path', $path );
	}

	public function newMessage() {
		$user = $this->helper->getUser();
		$wallUsername = $user->getName();

		$username = $this->wg->User->getName();
		$this->response->setVal( 'username', $username );
		$this->response->setVal( 'wall_username', $wallUsername );

		Hooks::run( 'WallNewMessage', [ $this->wg->Title, &$this->response ] );

		$wall_message = $this->response->getVal( 'wall_message' );
		if ( empty( $wall_message ) ) {
			$wall_message = User::isIP( $wallUsername ) ? wfMessage( 'wall-placeholder-message-anon' )->escaped() : wfMessage( 'wall-placeholder-message', $wallUsername )->escaped();
			$this->response->setVal( 'wall_message', $wall_message );
		}

		$this->response->setVal( 'showMiniEditor', $this->wg->EnableMiniEditorExtForWall );

		$this->checkAndSetUserBlockedStatus( $user );
	}

	/** @param User $wallOwner */
	protected function checkAndSetUserBlockedStatus( $wallOwner = null ) {
		$user = $this->app->wg->User;

		if ( $user->isBlocked( true, false ) || $user->isBlockedGlobally() ) {
			if ( !empty( $wallOwner ) &&
				$wallOwner->getName() == $this->wg->User->getName() &&
				!( empty( $user->mAllowUsertalk ) )
			) {
				// user is blocked, but this is his wall and he was not blocked
				// from user talk page
				$this->response->setVal( 'userBlocked', false );
			} else {
				$this->response->setVal( 'userBlocked', true );
			}
		} else {
			$this->response->setVal( 'userBlocked', false );
		}

	}

	/**
	 * @param Title $title
	 * @return string
	 * @throws MWException
	 */
	private function getGreetingText( Title $title ) {
		$greeting = Title::newFromText( $title->getText(), NS_USER_WALL_MESSAGE_GREETING );
		$greetingText = '';

		if ( !empty( $greeting ) && $greeting->exists() ) {
			$article = new Article( $greeting );
			$article->getParserOptions();
			$article->mParserOptions->setIsPreview( true ); // create parser option
			$article->mParserOptions->setEditSection( false );
			$greetingText = $article->getParserOutput()->getText();
		}

		return $greetingText;
	}

	private function shouldHideIfForumReadOnly() {
		return $this->wg->HideForumForms && ForumHelper::isForum();
	}
} // end class Wall

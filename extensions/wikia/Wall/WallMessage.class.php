<?php

/* smart proxy to article comment */

use Wikia\Logger\WikiaLogger;

class WallMessage {
	use \Wikia\Logger\Loggable;

	protected $articleComment;
	protected $title;
	protected $order = 0;
	protected $isLoaded = false;
	protected $propsCache = [ ];
	protected $cityId = 0;
	protected static $permissionsCache = [ ]; // permissions cache
	protected static $wallURLCache = [ ];

	protected static $wallMessageCache = [];
	protected static $titleCache = [];
	protected static $emptyTitle;

	/**
	 * @var $commentsIndex CommentsIndexEntry
	 */
	public $commentsIndex = false;
	/**
	 * @var $helper WallHelper
	 */
	public $helper;

	/**
	 * @var $mActionReason array
	 */
	public $mActionReason;

	function __construct( Title $title, $articleComment = null ) {
		wfProfileIn( __METHOD__ );
		$this->title = $title;
		$this->articleComment = $articleComment;
		$app = F::App();
		// TODO: inject this
		$this->cityId = $app->wg->CityId;

		$this->helper = new WallHelper();
		wfProfileOut( __METHOD__ );
	}

	static public function emptyTitle(): Title {
		return static::$emptyTitle ?? ( static::$emptyTitle = Title::newFromText( 'empty' ));
	}

	/**
	 * @param int $id
	 * @param bool $master
	 * @return null|WallMessage
	 */
	static public function newFromId( int $id, $master = false ) {

		// WallMessage::getTopParentObj may call this method with $id set to zero
		if ( $id === 0 ) {
			return null;
		}

		// use in-memory cache
		if ( !empty( self::$wallMessageCache[$id] ) ) {
			return self::$wallMessageCache[$id];
		}

		wfProfileIn( __METHOD__ );

		$title = Title::newFromID( $id, $master == true ? Title::GAID_FOR_UPDATE : 0 );

		if ( $title instanceof Title && $title->exists() && self::isWallMessage( $title ) ) {
			wfProfileOut( __METHOD__ );
			return self::$wallMessageCache[$id] = WallMessage::newFromTitle( $title );
		}

		if ( $master == false ) {
			// TODO: instead of relying on fallback to master let's implement a proper wfWaitForSlaves() use
			WikiaLogger::instance()->warning( __METHOD__ . ' - newFromId failed for slave, trying master', [
				'titleId' => $id
			] );

			wfProfileOut( __METHOD__ );
			// if you fail from slave try again from master
			return self::$wallMessageCache[$id] = self::newFromId( $id, true );
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

	/**
	 * @param int[] $ids
	 * @return WallMessage[]
	 */
	static public function newFromIds( Array $ids ) {
		wfProfileIn( __METHOD__ );

		$titles = Title::newFromIDs( $ids );

		/* @var WallMessage[] $wallMessages */
		$wallMessages = [ ];
		$correctIds = [ ];

		//double check if all titles are correct
		foreach ( $titles as $title ) {
			if ( $title->exists() && self::isWallMessage( $title ) ) {
				$wallMessages[ $title->getArticleID() ] = WallMessage::newFromTitle( $title );
				$correctIds[] = $title->getArticleID();
			}
		}

		/**
		 * Avoid a flood of database queries from CommentsIndex::selectRow
		 * when WallMessages::getCommentsIndex is called
		 *
		 * @see SUS-262
		 */
		$commentsIndices = CommentsIndex::getInstance()->entriesFromIds( $correctIds );

		foreach( $commentsIndices as $commentIndex ) {
			$wallMessages[ $commentIndex->getCommentId() ]->commentsIndex = $commentIndex;
		}

		$retryIds = array_diff( $ids, $correctIds );

		foreach ( $retryIds as $id ) {
			$title = Title::newFromID( $id, Title::GAID_FOR_UPDATE );
			if ( $title instanceof Title && $title->exists() ) {
				$wallMessages[ $title->getArticleID() ] = WallMessage::newFromTitle( $title );
			} else {
				WikiaLogger::instance()->error( 'Failed to load reply for thread', [ 'titleId' => $id ] );
			}
		}

		wfProfileOut( __METHOD__ );
		return array_values( $wallMessages );
	}

	static public function isWallMessage( Title $title ) {
		return $title->inNamespaces( NS_USER_WALL_MESSAGE, NS_USER_WALL_MESSAGE_GREETING, NS_WIKIA_FORUM_BOARD_THREAD );
	}

	static public function newFromTitle( Title $title ) {
		wfProfileIn( __METHOD__ );
		$class = new WallMessage( $title );
		wfProfileOut( __METHOD__ );
		return $class;
	}

	static public function newFromArticleComment( ArticleComment $articleComment ) {
		wfProfileIn( __METHOD__ );
		$class = new WallMessage( $articleComment->getTitle(), $articleComment );
		wfProfileOut( __METHOD__ );
		return $class;
	}

	public function setOrderId( $val = 1 ) {
		wfProfileIn( __METHOD__ );
		$this->setInProps( WPP_WALL_COUNT, $val );
		$this->order = $val;
		wfProfileOut( __METHOD__ );
		return $val;
	}

	/**
	 * @return CommentsIndexEntry
	 */
	public function getCommentsIndexEntry() {
		if ( !( $this->commentsIndex instanceof CommentsIndexEntry ) ) {
			if ( !empty( $this->commentsIndex ) ) {
				$this->getThread()->invalidateCache();
			}

			$this->commentsIndex = CommentsIndex::getInstance()->entryFromId( $this->getId() );
		}

		return $this->commentsIndex;
	}

	public function getOrderId( $for_update = false ) {
		wfProfileIn( __METHOD__ );
		if ( $for_update ) {
			wfProfileOut( __METHOD__ );
			return wfGetWikiaPageProp( WPP_WALL_COUNT, $this->getId(), DB_MASTER );
		}

		if ( $this->order != 0 ) {
			wfProfileOut( __METHOD__ );
			return $this->order;
		}

		$out = $this->getPropVal( WPP_WALL_COUNT );
		wfProfileOut( __METHOD__ );
		return $out;
	}

	public function storeRelatedTopicsInDB( $relatedTopicURLs ) {
		Hooks::run( 'WallBeforeStoreRelatedTopicsInDB', [ $this->getTopParentId(), $this->getTitle()->getArticleId(), $this->getTitle()->getNamespace() ] );
		$rp = new WallRelatedPages();
		$rp->setWithURLs( $this->getId(), $relatedTopicURLs );
		Hooks::run( 'WallAfterStoreRelatedTopicsInDB', [ $this->getTopParentId(), $this->getTitle()->getArticleId(), $this->getTitle()->getNamespace() ] );
	}

	public function getRelatedTopics() {
		$rp = new WallRelatedPages();
		return $rp->getMessagesRelatedArticleTitles( $this->getId() );
	}

	/**
	 * Check if user can edit WallMessage
	 *
	 * @param User $user
	 * @param bool|true $shouldLogBlockInStats
	 * @return bool
	 */
	public function canEdit( User $user, $shouldLogBlockInStats = true ) {
		wfProfileIn( __METHOD__ );
		$out = $this->can( $user, 'edit', $shouldLogBlockInStats ) &&
			(
				$this->isAuthor( $user ) ||
				$this->can( $user, 'walledit', $shouldLogBlockInStats )
			);
		wfProfileOut( __METHOD__ );
		return $out;
	}

	/**
	 * @param string $body
	 * @param User $user
	 * @param string $summary
	 * @param bool $force
	 * @param bool $preserveMetadata
	 * @return string
	 */
	public function doSaveComment( $body, $user, $summary = '', $force = false, $preserveMetadata = false ) {
		wfProfileIn( __METHOD__ );

		if ( $this->canEdit( $user ) || $force ) {
			$this->getArticleComment()->doSaveComment( $body, $user, null, 0, true, $summary, $preserveMetadata );
		}
		if ( !$this->isMain() ) {
			// after changing reply invalidate thread cache
			$this->getThread()->invalidateCache();
		}

		$articleComment = $this->getArticleComment();

		// parse the new / updated message
		$articleComment->setRawText( $body );
		$out = $articleComment->getTransformedParsedText();

		wfProfileOut( __METHOD__ );
		return $out;
	}

	protected function doSaveMetadata( $user, $summary = '', $force = false ) {
		wfProfileIn( __METHOD__ );
		$body = $this->getArticleComment()->getRawText();

		wfDebug( __METHOD__ . json_encode( $this->getArticleComment()->getAllMetadata() ) . "\n" );

		$out = $this->doSaveComment( $body, $user, $summary, $force, true );
		wfProfileOut( __METHOD__ );
		return $out;
	}

	/**
	 * Check user permission
	 *
	 * @param User $user
	 * @param string $permissionName
	 * @param bool|true $shouldLogBlockInStats
	 * @return bool
	 */
	protected function can( User $user, $permissionName, $shouldLogBlockInStats = true ) {
		wfProfileIn( __METHOD__ );
		$username = $user->getName();
		if ( isset( self::$permissionsCache[ $username ][ $permissionName ] ) ) {
			wfProfileOut( __METHOD__ );
			return self::$permissionsCache[ $username ][ $permissionName ];
		}

		if ( empty( self::$permissionsCache[ $username ] ) ) {
			self::$permissionsCache[ $username ] = [ ];
		}

		wfProfileIn( __METHOD__ . "2" );
		if ( $permissionName == 'wallshowwikiaemblem' ) {
			self::$permissionsCache[ $username ][ $permissionName ] = $user->isAllowed( $permissionName );
		} else {
			self::$permissionsCache[ $username ][ $permissionName ] = $user->isAllowed( $permissionName ) &&
				!$user->isBlocked( true, $shouldLogBlockInStats );
		}
		wfProfileOut( __METHOD__ . "2" );

		wfProfileOut( __METHOD__ );
		return self::$permissionsCache[ $username ][ $permissionName ];
	}

	public function showWikiaEmblem() {
		return $this->can( $this->getUser(), 'wallshowwikiaemblem', false );
	}

	/**
	 * Check if user has permission to delete Wall
	 *
	 * @param User $user
	 * @param bool|true $shouldLogBlockInStats
	 * @return bool
	 */
	public function canDelete( User $user, $shouldLogBlockInStats = true ) {
		return $this->can( $user, 'walldelete', $shouldLogBlockInStats ) &&
		$user->getGlobalPreference( 'walldelete', false );
	}

	/**
	 * Check if user has permission to remove WallMessage
	 *
	 * @param User $user
	 * @param bool|true $shouldLogBlockInStats
	 * @return bool
	 */
	public function canRemove( User $user, $shouldLogBlockInStats = true ) {
		if ( $user->isBlocked( true, $shouldLogBlockInStats ) ) {
			return false;
		}

		if ( $this->can( $user, 'wallremove', $shouldLogBlockInStats ) ) {
			return true;
		}

		if ( $this->isAuthor( $user ) || $this->isWallOwner( $user ) ) {
			return !$this->isMarkInProps( WPP_WALL_MODERATORREMOVE );
		}

		return false;
	}

	/**
	 * Check if user can admin delete - after admin delete revision is not visible for regular user
	 *
	 * @param User $user
	 * @param bool|true $shouldLogBlockInStats
	 * @return bool
	 */
	public function canAdminDelete( User $user, $shouldLogBlockInStats = true ) {
		return $this->can( $user, 'walladmindelete', $shouldLogBlockInStats ) &&
		!$this->isAdminDelete() && $this->isRemove() && $this->isMain();
	}

	/**
	 * Check if user can admin delete - after admin delete revision is not visible for regular user
	 * TODO Probably fastAdminDelete is equivalent to adminDelete - think of refactoring
	 *
	 * @param User $user
	 * @param bool|true $shouldLogBlockInStats
	 * @return bool
	 */
	public function canFastAdminDelete( User $user, $shouldLogBlockInStats = true ) {
		return $this->can( $user, 'wallfastadmindelete', $shouldLogBlockInStats );
	}

	/**
	 * Check if user can restore
	 *
	 * @param User $user
	 * @param bool|true $shouldLogBlockInStats
	 * @return bool
	 */
	public function canFastRestore( User $user, $shouldLogBlockInStats = true ) {
		return $this->can( $user, 'walladmindelete', $shouldLogBlockInStats ) || $this->isWallOwner( $user );
	}

	/**
	 * Check if user can archive WallMessage - in fact it's closing
	 *
	 * @param User $user
	 * @param bool|true $shouldLogBlockInStats
	 * @return bool
	 */
	public function canArchive( User $user, $shouldLogBlockInStats = true ) {
		if ( $user->isBlocked( true, $shouldLogBlockInStats ) ) {
			return false;
		}

		if ( !in_array( MWNamespace::getSubject( $this->title->getNamespace() ), F::app()->wg->WallThreadCloseNS ) ) {
			return false;
		}

		if ( !$this->isMain() ) {
			return false;
		}

		if ( $this->isArchive() || $this->isRemove() ) {
			return false;
		}

		if ( $this->can( $user, 'wallarchive', $shouldLogBlockInStats ) ) {
			return true;
		}

		if ( $this->isWallOwner( $user ) ) {
			return !$this->isMarkInProps( WPP_WALL_MODERATORREOPEN );
		}

		return false;
	}

	/**
	 * Check if user can reopen WallMessage
	 *
	 * @param User $user
	 * @param bool|true $shouldLogBlockInStats
	 * @return bool
	 */
	public function canReopen( User $user, $shouldLogBlockInStats = true ) {
		if ( $user->isBlocked( true, $shouldLogBlockInStats ) ) {
			return false;
		}

		if ( !in_array( MWNamespace::getSubject( $this->title->getNamespace() ), F::app()->wg->WallThreadCloseNS ) ) {
			return false;
		}

		if ( !$this->isMain() ) {
			return false;
		}

		if ( !$this->isArchive() ) {
			return false;
		}

		if ( $this->isRemove() ) {
			return false;
		}

		if ( $this->can( $user, 'wallarchive', $shouldLogBlockInStats ) ) {
			return true;
		}

		if ( $this->isWallOwner( $user ) ) {
			return !$this->isMarkInProps( WPP_WALL_MODERATORARCHIVE );
		}

		return false;
	}

	public function getMetaTitle() {
		return $this->getArticleComment()->getMetadata( 'title' );
	}

	public function getNotifyeveryone() {
		$out = (int )$this->getArticleComment()->getMetadata( 'notify_everyone' );
		$ageInDays = ( time() - $out ) / ( 60 * 60 * 24 );

		if ( $ageInDays < WallHelper::NOTIFICATION_EXPIRE_DAYS ) {
			return true;
		} else {
			return false;
		}
	}

	public function canNotifyeveryone() {
		if ( $this->isMain() && !$this->isArchive() && !$this->isRemove() ) {
			if ( !$this->isAllowedNotifyEveryone() ) {
				return false;
			}
			return !$this->getNotifyeveryone();
		}
		return false;
	}

	public function canUnnotifyeveryone() {
		if ( $this->isMain() ) {
			if ( !$this->isAllowedNotifyEveryone() ) {
				return false;
			}
			return $this->getNotifyeveryone();
		}
		return false;
	}

	public function setNotifyEveryone( $notifyEveryone ) {
		if ( $this->isMain() ) {
			if ( !$this->isAllowedNotifyEveryone() ) {
				wfDebug( __METHOD__ . " - is not allowed to notify everyone\n" );
				return false;
			}
			$app = F::App();
			$wne = new WallNotificationsEveryone();
			$this->load( true );
			if ( $notifyEveryone ) {
				$this->getArticleComment()->setMetaData( 'notify_everyone', time() );
				$this->doSaveMetadata( $app->wg->User,
					wfMessage( 'wall-message-update-highlight-summary' )->inContentLanguage()->text() );
				$rev = $this->getArticleComment()->mLastRevision;
				$entity = WallNotificationEntity::createFromRev( $rev );
				$wne->addNotificationToQueue( $entity );
			} else {
				$this->getArticleComment()->removeMetadata( 'notify_everyone' );
				$pageId = $this->getId();
				$wne->removeNotificationForPageId( $pageId );
				$this->doSaveMetadata( $app->wg->User,
					wfMessage( 'wall-message-update-removed-highlight-summary' )->inContentLanguage()->text() );
			}
		}
	}

	public function setMetaTitle( $title ) {
		if ( $this->isMain() ) {
			$this->getArticleComment()->setMetaData( 'title', $title );
		}
		return true;
	}

	public function setRelatedTopics( $user, $relatedTopics ) {
		if ( $this->isMain() ) {
			$this->getArticleComment()->setMetaData( 'related_topics', implode( '|', $relatedTopics ) );
			$this->doSaveMetadata( $user, wfMsgForContent( 'wall-message-update-topics-summary' ), true );
			$this->storeRelatedTopicsInDB( $relatedTopics );
		}
		return true;
	}

	public function markAsMove( $user ) {
		if ( $this->isMain() ) {
			$this->getArticleComment()->setMetaData( 'lastmove', time(), true );
			$this->doSaveMetadata( $user, wfMsgForContent( 'wall-action-move-topics-summary', $this->getWall()->getTitle()->getPrefixedText() ), true );
		}
		return true;
	}

	/**
	 * This method is used by on Wall and Forum messages to get the name of the main page (wall owner or forum board)
	 */
	public function getMainPageText() {
		$title = $this->getArticleTitle();
		$parts = explode( '/', $title->getText() );
		$wallOwnerName = $parts[ 0 ];

		Hooks::run( 'WallMessageGetWallOwnerName', [ $title, &$wallOwnerName ] );

		return $wallOwnerName;
	}

	private function getTitleBaseText( Title $title ): string {
		$titleText = $title->getText();
		$slashPosition = strpos( $titleText, '/' );

		if ( $slashPosition === false ) {
			return $titleText;
		}

		return substr( $titleText, 0, $slashPosition );
	}

	public function getWallOwner() {
		$boardName = $this->getTitleBaseText( $this->getArticleTitle() );
		return User::newFromName( $boardName, false );
	}

	public function getWallPageUrl() {
		return $this->getArticleTitle()->getFullUrl();
	}

	/**
	 * @return Title
	 */
	public function getArticleTitle(): Title {
		// Forum Threads may have been moved to another board - use comments index as data source
		try {
			$commentsIndexEntry = $this->getCommentsIndexEntry();
			$parentPageId = $commentsIndexEntry->getParentPageId();

			$parentTitle =
				static::$titleCache[$parentPageId] ??
				Title::newFromID( $parentPageId ) ??
				Title::newFromID( $parentPageId, Title::GAID_FOR_UPDATE ) ??
				static::emptyTitle();

			return ( static::$titleCache[$parentPageId] = $parentTitle );
		} catch ( CommentsIndexEntryNotFoundException $entryNotFoundException ) {
			$title = $this->getTitle();
			WikiaLogger::instance()->error( 'SUS-1680: No comments index entry for message', [
				'messageTitle' => $title->getPrefixedText(),
				'messageId' => $title->getArticleID(),
				'exception' => $entryNotFoundException
			] );

			return static::emptyTitle();
		}
	}

	/**
	 * @return Wall
	 */
	public function getWall() {
		$wall = Wall::newFromTitle( $this->getArticleTitle() );
		return $wall;
	}

	public function getThread() {
		$wm = $this;
		if ( $this->isMain() == false ) {
			$wm = $this->getTopParentObj();
		}
		return WallThread::newFromId( $wm->getId() );
	}

	public function getPageUrlPostFix() {
		wfProfileIn( __METHOD__ );
		if ( $this->isMain() ) {
			wfProfileOut( __METHOD__ );
			return '';
		}

		$order = $this->getOrderId();
		if ( $order != null ) {
			$res = $order;
		} else {
			$res = $this->getId();
		}
		wfProfileOut( __METHOD__ );
		return $res;
	}

	public function getMessagePageId() {

		if ( $this->isMain() ) {
			$id = $this->getId();
		} else {
			$topParent = $this->getTopParentObj();
			$id = $topParent->getId();
		}

		return $id;
	}

	public function getMessagePageUrl( $withoutAnchor = false, $fullUrl = true ) {
		wfProfileIn( __METHOD__ );

		// local cache consider cache this in memc
		if ( !empty( $this->messagePageUrl ) ) {
			wfProfileOut( __METHOD__ );
			return $this->messagePageUrl[ $withoutAnchor ];
		}

		$id = $this->getMessagePageId();

		$postFix = $this->getPageUrlPostFix();
		$postFix = empty( $postFix ) ? "" : ( '#' . $postFix );
		$title = Title::makeTitle( NS_USER_WALL_MESSAGE, $id );

		$this->messagePageUrl = [ ];

		$this->messagePageUrl[ true ] = $fullUrl ? $title->getFullUrl() : $title->getLocalURL();
		$this->messagePageUrl[ false ] = $this->messagePageUrl[ true ] . $postFix;

		wfProfileOut( __METHOD__ );
		return $this->messagePageUrl[ $withoutAnchor ];
	}

	public function getWallUrl() {
		return $this->getArticleTitle()->getFullUrl();
	}

	/**
	 * @return null|WallMessage
	 */
	public function getTopParentObj() {
		$parentComment = $this->getArticleComment()->getTopParentObj();

		return $parentComment ? WallMessage::newFromArticleComment( $parentComment ) : null;
	}

	public function getTopParentId() {
		$top = $this->getTopParentObj();
		if ( empty( $top ) ) {
			return null;
		}
		return $top->getId();
	}

	public function isMain() {
		$top = $this->getTopParentObj();
		if ( empty( $top ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Checks if the user passed as an argument is the owner of the Wall containing current WallMessage
	 *
	 * @param User $user instance of the user class
	 * @return bool true when the user is the owner
	 */
	public function isWallOwner( User $user ) {
		// SUS-1777: Of course the user cannot be the Wall owner of a Forum thread
		if ( !$this->title->inNamespace( NS_USER_WALL_MESSAGE ) ) {
			return false;
		}

		$wallUser = $this->getWallOwner();
		return !empty( $wallUser ) && $wallUser->equals( $user );
	}

	public function load( $master = false ) {
		if ( $this->isLoaded ) {
			return true;
		}
		$this->isLoaded = true;
		return $this->getArticleComment()->load( $master );
	}

	public function getUser() {
		/*
		 * During posting message as bot we are adding information about admin of wiki
		 * and when we are displaying this message we are loading user information from this data
		 */

		if ( $this->isMain() ) {
			$user = $this->getPostedAsBot();
			if ( !empty( $user ) ) {
				return $user;
			}
		}

		$user = $this->getArticleComment()->mUser;
		if ( $user ) {
			return $user;
		} else {
			// this only happend for wrong enties in DB
			// without revision information
			return User::newFromName( NON_ROUTABLE_IPV6, false );
		}
	}

	/**
	 * Will return either username if user exists, or it will return "A Wikia Contributor" (i18n translated) if user is an anon
	 */
	public function getUserDisplayName() {
		$displayName = '';

		if ( $this->getUser()->getId() == 0 ) {
			$displayName = wfMsg( 'oasis-anon-user' );
		} else {
			$displayName = $this->getUser()->getName();
		}

		return $displayName;
	}

	/**
	 * Returns wall url if user exists.  Returns url to contributions if anonymous.
	 * If wall is disabled and user exists, it should return link to user talk page
	 */
	public function getUserWallUrl() {
		$name = $this->getUser()->getName();

		if ( empty( self::$wallURLCache[ $name ] ) ) {
			if ( $this->getUser()->getId() == 0 ) { // anynymous contributor
				$url = Skin::makeSpecialUrl( 'Contributions' ) . '/' . $this->getUser()->getName();
			} else if ( empty( F::app()->wg->EnableWallExt ) ) {
				$url = Title::newFromText( $name, NS_USER_TALK )->getFullUrl();
			} else {
				$url = Title::newFromText( $name, NS_USER_WALL )->getFullUrl();
			}
			self::$wallURLCache[ $name ] = $url;
		}

		return self::$wallURLCache[ $name ];
	}

	public function getText() {
		return $this->getArticleComment()->getText();
	}

	public function getHeadItems() {
		return $this->getArticleComment()->getHeadItems();
	}

	public function getCreateTime( $format = TS_ISO_8601 ) {
		return wfTimestamp( $format, $this->getCreateTimeRAW() );
	}

	public function getCreateTimeRAW() {
		$ac = $this->getArticleComment();
		if ( $ac && $ac->mFirstRevision ) {
			return $ac->mFirstRevision->getTimestamp();
		}
		return null;
	}

	public function getRawText( $master = false ) {
		$this->load( $master );
		$data = $this->getData();
		return $data[ 'rawtext' ];

	}

	public function getEditor() {
		$user = User::newFromId( $this->getArticleComment()->mLastRevision->getUser() );
		return $user;
	}

	public function getEditTime( $format ) {
		$r = $this->getArticleComment()->mLastRevision;
		if ( !$r ) return null; // BugId:22821
		return wfTimestamp( $format, $r->getTimestamp() );
	}

	public function getVoteHelper() {
		if ( !empty( $this->voteVoteHelper ) ) {
			return $this->voteVoteHelper;
		}
		$app = F::App();
		$this->voteVoteHelper = new VoteHelper( $app->wg->User, $this->getId() );
		return $this->voteVoteHelper;
	}

	public function vote( $user ) {
		if ( !$this->canVotes( $user ) ) {
			return false;
		}

		$this->getVoteHelper()->addVote();
	}

	public function removeVote( $user ) {
		if ( !$this->canVotes( $user ) ) {
			return false;
		}

		$this->getVoteHelper()->removeVote();
	}

	public function isVoted() {
		return $this->getVoteHelper()->isVoted();
	}

	public function getVoteCount() {
		return $this->getVoteHelper()->getVoteCount();
	}

	public function getVotersList( $from, $count ) {
		return $this->getVoteHelper()->getVotersList( $from, $count );
	}

	public function isEdited() {
		return $this->getArticleComment()->mLastRevId != $this->getArticleComment()->mFirstRevId;
	}

	public function getLastEditSummary() {
		$lastRev = Revision::newFromId( $this->getArticleComment()->mLastRevId );

		if ( empty( $lastRev ) ) {
			return false;
		}

		return $lastRev->getComment();
	}

	public function isAuthor( User $user ) {
		return $this->getArticleComment()->isAuthor( $user );
	}

	public function canModerate( User $user ) {
		return $this->can( $user, 'wallarchive' ) || $this->can( $user, 'wallremove' );
	}

	public function isWallWatched( User $user ) {
		return $user->isWatched( $this->getArticleTitle() );
	}

	public function isWatched( User $user ) {
		return $user->isWatched( $this->title );
	}

	public function addWatch( User $user ) {
		if ( !$this->isMain() ) {
			$parent = $this->getTopParentObj();
			if ( $parent ) $user->addWatch( $parent->getTitle() );
		} else {
			$user->addWatch( $this->title );
		}
	}

	public function removeWatch( User $user ) {
		if ( !$this->isMain() ) {
			$parent = $this->getTopParentObj();
			if ( $parent ) {
				$user->removeWatch( $parent->getTitle() );
			}
		} else {
			$user->removeWatch( $this->title );
		}

	}

	public function getCreatTime( $format ) {
		return wfTimestamp( $format, $this->getCreateTimeRAW() );
	}

	public function getTitle() {
		return $this->title;
	}

	protected function recordAdminHistory( $user, $reason, $history, $notifyAdmins = false ) {
		$wnae = $this->getAdminNotificationEntity( $user, $reason );
		if ( $notifyAdmins ) {
			$this->addAdminNotificationFromEntity( $wnae );
		}

		$wh = new WallHistory();
		$wh->add( $history, $wnae, $user );
	}

	public function archive( $user, $reason = '' ) {
		$status = $this->markInProps( WPP_WALL_ARCHIVE );
		if ( $this->can( $user, 'wallarchive' ) ) {
			$this->markInProps( WPP_WALL_MODERATORARCHIVE ); // VOLDEV-79
		}
		$this->recordAdminHistory( $user, $reason, WH_ARCHIVE );
		$this->saveReason( $user, $reason );
		$this->customActionNotifyRC( $user, 'wall_archive', $reason );
		return $status;
	}

	public function reopen( $user ) {
		$this->unMarkInProps( WPP_WALL_ARCHIVE );
		if ( $this->isMarkInProps( WPP_WALL_MODERATORARCHIVE ) ) {
			$this->unMarkInProps( WPP_WALL_MODERATORARCHIVE );
		}
		if ( $this->can( $user, 'wallarchive' ) ) {
			$this->markInProps( WPP_WALL_MODERATORREOPEN );
		}
		$this->recordAdminHistory( $user, '', WH_REOPEN );
		$this->customActionNotifyRC( $user, 'wall_reopen', '' );
		return true;
	}

	public function remove( $user, $reason = '', $notifyAdmins = false ) {
		$this->saveReason( $user, $reason );

		$this->unMarkInProps( WPP_WALL_ARCHIVE );
		if ( $this->isMarkInProps( WPP_WALL_MODERATORARCHIVE ) ) {
			$this->unMarkInProps( WPP_WALL_MODERATORARCHIVE );
		}
		if ( $this->isMarkInProps( WPP_WALL_MODERATORREOPEN ) ) {
			$this->unMarkInProps( WPP_WALL_MODERATORREOPEN );
		}
		$status = $this->markInProps( WPP_WALL_REMOVE );
		if ( $this->can( $user, 'wallremove' ) ) {
			$this->markInProps( WPP_WALL_MODERATORREMOVE );
		}

		if ( $status === true ) {
			$this->customActionNotifyRC( $user, 'wall_remove', $reason );

			$this->recordAdminHistory( $user, $reason, WH_REMOVE, $notifyAdmins );

			if ( $this->isMain() === true ) {
				$this->getWall()->invalidateCache();
				$wnoe = $this->getOwnerNotificationEntity( $user, $reason );
				$this->addOwnerNotificationFromEntity( $wnoe );
			} else {
				$this->getThread()->invalidateCache();
			}
			$this->hideRelatedNotifications();
		}

		$this->addWatch( $user );

		return $status;
	}

	protected function addAdminNotificationFromEntity( $wnae ) {
		$wna = new WallNotificationsAdmin;
		$wna->addAdminNotificationFromEntity( $wnae );
	}

	protected function getAdminNotificationEntity( $user, $reason ) {
		$data = [ ];

		$this->load();
		$wikiId = $this->cityId;
		$data[ 'userIdRemoving' ] = $user->getId();
		$data[ 'userIdWallOwner' ] = $this->getWallOwner()->getId();
		$data[ 'parentPageId' ] = $this->getArticleTitle()->getArticleId();

		$data[ 'url' ] = $this->getMessagePageUrl();
		$data[ 'title' ] = $this->getMetaTitle();
		$data[ 'messageId' ] = $this->getId();
		$data[ 'reason' ] = $reason;

		if ( $this->isMain() ) {
			$data[ 'parentId' ] = 0;
			$data[ 'isReply' ] = false;
			$wnae = new WallNotificationAdminEntity( $wikiId, $data );
		} else {
			$parent = $this->getTopParentObj();
			$parent->load();
			$data[ 'parentId' ] = $parent->getId();
			$data[ 'title' ] = $parent->getMetaTitle();
			$data[ 'isReply' ] = true;
			$wnae = new WallNotificationAdminEntity( $wikiId, $data );
		}

		return $wnae;
	}

	protected function addOwnerNotificationFromEntity( $wnoe ) {
		$wno = new WallNotificationsOwner;
		$wno->addOwnerNotificationFromEntity( $wnoe );
	}

	protected function getOwnerNotificationEntity( $user, $reason ) {
		$data = [ ];

		$this->load();
		$wikiId = $this->cityId;
		$data[ 'userIdRemoving' ] = $user->getId();
		$data[ 'userIdWallOwner' ] = $this->getWallOwner()->getId();
		$data[ 'url' ] = $this->getMessagePageUrl();
		$data[ 'title' ] = $this->getMetaTitle();
		$data[ 'messageId' ] = $this->getId();
		$data[ 'reason' ] = $reason;

		if ( $this->isMain() ) {
			$data[ 'parentMessageId' ] = 0;
			$data[ 'isReply' ] = false;
			$wnoe = new WallNotificationOwnerEntity( $wikiId, $data );
		} else {
			$parent = $this->getTopParentObj();
			$parent->load();
			$data[ 'parentMessageId' ] = $parent->getId();
			$data[ 'title' ] = $parent->getMetaTitle();
			$data[ 'isReply' ] = true;
			$wnoe = new WallNotificationOwnerEntity( $wikiId, $data );
		}

		return $wnoe;
	}

	public function adminDelete( $user, $reason = '', $notifyAdmins = false ) {
		$this->saveReason( $user, $reason );
		$status = $this->markInProps( WPP_WALL_ADMINDELETE );

		if ( $status === true ) {
			$this->customActionNotifyRC( $user, 'wall_admindelete', $reason );

			$wnae = $this->getAdminNotificationEntity( $user, $reason );
			if ( $notifyAdmins ) {
				$this->addAdminNotificationFromEntity( $wnae );
			}

			$wh = new WallHistory();
			$wh->add( WH_DELETE, $wnae, $user );

			if ( $this->isMain() === true ) {
				$this->getWall()->invalidateCache();
				$wnoe = $this->getOwnerNotificationEntity( $user, $reason );
				$this->addOwnerNotificationFromEntity( $wnoe );
			} else {
				$this->getThread()->invalidateCache();
			}
			$this->hideRelatedNotifications();
		}

		$this->addWatch( $user );

		return $status;
	}

	public function fastAdminDelete( $user ) {
		if ( $this->adminDelete( $user ) ) {
			return true;
		}

		return false;
	}

	protected function customActionNotifyRC( $user, $action, $reason ) {
		$articleId = $this->getId();
		$target = $this->getTitle();

		RecentChange::notifyLog(
			wfTimestampNow(),
			$target,
			$user,                // user
			'',                    // articleComment
			'',                    // ip
			RC_EDIT,            // rc_log_type
			$action,            // rc_action
			$target,
			$reason,            // rc_comment
			'',                    // params
			0                    // new id
		);
	}

	public function delete( $reason, $suppress = true ) {
		$this->load( true );

		$this->removeRelatedNotifications();

		if ( $this->isMain() === true ) {
			$obj = $this->getWall();
		} else {
			$obj = $this->getThread();
		}

		$retval = $this->getArticleComment()->doDeleteComment( $reason, $suppress );
		$obj->invalidateCache();
		return $retval;
	}

	public function removeRelatedNotifications() {
		if ( $this->isMain() ) {
			$wn = new WallNotifications;
			$uniqueId = $this->getId();
			$wn->remNotificationsForUniqueID( null, $this->cityId, $uniqueId, false );

			$wna = new WallNotificationsAdmin;
			$wna->removeForThread( $this->cityId, $this->getId() );
		}
	}

	public function hideRelatedNotifications() {
		if ( $this->isMain() ) {
			$wn = new WallNotifications;
			$uniqueId = $this->getId();
			$wn->remNotificationsForUniqueID( null, $this->cityId, $uniqueId, true );
		}
	}

	public function isArchive() {
		return $this->isMarkInProps( WPP_WALL_ARCHIVE );
	}

	public function isRemove() {
		return $this->isMarkInProps( WPP_WALL_REMOVE );
	}

	public function isAdminDelete() {
		return $this->isMarkInProps( WPP_WALL_ADMINDELETE );
	}

	public function canReply() {
		return !$this->isArchive() && !$this->isAdminDelete() && !$this->isRemove();
	}

	/**
	 * Check if user can restore WallMessage
	 *
	 * @param $user
	 * @param bool|true $shouldLogBlockInStats
	 * @return bool
	 */
	public function canRestore( $user, $shouldLogBlockInStats = true ) {
		wfProfileIn( __METHOD__ );
		if ( $this->isAdminDelete() ) {
			if ( $this->can( $user, 'walladmindelete', $shouldLogBlockInStats ) ) {
				wfProfileOut( __METHOD__ );
				return true;
			}
		} elseif ( $this->isRemove() ) {
			if ( $this->canRemove( $user, $shouldLogBlockInStats ) ) {
				wfProfileOut( __METHOD__ );
				return true;
			}
		}
		wfProfileOut( __METHOD__ );
		return false;
	}

	public function isVisible( $user ) {
		if ( !$this->isAdminDelete( $user ) ) {
			return true;
		}

		return false;
	}

	/*
	 * expanded view, you can use it if you want to check if you can see deleted message
	 */

	public function canViewDeletedMessage( $user ) {
		if ( $this->can( $user, 'walladmindelete', false ) ) {
			return true;
		}

		return false;
	}

	/*
	 * put it back in remove status
	 */

	public function undoAdminDelete( $user ) {
		$this->restore( $user, '' );
		$this->remove( $user, '' );
	}

	public function restore( $user, $reason = '' ) {
		$this->unMarkInProps( WPP_WALL_REMOVE );
		$this->unMarkInProps( WPP_WALL_ADMINDELETE );
		$this->unMarkInProps( WPP_WALL_MODERATORREMOVE );
		$this->customActionNotifyRC( $user, 'wall_restore', $reason );

		$wne = $this->getAdminNotificationEntity( $user, $reason );
		$wh = new WallHistory();
		$wh->add( WH_RESTORE, $wne, $user );

		$this->addWatch( $user );

		$wn = new WallNotifications;
		if ( $this->isMain() ) {
			$wn->unhideNotificationsForUniqueID( $this->cityId, $this->getId() );
			$this->getWall()->invalidateCache();

			$wna = new WallNotificationsAdmin;
			$wna->removeForThread( $this->cityId, $this->getId() );
			$wno = new WallNotificationsOwner;
			$wno->removeForThread( $this->cityId, $this->getWallOwner()->getId(), $this->getId() );
		} else {
			$this->getThread()->invalidateCache();

			$wna = new WallNotificationsAdmin;
			$wna->removeForReply( $this->cityId, $this->getId() );
			$wno = new WallNotificationsOwner;
			$wno->removeForReply( $this->cityId, $this->getWallOwner()->getId(), $this->getId() );
		}
	}

	// TODO: cache it
	public function getLastActionReason() {
		if ( empty( $this->mActionReason ) ) {
			$info = wfGetWikiaPageProp( WPP_WALL_ACTIONREASON, $this->getId() );
		} else {
			$info = $this->mActionReason;
		}

		if ( empty( $info[ 'userid' ] ) ) {
			return false;
		}

		$user = User::newFromId( $info[ 'userid' ] );
		if ( empty( $user ) ) {
			return false;
		}

		$info[ 'isotime' ] = wfTimestamp( TS_ISO_8601, $info[ 'time' ] );
		$info[ 'mwtime' ] = wfTimestamp( TS_MW, $info[ 'time' ] );

		$info[ 'user' ] = $user;

		$displayname = $user->getName();

		$user_link = $user->getUserPage()->getFullURL();

		$info[ 'user_displayname_linked' ] = Xml::openElement( 'a', [ 'href' => $user_link ] ) . $displayname . Xml::closeElement( 'a' );

		$info[ 'status' ] = $this->isAdminDelete() ? 'deleted' : 'removed';

		return $info;
	}

	protected function saveReason( $user, $reason ) {
		$this->mActionReason = [
			'reason' => strip_tags( $reason ),
			'userid' => $user->getId(),
			'time' => wfTimestampNow()
		];

		wfSetWikiaPageProp( WPP_WALL_ACTIONREASON, $this->getId(), $this->mActionReason );
	}

	public function getQuoteOf() {
		$id = $this->getPropVal( WPP_WALL_QUOTE_OF );
		if ( empty( $id ) ) {
			return false;
		}

		$msg = WallMessage::newFromId( $id );

		if ( empty( $msg ) ) {
			return false;
		}

		return $msg;
	}

	public function setQuoteOf( $id ) {
		if ( $this->isMain() ) {
			return false;
		}

		$msgParent = $this->getTopParentObj();
		/**
		 * @var $quotedMsg WallMessage
		 */
		$quotedMsg = WallMessage::newFromId( $id, true );

		if ( empty( $quotedMsg ) ) {
			return false;
		}

		if ( $quotedMsg->isMain() ) {
			if ( $quotedMsg->getId() != $msgParent->getId() ) {
				return false;
			}
		} else {
			$quotedMsgParent = $quotedMsg->getTopParentObj();
			if ( $quotedMsgParent->getId() != $msgParent->getId() ) {
				return false;
			}
		}

		$this->setInProps( WPP_WALL_QUOTE_OF, $id );
		return true;
	}

	/*
	 * $user - admin on wiki
	 */

	public function setPostedAsBot( $user ) {
		$this->addWatch( $user );
		$this->setInProps( WPP_WALL_POSTEDBYBOT, $user->getId() );
	}

	public function getPostedAsBot() {
		$val = $this->getPropVal( WPP_WALL_POSTEDBYBOT );
		if ( ( (int)$val ) == 0 ) {
			return false;
		}
		$user = User::newFromId( $val );

		if ( $user instanceof User && $user->getId() > 0 ) {
			return $user;
		}

		return false;
	}

	public function setInCommentsIndex( $prop, $value ) {
		$commentId = $this->getId();
		if ( !empty( $commentId ) ) {
			$entry = $this->getCommentsIndexEntry();

			if ( $entry instanceof CommentsIndexEntry ) {
				switch ( $prop ) {
					case WPP_WALL_ARCHIVE:
						$entry->setArchived( $value );
						break;
					case WPP_WALL_ADMINDELETE:
						$entry->setDeleted( $value );
						break;
					case WPP_WALL_REMOVE:
						$entry->setRemoved( $value );
						break;
				}

				CommentsIndex::getInstance()->updateEntry( $entry );
			}
		}
	}

	protected function markInProps( $prop ) {
		$this->setInProps( $prop, 1 );
		$this->setInCommentsIndex( $prop, 1 );
		return true;
	}

	protected function setInProps( $prop, $val = 1 ) {
		wfSetWikiaPageProp( $prop, $this->getId(), $val );

		$key = $this->getPropCacheKey();
		$cache = $this->getCache();
		$this->propsCache = $cache->get( $key );
		$this->propsCache[ $prop ] = $val;

		$cache->set( $key, $this->propsCache );

		return true;
	}

	protected function unMarkInProps( $prop ) {
		$key = $this->getPropCacheKey();
		$this->propsCache[ $prop ] = false;

		$cache = $this->getCache();
		$cache->set( $key, false );

		wfDeleteWikiaPageProp( $prop, $this->getId() );

		$this->setInCommentsIndex( $prop, 0 );
	}

	protected function getPropVal( $prop ) {
		wfProfileIn( __METHOD__ );

		$key = $this->getPropCacheKey();

		// check local memory cache
		if ( array_key_exists( $prop, $this->propsCache ) ) {
			wfProfileOut( __METHOD__ );
			return $this->propsCache[ $prop ];
		}

		wfProfileIn( __METHOD__ . "_1" );
		// check memcache
		$cache = $this->getCache();
		$fromcache = $cache->get( $key );

		if ( !empty( $fromcache ) ) {
			$this->propsCache = $fromcache;
		}

		if ( $this->propsCache === false ) {
			$this->propsCache = [ ];
		}

		// we have it memc
		if ( array_key_exists( $prop, $this->propsCache ) ) {
			wfProfileOut( __METHOD__ . "_1" );
			wfProfileOut( __METHOD__ );
			return $this->propsCache[ $prop ];
		}

		// we don't lets add it
		$this->propsCache[ $prop ] = wfGetWikiaPageProp( $prop, $this->getId() );

		$cache->set( $key, $this->propsCache );
		wfProfileOut( __METHOD__ . "_1" );
		wfProfileOut( __METHOD__ );
		return $this->propsCache[ $prop ];
	}

	protected function isMarkInProps( $prop ) {
		return $this->getPropVal( $prop ) == 1;
	}

	protected function getPropCacheKey() {
		return wfMemcKey( __CLASS__, __METHOD__, $this->cityId, $this->getId(), 'v5' );
	}

	private function getCache() {
		return F::App()->wg->Memc;
	}

	public function getId() {
		$id = $this->title->getArticleId();
		if ( !empty( $id ) ) {
			return $id;
		}
		return 0;
	}

	/**
	 * @return null|ArticleComment
	 */
	public function getArticleComment() {
		if ( empty( $this->articleComment ) ) {
			$this->articleComment = ArticleComment::newFromTitle( $this->title );
		}

		return $this->articleComment;
	}

	public function getData( $master = false, $title = null ) {
		return $this->getArticleComment()->getData( $master, $title );
	}

	public function showVotes() {
		return in_array( MWNamespace::getSubject( $this->title->getNamespace() ), F::App()->wg->WallVotesNS );
	}

	public function showTopics() {
		return in_array( MWNamespace::getSubject( $this->title->getNamespace() ), F::App()->wg->WallTopicsNS );
	}

	public function canVotes( User $user ) {
		return $this->showVotes() && $user->isLoggedIn() && !$user->isBlocked();
	}

	public function isAllowedNotifyEveryone() {
		$app = F::App();
		return $this->helper->isAllowedNotifyEveryone( $this->title->getNamespace(), $app->wg->User );
	}

	/**
	 * Check if user can move WallMessage
	 *
	 * @param User $user
	 * @param bool|true $shouldLogBlockInStats
	 * @return bool
	 */
	public function canMove( User $user, $shouldLogBlockInStats = true ) {
		return ( $this->isMain() && !$this->isRemove() &&
			$this->can( $user, 'wallmessagemove', $shouldLogBlockInStats ) &&
			in_array( MWNamespace::getSubject( $this->title->getNamespace() ), F::App()->wg->WallTopicsNS ) );
	}

	/**
	 * @desc calls purgeSquid() on $title instance and invalidateCache() on Wall's title instance
	 * The flow then goes to TitleGetSquidURLs hook which cleans the list of URLs in Wall and Forum
	 */
	public function invalidateCache() {
		if ( $this->title instanceof Title ) {
			$this->getWall()->getTitle()->invalidateCache(); // bumps page_touched
			wfWaitForSlaves();
			$this->title->purgeSquid();
		}
	}

	/**
	 * @param Integer $namespace Message_Wall or Board namespace
	 *
	 * @return array
	 */
	public function getSquidURLs( $namespace ) {
		$urls = [ ];
		$this->load( true );

		// While creating a new forum board the message id === 0
		// Therefore we're getting at this place invalid URLs to be purge
		// To quick fix it we use $idDB variable...
		if ( $this->getMessagePageId() > 0 ) {
			if ( $this->isMain() ) {
				$urls[] = $this->getMessagePageUrl( true );
			} else {
				/** @var WallMessage $parent */
				$parent = $this->getTopParentObj();
				$parent->load( true );
				$urls[] = $parent->getMessagePageUrl( true );
			}

			// CONN-430: Purge wall page / forum board
			$title = Title::newFromText( $this->getMainPageText(), $namespace );
			if ( !empty( $title ) ) {
				$urls[] = $title->getFullURL();
			}
		}

		return $urls;
	}

}

<?php

/* smart proxy to article comment */

class WallMessage {
	protected $articleComment;
	protected $title;
	protected $order = 0;
	protected $isLoaded = false;
	protected $propsCache = array();
	protected $cityId = 0;
	protected static $permissionsCache = array(); //permissions cache
	protected static $wallURLCache = array();
	/**
	 * @var $commentsIndex CommentsIndex
	 */
	public $commentsIndex;
	/**
	 * @var $helper WallHelper
	 */
	public $helper;

	/**
	 * @var $mActionReason array
	 */
	public $mActionReason;

	function __construct(Title $title, $articleComment = null) {
		wfProfileIn(__METHOD__);
		$this->title = $title;
		$this->articleComment = $articleComment;
		$app = F::App();
		//TODO: inject this
		$this->cityId = $app->wg->CityId;

		$this->helper = new WallHelper();
		wfProfileOut(__METHOD__);
	}

	static public function newFromId($id, $master = false) {
		wfProfileIn(__METHOD__);

		if( $master == true ) {
			$title = Title::newFromId($id, Title::GAID_FOR_UPDATE);
		} else {
			$title = Title::newFromId($id);
		}

		if( $title instanceof Title && $title->exists() ) {
			wfProfileOut(__METHOD__);
			return  WallMessage::newFromTitle($title);
		}

		if( $master == false ) {
			wfProfileOut(__METHOD__);
			// if you fail from slave try again from master
			return self::newFromId( $id, true );
		}

		wfProfileOut(__METHOD__);
		return null;
	}

	static public function addMessageWall( $userPageTitle ) {
		wfProfileIn(__METHOD__);
		$botUser = User::newFromName( 'WikiaBot' );
		$article = new Article($userPageTitle);
		$status = $article->doEdit( '', '', EDIT_NEW | EDIT_MINOR | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT, false, $botUser );
		$title = ( $status->isOK() ) ? $article->getTitle() : false ;
		wfProfileOut(__METHOD__);
		return $title;
	}

	/**
	 * @static
	 * @param $body
	 * @param $page
	 * @param $user
	 * @param string $metaTitle
	 * @param bool|WallMessage $parent
	 * @param array $relatedTopics
	 * @param bool $notify
	 * @param bool $notifyEveryone
	 * @return WallMessage|Bool
	 */
	static public function buildNewMessageAndPost( $body, $page, $user, $metaTitle = '', $parent = false, $relatedTopics = array(), $notify = true, $notifyEveryone = false) {
		wfProfileIn(__METHOD__);
		if($page instanceof Title ) {
			$userPageTitle = $page;
		} else {
			$userPageTitle = Title::newFromText($page, NS_USER_WALL);
		}

		// if message wall was just created, we should later use MASTER db when creating title object
		$newMessageWall = false;
		// create wall page by bot if not exist
		if ( $userPageTitle instanceof Title && !$userPageTitle->exists() ) {
			$userPageTitle = self::addMessageWall( $userPageTitle );
			$newMessageWall = true;
		}

		if( empty($userPageTitle) ) {
			Wikia::log(__METHOD__, '', '$userPageTitle not an instance of Title');
			Wikia::logBacktrace(__METHOD__);

			wfProfileOut(__METHOD__);
			return false;
		}

		if( $parent === false ) {
			$metaData = array('title' => $metaTitle );
			if( $notifyEveryone ) {
				$metaData['notify_everyone'] = time();
			}

			if( !empty($relatedTopics) ) {
				$metaData['related_topics'] = implode('|', $relatedTopics);
			}

			$acStatus = ArticleComment::doPost( $body, $user, $userPageTitle, false , $metaData );
		} else {
			if( !$parent->canReply() ) {
				wfProfileOut(__METHOD__);
				return false;
			}

			$acStatus = ArticleComment::doPost( $body, $user, $userPageTitle, $parent->getId() , null );
		}

		if( $acStatus === false ) {
			wfProfileOut(__METHOD__);
			return false;
		}

		$ac = ArticleComment::newFromId( $acStatus[1]->getId() );
		if( empty( $ac ) ) {
			wfProfileOut(__METHOD__);
			return false;
		}
		// after successful posting invalidate Wall cache
		/**
		 * @var $class WallMessage
		 */
		$class = new WallMessage( $ac->getTitle(), $ac );

		if($parent === false) {//$db = DB_SLAVE
			$class->storeRelatedTopicsInDB( $relatedTopics );
			$class->setOrderId( 1 );
			$class->getWall()->invalidateCache();
		} else {
			$count = $parent->getOrderId( true ); //this is not work perfect with transations
			if(is_numeric($count)){
				$count++;
				$parent->setOrderId( $count );
				$class->setOrderId( $count );
			}
			// after successful posting invalidate Thread cache
			$class->getThread()->invalidateCache();
			$rp = new WallRelatedPages();
			$rp->setLastUpdate($parent->getId());
		}
		//Build data for sweet url ? id#number_of_comment
		//notify
		if($notify) {
			$class->sendNotificationAboutLastRev( $newMessageWall );
		}

		if($parent === false && $notifyEveryone) {
			$class->notifyEveryone();
		}

		$class->addWatch($user);

		wfRunHooks( 'AfterBuildNewMessageAndPost', array(&$class) );
		wfProfileOut(__METHOD__);
		return $class;
	}

	static public function newFromTitle(Title $title) {
		wfProfileIn(__METHOD__);
		$class = new WallMessage($title);
		wfProfileOut(__METHOD__);
		return $class;
	}

	static public function newFromArticleComment(ArticleComment $articleComment) {
		wfProfileIn( __METHOD__ );
		$class = new WallMessage( $articleComment->getTitle(), $articleComment );
		wfProfileOut( __METHOD__ );
		return $class;
	}

	public function setOrderId($val = 1) {
		wfProfileIn( __METHOD__ );
		$this->setInProps(WPP_WALL_COUNT, $val);
		$this->order = $val;
		wfProfileOut( __METHOD__ );
		return $val;
	}

	public function getCommentsIndex() {
		if(empty($this->commentsIndex)) {
			$this->commentsIndex = CommentsIndex::newFromId( $this->getId() );
		}

		return $this->commentsIndex;
	}

	public function getOrderId($for_update = false) {
		wfProfileIn(__METHOD__);
		if($for_update) {
			wfProfileOut(__METHOD__);
			return wfGetWikiaPageProp(WPP_WALL_COUNT, $this->getId(), DB_MASTER);
		}

		if($this->order != 0) {
			wfProfileOut(__METHOD__);
			return $this->order;
		}

		$out = $this->getPropVal(WPP_WALL_COUNT);
		wfProfileOut(__METHOD__);
		return $out;
	}

	public function addNewReply($body, $user) {
		wfProfileIn( __METHOD__ );
		$out = self::buildNewMessageAndPost($body, $this->getWallTitle(), $user, '', $this );
		wfProfileOut( __METHOD__ );
		return $out;
	}

	public function storeRelatedTopicsInDB($relatedTopicURLs) {
		wfRunHooks('WallBeforeStoreRelatedTopicsInDB', array($this->getTopParentId(), $this->getTitle()->getArticleId(), $this->getTitle()->getNamespace() ));
		$rp = new WallRelatedPages();
		$rp->setWithURLs($this->getId(), $relatedTopicURLs);
		wfRunHooks('WallAfterStoreRelatedTopicsInDB', array($this->getTopParentId(), $this->getTitle()->getArticleId(), $this->getTitle()->getNamespace() ));
	}

	public function getRelatedTopics() {
		$rp = new WallRelatedPages();
		return $rp->getMessagesRelatedArticleTitles($this->getId());
	}

	public function canEdit(User $user){
		wfProfileIn( __METHOD__ );
		$out = $this->can( $user, 'edit' ) && ( $this->isAuthor($user) || $this->can($user, 'walledit') || $this->can($user, 'rollback') );
		wfProfileOut( __METHOD__ );
		return $out;
	}

	public function doSaveComment($body, $user, $summary = '', $force = false, $preserveMetadata = false) {
		wfProfileIn( __METHOD__ );

		if($this->canEdit($user) || $force){
			$this->getArticleComment()->doSaveComment( $body, $user, null, 0, true, $summary, $preserveMetadata );
		}
		if( !$this->isMain() ) {
			// after changing reply invalidate thread cache
			$this->getThread()->invalidateCache();
		}
		if ( !$preserveMetadata ) { // it's only a request to modify metadata, so we probably don't need to add watch
			/**
			 * mech: EditPage calls Article with watchThis set to false
			 *      in Wall we assume that save on message subscribes you to it
			 *      so we re-scubscribe it here
			*/
			$this->addWatch( $user );
		}
		$out = $this->getArticleComment()->parseText($body);
		wfProfileOut( __METHOD__ );
		return $out;
	}

	public function doSaveMetadata($user, $summary = '', $force = false) {
		wfProfileIn( __METHOD__ );
		//@todo: as getRawText overwrites the metadata, we have to make a copy of it
		//this is done only to quickly fix case 102384, this whole thing should be refactored
		$metadataCopy = $this->getArticleComment()->mMetadata;
		$body = $this->getRawText(true);
		$this->getArticleComment()->mMetadata = $metadataCopy;
		$out = $this->doSaveComment( $body, $user, $summary, $force, true );
		wfProfileOut( __METHOD__ );
		return $out;
	}

	protected function can($user, $prev ) {
		wfProfileIn( __METHOD__ );
		$username = $user->getName();
		if(isset(self::$permissionsCache[$username][$prev])) {
			wfProfileOut( __METHOD__ );
			return self::$permissionsCache[$username][$prev];
		}

		if(empty(self::$permissionsCache[$username])) {
			self::$permissionsCache[$username] = array();
		}

		wfProfileIn( __METHOD__."2" );
		if($prev == 'wallshowwikiaemblem') {
			self::$permissionsCache[$username][$prev] = $user->isAllowed($prev);
		} else {
			self::$permissionsCache[$username][$prev] = $user->isAllowed($prev) && !$user->isBlocked();
		}
		wfProfileOut( __METHOD__."2" );

		wfProfileOut( __METHOD__ );
		return self::$permissionsCache[$username][$prev];
	}

	public function showWikiaEmblem() {
		return $this->can($this->getUser(), 'wallshowwikiaemblem');
	}

	public function canDelete(User $user){
		return $this->can($user, 'walldelete') && $user->getOption('walldelete', false);
	}

	public function canRemove(User $user){
		return $this->can($user, 'wallremove');
	}

	public function canAdminDelete(User $user) {
		return $this->can($user, 'walladmindelete') && !$this->isAdminDelete() && $this->isRemove() && $this->isMain();
	}

	public function canFastAdminDelete(User $user) {
		return $this->can($user, 'wallfastadmindelete');
	}

	public function canFastrestore(User $user) {
		return $this->can($user, 'walladmindelete') || $this->isWallOwner($user);
	}

	/**
	 * archive is "close".
	 */
	public function canArchive(User $user) {
		return in_array(MWNamespace::getSubject($this->title->getNamespace()), F::app()->wg->WallThreadCloseNS) && $this->can($user, 'wallarchive') && !$this->isRemove() && !$this->isArchive() && !$this->isRemove() && $this->isMain();
	}

	public function canReopen(User $user) {
		return in_array(MWNamespace::getSubject($this->title->getNamespace()), F::app()->wg->WallThreadCloseNS) && $this->can($user, 'wallarchive') && !$this->isRemove() && $this->isArchive() && $this->isMain();
	}

	public function getMetaTitle() {
		return $this->getArticleComment()->getMetadata('title');
	}

	public function getNotifyeveryone() {
		$out = (int ) $this->getArticleComment()->getMetadata('notify_everyone');
		$ageInDays = (time() - $out)/(60*60*24);

		if( $ageInDays < 30  ){
			return true;
		} else {
			return false;
		}
	}

	public function canNotifyeveryone() {
		if($this->isMain() && !$this->isArchive() && !$this->isRemove() ) {
			if(!$this->isAllowedNotifyEveryone()) {
				return false;
			}
			return !$this->getNotifyeveryone();
		}
		return false;
	}

	public function canUnnotifyeveryone() {
		if($this->isMain()) {
			if(!$this->isAllowedNotifyEveryone()) {
				return false;
			}
			return $this->getNotifyeveryone();
		}
		return false;
	}
	public function setNotifyeveryone($notifyeveryone, $save = false ) {
		if($this->isMain()) {
			if(!$this->isAllowedNotifyEveryone()) {
				return false;
			}
			$app = F::App();
			$wne = new WallNotificationsEveryone();
			$this->load(true);
			if($notifyeveryone) {
				$this->getArticleComment()->setMetaData('notify_everyone', time());
				$this->doSaveMetadata( $app->wg->User, wfMsgForContent( 'wall-message-update-highlight-summary' ), false, true );
				$rev = $this->getArticleComment()->mLastRevision;
				$notif = WallNotificationEntity::createFromRev($rev, $this->cityId);
				$wne->addNotificationToQueue($notif);
			} else {
				$this->getArticleComment()->removeMetadata('notify_everyone');
				$pageId = $this->getId();
				$wne->removeNotificationFromQueue($pageId);
				$this->doSaveMetadata( $app->wg->User, wfMsgForContent( 'wall-message-update-removed-highlight-summary' ), false, true );
			}
		}
	}

	public function setMetaTitle($title) {
		if($this->isMain()) {
			$this->getArticleComment()->setMetaData('title', $title);
		}
		return true;
	}

	public function setRelatedTopics($user, $relatedTopics) {
		if($this->isMain()) {
			$this->getArticleComment()->setMetaData('related_topics', implode('|', $relatedTopics));
			$this->doSaveMetadata( $user, wfMsgForContent( 'wall-message-update-topics-summary' ), true );
			$this->storeRelatedTopicsInDB($relatedTopics);
		}
		return true;
	}

	public function markAsMove($user) {
		if($this->isMain()) {
			$this->getArticleComment()->setMetaData('lastmove', time(), true);
			$this->doSaveMetadata( $user, wfMsgForContent( 'wall-action-move-topics-summary', $this->getWall()->getTitle()->getPrefixedText() ), true );
		}
		return true;
	}


	public function getWallOwnerName() {
		$title = $this->getWallTitle();
		$parts = explode( '/', $title->getText() );
		$wallOwnerName = $parts[0];

		wfRunHooks( 'WallMessageGetWallOwnerName', array( $title, &$wallOwnerName ) );

		return $wallOwnerName;
	}

	public function getWallOwner( $master = false ) {
		$parts = explode( '/', $this->getWallTitle( $master )->getText() );
		$userName = $parts[0];
		// mech: I'm not sure we have to create wall title doing db queries on both, page and comments_index tables.
		// as the user name is the first part on comment's title. But I'm not able to go through all wall/forum
		// usecases. I'm going to check production logs for the next 2-3 sprints and make sure the result is
		// always correct
		$titleText = $this->title->getText();
		$parts = explode( '/', $titleText );
		if ( $parts[0] != $userName ) {
			Wikia::log( __METHOD__, false, 'WALL_PERF article title owner does not match ci username (' . $userName .
				' vs ' . $parts[0] . ') for ' . $this->getId() . ' (title is ' . $titleText. ')', true );
		}

		$wall_owner = User::newFromName( $userName, false );

		if( empty($wall_owner) ) {
			error_log('EMPTY_WALL_OWNER: (id)'. $this->getId());
		}
		return $wall_owner;
	}

	public function getWallPageUrl() {
		return $this->getWallTitle()->getFullUrl();
	}


	//TODO: remove get wall title
	public function getWallTitle( $master = false ){
		return $this->getArticleTitle( $master );
	}

	public function getArticleTitle( $master = false ){
		$commentsIndex = $this->getCommentsIndex();

		if(empty($commentsIndex)) {
			return Title::newFromText('empty');
		}

		$pageId = $commentsIndex->getParentPageId();

		static $cache = array();
		if(empty($cache[$pageId])) {
			if ( !$master ) {
				$cache[$pageId] = Title::newFromId( $pageId );
				// make sure this did not happen due to master-slave delay
				// if so, this is a bug in the code, as $master flag should be set to true
				// we want to log this and fix it
				if( empty($cache[$pageId]) ) {
					$cache[$pageId] = Title::newFromId( $pageId, Title::GAID_FOR_UPDATE );
					if ( !empty( $cache[$pageId] ) ) {
						Wikia::log( __METHOD__, false, "WALL_BUG - title does not exist in slave db yet - fix it!", true );
					}
				}
			} else {
				$cache[$pageId] = Title::newFromId( $pageId, Title::GAID_FOR_UPDATE );
			}
		}

		if( empty($cache[$pageId]) ){
			return Title::newFromText('empty');
		}

		return $cache[$pageId];
	}

	/**
	 * @return Wall
	 */
	public function getWall() {
		$wall = Wall::newFromTitle( $this->getWallTitle() );
		return $wall;
	}

	public function getThread() {
		$wm = $this;
		if( $this->isMain() == false ) {
			$wm = $this->getTopParentObj();
		}
		return WallThread::newFromId( $wm->getId() );
	}

	public function getPageUrlPostFix() {
		wfProfileIn(__METHOD__);
		if($this->isMain()){
			wfProfileOut(__METHOD__);
			return '';
		}

		$order = $this->getOrderId();
		if($order != null) {
			$res = $order;
		} else {
			$res = $this->getId();
		}
		wfProfileOut(__METHOD__);
		return $res;
	}

	public function getMessagePageId() {

		if($this->isMain()){
			$id = $this->getId();
		} else {
			$topParent = $this->getTopParentObj();
			$id = $topParent->getId();
		}

		return $id;
	}

	public function getMessagePageUrl($withoutAnchor = false) {

		wfProfileIn(__METHOD__);
		//local cache consider cache this in memc
		if(!empty($this->messagePageUrl)) {
			wfProfileOut(__METHOD__);
			return $this->messagePageUrl[$withoutAnchor];
		}

		$id = $this->getMessagePageId();

		$postFix = $this->getPageUrlPostFix();
		$postFix = empty($postFix) ? "":('#'.$postFix);
		$title = Title::newFromText($id, NS_USER_WALL_MESSAGE);

		$this->messagePageUrl = array();

		$this->messagePageUrl[true] = $title->getFullUrl();
		$this->messagePageUrl[false] = $this->messagePageUrl[true].$postFix;

		wfProfileOut(__METHOD__);
		return $this->messagePageUrl[$withoutAnchor];
	}

	public function getArticleId(&$articleData = null) {
		$title = $this->getArticleComment()->getTitle();
		$articleId = $this->getArticleComment()->getTitle()->getArticleId();

		if( $articleId === false ) {
			Wikia::log(__METHOD__, false, "WALL_NO_ARTILE_ID" . print_r(array('$title' => $title), true));
			$articleId = 0;
		}

		return $articleId;
	}

	/**
	 * @deprecated Probably we'll remove it it was supposed to return article timestamp but the article doesn't seem right one. more info in WallMessage::remove()
	 */
	public function getArticleTimestamp(&$articleData = null) {
		$articleId = $this->getId();

		if( $articleId !== 0 ) {
			$article = Article::newFromID($articleId);
			return $article->getTimestamp();
		}

		return null;
	}

	public function getWallUrl() {
		return $this->getArticleTitle()->getFullUrl();
	}

	/**
	 * @return null|ArticleComment
	 */
	public function getTopParentObj(){
		wfProfileIn(__METHOD__);

		static $topObjectCache = array();

		//TODO: some cache or pre setting of parentPageId during list fetching

		$index = $this->getCommentsIndex();
		if(empty($index)) {
			wfProfileOut(__METHOD__);
			return null;
		}

		$id = $index->getParentCommentId();
		if( !empty($topObjectCache[$id]) ) {
			wfProfileOut(__METHOD__);
			return $topObjectCache[$id];
		}

		wfProfileOut(__METHOD__);
		$topObjectCache[$id] = WallMessage::newFromId($id);
		return $topObjectCache[$id];
	}

	public function	getTopParentId() {
		$top = $this->getTopParentObj();
		if(empty($top)) {
			return null;
		}
		return $this->getId();
	}

	public function isMain() {
		$top = $this->getTopParentObj();
		if(empty($top)) {
			return true;
		}
		return false;
	}

	public function isWallOwner(User $user) {
		$wallUser = $this->getWallOwner();
		if(empty($wallUser)) {
			return false;
		}

		return $wallUser->getId() == $user->getId();
	}

	public function load($master = false) {
		if($this->isLoaded) {
			return true;
		}
		$this->isLoaded = true;
		return $this->getArticleComment()->load($master);
	}

	public function getUser(){
		/*
		 * During posting message as bot we are adding information about admin of wiki
		 * and when we are displaying this message we are loading user information from this data
		 */

		if($this->isMain()) {
			$user = $this->getPostedAsBot();
			if(!empty($user)) {
				return $user;
			}
		}

		$user = $this->getArticleComment()->mUser;
		if($user) {
			return $user;
		} else {
			// this only happend for wrong enties in DB
			// without revision information
			return User::newFromName('0.0.0.0', false);
		}
	}

	/**
	 * Will return either username if user exists, or it will return "A Wikia Contributor" (i18n translated) if user is an anon
	 */
	public function getUserDisplayName() {
		$displayName = '';

		if($this->getUser()->getId() == 0) {
			$displayName = wfMsg('oasis-anon-user');
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

		if(empty(self::$wallURLCache[$name])) {
			if($this->getUser()->getId() == 0) { // anynymous contributor
				$url = Skin::makeSpecialUrl('Contributions').'/'.$this->getUser()->getName();
			} else if(empty(F::app()->wg->EnableWallExt)) {
				$url = Title::newFromText( $name, NS_USER_TALK )->getFullUrl();
			} else {
				$url = Title::newFromText( $name, NS_USER_WALL )->getFullUrl();
			}
			self::$wallURLCache[$name] = $url;
		}

		return self::$wallURLCache[$name];
	}

	public function getText() {
		return $this->getArticleComment()->getText();
	}

	public function getHeadItems() {
		$ac = $this->getArticleComment();

		if(!empty($ac->mHeadItems)) {
			return $ac->mHeadItems;
		}

		return array();
	}

	public function getCreateTime($format = TS_ISO_8601) {
		return wfTimestamp($format, $this->getCreateTimeRAW() );
	}

	public function getCreateTimeRAW() {
		$ac = $this->getArticleComment();
		if( $ac && $ac->mFirstRevision ) {
			return $ac->mFirstRevision->getTimestamp();
		}
		return null;
	}

	public function getRawText($master = false) {
		$this->load($master);
		$data = $this->getData();
		return $data['rawtext'];

	}

	public function getEditor(){
		$user = User::newFromId($this->getArticleComment()->mLastRevision->getUser());
		return $user;
	}

	public function getEditTime($format){
		$r = $this->getArticleComment()->mLastRevision;
		if (!$r) return null; // BugId:22821
		return wfTimestamp($format, $r->getTimestamp());
	}

	public function notifyEveryone() {
		$rev = $this->getArticleComment()->mLastRevision;

		if(empty($rev)) {
			return true;
		}

		$notif = WallNotificationEntity::createFromRev($rev, $this->cityId);

		/*
		 * experimental notfieverone
		 */

		$wne = new WallNotificationsEveryone();
		$wne->addNotificationToQueue($notif);
	}

	public function getVoteHelper() {
		if(!empty($this->voteVoteHelper)) {
			return $this->voteVoteHelper;
		}
		$app = F::App();
		$this->voteVoteHelper = new VoteHelper( $app->wg->User, $this->getId() );
		return $this->voteVoteHelper;
	}

	public function vote($user) {
		if(!$this->canVotes($user)) {
			return false;
		}

		$this->getVoteHelper()->addVote();
	}

	public function removeVote($user) {
		if(!$this->canVotes($user)) {
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

	public function getVotersList() {
		return $this->getVoteHelper()->getVotersList();
	}

	public function isEdited() {
		return $this->getArticleComment()->mLastRevId != $this->getArticleComment()->mFirstRevId;
	}

	public function getLastEditSummery() {
		$lastRev = Revision::newFromId($this->getArticleComment()->mLastRevId);

		if(empty($lastRev)) {
			return false;
		}

		return $lastRev->getComment();
	}

	public function isAuthor(User $user){
		return $this->getArticleComment()->isAuthor($user);
	}

	public function isWallWatched(User $user) {
		return $user->isWatched( $this->getWallTitle() );
	}

	public function isWatched(User $user) {
		return $user->isWatched( $this->title );
	}

	public function addWatch(User $user) {
		if( !$this->isMain() ) {
			$parent = $this->getTopParentObj();
			if ($parent) $user->addWatch( $parent->getTitle() );
		} else {
			$user->addWatch( $this->title );
		}
	}

	public function removeWatch(User $user) {
		if( !$this->isMain() ) {
			$parent = $this->getTopParentObj();
			if ($parent) $user->removeWatch( $parent->getTitle() );
		} else {
			$user->removeWatch( $this->title );
		}

	}

	public function getCreatTime($format) {
		return wfTimestamp($format,$this->getCreateTimeRAW());
	}

	public function getTitle() {
		return $this->title;
	}

	protected function recordAdminHistory($user, $reason, $history, $notifyAdmins = false) {
		$wnae = $this->getAdminNotificationEntity($user, $reason);
		if($notifyAdmins) {
			$this->addAdminNotificationFromEntity($wnae);
		}

		$wh = new WallHistory($this->cityId);
		$wh->add( $history, $wnae, $user );
	}

	public function archive($user, $reason = '') {
		$status = $this->markInProps(WPP_WALL_ARCHIVE);
		$this->recordAdminHistory($user, $reason, WH_ARCHIVE);
		$this->saveReason($user, $reason);
		$this->customActionNotifyRC($user, 'wall_archive', $reason);
		return $status;
	}

	public function reopen($user) {
		$this->unMarkInProps(WPP_WALL_ARCHIVE);
		$this->recordAdminHistory($user, '', WH_REOPEN);
		$this->customActionNotifyRC($user, 'wall_reopen', '');
		return true;
	}

	public function remove($user, $reason = '', $notifyAdmins = false) {
		$this->saveReason($user, $reason);

		$this->unMarkInProps(WPP_WALL_ARCHIVE);
		$status = $this->markInProps(WPP_WALL_REMOVE);

		if( $status === true ) {
			$this->customActionNotifyRC($user, 'wall_remove', $reason);

			$this->recordAdminHistory($user, $reason, WH_REMOVE, $notifyAdmins);

			if( $this->isMain() === true ) {
				$this->getWall()->invalidateCache();
				$wnoe = $this->getOwnerNotificationEntity($user, $reason);
				$this->addOwnerNotificationFromEntity($wnoe);
			} else {
				$this->getThread()->invalidateCache();
			}
			$this->hideRelatedNotifications();
		}

		$this->addWatch($user);

		return $status;
	}

	protected function addAdminNotificationFromEntity($wnae) {
		$wna = new WallNotificationsAdmin;
		$wna->addAdminNotificationFromEntity( $wnae );
	}

	protected function getAdminNotificationEntity($user, $reason) {
		$this->load();
		$wikiId = $this->cityId;
		$userIdRemoving = $user->getId();
		$userIdWallOwner = $this->getWallOwner()->getId();
		$parentPageId = $this->getArticleTitle()->getArticleId();

		$url = $this->getMessagePageUrl();
		$title = $this->getMetaTitle();
		$messageId = $this->getId();

		if( $this->isMain() ) {
			$wnae = new WallNotificationAdminEntity($wikiId, $parentPageId, $userIdRemoving, $userIdWallOwner, $title, $url, $messageId, 0, false, $reason);
		} else {
			$parent = $this->getTopParentObj();
			$parent->load();
			$parentMessageId = $parent->getId();
			$title = $parent->getMetaTitle();
			$wnae = new WallNotificationAdminEntity($wikiId, $parentPageId, $userIdRemoving, $userIdWallOwner, $title, $url, $messageId, $parentMessageId, true, $reason);
		}

		return $wnae;
	}

	protected function addOwnerNotificationFromEntity($wnoe) {
		$wno = new WallNotificationsOwner;
		$wno->addOwnerNotificationFromEntity( $wnoe );
	}

	protected function getOwnerNotificationEntity($user, $reason) {
		$this->load();
		$wikiId = $this->cityId;
		$userIdRemoving = $user->getId();
		$userIdWallOwner = $this->getWallOwner()->getId();
		$url = $this->getMessagePageUrl();
		$title = $this->getMetaTitle();
		$messageId = $this->getId();

		if( $this->isMain() ) {
			$wnoe = new WallNotificationOwnerEntity($wikiId, $userIdRemoving, $userIdWallOwner, $title, $url, $messageId, 0, false, $reason);
		} else {
			$parent = $this->getTopParentObj();
			$parent->load();
			$parentMessageId = $parent->getId();
			$title = $parent->getMetaTitle();
			$wnoe = new WallNotificationOwnerEntity($wikiId, $userIdRemoving, $userIdWallOwner, $title, $url, $messageId, $parentMessageId, true, $reason);
		}

		return $wnoe;
	}

	public function adminDelete($user, $reason = '', $notifyAdmins = false) {
		$this->saveReason($user, $reason);
		$status = $this->markInProps(WPP_WALL_ADMINDELETE);

		if( $status === true ) {
			$this->customActionNotifyRC($user, 'wall_admindelete', $reason);

			$wnae = $this->getAdminNotificationEntity($user, $reason);
			if($notifyAdmins) {
				$this->addAdminNotificationFromEntity($wnae);
			}

			$wh = new WallHistory($this->cityId);
			$wh->add( WH_DELETE, $wnae, $user );

			if( $this->isMain() === true ) {
				$this->getWall()->invalidateCache();
				$wnoe = $this->getOwnerNotificationEntity($user, $reason);
				$this->addOwnerNotificationFromEntity($wnoe);
			} else {
				$this->getThread()->invalidateCache();
			}
			$this->hideRelatedNotifications();
		}

		$this->addWatch($user);

		return $status;
	}

	public function fastAdminDelete($user) {
		if( $this->adminDelete($user) ){
			return true;
		}

		return false;
	}

	protected function customActionNotifyRC($user, $action, $reason) {
		$articleId = $this->getId();
		$target =  $this->getTitle();

		RecentChange::notifyLog(
			wfTimestampNow(),
			$target,
			$user,				//user
			'',					//articleComment
			'',					//ip
			RC_EDIT,			//rc_log_type
			$action,			//rc_action
			$target,
			$reason,			//rc_comment
			'',					//params
			0					//new id
		);
	}

	public function delete( $reason ){
		$this->load(true);

		$this->removeRelatedNotifications();

		if( $this->isMain() === true ) {
			$obj = $this->getWall();
		} else {
			$obj = $this->getThread();
		}

		$retval = $this->getArticleComment()->doDeleteComment( $reason, true );
		$obj->invalidateCache();
		return $retval;
	}

	public function removeRelatedNotifications() {
		if( $this->isMain() ) {
			$wn = new WallNotifications;
			$uniqueId = $this->getId();
			$wn->remNotificationsForUniqueID( null, $this->cityId, $uniqueId, false );

			$wna = new WallNotificationsAdmin;
			$wna->removeForThread( $this->cityId, $this->getId() );
		}
	}

	public function hideRelatedNotifications() {
		if( $this->isMain() ) {
			$wn = new WallNotifications;
			$uniqueId = $this->getId();
			$wn->remNotificationsForUniqueID( null, $this->cityId, $uniqueId, true );
		}
	}

	public function isArchive() {
		return $this->isMarkInProps(WPP_WALL_ARCHIVE);
	}

	public function isRemove() {
		return $this->isMarkInProps(WPP_WALL_REMOVE);
	}

	public function isAdminDelete() {
		return $this->isMarkInProps(WPP_WALL_ADMINDELETE);
	}

	public function canReply() {
		return !$this->isArchive() && !$this->isAdminDelete() && !$this->isRemove();
	}

	public function canRestore($user) {
		wfProfileIn(__METHOD__);
		if( $this->isAdminDelete() ) {
			if($this->can($user, 'walladmindelete')) {
				wfProfileOut(__METHOD__);
				return true;
			}
		} elseif($this->isRemove()) {
			if($this->canRemove($user)) {
				wfProfileOut(__METHOD__);
				return true;
			}
		}
		wfProfileOut(__METHOD__);
		return false;
	}

	public function isVisible($user) {
		if(!$this->isAdminDelete($user)) {
			return true;
		}

		return false;
	}

	/*
	 * expanded view, you can use it if you want to check if you can see deleted message
	 */

	public function canViewDeletedMessage($user) {
		if($this->can($user, 'walladmindelete')) {
			return true;
		}

		return false;
	}

	/*
	 * put it back in remove status
	 */

	public function undoAdminDelete($user) {
		$this->restore($user, '');
		$this->remove($user, '');
	}

	public function restore($user, $reason = '') {
		$this->unMarkInProps(WPP_WALL_REMOVE);
		$this->unMarkInProps(WPP_WALL_ADMINDELETE);
		$this->customActionNotifyRC($user, 'wall_restore', $reason);

		$wne = $this->getAdminNotificationEntity($user, $reason);
		$wh = new WallHistory($this->cityId);
		$wh->add( WH_RESTORE, $wne, $user );

		$this->addWatch($user);

		$wn = new WallNotifications;
		if( $this->isMain() ) {
			$wn->unhideNotificationsForUniqueID($this->cityId, $this->getId() );
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

	//TODO: cache it
	public function getLastActionReason() {
		if(empty($this->mActionReason)) {
			$info = wfGetWikiaPageProp( WPP_WALL_ACTIONREASON, $this->getId());
		} else {
			$info = $this->mActionReason;
		}

		if(empty($info['userid'])) {
			return false;
		}

		$user = User::newFromId($info['userid']);
		if(empty($user)) {
			return false;
		}

		$info['isotime'] =  wfTimestamp(TS_ISO_8601, $info['time']);
		$info['mwtime'] =  wfTimestamp(TS_MW, $info['time']);

		$info['user'] = $user;

		$displayname = $user->getName();

		$user_link = $user->getUserPage()->getFullURL();

		$info['user_displayname_linked'] = Xml::openElement('a', array('href'=>$user_link)) . $displayname . Xml::closeElement('a');

		$info['status'] = $this->isAdminDelete() ? 'deleted' : 'removed';

		return $info;
	}

	protected function saveReason( $user, $reason ) {
		$this->mActionReason = array(
			'reason' => strip_tags($reason),
			'userid' => $user->getId(),
			'time' => wfTimestampNow()
		);

		wfSetWikiaPageProp( WPP_WALL_ACTIONREASON, $this->getId(), $this->mActionReason);
	}

	public function getQuoteOf() {
		$id = $this->getPropVal(WPP_WALL_QUOTE_OF);
		if(empty($id)) {
			return false;
		}

		$msg = WallMessage::newFromId($id);

		if(empty($msg)) {
			return false;
		}

		return $msg;
	}

	public function setQuoteOf($id) {
		if($this->isMain()) {
			return false;
		}

		$msgParent = $this->getTopParentObj();
		/**
		 * @var $quotedMsg WallMessage
		 */
		$quotedMsg = WallMessage::newFromId($id, true);

		if(empty($quotedMsg)) {
			return false;
		}

		if($quotedMsg->isMain()) {
			if($quotedMsg->getId() != $msgParent->getId()) {
				return false;
			}
		} else {
			$quotedMsgParent = $quotedMsg->getTopParentObj();
			if($quotedMsgParent->getId() !=  $msgParent->getId()) {
				return false;
			}
		}

		$this->setInProps(WPP_WALL_QUOTE_OF, $id);
		return true;
	}

	/*
	 * $user - admin on wiki
	 */

	public function setPostedAsBot($user) {
		$this->addWatch($user);
		$this->setInProps(WPP_WALL_POSTEDBYBOT, $user->getId());
	}

	public function getPostedAsBot() {
		$val = $this->getPropVal(WPP_WALL_POSTEDBYBOT);
		if( ((int) $val) == 0 ) {
			return false;
		}
		$user = User::newFromId($val);

		if( $user instanceof User && $user->getId() > 0 ){
			return $user;
		}

		return false;
	}

	protected function setInCommentsIndex( $prop, $value, $useMaster = false ) {
		$commentId = $this->getId();
		if ( !empty($commentId) ) {
			$commentsIndex = $this->getCommentsIndex();
			if ( $commentsIndex instanceof CommentsIndex ) {
				switch( $prop ) {
					case WPP_WALL_ARCHIVE: $commentsIndex->updateArchived( $value );
											break;
					case WPP_WALL_ADMINDELETE: $commentsIndex->updateDeleted( $value );
												$lastChildCommentId = $commentsIndex->getParentLastCommentId( $useMaster );
												$commentsIndex->updateParentLastCommentId( $lastChildCommentId );

												wfRunHooks( 'EditCommentsIndex', array($this->getTitle(), $commentsIndex) );
												break;
					case WPP_WALL_REMOVE: $commentsIndex->updateRemoved( $value );
											$lastChildCommentId = $commentsIndex->getParentLastCommentId( $useMaster );
											$commentsIndex->updateParentLastCommentId( $lastChildCommentId );

											wfRunHooks( 'EditCommentsIndex', array($this->getTitle(), $commentsIndex) );
											break;
				}
			}
		}
	}

	protected function markInProps($prop) {
		$this->setInProps($prop, 1);
		$this->setInCommentsIndex($prop, 1);
		return true;
	}

	protected function setInProps($prop, $val = 1) {
		wfSetWikiaPageProp($prop, $this->getId(), $val);

		$key = $this->getPropCacheKey();
		$cache = $this->getCache();
		$this->propsCache = $cache->get( $key );
		$this->propsCache[$prop] = $val;

		$cache->set( $key, $this->propsCache );

		return true;
	}

	protected function unMarkInProps($prop) {
		$key = $this->getPropCacheKey();
		$this->propsCache[$prop] = false;

		$cache = $this->getCache();
		$cache->set( $key, false );

		wfDeleteWikiaPageProp( $prop, $this->getId() );

		$this->setInCommentsIndex($prop, 0, true);
	}

	protected function getPropVal($prop) {
		wfProfileIn(__METHOD__);

		$key = $this->getPropCacheKey();

		// check local memory cache
		if( array_key_exists($prop, $this->propsCache) ) {
			wfProfileOut(__METHOD__);
			return $this->propsCache[$prop];
		}

		wfProfileIn(__METHOD__."_1");
		// check memcache
		$cache = $this->getCache();
		$fromcache = $cache->get( $key );

		if(!empty($fromcache)) {
			$this->propsCache =	$fromcache;
		}

		if($this->propsCache === false) {
			$this->propsCache = array();
		}

		//we have it memc
		if( array_key_exists($prop, $this->propsCache) ) {
			wfProfileOut(__METHOD__."_1");
			wfProfileOut(__METHOD__);
			return $this->propsCache[$prop];
		}

		//we don't lets add it
		$this->propsCache[$prop] = wfGetWikiaPageProp($prop, $this->getId());

		$cache->set( $key, $this->propsCache );
		wfProfileOut(__METHOD__."_1");
		wfProfileOut(__METHOD__);
		return $this->propsCache[$prop];
	}

	protected function isMarkInProps($prop) {
		return $this->getPropVal($prop) == 1;
	}

	protected function getPropCacheKey() {
		return  wfMemcKey(__CLASS__, __METHOD__, $this->cityId, $this->getId(), 'v5');
	}

	private function getCache() {
		return F::App()->wg->Memc;
	}

	public function getId() {
		$id = $this->title->getArticleId();
		if(!empty($id)) {
			return $id;
		}
		return 0;
	}

	/**
	 * @return null|ArticleComment
	 */
	protected function getArticleComment() {
		if( empty($this->articleComment) ) {
			$this->articleComment = ArticleComment::newFromTitle($this->title);
		}

		return $this->articleComment;
	}

	public function getData($master = false, $title = null) {
		return $this->getArticleComment()->getData($master, $title);
	}

	public function sendNotificationAboutLastRev( $master = false ) {
		$this->load();
		$lastRevId = $this->getArticleComment()->mLastRevId;
		if(!empty($lastRevId)){
			$this->helper->sendNotification( $lastRevId, RC_NEW, $master );
		}
	}

	public function showVotes() {
		return in_array(MWNamespace::getSubject($this->title->getNamespace()), F::App()->wg->WallVotesNS);
	}

	public function showTopics() {
		return in_array(MWNamespace::getSubject($this->title->getNamespace()), F::App()->wg->WallTopicsNS);
	}

	public function canVotes(User $user) {
		return $this->showVotes() && $user->isLoggedIn() && !$user->isBlocked();
	}

	public function isAllowedNotifyEveryone() {
		$app = F::App();
		return $this->helper->isAllowedNotifyEveryone($this->title->getNamespace(), $app->wg->User);
	}

	public function canMove(User $user) {
		return ( $this->isMain() && !$this->isRemove() && $this->can($user, 'wallmessagemove') && in_array(MWNamespace::getSubject($this->title->getNamespace()), F::App()->wg->WallTopicsNS) );
	}
}

<?php

/* smart proxy to article comment */

class WallMessage {
	protected $articleComment;
	protected $title;
	protected $order = 0;
	protected $isLoaded = false;
	protected $propsCache = array();
	protected $cityId = 0;
	protected static $permissionsCache; //permissions cache
	protected $commentIndex;
	function __construct(Title $title, $articleComment = null) {
		$this->title = $title;
		$this->articleComment = $articleComment;
		$this->commentsIndex = F::build( 'CommentsIndex' );
		$app = F::App();
		//TODO: inject this
		$this->cityId = $app->wg->CityId;
	}

	static public function newFromId($id, $master = false) {
		if( $master == true ) {
			$title = F::build('Title', array($id, Title::GAID_FOR_UPDATE), 'newFromId');
		} else {
			$title = F::build('Title', array($id), 'newFromId');
		}

		if( $title instanceof Title && $title->exists() ) {
			return  F::build('WallMessage', array($title), 'newFromTitle');
		}

		if( $master == false ) {
			// if you fail from slave try again from master
			return self::newFromId( $id, true );
		}
		return null;
	}

	static public function addMessageWall( $userPageTitle ) {
			$botUser = User::newFromName( 'WikiaBot' );
			$article = F::build( 'Article', array($userPageTitle) );
			$status = $article->doEdit( '', '', EDIT_NEW | EDIT_MINOR | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT, false, $botUser );
			$title = ( $status->isOK() ) ? $article->getTitle() : false ;

			return $title;
	}

	static public function buildNewMessageAndPost( $body, $page, $user, $metaTitle = '', $parent = false, $notify = true ) {
		
		if($page instanceof Title ) {
			$userPageTitle = $page;
		} else {
			$userPageTitle = F::build('Title', array($page, NS_USER_WALL), 'newFromText');
		}
		
		// create wall page by bot if not exist
		if ( !$userPageTitle->exists() ) {
			$userPageTitle = self::addMessageWall( $userPageTitle );
		}

		if( empty($userPageTitle) ) {
			return false;
		}

		if( $parent === false ) {
			$acStatus = F::build( 'ArticleComment', array( $body, $user, $userPageTitle, false , array('title' => $metaTitle ) ), 'doPost' );
		} else {
			if( !$parent->canReply() ) {
				return false;
			}

			$acStatus = F::build( 'ArticleComment', array( $body, $user, $userPageTitle, $parent->getTitle()->getArticleId() , null ), 'doPost' );
		}

		if( $acStatus === false ) {
			return false;
		}

		$ac = ArticleComment::newFromId( $acStatus[1]->getId() );
		if( empty( $ac ) ) {
			return false;
		}

		// after successful posting invalidate Wall cache
		$class = F::build( 'WallMessage', array( $ac->getTitle(), $ac ) );

		if($parent === false) {//$db = DB_SLAVE
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
		}
		//Build data for sweet url ? id#number_of_comment
		//notify
		if($notify) {
			$class->sendNotificationAboutLastRev();
		}
		
		$class->addWatch($user);
		
		return $class;
	}

	static public function newFromTitle(Title $title) {
		$class = new WallMessage($title);
		return $class;
	}

	static public function newFromArticleComment(ArticleComment $articleComment) {
		$class = new WallMessage( $articleComment->getTitle(), $articleComment );
		return $class;
	}


	//TODO: add some cache
	public function setOrderId($val = 1) {
		wfSetWikiaPageProp(WPP_WALL_COUNT,  $this->getTitle()->getArticleId(),  $val);
		$this->order = $val;
		return $val;
	}

	//TODO: add some cache
	public function getOrderId($for_update = false) {
		if($for_update) {
			return wfGetWikiaPageProp(WPP_WALL_COUNT, $this->getTitle()->getArticleId(), DB_MASTER);
		}

		if($this->order != 0) {
			return $this->order;
		}

		return wfGetWikiaPageProp(WPP_WALL_COUNT, $this->getTitle()->getArticleId());
	}

	public function addNewReply($body, $user) {
		return self::buildNewMessageAndPost($body, $this->getWallTitle(), $user, '', $this );
	}

	public function canEdit(User $user){
		return $this->can( $user, 'edit' ) && ( $this->isAuthor($user) || $user->isAllowed('walledit') || $user->isAllowed('rollback') );
	}
		
	public function doSaveComment($body, $user) {
		if($this->canEdit($user)){
			$this->getArticleComment()->doSaveComment( $body, $user, null, 0, true );
		}
		if( !$this->isMain() ) {
			// after changing reply invalidate thread cache
			$this->getThread()->invalidateCache();
		}
		/*
		* mech: EditPage calls Article with watchThis set to false
		*       which causes this article comment to be unsubscribed.
		*       so we re-subscribe (it's not a hack, it's a workaround)
		*/
		$this->addWatch($user);
		return $this->getArticleComment()->parseText($body);
	}

	protected function can($user, $prev ) {
		if(!empty(self::$permissionsCache[$prev][$user->getName()])) {
			return self::$permissionsCache[$prev][$user->getName()];
		}

		self::$permissionsCache[$prev][$user->getName()] = !$user->isBlocked() && $user->isAllowed($prev);

		return self::$permissionsCache[$prev][$user->getName()];
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

	public function canFastrestore(User $user) {
		return $this->can($user, 'walladmindelete') || $this->isWallOwner($user);
	}

	public function getMetaTitle(){
		return $this->getArticleComment()->getMetadata('title');
	}

	public function setMetaTitle($title) {
		if($this->isMain()) {
			return $this->getArticleComment()->setMetaData('title', $title);
		}
		return false;
	}

	public function getWallOwnerName() {
		$parts = explode( '/', $this->getWallTitle()->getText() );
		return $parts[0];
	}

	public function getWallOwner() {
		$parts = explode( '/', $this->getWallTitle()->getText() );
		$wall_owner = User::newFromName(  $parts[0], false);
		if( empty($wall_owner) ) {
			error_log('EMPTY_WALL_OWNER: (id)'. $this->getArticleComment()->getArticleTitle()->getArticleID());
			error_log('EMPTY_WALL_OWNER: (basetext)'. $this->getArticleComment()->getArticleTitle()->getBaseText());
			error_log('EMPTY_WALL_OWNER: (fulltext)'. $this->getArticleComment()->getArticleTitle()->getFullText());
		}
		return $wall_owner;
	}

	public function getWallPageUrl() {
		return $this->getWallTitle()->getFullUrl();
	}

	
	//TODO: remove get wall title
	public function getWallTitle(){
		return $this->getArticleTitle();
	}

	public function getArticleTitle(){
		return $this->getArticleComment()->getArticleTitle();
	}
	
	public function getWall() {
		$wall = F::build('Wall', array( $this->getWallTitle() ), 'newFromTitle');
		return $wall;
	}

	public function getThread() {
		$wm = $this;
		if( $this->isMain() == false ) {
			$wm = $this->getTopParentObj();
		}
		return F::build('WallThread', array( $wm->getId() ), 'newFromId');
	}

	public function getPageUrlPostFix() {
		if($this->isMain()){
			return '';
		} else {
			$order = $this->getOrderId();
			if($order != null) {
				return $order;
			} else {
				return $this->getArticleId();
			}
		}
	}

	public function getMessagePageUrl($withoutAnchor = false) {
		if($this->isMain()){
			$id = $this->getArticleId();
		} else {
			$topParent = $this->getTopParentObj();
			$id = $topParent->getArticleId();
		}
		$postFix = $this->getPageUrlPostFix();

		if( !empty($postFix) && $withoutAnchor === false ) {
			$postFix = '#'.$postFix;
		} else {
			$postFix = '';
		}

		$title = Title::newFromText($id, NS_USER_WALL_MESSAGE);
		return $title->getFullUrl().$postFix;
	}

	public function getArticleId(&$articleData = null) {
		$title = $this->getArticleComment()->getTitle();
		$articleId = $this->getArticleComment()->getTitle()->getArticleId();

		if( $articleId === 0 && $title instanceof Title ) {
		//message was deleted and never restored
			$helper = F::build('WallHelper', array());
			$articleId = $helper->getArticleId_forDeleted($title->getText(), $articleData);
		}

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
		$articleId = $this->getArticleComment()->getTitle()->getArticleId();

		if( $articleId !== 0 ) {
			$article = Article::newFromID($articleId);
			return $article->getTimestamp();
		}

		return null;
	}

	public function getWallUrl() {
		return $this->getArticleComment()->getArticleTitle()->getFullUrl();
	}

	public function getTopParentObj(){
		$obj = $this->getArticleComment()->getTopParentObj();

		if( empty($obj) ) {
			return null;
		}

		if($obj instanceof ArticleComment){
			return WallMessage::newFromArticleComment($obj);
		} else {
			return null;
		}
	}

	public function isMain() {
		$top = $this->getTopParentObj();
		if(empty($top)) {
			return true;
		}
		return false;
	}

	public function getTopParentText($titleText) {
		return $this->getArticleComment()->explodeParentTitleText($titleText);
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
			/*
			 * FB 19409 - cannot user the user object cached in article comment,
			 * cos it may have an old real name
			 */
			$freshUser = User::newFromName($user->getName(), false);
			return ($freshUser) ? $freshUser : $user;
		} else {
			// this only happend for wrong enties in DB
			// without revision information
			return User::newFromName('0.0.0.0', false);
		}
	}

	public function getText() {
		return $this->getArticleComment()->getText();
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

	public function getEditor(){
		$user = User::newFromId($this->getArticleComment()->mLastRevision->getUser());
		return $user;
	}

	public function getEditTime($format){
		$r = $this->getArticleComment()->mLastRevision;
		if (!$r) return null; // BugId:22821
		return wfTimestamp($format, $r->getTimestamp());
	}

	public function isEdited() {
		return $this->getArticleComment()->mLastRevId != $this->getArticleComment()->mFirstRevId;
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

	public function archive() {
		return $this->markInProps(WPP_WALL_ARCHIVE);
	}

	public function remove($user, $reason = '', $notifyAdmins = false) {
		$this->saveReason($user, $reason);
		$status = $this->markInProps(WPP_WALL_REMOVE);

		if( $status === true ) {
			$this->customActionNotifyRC($user, 'wall_remove', $reason);

			$wnae = $this->getAdminNotificationEntity($user, $reason);
			if($notifyAdmins) {
				$this->addAdminNotificationFromEntity($wnae);
			}

			$wh = F::build('WallHistory', array($this->cityId));
			$wh->add( WH_REMOVE, $wnae, $user );

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
		$url = $this->getMessagePageUrl();
		$title = $this->getMetaTitle();
		$messageId = $this->getId();

		if( $this->isMain() ) {
			$wnae = new WallNotificationAdminEntity($wikiId, $userIdRemoving, $userIdWallOwner, $title, $url, $messageId, 0, false, $reason);
		} else {
			$parent = $this->getTopParentObj();
			$parent->load();
			$parentMessageId = $parent->getId();
			$title = $parent->getMetaTitle();
			$wnae = new WallNotificationAdminEntity($wikiId, $userIdRemoving, $userIdWallOwner, $title, $url, $messageId, $parentMessageId, true, $reason);
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

			$wh = F::build('WallHistory', array($this->cityId));
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

	protected function customActionNotifyRC($user, $action, $reason) {
		$articleId = $this->getArticleId();
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
		return !$this->isAdminDelete() && !$this->isRemove();
	}

	public function canRestore($user) {
		if( $this->isAdminDelete() ) {
			if($user->isAllowed('walladmindelete')) {
				return true;
			}
		} elseif($this->isRemove()) {
			if($this->canRemove($user)) {
				return true;
			}
		}
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
		if($user->isAllowed('walladmindelete')) {
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
		$wh = F::build('WallHistory', array($this->cityId));
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
	public function getLastActionReason( ) {
		if(empty($this->mActionReason)) {
			$info = wfGetWikiaPageProp(WPP_WALL_ACTIONREASON, $this->getId());
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
		$user = F::build('User', array($val), 'newFromId');

		if( $user instanceof User && $user->getId() > 0 ){
			return $user;
		}

		return false;
	}

	protected function setInCommentsIndex( $prop, $value, $useMaster = false ) {
		$commentId = $this->getId();
		if ( !empty($commentId) ) {
			$this->commentsIndex = F::build( 'CommentsIndex', array( $commentId ), 'newFromId' );
			if ( $this->commentsIndex instanceof CommentsIndex ) {
				switch( $prop ) {
					case WPP_WALL_ARCHIVE : $this->commentsIndex->updateArchived( $value );
											break;
					case WPP_WALL_ADMINDELETE : $this->commentsIndex->updateDeleted( $value );
												$lastChildCommentId = $this->commentsIndex->getParentLastCommentId( $useMaster );
												$this->commentsIndex->updateParentLastCommentId( $lastChildCommentId );

												wfRunHooks( 'EditCommentsIndex', array($this->getTitle(), $this->commentsIndex) );
												break;
					case WPP_WALL_REMOVE : $this->commentsIndex->updateRemoved( $value );
											$lastChildCommentId = $this->commentsIndex->getParentLastCommentId( $useMaster );
											$this->commentsIndex->updateParentLastCommentId( $lastChildCommentId );

											wfRunHooks( 'EditCommentsIndex', array($this->getTitle(), $this->commentsIndex) );
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
		$id = $this->getPropCacheKey($prop, $this->getId());
		$this->propsCache[$id] = $val;

		$cache = $this->getCache();
		$cache->set( $id, $val );

		return true;
	}

	protected function unMarkInProps($prop) {
		$id = $this->getPropCacheKey($prop, $this->getId());
		$this->propsCache[$id] = false;

		$cache = $this->getCache();
		$cache->set( $id, false );

		wfDeleteWikiaPageProp( $prop, $this->getId() );

		$this->setInCommentsIndex($prop, 0, true);
	}

	protected function getPropVal($prop) {
		$id = $this->getPropCacheKey($prop, $this->getId());

		// check local memory cache
		if(isset($this->propsCache[$id])) {
			return $this->propsCache[$id];
		}

		// check memcache
		$cache = $this->getCache();
		$val = $cache->get( $id );
		if($val !== null) {
			$this->propsCache[$id] = $val;
			return $val;
		}

		$this->propsCache[$id] = wfGetWikiaPageProp($prop, $this->getId());
		$cache->set( $id, $this->propsCache[$id] );
		return $this->propsCache[$id];
	}

	protected function isMarkInProps($prop) {
		return $this->getPropVal($prop) == 1;
	}

	protected function getPropCacheKey($prop, $id) {
		return __CLASS__ . '_' . $this->cityId . '_' . $prop . '_' .  $this->getId();
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

	protected function getArticleComment() {
		if( empty($this->articleComment) ) {
			$this->articleComment = ArticleComment::newFromTitle($this->title);
		}

		return $this->articleComment;
	}

	public function getData($master = false, $title = null) {
		return $this->getArticleComment()->getData($master, $title);
	}

	public function sendNotificationAboutLastRev() {
		$this->load();
		$lastRevId = $this->getArticleComment()->mLastRevId;
		if(!empty($lastRevId)){
			$helper = F::build('WallHelper', array());
			$helper->sendNotification($lastRevId);
		}
	}
}

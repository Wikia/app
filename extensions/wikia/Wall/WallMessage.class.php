<?php 

/* smart proxy to article comment */

class WallMessage {
	protected $articleComment;
	protected $title;
	protected $order = 0;
	
	function __construct(Title $title, $articleComment = null) {
		$this->title = $title;
		$this->articleComment = $articleComment;
	}
	
	static public function buildNewMessageAndPost($body, $userWall, $user, $metaTitle = '', $parent = false){
		
		if($userWall instanceof Title ){
			$userPageTitle = $userWall;
		} else {
			$userPageTitle = F::build('Title', array($userWall , NS_USER_WALL), 'newFromText');
		}
		
		if(empty($userPageTitle)  ) {
			return false;			
		}
		if($parent === false) {
			$acStatus = F::build('ArticleComment', array($body, $user, $userPageTitle, false , array('title' => $metaTitle) ), 'doPost');	
		} else {
			$acStatus = F::build('ArticleComment', array($body, $user, $userPageTitle, $parent->getTitle()->getArticleId() , array('title' => $metaTitle) ), 'doPost');
		}
		
		if($acStatus === false) {
			return false;
		}
		
		$ac = ArticleComment::newFromId($acStatus[1]->getId());
		
		if(empty($ac)) {
			return false;
		}
		
		$class = new WallMessage( $ac->getTitle(), $ac );
		
		if($parent === false) {//$db = DB_SLAVE
			$class->setOrderId( 1 );
		} else {
			$count = $parent->getOrderId( true );
			if(is_numeric($count)){
				$count++;
				$parent->setOrderId( $count );
				$class->setOrderId( $count );				
			}
		}
		
		//Build data for sweet url ? id#number_of_comment 
		
		return $class;
	}
	
	static public function newFromTitle(Title $title) {
		$class = new WallMessage( $title );
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
		return $this->isAuthor($user) || $user->isAllowed('walledit');
	}
	
	public function doSaveComment($body, $user) {
		if($this->canEdit($user)){
			$this->getArticleComment()->doSaveComment( $body, $user, null, 0, true );			
		}
		return $this->getArticleComment()->parseText($body);
	}

	public function canDelete(User $user){
		return $this->isWallOwner($user) || $user->isAllowed('walldelete');
	}	
	 
	public function getMetaTitle(){
		return $this->getArticleComment()->getMetadata('title');
	}
	
	public function setMetaTitle($title) {
		return $this->getArticleComment()->setMetaData('title', $title);
	}

	public function getWallOwnerName() {
		$parts = explode( '/', $this->getWallTitle()->getText() );
		return $parts[0];
	}
	
	public function getWallOwner() {
		$parts = explode( '/', $this->getWallTitle()->getText() );
		$wall_owner = User::newFromName(  $parts[0], false);
		if(empty($wall_owner)) {
			error_log('EMPTY_WALL_OWNER: (id)'. $this->getArticleComment()->getArticleTitle()->getArticleID());
			error_log('EMPTY_WALL_OWNER: (basetext)'. $this->getArticleComment()->getArticleTitle()->getBaseText());
			error_log('EMPTY_WALL_OWNER: (fulltext)'. $this->getArticleComment()->getArticleTitle()->getFullText());
		}
		return $wall_owner;
	}
	
	public function getWallPageUrl() {
		return $this->getWallTitle()->getFullUrl();
	}
	
	public function getWallTitle(){
		return $this->getArticleComment()->getArticleTitle(); 
	}
	
	public function getArticleTitle(){ 
		return $this->getArticleComment()->getArticleTitle();
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
		return '';
	}
	
	public function getMessagePageUrl() {
		if($this->isMain()){
			$id = $this->getArticleId();
		} else {
			$topParent = $this->getTopParentObj();
			$id = $topParent->getArticleId();
		}
		$postFix = $this->getPageUrlPostFix();
		if(!empty($postFix)) {
			$postFix = '#'.$postFix;
		}
		$title = Title::newFromText($id, NS_USER_WALL_MESSAGE);
	
		return $title->getFullUrl().$postFix;
	}
	
	public function getArticleId() {
		return $this->getArticleComment()->getTitle()->getArticleId();
	}
	
	public function getWallUrl() {
		return $this->getArticleComment()->getArticleTitle()->getFullUrl();
	}
	
	public function getTopParentObj(){
		$obj = $this->getArticleComment()->getTopParentObj();
 
		if(empty($obj)  ) {
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
		return $this->getArticleComment()->load($master);
	}
	
	public function getUser(){
		return $this->getArticleComment()->mUser;
	}
	
	public function getText() {
		return $this->getArticleComment()->getText();
	}
	
	public function getCreatTime($format = TS_ISO_8601) {
		return wfTimestamp($format, $this->getArticleComment()->mFirstRevision->getTimestamp());
	}
	
	public function getEditor(){
		$user = User::newFromId($this->getArticleComment()->mLastRevision->getUser());
		return $user;		
	}
	
	public function getEditTime($format){
		return wfTimestamp($format, $this->getArticleComment()->mLastRevision->getTimestamp());		
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
		return $user->isWatched($this->title);
	}
	
	public function addWatch(User $user) {
		$user->addWatch($this->title);		
	}
	
	public function removeWatch(User $user) {
		$user->removeWatch($this->title);
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function doDeleteComment( $reason, $suppress = false ){
		return $this->getArticleComment()->doDeleteComment( $reason, $suppress );
	}
	
	public function getThreadHistory() {
		var_dump($this->getArticleTitle()->getFullURL() );
	}
	
	protected function getArticleComment() {
		if(empty($this->articleComment)) {
			$this->articleComment = ArticleComment::newFromTitle($this->title);
		}
		return $this->articleComment;
	}
}
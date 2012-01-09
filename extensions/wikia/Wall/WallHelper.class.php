<?php 

class WallHelper {
	//WA = wiki activity
	const WA_WALL_COMMENTS_MAX_LEN = 150;
	const WA_WALL_COMMENTS_EXPIRED_TIME = 86400;
	
	public function __construct() {
		$this->urls = array();
	}
	
	public function createPostContent($title, $body) {
		return XML::element("title", array(), $title )."\n".XML::element("body", array(), $body );
	}
	
	public function getArchiveSubPageText() {
		return wfMsg('wall-user-talk-archive-page-title');
	}
		
	/**
	 * @brief Gets and returns user's talk page's content
	 * 
	 * @desc If $namespace is not passed via method parameter getTitle() will try to get it from Nirvana's architercture
	 * 
	 * @param int | null $namespace namespace's id passed via const for instance: NS_USER_TALK
	 * @param string | null $subpage a subpage title/text
	 * @param User | null $user a user object
	 * @requestParam int $namespace namespace's id passed via const for instance: NS_USER_TALK
	 * 
	 * @return Title
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getTitle($namespace = null, $subpage = null, $user = null) {
		$app = F::App();
		
		if( empty($namespace) ) {
			$namespace2 = $this->getVal('namespace');
		}
		
		if( empty($user) ) {
			$user = $this->getUser();
		}
		
		if( empty($namespace) ) {
			$this->title = F::build('Title', array($user->getName(), $namespace2), 'newFromText');
			
			return $this->title;
		}
		
		if( empty($subpage) ) {
			return F::build('Title', array($user->getName(), $namespace), 'newFromText');
		} else {
			return F::build('Title', array($user->getName().'/'.$subpage, $namespace), 'newFromText');
		}
	}
	
	/**
	 * @brief Gets and returns user's object. 
	 * 
	 * @desc !IMPORTANT! It requires UserProfilePage class from UserProfilePageV3 extension. 
	 * It sends request to UserProfilePage controller which should return user object generated
	 * from passed title.
	 * 
	 * @return User
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	
	//TODO: remove call to UserProfilePage
	public function getUser($title = false) {
		$response = F::App()->sendRequest(
			'UserProfilePage',
			'getUserFromTitle',
			array(
				'title' => $title ? $title : F::App()->wg->Title,
				'returnUser' => true
			)
		);
		
		return $response->getVal('user');
	}
	
	/**
	 * @brief Filtring message wall data and spliting it to parents and childs
	 * 
	 * @param Title $title title object instance
	 * @param array $res a referance to array returned from recent changes
	 *
	 * @return array | boolean returns false if ArticleComment class does not exist
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function wikiActivityFilterMessageWall($title, &$res) {
		$app = F::app();
		$app->wf->ProfileIn(__METHOD__);
		
		$item = array();
		$item['type'] = 'new';
		$item['wall'] = true;
		$item['ns'] = $res['ns'];
		$item['timestamp'] = $res['timestamp'];
		$item['wall-comment'] = $res['rc_params']['intro'];
		$item['article-id'] = $title->getArticleID();
		
		$wmessage = F::build('WallMessage', array($title) );
		$parent = $wmessage->getTopParentObj();

		$item['wall-url'] = $wmessage->getWallPageUrl();
		
		$owner = $wmessage->getWallOwner();
		if($realname = $owner->getRealName())
			$item['wall-owner'] = $realname;
		else
			$item['wall-owner'] = $owner->getName();
		
		if( empty($parent) ) {
		//parent
			$metaTitle = $wmessage->getMetaTitle();
			if( !empty($metaTitle) ) {
				$item['title'] = $metaTitle;
			} else {
				$wmessage->load();
				$metaTitle = $wmessage->getMetaTitle();
				$item['title'] = empty($metaTitle) ? wfMsg('wall-no-title') : $metaTitle;
			}
			
			$item['url'] = $wmessage->getMessagePageUrl();
			$res['title'] = 'message-wall-thread-#'.$title->getArticleID();
		} else {
		//child
			$parent->load();
			$title = wfMsg('wall-no-title'); // in case metadata does not include title field
			if( isset($parent->mMetadata['title']) ) $title = $wmessage->getMetaTitle();
			$this->mapParentData($item, $parent, $title);
			$res['title'] = 'message-wall-thread-#'.$parent->getTitle()->getArticleID();
		}
		
		$app->wf->ProfileOut(__METHOD__);
		return $item;
	}
	
	/**
	 * @brief Copies parent's informations to child item
	 * 
	 * @param array $item a referance to an array with wall comment informations
	 * @param ArticleComment $parent parent comment
	 * @param Title $title title object instance
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function mapParentData(&$item, $parent, $title) {
		$app = F::app();
		$app->wf->ProfileIn(__METHOD__);
		
		$metaTitle = $parent->getMetaTitle();
		
		if( !empty($metaTitle) ) {
			$item['title'] = $metaTitle;
		} else {
			$item['title'] = wfMsg('wall-no-title');
		}
		$item['url'] = $parent->getMessagePageUrl();
		
		$parentTitle = $parent->getTitle();
		if( $parentTitle instanceof Title ) {
			$item['parent-id'] = $parentTitle->getArticleID();
		}
		
		$app->wf->ProfileOut(__METHOD__);
	}
	
	/**
	 * @brief Gets wall comments from memc/db
	 *
	 * @param integer $parentId if not null returns only last two comments
	 *
	 * @return array first element is a counter, second is an array with comments
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getWallComments($parentId = null) {
		$app = F::app();
		$app->wf->ProfileIn(__METHOD__);
		
		$comments = array();
		$commentsCount = 0;
		
		if( !is_null($parentId) ) {
			$parent = F::build('ArticleComment', array($parentId), 'newFromId');
			
			if( !($parent instanceof ArticleComment) ) {
			//this should never happen
				Wikia::log(__METHOD__, false, 'No ArticleComment instance article id: '.$parentId);
				
				return array(
					'count' => $commentsCount,
					'comments' => $comments,
				);
			}
			
			$commentList = F::build('ArticleCommentList', array($parent->getTitle()), 'newFromTitle');
			$commentList->setId($parentId);
			$data = $commentList->getData();
			
			if( !empty($data['commentListRaw'][$parentId]['level2']) ) {
			//top message has replies
				$comments = $data['commentListRaw'][$parentId]['level2'];
				
				//in wiki activity we display amount of messages
				//not only replies (comments), so we add 1 which is top message
				$commentsCount = count($comments) + 1;
				if( $commentsCount > 2 ) {
					$comments = array_slice($comments, -2, 2);
				}
				$comments = $this->getCommentsData($comments);
			} else {
			//top message doesn't have replies yet -- it's a new wall message
				if( !empty($data['commentListRaw'][$parentId]['level1']) ) {
					$comment = $data['commentListRaw'][$parentId]['level1'];
					$comments = $this->getCommentsData(array($comment));
				}
			}
		}
		
		$app->wf->ProfileOut(__METHOD__);
		return array(
			'count' => $commentsCount,
			'comments' => $comments,
		);
	}
	
	/**
	 * @brief Gets wall comments data from memc/db
	 * 
	 * @param array $comments an array with ArticleComments instances
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getCommentsData($comments) {
		$app = F::app();
		$app->wf->ProfileIn(__METHOD__);
		
		$items = array();
		$i = 0;
		foreach($comments as $comment) {
			if( $comment instanceof ArticleComment ) {
				$data = $comment->getData(false, null, 30);
				
				$items[$i]['avatar'] = $data['avatarSmall'];
				$items[$i]['user-profile-url'] = $data['userurl'];
				$user = User::newFromName($data['author']->getName());
				if($user)
					$items[$i]['real-name'] = $user->getRealName();
				else
					$items[$i]['real-name'] = '';
				$items[$i]['author'] = $data['username'];
				$items[$i]['wall-comment'] = $this->shortenText($this->strip_wikitext($data['rawtext'])).'&nbsp;';
				$items[$i]['timestamp'] = $data['rawmwtimestamp'];
				if(User::isIP( $data['username']) ) {
					$items[$i]['user-profile-url'] = Skin::makeSpecialUrl('Contributions').'/'.$data['username'];
					$items[$i]['real-name'] = wfMsg('oasis-anon-user');
				}
				$i++;
			} else {
			//just in-case: all elements of $comments are should be instances of ArticleComments
				Wikia::log(__METHOD__, false, 'WALL_HELPER_ERROR: an element is not ArticleComments instance: '.print_r($comment, true) );
			}
		}
		unset($data);
		
		$items = $this->filterOldMessageWallComments($items);
		
		$app->wf->ProfileOut(__METHOD__);
		return $items;
	}
	
	/**
	 * @brief Filters old messages -- finds them and removes
	 * 
	 * @param array $comments two comments from memc/db
	 */
	private function filterOldMessageWallComments($comments) {
		$app = F::app();
		$app->wf->ProfileIn(__METHOD__);
		
		$items = array();
		if( count($comments) > 0 ) {
			$timeNow = time();
			
			foreach($comments as $comment) {
				$ago = $timeNow - strtotime($comment['timestamp']) + 1;
				
				if( $ago <= self::WA_WALL_COMMENTS_EXPIRED_TIME ) {
					$items[] = $comment;
				}
			}
			
			if( empty($items) ) {
				$items[] = (!empty($comments[1])) ? $comments[1] : $comments[0];
				unset($items[0]['timestamp']);
			}
		}
		
		$app->wf->ProfileOut(__METHOD__);
		return $items;
	}
	
	/**
	 * @brief Shorten given text to given limit (if the text is longer than limit) and adds ellipses at the end
	 * 
	 * @desc Text is truncated to given limit (by default limit is equal to WA_WALL_COMMENTS_MAX_LEN constant) then it truncates it to last spacebar and adds ellipses. 
	 * 
	 * @param string $text text which needs to be shorter
	 * @param integer $limit limit of characters
	 * 
	 * @return string
	 */
	public function shortenText($text, $limit = self::WA_WALL_COMMENTS_MAX_LEN) {
		$app = F::app();
		$app->wf->ProfileIn(__METHOD__);
		
		if( mb_strlen($text) > $limit ) {
			$text = $app->wg->Lang->truncate($text, $limit);
			$lastSpacePos = strrpos($text, ' ');
			
			if( $lastSpacePos !== false ) {
				$text = $app->wg->Lang->truncate($text, $lastSpacePos);
			}
		}
		
		$app->wf->ProfileOut(__METHOD__);
		return $text;
	}
	
	public function getDefaultTitle() {
		$app = F::app();
		$name = $app->wg->User->getRealName();
		if (empty($name)) $name = $app->wg->User->getName();
		if (User::isIP($name)){
			$name = wfMsg('oasis-anon-user');
			$name{0} = strtolower($name{0});
		}
		return $app->wf->msg('wall-default-title') . ' ' . $name;
		
	}
	
	public function getParsedText($rawtext, $title) {
		global $wgParser, $wgOut;
		global $wgEnableParserCache;
		global $wgUser;
		$wgEnableParserCache = false;

		return $wgParser->parse( $rawtext, $title, $wgOut->parserOptions())->getText();
	}
	
	/**
	 * @brief Returns id of a deleted article
	 * 
	 * @brief Returns id of deleted article from table archive. If an article was restored then it returns false.
	 * 
	 * @param string $dbkey
	 * @param array $optFields a referance with other data we'd like to recieve
	 * 
	 * @return int | boolean
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getArticleId_forDeleted($dbkey, &$optFields) {
		$dbr = wfGetDB( DB_SLAVE );
		
		$fields = array('ar_page_id');
		
		if( is_array($optFields) ) {
			if( isset($optFields['text_id']) ) {
				$fields[] = 'ar_text_id';
			}
		}
		
		$row = $dbr->selectRow(
			'archive',
			$fields,
			array( 'ar_title' => str_replace(' ', '_', $dbkey) ),
			__METHOD__ 
		);
		
		if( is_array($optFields) ) {
			if( isset($optFields['text_id']) && !empty($row->ar_text_id) ) {
				$optFields['text_id'] = $row->ar_text_id;
			}
		}
		
		return isset($row->ar_page_id) ? $row->ar_page_id : false;
	}
	
	public function getDbkeyFromArticleId_forDeleted($articleId) {
		$dbkey = null;

		$dbr = wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow( 'archive',
			array( 'ar_title' ),
			array( 'ar_page_id' => $articleId ),
			__METHOD__ );
		
		if(!empty($row)) $dbkey = $row->ar_title;
		
		if(empty($dbkey)) {
			// try again from master
			$dbr = wfGetDB( DB_MASTER );
			$row = $dbr->selectRow( 'archive',
				array( 'ar_title' ),
				array( 'ar_page_id' => $articleId ),
				__METHOD__ );
			
			if(!empty($row)) $dbkey = $row->ar_title;
		}
		
		return $dbkey;
	}
	
	public function getUserFromArticleId_forDeleted($articleId) {
		/*
		 * This is ugly way of doing that
		 * but for removed threads that we only have ArticleId for
		 * there is no other way (can't create WallMessage object
		 * for deleted threads)
		 */
		$user_id = null;

		$dbr = wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow( 'archive',
			array( 'ar_user' ),
			array( 'ar_page_id' => $articleId ),
			__METHOD__ );
		
		if(!empty($row)) $user_id = $row->ar_user;
		
		if(empty($dbkey)) {
			// try again from master
			$dbr = wfGetDB( DB_MASTER );
			$row = $dbr->selectRow( 'archive',
				array( 'ar_user' ),
				array( 'ar_page_id' => $articleId ),
				__METHOD__ );
			
			if(!empty($row)) $user_id = $row->ar_user;
		}
		
		return User::newFromId( $user_id );
	}


	public function getDbkeyFromArticleId($articleId) {
		$title = Title::newFromId($articleId);
		if(empty($dbkey)) {
			$dbkey = getDbkeyFromArticleId_forDeleted($articleId);
		} else {
			return $title->getDBkey();
		}
		return $dbkey;
	}

	public function isDbkeyFromWall($dbkey) {
		$lookFor = explode( '/@' ,$dbkey);
		if (count($lookFor) > 1){
			return true;
		}
		return false;
	}
		
	public function strip_wikitext( $text ) {
		//bugfix fb#17907
		$parser = F::build('Parser', array());
		
		$app = F::app();
		$text = str_replace('*', '&asterix;', $text);
		$text = $parser->parse($text, $app->wg->Title, $app->wg->Out->parserOptions())->getText();
		$text = str_replace('&amp;asterix;', '*', $text);
		$text = trim( strip_tags($text) );
		return $text;
	}
	
	/**
	 * @brief Gets old article's text
	 * 
	 * @desc Returns article's content from text table if fail it'll return empty string
	 * 
	 * @param integer $textId article's text id in text table
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getDeletedArticleTitleTxt($textId) {
		$dbr = wfGetDB( DB_SLAVE );
		
		$row = $dbr->selectRow(
			'text',
			array('old_text', 'old_flags'),
			array('old_id' => $textId),
			__METHOD__ 
		);
		
		if( !empty($row->old_text) && !empty($row->old_flags) ) {
			$flags = explode(',', $row->old_flags);
			if( in_array('gzip', $flags) ) {
				return gzinflate(F::build('ExternalStore', array($row->old_text), 'fetchFromUrl'));
			}
		}
		
		return '';
	}
	
	/**
	 * @brief Extracts title of the message via regural expression
	 * 
	 * @desc Uses preg_match_all() and extracts title attribute value from given string; returns empty string if fails
	 * 
	 * @param string $text text which should have <ac_metadata title="A title of a message"> </ac_metadata> tag inside
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getTitleTxtFromMetadata($text) {
		$pattern = '#<ac_metadata title="([^"]*)">(.*)</ac_metadata>#i';
		preg_match_all($pattern, $text, $matches);
		
		if( !empty($matches[1][0]) ) {
			return $matches[1][0];
		}
		
		return '';
	}
	
	public function haveMsg($user) {
		$title = Title::newFromText( $user->getName(),  NS_USER_WALL );
		$comments = ArticleCommentList::newFromTitle($title);
		return $comments->getCountAll() > 0;
	}
}

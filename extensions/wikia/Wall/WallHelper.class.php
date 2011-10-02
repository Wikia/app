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
	
	//TODO: remove getMessagePageUrl and use one from WallMessage class
	public function getMessagePageUrl(ArticleComment $comment) {
		return $comment->getArticleTitle()->getFullUrl().'/'.$comment->getTitle()->getArticleId();
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
		
		$ac = new ArticleComment($title);
		$ac->load();
		$parent = $ac->getTopParentObj();
		
		if( empty($parent) ) {
		//parent
			if(isset($ac->mMetadata['title'])) // TODO FIXME
				$item['title'] = $ac->mMetadata['title'];
			else
				$item['title'] = wfMsg('wall-no-title');
			$item['url'] = $this->getMessagePageUrl($ac);
			$res['title'] = 'message-wall-thread-'.urlencode($item['title']).'#'.$title->getArticleID();
		} else {
		//child
			$parent->load();
			$title = wfMsg('wall-no-title'); // in case metadata does not include title field
			if(isset($parent->mMetadata['title'])) $title = $parent->mMetadata['title'];
			$this->mapParentData($item, $parent, $title);
			$res['title'] = 'message-wall-thread-'.urlencode($title).'#'.$parent->getTitle()->getArticleID();
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
		
		if(isset($parent->mMetadata['title'])) 
			$item['title'] = $parent->mMetadata['title'];
		else
			$item['title'] = wfMsg('wall-no-title');;
		$item['url'] = $this->getMessagePageUrl($parent);
		
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
			
			$commentList = F::build('ArticleCommentList', array(($parent->getTitle())), 'newFromTitle');
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
			$data = $comment->getData(false, null, 30);
			
			$items[$i]['avatar'] = $data['avatarSmall'];
			$items[$i]['user-profile-url'] = $data['userurl'];
			$user = User::newFromName($data['author']->getName());
			if($user)
				$items[$i]['real-name'] = $user->getRealName();
			else
				$items[$i]['real-name'] = '';
			$items[$i]['author'] = $data['username'];
			$items[$i]['wall-comment'] = $this->shortenText($data['rawtext']).'&nbsp;';
			$items[$i]['timestamp'] = $data['rawmwtimestamp'];
			$i++;
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
		
		$timeNow = time();
		
		$items = array();
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
}
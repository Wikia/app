<?php

class WallHelper {
	//WA = wiki activity
	const WA_WALL_COMMENTS_MAX_LEN = 150;
	const WA_WALL_COMMENTS_EXPIRED_TIME = 259200; // = (3 * 24 * 60 * 60) = 3 days

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
	 * @author Andrzej 'nAndy' Åukaszewski
	 */
	public function getTitle($namespace = null, $subpage = null, $user = null) {
		if( empty($user) ) {
			$user = $this->getUser();
		}


		if( empty($namespace) ) {
			$namespace2 = $this->getVal('namespace');
			$this->title = F::build( 'Title', array( $user->getName(), $namespace2 ), 'newFromText' );

			return $this->title;
		}

		if( empty($subpage) ) {
			return F::build( 'Title', array( $user->getName(), $namespace ), 'newFromText' );
		} else {
			return F::build( 'Title', array( $user->getName().'/'.$subpage, $namespace ), 'newFromText' );
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
	 * @author Andrzej 'nAndy' Åukaszewski
	 */
	//TODO: remove call to UserProfilePage
	public function getUser($title = false) {
		$title = $title ? $title : F::App()->wg->Title;
		$ns = $title->getNamespace();
        $user = null;

        if( $ns == NS_USER_WALL ) {

			/**
			 * @var $w Wall
			 */
			$w = F::build( 'Wall', array( $title ), 'newFromTitle' );
			$user = $w->getUser();
		} else if( $ns == NS_USER_WALL_MESSAGE) {
			/**
			 * @var $wm WallMessage
			 */
			 
			$wm = F::build( 'WallMessage', array( $title ), 'newFromTitle' );
            $user = $wm->getWallOwner();
		}

        if( is_null($user) ) {
            // this is last resort
            // should no longer be needed
            $response = F::App()->sendRequest(
                'UserProfilePage',
                'getUserFromTitle',
                array(
                    'title' => $title,
                    'returnUser' => true
                )
            );

            return $response->getVal('user');
        }

        return $user;
	}

	/**
	 * @brief Filtring message wall data and spliting it to parents and childs
	 *
	 * @param Title $title title object instance
	 * @param array $res a referance to array returned from recent changes
	 *
	 * @return array | boolean returns false if ArticleComment class does not exist
	 *
	 * @author Andrzej 'nAndy' Åukaszewski
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

		if( !in_array(true, array($wmessage->isAdminDelete(), $wmessage->isRemove())) ) {
			$item['wall-url'] = $wmessage->getWallPageUrl();

			$owner = $wmessage->getWallOwner();

			$item['wall-owner'] = $owner->getName();
			$item['wall-msg'] = '';

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
				$item['wall-msg'] = wfMsg( 'wall-wiki-activity-on', '<a href="'.$item['wall-url'].'">'.wfMsg('wall-wiki-activity-wall-owner', $item['wall-owner']).'</a>');
			} else {
			//child
				$parent->load();

				if( !in_array(true, array($parent->isRemove(), $parent->isAdminDelete())) ) {
					$title = wfMsg('wall-no-title'); // in case metadata does not include title field
					if( isset($parent->mMetadata['title']) ) $title = $wmessage->getMetaTitle();
					$this->mapParentData($item, $parent, $title);
					$res['title'] = 'message-wall-thread-#'.$parent->getTitle()->getArticleID();
					$item['wall-msg'] = wfMsg( 'wall-wiki-activity-on', '<a href="'.$item['wall-url'].'">'.wfMsg('wall-wiki-activity-wall-owner', $item['wall-owner']).'</a>');
				} else {
				//message was removed or deleted
					$item = array();
				}
			}
		} else {
		//message was removed or deleted
			$item = array();
		}

		wfRunHooks('AfterWallWikiActivityFilter', array(&$item, $wmessage));

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
	 * @author Andrzej 'nAndy' Åukaszewski
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
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function getWallComments($parentId = null) {
		$app = F::app();
		$app->wf->ProfileIn(__METHOD__);

		$comments = array();
		$commentsCount = 0;

		if( !is_null($parentId) ) {
			$parent = F::build('WallMessage', array($parentId), 'newFromId');

			if( !($parent instanceof WallMessage) ) {
			//this should never happen
				Wikia::log(__METHOD__, false, 'No WallMessage instance article id: '.$parentId);

				$app->wf->ProfileOut(__METHOD__);
				return array(
					'count' => $commentsCount,
					'comments' => $comments,
				);
			}

			$wallThread = F::build('WallThread', array($parentId), 'newFromId');
			$topMessage = $wallThread->getThreadMainMsg();
			$comments = $wallThread->getRepliesWallMessages();

			if( !empty($comments) ) {
			//top message has replies
				//in wiki activity we display amount of messages
				//not only replies (comments), so we add 1 which is top message
				$commentsCount = count($comments) + 1;
				$revComments = array_reverse($comments);
				$comments = array();
				$i = 0;
				foreach($revComments as $comment) {
					if( !in_array(true, array($comment->isRemove(), $comment->isAdminDelete())) ) {
						$comments[] = $comment;
						$i++;
					}

					if( $i === 2 ) break;
				}
				if( count($comments) < 2 ) {
				//if there is only one reply we add the top message
				//and the order is correct
					array_unshift($comments, $topMessage);
				} else {
				//when there are more replies than one, we need to change
				//the order again
					$comments = array_reverse($comments);
				}
				$comments = $this->getCommentsData($comments);
			} else {
			//top message doesn't have replies yet -- it's a new wall message
				$comments = $this->getCommentsData(array($topMessage));
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
	 * @param array $comments an array with WallMessage instances
	 *
	 * @author Andrzej 'nAndy' Åukaszewski
	 */
	private function getCommentsData($comments) {
		$app = F::app();
		$app->wf->ProfileIn(__METHOD__);

		$timeNow = time();
		$items = array();
		$i = 0;
		foreach($comments as $wm) {
			$data = $wm->getData(false, null, 30);

			if( !($data['author'] instanceof User) ) {
				// bugId:22820
				// in case of Page table entries without corresponding revision
				// there is no content for specific article (and consequently - wall message)
				// and there is no user
				// it's safe to ignore such entries
				error_log("WallHelper.class.php NO_AUTHOR_FOR_AC:" . $wm->getId() );
				continue;
			}

			$items[$i]['avatar'] = $data['avatarSmall'];
			$items[$i]['user-profile-url'] = $data['userurl'];
			$user = User::newFromName($data['author']->getName());

			if( $user ) {
				$items[$i]['real-name'] = $user->getName();
				$userWallTitle = F::build( 'Title', array( $user->getName(), NS_USER_WALL ), 'newFromText' );
				$items[$i]['user-profile-url'] = $userWallTitle->getFullUrl();
			} else {
				$items[$i]['real-name'] = '';
			}

			$items[$i]['author'] = $data['username'];
			$items[$i]['wall-comment'] = $this->shortenText($this->strip_wikitext($data['rawtext'])).'&nbsp;';
			if( User::isIP( $data['username']) ) {
				$items[$i]['user-profile-url'] = Skin::makeSpecialUrl('Contributions').'/'.$data['username'];
				$items[$i]['real-name'] = wfMsg('oasis-anon-user');
			} else {
				$items[$i]['author'] = "";
			}

			//if message is older than 3 days we don't show its timestamp
			$items[$i]['timestamp'] = $msgTimestamp = $data['rawmwtimestamp'];
			$ago = $timeNow - strtotime($msgTimestamp) + 1;
			if( $ago <= self::WA_WALL_COMMENTS_EXPIRED_TIME ) {
				$items[$i]['timestamp'] = $msgTimestamp;
			} else {
				$items[$i]['timestamp'] = null;
			}

			$items[$i]['wall-message-url'] = $wm->getMessagePageUrl();
			$i++;
		}
		unset($data);

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
		$name = $app->wg->User->getName();
		if (User::isIP($name)){
			$name = wfMsg('oasis-anon-user');
			$name{0} = strtolower($name{0});
		}
		return $app->wf->msg('wall-default-title', array('$1' => $name));

	}

	public function getParsedText($rawtext, $title) {
		global $wgParser, $wgOut;
		global $wgEnableParserCache;
		global $wgUser;
		$wgEnableParserCache = false;

		return $wgParser->parse( $rawtext, $title, $wgOut->parserOptions())->getText();
	}

	public function isDbkeyFromWall($dbkey) {
		$lookFor = explode( '/@' ,$dbkey);
		if (count($lookFor) > 1){
			return true;
		}
		return false;
	}

	public function strip_wikitext($text) {
		$app = F::app();

		//local parser to fix the issue fb#17907
		$parser = F::build('Parser', array());

		$text = str_replace('*', '&asterix;', $text);
		$text = $parser->parse($text, $app->wg->Title, $app->wg->Out->parserOptions())->getText();
		// BugId:31034 - I had to give ENT_COMPAT and UTF-8 explicitly.
		// Prior PHP 5.4 the defaults are ENT_COMPAT and ISO-8859-1 (not UTF-8)
		// and cause HTML entities in an actual UTF-8 string to be decoded incorrectly
		// and displayed in... an ugly way.
		$text = trim( strip_tags( html_entity_decode( $text, ENT_COMPAT, 'UTF-8' ) ) );
		$text = str_replace('&asterix;', '*', $text);

		return $text;
	}

	/**
	 * @brief Gets old article's text
	 *
	 * @desc Returns article's content from text table if fail it'll return empty string
	 *
	 * @param integer $textId article's text id in text table
	 *
	 * @author Andrzej 'nAndy' Åukaszewski
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
	 * TODO: remove it we don't need to operate on delete wall messages anymore
	 *
	 * @author Andrzej 'nAndy' Åukaszewski
	 */
	public function getTitleTxtFromMetadata($text) {
		$pattern = '#<ac_metadata title="([^"]*)">(.*)</ac_metadata>#i';
		preg_match_all($pattern, $text, $matches);

		if( !empty($matches[1][0]) ) {
			return $matches[1][0];
		}

		return '';
	}

	public static function haveMsg($user) {
		$title = Title::newFromText( $user->getName(),  NS_USER_WALL );
		$comments = ArticleCommentList::newFromTitle($title);
		return $comments->getCountAll() > 0;
	}

	public function sendNotification($revOldId, $rcType = RC_NEW) {
		$app = F::App();
		$rev = Revision::newFromId($revOldId);
		$notif = F::build('WallNotificationEntity', array($rev, $app->wg->CityId), 'createFromRev');

		$wh = F::build('WallHistory', array($app->wg->CityId));
		
		$wh->add($rcType == RC_NEW ? WH_NEW : WH_EDIT, $notif, $app->wg->User);

		if( $rcType == RC_NEW ) {
			$wn = F::build('WallNotifications', array());
			$wn->addNotification($notif);
		}
	}

	//TODO: move it some how to wall message class

	public function isAllowedNotifyEveryone($ns, $user) {
		$app = F::App();
		if(in_array(MWNamespace::getSubject($ns), $app->wg->WallNotifyEveryoneNS) && $user->isAllowed('notifyeveryone')) {
			return true;
		}
		return false;
	}
	
	public static function getTopicPageURL($topic) {
		if(empty($topic)) {
			return "#";
		}
		//TODO:generalize this, this should be part of forum
		$topicTitle = Title::newFromText($topic->getPrefixedText(), NS_WIKIA_FORUM_TOPIC_BOARD);
		return $topicTitle->getFullURL();
	}
	
	public static function isWallNamespace($ns) {
		$app = F::App();
		return in_array( MWNamespace::getSubject( $ns ), $app->wg->WallNS );
	}
	
}

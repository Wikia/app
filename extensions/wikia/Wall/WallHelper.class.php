<?php

/**
 * @property mixed title
 */
class WallHelper {
	// WA = wiki activity
	const WA_WALL_COMMENTS_MAX_LEN = 150;
	const WA_WALL_COMMENTS_EXPIRED_TIME = 259200; // = (3 * 24 * 60 * 60) = 3 days

	const NOTIFICATION_EXPIRE_DAYS = 7;

	const PARSER_CACHE_TTL = 3600; // 60 * 60

	public function __construct() {
		$this->urls = [ ];
	}

	public function createPostContent( $title, $body ) {
		return Xml::element( "title", [ ], $title ) . "\n" . Xml::element( "body", [ ], $body );
	}

	public function getArchiveSubPageText() {
		return wfMessage( 'wall-user-talk-archive-page-title' )->text();
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
	public function getTitle( $namespace = null, $subpage = null, $user = null ) {
		if ( empty( $user ) ) {
			$user = $this->getUser();
		}


		if ( empty( $namespace ) ) {
			$namespace2 = $this->getVal( 'namespace' );
			$this->title = Title::newFromText( $user->getName(), $namespace2 );

			return $this->title;
		}

		if ( empty( $subpage ) ) {
			return Title::newFromText( $user->getName(), $namespace );
		} else {
			return Title::newFromText( $user->getName() . '/' . $subpage, $namespace );
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
	// TODO: remove call to UserProfilePage
	public function getUser() {
		$title = F::app()->wg->Title;
		$ns = $title->getNamespace();
		$user = null;

		if ( $ns == NS_USER_WALL ) {

			/**
			 * @var $w Wall
			 */
			$w = Wall::newFromTitle( $title );
			$user = $w->getUser();
		} else if ( $ns == NS_USER_WALL_MESSAGE ) {
			// title to wall thread is Thread:dddd, which does not exist in the db. this will
			// result in articleId being 0, which will break the logic later. So we need
			// to fetch the existing title here (Username/@comment-...)
			if ( intval( $title->getText() ) > 0 ) {
				$mainTitle = Title::newFromId( $title->getText() );
				if ( empty( $mainTitle ) ) {
					$mainTitle = Title::newFromId( $title->getText(), Title::GAID_FOR_UPDATE );
				}
				if ( !empty( $mainTitle ) ) {
					$title = $mainTitle;
				}
			}
			/**
			 * @var $wm WallMessage
			 */

			$wm = WallMessage::newFromTitle( $title );
			$user = $wm->getWallOwner();
		}

		if ( is_null( $user ) ) {
			return UserProfilePageHelper::getUserFromTitle( $title );
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
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function wikiActivityFilterMessageWall( $title, &$res ) {
		wfProfileIn( __METHOD__ );

		$item = [ ];
		$item['type'] = 'new';
		$item['wall'] = true;
		$item['ns'] = $res['ns'];
		$item['timestamp'] = $res['timestamp'];
		$item['wall-comment'] = $res['rc_params']['intro'];
		$item['article-id'] = $title->getArticleID();

		$wmessage = new WallMessage( $title );
		$parent = $wmessage->getTopParentObj();

		if ( !in_array( true, [ $wmessage->isAdminDelete(), $wmessage->isRemove() ] ) ) {
			$item['wall-title'] = $wmessage->getArticleTitle()->getPrefixedText();

			$owner = $wmessage->getWallOwner();

			$item['wall-owner'] = $owner->getName();
			$item['wall-msg'] = '';

			if ( empty( $parent ) ) {
			// parent
				$metaTitle = $wmessage->getMetaTitle();
				if ( !empty( $metaTitle ) ) {
					$item['title'] = $metaTitle;
				} else {
					$wmessage->load();
					$metaTitle = $wmessage->getMetaTitle();
					$item['title'] = empty( $metaTitle ) ? wfMessage( 'wall-no-title' )->escaped() : $metaTitle;
				}

				$item['url'] = $wmessage->getMessagePageUrl();
				$res['title'] = 'message-wall-thread-#' . $title->getArticleID();
				$item['wall-msg'] = wfMessage( 'wall-wiki-activity-on', $item['wall-title'], $item['wall-owner'] )->parse();
			} else {
			// child
				/* @var WallMessage $parent */
				$parent->load();

				if ( !in_array( true, [ $parent->isRemove(), $parent->isAdminDelete() ] ) ) {
					$this->mapParentData( $item, $parent );
					$res['title'] = 'message-wall-thread-#' . $parent->getTitle()->getArticleID();
					$item['wall-msg'] = wfMessage( 'wall-wiki-activity-on', $item['wall-title'], $item['wall-owner'] )->parse();
				} else {
				// message was removed or deleted
					$item = [ ];
				}
			}
		} else {
		// message was removed or deleted
			$item = [ ];
		}

		Hooks::run( 'AfterWallWikiActivityFilter', [ &$item, $wmessage ] );

		wfProfileOut( __METHOD__ );
		return $item;
	}

	/**
	 * @brief Copies parent's informations to child item
	 *
	 * @param array $item a referance to an array with wall comment informations
	 * @param WallMessage $parent parent comment
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function mapParentData( Array &$item, WallMessage $parent ) {
		wfProfileIn( __METHOD__ );

		$metaTitle = $parent->getMetaTitle();

		if ( !empty( $metaTitle ) ) {
			$item['title'] = $metaTitle;
		} else {
			$item['title'] = wfMessage( 'wall-no-title' )->escaped();
		}
		$item['url'] = $parent->getMessagePageUrl();

		$parentTitle = $parent->getTitle();
		if ( $parentTitle instanceof Title ) {
			$item['parent-id'] = $parentTitle->getArticleID();
		}

		wfProfileOut( __METHOD__ );
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
	public function getWallComments( $parentId = null ) {
		wfProfileIn( __METHOD__ );

		$comments = [ ];
		$commentsCount = 0;

		if ( !is_null( $parentId ) ) {
			$parent = WallMessage::newFromId( $parentId );

			if ( !( $parent instanceof WallMessage ) ) {
			// this should never happen
				Wikia::log( __METHOD__, false, 'No WallMessage instance article id: ' . $parentId, true );

				wfProfileOut( __METHOD__ );
				return [
					'count' => $commentsCount,
					'comments' => $comments,
				];
			}

			$wallThread = WallThread::newFromId( $parentId );
			$wallThread->loadIfCached();
			$topMessage = $wallThread->getThreadMainMsg();
			$comments = $wallThread->getRepliesWallMessages();

			if ( !empty( $comments ) ) {
			// top message has replies
				// in wiki activity we display amount of messages
				// not only replies (comments), so we add 1 which is top message
				$commentsCount = count( $comments ) + 1;
				$revComments = array_reverse( $comments );
				$comments = [ ];
				$i = 0;
				foreach ( $revComments as $comment ) {
					if ( !in_array( true, [ $comment->isRemove(), $comment->isAdminDelete() ] ) ) {
						$comments[] = $comment;
						$i++;
					}

					if ( $i === 2 ) break;
				}
				if ( count( $comments ) < 2 ) {
				// if there is only one reply we add the top message
				// and the order is correct
					array_unshift( $comments, $topMessage );
				} else {
				// when there are more replies than one, we need to change
				// the order again
					$comments = array_reverse( $comments );
				}
				$comments = $this->getCommentsData( $comments );
			} else {
			// top message doesn't have replies yet -- it's a new wall message
				$comments = $this->getCommentsData( [ $topMessage ] );
			}
		}

		wfProfileOut( __METHOD__ );
		return [
			'count' => $commentsCount,
			'comments' => $comments,
		];
	}

	/**
	 * @brief Gets wall comments data from memc/db
	 *
	 * @param WallMessage[] $comments an array with WallMessage instances
	 *
	 * @return array
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getCommentsData( Array $comments ) {
		wfProfileIn( __METHOD__ );

		$timeNow = time();
		$items = [ ];
		$i = 0;
		foreach ( $comments as $wm ) {
			$data = $wm->getData();

			if ( !( $data['author'] instanceof User ) ) {
				// bugId:22820
				// in case of Page table entries without corresponding revision
				// there is no content for specific article (and consequently - wall message)
				// and there is no user
				// it's safe to ignore such entries
				error_log( "WallHelper.class.php NO_AUTHOR_FOR_AC:" . $wm->getId() );
				continue;
			}

			$items[$i]['avatar'] = $data['avatarSmall'];
			$items[$i]['user-profile-url'] = $data['userurl'];
			$user = $data['author'];

			if ( $user instanceof User ) {
				$items[$i]['real-name'] = $user->getName();
				if ( !empty( F::app()->wg->EnableWallExt ) ) {
					$userLinkTitle = $user->getTalkPage();
				} else {
					$userLinkTitle = $user->getUserPage();
				}
				$items[$i]['user-profile-url'] = $userLinkTitle->getFullUrl();
			} else {
				$items[$i]['real-name'] = '';
			}

			$items[$i]['author'] = $data['username'];
			$items[$i]['wall-comment'] = $this->getMessageSnippet( $wm ) . '&nbsp;';
			if ( User::isIP( $data['username'] ) ) {
				$items[$i]['user-profile-url'] = Skin::makeSpecialUrl( 'Contributions' ) . '/' . $data['username'];
				$items[$i]['real-name'] = wfMessage( 'oasis-anon-user' )->escaped();
			} else {
				$items[$i]['author'] = "";
			}

			// if message is older than 3 days we don't show its timestamp
			$items[$i]['timestamp'] = $msgTimestamp = $data['rawmwtimestamp'];
			$ago = $timeNow - strtotime( $msgTimestamp ) + 1;
			if ( $ago <= self::WA_WALL_COMMENTS_EXPIRED_TIME ) {
				$items[$i]['timestamp'] = $msgTimestamp;
			} else {
				$items[$i]['timestamp'] = null;
			}

			$items[$i]['wall-message-url'] = $wm->getMessagePageUrl();
			$i++;
		}
		unset( $data );

		wfProfileOut( __METHOD__ );
		return $items;
	}

	/**
	 * @brief Shorten given text to given limit (if the text is longer than limit) and adds ellipses at the end
	 *
	 * @desc Text is truncated to given limit (by default limit is equal to WA_WALL_COMMENTS_MAX_LEN constant) then it truncates it to last spacebar and adds ellipses.
	 *
	 * @param Language $language Language object to be used in formatting string
	 * @param string $text text which needs to be shorter
	 * @param integer $limit limit of characters
	 *
	 * @return string
	 */
	public static function shortenText( Language $language, string $text, int $limit = self::WA_WALL_COMMENTS_MAX_LEN ): string {
		wfProfileIn( __METHOD__ );

		if ( mb_strlen( $text ) > $limit ) {
			$text = $language->truncate( $text, $limit );
			$lastSpacePos = strrpos( $text, ' ' );

			if ( $lastSpacePos !== false ) {
				$text = $language->truncate( $text, $lastSpacePos );
			}
		}

		wfProfileOut( __METHOD__ );
		return $text;
	}

	public function getDefaultTitle() {
		$app = F::app();
		$name = $app->wg->User->getName();
		if ( User::isIP( $name ) ) {
			$name = wfMessage( 'oasis-anon-user' )->escaped();
			$name { 0 } = strtolower( $name { 0 } );
		}
		return wfMessage( 'wall-default-title', $name )->text();

	}

	public function isDbkeyFromWall( $dbkey ) {
		$lookFor = explode( '/@' , $dbkey );
		if ( count( $lookFor ) > 1 ) {
			return true;
		}
		return false;
	}

	/**
	 * Call a lighweight parser to get a snippet of wall message
	 *
	 * @see SUS-1135
	 *
	 * @param WallMessage $wallMessage
	 * @return string
	 */
	public function getMessageSnippet( WallMessage $wallMessage ) {
		$messageText = $wallMessage->getRawText();
		// SUS-1684: Remove quotes and other HTML tags before parsing
		$messageText = Sanitizer::stripAllTags( $messageText );

		$formatted = Linker::formatComment( $messageText, $wallMessage->getTitle() );

		return static::shortenText( RequestContext::getMain()->getLanguage(), $formatted );
	}

	/**
	 * @brief Gets old article's text
	 *
	 * @desc Returns article's content from text table if fail it'll return empty string
	 *
	 * @param integer $textId article's text id in text table
	 *
	 * @return string
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getDeletedArticleTitleTxt( $textId ) {
		$dbr = wfGetDB( DB_SLAVE );

		$row = $dbr->selectRow(
			'text',
			[ 'old_text', 'old_flags' ],
			[ 'old_id' => $textId ],
			__METHOD__
		);

		if ( !empty( $row->old_text ) && !empty( $row->old_flags ) ) {
			$flags = explode( ',', $row->old_flags );
			if ( in_array( 'gzip', $flags ) ) {
				return gzinflate( ExternalStore::fetchFromUrl( $row->old_text ) );
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
	 * @return string
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getTitleTxtFromMetadata( $text ) {
		$pattern = '#<ac_metadata title="([^"]*)">(.*)</ac_metadata>#i';
		preg_match_all( $pattern, $text, $matches );

		if ( !empty( $matches[1][0] ) ) {
			return $matches[1][0];
		}

		return '';
	}

	public static function haveMsg( $user ) {
		$title = Title::newFromText( $user->getName(),  NS_USER_WALL );
		$comments = ArticleCommentList::newFromTitle( $title );
		return $comments->getCountAll() > 0;
	}

	/**
	 * Create a new Wall Notification from revision info, and dispatch it to wall_notifications table.
	 *
	 * @param Revision $rev
	 * @param int $rcType whether this is a new thread/reply (RC_NEW = 1) or edit to existing one/wall action (RC_EDIT = 2)
	 * @param User $user
	 */
	public static function sendNotification( Revision $rev, int $rcType, User $user ) {
		// SUS-3281: No point in creating notification for anons
		if ( $user->isAnon() ) {
			return;
		}

		$notif = WallNotificationEntity::createFromRev( $rev );
		$wh = new WallHistory();

		$wh->add( $rcType == RC_NEW ? WH_NEW : WH_EDIT, $notif, $user );

		if ( $rcType == RC_NEW ) {
			$wn = new WallNotifications();
			$wn->addNotification( $notif );
		}
	}

	// TODO: move it some how to wall message class

	public function isAllowedNotifyEveryone( $ns, $user ) {
		$app = F::App();
		if ( in_array( MWNamespace::getSubject( $ns ), $app->wg->WallNotifyEveryoneNS ) && $user->isAllowed( 'notifyeveryone' ) ) {
			return true;
		}
		return false;
	}

	public static function getTopicPageURL( $topic ) {
		if ( empty( $topic ) ) {
			return "#";
		}
		// TODO:generalize this, this should be part of forum
		$topicTitle = Title::newFromText( $topic->getPrefixedText(), NS_WIKIA_FORUM_TOPIC_BOARD );
		return $topicTitle->getFullURL();
	}

	public static function isWallNamespace( $ns ) {
		$app = F::App();
		return in_array( MWNamespace::getSubject( $ns ), $app->wg->WallNS );
	}

	public static function clearNamespaceList( $namespaces ) {
		if ( !empty( F::app()->wg->EnableForumExt ) ) {
			if ( isset( $namespaces[NS_FORUM] ) ) {
				unset( $namespaces[NS_FORUM] );
			}

			if ( isset( $namespaces[NS_FORUM_TALK] ) ) {
				unset( $namespaces[NS_FORUM_TALK] );
			}

			if ( isset( $namespaces[NS_WIKIA_FORUM_TOPIC_BOARD] ) ) {
				unset( $namespaces[NS_WIKIA_FORUM_TOPIC_BOARD] );
			}
		}

		if ( !empty( F::app()->wg->EnableWallExt ) ) {
			if ( isset( $namespaces[NS_USER_WALL] ) ) {
				unset( $namespaces[NS_USER_WALL] );
			}

			if ( isset( $namespaces[NS_USER_WALL_MESSAGE_GREETING] ) ) {
				unset( $namespaces[NS_USER_WALL_MESSAGE_GREETING] );
			}

			if ( isset( $namespaces[NS_USER_WALL_MESSAGE] ) ) {
				$namespaces[NS_USER_WALL_MESSAGE] = wfMessage( 'wall-recentchanges-wall-thread' )->text();
			}
		}

		return $namespaces;
	}

	/**
	 * @param RCCacheEntry $rc or a row from revison table
	 * @param array $row [ page_title, page_namespace, rev_user_text?, page_is_new?, rev_parent_id? ]
	 * @return array|bool
	 */
	public static function getWallTitleData( $rc = null, $row = null ) {
		if ( is_object( $row ) ) {
			// row from the revision table
			$objTitle = Title::makeTitle( $row->page_namespace, $row->page_title );
			$userText = isset( $row->rev_user ) ? User::getUsername( $row->rev_user, $row->rev_user_text ) : '';

			$isNew = ( !empty( $row->page_is_new ) && $row->page_is_new === '1' ) ? true : false;

			if ( !$isNew ) {
				$isNew = ( isset( $row->rev_parent_id ) && $row->rev_parent_id === '0' ) ? true : false;
			}

		} else {
			$objTitle = $rc->getTitle();
			$userIp = inet_ntop( $rc->getAttribute( 'rc_ip_bin' ) );
			$userText = User::getUsername( $rc->getAttribute( 'rc_user' ), $userIp );
			$isNew = false; // it doesn't metter for rc -- we've got there rc_log_action
		}


		if ( !( $objTitle instanceof Title ) ) {
			// it can be media wiki deletion of an article -- we ignore them
			Wikia::log( __METHOD__, false, "WALL_NOTITLE_FOR_MSG_OPTS " . print_r( [ $rc, $row ], true ) );
			return true;
		}

		// SUS-1777: Don't bother trying to load Wall Message if this is the Wall itself
		if ( $objTitle->inNamespace( NS_USER_WALL ) ) {
			// change in NS_USER_WALL namespace mean that wall page was created (bugid:95249)
			return [
				'articleTitle' => $objTitle->getPrefixedText(),
				'articleFullUrl' => $objTitle->getFullUrl(),
				'articleTitleVal' => '',
				'articleTitleTxt' => wfMessage(  'wall-recentchanges-wall-created-title' )->text(),
				'wallTitleTxt' => $objTitle->getPrefixedText(),
				'wallPageFullUrl' =>  $objTitle->getFullUrl(),
				'wallPageName' => $objTitle->getText(),
				'actionUser' => $userText,
				'isThread' => true,
				'isNew' => $isNew
			];
		}

		$wm = WallMessage::newFromId( $objTitle->getArticleId() );
		if ( empty( $wm ) ) {
			// it can be media wiki deletion of an article -- we ignore them
			Wikia::log( __METHOD__, false, "WALL_NOTITLE_FOR_MSG_OPTS " . print_r( [ $rc, $row ], true ) );
			return true;
		}

		$wm->load();
		if ( !$wm->isMain() ) {
			$wmw = $wm->getTopParentObj();
			if ( empty( $wmw ) ) {
				return true;
			}
			$wmw->load();
		}

		if ( !empty( $wmw ) ) {
			$articleTitleTxt =  $wmw->getMetaTitle();
			$articleId = $wmw->getId();
		} else {
			$articleTitleTxt = $wm->getMetaTitle();
			$articleId = $wm->getId();
		}

		// XSS vulnerable (MAIN-1412)
		if ( !empty( $articleTitleTxt ) ) {
			$articleTitleTxt = strip_tags( $articleTitleTxt );
		}

		$title = Title::makeTitle( NS_USER_WALL_MESSAGE, $articleId );

		return [
			'articleTitle' => $title->getPrefixedText(),
			'articleFullUrl' => $wm->getMessagePageUrl(),
			'articleTitleVal' => $articleTitleTxt,
			'articleTitleTxt' => empty( $articleTitleTxt ) ? wfMessage( 'wall-recentchanges-deleted-reply-title' )->text() : $articleTitleTxt,
			'wallTitleTxt' => $wm->getArticleTitle()->getPrefixedText(),
			'wallPageFullUrl' => $wm->getArticleTitle()->getFullUrl(),
			'wallPageName' => $wm->getArticleTitle()->getText(),
			'actionUser' => $userText,
			'isThread' => $wm->isMain(),
			'isNew' => $isNew
		];
	}
}

<?php

/**
 * ArticleComment is article, this class is used for manipulation on
 */

class ArticleComment {

	const MOVE_USER = 'WikiaBot';
	const AVATAR_BIG_SIZE = 50;
	const AVATAR_SMALL_SIZE = 30;

	const CACHE_VERSION = 1;
	const AN_HOUR = 3600;

	/**
	 * @var $mProps Bool blogs only
	 */
	public $mProps,
		$mLastRevId,
		$mFirstRevId,
		$mNamespace,
		$mMetadata,
		$mText,
		$mRawtext,
		$mHeadItems,
		$mNamespaceTalk;

	/**
	 * @var $mTitle Title
	 */
	public $mTitle;

	/**
	 * @var $mUser User comment creator
	 */
	public $mUser;

	/**
	 * @var $mArticle Article
	 */
	public $mArticle;

	/**
	 * @var $mLastRevision Revision for author & time
	 */
	public $mLastRevision;

	/**
	 * @var $mFirstRevId Revision for displaying text
	 */
	public $mFirstRevision;

	protected $minRevIdFromSlave;

	/**
	 * @param $title Title
	 */
	public function __construct( $title ) {
		$this->mTitle = $title;
		$this->mNamespace = $title->getNamespace();
		$this->mNamespaceTalk = MWNamespace::getTalk($this->mNamespace);
		$this->mProps = false;
	}

	/**
	 * newFromTitle -- static constructor
	 *
	 * @static
	 * @access public
	 *
	 * @param Title $title -- Title object connected to comment
	 *
	 * @return ArticleComment object
	 */
	static public function newFromTitle( Title $title ) {
		return new ArticleComment( $title );
	}

	/**
	 * newFromTitle -- static constructor
	 *
	 * @static
	 * @access public
	 *
	 * @param Title $title -- Title object connected to comment
	 *
	 * @return ArticleComment object
	 */
	static public function newFromArticle( Article $article ) {
		$title = $article->getTitle();

		$comment = new ArticleComment( $title );
		return $comment;
	}

	/**
	 *
	 * Used to store extra data in comment contend
	 *
	 * @access public
	 *
	 */

	public function setMetadata( $key, $val ) {
		$this->mMetadata[$key] = $val;
	}

	public function removeMetadata( $key ) {
		unset($this->mMetadata[$key]);
	}

	/**
	 *
	 * Used to get extra data in comment contend
	 *
	 * @access public
	 *
	 */

	public function getMetadata( $key, $val = '' ) {
		return empty($this->mMetadata[$key]) ? $val:$this->mMetadata[$key];
	}

	/**
	 * newFromId -- static constructor
	 *
	 * @static
	 * @access public
	 *
	 * @param Integer $id -- identifier from page_id
	 *
	 * @return ArticleComment object
	 */
	static public function newFromId( $id ) {
		$title = Title::newFromID( $id );
		if ( ! $title ) {
			/**
			 * maybe from Master?
			 */
			$title = Title::newFromID( $id, Title::GAID_FOR_UPDATE );

			if (empty($title)) {
				return false;
			}
		}
		//RT#86385 Why do we get an ID of 0 here sometimes when we know our id already?  Just set it!
		if ($title && $title->getArticleID() <= 0) {
			$title->mArticleID = $id;
		}
		return new ArticleComment( $title );
	}

	/**
	 * load -- set variables, load data from database
	 *
	 */
	public function load($master = false) {
		wfProfileIn( __METHOD__ );
		$result = true;

		if ( $this->mTitle ) {
 			// get revision ids
			if ( $master ) {
				$this->mLastRevId = $this->mTitle->getLatestRevID( Title::GAID_FOR_UPDATE );
			} else {
				$this->mLastRevId = $this->mTitle->getLatestRevID( );
				// if last rev does not exist on slave then fall back to master anyway
				if ( !$this->mLastRevId ) {
					$this->mLastRevId = $this->mTitle->getLatestRevID( Title::GAID_FOR_UPDATE );
				}
				// if last rev STILL does not exist, give up and set it to first rev
				if ( !$this->mLastRevId ) {
					$this->mLastRevId = $this->getFirstRevID( DB_MASTER );
				}
			}

			if ( empty( $this->mLastRevId ) ) {
				// assume article is bogus, threat as if it doesn't exist
				wfProfileOut( __METHOD__ );
				return false;
			}

			$this->mFirstRevId = $this->getFirstRevID( DB_SLAVE );
			// if first rev does not exist on slave then fall back to master anyway
			if ( !$this->mFirstRevId ) {
				$this->mFirstRevId = $this->getFirstRevID( DB_MASTER );
			}

			if ( empty( $this->mFirstRevId ) ) {
				// assume article is bogus, threat as if it doesn't exist
				wfProfileOut( __METHOD__ );
				return false;
			}

			// get revision objects
			if ( $this->mFirstRevId ) {
				$this->mFirstRevision = Revision::newFromId( $this->mFirstRevId );
				if ( !empty( $this->mFirstRevision ) && is_object( $this->mFirstRevision ) && ( $this->mFirstRevision instanceof Revision ) ) { // fix for FB:15198
					if ($this->mLastRevId == $this->mFirstRevId) {
						// save one db query by just setting them to the same revision object
						$this->mLastRevision = $this->mFirstRevision;
					} else {
						$this->mLastRevision = Revision::newFromId( $this->mLastRevId );
						if ( empty( $this->mLastRevision ) || !is_object( $this->mLastRevision ) || !( $this->mLastRevision instanceof Revision ) ) {
							$result = false;
						}
					}
				} else {
					$result = false;
				}
			} else {
				$result = false;
			}

			// get user that created this comment
			if ( $this->mFirstRevision ) {
				$this->mUser = User::newFromId( $this->mFirstRevision->getUser() );
				$this->mUser->setName( $this->mFirstRevision->getUserText() );
			} else {
				$result = false;
			}

			if(empty($this->mFirstRevision) || empty($this->mLastRevision) ){
				wfProfileOut( __METHOD__ );
				return false;
			}

			$rawtext = $this->mLastRevision->getText();
			$this->parseText( $rawtext );
		} else { // null title
			$result = false;
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	public function parseText( $rawtext ) {
		global $wgEnableParserCache;

		$this->mRawtext = self::removeMetadataTag( $rawtext );

		$wgEnableParserCache = false;

		$parser = ParserPool::get();

		$parser->ac_metadata = [];

		// Always tidy Article Comment markup to avoid breakage of surrounding markup
		global $wgAlwaysUseTidy;
		$oldWgAlwaysUseTidy = $wgAlwaysUseTidy;
		$wgAlwaysUseTidy = true;

		$head = $parser->parse( $rawtext, $this->mTitle, ParserOptions::newFromContext( RequestContext::getMain() ) );

		$this->mText = $head->getText();
		$this->mHeadItems = $head->getHeadItems();

		if( isset( $parser->ac_metadata ) ) {
			$this->mMetadata = $parser->ac_metadata;
		} else {
			$this->mMetadata = [];
		}

		ParserPool::release( $parser );

		// Restore old value of $wgAlwaysUseTidy
		$wgAlwaysUseTidy = $oldWgAlwaysUseTidy;

		return $this->mText;
	}

	public function getText() {
		return $this->mText;
	}

	/**
	 * getFirstRevID -- What is id for first revision
	 * @see Title::getLatestRevID
	 *
	 * @return Integer
	 */
	private function getFirstRevID( $db_conn ) {
		wfProfileIn( __METHOD__ );

		$id = false;

		if ( $db_conn == DB_SLAVE && isset($this->minRevIdFromSlave) ) {
			wfProfileOut( __METHOD__ );
			return $this->minRevIdFromSlave;
		}

		if ( $this->mTitle ) {
			$db = wfGetDB($db_conn);
			$id = $db->selectField(
				'revision',
				'min(rev_id)',
				array( 'rev_page' => $this->mTitle->getArticleID() ),
				__METHOD__
			);
		}

		wfProfileOut( __METHOD__ );

		return $id;
	}

	public function setFirstRevId( $value, $db_conn ) {
		if ( $db_conn == DB_SLAVE ) {
			$this->minRevIdFromSlave = $value;
		}
	}

	/**
	 * getTitle -- getter/accessor
	 *
	 */
	public function getTitle() {
		return $this->mTitle;
	}

	public function getData( $master = false ) {
		global $wgUser, $wgBlankImgUrl, $wgMemc, $wgArticleCommentsEnableVoting;

		wfProfileIn( __METHOD__ );

		$comment = false;

		$canDelete = $wgUser->isAllowed( 'commentdelete' );

		if ( self::isBlog() ) {
			$canDelete = $canDelete || $wgUser->isAllowed( 'blog-comments-delete' );
		}

		$title = $this->getTitle();
		$commentId = $title->getArticleId();

		//vary cache on permision as well so it changes we can show it to a user
		$articleDataKey = wfMemcKey(
			'articlecomment_data',
			$commentId,
			$title->getLatestRevID(),
			$wgUser->getId(),
			$canDelete,
			RequestContext::getMain()->getSkin()->getSkinName(),
			self::CACHE_VERSION
		);

		$data = $wgMemc->get( $articleDataKey );

		if ( !empty( $data ) ) {
			$data['timestamp'] = "<a href='" . $title->getFullUrl( array( 'permalink' => $data['id'] ) ) . '#comm-' . $data['id'] . "' class='permalink'>" . wfTimeFormatAgo($data['rawmwtimestamp']) . "</a>";

			wfProfileOut( __METHOD__ );
			return $data;
		}

		if ( $this->load( $master ) ) {
			$sig = ( $this->mUser->isAnon() )
				? AvatarService::renderLink( $this->mUser->getName() )
				: Xml::element( 'a', array ( 'href' => $this->mUser->getUserPage()->getFullUrl() ), $this->mUser->getName() );

			$isStaff = (int)in_array('staff', $this->mUser->getEffectiveGroups() );

			$parts = self::explode($title);

			$buttons = array();
			$replyButton = '';

			//this is for blogs we want to know if commenting on it is enabled
			$commentingAllowed = ArticleComment::canComment( Title::newFromText( $title->getBaseText() ) );

			if ( ( count( $parts['partsStripped'] ) == 1 ) && $commentingAllowed && !ArticleCommentInit::isFbConnectionNeeded() ) {
				$replyButton = '<button type="button" class="article-comm-reply wikia-button secondary actionButton">' . wfMsg('article-comments-reply') . '</button>';
			}
			if( defined('NS_QUESTION_TALK') && ( $title->getNamespace() == NS_QUESTION_TALK ) ) {
				$replyButton = '';
			}

			if ( $canDelete && !ArticleCommentInit::isFbConnectionNeeded() ) {
				$img = '<img class="remove sprite" alt="" src="'. $wgBlankImgUrl .'" width="16" height="16" />';
				$buttons[] = $img . '<a href="' . $title->getLocalUrl('redirect=no&action=delete') . '" class="article-comm-delete">' . wfMsg('article-comments-delete') . '</a>';
			}

			//due to slave lag canEdit() can return false negative - we are hiding it by CSS and force showing by JS
			if ( $wgUser->isLoggedIn() && $commentingAllowed && !ArticleCommentInit::isFbConnectionNeeded() ) {
				$display = $this->canEdit() ? 'test=' : ' style="display:none"';
				$img = '<img class="edit-pencil sprite" alt="" src="' . $wgBlankImgUrl . '" width="16" height="16" />';
				$buttons[] = "<span class='edit-link'$display>" . $img . '<a href="#comment' . $commentId . '" class="article-comm-edit actionButton" id="comment' . $commentId . '">' . wfMsg('article-comments-edit') . '</a></span>';
			}

			if ( !$this->mTitle->isNewPage(Title::GAID_FOR_UPDATE) ) {
				$buttons[] = RequestContext::getMain()->getSkin()->makeKnownLinkObj( $title, wfMsgHtml('article-comments-history'), 'action=history', '', '', 'class="article-comm-history"' );
			}

			$rawmwtimestamp = $this->mFirstRevision->getTimestamp();
			$rawtimestamp = wfTimeFormatAgo($rawmwtimestamp);
			$timestamp = "<a rel='nofollow' href='" . $title->getFullUrl( array( 'permalink' => $commentId ) ) . '#comm-' . $commentId . "' class='permalink'>" . wfTimeFormatAgo($rawmwtimestamp) . "</a>";

			$comment = array(
				'id' => $commentId,
				'author' => $this->mUser,
				'username' => $this->mUser->getName(),
				'avatar' => AvatarService::renderAvatar($this->mUser->getName(), self::AVATAR_BIG_SIZE),
				'avatarSmall' => AvatarService::renderAvatar($this->mUser->getName(), self::AVATAR_SMALL_SIZE),
				'userurl' =>  AvatarService::getUrl($this->mUser->getName()),
				'isLoggedIn' => $this->mUser->isLoggedIn(),
				'buttons' => $buttons,
				'replyButton' => $replyButton,
				'sig' => $sig,
				'text' => $this->mText,
				'metadata' => $this->mMetadata,
				'rawtext' =>  $this->mRawtext,
				'timestamp' => $timestamp,
				'rawtimestamp' => $rawtimestamp,
				'rawmwtimestamp' =>	$rawmwtimestamp,
				'title' => $title->getText(),
				'isStaff' => $isStaff,
			);

			if( !empty( $wgArticleCommentsEnableVoting ) ) {
				$comment['votes'] = $this->getVotesCount();
			}

			$wgMemc->set( $articleDataKey, $comment, self::AN_HOUR );

			if(!($comment['title'] instanceof Title)) {
				$comment['title'] = Title::newFromText( $comment['title'], NS_TALK );
			}
		}

		wfProfileOut( __METHOD__ );

		return $comment;
	}

	/**
	 * @static
	 * @param Parser $parser
	 * @return bool
	 */
	static public function metadataParserInit( Parser $parser ) {
		$parser->setHook('ac_metadata', 'ArticleComment::parserTag');
		return true;
	}

	/**
	 * @static
	 * @param string $content parser tag content
	 * @param Array $attributes attribs
	 * @param Parser $self
	 * @return string
	 */
	public static function parserTag( $content, $attributes, Parser $self ) {
		$self->ac_metadata = $attributes;
		return '';
	}

	/**
	 * delete article with out any confirmation (used by wall)
	 *
	 * @access public
	 */
	public function doDeleteComment( $reason, $suppress = false ){
		global $wgUser;
		if(empty($this->mArticle)) {
			$this->mArticle = new Article($this->mTitle, 0);
		}
		$error = '';
		$id = $this->mArticle->getId();
		//we need to run all the hook manual :/
		if ( wfRunHooks( 'ArticleDelete', array( &$this->mArticle, &$wgUser, &$reason, &$error ) ) ) {
			if( $this->mArticle->doDeleteArticle( $reason, $suppress ) ) {
				$this->mTitle->getPrefixedText();
				wfRunHooks( 'ArticleDeleteComplete', array( &$this->mArticle, &$wgUser, $reason, $id) );
				return true;
			}
		}

		return false;
	}

	/**
	 * get Title object of article page
	 *
	 * @access public
	 */
	public function getArticleTitle() {
		if ( !isset($this->mTitle) ) {
			return null;
		}

		$title = null;
		$parts = self::explode($this->mTitle->getDBkey());
		if ($parts['title'] != '') {
			$title = Title::makeTitle(MWNamespace::getSubject($this->mNamespace), $parts['title']);
		}
		return $title;
	}

	/**
	 * @static
	 * @param $title Title
	 * @return bool
	 */
	public static function isTitleComment($title) {
		if (!($title instanceof Title)) {
			return false;
		}

		if ( self::isBlog() ) {
			return true;
		} else {
			return strpos(end(explode('/', $title->getText())), ARTICLECOMMENT_PREFIX) === 0;
		}
	}

	public static function explode($titleText, $oTitle = null) {
		$count = 0;
		$titleTextStripped = str_replace(ARTICLECOMMENT_PREFIX, '', $titleText, $count);
		$partsOriginal = explode('/', $titleText);
		$partsStripped = explode('/', $titleTextStripped);

		if ($count) {
			$title = implode('/', array_splice($partsOriginal, 0, -$count));
			array_splice($partsStripped, 0, -$count);
		} else {
			//not a comment - fallback
			$title = $titleText;
			$partsOriginal = $partsStripped = array();
		}

		$result = array(
			'title' => $title,
			'partsOriginal' => $partsOriginal,
			'partsStripped' => $partsStripped
		);

		return $result;
	}

	/**
	 * check if current user can edit comment
	 */
	public function canEdit() {
		global $wgUser;

		$isAuthor = false;

		if ( $this->mFirstRevision ) {
			$isAuthor = $this->mFirstRevision->getUser( Revision::RAW ) == $wgUser->getId() && !$wgUser->isAnon();
		}

		//prevent infinite loop for blogs - userCan hooked up in BlogLockdown
		$canEdit = self::isBlog( $this->mTitle ) || $this->mTitle->userCan( "edit" );

		$isAllowed = $wgUser->isAllowed('commentedit');

		$res = $isAuthor || ( $isAllowed && $canEdit );

		return $res;
	}

	/**
	 * Check if current user can comment
	 *
	 * @returns boolean
	 */
	public static function canComment( Title $title = null ) {
		global $wgTitle;

		$canComment = true;
		$title = is_null( $title ) ? $wgTitle : $title;

		if ( self::isBlog( $title ) ) {
			$props = BlogArticle::getProps( $title->getArticleID() );

			$canComment = isset( $props[ 'commenting' ] ) ? ( bool ) $props[ 'commenting' ] : true;
		}

		return $canComment;
	}

	/**
	 * @param $user User
	 * @return bool
	 */
	public function isAuthor($user) {
		if ( $this->mUser ) {
			return $this->mUser->getId() == $user->getId() && !$user->isAnon();
		}
		return false;
	}

	/**
	 * Whether or not the current page is a blog page
	 *
	 * @return boolean
	 */
	public static function isBlog( Title $title = null ) {
		global $wgTitle;

		$isBlog = false;
		$title = is_null( $title ) ? $wgTitle : $title;

		if ( !empty( $title ) ) {
			$namespace = $title->getNamespace();
			$isBlog =
				( defined( 'NS_BLOG_ARTICLE' ) && $namespace == NS_BLOG_ARTICLE ) ||
				( defined( 'NS_BLOG_ARTICLE_TALK' ) && $namespace == NS_BLOG_ARTICLE_TALK );
		}

		return $isBlog;
	}

	/**
	 * editPage -- show edit form
	 *
	 * @access public
	 *
	 * @return String
	 */
	public function editPage() {
		global $wgStylePath;
		wfProfileIn( __METHOD__ );

		$text = '';
		$this->load(true);
		if ($this->canEdit() && !ArticleCommentInit::isFbConnectionNeeded()) {
			$vars = array(
				'canEdit'				=> $this->canEdit(),
				'comment'				=> htmlentities(ArticleCommentsAjax::getConvertedContent($this->mLastRevision->getText())),
				'isReadOnly'			=> wfReadOnly(),
				'isMiniEditorEnabled'	=> ArticleComment::isMiniEditorEnabled(),
				'stylePath'				=> $wgStylePath,
				'articleId'				=> $this->mTitle->getArticleId(),
				'articleFullUrl'		=> $this->mTitle->getFullUrl(),
			);
			$text = F::app()->getView('ArticleComments', 'Edit', $vars)->render();
		}

		wfProfileOut( __METHOD__ );

		return $text;
	}

	/**
	 * doSaveComment -- save comment
	 *
	 * @access public
	 * @param $preserveMetadata: hack to fix bug 102384 (prevent metadata override when trying to modify one of metadata keys)
	 * @return Array or false on error. - TODO: Document what the array contains.
	 */
	public function doSaveComment( $text, $user, $title = null, $commentId = 0, $force = false, $summary = '', $preserveMetadata = false ) {
		global $wgTitle;
		wfProfileIn( __METHOD__ );
		$metadata = $this->mMetadata;

		$this->load(true);

		if ( $force || ($this->canEdit() && !ArticleCommentInit::isFbConnectionNeeded()) ) {

			if ( wfReadOnly() ) {
				wfProfileOut( __METHOD__ );
				return false;
			}

			if ( !$text || !strlen( $text ) ) {
				wfProfileOut( __METHOD__ );
				return false;
			}

			if ( empty($this->mTitle) && !$commentId ) {
				wfProfileOut( __METHOD__ );
				return false;
			}

			$commentTitle = $this->mTitle ? $this->mTitle : Title::newFromId($commentId);

			/**
			 * because we save different title via Ajax request
			 */
			$origTitle = $wgTitle;
			$wgTitle = $commentTitle;

			/**
			 * add article using EditPage class (for hooks)
			 */

			$article = new Article( $commentTitle, intval( $this->mLastRevId ) );
			if ( $preserveMetadata ) {
				$this->mMetadata = $metadata;
			}
			$retval = self::doSaveAsArticle($text, $article, $user, $this->mMetadata, $summary );

			if(!empty($title)) {
				$purgeTarget = $title;
			} else {
				$purgeTarget = $origTitle;
			}

			ArticleCommentList::purgeCache( $purgeTarget );
			$res = array( $retval, $article );
		} else {
			$res = false;
		}

		$this->mLastRevId = $this->mTitle->getLatestRevID( Title::GAID_FOR_UPDATE );
		$this->mLastRevision = Revision::newFromId( $this->mLastRevId );

		wfProfileOut( __METHOD__ );

		return $res;
	}

	/**
	 * doSaveAsArticle store comment as article
	 *
	 * @static
	 * @param $text String
	 * @param $article Article
	 * @param $user User
	 * @param array $metadata
	 * @return Status TODO: Document
	 */
	static protected function doSaveAsArticle($text, $article, $user, $metadata = array(), $summary = '' ) {
		$result = null;

		$editPage = new EditPage( $article );
		$editPage->edittime = $article->getTimestamp();
		$editPage->textbox1 = self::removeMetadataTag($text);

		$editPage->summary = $summary;

		if(!empty($metadata)) {
			$editPage->textbox1 =  $text. Xml::element( 'ac_metadata', $metadata, ' ' );
		}

		$bot = $user->isAllowed('bot');

		return $editPage->internalAttemptSave( $result, $bot );
	}

	/**
	 *
	 * remove metadata tag from
	 *
	 * @access protected
	 *
	 */

	static protected function removeMetadataTag($text) {
		return preg_replace('#</?ac_metadata(\s[^>]*)?>#i', '', $text);
	}


	/**
	 * doPost -- static hook/entry for normal request post
	 *
	 * @static
	 * @access public
	 *
	 * @param WebRequest $request -- instance of WebRequest
	 * @param User       $user    -- instance of User who is leaving the comment
	 * @param Title      $title   -- instance of Title
	 *
	 * @return Article -- newly created article
	 */
	static public function doPost( $text, $user, $title, $parentId = false, $metadata = array() ) {
		global $wgTitle;
		wfProfileIn( __METHOD__ );

		if ( !$text || !strlen( $text ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		/**
		 * title for comment is combination of article title and some 'random' data
		 */
		if ($parentId == false) {
			//1st level comment
			$commentTitle = sprintf('%s/%s%s-%s', $title->getText(), ARTICLECOMMENT_PREFIX, $user->getName(), wfTimestampNow());
		} else {
			$parentArticle = Article::newFromID($parentId);
			if(empty($parentArticle)) {
				$parentTitle = Title::newFromID($parentId, Title::GAID_FOR_UPDATE);
				// it's possible for Title to be empty at this point
				// if article was removed in the meantime
				// (for eg. when replying on Wall from old browser session
				//  to non-existing thread)
				// it's fine NOT to create Article in that case
				if(!empty($parentTitle)) {
					$parentArticle = new Article($parentTitle);
				}

				// if $parentTitle is empty the logging below will be executed
			}
			//FB#2875 (log data for further debugging)
			if (is_null($parentArticle)) {
				$debugTitle = !empty($title) ? $title->getText() : '--EMPTY--'; // BugId:2646
				Wikia::log(__FUNCTION__, __LINE__, "Failed to create Article object, ID=$parentId, title={$debugTitle}, user={$user->getName()}", true);
				wfProfileOut( __METHOD__ );
				return false;
			}
			$parentTitle = $parentArticle->getTitle();
			//nested comment
			$commentTitle = sprintf('%s/%s%s-%s', $parentTitle->getText(), ARTICLECOMMENT_PREFIX, $user->getName(), wfTimestampNow());
		}
		$commentTitleText = $commentTitle;
		$commentTitle = Title::newFromText($commentTitle, MWNamespace::getTalk($title->getNamespace()));
		/**
		 * because we save different tile via Ajax request TODO: fix it !!
		 */
		$wgTitle = $commentTitle;


		if( !($commentTitle instanceof Title) ) {
			if ( !empty($parentId) ) {
				Wikia::log( __METHOD__, false, "ArticleComment::doPost (reply to " . $parentId .
					") - failed to create commentTitle from " . $commentTitleText, true );
			}
			wfProfileOut( __METHOD__ );
			return false;
		}

		/**
		 * add article using EditPage class (for hooks)
		 */

		$article  = new Article( $commentTitle, 0 );

		CommentsIndex::addCommentInfo($commentTitleText, $title, $parentId);

		$retval = self::doSaveAsArticle($text, $article, $user, $metadata);

		if ( $retval->value == EditPage::AS_SUCCESS_NEW_ARTICLE ) {
			$commentsIndex = CommentsIndex::newFromId( $article->getID() );
			wfRunHooks( 'EditCommentsIndex', [ $article->getTitle(), $commentsIndex ] );
		}

		$res = ArticleComment::doAfterPost( $retval, $article, $parentId );

		ArticleComment::doPurge($title, $commentTitle);

		wfProfileOut( __METHOD__ );

		return array( $retval, $article, $res );
	}

	/**
	 * @static
	 * @param $title Title
	 * @param $commentTitle Title
	 */
	static public function doPurge($title, $commentTitle) {
		wfProfileIn( __METHOD__ );

		global $wgArticleCommentsLoadOnDemand;

		// make sure our comment list is refreshed from the master RT#141861
		$commentList = ArticleCommentList::newFromTitle($title);
		$commentList->purge();
		$commentList->getCommentList(true);

		// Purge squid proxy URLs for ajax loaded content if we are lazy loading
		if ( !empty( $wgArticleCommentsLoadOnDemand ) ) {
			$urls = array();
			$pages = $commentList->getCountPages();
			$articleId = $title->getArticleId();

			for ( $page = 1; $page <= $pages; $page++ ) {
				$params[ 'page' ] = $page;
				$urls[] = ArticleCommentsController::getUrl(
					'Content',
					array(
						'format' => 'html',
						'articleId' => $articleId,
						'page' => $page,
						'skin' => 'true'
					)
				);
			}

			$squidUpdate = new SquidUpdate( $urls );
			$squidUpdate->doUpdate();

		// Otherwise, purge the article
		} else {

			//BugID: 2483 purge the parent article when new comment is posted
			//BugID: 29462, purge the ACTUAL parent, not the root page... $#%^!
			$parentTitle = Title::newFromText( $commentTitle->getBaseText() );

			if ($parentTitle) {
				$parentTitle->invalidateCache();
				$parentTitle->purgeSquid();
			}
		}

		/*
		// TODO: use this when surrogate key purging works correctly
		$parentTitle = Title::newFromText( $commentTitle->getBaseText() );

		if ($parentTitle) {
			if ( empty( $wgArticleCommentsLoadOnDemand ) ) {
				// need to invalidate parsed article if it includes comments in the body
				$parentTitle->invalidateCache();
			}
			SquidUpdate::VarnishPurgeKey( self::getSurrogateKey( $parentTitle->getArticleID() ) );
		}
		*/

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @static
	 * @param $status
	 * @param $article Article
	 * @param int $parentId
	 * @return array
	 */

	static public function doAfterPost( $status, $article, $parentId = 0 ) {
		global $wgUser, $wgDBname;

		wfRunHooks( 'ArticleCommentAfterPost', array( $status, &$article ) );
		$commentId = $article->getID();
		$error = false;
		$id = 0;

		switch( $status->value ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
				$comment = ArticleComment::newFromArticle( $article );
				$app = F::app();
				$text = $app->getView( 'ArticleComments',
					( $app->checkSkin( 'wikiamobile' ) ) ? 'WikiaMobileComment' : 'Comment',
					array('comment' => $comment->getData(true),
						'commentId' => $commentId,
						'rowClass' => '',
						'level' => ( $parentId ) ? 2 : 1 ) )->render();

				if ( !is_null($comment->mTitle) ) {
					$id = $comment->mTitle->getArticleID();
				}

				if ( !empty($comment->mTitle) ) {
					self::addArticlePageToWatchlist( $comment ) ;
				}

				$message = false;

				//commit before purging
				wfGetDB(DB_MASTER)->commit();
				break;
			default:
				$userId = $wgUser->getId();
				Wikia::log( __METHOD__, 'error', "No article created. Status: {$status->value}; DB: {$wgDBname}; User: {$userId}" );
				$text  = false;
				$error = true;
				$message = wfMsg('article-comments-error');
		}

		$res = array(
			'commentId' => $commentId,
			'error'  	=> $error,
			'id'		=> $id,
			'msg'    	=> $message,
			'status' 	=> $status,
			'text'   	=> $text
		);

		return $res;
	}

	/**
	 * @static
	 * @param $comment ArticleComment
	 * @return bool
	 */
	static public function addArticlePageToWatchlist( $comment ) {
		global $wgUser, $wgEnableArticleWatchlist, $wgBlogsEnableStaffAutoFollow;

		if(!wfRunHooks( 'ArticleCommentBeforeWatchlistAdd', array( $comment ) )) {
			return true;
		}

		if ( empty($wgEnableArticleWatchlist) || $wgUser->isAnon() ) {
			return false;
		}

		$oArticlePage = $comment->getArticleTitle();
		if ( is_null($oArticlePage) ) {
			return false;
		}


		if ( $wgUser->getOption( 'watchdefault' ) && !$oArticlePage->userIsWatching() ) {
			# and article page
			$wgUser->addWatch( $oArticlePage );
		}

		if ( !empty($wgBlogsEnableStaffAutoFollow) && self::isBlog() ) {
			$owner = BlogArticle::getOwner($oArticlePage);
			$oUser = User::newFromName($owner);
			if ( $oUser instanceof User ) {
				$groups = $oUser->getEffectiveGroups();
				if ( is_array($groups) && in_array( 'staff', $groups ) ) {
					$wgUser->addWatch( Title::newFromText( $oUser->getName(), NS_BLOG_ARTICLE ) );
				}
			}
		}

		return true;
	}

	/**
	 * Hook
	 *
	 * @param RecentChange $oRC -- instance of RecentChange class
	 *
	 * @static
	 * @access public
	 *
	 * @return Bool true -- because it's a hook
	 */
	static public function watchlistNotify(RecentChange &$oRC) {
		global $wgEnableGroupedArticleCommentsRC;
		wfProfileIn( __METHOD__ );

		wfRunHooks( 'AC_RecentChange_Save', array( &$oRC ) );

		if ( !empty($wgEnableGroupedArticleCommentsRC) && ( $oRC instanceof RecentChange ) ) {
			$title = $oRC->getAttribute('rc_title');
			$namespace = $oRC->getAttribute('rc_namespace');
			$article_id = $oRC->getAttribute('rc_cur_id');
			$title = Title::newFromText($title, $namespace);

			//TODO: review
			if (MWNamespace::isTalk($namespace) &&
				ArticleComment::isTitleComment($title) &&
				!empty($article_id)) {

				$comment = ArticleComment::newFromId( $article_id );
				if ( $comment instanceof ArticleComment ) {
					$oArticlePage = $comment->getArticleTitle();
					$mAttribs = $oRC->mAttribs;
					$mAttribs['rc_title'] = $oArticlePage->getDBkey();
					$mAttribs['rc_namespace'] = $oArticlePage->getNamespace();
					$mAttribs['rc_log_action'] = 'article_comment';

					$oRC->setAttribs($mAttribs);
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Hook
	 *
	 * @param Title $title -- instance of EmailNotification class
	 * @param Array $keys -- array of all special variables like $PAGETITLE etc
	 * @param String $message (subject or body)
	 * @param $editor User
	 *
	 * @static
	 * @access public
	 *
	 * @return Bool true -- because it's a hook
	 */
	static public function ComposeCommonMail( $title, &$keys, &$message, $editor ) {
		global $wgEnotifUseRealName;

		if (MWNamespace::isTalk($title->getNamespace()) && ArticleComment::isTitleComment($title)) {
			if ( !is_array($keys) ) {
				$keys = array();
			}

			$name = $wgEnotifUseRealName ? $editor->getRealName() : $editor->getName();
			if ( $editor->isIP( $name ) ) {
				$utext = trim(wfMsgForContent('enotif_anon_editor', ''));
				$message = str_replace('$PAGEEDITOR', $utext, $message);
				$keys['$PAGEEDITOR'] = $utext;
			}
		}
		return true;
	}

	/**
	 * create task to move comment
	 *
	 * @access public
	 * @static
	 *
	 * @param $oCommentTitle Title
	 * @param $oNewTitle Title
	 */
	static private function addMoveTask( $oCommentTitle, &$oNewTitle, $taskParams ) {
		wfProfileIn( __METHOD__ );

		if ( !is_object( $oCommentTitle ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$parts = self::explode($oCommentTitle->getDBkey());
		$commentTitleText = implode('/', $parts['partsOriginal']);

		$newCommentTitle = Title::newFromText(
			sprintf( '%s/%s', $oNewTitle->getText(), $commentTitleText ),
			MWNamespace::getTalk($oNewTitle->getNamespace()) );

		$taskParams['page'] = $oCommentTitle->getFullText();
		$taskParams['newpage'] = $newCommentTitle->getFullText();
		$thisTask = new MultiMoveTask( $taskParams );
		$submit_id = $thisTask->submitForm();
		Wikia::log( __METHOD__, 'deletecomment', "Added move task ($submit_id) for {$taskParams['page']} page" );

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * move one comment
	 *
	 * @access public
	 * @static
	 *
	 * @param $oCommentTitle Title
	 * @param $oNewTitle title
	 */
	static private function moveComment( $oCommentTitle, &$oNewTitle, $reason = '' ) {
		global $wgUser;

		wfProfileIn( __METHOD__ );

		if ( !is_object( $oCommentTitle ) ) {
			wfProfileOut( __METHOD__ );
			return array('invalid title');
		}

		$currentUser = $wgUser;
		$wgUser = User::newFromName( self::MOVE_USER );

		$parts = self::explode($oCommentTitle->getDBkey());
		$commentTitleText = implode('/', $parts['partsOriginal']);

		$newCommentTitle = Title::newFromText(
			sprintf( '%s/%s', $oNewTitle->getText(), $commentTitleText ),
			MWNamespace::getTalk($oNewTitle->getNamespace()) );

		$error = $oCommentTitle->moveTo( $newCommentTitle, false, $reason, false );

		$wgUser = $currentUser;

		wfProfileOut( __METHOD__ );
		return $error;
	}

	/**
	 * hook
	 *
	 * @access public
	 * @static
	 *
	 * @param $form MovePageForm
	 * @param $oOldTitle Title
	 * @param $oNewTitle Title
	 */
	static public function moveComments( /*MovePageForm*/ &$form , /*Title*/ &$oOldTitle , /*Title*/ &$oNewTitle ) {
		global $wgUser, $wgRC2UDPEnabled, $wgMaxCommentsToMove, $wgEnableMultiDeleteExt, $wgCityId;
		wfProfileIn( __METHOD__ );

		if ( !$wgUser->isAllowed( 'move' ) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( $wgUser->isBlocked() ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$commentList = ArticleCommentList::newFromTitle( $oOldTitle );
		$comments = $commentList->getCommentPages(true, false);

		if (count($comments)) {
			$mAllowTaskMove = false;
			if ( isset($wgMaxCommentsToMove) && ( $wgMaxCommentsToMove > 0) && ( !empty($wgEnableMultiDeleteExt) ) ) {
				$mAllowTaskMove = true;
			}

			$irc_backup = $wgRC2UDPEnabled;	//backup
			$wgRC2UDPEnabled = false; //turn off
			$finish = $moved = 0;
			$comments = array_values($comments);
			foreach ($comments as $id => $aCommentArr) {
				/**
				 * @var $oCommentTitle Title
				 */
				$oCommentTitle = $aCommentArr['level1']->getTitle();

				# move comment level #1
				$error = self::moveComment( $oCommentTitle, $oNewTitle, $form->reason );
				if ( $error !== true ) {
					Wikia::log( __METHOD__, 'movepage',
						'cannot move blog comments: old comment: ' . $oCommentTitle->getPrefixedText() . ', ' .
						'new comment: ' . $oNewTitle->getPrefixedText() . ', error: ' . @implode(', ', $error)
					);
				} else {
					$moved++;
				}

				if (isset($aCommentArr['level2'])) {
					foreach ($aCommentArr['level2'] as $oComment) {
						/**
						 * @var $oComment ArticleComment
						 * @var $oCommentTitle Title
						 */
						$oCommentTitle = $oComment->getTitle();

						# move comment level #2
						$error = self::moveComment( $oCommentTitle, $oNewTitle, $form->reason );
						if ( $error !== true ) {
							Wikia::log( __METHOD__, 'movepage',
								'cannot move blog comments: old comment: ' . $oCommentTitle->getPrefixedText() . ', ' .
								'new comment: ' . $oNewTitle->getPrefixedText() . ', error: ' . @implode(', ', $error)
							);
						} else {
							$moved++;
						}
					}
				}

				if ( $mAllowTaskMove && $wgMaxCommentsToMove < $moved ) {
					$finish = $id;
					break;
				}
			}

			# rest comments move to task
			if ( $finish > 0 && $finish < count($comments) ) {
				$taskParams= array(
					'wikis'		=> '',
					'reason' 	=> $form->reason,
					'lang'		=> '',
					'cat'		=> '',
					'selwikia'	=> $wgCityId,
					'user'		=> self::MOVE_USER
				);

				for ( $i = $finish + 1; $i < count($comments); $i++ ) {
					$aCommentArr = $comments[$i];
					$oCommentTitle = $aCommentArr['level1']->getTitle();
					self::addMoveTask( $oCommentTitle, $oNewTitle, $taskParams );
					if (isset($aCommentArr['level2'])) {
						foreach ($aCommentArr['level2'] as $oComment) {
							$oCommentTitle = $oComment->getTitle();
							self::addMoveTask( $oCommentTitle, $oNewTitle, $taskParams );
						}
					}
				}
			}

			$wgRC2UDPEnabled = $irc_backup; //restore to whatever it was
			$listing = ArticleCommentList::newFromTitle($oNewTitle);
			$listing->purge();
		} else {
			Wikia::log( __METHOD__, 'movepage', 'cannot move article comments, because no comments: ' . $oOldTitle->getPrefixedText());
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	//Blogs only functions
	/**
	 * setProps -- change props for comment article
	 *
	 */
	public function setProps( $props, $update = false ) {
		wfProfileIn( __METHOD__ );

		if ( $update && class_exists('BlogArticle') ) {
			BlogArticle::setProps( $this->mTitle->getArticleID(), $props );
		}
		$this->mProps = $props;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * getProps -- get props for comment article
	 *
	 */
	public function getProps(){
		if ( (!$this->mProps || !is_array( $this->mProps )) && class_exists('BlogArticle') ) {
			$this->mProps = BlogArticle::getProps( $this->mTitle->getArticleID() );
		}
		return $this->mProps;
	}

	//Voting functions

	public function getVotesCount(){
		$pageId = $this->mTitle->getArticleId();
		$oFauxRequest = new FauxRequest(array( "action" => "query", "list" => "wkvoteart", "wkpage" => $pageId, "wkuservote" => 0, "wktimestamps" => 1 ));
		$oApi = new ApiMain($oFauxRequest);
		$oApi->execute();
		$aResult = $oApi->getResultData();

		if( isset( $aResult['query']['wkvoteart'][$pageId]['votescount'] ) ) {
			return $aResult['query']['wkvoteart'][$pageId]['votescount'];
		} else {
			return 0;
		}
	}

	public function vote() {
		$oFauxRequest = new FauxRequest(array( "action" => "insert", "list" => "wkvoteart", "wkpage" => $this->mTitle->getArticleId(), "wkvote" => 3 ));
		$oApi = new ApiMain($oFauxRequest);

		$oApi->execute();

		$aResult = $oApi->getResultData();

		$success = !empty( $aResult );

		return $success;
	}

	public function userCanVote() {
		$pageId = $this->mTitle->getArticleId();

		$oFauxRequest = new FauxRequest(array( "action" => "query", "list" => "wkvoteart", "wkpage" => $pageId, "wkuservote" => 1 ));
		$oApi = new ApiMain($oFauxRequest);
		$oApi->execute();
		$aResult = $oApi->GetResultData();

		if( isset( $aResult['query']['wkvoteart'][$pageId]['uservote'] ) ) {
			$result = false;
		} else {
			$result = true;
		}

		return $result;
	}

	public function getTopParent() {
		$key = $this->mTitle->getDBkey();

		return $this->explodeParentTitleText($key);
	}

	/**
	 * @brief Explodes string got from Title::getText() and returns its parent's text if exists
	 *
	 * @param string $titleText this is the text given from Title::getText()
	 *
	 * @return string | null if given $titleText is a parent's one returns null
	 */
	public function explodeParentTitleText($titleText) {
		$parts = explode('/@', $titleText);

		if(count($parts) < 3) return null;

		return $parts[0] . '/@' . $parts[1];
	}

	public function getTopParentObj() {
		$title = $this->getTopParent();

		if( empty($title) ) return null;

		$title = Title::newFromText( $title, $this->mNamespace );

		if( $title instanceof Title ) {
			$obj = ArticleComment::newFromTitle( $title );

			return $obj;
		}

		return null;
	}

	static public function getSurrogateKey( $articleId ) {
		global $wgCityId;
		return 'Wiki_' . $wgCityId . '_ArticleComments_' . $articleId;
	}

	/**
	 * Checks if article comments will be loading on demand.
	 *
	 * @return boolean
	 */
	static public function isLoadingOnDemand() {
		$app = F::app();
		return $app->wg->ArticleCommentsLoadOnDemand && !$app->checkSkin( 'wikiamobile' );
	}

	/**
	 * Checks if mini editor is enabled for article comments.
	 *
	 * @return boolean
	 */
	static public function isMiniEditorEnabled() {
		$app = F::app();
		return $app->wg->EnableMiniEditorExtForArticleComments && $app->checkSkin( 'oasis' );
	}

	/**
	 * @desc Helper method returning true or false depending on fact if ArticleComments or Blogs are enabled
	 *
	 * @return bool
	 */
	static private function isCommentingEnabled() {
		global $wgEnableArticleCommentsExt, $wgEnableBlogArticles;

		return !empty($wgEnableArticleCommentsExt) || !empty($wgEnableBlogArticles);
	}

	/**
	 * @desc Enables article and blog comments deletion for users who have commentdelete right but don't have delete
	 *
	 * @param Article $article
	 * @param Title $title
	 * @param User $user
	 * @param Array $permission_errors
	 *
	 * @return true because it's a hook
	 */
	static public function onBeforeDeletePermissionErrors( &$article, &$title, &$user, &$permission_errors ) {
		if( self::isCommentingEnabled() &&
			$user->isAllowed( 'commentdelete' ) &&
			ArticleComment::isTitleComment( $title )
		) {
			foreach( $permission_errors as $key => $errorArr ) {
				if( self::isBadAccessError( $errorArr ) ) {
					unset( $permission_errors[$key] );
				}
			}
		}

		return true;
	}

	/**
	 * @desc Checks if $errors array have badaccess-groups or badaccess-group0 string
	 *
	 * @param Array $errors
	 *
	 * @return bool
	 */
	static private function isBadAccessError( $errors ) {
		return in_array( 'badaccess-groups', $errors ) || in_array( 'badaccess-group0', $errors );
	}

}

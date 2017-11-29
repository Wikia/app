<?php

/**
 * Class which builds new Thread for Message Wall/Forum
 * and performs associated updates
 */
class WallMessageBuilder extends WallBuilder {
	use \Wikia\Logger\Loggable;

	// Mandatory fields
	/** @var string $messageText */
	private $messageText;
	/** @var User $messageAuthor */
	private $messageAuthor;
	/** @var Title $parentPageTitle */
	private $parentPageTitle;
	/** @var string $messageTitle */
	private $messageTitle;

	// Optional fields
	/** @var WallMessage|null $parentMessage */
	private $parentMessage = null;
	/** @var bool $notify; */
	private $notify = true;
	/** @var bool $notifyEveryone */
	private $notifyEveryone = false;
	/** @var array $relatedTopics */
	private $relatedTopics = [];

	// Generated fields
	/** @var array $metaData */
	private $metaData;
	/** @var WallMessage $newMessage */
	private $newMessage;
	/** @var Revision $newRevision */
	private $newRevision;

	/**
	 * Check if Forum Board or Message Wall we are posting on exists, and try to create it if does not yet exist.
	 * @return WallMessageBuilder
	 */
	public function createParentPageIfNotExists(): WallMessageBuilder {
		if ( !$this->parentPageTitle->exists() ) {
			$robot = User::newFromName( Wikia::BOT_USER );
			$page = WikiPage::factory( $this->parentPageTitle );

			$status = $page->doEdit( '', '', EDIT_NEW | EDIT_MINOR | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT, false, $robot );
			if ( !$status->isOK() ) {
				$this->throwException( WallBuilderException::class, 'Failed to create parent page for message' );
			}
		}

		return $this;
	}

	/**
	 * Given user-supplied parameters, initialize message metadata which will be saved as part of comment content.
	 * @return WallMessageBuilder
	 */
	public function createMetaData(): WallMessageBuilder {
		$this->metaData = [ 'title' => $this->messageTitle ];
		if ( $this->notifyEveryone ) {
			$this->metaData[ 'notify_everyone' ] = time();
		}
		if ( !empty( $this->relatedTopics ) ) {
			$this->metaData[ 'related_topics' ] = implode( '|', $this->relatedTopics );
		}

		return $this;
	}

	/**
	 * Call ArticleComments and actually save the new message.
	 * All permissions checks (Phalanx spam filter and user blocks, local blocks, AbuseFilter...) are performed at this step.
	 * @return WallMessageBuilder
	 */
	public function postNewMessage(): WallMessageBuilder {
		/**
		 * Hook into MW transaction to ensure data integrity is maintained in comments_index table
		 * If handler cannot create comments_index entry, transaction will be aborted and comment will not be posted!
		 * @see WallMessageBuilder::insertNewCommentsIndexEntry()
		 */
		Hooks::register( 'ArticleDoEdit', [ $this, 'insertNewCommentsIndexEntry' ] );

		if ( !$this->parentMessage ) {
			$result = ArticleComment::doPost( $this->messageText, $this->messageAuthor, $this->parentPageTitle, false, $this->metaData );
		} elseif ( !$this->parentMessage->canReply() ) {
			// This can happen in two cases
			// 1) thread was removed or deleted but the user has not refreshed the page and attempted to post a reply
			// 2) direct nirvana invocation of WallExternalController::replyToMessage ("hack")
			$this->throwException( WallBuilderException::class, 'Attempted to post reply on deleted or removed thread' );
		} else {
			$result = ArticleComment::doPost( $this->messageText, $this->messageAuthor, $this->parentMessage->getTitle(), $this->parentMessage->getId() );
		}

		if ( !$result || !$result[0]->isOK() ) {
			// Permissions check are performed on article comment level by EditPage class of Mediawiki
			// Text is matched there against Phalanx filters and all user blocks (global and local) are also checked
			// This can cause edit to fail
			if ( $result && 'EditFilter' == $result[0]->errors[0]['params'][0] ) {
				$this->throwException(
						InappropriateContentException::class,
						'Inappropriate content detected',
						[ 'block' => $result[0]->errors[0]['params'][1] ]
					);
			} else {
				$this->throwException( WallBuilderException::class, 'Failed to create article comment' );
			}
		}

		/**
		 * @var Article $article
		 * @var Status $status
		 * @var Revision $rev
		 */
		list( $status, $article ) = $result;
		$title = $article->getTitle();
		$rev = $status->revision;

		// Preload article ID - saves DB call
		$this->newRevision = $rev;
		$title->mArticleID = $rev->getPage();
		$this->newMessage = WallMessage::newFromTitle( $title );
		return $this;
	}

	/**
	 * Do thread-related updates, such as updating related topics, initializing display order for history, and purging cache.
	 * @return WallMessageBuilder
	 */
	public function doNewThreadUpdates(): WallMessageBuilder {
		$this->newMessage->storeRelatedTopicsInDB( $this->relatedTopics );
		$this->newMessage->setOrderId();

		// purge URLs for Wall/Board etc., catch up with slaves
		$this->newMessage->invalidateCache();

		// have user watch new message
		$this->newMessage->addWatch( $this->messageAuthor );

		return $this;
	}

	/**
	 * Do reply related updates, such as updating display order for history and purging cache.
	 * @return WallMessageBuilder
	 */
	public function doNewReplyUpdates(): WallMessageBuilder {
		// TODO: review if use of master is really needed here
		$count = $this->parentMessage->getOrderId( true );

		if ( is_numeric( $count ) ) {
			$count++;
			$this->parentMessage->setOrderId( $count );
			$this->newMessage->setOrderId( $count );
		}

		// after successful posting invalidate Thread memcache...
		$this->newMessage->getThread()->invalidateCache();

		// ...and purge Wall/Board URLs.
		$this->newMessage->invalidateCache();

		$rp = new WallRelatedPages();
		$rp->setLastUpdate( $this->parentMessage->getId() );

		return $this;
	}

	/**
	 * Optionally notify users following this thread about the change.
	 * @return WallMessageBuilder
	 */
	public function notifyIfNeeded(): WallMessageBuilder {
		if ( $this->notify ) {
			WallHelper::sendNotification( $this->newRevision, RC_NEW, $this->messageAuthor );
		}

		return $this;
	}

	/**
	 * If set, notify all users on the wiki about the change.
	 * @return WallMessageBuilder
	 */
	public function notifyEveryoneForNewThreadIfNeeded(): WallMessageBuilder {
		if ( $this->notifyEveryone ) {
			$notif = WallNotificationEntity::createFromRev( $this->newRevision );

			$wne = new WallNotificationsEveryone();
			$wne->addNotificationToQueue( $notif );
		}

		return $this;
	}

	/**
	 * Insert a new entry into comments_index table for the new thread or reply.
	 * In order to enforce data integrity, we have to use the same transaction as MediaWiki
	 *
	 * @see WikiPage::doEdit()
	 * @see https://wikia-inc.atlassian.net/browse/ZZZ-3225
	 *
	 * @param DatabaseBase $dbw DB connection used by MediaWiki to create article comment
	 * @param Title $title title of newly posted article comment
	 * @param Revision $rev newly inserted revision
	 * @return bool true if comments index was successfully updated, else false to force MW to rollback the transaction
	 */
	public function insertNewCommentsIndexEntry( DatabaseBase $dbw, Title $title, Revision $rev ): bool {
		if ( $title->isTalkPage() && WallHelper::isWallNamespace( $title->getNamespace() ) ) {
			$parentPageId = $this->parentPageTitle->getArticleID();
			$parentCommentId = $this->parentMessage ? $this->parentMessage->getId() : 0;
			$revId = $rev->getId();

			$entry =
				( new CommentsIndexEntry() )
					->setNamespace( $title->getNamespace() )
					->setParentPageId( $parentPageId )
					->setParentCommentId( $parentCommentId )
					->setCommentId( $title->getArticleID() )
					->setFirstRevId( $revId )
					->setLastRevId( $revId );

			$result = CommentsIndex::getInstance()->insertEntry( $entry, $dbw );
			if ( !$result ) {
				$this->error( __METHOD__ . ' - SUS-1719: Failed to insert Comments Index Entry', [
					'title' => $title->getPrefixedText(),
					'revision' => $rev->getId(),
					'articleId' => $rev->getPage()
				] );
			}

			return $result;
		}

		return true;
	}

	/**
	 * Return the WallMessage instance representing the newly posted message.
	 * @return WallMessage
	 */
	public function build(): WallMessage {
		// new thread
		if ( !$this->parentMessage ) {
			$this
				->createParentPageIfNotExists()
				->createMetaData()
				->postNewMessage()
				->doNewThreadUpdates()
				->notifyIfNeeded()
				->notifyEveryoneForNewThreadIfNeeded();
		} else {
			// reply
			$this
				->postNewMessage()
				->doNewReplyUpdates()
				->notifyIfNeeded();
		}

		Hooks::run( 'AfterBuildNewMessageAndPost', [ $this->newMessage ] );
		return $this->newMessage;
	}

	/**
	 * Populate an exception with proper context for logging, and throw it
	 *
	 * @param string $class
	 * @param string $message
	 * @param array $additionalContext
	 */
	protected function throwException( string $class, string $message, array $additionalContext=[] ) {
		$context = array_merge( $additionalContext,
			[
				'parentPageTitle' => $this->parentPageTitle->getPrefixedText(),
				'parentPageId' => $this->parentPageTitle->getArticleID(),
				'parentMessageTitle' => $this->parentMessage ? $this->parentMessage->getTitle()->getPrefixedText() : '',
				'parentMessageId' => $this->parentMessage ? $this->parentMessage->getId() : '',
			]);

		throw new $class( $message, $context );
	}

	/**
	 * @param Title $parentPageTitle
	 * @return WallMessageBuilder
	 */
	public function setParentPageTitle( Title $parentPageTitle ): WallMessageBuilder {
		$this->parentPageTitle = $parentPageTitle;

		return $this;
	}

	/**
	 * @param null|WallMessage $parentMessage
	 * @return WallMessageBuilder
	 */
	public function setParentMessage( $parentMessage ) {
		$this->parentMessage = $parentMessage;

		return $this;
	}

	/**
	 * @param string $messageTitle
	 * @return WallMessageBuilder
	 */
	public function setMessageTitle( string $messageTitle ): WallMessageBuilder {
		$this->messageTitle = $messageTitle;

		return $this;
	}

	/**
	 * @param string $messageText
	 * @return WallMessageBuilder
	 */
	public function setMessageText( string $messageText ): WallMessageBuilder {
		$this->messageText = $messageText;

		return $this;
	}

	/**
	 * @param User $messageAuthor
	 * @return WallMessageBuilder
	 */
	public function setMessageAuthor( User $messageAuthor ): WallMessageBuilder {
		$this->messageAuthor = $messageAuthor;

		return $this;
	}

	/**
	 * @param bool $notify
	 * @return WallMessageBuilder
	 */
	public function setNotify( bool $notify ): WallMessageBuilder {
		$this->notify = $notify;

		return $this;
	}

	/**
	 * @param bool $notifyEveryone
	 * @return WallMessageBuilder
	 */
	public function setNotifyEveryone( bool $notifyEveryone ): WallMessageBuilder {
		$this->notifyEveryone = $notifyEveryone;

		return $this;
	}

	/**
	 * @param array $metaData
	 * @return WallMessageBuilder
	 */
	public function setMetaData( array $metaData ): WallMessageBuilder {
		$this->metaData = $metaData;

		return $this;
	}

	/**
	 * @param array $relatedTopics
	 * @return WallMessageBuilder
	 */
	public function setRelatedTopics( array $relatedTopics ): WallMessageBuilder {
		$this->relatedTopics = $relatedTopics;

		return $this;
	}

	/**
	 * @param WallMessage $newMessage
	 * @return WallMessageBuilder
	 */
	public function setNewMessage( WallMessage $newMessage ): WallMessageBuilder {
		$this->newMessage = $newMessage;

		return $this;
	}
}

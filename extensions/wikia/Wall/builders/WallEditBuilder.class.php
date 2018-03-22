<?php

/**
 * Class WallEditBuilder builds newly edited version of Wall/Forum thread or reply
 */
class WallEditBuilder extends WallBuilder {
	use \Wikia\Logger\Loggable;

	/** @var string $messageText */
	private $messageText;
	/** @var User $editor*/
	private $editor;
	/** @var WallMessage $message */
	private $message;

	/** @var ArticleComment $articleComment */
	private $articleComment;

	/**
	 * Save the message with the newly provided text, and empty caches.
	 * @return WallEditBuilder
	 */
	public function editWallMessage(): WallEditBuilder {
		if ( !$this->message->canEdit( $this->editor ) ) {
			$this->throwException( WallBuilderException::class, 'User not allowed to edit message' );
		}

		/**
		 * Hook into MW transaction
		 * @see WallEditBuilder::updateCommentsIndexEntry()
		 */
		Hooks::register( 'ArticleDoEdit', [ $this, 'updateCommentsIndexEntry' ] );

		$comment = $this->message->getArticleComment();
		$result = $comment->doSaveComment( $this->messageText, $this->editor );
		if ( !$result || !$result[0]->isOK() ) {
			if ( $result && in_array( 'EditFilter', $result[0]->errors[0]['params'] ) ) {
				$this->throwException(
					InappropriateContentException::class,
					'Inappropriate content detected',
					[ 'block' => $result[0]->errors[0]['params'][1] ]
				);
			} else {
				$this->throwException( WallBuilderException::class, 'Failed to save edited message' );
			}
		}

		if ( !$this->message->isMain() ) {
			// after changing reply invalidate thread cache on memc level
			$this->message->getThread()->invalidateCache();
		}

		// Purge URLs for Wall/Board page etc., catch up with slaves
		$this->message->invalidateCache();

		WallHelper::sendNotification( $comment->mLastRevision, RC_EDIT, $this->editor );

		$this->articleComment = $comment;
		return $this;
	}


	/**
	 * Update the entry of this message in comments_index table with the newly inserted revision ID
	 * In order to enforce data integrity, we have to use the same transaction as MediaWiki
	 *
	 * @see WikiPage::doEdit()
	 * @see https://wikia-inc.atlassian.net/browse/ZZZ-3225
	 *
	 * @param DatabaseBase $dbw DB connection used by MediaWiki to edit article comment
	 * @param Title $title title of edited article comment
	 * @param Revision $rev newly inserted revision
	 * @return bool true
	 */
	public function updateCommentsIndexEntry( DatabaseBase $dbw, Title $title, Revision $rev ): bool {
		if ( $title->isTalkPage() && WallHelper::isWallNamespace( $title->getNamespace() ) ) {
			$entry = CommentsIndex::getInstance()->entryFromId( $title->getArticleID() );
			$entry->setLastRevId( $rev->getId() );

			$result = CommentsIndex::getInstance()->updateEntry( $entry, $dbw );
			if ( !$result ) {
				$this->error( 'Failed to update Comments Index Entry', [
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
	 * Return newly parsed text of edited message
	 * @return string
	 */
	public function build() {
		$this->editWallMessage();

		$this->articleComment->setRawText( $this->messageText );
		return $this->articleComment->getTransformedParsedText();
	}

	/**
	 * Populate an exception with proper context for logging, and throw it
	 *
	 * @param string $class
	 * @param string $message
	 * @param array $additionalContext
	 */
	protected function throwException( string $class, string $message, array $additionalContext=[] ) {
		$context = array_merge( $additionalContext, [
				'parentPageTitle' => $this->message->getArticleTitle()->getPrefixedText(),
				'parentPageId' => $this->message->getArticleTitle()->getArticleID(),
				'messageTitle' => $this->message->getTitle()->getPrefixedText(),
				'messageId' => $this->message->getTitle()->getArticleID(),
			]);

		throw new $class( $message, $context );
	}

	/**
	 * @param string $messageText
	 * @return WallEditBuilder
	 */
	public function setMessageText( string $messageText ): WallEditBuilder {
		$this->messageText = $messageText;

		return $this;
	}

	/**
	 * @param User $editor
	 * @return WallEditBuilder
	 */
	public function setEditor( User $editor ): WallEditBuilder {
		$this->editor = $editor;

		return $this;
	}

	/**
	 * @param WallMessage $message
	 * @return WallEditBuilder
	 */
	public function setMessage( WallMessage $message ): WallEditBuilder {
		$this->message = $message;

		return $this;
	}

	/**
	 * @param ArticleComment $articleComment
	 * @return WallEditBuilder
	 */
	public function setArticleComment( ArticleComment $articleComment ): WallEditBuilder {
		$this->articleComment = $articleComment;

		return $this;
	}
}

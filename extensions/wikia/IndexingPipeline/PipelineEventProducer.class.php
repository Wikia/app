<?php

class PipelineEventProducer {
	const ARTICLE_MESSAGE_PREFIX = 'article';
	/** @var PipelineConnectionBase */
	protected static $pipe;

	public static function send( $eventName, $pageId, $params = [ ] ) {
		global $wgCityId;
		$msg = new stdClass();
		$msg->cityId = $wgCityId;
		$msg->pageId = $pageId;
		$msg->args = new stdClass();
		foreach ( $params as $param => $value ) {
			$msg->args->{$param} = $value;
		}
		try {
			self::getPipeline()->publish( implode( '.', [ self::ARTICLE_MESSAGE_PREFIX, $eventName ] ), $msg );
		} catch ( Exception $e ) {
			\Wikia\Logger\WikiaLogger::instance()->error( __METHOD__, [
				'exception' => $e,
				'event_name' => $eventName
			] );
		}
	}

	/** @return PipelineConnectionBase */
	protected static function getPipeline() {
		if ( !isset( self::$pipe ) ) {
			self::$pipe = new PipelineConnectionBase();
		}
		return self::$pipe;
	}

	// Hooks handlers
	static public function onArticleSaveComplete( &$oPage, &$oUser, $text, $summary, $minor, $undef1, $undef2, &$flags, $oRevision, &$status, $baseRevId ) {
		wfDebug( "IndexingPipeline:onArticleSaveComplete\n" );
		$rev = isset($oRevision) ? $oRevision->getId() : $oRevision;
		self::send( 'onArticleSaveComplete', $oPage->getId(),
			[ 'prevRevision' => $baseRevId, 'revision' => $rev ] );
		return true;
	}

	static public function onNewRevisionFromEditComplete( /* WikiPage */
		$article, Revision $rev, $baseID, User $user ) {
		wfDebug( "IndexingPipeline:onNewRevisionFromEditComplete\n" );
		self::send( 'onNewRevisionFromEditComplete', $article->getId(),
			[ 'prevRevision' => $baseID, 'revision' => $rev->getId() ] );
		return true;
	}

	static public function onArticleDeleteComplete( &$oPage, &$oUser, $reason, $pageId ) {
		wfDebug( "IndexingPipeline:onArticleDeleteComplete\n" );
		self::send( 'onArticleDeleteComplete', $pageId );
		return true;
	}

	static public function onArticleUndelete( Title &$oTitle, $isNew = false ) {
		wfDebug( "IndexingPipeline:onArticleUndelete\n" );
		self::send( 'onArticleUndelete', $oTitle->getArticleId(), [ 'isNew' => $isNew ] );
		return true;
	}

	static public function onTitleMoveComplete( &$oOldTitle, &$oNewTitle, &$oUser, $pageId, $redirectId = 0 ) {
		wfDebug( "IndexingPipeline:onTitleMoveComplete\n" );
		self::send( 'onTitleMoveComplete', $pageId, [ 'redirectId' => $redirectId ] );
		return true;
	}
}

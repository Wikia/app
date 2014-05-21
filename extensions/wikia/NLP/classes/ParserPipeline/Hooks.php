<?php

namespace \Wikia\NLP\ParserPipeline;
use Wikia\Tasks\Queues\NlpPipelineQueue;
use \Title;

class Hooks
{
	
	public static function onArticleEditUpdates( $article, $editInfo, $changed ) {
		global $wgContentNamespaces, $wgCityId;
		$title = $article->getTitle();
		if ( $changed && in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
			$task = ( new NlpParseContentTask() )
				->wikiId( $wgCityId )
				->title( $title )
				->setPriority( NlpPipelineQueue::NAME );
			$task->call( 'parse' );
			$task->queue();
		}
		return true;
	}

	public static function onArticleDeleteComplete( $article, User $user, $reason, $id ) {
		global $wgContentNamespaces, $wgCityId;
		$title = $article->getTitle();
		if ( in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
			self::deleteTitleParse( $title );
		}
		return true;
	}

	public static function onArticleUndelete( Title $title, $created, $comment ) {
		global $wgContentNamespaces;
		if ( in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
			self::parseTitle( $title );
		}
		return true;
	}

	public static function onTitleMoveComplete( Title $title, Title $newtitle, User $user, $oldid, $newid ) {
		if ( in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
			self::deleteTitleParse( $title );
			self::parseTitle( $newTitle );			
		}
		return true;
	}

	private static function parseTitle( Title $title ) {
		$task = ( new NlpParseContentTask() )
				->wikiId( $wgCityId )
				->title( $title )
				->setPriority( NlpPipelineQueue::NAME );
		$task->call( 'parse' );
		$task->queue();		
	}

	private static function deleteTitleParse( Title $title ) {
		$task = ( new NlpParseContentTask() )
				->wikiId( $wgCityId )
				->title( $title )
				->setPriority( NlpPipelineQueue::NAME );
		$task->call( 'delete_parse' );
		$task->queue();
	}


}
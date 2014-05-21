<?php

namespace \Wikia\NLP\ParserPipeline;
use Wikia\Tasks\Queues\NlpPipelineQueue;
use Wikia\Tasks\AsyncBackendTaskList;
use \Title;

class Hooks
{
	
	public static function onArticleEditUpdates( $article, $editInfo, $changed ) {
		global $wgContentNamespaces;
		$title = $article->getTitle();
		if ( $changed && in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
			self::parseEvent( $title, 'celery_workers.nlp_pipeline.parse' );
		}
		return true;
	}

	public static function onArticleDeleteComplete( $article, User $user, $reason, $id ) {
		global $wgContentNamespaces;
		$title = $article->getTitle();
		if ( in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
			self::parseEvent( $title, 'celery_workers.nlp_pipeline.delete' );
		}
		return true;
	}

	public static function onArticleUndelete( Title $title, $created, $comment ) {
		global $wgContentNamespaces;
		if ( in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
			self::parseEvent( $title, 'celery_workers.nlp_pipeline.parse' );
		}
		return true;
	}

	public static function onTitleMoveComplete( Title $title, Title $newtitle, User $user, $oldid, $newid ) {
		global $wgContentNamespaces;
		if ( in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
			self::parseEvent( $title, 'celery_workers.nlp_pipeline.delete' );
			self::parseEvent( $newtitle, 'celery_workers.nlp_pipeline.parse' );
		}
		return true;
	}

	private static function parseEvent( Title $title, $task ) {
		global $wgCityId;

		$taskList = new AsyncBackendTaskList();

		$taskList->taskType( $task )
				 ->add( $title->getArticleId() )
				 ->wikiId( $wgCityId )
				 ->wikiUrl( preg_replace( '/\/wiki\/*$/', '', $title->getFullURL() ) )
				 ->setPriority( Wikia\Tasks\Queues\NlpPipelineQueue::NAME )
				 ->queue();
	}

}
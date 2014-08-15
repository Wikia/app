<?php

namespace Wikia\NLP\ParserPipeline;
use Wikia\Tasks\Queues\NlpPipelineQueue;
use Wikia\Tasks\AsyncBackendTaskList;
use \Title, \User;

class Hooks
{
	
	public static function onArticleEditUpdates( $article, $editInfo, $changed ) {
		global $wgContentNamespaces;
		$title = $article->getTitle();
		if ( $changed && in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
			self::parseEvent( $title->getArticleId(), $title->getFullUrl(), 'celery_workers.nlp_pipeline.parse' );
		}
		return true;
	}

	public static function onArticleDeleteComplete( $article, User $user, $reason, $id ) {
		global $wgContentNamespaces;
		$title = $article->getTitle();
		if ( in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
			self::parseEvent( $id, $title->getFullUrl(), 'celery_workers.nlp_pipeline.delete' );
		}
		return true;
	}

	public static function onArticleUndelete( Title $title, $created, $comment ) {
		global $wgContentNamespaces;
		if ( in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
			self::parseEvent( $title->getArticleId(), $title->getFullUrl(), 'celery_workers.nlp_pipeline.parse' );
		}
		return true;
	}

	private static function parseEvent( $articleId, $titleUrl, $task ) {
		global $wgCityId;

		$taskList = new AsyncBackendTaskList();

		$taskList->taskType( $task )
				 ->add( $articleId )
				 ->wikiId( $wgCityId )
				 ->wikiUrl( preg_replace( '/\/wiki\/.*$/', '', $titleUrl ) )
				 ->setPriority( NlpPipelineQueue::NAME )
				 ->queue();
	}

}
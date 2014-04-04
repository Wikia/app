<?php

/**
 * Hooks for events that should trigger Parsoid cache updates.
 */
class ParsoidHooks {

	public static function onArticleEditUpdates( $article, $editInfo, $changed ) {
		if ( $changed ) {
			self::updateTitle( $article->getTitle(), 'edit' );
		}
		return true;
	}

	public static function onArticleDeleteComplete( $article, User $user, $reason, $id ) {
		self::updateTitle( $article->getTitle(), 'delete' );
		return true;
	}

	public static function onArticleUndelete( Title $title, $created, $comment ) {
		self::updateTitle( $title, 'undelete' );
		return true;
	}

	public static function onArticleRevisionVisibilitySet( Title $title ) {
		self::updateTitle( $title, 'visibilitySet' );
		return true;
	}

	public static function onTitleMoveComplete( Title $title, Title $newtitle, User $user, $oldid, $newid ) {
		self::updateTitle( $title, 'delete' );
		self::updateTitle( $newtitle, 'edit' );
		return true;
	}

	public static function onFileUpload( File $file ) {
		self::updateTitle( $file->getTitle(), 'file' );
		return true;
	}

	private static function updateTitle( Title $title, $action ) {
		if ( $title->getNamespace() == NS_FILE ) {
			$job = new ParsoidCacheUpdateJob( $title, array(
				'type' => 'OnDependencyChange',
				'table' => 'imagelinks'
			) );
			// Not supported yet
			//$job->insert();
		} else {
			$job = new ParsoidCacheUpdateJob( $title, array( 'type' => 'OnEdit' ) );
			$job->insert();

			$job = new ParsoidCacheUpdateJob( $title, array(
				'type' => 'OnDependencyChange',
				'table' => 'templatelinks'
			) );
			// Not supported yet
			//$job->insert();
		}
	}

}

<?php

/**
 * Hooks for events that should trigger Parsoid cache updates.
 */
class ParsoidHooks {

	public static function onArticleEditUpdates( $article, $editInfo, $changed ) {
		if ( $changed ) {
			self::updateTitle( $article->getTitle() );
		}
		return true;
	}

	public static function onFileUpload( File $file ) {
		self::updateTitle( $file->getTitle() );
		return true;
	}

	private static function updateTitle( Title $title ) {
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

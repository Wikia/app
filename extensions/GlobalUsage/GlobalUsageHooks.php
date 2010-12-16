<?php
/**
 * GlobalUsage hooks for updating globalimagelinks table.
 * 
 * UI hooks in SpecialGlobalUsage.
 */

class GlobalUsageHooks {
	private static $gu = null;

	/**
	 * Hook to LinksUpdateComplete
	 * Deletes old links from usage table and insert new ones.
	 */
	public static function onLinksUpdateComplete( $linksUpdater ) {
		$title = $linksUpdater->getTitle();

		// Create a list of locally existing images
		$images = array_keys( $linksUpdater->getImages() );
		$localFiles = array_keys( RepoGroup::singleton()->getLocalRepo()->findFiles( $images ) );
		$missingFiles = array_diff( $images, $localFiles );

		global $wgUseDumbLinkUpdate;
		$gu = self::getGlobalUsage();
		if ( $wgUseDumbLinkUpdate ) {
			// Delete all entries to the page
			$gu->deleteLinksFromPage( $title->getArticleId( GAID_FOR_UPDATE ) );
			// Re-insert new usage for the page
			$gu->insertLinks( $title, $missingFiles );
		} else {
			$articleId = $title->getArticleId( GAID_FOR_UPDATE );
			$existing = $gu->getLinksFromPage( $articleId );
			
			// Calculate changes
			$added = array_diff( $missingFiles, $existing );
			$removed  = array_diff( $existing, $missingFiles );
			
			// Add new usages and delete removed
			$gu->insertLinks( $title, $added );
			if ( $removed )
				$gu->deleteLinksFromPage( $articleId, $removed );
		}

		return true;
	}
	/**
	 * Hook to TitleMoveComplete
	 * Sets the page title in usage table to the new name.
	 */
	public static function onTitleMoveComplete( $ot, $nt, $user, $pageid, $redirid ) {
		$gu = self::getGlobalUsage();
		$gu->moveTo( $pageid, $nt );
		return true;
	}
	/**
	 * Hook to ArticleDeleteComplete
	 * Deletes entries from usage table.
	 */
	public static function onArticleDeleteComplete( $article, $user, $reason, $id ) {
		$title = $article->getTitle();
		$gu = self::getGlobalUsage();
		$gu->deleteLinksFromPage( $id );

		return true;
	}
	/**
	 * Hook to FileDeleteComplete
	 * Copies the local link table to the global.
	 */
	public static function onFileDeleteComplete( $file, $oldimage, $article, $wgUser, $reason ) {
		if ( !$oldimage ) {
			$gu = self::getGlobalUsage();
			$gu->copyLocalImagelinks( $file->getTitle() );
		}
		return true;
	}

	/**
	 * Hook to FileUndeleteComplete
	 * Deletes the file from the global link table.
	 */
	public static function onFileUndeleteComplete( $title, $versions, $user, $reason ) {
		$gu = self::getGlobalUsage();
		$gu->deleteLinksToFile( $title );
		return true;
	}
	/**
	 * Hook to UploadComplete
	 * Deletes the file from the global link table.
	 */
	public static function onUploadComplete( $upload ) {
		$gu = self::getGlobalUsage();
		$gu->deleteLinksToFile( $upload->getTitle() );
		return true;
	}

	/**
	 * Initializes a GlobalUsage object for the current wiki.
	 */
	private static function getGlobalUsage() {
		global $wgGlobalUsageDatabase;
		if ( is_null( self::$gu ) ) {
			self::$gu = new GlobalUsage( wfWikiId(),
					wfGetDB( DB_MASTER, array(), $wgGlobalUsageDatabase )
			);
		}

		return self::$gu;
	}
	
	/** 
	 * Hook to make sure globalimagelinks table gets duplicated for parsertests
	 */
	public static function onParserTestTables ( &$tables ) {
		$tables[] = 'globalimagelinks';
		return true;
	}

}
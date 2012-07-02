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
		
		//$localFiles = array_keys( RepoGroup::singleton()->getLocalRepo()->findFiles( $images ) );
		// Unrolling findFiles() here because pages with thousands of images trigger an OOM
		// error while building an array with thousands of File objects (bug 32598)
		$localFiles = array();
		$repo = RepoGroup::singleton()->getLocalRepo();
		foreach ( $images as $image ) {
			$file = $repo->findFile( $image );
			if ( $file ) {
				$localFiles[] = $file->getTitle()->getDBkey();
			}
		}
		
		$missingFiles = array_diff( $images, $localFiles );

		global $wgUseDumbLinkUpdate;
		$gu = self::getGlobalUsage();
		if ( $wgUseDumbLinkUpdate ) {
			// Delete all entries to the page
			$gu->deleteLinksFromPage( $title->getArticleId( Title::GAID_FOR_UPDATE ) );
			// Re-insert new usage for the page
			$gu->insertLinks( $title, $missingFiles );
		} else {
			$articleId = $title->getArticleId( Title::GAID_FOR_UPDATE );
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
		$gu = self::getGlobalUsage();
		$gu->deleteLinksFromPage( $id );

		return true;
	}

	/**
	 * Hook to FileDeleteComplete
	 * Copies the local link table to the global.
	 */
	public static function onFileDeleteComplete( $file, $oldimage, $article, $user, $reason ) {
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
	 *
	 * @return GlobalUsage
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

	/**
	 * Hook to apply schema changes
	 *
	 * @param $updater DatabaseUpdater
	 */
	public static function onLoadExtensionSchemaUpdates( $updater = null ) {
		$dir = dirname( __FILE__ );
		if ( $updater === null ) {
			global $wgExtNewTables, $wgExtNewIndexes, $wgDBtype;
			if ( $wgDBtype == 'mysql' || $wgDBtype == 'sqlite' ) {
				$wgExtNewTables[] = array( 'globalimagelinks', "$dir/GlobalUsage.sql" );
				$wgExtNewIndexes[] = array( 'globalimagelinks', 'globalimagelinks_wiki_nsid_title', "$dir/patches/patch-globalimagelinks_wiki_nsid_title.sql" );
			} elseif ( $wgDBtype == 'postgresql' ) {
				$wgExtNewTables[] = array( 'globalimagelinks', "$dir/GlobalUsage.pg.sql" );
				$wgExtNewIndexes[] = array( 'globalimagelinks', 'globalimagelinks_wiki_nsid_title', "$dir/patches/patch-globalimagelinks_wiki_nsid_title.pg.sql" );
			}
		} else {
			if ( $updater->getDB()->getType() == 'mysql' || $updater->getDB()->getType() == 'sqlite' ) {
				$updater->addExtensionUpdate( array( 'addTable', 'globalimagelinks',
					"$dir/GlobalUsage.sql", true ) );
				$updater->addExtensionUpdate( array( 'addIndex', 'globalimagelinks',
					'globalimagelinks_wiki_nsid_title', "$dir/patches/patch-globalimagelinks_wiki_nsid_title.sql", true ) );
			} elseif ( $updater->getDB()->getType() == 'postgresql' ) {
				$updater->addExtensionUpdate( array( 'addTable', 'globalimagelinks',
					"$dir/GlobalUsage.pg.sql", true ) );
				$updater->addExtensionUpdate( array( 'addIndex', 'globalimagelinks',
					'globalimagelinks_wiki_nsid_title', "$dir/patches/patch-globalimagelinks_wiki_nsid_title.pg.sql", true ) );
			}
		}
		return true;
	}
}

<?php

/**
 * Basic cache invalidation for Parsoid
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "Parsoid extension\n";
	exit( 1 );
}

class ParsoidSetup {

	public static function setup() {
		global $wgAutoloadClasses, $wgJobClasses, $wgParsoidCacheServers;
		$dir = __DIR__;

		$wgAutoloadClasses['ParsoidHooks'] = "$dir/Parsoid.hooks.php";
		$wgAutoloadClasses['ParsoidCacheUpdateJob'] = "$dir/ParsoidCacheUpdateJob.php";
		$wgAutoloadClasses['CurlMultiClient'] = "$dir/CurlMultiClient.php";

		$wgJobClasses['ParsoidCacheUpdateJob'] = 'ParsoidCacheUpdateJob';

		self::registerHooks();

		$wgParsoidCacheServers = array( 'http://parsoid-cache' );
	}

	protected static function registerHooks() {
		global $wgHooks;

		# Article edit/create
		$wgHooks['ArticleEditUpdates'][] = 'ParsoidHooks::onArticleEditUpdates';
		# Article delete/restore
		$wgHooks['ArticleDeleteComplete'][] = 'ParsoidHooks::onArticleDeleteComplete';
		$wgHooks['ArticleUndelete'][] = 'ParsoidHooks::onArticleUndelete';
		# Revision delete/restore
		$wgHooks['ArticleRevisionVisibilitySet'][] = 'ParsoidHooks::onArticleRevisionVisibilitySet';
		# Article move
		$wgHooks['TitleMoveComplete'][] = 'ParsoidHooks::onTitleMoveComplete';
		# File upload
		$wgHooks['FileUpload'][] = 'ParsoidHooks::onFileUpload';
	}

}

ParsoidSetup::setup();

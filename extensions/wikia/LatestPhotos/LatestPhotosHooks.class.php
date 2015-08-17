<?php

class LatestPhotosHooks {

	public static function onImageUpload( $image, $reupload, $hasDescription ) {
		self::avoidUpdateRace();
		self::invalidateCacheWikiTotalImages( $image, $reupload );
		return true;
	}

	public static function onImageUploadComplete( &$image ){
		self::avoidUpdateRace();
		return true;
	}

	public static function onImageRenameCompleated( &$this , &$ot , &$nt ){
		global $wgMemc;
		if ( $nt->getNamespace() == NS_FILE ) {
			wfDebug(__METHOD__ . ": photo renamed\n");
			$wgMemc->delete( LatestPhotosController::memcacheKey() );
		}
		return true;
	}

	public static function onImageDelete(&$file, $oldimage, $article, $user, $reason) {
		global $wgMemc;
		$wgMemc->delete(LatestPhotosController::memcacheKey());
		self::invalidateCacheWikiTotalImages( $file, false );
		return true;
	}


	public static function onMessageCacheReplace($title, $text) {
		global $wgMemc;
		if ($title == LatestPhotosHelper::BLACKLIST_MESSAGE) {
			wfDebug(__METHOD__ . ": photos blacklist has been updated\n");
			$wgMemc->delete(LatestPhotosController::memcacheKey());
		}
		return true;
	}

	private static function avoidUpdateRace(){
		global $wgMemc;
		// avoid a race in update event propgation by deleting key after 10 seconds
		// Memcache delete with a timeout is not implemented, but we can use set to fake it
		$thumbUrls = $wgMemc->get(LatestPhotosController::memcacheKey());
		if (!empty($thumbUrls)) {
			$wgMemc->set(LatestPhotosController::memcacheKey(), $thumbUrls, 10);
		}
	}

	protected static function invalidateCacheWikiTotalImages( $file, $reupload ) {
		$title = $file->getTitle();
		if ( $title instanceof Title && !WikiaFileHelper::isVideoFile($file) && !$reupload ) {
			$wikiService = (new WikiService);
			$wikiService->invalidateCacheTotalImages();
		}
	}
}

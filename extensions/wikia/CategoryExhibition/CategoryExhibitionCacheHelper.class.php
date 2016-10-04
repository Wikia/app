<?php

/**
 * Class CategoryExhibitionCacheHelper
 *
 * We use this class to easily invalidate all category objects in cached related to a particular
 * page. The way to go is to call getTouched( $title ) and incorporate the resulting number to
 * the key used for getting the actual value from cache.
 *
 * On modification call setTouched on the same Title to cause the cache to be invalidated.
 */
class CategoryExhibitionCacheHelper {
	public function getTouched( $title ) {
		global $wgMemc;
		return $wgMemc->get( $this->getTouchedKey( $title ), 0 );
	}

	public function setTouched( $title ) {
		global $wgMemc;
		$wgMemc->set( $this->getTouchedKey( $title ), time() . rand( 0, 9999 ), 60 * 60 * 24 );
	}

	private function getTouchedKey( Title $title ) {
		$key = wfMemcKey( 'category_touched', md5( $title->getDBKey() ), CategoryExhibitionSection::CACHE_VERSION );
		return $key;
	}
}

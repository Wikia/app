<?php
class PlacesHookHandler {
	
	public static function onOutputPageMakeCategoryLinks( $outputPage, $categories, $categoryLinks ) {
		RelatedVideos::getInstance()->setCategories( $categories );
		return true;
	}
}

<?php

/**
 * ArticleComments
 *
 * A ArticleComments extension for MediaWiki
 * Adding comment functionality on article pages
 *
 * @author Jakub Kurcek  <jakub@wikia.inc>
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 */

class CategoryExhibitionAjax {

	static public function axGetArticlesPage() {
		return self::getSection( 'CategoryExhibitionSectionPages' );
	}

	static public function axGetMediaPage() {
		return self::getSection( 'CategoryExhibitionSectionMedia' );
	}

	static public function axGetSubcategoriesPage() {
		return self::getSection( 'CategoryExhibitionSectionSubcategories' );
	}

	static public function axGetBlogsPage() {
		return self::getSection( 'CategoryExhibitionSectionBlogs' );
	}

	/**
	 * Returns section html.
	 *
	 * @param $class string
	 * @return string
	 */

	static private function getSection( $class ){
		global $wgRequest, $wgUser, $wgTitle;
		
		$pageId = (int)$wgRequest->getVal('articleId');
		$iPaginatorPosition = (int)$wgRequest->getVal('page');
		$oCategoryTitle = Title::newFromID( $pageId );
		$oSection = new $class( $oCategoryTitle );
		$sUrl = $oCategoryTitle->getFullURL();
		$result = $oSection->getSectionAxHTML( $iPaginatorPosition, $sUrl );
		
		return $result;
	}

	/*
	 * Get HTML of video player for given video file
	 * Used for on-click video play
	 */

	public static function axGetVideoPlayer() {
		wfProfileIn(__METHOD__);
		global $wgTitle;

		$video = new VideoPage($wgTitle);
		$video->load();

		// get default video dimensions
		$dimensions = explode('x', $video->getTextRatio());
		$width = intval($dimensions[0]);
		$height = intval($dimensions[1]);

		$return = array(
			'width' => $width,
			'height' => $height,
			'html' => $video->getEmbedCode($width, true),
			'title' => $wgTitle->getText(),
		);

		wfProfileOut(__METHOD__);
		return $return;
	}
}
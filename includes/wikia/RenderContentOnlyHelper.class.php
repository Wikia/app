<?php

/**
 * Class RenderContentOnlyHelper
 *
 * Provides a way to store information that is then used by the skin
 * to determine which skin elements should be rendered apart from
 * content
 */
class RenderContentOnlyHelper {
	const LEAVE_ALL_SKIN_ELEMENTS = 0;
	const LEAVE_NO_SKIN_ELEMENTS = 1;
	const LEAVE_ARTICLE_PLACEHOLDER_ONLY = 2;
	const LEAVE_NAV_ONLY = 4;

	private static $renderContentOnly = false;
	private static $renderContentOnlyLevel = self::LEAVE_ALL_SKIN_ELEMENTS;

	/**
	 * Method accessed by hook to set correct behaviour
	 */
	public static function onUnknownAction( $action, $article ) {
		if ( $action == 'rendercontentonly' ) {
			self::$renderContentOnly = true;
			self::$renderContentOnlyLevel = self::LEAVE_ARTICLE_PLACEHOLDER_ONLY;
			global $wgArticle;
			$wgArticle->view();
			return false;
		}
		return true;
	}

	/**
	 * @return bool
	 */
	public static function isRenderContentOnlyEnabled() {
		return self::$renderContentOnly;
	}

	/**
	 * Set boolean value for $renderContentOnly
	 * @param $value bool
	 */
	public static function setRenderContentVar( $value ) {
		self::$renderContentOnly = (bool)$value;
	}

	/**
	 * Set interge value for $renderContentOnlyLevel
	 * @param $value bool
	 */
	public static function setRenderContentLevel( $value ) {
		self::$renderContentOnlyLevel = (int)$value;
	}


	/**
	 * Returns level of stripping base skin elements
	 * @return integer
	 */
	public static function getRenderContentOnlyLevel() {
		return self::$renderContentOnlyLevel;
	}
}

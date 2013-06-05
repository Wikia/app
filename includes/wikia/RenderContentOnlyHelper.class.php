<?php

class RenderContentOnlyHelper {
	private static $renderContentOnly;

	/**
	 * This method is called when unknown action is called
	 */
	public static function onUnknownAction ($action, $article) {
		if ($action == 'rendercontentonly') {
			self::$renderContentOnly = true;
			global $wgArticle;
			$wgArticle->view();
			return false;
		}
		return true;
	}

	public static function isRenderContentOnlyEnabled () {
		return self::$renderContentOnly;
	}

	/**
	 * Set boolean value for $renderContentOnly
	 * @param $value bool
	 */
	public static function setRenderContentVar ($value) {
		self::$renderContentOnly = (bool)$value;
	}
}

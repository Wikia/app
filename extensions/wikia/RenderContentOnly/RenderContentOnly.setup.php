<?php

/**
 * renderContentOnly
 * extension enabling rendering of article content only inside of skin
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$wgHooks['UnknownAction'][] = 'renderContentOnly::onUnknownAction';

class renderContentOnly{
	private static $renderContentOnly;

	/**
	 * This method is called when unknown action is called
	 */
	public static function onUnknownAction($action, $article) {
		if ($action == 'rendercontentonly') {
			self::$renderContentOnly = true;
			global $wgArticle;
			$wgArticle->view();
			return false;
		}
		return true;
	}

	public static function isRenderContentOnlyEnabled() {
		return self::$renderContentOnly;
	}

}
<?php

/**
 * renderContentModuleOnly
 * extension which forces skin to render only article module without additional
 * skin modules, but with whole CSS/JS native to skin
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$wgHooks['UnknownAction'][] = 'renderContentModuleOnly::onUnknownAction';

class renderContentModuleOnly {
	private static $renderContentModuleOnly;

	/**
	 * This method is called when unknown action is called
	 */
	public static function onUnknownAction($action, $article) {
		if ($action == 'rendercontentmoduleonly') {
			self::$renderContentModuleOnly = true;
			F::app()->wg->Article->view();
			return false;
		}
		return true;
	}

	public static function isRenderContentModuleOnlyEnabled() {
		return self::$renderContentModuleOnly;
	}

}
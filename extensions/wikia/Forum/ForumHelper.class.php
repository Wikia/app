<?
class ForumHelper {
	public static $forumNamespaces = [NS_WIKIA_FORUM_BOARD, NS_WIKIA_FORUM_TOPIC_BOARD, NS_WIKIA_FORUM_BOARD_THREAD];

	public static function isForum() {
		global $wgTitle;
		if ($wgTitle instanceof Title) {
			if ($wgTitle->isSpecial('Forum') || in_array($wgTitle->getNamespace(), self::$forumNamespaces)) {
				return true;
			} else if ($wgTitle->getNamespace() === NS_USER_WALL_MESSAGE) {
				$mainTitle = Title::newFromId($wgTitle->getText());
				/*
				 * if we visit the thread using Thread:xxxxx url, $wgTitle's namespace is 1201 for both, wall and forum
				 * threads. But when we create new title from it using newFromId, we're able to distinguish those two
				 */
				if ($mainTitle instanceof Title) {
					return in_array($mainTitle->getNamespace(), self::$forumNamespaces);
				}
			}
		}
		return false;
	}
}

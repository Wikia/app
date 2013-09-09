<?
class ForumHelper {
	public static $forumNamespaces = [NS_WIKIA_FORUM_BOARD, NS_WIKIA_FORUM_TOPIC_BOARD, NS_WIKIA_FORUM_BOARD_THREAD];

	public static function isForum() {
		global $wgTitle;
		if ($wgTitle instanceof Title) {
			if ($wgTitle->isSpecial('Forum') || in_array($wgTitle->getNamespace(), self::$forumNamespaces)) {
				return true;
			} else if ($wgTitle->getNamespace() == NS_USER_WALL_MESSAGE) {
				$mainTitle = Title::newFromId($wgTitle->getText());
				return in_array($mainTitle->getNamespace(), self::$forumNamespaces);
			}
		}
		return false;
	}
}
<?php

class FooterMenuItemFactory {
	protected static $supportedItems = array();

	/**
	 * @param $itemType
	 * @return FooterMenuItem
	 */
	static function buildItem($itemType) {
		if (!empty(self::$supportedItems[$itemType])) {
			return new self::$supportedItems[$itemType];
		}
	}

	static function addSupportedItem($itemType, $itemClass) {
		self::$supportedItems[$itemType] = $itemClass;
	}
}
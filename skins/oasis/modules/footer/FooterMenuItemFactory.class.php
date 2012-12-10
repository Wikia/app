<?php

class FooterMenuItemFactory {

	protected static $supportedItems = array(
		'share' => 'FooterShareItemService',
		'follow' => 'FooterFollowItemService',
		'menu' => 'FooterMenuItemService',
		'link' => 'FooterLinkItemService',
		'html' => 'FooterHtmlItemService',
		'customize' => 'FooterCustomizeItemService',
		'devinfo' => 'FooterDevinfoItemService',
		'disabled' => 'FooterDisabledItemService'
	);

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
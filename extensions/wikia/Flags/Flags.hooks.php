<?php
namespace Flags;

class FlagsHooks {

	const FLAGS_DROPDOWN_ACTION = 'flags';

	public static function onBeforePageDisplay( \OutputPage &$out, \Skin &$skin ) {
		$out->addScriptFile('/extensions/wikia/Flags/scripts/FlagsModal.js');
		return true;
	}

	/**
	 * Adds flags item to edit button dropdown. Flags item shows modal for editing flags for article.
	 * This is attached to the MediaWiki 'SkinTemplateNavigation' hook.
	 *
	 * @param SkinTemplate $skin
	 * @param array $links Navigation links
	 * @return bool true
	 */
	public static function onSkinTemplateNavigation( &$skin, &$links ) {
		$links['views'][self::FLAGS_DROPDOWN_ACTION] = [
			'href' => '#',
			'text' => 'Flags',
			'class' => 'flags-access-class',
		];
		return true;
	}

	/**
	 * Adds flags action to dropdown actions to enable displaying flags item on edit dropdown
	 * @param array $actions
	 * @return bool true
	 */
	public static function onDropdownActions( array &$actions ) {
		$actions[] = self::FLAGS_DROPDOWN_ACTION;
		return true;
	}
}

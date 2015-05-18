<?php
namespace Flags;

class FlagsHooks {
	/**
	 * Adds flags item to edit button dropdown. Flags item shows modal for editing flags for article.
	 * This is attached to the MediaWiki 'SkinTemplateNavigation' hook.
	 *
	 * @param SkinTemplate $skin
	 * @param array $links Navigation links
	 * @return bool true
	 */
	public static function onSkinTemplateNavigation( &$skin, &$links ) {
		$links['views']['flags'] = [
			'href' => '#',
			'text' => 'Flags',
			'class' => 'flags-access-class',
		];
		return true;
	}
}

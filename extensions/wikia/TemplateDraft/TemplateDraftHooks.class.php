<?php

class TemplateDraftHooks {

	/*
	 * property used in page_props table, construction:
	 * * tc- - prefix for "template classifiaction"
	 * * -marked- - signifies classification decision made by human
	 * * -auto- - signifies classification decision made by AI
	 * * -infobox - suffix denoting the type of template we identified
	 *
	 * @TODO move this someplace sensible, once available
	 */
	const TEMPLATE_INFOBOX_PROP = 'tc-marked-infobox';

	public static function onGetRailModuleList( Array &$railModuleList ) {
		global $wgTitle;

		if ( $wgTitle->getNamespace() === NS_TEMPLATE
		&& Wikia::getProps( $wgTitle->getId(), self::TEMPLATE_INFOBOX_PROP ) !== 0 ) {
			$railModuleList[1502] = [ 'TemplateDraftModule', Index, null ];
		}

		return true;
	}
}

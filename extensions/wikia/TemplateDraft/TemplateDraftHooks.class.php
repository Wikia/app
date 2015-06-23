<?php

class TemplateDraftHooks {

	public static function onGetRailModuleList( Array &$railModuleList ) {
		global $wgTitle;

		// TODO: Check page props here
		if ( $wgTitle->getNamespace() === NS_TEMPLATE ) {
			$railModuleList[1502] = [ 'TemplateDraftModule', Index, null ];
		}

		return true;
	}
}

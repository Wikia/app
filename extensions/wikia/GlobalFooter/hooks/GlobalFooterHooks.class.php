<?php

class GlobalFooterHooks {

	public static function onSkinCopyrightFooter( $title, $type, &$msg, &$link, &$forContent ) {
		$forContent = false;
		return true;
	}
}

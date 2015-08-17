<?php

class GlobalFooterHooks {

	static public function onSkinCopyrightFooter( $title, $type, &$msg, &$link, &$forContent ) {
		$forContent = false;
		return true;
	}
}

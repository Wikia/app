<?php

class TOCHooksHelper {

	public static function onDisableMWTOC( &$parser, &$enoughToc ) {

		$parser->mShowToc = false;
		$enoughToc = false;

		return true;
	}

	public static function onOverwriteTOC( &$title, &$toc ) {

		$toc = '<div>TEST!!!!!!!</div>';

		return true;
	}

}
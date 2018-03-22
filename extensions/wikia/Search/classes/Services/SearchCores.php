<?php

namespace Wikia\Search\Services;

class SearchCores {
	// core names
	const CORE_XWIKI = 'xwiki';
	const CORE_MAIN = 'main';

	// list all common field ids that can be shared across cores
	const F_WIKI_ID = 'wikiId';
	const F_WIKI_HOST = 'wikiHost';

	public static function getCoreFieldNames( $core ) {
		$core_opt = [];
		switch ( $core ) {
			case static::CORE_XWIKI:
				$core_opt[self::F_WIKI_ID] = 'id';
				$core_opt[self::F_WIKI_HOST] = 'hostname_s';
				break;
			case static::CORE_MAIN:
				$core_opt[self::F_WIKI_ID] = 'wid';
				$core_opt[self::F_WIKI_HOST] = 'host';
		}

		return $core_opt;
	}
}

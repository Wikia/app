<?php

namespace Wikia\SpecialDiscussionsLog\Search;


interface SearchQuery {
	function getKey();
	static function getKeyName();
	static function getQuery( $key, $paginationSize );
}

<?php

namespace Wikia\SpecialDiscussionsLog\Search;


interface SearchQuery {
	static function getKeyName();
	static function getQuery( $key, $paginationSize );
}

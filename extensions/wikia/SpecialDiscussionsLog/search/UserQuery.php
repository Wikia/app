<?php

namespace Wikia\SpecialDiscussionsLog\Search;


class UserQuery implements SearchQuery {

	private $searchKey;

	public function __construct( $searchKey ) {
		$this->searchKey = $searchKey;
	}

	function getKey() {
		return $this->searchKey;
	}

	static function getKeyName() {
		return 'username';
	}

	static function getQuery( $userId, $paginationSize ) {
		return <<<JSON_BODY
{
	"query": {
		"filtered": {
			"query": {
				"bool": {
					"should": [{
						"query_string": {
							"query":"mobile_app.event.user_id:$userId"
						}
					}]
				}
			}
		}
	},
	"size":$paginationSize,
	"sort":[{
		"@timestamp": {
			"order": "desc"
		}
	}]
}
JSON_BODY;
	}

}

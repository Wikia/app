<?php

namespace Wikia\SpecialDiscussionsLog\Search;


class UserQuery implements SearchQuery {

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
							"query":"rawTags:dis_service_contribution AND user_id:$userId"
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

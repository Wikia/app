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
							"query":"mobile_app.event.user_id:$userId OR rawTags:dis_service_contribution"
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

#							"query":"mobile_app.event.user_id:$userId OR (logger_name:com.wikia.discussionservice.* AND wikia_user_id:$userId)"
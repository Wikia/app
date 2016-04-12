<?php

namespace Wikia\SpecialDiscussionsLog\Search;


class IpAddressQuery implements SearchQuery {

	static function getKeyName() {
		return 'ipAddress';
	}

	static function getQuery( $ipAddress, $paginationSize ) {
		return <<<JSON_BODY
{
	"query": {
		"filtered": {
			"query": {
				"bool": {
					"should": [{
						"query_string": {
							"query":"mobile_app.client_ip:$ipAddress"
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

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
							"query":"mobile_app.client_ip:$ipAddress OR rawTags:dis_service_contribution"
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

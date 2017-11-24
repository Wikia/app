<?php

class DWDimensionApiController extends WikiaApiController {
	const LIMIT = 100;
	const LIMIT_MAX = 20000;

	const WIKI_DOMAINS_AFTER_DOMAIN = null;

	const WIKIS_AFTER_WIKI_ID = -1;

	private function getSharedDbSlave() {
		global $wgExternalSharedDB;
		return wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
	}

	public function getWikiDomains() {
		$db = $this->getSharedDbSlave();

		$limit = min($db->strencode( $this->getRequest()->getVal( 'limit', static::LIMIT ) ), static::LIMIT_MAX);
		$afterDomain = $db->strencode( $this->getRequest()->getVal( 'after_domain', static::WIKI_DOMAINS_AFTER_DOMAIN ) );

		$dbResult = $db->select(
			[ 'city_domains' ],
			[ 'city_id', 'city_domain' ],
			isset( $afterDomain ) ? [ 'city_domain > "'.$afterDomain.'"' ] : [ ],
			__METHOD__,
			[
				'ORDER BY' => 'city_domain',
				'LIMIT' => $limit
			]
		);
		$result = [];
		while ($row = $db->fetchObject($dbResult)) {
			$result[] = [
				'city_id' => $row->city_id,
				'city_domain' => $row->city_domain
			];
		}

		$this->setResponseData(
			$result,
			null,
			WikiaResponse::CACHE_DISABLED
		);
	}

	public function getWikis() {
		$db = $this->getSharedDbSlave();

		$limit = min($db->strencode( $this->getRequest()->getVal( 'limit', static::LIMIT ) ), static::LIMIT_MAX);
		$afterWikiId = $db->strencode( $this->getRequest()->getVal( 'after_wiki_id', static::WIKIS_AFTER_WIKI_ID ) );

		$query = str_replace( '$city_id', $afterWikiId, DWDimensionApiControllerSQL::DIMENSION_WIKIS_QUERY);
		$query = str_replace( '$limit', $limit, $query);

		$dbResult = $db->query($query,__METHOD__);
		$result = [];
		while ($row = $db->fetchObject($dbResult)) {
			$result[] = [
				'wiki_id' => $row->wiki_id,
				'dbname' => $row->dbname,
				'sitename' => $row->sitename,
				'url' => $row->url,
				'domain' => $row->domain,
				'title' => $row->title,
				'founding_user_id' => $row->founding_user_id,
				'public' => $row->public,
				'lang' => $row->lang,
				'lang_id' => $row->lang_id,
				'ad_tag' => $row->ad_tag,
				'category_id' => $row->category_id,
				'category_name' => $row->category_name,
				'hub_id' => $row->hub_id,
				'hub_name' => $row->hub_name,
				'vertical_id' => $row->vertical_id,
				'vertical_name' => $row->vertical_name,
				'cluster' => $row->cluster,
				'created_at' => $row->created_at,
				'deleted' => $row->deleted
			];
		}

		$this->setResponseData(
			$result,
			null,
			WikiaResponse::CACHE_DISABLED
		);
	}
}

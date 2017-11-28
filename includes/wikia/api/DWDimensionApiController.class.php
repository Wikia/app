<?php

class DWDimensionApiController extends WikiaApiController {
	const LIMIT = 100;
	const LIMIT_MAX = 20000;

	const WIKI_DOMAINS_AFTER_DOMAIN = null;

	const WIKIS_AFTER_WIKI_ID = -1;

	const DART_TAG_VARIABLE_ID = 938;

	private function getSharedDbSlave() {
		global $wgExternalSharedDB;
		return wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
	}

	public function getWikiDartTags() {
		$db = $this->getSharedDbSlave();

		$limit = min($db->strencode( $this->getRequest()->getVal( 'wiki_limit', static::LIMIT ) ), static::LIMIT_MAX);
		$afterWikiId = $db->strencode( $this->getRequest()->getVal( 'after_wiki_id', static::WIKIS_AFTER_WIKI_ID ) );

		$variables = WikiFactory::getVariableForAllWikis( static::DART_TAG_VARIABLE_ID, $limit, $afterWikiId );

		$result = [];
		foreach ($variables as $variable) {
			#extract from list like "s:199:\"sex=m;sex=f;age=under18;age=13-17;age=18-24;age=25-34;age=18-34;\";"
			preg_match_all("/([^;= ]+)=([^;= ]+)/", $variable[ 'value' ], $r);

			for ($i = 0; $i < count( $r[1] ); $i++) {
				$result[] = [
					'wiki_id' => $variable[ 'city_id' ],
					'tag' => $r[ 1 ][ $i ],
					'value' => $r[ 2 ][ $i ]
				];
			}
		}

		$this->setResponseData(
			$result,
			null,
			WikiaResponse::CACHE_DISABLED
		);
	}

	private function getVerticalName( $allVerticals, $verticalId ) {
		if ( isset( $allVerticals[ $verticalId ] ) ) {
			return $allVerticals[ $verticalId ][ 'name' ];
		}
		return null;
	}

	private function getCategoryName( $allCategories, $categoryId ) {
		if ( isset( $allCategories[ $categoryId ] ) ) {
			return $allCategories[ $categoryId ][ 'name' ];
		}
		return null;
	}

	public function getWikis() {
		$db = $this->getSharedDbSlave();

		$limit = min($db->strencode( $this->getRequest()->getVal( 'limit', static::LIMIT ) ), static::LIMIT_MAX);
		$afterWikiId = $db->strencode( $this->getRequest()->getVal( 'after_wiki_id', static::WIKIS_AFTER_WIKI_ID ) );

		$query = str_replace( '$city_id', $afterWikiId, DWDimensionApiControllerSQL::DIMENSION_WIKIS_QUERY);
		$query = str_replace( '$limit', $limit, $query);

		$allVerticals = WikiFactoryHub::getInstance()->getAllVerticals();
		$allCategories = WikiFactoryHub::getInstance()->getAllCategories();

		$dbResult = $db->query($query,__METHOD__);
		$result = [];
		while ($row = $db->fetchObject($dbResult)) {
			$result[] = [
				'wiki_id' => $row->wiki_id,
				'dbname' => $row->dbname,
				'sitename' => $row->sitename,
				'url' => parse_url($row->url, PHP_URL_HOST),
				'domain' => parse_url($row->url, PHP_URL_HOST),
				'title' => $row->title,
				'founding_user_id' => $row->founding_user_id,
				'public' => $row->public,
				'lang' => $row->lang,
				'lang_id' => $row->lang_id,
				'ad_tag' => $row->ad_tag,
				'category_id' => $row->category_id,
				'category_name' => $this->getCategoryName( $allCategories, $row->category_id ),
				'hub_id' => $row->category_id,
				'hub_name' => $this->getCategoryName( $allCategories, $row->category_id ),
				'vertical_id' => $row->vertical_id,
				'vertical_name' => $this->getVerticalName( $allVerticals, $row->vertical_id ),
				'cluster' => $row->cluster,
				'created_at' => $row->created_at,
				'deleted' => $row->deleted
			];
		}
		$db->freeResult( $dbResult );

		$this->setResponseData(
			$result,
			null,
			WikiaResponse::CACHE_DISABLED
		);
	}
}

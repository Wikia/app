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

	public function getWikiDartTags() {
		$db = $this->getSharedDbSlave();

		$limit = min($db->strencode( $this->getRequest()->getVal( 'limit', static::LIMIT ) ), static::LIMIT_MAX);
		$afterWikiId = $db->strencode( $this->getRequest()->getVal( 'after_wiki_id', static::WIKIS_AFTER_WIKI_ID ) );

		$where = [ 'cv_variable_id = '.static::DART_TAG_VARIABLE_ID ];
		if ( isset( $afterWikiId ) ) {
			array_push( $where, 'cv_city_id > "'.$afterWikiId.'"' );
		}
		$dbResult = $db->select(
			[ 'city_variables' ],
			[ 'cv_city_id', 'cv_value' ],
			$where,
			__METHOD__,
			[
				'ORDER BY' => 'cv_city_id',
				'LIMIT' => $limit
			]
		);

		$result = [];
		while ($row = $db->fetchObject($dbResult)) {
			$result[] = [
				'wiki_id' => $row->cv_city_id,
				'tag' => null,
				'value' => $row->cv_value
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

		$this->setResponseData(
			$result,
			null,
			WikiaResponse::CACHE_DISABLED
		);
	}
}

<?php

use Wikia\Service\User\Permissions\PermissionsServiceAccessor;
use FandomCreator\CommunitySetup;

class DWDimensionApiController extends WikiaApiController {
	use PermissionsServiceAccessor;

	const LIMIT = 100;
	const LIMIT_MAX = 20000;

	const WIKI_DOMAINS_AFTER_DOMAIN = null;

	const DEFAULT_AFTER_ID = -1;

	const DEFAULT_AFTER_IMAGE_NAME = '';

	const ARTICLE_LAST_EDITED = '1970-01-01';

	const DART_TAG_VARIABLE_NAME = 'wgDartCustomKeyValues';

	const BOT_USER_GROUP = 'bot';

	const BOT_GLOBAL_USER_GROUP = 'bot-global';

	const TEST_WIKI_VARIABLE_NAME = 'wgIsTestWiki';

	private $connections = [];

	private function getDbSlave( $dbname ) {
		return wfGetDB( DB_SLAVE, array(), $dbname );
	}

	private function getSharedDbSlave() {
		global $wgExternalSharedDB;
		return $this->getDbSlave( $wgExternalSharedDB );
	}

	public function getWikiDartTags() {
		$db = $this->getSharedDbSlave();

		$limit = min($db->strencode( $this->getRequest()->getInt(
			'wiki_limit', static::LIMIT ) ), static::LIMIT_MAX);
		$afterWikiId = $db->strencode( $this->getRequest()->getInt(
			'after_wiki_id', static::DEFAULT_AFTER_ID ) );

		$variables = WikiFactory::getVariableForAllWikis( static::DART_TAG_VARIABLE_NAME, $limit,
			$afterWikiId );

		$result = [];
		foreach ( $variables as $variable ) {
			#extract from list like "s:199:\"sex=m;sex=f;age=under18;age=13-17;age=18-24;age=25-34;age=18-34;\";"
			preg_match_all("/([^;= ]+)=([^;= ]+)/", $variable[ 'value' ], $r );

			for ( $i = 0; $i < count( $r[1] ); $i++ ) {
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

	private function getTestWikisIDs() {
		$testWikiVarId = WikiFactory::getVarIdByName( self::TEST_WIKI_VARIABLE_NAME );
		return array_keys(
			WikiFactory::getListOfWikisWithVar( $testWikiVarId, 'bool', '=', true )
		);
	}

	protected function getFandomCreatorWikis( $limit, $afterWikiId ) {
		$communityMap = [];
		$fcCommunities = WikiFactory::getVariableForAllWikis( CommunitySetup::WF_VAR_FC_COMMUNITY_ID, $limit, $afterWikiId );
		return array_reduce( $fcCommunities,
			function( $acc, $pair ) {
				$acc[ $pair[ 'city_id' ] ] = $pair[ 'value' ];
				return $acc;
			} , [] );
	}

	protected function parseUrl( $rowUrl ) {
		$urlWithoutScheme = str_replace( ['http://', 'https://'], '', $rowUrl );
		return trim( $urlWithoutScheme, '/' );
	}

	public function getWikis() {
		$testWikis = $this->getTestWikisIDs();
		$db = $this->getSharedDbSlave();

		$limit = min( $db->strencode( $this->getRequest()->getVal(
			'limit', static::LIMIT ) ), static::LIMIT_MAX );
		$afterWikiId = $db->strencode( $this->getRequest()->getVal(
			'after_wiki_id', static::DEFAULT_AFTER_ID ) );

		$query = str_replace( '$city_id', $afterWikiId,
			DWDimensionApiControllerSQL::DIMENSION_WIKIS_QUERY );
		$query = str_replace( '$limit', $limit, $query );

		$fcCommunityIdMap = $this->getFandomCreatorWikis( $limit, $afterWikiId );

		$allVerticals = WikiFactoryHub::getInstance()->getAllVerticals();

		$dbResult = $db->query( $query,__METHOD__ );
		$result = [];
		while ( $row = $db->fetchObject( $dbResult ) ) {
			$result[] = [
				'wiki_id' => $row->wiki_id,
				'dbname' => $row->dbname,
				'sitename' => $row->sitename,
				'url' => $row->url,
				'domain' => $this->parseUrl( $row->url ),
				'title' => $row->title,
				'founding_user_id' => $row->founding_user_id,
				'public' => $row->public,
				'lang' => $row->lang,
				'lang_id' => $row->lang_id,
				'vertical_id' => $row->vertical_id,
				'vertical_name' => $this->getVerticalName( $allVerticals, $row->vertical_id ),
				'cluster' => $row->cluster,
				'created_at' => $row->created_at,
				'deleted' => $row->deleted,
				'is_test_wiki' => intval( in_array( $row->wiki_id, $testWikis ) ),
				'fc_community_id' => $fcCommunityIdMap[ $row->wiki_id ] ?? null,
			];
		}
		$db->freeResult( $dbResult );

		$this->setResponseData(
			$result,
			null,
			WikiaResponse::CACHE_DISABLED
		);
	}

	private function getDataWareDbSlave() {
		global $wgExternalDatawareDB;
		return wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
	}

	public function getAllArticles() {

		$db = $this->getDataWareDbSlave();

		$limit = min($db->strencode( $this->getRequest()->getInt( 'limit', static::LIMIT ) ),
			static::LIMIT_MAX);
		$afterWikiId = $db->strencode( $this->getRequest()->getInt( 'after_wiki_id',
			static::DEFAULT_AFTER_ID ) );
		$afterArticleId = $db->strencode( $this->getRequest()->getInt( 'after_article_id',
			static::DEFAULT_AFTER_ID ) );
		$last_edited = $db->strencode( $this->getRequest()->getVal( 'last_edited',
			static::ARTICLE_LAST_EDITED ) );

		$query = str_replace( '$wiki_id', $afterWikiId,
			DWDimensionApiControllerSQL::DIMENSION_ALL_ARTICLES );
		$query = str_replace( '$article_id', $afterArticleId, $query );
		$query = str_replace( '$last_edited', $last_edited, $query );
		$query = str_replace( '$limit', $limit, $query );

		$dbResult = $db->query( $query,__METHOD__ );
		$result = [];
		while ( $row = $db->fetchObject( $dbResult ) ) {
			$result[] = [
				'wiki_id' => $row->wiki_id,
				'namespace_id' => $row->namespace_id,
				'article_id' => $row->article_id,
				'title' => $row->title,
				'is_redirect' => $row->is_redirect,
				'created_at' => isset( $row->created_at ) ?
					( new DateTime( $row->created_at ) )->format( 'Y-m-d H:i:s' ) : null
			];
		}
		$db->freeResult( $dbResult );
		$this->setResponseData(
			$result,
			null,
			WikiaResponse::CACHE_DISABLED
		);
	}

	public function getUsers() {
		$db = $this->getSharedDbSlave();

		$limit = min( $db->strencode( $this->getRequest()->getVal(
			'limit', static::LIMIT ) ), static::LIMIT_MAX );
		$afterUserId = $db->strencode( $this->getRequest()->getVal(
			'after_user_id', static::DEFAULT_AFTER_ID ) );

		$query = str_replace( '$user_id', $afterUserId, DWDimensionApiControllerSQL::DIMENSION_USERS );
		$query = str_replace( '$limit', $limit, $query);

		$dbResult = $db->query( $query,__METHOD__);
		$result = [];
		$botUsers = $this->permissionsService()->getUsersInGroups( [ static::BOT_USER_GROUP ] );
		$botGlobalUsers = $this->permissionsService()->getUsersInGroups( [ static::BOT_GLOBAL_USER_GROUP ] );
		while ( $row = $db->fetchObject( $dbResult ) ) {
			$result[] = [
				'user_id' => $row->user_id,
				'user_name' => $row->user_name,
				'user_real_name' => $row->user_real_name,
				'user_email_authenticated' => $row->user_email_authenticated,
				'user_editcount' => $row->user_editcount,
				'user_registration' => $row->user_registration,
				'is_bot' => isset( $botUsers[ $row->user_id ] ),
				'is_bot_global' => isset( $botGlobalUsers[ $row->user_id ] )
			];
		}
		$db->freeResult( $dbResult );

		$this->setResponseData(
			$result,
			null,
			WikiaResponse::CACHE_DISABLED
		);
	}

	public function getWikiCategories() {
		$db = $this->getSharedDbSlave();

		$limit = min( $db->strencode( $this->getRequest()->getVal(
			'limit', static::LIMIT ) ), static::LIMIT_MAX );
		$afterId = $db->strencode( $this->getRequest()->getVal(
			'after_id', static::DEFAULT_AFTER_ID ) );

		$query = str_replace( '$after_id', $afterId, DWDimensionApiControllerSQL::DIMENSION_WIKI_CATEGORIES );
		$query = str_replace( '$limit', $limit, $query);

		$dbResult = $db->query( $query,__METHOD__);

		$result = [];
		foreach( $dbResult as $row ) {
			$result[] = [
				'id' => $row->id,
				'wiki_id' => $row->city_id,
				'category_id' => $row->cat_id
			];
		}

		$this->setResponseData(
			$result,
			null,
			WikiaResponse::CACHE_DISABLED
		);
	}

	public function getWikiImages() {

		$startingWikiId = $this->getSharedDbSlave()->strencode( $this->getRequest()->getVal( 'starting_wiki_id',
			static::DEFAULT_AFTER_ID ) );
		$afterImageName = $this->getSharedDbSlave()->strencode( $this->getRequest()->getVal(
			'after_image_name', static::DEFAULT_AFTER_IMAGE_NAME ) );
		$limit = min( $this->getSharedDbSlave()->strencode( $this->getRequest()->getVal(
			'limit', static::LIMIT ) ), static::LIMIT_MAX );

		$wikis = $this->getWikiDbNames( [ "city_id >= ".$startingWikiId ] );

		$result = [];
		foreach( $wikis as $wiki ) {
			$db = $this->getWikiConnection( $wiki[ 'cluster' ], $wiki[ 'dbname' ] );
			$sub_result = null;
			if ( isset( $db ) ) {
				$sub_result = $this->getWikiImagesData( $db, $afterImageName, $limit );
			}
			$result[] = [
				'wiki_id' => $wiki[ 'wiki_id' ],
				'data' => $sub_result
			];
			$afterImageName = '';
			if ( $limit > 0 ) {
				$limit = $limit - count( $sub_result );
				if ( $limit <= 0 ) {
					break;
				}
			}
		}
		foreach( $this->connections as $connection ) {
			$connection->close();
		}

		$this->setResponseData(
			$result,
			null,
			WikiaResponse::CACHE_DISABLED
		);
	}

	private function getWikiImagesData( DatabaseMysqli $db, $afterImageName, $limit ) {
		$result = [];
		try {
			$query = DWDimensionApiControllerSQL::DIMENSION_WIKI_IMAGES;
			$query = str_replace( '$limit', $limit, $query );
			$query = str_replace( '$img_name', $afterImageName, $query );
			$rows = $db->query( $query, __METHOD__ );
			if ( !empty( $rows ) ) {
				while ( $row = $db->fetchObject( $rows ) ) {
					$result[] = [
						'name' => $row->image_name,
						'user_id' => $row->user_id,
						'minor_mime' => $row->minor_mime,
						'media_type' => $row->media_type,
						'created_at' => $row->created_at
					];
				}
				$db->freeResult( $rows );
			}
		} catch ( DBQueryError $e ) {
			Wikia\Logger\WikiaLogger::instance()->error(
				"Exception caught while querying wiki images data", [
				'exception' => $e,
				'db' => $db->getDBname()
			] );
		}
		return $result;
	}

	public function getWikiInfo() {
		$this->getDataPerWiki( array( $this, 'getWikiInfoData' ) );
	}

	private function getWikiInfoData( DatabaseMysqli $db ) {
		$result = [];
		try {
			$rows = $db->query( DWDimensionApiControllerSQL::DIMENSION_WIKI_INFO, __METHOD__ );
			if ( !empty( $rows ) ) {
				while ( $row = $db->fetchObject( $rows ) ) {
					$result[] = [
						'total_edits' => $row->total_edits,
						'good_articles' => $row->good_articles,
						'total_pages' => $row->total_pages,
						'users' => $row->users,
						'active_users' => $row->active_users,
						'admins' => $row->admins,
						'images' => $row->images,
						'updated_at' => $row->updated_at
					];
				}
				$db->freeResult( $rows );
			}
		} catch ( DBQueryError $e ) {
			Wikia\Logger\WikiaLogger::instance()->error(
				"Exception caught while querying wiki info data", [
				'exception' => $e,
				'db' => $db->getDBname()
			] );
		}

		return $result;
	}

	public function getWikiUserGroups() {
		$this->getDataPerWiki( array( $this, 'getWikiUserGroupsData' ) );
	}

	private function getWikiUserGroupsData( DatabaseMysqli $db ) {
		$result = [];
		try {
			$rows = $db->query( DWDimensionApiControllerSQL::DIMENSION_WIKI_USER_GROUPS, __METHOD__ );
			if ( !empty( $rows ) ) {
				while ( $row = $db->fetchObject( $rows ) ) {
					$result[] = [
						'user_id' => $row->user_id,
						'user_group' => $row->user_group
					];
				}
				$db->freeResult( $rows );
			}
		} catch ( DBQueryError $e ) {
			Wikia\Logger\WikiaLogger::instance()->error(
				"Exception caught while querying wiki info data", [
				'exception' => $e,
				'db' => $db->getDBname()
			] );
		}

		return $result;
	}

	private function getWikiConnection( $cluster, $dbname ) {
		if ( !isset( $connections[ $cluster ] ) ) {
			$connections[ $cluster ] = $db = wfGetDB( DB_SLAVE, array(), 'wikicities_'.$cluster );
		}
		$connection = $connections[ $cluster ];
		$dbname = $db->strencode( $dbname );
		try {
			$connection->query( "USE `".$dbname."`", __METHOD__ );
		} catch ( DBQueryError $e ) {
			Wikia\Logger\WikiaLogger::instance()->error(
				"Exception caught while trying to switch to DB", [
				'exception' => $e,
				'db' => $dbname
			] );
			$connection = null;
		}

		return $connection;
	}

	private function getWikiDbNames( $where ) {
		$db = $this->getSharedDbSlave();

		$limit = min( $db->strencode( $this->getRequest()->getVal( 'wiki_limit', static::LIMIT ) ),
			static::LIMIT_MAX );

		$rows = $db->select(
			[ "city_list" ],
			[ "city_id", "city_cluster", "city_dbname" ],
			$where,
			__METHOD__,
			[
				'ORDER BY' => 'city_id',
				'LIMIT' => $limit
			]
		);

		$wikis = [];
		foreach( $rows as $row ) {
			$wikis[] = [
				'wiki_id' => $row->city_id,
				'cluster' => $row->city_cluster,
				'dbname' => $row->city_dbname ];
		}
		$db->freeResult( $rows );
		$db->close();

		return $wikis;
	}

	private function getDataPerWiki( callable $dataGatherer ) {

		$afterWikiId = $this->getSharedDbSlave()->strencode( $this->getRequest()->getVal( 'after_wiki_id',
			static::DEFAULT_AFTER_ID ) );

		$wikis = $this->getWikiDbNames( [ "city_id > ".$afterWikiId ] );

		$result = [];
		foreach( $wikis as $wiki ) {
			$db = $this->getWikiConnection( $wiki[ 'cluster' ], $wiki[ 'dbname' ] );
			$sub_result = null;
			if ( isset( $db ) ) {
				$sub_result = call_user_func( $dataGatherer, $db );
			}
			$result[] = [
				'wiki_id' => $wiki[ 'wiki_id' ],
				'data' => $sub_result
			];
		}
		foreach( $this->connections as $connection ) {
			$connection->close();
		}

		$this->setResponseData(
			$result,
			null,
			WikiaResponse::CACHE_DISABLED
		);
	}
}


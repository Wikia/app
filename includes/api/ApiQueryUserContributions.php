<?php
/**
 *
 *
 * Created on Oct 16, 2006
 *
 * Copyright © 2006 Yuri Astrakhan <Firstname><Lastname>@gmail.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

/**
 * This query action adds a list of a specified user's contributions to the output.
 *
 * @ingroup API
 */
class ApiQueryContributions extends ApiQueryBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'uc' );
	}

	private $params, $username, $userId, $userIp;
	private $fld_ids = false, $fld_title = false, $fld_timestamp = false,
			$fld_comment = false, $fld_parsedcomment = false, $fld_flags = false,
			$fld_patrolled = false, $fld_tags = false, $fld_size = false;

	public function execute() {
		// Parse some parameters
		$this->params = $this->extractRequestParams();

		$prop = array_flip( $this->params['prop'] );
		$this->fld_ids = isset( $prop['ids'] );
		$this->fld_title = isset( $prop['title'] );
		$this->fld_comment = isset( $prop['comment'] );
		$this->fld_parsedcomment = isset ( $prop['parsedcomment'] );
		$this->fld_size = isset( $prop['size'] );
		$this->fld_flags = isset( $prop['flags'] );
		$this->fld_timestamp = isset( $prop['timestamp'] );
		$this->fld_patrolled = isset( $prop['patrolled'] );
		$this->fld_tags = isset( $prop['tags'] );
		$this->fld_wikiamode = isset($prop['wikiamode']);

		// TODO: if the query is going only against the revision table, should this be done?
		$this->selectNamedDB( 'contributions', DB_SLAVE, 'contributions' );

		list( $userIds, $ips ) = $this->prepareUsername( $this->params['user'] );
		$this->prepareQuery( $userIds, $ips );

		// Do the actual query.
		$res = $this->select( __METHOD__ );

		// Initialise some variables
		$count = 0;
		$limit = $this->params['limit'];

		// Fetch each row
		foreach ( $res as $row ) {
			if ( ++ $count > $limit ) {
				$this->setContinueEnumParameter( 'start', wfTimestamp( TS_ISO_8601, $row->rev_timestamp ) );
				break;
			}

			$vals = $this->extractRowInfo( $row );
			$fit = $this->getResult()->addValue( [ 'query', $this->getModuleName() ], null, $vals );
			if ( !$fit ) {
				$this->setContinueEnumParameter( 'start', wfTimestamp( TS_ISO_8601, $row->rev_timestamp ) );
				break;
			}
		}

		$this->getResult()->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'item' );
	}

	/**
	 * Convert a list of user names and IP addresses to look up into a list of user IDs and IPs
	 * @param string[] $user
	 * @return array
	 */
	private function prepareUsername( $user ) {
		$ips = [];
		$userNames = [];

		foreach ( array_unique( $user ) as $entry ) {
			if ( IP::isIPAddress( $entry ) ) {
				$ips[] = $entry;
				continue;
			}

			if ( User::getCanonicalName( $entry ) ) {
				$userNames[] = $entry;
				continue;
			}

			$this->dieUsage( "User name $entry is not valid", 'param_user' );
		}

		$userIds = $this->resolveUserNames( $userNames );

		if ( empty( $userIds ) && empty( $ips ) ) {
			$this->dieUsage( "No valid user names provided", 'param_user' );
		}

		return [ $userIds, $ips ];
	}

	/**
	 * Resolve a set of user names to their corresponding user IDs
	 * @param string[] $userNames
	 * @return int[] user IDs
	 */
	private function resolveUserNames( array $userNames ): array {
		global $wgExternalSharedDB;

		if ( empty( $userNames ) ) {
			return [];
		}

		// Leverage cache if only one user name was provided (most common scenario)
		if ( count( $userNames ) === 1 ) {
			$userId = User::idFromName( $userNames[0] );
			return $userId ? [ $userId ] : [];
		}

		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		return $dbr->selectFieldValues(
			'`user`',
			'user_id',
			[ 'user_name' => array_unique( $userNames ) ],
			__METHOD__ );
	}

	/**
	 * Prepares the query and returns the limit of rows requested
	 * @param int[] $userIds
	 * @param string[] $ips
	 */
	private function prepareQuery( array $userIds, array $ips ) {
		// We're after the revision table, and the corresponding page
		// row for anything we retrieve. We may also need the
		// recentchanges row and/or tag summary row.
		$user = $this->getUser();
		$tables = array( 'page', 'revision' ); // Order may change
		$this->addWhere( 'page_id=rev_page' );

		if ( !$user->isAllowed( 'hideuser' ) ) {
			$this->addWhere( $this->getDB()->bitAnd( 'rev_deleted', Revision::DELETED_USER ) . ' = 0' );
		}

		// SUS-3140: different field needs to be queried for user IDs and anon IPs
		if ( !empty( $userIds ) && !empty( $ips ) ) {
			$userIdList = $this->getDB()->makeList( $userIds );
			$ipList = $this->getDB()->makeList( $ips );

			$this->addWhere( "(rev_user IN ($userIdList) OR (rev_user = 0 AND rev_user_text IN ($ipList)))" );
		} elseif ( empty( $userIds ) ) {
			$ipList = $this->getDB()->makeList( $ips );

			$this->addWhere( "rev_user = 0 AND rev_user_text IN ($ipList)" );
		} elseif ( empty( $ips ) ) {
			$userIdList = $this->getDB()->makeList( $userIds );

			$this->addWhere( "rev_user IN ($userIdList)" );
		}

		// ... and in the specified timeframe.
		$this->addTimestampWhereRange( 'rev_timestamp',
			$this->params['dir'], $this->params['start'], $this->params['end'] );
		$this->addWhereFld( 'page_namespace', $this->params['namespace'] );

		$show = $this->params['show'];
		if ( !is_null( $show ) ) {
			$show = array_flip( $show );
			if ( ( isset( $show['minor'] ) && isset( $show['!minor'] ) )
			   		|| ( isset( $show['patrolled'] ) && isset( $show['!patrolled'] ) ) ) {
				$this->dieUsageMsg( 'show' );
			}

			$this->addWhereIf( 'rev_minor_edit = 0', isset( $show['!minor'] ) );
			$this->addWhereIf( 'rev_minor_edit != 0', isset( $show['minor'] ) );
			$this->addWhereIf( 'rc_patrolled = 0', isset( $show['!patrolled'] ) );
			$this->addWhereIf( 'rc_patrolled != 0', isset( $show['patrolled'] ) );
		}
		$this->addOption( 'LIMIT', $this->params['limit'] + 1 );

		// Mandatory fields: timestamp allows request continuation
		// ns+title checks if the user has access rights for this page
		// user_text is necessary if multiple users were specified
		$this->addFields( array(
			'rev_timestamp',
			'page_namespace',
			'page_title',
			'rev_user',
			'rev_user_text',
			'rev_deleted'
		) );

		if ( isset( $show['patrolled'] ) || isset( $show['!patrolled'] ) ||
				 $this->fld_patrolled ) {
			if ( !$user->useRCPatrol() && !$user->useNPPatrol() ) {
				$this->dieUsage( 'You need the patrol right to request the patrolled flag', 'permissiondenied' );
			}

			// Use a redundant join condition on both
			// timestamp and ID so we can use the timestamp index
			if ( isset( $show['patrolled'] ) || isset( $show['!patrolled'] ) ) {
				// Put the tables in the right order for
				// STRAIGHT_JOIN
				$tables = array( 'revision', 'recentchanges', 'page' );
				$this->addOption( 'STRAIGHT_JOIN' );
				$this->addWhere( '((rc_user != 0 AND rc_user=rev_user) OR rc_ip_bin=INET6_ATON(rev_user_text))' );
				$this->addWhere( 'rc_timestamp=rev_timestamp' );
				$this->addWhere( 'rc_this_oldid=rev_id' );
			} else {
				$tables[] = 'recentchanges';
				$this->addJoinConds( array( 'recentchanges' => array(
					'LEFT JOIN', array(
						'(rc_user != 0 AND rc_user=rev_user) OR rc_ip_bin=INET6_ATON(rev_user_text)',
						'rc_timestamp=rev_timestamp',
						'rc_this_oldid=rev_id' ) ) ) );
			}
		}

		$this->addTables( $tables );
		$this->addFieldsIf( 'rev_page', $this->fld_ids );
		$this->addFieldsIf( 'rev_id', $this->fld_ids || $this->fld_flags );
		$this->addFieldsIf( 'page_latest', $this->fld_flags );
		// $this->addFieldsIf( 'rev_text_id', $this->fld_ids ); // Should this field be exposed?
		$this->addFieldsIf( 'rev_comment', $this->fld_comment || $this->fld_parsedcomment );
		$this->addFieldsIf( 'rev_len', $this->fld_size );
		$this->addFieldsIf( array( 'rev_minor_edit', 'rev_parent_id' ), $this->fld_flags );
		$this->addFieldsIf( 'rc_patrolled', $this->fld_patrolled );

		if ( $this->fld_tags ) {
			$tsTags = ChangeTags::buildTsTagsGroupConcatField( 'rev_id' );
			$this->addFields( $tsTags );
		}

		if ( isset( $this->params['tag'] ) ) {
			// SUS-3140: Optimize tag condition
			// JOINing on tag will allow the query planner to use change_tag_rev_tag index
			$tag = $this->getDB()->addQuotes( $this->params['tag'] );

			$this->addTables( 'change_tag' );
			$this->addJoinConds( [
				'change_tag' => [ 'INNER JOIN', [ "ct_tag = $tag AND rev_id=ct_rev_id" ] ]
			] );
		}

		if ( $this->params['toponly'] ) {
			$this->addWhere( 'rev_id = page_latest' );
		}

		/* Wikia change begin - @author: Marooned */
		/* Add revision parent id to make diff link in MyHome and to see if current revision was the first one */
		$this->addFieldsIf('rev_parent_id', $this->fld_wikiamode);
		/* Wikia change end */
	}

	/**
	 * Extract fields from the database row and append them to a result array
	 *
	 * @param $row
	 * @return array
	 */
	private function extractRowInfo( $row ) {
		$vals = [];

		$vals['userid'] = $row->rev_user;
		$vals['user'] = User::getUsername( $row->rev_user, $row->rev_user_text );
		if ( $row->rev_deleted & Revision::DELETED_USER ) {
			$vals['userhidden'] = '';
		}
		if ( $this->fld_ids ) {
			$vals['pageid'] = intval( $row->rev_page );
			$vals['revid'] = intval( $row->rev_id );
		}

		$title = Title::makeTitle( $row->page_namespace, $row->page_title );

		if ( $this->fld_title ) {
			ApiQueryBase::addTitleInfo( $vals, $title );
		}

		if ( $this->fld_timestamp ) {
			$vals['timestamp'] = wfTimestamp( TS_ISO_8601, $row->rev_timestamp );
		}

		if ( $this->fld_flags ) {
			if ( $row->rev_parent_id == 0 && !is_null( $row->rev_parent_id ) ) {
				$vals['new'] = '';
			}
			if ( $row->rev_minor_edit ) {
				$vals['minor'] = '';
			}
			if ( $row->page_latest == $row->rev_id ) {
				$vals['top'] = '';
			}
		}

		/* Wikia change begin - @author: Marooned */
		/* Add revision parent id to make diff link in MyHome and to see if current revision was the first one */
		if($this->fld_wikiamode) {
			$vals['rev_parent_id'] = $row->rev_parent_id;

		}
		/* Wikia change end */
		if ( ( $this->fld_comment || $this->fld_parsedcomment ) && isset( $row->rev_comment ) ) {
			if ( $row->rev_deleted & Revision::DELETED_COMMENT ) {
				$vals['commenthidden'] = '';
			} else {
				if ( $this->fld_comment ) {
					$vals['comment'] = $row->rev_comment;
				}

				if ( $this->fld_parsedcomment ) {
					$vals['parsedcomment'] = Linker::formatComment( $row->rev_comment, $title );
				}
			}
		}

		if ( $this->fld_patrolled && $row->rc_patrolled ) {
			$vals['patrolled'] = '';
		}

		if ( $this->fld_size && !is_null( $row->rev_len ) ) {
			$vals['size'] = intval( $row->rev_len );
		}

		if ( $this->fld_tags ) {
			if ( $row->ts_tags ) {
				$tags = explode( ',', $row->ts_tags );
				$this->getResult()->setIndexedTagName( $tags, 'tag' );
				$vals['tags'] = $tags;
			} else {
				$vals['tags'] = array();
			}
		}

		return $vals;
	}

	public function getCacheMode( $params ) {
		// This module provides access to deleted revisions and patrol flags if
		// the requester is logged in
		return 'anon-public-user-private';
	}

	public function getAllowedParams() {
		return array(
			'limit' => array(
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			'start' => array(
				ApiBase::PARAM_TYPE => 'timestamp'
			),
			'end' => array(
				ApiBase::PARAM_TYPE => 'timestamp'
			),
			'user' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_REQUIRED => true,
			),
			'dir' => array(
				ApiBase::PARAM_DFLT => 'older',
				ApiBase::PARAM_TYPE => array(
					'newer',
					'older'
				)
			),
			'namespace' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => 'namespace'
			),
			'prop' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_DFLT => 'ids|title|timestamp|comment|size|flags',
				ApiBase::PARAM_TYPE => array(
					'ids',
					'title',
					'timestamp',
					'comment',
					'parsedcomment',
					'size',
					'flags',
					'patrolled',
					'wikiamode',
					'tags'
				)
			),
			'show' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array(
					'minor',
					'!minor',
					'patrolled',
					'!patrolled',
				)
			),
			'tag' => null,
			'toponly' => false,
		);
	}

	public function getParamDescription() {
		global $wgRCMaxAge;
		$p = $this->getModulePrefix();
		return array(
			'limit' => 'The maximum number of contributions to return',
			'start' => 'The start timestamp to return from',
			'end' => 'The end timestamp to return to',
			'user' => 'The users to retrieve contributions for',
			'dir' => $this->getDirectionDescription( $p ),
			'namespace' => 'Only list contributions in these namespaces',
			'prop' => array(
				'Include additional pieces of information',
				' ids            - Adds the page ID and revision ID',
				' title          - Adds the title and namespace ID of the page',
				' timestamp      - Adds the timestamp of the edit',
				' comment        - Adds the comment of the edit',
				' parsedcomment  - Adds the parsed comment of the edit',
				' size           - Adds the size of the page',
				' flags          - Adds flags of the edit',
				' patrolled      - Tags patrolled edits',
				' tags           - Lists tags for the edit',
			),
			'show' => array( "Show only items that meet this criteria, e.g. non minor edits only: {$p}show=!minor",
					"NOTE: if {$p}show=patrolled or {$p}show=!patrolled is set, revisions older than \$wgRCMaxAge ($wgRCMaxAge) won't be shown", ),
			'tag' => 'Only list revisions tagged with this tag',
			'toponly' => 'Only list changes which are the latest revision',
		);
	}

	public function getDescription() {
		return 'Get all edits by a user';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'param_user', 'info' => 'User name user is not valid' ),
			array( 'show' ),
			array( 'code' => 'permissiondenied', 'info' => 'You need the patrol right to request the patrolled flag' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=usercontribs&ucuser=YurikBot'
		);
	}

	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/API:Usercontribs';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}

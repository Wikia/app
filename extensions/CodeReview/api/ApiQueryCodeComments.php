<?php

/**
 * Created on Oct 29, 2008
 *
 * Copyright © 2008 Bryan Tong Minh <Bryan.TongMinh@Gmail.com>
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
 */

class ApiQueryCodeComments extends ApiQueryBase {
	private $props;

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'cc' );
	}

	public function execute() {
		global $wgUser;
		// Before doing anything at all, let's check permissions
		if ( !$wgUser->isAllowed( 'codereview-use' ) ) {
			$this->dieUsage( 'You don\'t have permission to view code comments', 'permissiondenied' );
		}
		$params = $this->extractRequestParams();

		$this->props = array_flip( $params['prop'] );
		if ( isset( $this->props['revision'] ) ) {
			$this->setWarning( 'ccprop=revision has been deprecated in favor of ccprop=status' );
		}

		$listview = new CodeCommentsListView( $params['repo'] );
		if ( is_null( $listview->getRepo() ) ) {
			$this->dieUsage( "Invalid repo ``{$params['repo']}''", 'invalidrepo' );
		}
		$pager = $listview->getPager();

		if ( !is_null( $params['start'] ) ) {
			$pager->setOffset( $this->getDB()->timestamp( $params['start'] ) );
		}
		$limit = $params['limit'];
		$pager->setLimit( $limit );

		$pager->doQuery();

		$comments = $pager->getResult();
		$data = array();

		$count = 0;
		$lastTimestamp = 0;
		foreach ( $comments as $row ) {
			if ( $count == $limit ) {
				$this->setContinueEnumParameter( 'start',
					wfTimestamp( TS_ISO_8601, $lastTimestamp ) );
				break;
			}

			$data[] = $this->formatRow( $row );
			$lastTimestamp = $row->cc_timestamp;
			$count++;
		}
		$comments->free();

		$result = $this->getResult();
		$result->setIndexedTagName( $data, 'comment' );
		$result->addValue( 'query', $this->getModuleName(), $data );
	}

	private function formatRow( $row ) {
		$item = array();
		if ( isset( $this->props['revid'] ) ) {
			$item['revid'] = $row->cc_rev_id;
		}
		if ( isset( $this->props['timestamp'] ) ) {
			$item['timestamp'] = wfTimestamp( TS_ISO_8601, $row->cc_timestamp );
		}
		if ( isset( $this->props['user'] ) ) {
			$item['user'] = $row->cc_user_text;
		}
		if ( isset( $this->props['revision'] ) || isset( $this->props['status'] ) ) {
			$item['status'] = $row->cr_status;
		}
		if ( isset( $this->props['text'] ) ) {
			ApiResult::setContent( $item, $row->cc_text );
		}
		return $item;
	}

	public function getAllowedParams() {
		return array(
			'repo' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
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
			'prop' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_DFLT => 'timestamp|user|status|revid',
				ApiBase::PARAM_TYPE => array(
					'timestamp',
					'user',
					'status',
					'text',
					'revid',
					'revision',
				),
			),
		);
	}

	public function getParamDescription() {
		return array(
			'repo' => 'Name of the repository',
			'limit' => 'How many comments to return',
			'start' => 'Timestamp to start listing at',
			'prop' => 'Which properties to return. revision is a deprecated alias for status',
		);
	}

	public function getDescription() {
		return 'List comments on revisions in CodeReview';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'permissiondenied', 'info' => 'You don\'t have permission to view code comments' ),
			array( 'code' => 'invalidrepo', 'info' => "Invalid repo ``repo''" ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=codecomments&ccrepo=MediaWiki',
			'api.php?action=query&list=codecomments&ccrepo=MediaWiki&ccprop=timestamp|user|status|text',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryCodeComments.php 108350 2012-01-08 06:55:19Z johnduhart $';
	}
}

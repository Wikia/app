<?php
/**
 * Created on Mar 29, 2009
 *
 * AbuseFilter extension
 *
 * Copyright © 2008 Alex Z. mrzmanwiki AT gmail DOT com
 * Based mostly on code by Bryan Tong Minh and Roan Kattouw
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

/**
 * Query module to list abuse filter details.
 *
 * @ingroup API
 * @ingroup Extensions
 */
class ApiQueryAbuseFilters extends ApiQueryBase {
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'abf' );
	}

	public function execute() {
		$user = $this->getUser();
		if ( !$user->isAllowed( 'abusefilter-view' ) ) {
			$this->dieUsage( 'You don\'t have permission to view abuse filters', 'permissiondenied' );
		}

		$params = $this->extractRequestParams();

		$prop = array_flip( $params['prop'] );
		$fld_id = isset( $prop['id'] );
		$fld_desc = isset( $prop['description'] );
		$fld_pattern = isset( $prop['pattern'] );
		$fld_actions = isset( $prop['actions'] );
		$fld_hits = isset( $prop['hits'] );
		$fld_comments = isset( $prop['comments'] );
		$fld_user = isset( $prop['lasteditor'] );
		$fld_time = isset( $prop['lastedittime'] );
		$fld_status = isset( $prop['status'] );
		$fld_private = isset( $prop['private'] );

		$result = $this->getResult();

		$this->addTables( 'abuse_filter' );

		$this->addFields( 'af_id' );
		$this->addFields( 'af_hidden' );
		$this->addFieldsIf( 'af_hit_count', $fld_hits );
		$this->addFieldsIf( 'af_enabled', $fld_status );
		$this->addFieldsIf( 'af_deleted', $fld_status );
		$this->addFieldsIf( 'af_public_comments', $fld_desc );
		$this->addFieldsIf( 'af_pattern', $fld_pattern );
		$this->addFieldsIf( 'af_actions', $fld_actions );
		$this->addFieldsIf( 'af_comments', $fld_comments );
		$this->addFieldsIf( 'af_user_text', $fld_user );
		$this->addFieldsIf( 'af_timestamp', $fld_time );

		$this->addOption( 'LIMIT', $params['limit'] + 1 );

		$this->addWhereRange( 'af_id', $params['dir'], $params['startid'], $params['endid'] );

		if ( !is_null( $params['show'] ) ) {
			$show = array_flip( $params['show'] );

			/* Check for conflicting parameters. */
			if ( ( isset( $show['enabled'] ) && isset( $show['!enabled'] ) )
					|| ( isset( $show['deleted'] ) && isset( $show['!deleted'] ) )
					|| ( isset( $show['private'] ) && isset( $show['!private'] ) ) ) {
					$this->dieUsage( 'Incorrect parameter - mutually exclusive values may not be supplied', 'show' );
			}

			$this->addWhereIf( 'af_enabled = 0', isset( $show['!enabled'] ) );
			$this->addWhereIf( 'af_enabled != 0', isset( $show['enabled'] ) );
			$this->addWhereIf( 'af_deleted = 0', isset( $show['!deleted'] ) );
			$this->addWhereIf( 'af_deleted != 0', isset( $show['deleted'] ) );
			$this->addWhereIf( 'af_hidden = 0', isset( $show['!private'] ) );
			$this->addWhereIf( 'af_hidden != 0', isset( $show['private'] ) );
		}

		$res = $this->select( __METHOD__ );

		$showhidden = $user->isAllowed( 'abusefilter-modify' );

		$count = 0;
		foreach ( $res as $row ) {
			if ( ++$count > $params['limit'] ) {
				// We've had enough
				$this->setContinueEnumParameter( 'startid', $row->af_id );
				break;
			}
			$entry = array();
			if ( $fld_id ) {
				$entry['id'] = intval( $row->af_id );
			}
			if ( $fld_desc ) {
				$entry['description'] = $row->af_public_comments;
			}
			if ( $fld_pattern && ( !$row->af_hidden || $showhidden ) ) {
				$entry['pattern'] = $row->af_pattern;
			}
			if ( $fld_actions ) {
				$entry['actions'] = $row->af_actions;
			}
			if ( $fld_hits ) {
				$entry['hits'] = intval( $row->af_hit_count );
			}
			if ( $fld_comments && ( !$row->af_hidden || $showhidden ) ) {
				$entry['comments'] = $row->af_comments;
			}
			if ( $fld_user ) {
				$entry['lasteditor'] = $row->af_user_text;
			}
			if ( $fld_time ) {
				$entry['lastedittime'] = wfTimestamp( TS_ISO_8601, $row->af_timestamp );
			}
			if ( $fld_private && $row->af_hidden ) {
				$entry['private'] = '';
			}
			if ( $fld_status ) {
				if ( $row->af_enabled ) {
					$entry['enabled'] = '';
				}
				if ( $row->af_deleted ) {
					$entry['deleted'] = '';
				}
			}
			if ( $entry ) {
				$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $entry );
				if ( !$fit ) {
					$this->setContinueEnumParameter( 'startid', $row->af_id );
					break;
				}
			}
		}
		$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'filter' );
	}

	public function getAllowedParams() {
		return array(
			'startid' => array(
				ApiBase::PARAM_TYPE => 'integer'
			),
			'endid' => array(
				ApiBase::PARAM_TYPE => 'integer',
			),
			'dir' => array(
				ApiBase::PARAM_TYPE => array(
					'older',
					'newer'
				),
				ApiBase::PARAM_DFLT => 'newer'
			),
			'show' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array(
					'enabled',
					'!enabled',
					'deleted',
					'!deleted',
					'private',
					'!private',
				),
			),
			'limit' => array(
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			'prop' => array(
				ApiBase::PARAM_DFLT => 'id|description|actions|status',
				ApiBase::PARAM_TYPE => array(
					'id',
					'description',
					'pattern',
					'actions',
					'hits',
					'comments',
					'lasteditor',
					'lastedittime',
					'status',
					'private',
				),
				ApiBase::PARAM_ISMULTI => true
			)
		);
	}

	public function getParamDescription() {
		return array(
			'startid' => 'The filter id to start enumerating from',
			'endid' => 'The filter id to stop enumerating at',
			'dir' => 'The direction in which to enumerate',
			'show' => 'Show only filters which meet these criteria',
			'limit' => 'The maximum number of filters to list',
			'prop' => 'Which properties to get',
		);
	}

	public function getDescription() {
		return 'Show details of the abuse filters.';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'nosuchuser', 'user' ),
			array( 'code' => 'permissiondenied', 'info' => 'You don\'t have permission to view abuse filters'),
			array( 'code' => 'show', 'Incorrect parameter - mutually exclusive values may not be supplied'),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=abusefilters&abfshow=enabled|!private',
			'api.php?action=query&list=abusefilters&abfprop=id|description|pattern'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryAbuseFilters.php 103298 2011-11-16 05:34:24Z johnduhart $';
	}
}

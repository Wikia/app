<?php

/*
 * Created on Sep 16, 2010
 *
 * API for MediaWiki 1.14+
 *
 * Copyright (C) 2010 Krzysztof Krzyżaniak (eloy)
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
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

if (!defined('MEDIAWIKI')) {
	require_once ('ApiBase.php');
}

use Wikia\Logger\WikiaLogger;

/**
 * API interface for running Job from job queue
 * @ingroup API
 */
class ApiRunJob extends ApiBase {

	private $maxJobs = 20;

	/**
	 * @access public
	 */
	public function __construct( $main, $action ) {
		self::$messageMap[ "cantrunjobs" ] = array( "code" => "cantrunjobs", 'info' => "You don't have permission to run jobs" );
		parent :: __construct( $main, $action );
	}

	public function wikiaLog( $data ) {
		WikiaLogger::instance()->debug( "ApiRunJob", $data );
	}

	/**
	 * Main entry point, tak job from queue and run it
	 *
	 * @access public
	 */
	public function execute() {
		global $wgUser, $wgApiRunJobsPerRequest;

		ini_set( "memory_limit", -1 );
		ini_set( "max_execution_time", 0 );

		$result = array();
		$done = 0;

		#
		# check if wiki is not readonly
		#
		if( !wfReadOnly() ) {

			$params = $this->extractRequestParams();
			if( !$wgUser->isAllowed( "runjob" ) ) {
				$this->dieUsageMsg( array( "cantrunjobs" ) );
			}

			#
			# api param has precedence
			#
			if( isset( $params[ "max" ] ) ) {
				$max = $params[ "max" ];
				if( is_numeric( $max ) && $max > 0 && $max <= 100 )  {
					$this->maxJobs = $max;
				}
			}
			elseif( !empty( $wgApiRunJobsPerRequest )
				&& is_numeric(  $wgApiRunJobsPerRequest  )
				&& $wgApiRunJobsPerRequest > 0
				&& $wgApiRunJobsPerRequest <= 100
			) {
				$this->maxJobs =  $wgApiRunJobsPerRequest;
			}

			foreach( range( 1, $this->maxJobs ) as $counter ) {
				if( isset( $params[ "type" ] ) ) {
					$job = Job::pop_type( $params[ "type" ] );
				}
				else {
					// refreshlinks2 has precedence
					$job = Job::pop_type( "refreshLinks2" );
					if( !$job ) {
						// any job
						$job = Job::pop();
					}
				}
				if( $job ) {
					$status = $job->run();
					$result[ "job" ][] = array(
						"id" => $job->id,
						"type" => $job->command,
						"status" => $job->toString(),
						"error" => $job->error
					);
					$done++;
				}
				else {
					// there's no job in queue, finish loop, release request
					break;
				}
			}

		}

		$this->wikiaLog( array (
			"type" => isset ( $params[ "type" ] ) ? $params[ "type" ] : "undefined",
			"maxJobs" => $this->maxJobs,
			"done" => $done
		) );

		$result[ "left" ]  = $this->checkQueue( $done );

		$this->getResult()->addValue( null, $this->getModuleName(), $result );

		$result = array();
	}

	/**
	 * check how many jobs still exists in queue
	 *
	 * @param integer $done - how much jobs is already done
	 * @access private
	 *
	 * @return Array
	 */
	private function checkQueue( $done ) {

		wfProfileIn( __METHOD__ );
		global $wgApiRunJobsPerRequest;

		$total = 0;
		#
		# just check if there's any job left
		#
		$dbr = wfGetDB( DB_SLAVE );
		$total = $dbr->selectField( "job", "job_id", "", __METHOD__ );

		$result[ "total" ] = $total;
		$result[ "done" ] = $done;

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * action must be posted, not getted (because it changes state of database)
	 *
	 * @access public
	 */
	public function mustBePosted() {
		return true;
	}

	/**
	 * application has to be in write mode (because it changes state of database)
	 *
	 * @access public
	 */
	public function isWriteMode() {
		return true;
	}

	public function getAllowedParams() {
		return array (
			'max' => array(
				ApiBase :: PARAM_TYPE => "integer"
			),
			'type' => array(
				ApiBase :: PARAM_TYPE => "string"
			)
		);
	}

	public function getParamDescription() {
		return array (
			'max' => 'Max jobs done in request, not more than 100, default 1',
			'type' => 'Type of job, for example refreshLinks2'
		);
	}

	public function getDescription() {
		return array (
			'Run jobs from jobs queue.'
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=runjob',
			'api.php?action=runjob&max=5',
			'api.php?action=runjob&max=5&type=refreshLinks2',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiPurge.php 69579 2010-07-20 02:49:55Z tstarling $';
	}
}

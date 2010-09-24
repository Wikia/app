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

/**
 * API interface for running Job from job queue
 * @ingroup API
 */
class ApiRunJob extends ApiBase {

	private $maxJobs = 5;

	/**
	 * @access public
	 */
	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action );
	}


	/**
	 * Main entry point, tak job from queue and run it
	 *
	 * @access public
	 */
	public function execute() {
		global $wgUser;


		ini_set( "memory_limit", -1 );
		ini_set( "max_execution_time", 600 );

		$params = $this->extractRequestParams();
		if( !$wgUser->isAllowed( "wikifactory" ) ) { // change to 'runjob' later
			$this->dieUsageMsg( array( 'cantrunjobs' ) );
		}

		if( isset( $params[ "max" ] ) ) {
			$max = $params[ "max" ];
			if( is_numeric( $max ) && $max > 0 && $max <= 100 )  {
				$this->maxJobs = $max;
			}
		}

		$result = array();
		foreach( range( 0, $this->maxJobs ) as $counter ) {
			$job = ( isset( $params[ "type" ] ) ) ? Job::pop_type( $params[ "type" ] ) : Job::pop();
			if( $job ) {
				$status = $job->run();
				$result[ "job" ][] = array(
					"id" => $job->id,
					"type" => $job->command,
					"status" => $job->toString(),
					"error" => $job->error
				);
			}
		}

		$result[ "left" ]  = $this->checkQueue();

		$this->getResult()->addValue( null, $this->getModuleName(), $result );

		$result = array();
	}

	/**
	 * check how many different jobs still exists in queue
	 *
	 * @access private
	 *
	 * @return Array
	 */
	private function checkQueue() {

		// select job_cmd, count(*) as howmany from job group by job_cmd;
		$dbr = wfGetDB( DB_SLAVE );
		$sth = $dbr->select(
			"job",
			array( "job_cmd", "count(*) as howmany" ),
			array(),
			__METHOD__,
			array( "GROUP BY" => "job_cmd" )
		);

		$result = array();
		$total = 0;
		while( $row = $dbr->fetchObject( $sth) ) {
			$total += $row->howmany;
			$result[ $row->job_cmd ] = $row->howmany;
		}

		$result[ "total" ] = $total;

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

	protected function getExamples() {
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

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

		$params = $this->extractRequestParams();
		if( !$wgUser->isAllowed( 'runjob' ) ) {
			$this->dieUsageMsg( array( 'cantrunjobs' ) );
		}

		$result = array();
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
				ApiBase :: PARAM_INTEGER => true
			)
		);
	}

	public function getParamDescription() {
		return array (
			'max' => 'Max jobs done in request, not more than 100',
		);
	}

		public function getDescription() {
		return array (
			'Run jobs from jobs queue.'
		);
	}

	protected function getExamples() {
		return array(
			'api.php?action=runjob&max=50'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiPurge.php 69579 2010-07-20 02:49:55Z tstarling $';
	}
}

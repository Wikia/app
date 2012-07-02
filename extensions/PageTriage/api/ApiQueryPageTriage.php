<?php
/**
 * PageTriage extension API
 *
 * Copyright © 2011 Wikimedia Foundation and Ian Baker <ian@wikimedia.org>
 * Based on code by Victor Vasiliev, Bryan Tong Minh, Roan Kattouw, and Alex Z.
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
 * Query module to checkout and checkin pages for PageTriage
 *
 * @ingroup API
 * @ingroup Extensions
 */
class ApiQueryPageTriage extends ApiBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'ptr' );
	}

	public function execute() {
		# get the current user.
		$context = $this->createContext();
		$userId = $context->getUser()->getId();

		$params = $this->extractRequestParams();
		$mode = $params['mode'];

		if( !preg_match('/^\D+$/', $params['id'] ) ) {
			$this->dieUsageMsg( array( 'pagetriage-api-invalidid', $params['id'] ) );
		}

		// expire old checkouts.
		// TODO: make the time configurable.
		wfDebug( __METHOD__ . " expiring PageTriage checkouts older than 15 minutes\n" );
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete(
			'pagetriage_checkouts',
			'ptc_timestamp < ' . $dbw->timestamp( time() - 15 * 60 ),
			__METHOD__
		);		

		$res = $this->getResult();

		if( $mode === 'checkout' ) {
			// the unique index on ptc_recentchanges_id ensures that this will fail if there's an existing row.
			// doing it this way allows for atomic checking w/o starting a transaction.
			//
			// this happens on the master because we expect even a small amount of lag to
			// entirely break it. it's a small table and a small number of people will be using it.
			$dbw->insert(
				'pagetriage_checkouts',
				array(
					'ptc_user' => $userId,
					'ptc_recentchanges_id' => $params['id'],
					'ptc_timestamp' => $dbw->timestamp()
				),
				__METHOD__
			);

			// this won't be set if the insert failed.
			$checkoutId = $dbw->insertId();

			if( $checkoutId ) {
				$res->addValue( 'pagetriage', 'checkout-id', $checkoutId );
				$res->addValue( 'pagetriage', 'result', 'ok' );
			} else {
				$res->addValue( 'pagetriage', 'result', 'already-checked-out' );				
			}			
		} elseif ( $mode === 'checkin' ) {
			// delete this user's row, if any.
			$dbw->delete(
				'pagetriage_checkouts',
				array(
					'ptc_user' => $userId,
					'ptc_recentchanges_id' => $params['id'],
				),
				__METHOD__
			);		
			
			$res->addValue( 'pagetriage', 'result', 'ok' );
		}
	}

	public function getAllowedParams() {
		return array(
			'id' => array(
				ApiBase::PARAM_TYPE => 'integer',
			),
			'mode' => array(
				ApiBase::PARAM_DFLT => 'checkout',
				ApiBase::PARAM_ISMULTI => false,
				ApiBase::PARAM_TYPE => array(
					'checkout', 'checkin',
				),
			)
		);
	}

	public function getParamDescription() {
		return array(
			'id' => 'The ID of the recentchanges entry you\'d like to check out/in',
			'mode' => 'What you\'d like to do',
		);
	}

	public function getDescription() {
		return 'Check out or check in a page for page triage.';
	}

	public function getExamples() {
		return array(
			'api.php?action=pagetriage&id=12345',
			'api.php?action=pagetriage&id=12345&mode=checkin',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: $';
	}
}

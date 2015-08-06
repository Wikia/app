<?php

/*
 * Created on Jan 18, 2013
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

global $wgFetchBlobApiURL;
$wgFetchBlobApiURL = "http://community.wikia.com/api.php";

$wgHooks[ "ExternalStoreDB::fetchBlob" ][ ] = "ExternalStoreDBFetchBlobHook";

$wgExtensionCredits['other'][] = [
	'name' => 'ExternalStoreDB fetch blob',
	'author' => [
		'Krzysztof Krzyżaniak'
	],
];

/**
 * hook for ExternalStoreDB::FetchBlob
 *
 * @param string  $cluster storage identifier
 * @param integer $id blob identifier
 * @param integer $itemID item identifier when revision text is merged & archived
 * @param string  $ret returned blob text
 */
function ExternalStoreDBFetchBlobHook( $cluster, $id, $itemID, &$ret ) {
	global $wgTheSchwartzSecretToken;
	wfProfileIn( __METHOD__ );

	// there's already blob text
	if ( $ret !== false ) {
		wfProfileOut( __METHOD__ );
		return true;
	}

	// PLATFORM-1381: don't try to fetch revisions from "dev-archive" cluster from production
	// @see $wgDefaultExternalStore
	global $wgDefaultExternalStore;

	if ( is_array( $wgDefaultExternalStore ) ) {
		list( $proto, $devCluster ) = explode( '://', $wgDefaultExternalStore[0], 2 );

		if ( $cluster === $devCluster ) {
			wfProfileOut( __METHOD__ );
			$ret = false;

			wfDebug( sprintf( "%s: blob #%d is missing on %s - won't check the production!\n", __METHOD__, $id, $cluster ) );
			return true;
		}
	}

	// wikia doesn't use $itemID
	$url = sprintf( "%s?action=fetchblob&store=%s&id=%d&token=%s&format=json",
		F::app()->wg->FetchBlobApiURL,
		$cluster,
		$id,
		$wgTheSchwartzSecretToken
	);

	$response = json_decode( Http::get( $url, "default", array( 'noProxy' => true ) ) );

	if ( isset( $response->fetchblob ) ) {
		$blob = isset( $response->fetchblob->blob ) ? $response->fetchblob->blob : false;
		$hash = isset( $response->fetchblob->hash ) ? $response->fetchblob->hash : null;

		if ( $blob ) {
			// pack to binary
			$blob = pack( "H*", $blob );
			$hash = md5( $blob );
			// check md5 sum for binary
			if (  $hash == $response->fetchblob->hash ) {
				wfDebug( __METHOD__ . ": md5 sum match\n" );
				$ret = $blob;

				// now store blob in local database
				$store = new ExternalStoreDB();
				$dbw = $store->getMaster( $cluster );
				if ( $dbw ) {
					wfDebug( __METHOD__ . ": storing blob $id on local storage $cluster\n" );
					$dbw->insert(
						$store->getTable( $dbw ),
						array( "blob_id" => $id, "blob_text" => $ret ),
						__METHOD__,
						array( "IGNORE" )
					);
					$dbw->commit();
				}
			}
			else {
				wfDebug( __METHOD__ . ": md5 sum not match, $hash != $response->fetchblob->hash\n" );
			}
		}
	}
	else {
		wfDebug( __METHOD__ . ": malformed response from API call\n" );
	}
	wfProfileOut( __METHOD__ );

	return true;
}

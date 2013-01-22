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

/**
 * hook for ExternalStoreDB::FetchBlob
 *
 * @param string  $cluster storage identifier
 * @param integer $id blob identifier
 * @param integer $itemID item identifier when revision text is merged & archived
 * @param string  $ret returned text
 */
function ExternalStoreDBFetchBlobHook( $cluster, $id, $itemID, &$ret ) {

	global $wgTheSchwartzSecretToken;
	// wikia doesn't use $itemID
	wfProfileIn( __METHOD__ );
	$url = sprintf( "http://community.eloy.wikia-dev.com/api.php?action=fetchblob&store=%s&id=%d&token=%s&format=json",
		$cluster,
		$id,
		$wgTheSchwartzSecretToken
	);

	$response = json_decode( Http::get( $url, "default", array( 'noProxy' => true ) ) );

	print_r( $response );


	if( isset( $response->fetchblob ) ) {
		$blob = isset( $response->fetchblob->blob ) ? $response->fetchblob->blob : false;
		$hash = isset( $response->fetchblob->hash ) ? $response->fetchblob->hash : null;

		if( $blob ) {
			// pack to binary
			$blob = pack( "H*", $blob );
			$hash = md5( $blob );
			// check md5 sum for binary
			if(  $hash == $response->fetchblob->hash ) {
				wfDebug( __METHOD__ . ": md5 sum match\n" );
				$ret = $blob;
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

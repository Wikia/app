<?php

/**
 * @author: Federico "Lox" Lucignano
 *
 * A helper class for the IP rename tool
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 3.0 or later
 */
class RenameIPHelper {

	/**
	 * Gets wikis an IP address might have edits on
	 *
	 * Called by CoppaToolController
	 *
	 * @author Daniel Grunwell (Grunny)
	 *
	 * @param String $ipAddress The IP address to lookup
	 *
	 * @return array
	 */
	public static function lookupIPActivity( $ipAddress ) : array {
		global $wgDevelEnvironment, $wgSpecialsDB;
		wfProfileIn( __METHOD__ );

		if ( empty( $ipAddress ) || !IP::isIPAddress( $ipAddress ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$result = [];
		$ip = inet_pton( $ipAddress );
		if ( empty( $wgDevelEnvironment ) ) {
			$dbr = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
			$res = $dbr->select(
				[ 'multilookup' ],
				[ 'ml_city_id' ],
				[
					'ml_ip_bin' => $ip,
				],
				__METHOD__
			);

			foreach ( $res as $row ) {
				if ( WikiFactory::isPublic( $row->ml_city_id ) ) {
					$result[] = (int)$row->ml_city_id;
				}
			}

			$dbr->freeResult( $res );
		} else { // on devbox - set up the list manually
			$result = [
				165, // firefly
			];
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}
}

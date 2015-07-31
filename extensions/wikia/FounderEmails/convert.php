<?php
/**
 * This script converts old founder options into new user_properties entries
 *
 * Usage:
 *  --dry don't write anything in database, just show what will be done
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
 * @ingroup Maintenance
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 */

require_once( dirname( __FILE__ ) . '/../../../maintenance/Maintenance.php' );

class FounderEmailsOptionsConverter extends Maintenance {

	/**
	 * @brief public constructor
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Convert old options to new user_properties for Founder Emails";
		$this->addOption( 'dry', 'Do not change anything, just show what will be done', false, false );
		$this->addOption( 'remove', 'After converting option to new format remove old one', false, false );
	}

	/**
	 * @brief memory limit
	 */
	public function memoryLimit() {
		// Don't eat all memory on the machine
		return "256M";
	}

	/**
	 * @brief main entry point
	 */
	public function execute() {
		global $wgExternalSharedDB;

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB ); // handler to wikifactory tables

		// take all users with founderemailsenabled option
		wfOut( "Getting users with founderemailsenabled option set...\n" );
		$sth = $dbw->select(
			array( "user_properties" ),
			array( "up_user", "up_value" ),
			array( "up_property" => "founderemailsenabled" ),
			__METHOD__
		);

		while ( $row = $dbw->fetchObject( $sth ) ) {
			// now check if user founded any wiki
			$sth2 = $dbw->select(
				array( "city_list" ),
				array( "city_id", "city_founding_user" ),
				array( "city_founding_user" => $row->up_user )
			);
			$user = User::newFromId( $row->up_user );
			if ( $user ) {
				wfOut( "Found user {$user->getId()} with user name {$user->getName()}\n" );
				$changed = false;
				while ( $city = $dbw->fetchObject( $sth2 ) ) {
					$city_id = $city->city_id;
					if ( !$this->hasOption( 'dry' ) ) {
						$user->setLocalPreference( "founderemails-joins", $row->up_value, $city_id );
						$user->setLocalPreference( "founderemails-edits", $row->up_value, $city_id );
						$user->setLocalPreference( "founderemails-views-digest", $row->up_value, $city_id );
						$user->setLocalPreference( "founderemails-complete-digest", $row->up_value, $city_id );
						if ( $this->hasOption( 'remove' ) ) {
							// founderemailsenabled is not in use anymore.
							$user->removeGlobalPreference("founderemailsenabled");
						}
						$changed = true;
					}
					wfOut( "\tset founderemails-joins-{$city_id} to {$row->up_value}\n" );
					wfOut( "\tset founderemails-edits-{$city_id} to {$row->up_value}\n" );
					wfOut( "\tset founderemails-views-digest-{$city_id} to {$row->up_value}\n" );
					wfOut( "\tset founderemails-complete-digest-{$city_id} to {$row->up_value}\n" );
				}
				if ( $changed ) {
					$user->saveSettings();
				}
			}
		}
	}
};

$maintClass = "FounderEmailsOptionsConverter";
require_once( DO_MAINTENANCE );

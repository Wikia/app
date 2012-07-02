<?php
/*
 (c) Aaron Schulz 2007, GPL

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 http://www.gnu.org/copyleft/gpl.html
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "ConfirmAccount extension\n";
	exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Confirm User Accounts',
	'descriptionmsg' => 'confirmedit-desc',
	'author'         => 'Aaron Schulz',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:ConfirmAccount',
);

# Load default config variables
require( dirname( __FILE__ ) . '/ConfirmAccount.config.php' );

# Define were PHP files and i18n files are located
require( dirname( __FILE__ ) . '/ConfirmAccount.setup.php' );
ConfirmAccountSetup::defineSourcePaths( $wgAutoloadClasses, $wgExtensionMessagesFiles );

# Define JS/CSS modules and file locations
ConfirmAccountUISetup::defineResourceModules( $wgResourceModules );

# Let some users confirm account requests and view credentials for created accounts
$wgAvailableRights[] = 'confirmaccount'; // user can confirm account requests
$wgAvailableRights[] = 'requestips'; // user can see IPs in request queue
$wgAvailableRights[] = 'lookupcredentials'; // user can lookup info on confirmed users

# Actually register special pages
ConfirmAccountUISetup::defineSpecialPages( $wgSpecialPages, $wgSpecialPageGroups );

# ####### HOOK CALLBACK FUNCTIONS #########

# UI-related hook handlers
ConfirmAccountUISetup::defineHookHandlers( $wgHooks );

# Check for account name collisions
$wgHooks['AbortNewAccount'][] = 'ConfirmAccountUIHooks::checkIfAccountNameIsPending';

# Schema changes
$wgHooks['LoadExtensionSchemaUpdates'][] = 'ConfirmAccountUpdaterHooks::addSchemaUpdates';

# ####### END HOOK CALLBACK FUNCTIONS #########

# Load the extension after setup is finished
$wgExtensionFunctions[] = 'efLoadConfirmAccount';

/**
 * This function is for setup that has to happen in Setup.php
 * when the functions in $wgExtensionFunctions get executed.
 * @return void
 */
function efLoadConfirmAccount() {
	global $wgEnableEmail;
	# This extension needs email enabled!
	# Otherwise users can't get their passwords...
	if ( !$wgEnableEmail ) {
		echo "ConfirmAccount extension requires \$wgEnableEmail set to true.\n";
		exit( 1 ) ;
	}
}

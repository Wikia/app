<?php
#(c) Andrew Garrett 2007 GPL

#This file is part of MediaWiki.

#MediaWiki is free software: you can redistribute it and/or modify
#it under the terms of version 2 of the GNU General Public License
#as published by the Free Software Foundation.

#MediaWiki is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.

#You should have received a copy of the GNU General Public License
#along with MediaWiki.  If not, see <http://www.gnu.org/licenses/>.

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "Invitations extension\n";
	exit( 1 );
}

// So that extensions which optionally allow an invitation model will work
define('Invitations',1);

$wgExtensionCredits['specialpage'][] = array(
	'author'         => 'Andrew Garrett',
	'version'        => '$Revision: 36735 $',
	'name'           => 'Invitations',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Invitations',
	'description'    => 'Allows management of new features by restricting them to an invitation-based system.',
	'descriptionmsg' => 'invitations-desc',
);

$dir = dirname(__FILE__) . '/';

$wgSpecialPages['Invitations'] = 'SpecialInvitations';
$wgAutoloadClasses['SpecialInvitations'] = $dir . 'Invitations_page.php';
$wgAutoloadClasses['Invitations'] = $dir . 'Invitations_obj.php';

$wgExtensionMessagesFiles['Invitations'] = $dir . 'Invitations.i18n.php';
$wgExtensionAliasesFiles['Invitations'] = $dir . 'Invitations.i18n.alias.php';

$wgInvitationTypes = array();

/*
Example:
$wgInvitationTypes['centralauth'] = array(
	'reserve' => 5,
	'limitedinvites' => true,
	'invitedelay' => 24 * 3600 * 4
);

Limits invites to 'centralauth' to 5 invites per inviter, which can be used
4 days after the user is invited. */

# Add invite log
$wgLogTypes[] = 'invite';
$wgLogNames['invite'] = 'invite-logpage';
$wgLogHeaders['invite'] = 'invite-logpagetext';
$wgLogActions['invite/invite'] = 'invite-logentry';

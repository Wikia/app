<?php

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation, version 2
of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

global $wgHooks, $wgOut;
$wgHooks['ParserAfterStrip'][]      = 'parseUserSignatures';
$wgExtensionCredits['parserhook'][] = array(
	'version'     => '0.4.1',
	'name'        => 'UserSignature',
	'author'      => 'Paul Grinberg',
	'email'       => 'gri6507 at yahoo dot com',
	'url'         => 'http://www.mediawiki.org/wiki/Extension:User_Contact_Links',
	'description' => 'provides the ability to simply and consistantly add other user names using ^^^user^^^ syntax',
	'descriptionmsg' => 'usercontactlink-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['UserContactLinks'] = $dir . 'UserSignature.i18n.php';

function parseUserSignatures(&$parser, &$text, &$strip_state) {
	wfLoadExtensionMessages( 'UserContactLinks' );
	while (preg_match('/\^\^\^(.+?)\^\^\^/', $text, $matches)) {
		$userid = getUserIDFromUserText($matches[1]);
			if ($userid != 0) { // successfully found the user based on first word
				$u = newFromId($userid);
				$text = str_replace("^^^$matches[1]^^^", "[[:user:" . $u->getName() . "|" . $u->getRealName() . "]]", $text);
			} else {
				$text = str_replace("^^^$matches[1]^^^", "'''{". wfMsg('usercontactlink-baduser') ."}'''", $text);
			}
		}

	return true;
}

function newFromId( $id ) {
	$u = new User;
	$u->mId = $id;
	$u->mFrom = 'id';
	return $u;
}

# only create the following function if it was not already installed with the Todo Tasks extension
if (!function_exists('getUserIDFromUserText')) {
	function getUserIDFromUserText($user) {
		$dbr = wfGetDB( DB_SLAVE );
		$userid = 0;

		if (preg_match('/^\s*(.*?)\s*$/', $user, $matches))
		    $user = $matches[1];

		$u = User::newFromName($user);
		if ($u) {
			$userid = $u->idForName(); // valid userName
		}
		if (!$userid) { // if not a valid userName, try as a userRealName
			$userid = $dbr->selectField( 'user', 'user_id', array( 'user_real_name' => $user ), 'renderTodo' );
			if (!$userid) { // if not valid userRealName, try case insensitive userRealName
				$sql = "SELECT user_id FROM ". $dbr->tableName('user') ." WHERE UPPER(user_real_name) LIKE '%" . strtoupper($user) . "%'";
				$res = $dbr->query( $sql, __METHOD__ );
				if ($dbr->numRows($res)) {
					$row = $dbr->fetchRow($res);
					$userid = $row[0];
				}
				$dbr->freeResult($res);
				if (!$userid) { // if not case insensitive userRealName, try case insensitive lastname
					$first = "";
					$last = "";
					$fullname = array();
					$fullname = preg_split('/\s+/', $user);
					if (count($fullname) > 0)
					    $first=$fullname[0];
					if (count($fullname) > 1)
					    $last=$fullname[1];

					if ($last != '') {
						$sql = "SELECT user_id FROM ". $dbr->tableName('user') ." WHERE UPPER(user_real_name) LIKE '%" . strtoupper($last) . "%'";
						$res = $dbr->query( $sql, __METHOD__ );
						if ($dbr->numRows($res)) {
							$row = $dbr->fetchRow($res);
							$userid = $row[0];
						}
						$dbr->freeResult($res);
					}
				}
			}
		}
		return $userid;
	}
}

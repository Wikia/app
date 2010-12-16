<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * A Special Page extension to add languages, runnable by users with the 'addlanguage' right.
 * @addtogroup Extensions
 *
 * @author Erik Moeller <Eloquence@gmail.com>
 * @license public domain
 */

$wgAvailableRights[] = 'addlanguage';
$wgGroupPermissions['bureaucrat']['addlanguage'] = true;

$wgExtensionFunctions[] = 'wfSpecialManageLanguages';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Language manager',
	'author' => 'Erik Moeller',
	'descmsg' => 'langman-desc',
);

function wfSpecialManageLanguages() {
	global $IP;
	
	require_once "$IP/includes/SpecialPage.php";

	class SpecialLanguages extends SpecialPage {
		function SpecialLanguages() {
			SpecialPage::SpecialPage( 'Languages' );
		}

		function execute( $par ) {
			global $wgOut, $wgRequest, $wgUser;
			$wgOut->setPageTitle( wfMsg( 'langman_title' ) );
			if ( !$wgUser->isAllowed( 'addlanguage' ) ) {
				$wgOut->addHTML( wfMsg( 'langman_not_allowed' ) );
				return false;
			}
			$action = $wgRequest->getText( 'action' );
			if ( !$action ) {
				$wgOut->addWikiText( wfMsg( 'langman_header' ) );
			} else {
				$dbr = wfGetDB( DB_MASTER );
				$langname = $wgRequest->getText( 'langname' );
				$langiso6393 = $wgRequest->getText( 'langiso6393' );
				$langiso6392 = $wgRequest->getText( 'langiso6392' );
				$langwmf = $wgRequest->getText( 'langwmf' );
				if ( !$langname || !$langiso6393 ) {
					$wgOut->addHTML( "<strong>" . wfMsg( 'langman_req_fields' ) . "</strong>" );
				} else {
					$wgOut->addHTML( "<strong>" . wfMsg( 'langman_adding', $langname, $langiso6393 ) . "</strong>" );
					$sql = 'INSERT INTO language(iso639_2,iso639_3,wikimedia_key) values(' . $dbr->addQuotes( $langiso6392 ) . ',' . $dbr->addQuotes( $langiso6393 ) . ',' . $dbr->addQuotes( $langwmf ) . ')';

					$dbr->query( $sql );
					$id = $dbr->insertId();
					$sql = 'INSERT INTO language_names(language_id,name_language_id,language_name) values (' . $id . ',85,' . $dbr->addQuotes( $langname ) . ')';
					$dbr->query( $sql );

				}

			}

			$this->showForm();


			# $wgRequest->getText( 'page' );
		}
		function showForm() {
			global $wgOut;
			$action = $this->getTitle()->escapeLocalURL( 'action=submit' );
			$wgOut->addHTML(
<<<END
<form name="addlanguage" method="post" action="$action">
<table border="0">
<tr>
<td>
END
. wfMsg( 'langman_langname' ) .
<<<END
</td>
<td>
<input type="text" size="40" name="langname">
</td>
</tr>
<tr>
<td>
END
. wfMsg( 'langman_iso639-3' ) .
<<<END
</td>
<td>
<input type="text" size="8" name="langiso6393">
</td>
</tr>
<tr>
<td>
END
. wfMsg( 'langman_iso639-2' ) .
<<<END
</td>
<td>
<input type="text" size="8" name="langiso6392"> 
END
. wfMsg( 'langman_field_optional' ) .
<<<END
</td>
</tr>
<tr>
<td>
END
. wfMsg( 'langman_wikimedia' ) .
<<<END
</td>
<td>
<input type="text" size="4" name="langwmf"> 
END
. wfMsg( 'langman_field_optional' ) .
<<<END
</td>
</tr>
<tr><td>
<input type="submit" value="
END
. wfMsg( 'langman_addlang' ) .
<<<END
">
</td></tr>
</table>
</form>
END
);
			return true;

		}
	}

	SpecialPage::addPage( new SpecialLanguages );
}

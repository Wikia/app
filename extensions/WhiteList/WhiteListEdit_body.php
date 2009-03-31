<?php
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public LicenseWh
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

/**
 * A file for the WhiteList extension
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Paul Grinberg <gri6507@yahoo.com>
 * @author Mike Sullivan <ms-mediawiki@umich.edu>
 * @copyright Copyright © 2008, Paul Grinberg, Mike Sullivan
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

# older versions of MW did not have the NewFromId method, let's define our own
function WhiteListUserFromId($id) {	
	if (method_exists('User', 'newfromid')) {
		return User::NewFromId($id);
	} else {
		$u = new User;
		$u->mId = $id;
		$u->mFrom = 'id';
		return $u;
	}
}

# older versions of MW did not have the standard method for loading messages. So, let's recreate it
function WhiteListLoadMessages() {
	static $messagesLoaded = false;
	global $wgMessageCache;
	if ($messagesLoaded) return;
		$messagesLoaded = true;

	require_once(dirname(__FILE__) . '/WhiteListEdit.i18n.php' );
	foreach ( $messages as $lang => $langMessages ) {
		$wgMessageCache->addMessages( $langMessages, $lang );
	}
}

class WhiteListEdit extends SpecialPage
{
	function __construct() {
		self::loadMessages();
		SpecialPage::SpecialPage( 'WhiteListEdit', 'editwhitelist' );
	}

	function loadMessages() {
		# the new method for loading extension messages is only available in MW versions > 1.12
		# so let's keep the compatibility with older versions
		if (function_exists('wfLoadExtensionMessages'))
		{
			wfLoadExtensionMessages('WhiteListEdit');
		}
		else
		{
			WhiteListLoadMessages();
		}
		
		return true;
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

		# sanity check
		if ($wgUser->isAnon()) 
		{
			$wgOut->PermissionRequired('editwhitelist');
			return;
		}
	
		$this->setHeaders();
		$wgOut->setPagetitle( wfMsg( 'whitelistedit' ) );

		$contractorId = $wgRequest->getInt( 'contractor', 0 );
		if ( !$contractorId )
		{
			self::DisplayContractorSelectForm();
			return;
		}

		if ( $wgRequest->getVal( 'submit', '' ) == wfMsg( 'whitelistnewtablereview' ) )
			self::ProcessContractorEditChanges( 0 );
		else
		{
			self::ProcessContractorEditChanges( 1 );
			self::DisplayContractorEditDetails( $contractorId );
		}
	}

	function ProcessContractorEditChanges( $doit ) {
		global $wgOut, $wgUser, $wgRequest;
		global $wgServer, $wgArticlePath;
		$debug = 1;
		$dbr = wfGetDB( DB_SLAVE );

		# first lets process the changes to the existing entries
		$contractorId = $wgRequest->getInt( 'contractor', 0 );
		$modify_array = $wgRequest->getArray( 'cb_modify', array() );
		$NewExpiryDate = $wgRequest->getVal( 'NewExpiryDate', '' );
		$action = $wgRequest->getVal( 'action', '' );

		if ( !$doit ) {
			# create the form for submitting the same data after review
			$wgOut->addHTML( "<form name='mainform' method='post'>" );
			$wgOut->addHTML( "<input type='hidden' name='contractor' value='$contractorId'>" );
			foreach ( $modify_array as $modify )
			$wgOut->addHTML( "<input type='hidden' name='cb_modify[]' value='$modify'>" );
			$wgOut->addHTML( "<input type='hidden' name='NewExpiryDate' value='$NewExpiryDate'>" );
			$wgOut->addHTML( "<input type='hidden' name='action' value='$action'>" );

			$ContractorUser = WhiteListUserFromID( $contractorId );
			$wgOut->addWikiText( wfMsg( 'whitelistoverview', $ContractorUser->getRealName() ) );
		}

		if ( $action == 'ChangeDate' ) {
			$date = ( $NewExpiryDate == '' ) ? "" : date( "Y-m-d H:i:s", strtotime( $NewExpiryDate ) );
			foreach ( $modify_array as $entry => $rowid )
			{
				$dbr->begin();
				if ( $doit ) {
					$dbr->update( 'whitelist',
					array( 'wl_expires_on' => $date,
					'wl_updated_by_user_id' => $wgUser->getId()
					),
					array( 'wl_id' => $rowid ),
					__METHOD__
					);
				} else {
					$pagename = $dbr->selectField( 'whitelist',
					'wl_page_title',
					array( 'wl_id' => $rowid ),
					__METHOD__
					);
					$wgOut->addWikiText( wfMsg( 'whitelistoverviewcd', $date, $pagename ) );
				}
				$dbr->commit();
			}
		} else if ( ( $action == 'SetEdit' ) || ( $action == 'SetView' ) ) {
			foreach ( $modify_array as $entry => $rowid )
			{
				$dbr->begin();
				if ( $doit ) {
					$dbr->update( 'whitelist',
						array( 'wl_allow_edit' => ( $action == 'SetEdit' ) ? 1 : 0,
							'wl_updated_by_user_id' => $wgUser->getId()
						),
						array( 'wl_id' => $rowid ),
						__METHOD__
					);
				} else {
					$pagename = $dbr->selectField( 'whitelist',
						'wl_page_title',
						array( 'wl_id' => $rowid ),
						__METHOD__
					);
					$wgOut->addWikiText( wfMsg( 'whitelistoverviewsa',
						( $action == 'SetEdit' ) ? wfMsg( 'whitelisttablesetedit' ) : wfMsg( 'whitelisttablesetview' ),
						$pagename
					) );
				}
				$dbr->commit();
			}
		} else if ( $action == 'Remove' ) {
			foreach ( $modify_array as $entry => $rowid )
			{
				$dbr->begin();
				if ( $doit ) {
					$dbr->delete( 'whitelist',
					array( 'wl_id' => $rowid ),
					__METHOD__
					);
				} else {
					$pagename = $dbr->selectField( 'whitelist',
						'wl_page_title',
						array( 'wl_id' => $rowid ),
						__METHOD__
					);
					self::DisplayWildCardMatches( $pagename, wfMsg( 'whitelistoverviewrm', $pagename ), -1 );
				}
				$dbr->commit();
			}
		}

		# now process the new additions, but make sure not to add duplicates
		$newPages = $wgRequest->getVal( 'newPages', '' );
		$expiryDate = $wgRequest->getVal( 'ExpiryDate', '' );
		$newAction = $wgRequest->getVal( 'newAction', '' );

		if ( !$doit ) {
			$wgOut->addHTML( "<input type='hidden' name='newPages' value='$newPages'>" );
			$wgOut->addHTML( "<input type='hidden' name='ExpiryDate' value='$expiryDate'>" );
			$wgOut->addHTML( "<input type='hidden' name='newAction' value='$newAction'>" );
		}

		$pages = preg_split( '/\n/', $newPages, -1, PREG_SPLIT_NO_EMPTY );
		foreach ( $pages as $entry => $pagename ) {
			$pagename = trim( $pagename );
			if ( $pagename == '' )
				continue;

			# If the input is a URL, then convert it back to a title
			$myArticlePath = str_replace( "$1", '', $wgArticlePath );
			$myArticlePath = str_replace( "/", '\\/', $myArticlePath );
			$myServer = str_replace( "/", '\\/', $wgServer );
			if ( preg_match( "/^$myServer$myArticlePath(.*)$/", $pagename, $matches ) )
				$pagename = preg_replace( '/_/', ' ', $matches[1] );

			# ensure we have a wildcard of %
			$pagename = str_replace( '*', '%', $pagename );

			if ( $doit ) {
				self::insertNewPage( $dbr, $contractorId, $pagename, $newAction, $expiryDate );
			} else {
				self::DisplayWildCardMatches( $pagename,
					wfMsg( 'whitelistoverviewna',
						$pagename,
						( $newAction == 'SetEdit' ) ? wfMsg( 'whitelisttablesetedit' ) : wfMsg( 'whitelisttablesetview' ),
						( $expiryDate == '' ) ? wfMsg( 'whitelistnever' ) : $expiryDate
					),
					-1
				);
			}

			# check to see if the page is a redirect and if so, add the redirected-to page also
			$title = Title::newFromText( $pagename );
			if ( $title ) {
				$article = new Article( $title );
				$pagetext = $article->getContent();
				$redirecttitle = Title::newFromRedirect( $pagetext );
				if ( $redirecttitle ) {
					if ( $doit ) {
						self::insertNewPage( $dbr, $contractorId, $redirecttitle->getPrefixedText(), $newAction, $expiryDate );
					} else {
						$wgOut->addWikiText( wfMsg( 'whitelistoverviewna',
							$redirecttitle->getPrefixedText(),
							( $newAction == 'SetEdit' ) ? wfMsg( 'whitelisttablesetedit' ) : wfMsg( 'whitelisttablesetview' ),
							$expiryDate
						) );
					}
				}
			}
		}

		if ( !$doit )
		{
			$wgOut->addHTML( "<p><input type='submit' value='" . wfMsg( 'whitelistnewtableprocess' ) . "' />" );
			$wgOut->addHTML( "</form>" );
		}

		return;
	}

	function InsertNewPage( $dbr, $contractorId, $pagename, $newAction, $expiryDate )
	{
		global $wgUser;

		# this is for some reason a case insensitive search, so be ware!!!
		$dbr->begin();
		if ( !$dbr->selectRow(
			'whitelist',
			array( 'wl_id' ),
			array( 'wl_user_id'    => $contractorId,
			'wl_page_title' => $pagename
			),
			__METHOD__
		) ) {
			$dbr->insert(
				'whitelist',
				array(
					'wl_user_id'    => $contractorId,
					'wl_page_title' => $pagename,
					'wl_allow_edit' => ( $newAction == 'SetEdit' ) ? 1 : 0,
					'wl_expires_on' => ( $expiryDate == '' ) ? "" : date( "Y-m-d H:i:s", strtotime( $expiryDate ) ),
					'wl_updated_by_user_id' => $wgUser->getId()
				),
				__METHOD__
			);
		}
		$dbr->commit();
	}

	function DisplayContractorEditDetails( $contractorId )
	{
		global $wgOut, $wgUser, $wgWhiteListUsePrettyCalendar;
		$dbr = wfGetDB( DB_SLAVE );

		$wgOut->addScript( <<<END
<script language = "Javascript">
/* <![CDATA[ */

var form='mainform' //Give the form name here

function SetChecked(val,chkName) {
dml=document.forms[form];
len = dml.elements.length;
var i=0;
for( i=0 ; i<len ; i++) {
if (dml.elements[i].name==chkName) {
dml.elements[i].checked=val;
}
}
}
/* ]]> */
</script>
END
		);
		if ( $wgWhiteListUsePrettyCalendar )
		{
			SpecialUserStats::AddCalendarJavascript();
			$wgOut->addScript( "<script type='text/javascript'>document.write(getCalendarStyles());</script>" );
		}

		ob_start();
		print  <<<END
<form name="mainform" method="post">
  <input type="hidden" name="contractor" value="$contractorId">
  <table cellpadding=0 cellspacing=10 border=0>
    <tr>
      <td>
        <table cellspacing=0 cellpadding=2 border=1>
          <tr>
            <td colspan=6>
END;
		$wgOut->addHTML( ob_get_contents() );
		ob_clean();

		$ContractorUser = WhiteListUserFromID( $contractorId );
		$wgOut->addHTML( wfMsg( 'whitelistfor', $ContractorUser->getRealName() ) );
		$wgOut->addHTML( '</td></tr><tr><th><center>' .
			wfMsg( 'whitelisttablemodify' ) . "<br /><a href=\"javascript:SetChecked(1,'cb_modify[]')\">" .
			wfMsg( 'whitelisttablemodifyall' ) . "</a> <a href=\"javascript:SetChecked(0,'cb_modify[]')\">" .
			wfMsg( 'whitelisttablemodifynone' ) . '</a></center></th><th>' .
			wfMsg( 'whitelisttablepage' ) . '</th><th>' .
			wfMsg( 'whitelisttabletype' ) . '</th><th>' .
			wfMsg( 'whitelisttableexpires' ) . '</th><th>' .
			wfMsg( 'whitelisttablemodby' ) . '</th><th>' .
			wfMsg( 'whitelisttablemodon' ) . '</th></tr>'
		);
		$res = self::contractorWhiteListTable( $dbr, $contractorId );
		for ( $row = $dbr->fetchObject( $res ); $row; $row = $dbr->fetchObject( $res ) ) {
			$wgOut->addHTML( "<tr><td><center><input type='checkbox' name='cb_modify[]' value='$row->wl_id'></center></td><td>" );
			$page_title = Title::newFromText( $row->wl_page_title );
			self::DisplayWildCardMatches( $row->wl_page_title, $row->wl_page_title, 0 );
			$wgOut->addHTML( "</td><td><center>" );
			if ( $row->wl_allow_edit ) {
				$wgOut->addHTML( wfMsg( 'whitelisttableedit' ) );
			} else {
				$wgOut->addHTML( wfMsg( 'whitelisttableview' ) );
			}
			$wgOut->addHTML( "</center></td><td>&nbsp;$row->wl_expires_on</td><td>" );
			$u = WhiteListUserFromId( $row->wl_updated_by_user_id );
			$wgOut->addHTML( $u->getRealName() );
			$wgOut->addHTML( "</td><td>$row->wl_updated_on</td></tr>" );
		}
		$dbr->freeResult( $res );

		print  <<<END
        </table>
      </td>
    </tr>
    <tr>
      <td>
END;
		$wgOut->addHTML( ob_get_contents() );
		ob_clean();

		if ( $wgWhiteListUsePrettyCalendar ) {
			print  <<<END
            <script type='text/javascript'>
              var cal1 = new CalendarPopup('testdiv1');
              cal1.showNavigationDropdowns();
            </SCRIPT>
            <A HREF='#' onClick="cal1.select(document.forms[0].NewExpiryDate,'anchor1','MM/dd/yyyy'); return false;" NAME='anchor1' ID='anchor1'>
END;
			$wgOut->addHTML( ob_get_contents() );
			ob_clean();
		}

		$wgOut->addHTML(
			wfMsg( 'whitelisttablenewdate' ) . "</a> <input type='text' size='10'  name='NewExpiryDate'/><input type='radio' name='action' value='ChangeDate'>" .
			wfMsg( 'whitelisttablechangedate' ) . " <input type='radio' name='action' value='SetEdit'>" .
			wfMsg( 'whitelisttablesetedit' ) . " <input type='radio' name='action' value='SetView'>" .
			wfMsg( 'whitelisttablesetview' ) . " <input type='radio' name='action' value='Remove' checked>" .
			wfMsg( 'whitelisttableremove' ) .
			"</td><td><div ID='testdiv1' STYLE=\"position:absolute;visibility:hidden;background-color:white;layer-background-color:white;\">" .
			"</div></td></tr><tr><td><table border=1 cellspacing=0 cellpadding=2 width=100%><tr><td><center>"
		);
		$wgOut->addHTML( wfMsg( 'whitelistnewpagesfor', $ContractorUser->getRealName() ) );
		print  <<<END
              <textarea name="newPages" cols=60 rows=5></textarea></center>
            </td>
          </tr>
          <tr>
            <td>
END;
		$wgOut->addHTML( ob_get_contents() );
		ob_clean();

		if ( $wgWhiteListUsePrettyCalendar ) {
			print  <<<END
                <script type='text/javascript'>
                var cal1 = new CalendarPopup('testdiv2');
                cal1.showNavigationDropdowns();
                </SCRIPT>
                <A HREF='#' onClick="cal1.select(document.forms[0].ExpiryDate,'anchor2','MM/dd/yyyy'); return false;" NAME='anchor2' ID='anchor2'>
END;
			$wgOut->addHTML( ob_get_contents() );
			ob_clean();
		}

		$wgOut->addHTML(
			wfMsg( 'whitelistnewtabledate' ) . "</a><input type='text' size='10'  name='ExpiryDate'/> <input type='radio' name='newAction' value='SetEdit'>" .
			wfMsg( 'whitelistnewtableedit' ) . " <input type='radio' name='newAction' value='SetView' checked>" .
			wfMsg( 'whitelistnewtableview' ) .
			"</td><td><div ID='testdiv2' STYLE=\"position:absolute;visibility:hidden;background-color:white;layer-background-color:white;\">" .
			"</div></td></tr></table></td></tr><tr><td><center><input type='submit' name='submit' value='" .
			wfMsg( 'whitelistnewtablereview' ) . "' /></center></td></tr></table></form>"
		);
	}

	function DisplayContractorSelectForm() {
		global $wgOut, $wgWhiteListRestrictedGroup, $wgWhiteListUsePrettyCalendar;
		$dbr = wfGetDB( DB_SLAVE );

		$wgOut->addWikiText( wfMsg( 'whitelistselectrestricted' ) );

		if ( $wgWhiteListUsePrettyCalendar )
		{
			if ( !class_exists( "SpecialUserStats" ) )
				$wgOut->addWikiText( wfMsg( 'whitelistnocalendar' ) );
		}

		$users = array();
		$dbr->begin();
		$res = $dbr->select( 'user_groups', 'ug_user', array( 'ug_group' => $wgWhiteListRestrictedGroup ), __METHOD__ );
		$dbr->commit();

		for ( $row = $dbr->fetchObject( $res ); $row; $row = $dbr->fetchObject( $res ) ) {
			$u = WhiteListUserFromID( $row->ug_user );
			$users[$row->ug_user] = $u->getRealName();
			if ( $users[$row->ug_user] == "" )
				$users[$row->ug_user] = $u->getName();
		}
		$dbr->freeResult( $res );

		if( !count( $users ) ) {
			$wgOut->addWikiText( wfMsg( 'whitelistnowhitelistedusers' ) );
		} else {
			$wgOut->addHTML( "<form method=\"post\">" );
			$wgOut->addHTML( '<select name="contractor">' );
	
			asort( $users );
			foreach ( $users as $id => $name ) {
				$wgOut->addHTML( "<option value=\"$id\">" . $name . "</option>" );
			}
			$wgOut->addHTML( '</select> ' );
			$wgOut->addHTML( "<input type=\"submit\" value=\"" . wfMsg( 'whitelistnewtableprocess' ) . "\" />" );
			$wgOut->addHTML( "</form>" );
		}
		return;
	}

	function contractorWhiteListTable( $dbr, $contractorId )
	{
		$dbr->begin();
		$res = $dbr->select( 'whitelist',
			array(
				'wl_id',
				'wl_page_title',
				'wl_allow_edit',
				'wl_expires_on',
				'wl_updated_by_user_id',
				'wl_updated_on'
			),
			array( 'wl_user_id' => $contractorId ),
			__METHOD__
		);
		$dbr->commit();
		return $res;
	}

	function ExpandWildCardWhiteList( $wl_pattern )
	{
		global $wgOut, $wgContLanguageCode, $wgWhiteListWildCardInsensitive;

		$dbr = wfGetDB( DB_SLAVE );
		$expanded = array();
		$whitelisted = array();
		$debug = 0;
		$dbr->debug($debug);

		# extract the NameSpace (the first part before the optional first colon followed by the article name
		$pattern = '/^((:?)(.*?):)?(.*)$/';
		$pattern .= $wgWhiteListWildCardInsensitive ? 'i' : '';

		if (preg_match($pattern, $wl_pattern, $matches)) {
if ($debug)
{
	$wgOut->addWikiText("* found something for '$wl_pattern'");
	ob_start();
	print_r($matches);
	$wgOut->addWikiText(ob_get_contents());
	ob_end_flush();
}
			global $wgContLang;
			$found = array();
			$found['title'] = $matches[4];
			$found['ns'] = '%';

			if (method_exists('Language', 'Factory')) {
				$ns = Language::Factory( $wgContLanguageCode );
			} else {
				$ns = $wgContLang;
			}
			if ( $matches[1] == ':' && $matches[2] == '' )
				$found['ns'] = NS_MAIN;
			if ( $nsindex = $ns->getNsIndex( $matches[3] ) )
				$found['ns'] = $nsindex;
			if ( !is_int( $found['ns'] ) && ( $found['ns'] == '%' ) )
				$found['title'] = $wl_pattern;

			$found['title'] = str_replace( '*', '%',  $found['title'] );
			$found['title'] = str_replace( ' ', '_',  $found['title'] );
			array_push( $expanded, $found );

			# process the talk categories as well as the underlying categories
			if ( is_int( $found['ns'] ) && $found['ns'] >= NS_MAIN ) {
				if ( $found['ns'] % 2 )
					$found['ns']--;
				else
					$found['ns']++;
				array_push( $expanded, $found );
			}
		}

		if ( $debug )
{
	$wgOut->addWikiText("expanded array is");
	ob_start();
			print_r( $expanded );
	$wgOut->addWikiText(ob_get_contents());
	ob_end_flush();
}
		foreach ( $expanded as $entry ) {
			$sql = "SELECT `page_id` FROM " . $dbr->tableName( 'page' ) .
				" WHERE CONVERT(`page_namespace` USING utf8) LIKE CONVERT('" . $entry['ns'] .
				"' USING utf8) AND CONVERT(`page_title` USING utf8) LIKE CONVERT('" . $entry['title'] . 
				"' USING utf8)";
			if ($wgWhiteListWildCardInsensitive) {
				$sql = "SELECT `page_id` FROM ". $dbr->tableName('page') .
				" WHERE UPPER(CONVERT(`page_namespace` USING utf8)) LIKE CONVERT('" . strtoupper($entry['ns']) .
				"' USING utf8) AND UPPER(CONVERT(`page_title` USING utf8)) LIKE CONVERT('" . strtoupper($entry['title']) . 
				"' USING utf8)";
			}
if ($debug) $wgOut->addWikiText("the SQL query is :$sql:\n<br>");
			$dbr->begin();
			$res = $dbr->query( $sql, __METHOD__ );
			$dbr->commit();
			for ( $row = $dbr->fetchObject( $res ); $row; $row = $dbr->fetchObject( $res ) )
				array_push( $whitelisted, $row->page_id );

			$dbr->freeResult( $res );
		}

		if ( $debug )
{
	$wgOut->addWikiText("Whitelisted array is");
	ob_start();
	print_r( $whitelisted );
	$wgOut->addWikiText(ob_get_contents());
	ob_end_flush();
}
		return $whitelisted;
	}

	// createlink:  negative = No link
	//                  zero = Only if possible
	//              Positive = Link
	function DisplayWildCardMatches( $pagename, $headertext, $createlink = 1 )
	{
		global $wgOut;
		$debug = 0;

		$wildcard_match = self::ExpandWildCardWhiteList( $pagename );
if ($debug) $wgOut->addWikiText("* tried to find matches for '$pagename'\n");
		$num_matches = count( $wildcard_match );
if ($debug) $wgOut->addWikiText("** found $num_matches\n");
		$need_bullet = 0;
		if ( substr( $headertext, 0, 1 ) == '*' )
		{
			$need_bullet = 1;
			$headertext = substr( $headertext, 1 );
		}
		if ( ( $num_matches <= 1 ) && !preg_match( '/\%/', $pagename ) ) {
			if ( $createlink >= 0 )
			$headertext = "[[:$pagename|$headertext]]";
			if ( $need_bullet )
			$headertext = '* ' . $headertext;
if ($debug)  $wgOut->addWikiText("* Adding '$headertext'\n");
			$wgOut->addWikiText( $headertext );
			return;
		}

		if ( $createlink > 0 )
			$headertext = "[[:$pagename|$headertext]]";
		if ( $debug )
			print "Adding '$headertext'\n";

		$wgOut->addHTML( '<div class="NavFrame" style="padding:0px;border-style:none;">' );
		$wgOut->addHTML( '<div class="NavHead" style="background: #ffffff; text-align: left; font-size:100%;">' );
		# this is a hack to make the [show]/[hide] always appear after the text
		$wgOut->addHtml("$headertext" . wfMsgExt('whitelistnummatches', array( 'parsemag' ), $num_matches) . "&nbsp;<font color='#ffffff'>[show]</font>&nbsp;</div>");
		$wgOut->addHTML( '<div class="NavContent" style="display:none; font-size:normal; text-align:left">' );

		foreach ( $wildcard_match as $pageid )
		{
			$page = Title::newFromId( $pageid );
			$link = ":* [[:" . $page->getNsText() . ":" . $page->getText() . "|" . $page->getNsText() . ":" . $page->getText() . "]]";
			$wgOut->addWikiText( $link );
			if ( $debug )
				print "Adding '$link'\n";
		}
		$wgOut->addHTML( '</div></div>' );
	}
}

class WhiteList extends SpecialPage
{
	function __construct() {
		self::loadMessages();
		SpecialPage::SpecialPage( 'WhiteList', 'restricttowhitelist' );
	}

	function loadMessages() {
		# the new method for loading extension messages is only available in MW versions > 1.12
		# so let's keep the compatibility with older versions
		if (function_exists('wfLoadExtensionMessages'))
		{
			wfLoadExtensionMessages('WhiteList');
		}
		else
		{
			WhiteListLoadMessages();
		}
		
		return true;
	}

	function execute( $para ) {
		global $wgRequest, $wgOut, $wgUser, $wgWhiteListOverride, $wgWhiteListManagerGroup, $wgWhiteListRestrictedGroup, $wgSitename;

		$dbr = wfGetDB( DB_SLAVE );

		if ( !isset( $para ) || $para == '' ) {
			$user = $wgUser;
		} else {
			$user = WhiteListUserFromId( $user );
		}

		$this->setHeaders();
		$wgOut->setPagetitle( wfMsg( 'whitelist' ) );

		if ( !in_array( $wgWhiteListRestrictedGroup, $user->getGroups() ) )
		{
			if( !$userName = $user->getRealName() ) {
				$userName = $user-> getName();
			}
			$wgOut->addWikiText( wfMsg( 'whitelistnonrestricted', $userName ) );
			return true;
		}

		if ( $wgRequest->getVal( 'submit', '' ) == wfMsg( 'whitelistnewtableprocess' ) )
		{
			$sender = new MailAddress( $wgUser->getEmail(), $wgUser->getRealName() );
			$to = '';
			if ( constant( "MW_USER_VERSION" ) < 4 ) {
				$to = new User();
				$to->mId = $wgRequest->getint( 'manager', 0 );
			} else {
				$to = WhiteListUserFromId( $wgRequest->getint( 'manager', 0 ) );
			}

			// FIXME: I think this mail will be sent in the wrong language.
			$requestedPages = $wgRequest->getVal( 'newPages' );
			$requestedPagesCount = count( $requestedPages );
			$to->sendMail(
				"[${wgSitename}] " . wfMsg( 'whitelistrequest' ),
				wfMsgExt(
					'whitelistrequestmsg',
					array( 'parsemag' ),
					$wgUser->getRealName(),
					$requestedPages,
					$requestedPagesCount ),
				$sender->toString()
			);

			$wgOut->addWikiText( wfMsg( 'whitelistrequestconf', $to->getRealName() ) );
			$wgOut->addWikiText( "" );
		}

		$wgOut->addHTML( "<table cellspacing=0 cellpadding=2 border=1 width=100%><tr>" );
		$wgOut->addHTML( "<th>" . wfMsg( 'whitelistpagelist', $user->getRealName() ) . "</th><th>" . wfMsg( 'whitelistrequest' ) . "</th>" );
		$wgOut->addHTML( "</tr><tr><td width=30%>" );

		$res = WhiteListEdit::contractorWhiteListTable( $dbr, $user->getId() );

		for ( $row = $dbr->fetchObject( $res ); $row; $row = $dbr->fetchObject( $res ) )
			WhiteListEdit::DisplayWildCardMatches( $row->wl_page_title, $row->wl_page_title, 0 );

		$dbr->freeResult( $res );
		$pages = array();
		foreach ( $wgWhiteListOverride['always']['read'] as $page )
			array_push( $pages, $page );

		foreach ( $wgWhiteListOverride['always']['edit'] as $page )
			array_push( $pages, $page );

		sort( $pages );
		foreach ( $pages as $page )
			WhiteListEdit::DisplayWildCardMatches( $page, $page, 0 );

		$wgOut->addHTML( "</td><td valign=top>" );
		$wgOut->addHTML( "<table cellspacing=0 cellpadding=2 border=0 width=100%><tr><td align='right'>$wgWhiteListManagerGroup:</td><td>" );
		$wgOut->addHTML( "<form method=\"post\">" );
		$wgOut->addHTML( '<select name="manager">' );

		$users = array();
		$dbr->begin();
		$res = $dbr->select( 'user_groups', 'ug_user', array( 'ug_group' => $wgWhiteListManagerGroup ), __METHOD__ );
		$dbr->commit();
		for ( $row = $dbr->fetchObject( $res ); $row; $row = $dbr->fetchObject( $res ) ) {
			$u = WhiteListUserFromID( $row->ug_user );
			$users[$u->getRealName()] = $row->ug_user;
		}
		$dbr->freeResult( $res );
		ksort( $users );
		foreach ( $users as $name => $id )
			$wgOut->addHTML( "<option value=\"$id\">" . $name . "</option>" );
		$wgOut->addHTML( '</select> ' );

		$wgOut->addHTML( "</td></tr><tr><td align='right'>" . wfMsg( 'mywhitelistpages' ) . ":</td><td>" );
		$wgOut->addHTML( "<textarea name='newPages' cols=40 rows=5></textarea>" );
		$wgOut->addHTML( "</td></tr><tr><td colspan=2><center>" );
		$wgOut->addHTML( "<input type='submit' name='submit' value='" . wfMsg( 'whitelistnewtableprocess' ) . "' />" );
		$wgOut->addHTML( "</form>" );
		$wgOut->addHTML( "</center></td></tr></table>" );
		$wgOut->addHTML( "</td></tr></table>" );
		$wgOut->addHTML( "</td></tr></table>" );
	}
}

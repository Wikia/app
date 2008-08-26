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

define("WHITELIST_GRANT", 1);
define("WHITELIST_DENY", -1);
define("WHITELIST_NOACTION", 0);

class WhitelistExec
{

	/* $result value:
	 *   true=Access Granted
	 *   false=Access Denied
	 *   null=Don't know/don't care (not 'allowed' or 'denied')
	 * Return value:
	 *   true=Later functions can override.
	 *   false=Later functions not consulted.
	 */
	static function CheckWhitelist(&$title, &$wgUser, $action, &$result) {

		$override = WHITELIST_NOACTION;


		/* Bail if the user isn't restricted.... */
		if( !in_array('restricttowhitelist', $wgUser->getRights()) ) {
			$result = null; /* don't care */
			return true; /* Later functions can override */
		}

		/* Sanity Check */
		if (!$title)
			return $hideMe;

		# If this is a talk page, we need to check permissions
		# of the subject page instead...
		$true_title = $title->getSubjectPage();

		/* Check global allow/deny lists */
		$override = self::GetOverride($true_title, $action);
                
                /* Check if page is on whitelist */
                if( WHITELIST_NOACTION == $override )
                        $override = self::IsAllowedNamespace( $true_title, $wgUser, $action );

		/* Check if page is on whitelist */
		if( WHITELIST_NOACTION == $override )
			$override = self::IsAllowed( $true_title, $wgUser, $action );

		/* Check if user page */
		if( WHITELIST_NOACTION == $override )
			$override = self::IsUserPage( $true_title->GetPrefixedText(), $wgUser );

		switch( $override )
		{
			case WHITELIST_GRANT:
				$result = true; /* Allow other checks to be run */
				return true; /* Later functions can override */
				break;
			case WHITELIST_DENY:
			case WHITELIST_NOACTION:
			default: /* Invalid - shouldn't be possible... */
				$result = false; /* Access Denied */
				return false; /* Later functions not consulted */
		}
	}

	/* Check for global page overrides (allow or deny)
	 */
	static function GetOverride($title, $action )
	{
		global $wgWhitelistOverride;

                $allowView = $allowEdit = $denyView = $denyEdit = false;
 
                foreach( $wgWhitelistOverride['always']['read'] as $value )
                {
                        if( self::RegexCompare($title, $value) )
                        {
                                $allowView = true;
                        }
                }
 
                foreach( $wgWhitelistOverride['always']['edit'] as $value )
                {
                        if( self::RegexCompare($title, $value) )
                        {
                                $allowEdit = true;
                        }
                }

		$override = undef;

		foreach( $wgWhitelistOverride['never']['read'] as $value )
                {
                        if( self::RegexCompare($title, $value) )
                        {
                                $denyView = true;
                        }
                }
 
                foreach( $wgWhitelistOverride['never']['edit'] as $value )
                {
                        if( self::RegexCompare($title, $value) )
                        {
                                $denyEdit = true;
                        }
                }

		if( $action == 'edit' )
		{
			if( $denyEdit || $denyView )
				$override = WHITELIST_DENY;
			else if( $allowEdit )
				$override = WHITELIST_GRANT;
			else
				$override = WHITELIST_NOACTION;
		}
		else
		{
			if( $denyView )
				$override = WHITELIST_DENY;
			else if( $allowView || $allowEdit )
				$override = WHITELIST_GRANT;
			else
				$override = WHITELIST_NOACTION;
		}

		return $override;
	}

	/* Allow access to user pages (unless disabled)
	 */
	static function IsUserPage( $title_text, &$wgUser )
	{
		global $wgWhitelistAllowUserPages;

		$userPage = $wgUser->getUserPage()->getPrefixedText();
		$userTalkPage = $wgUser->getTalkPage()->getPrefixedText();

		if( ($wgWhitelistAllowUserPages == true) &&
			($title_text == $userPage) || ($title_text == $userTalkPage) )
			return WHITELIST_GRANT;
		else
			return WHITELIST_NOACTION;
	}

        static function IsAllowedNamespace( &$title, &$wgUser, $action)
        {

                $page_ns = $title->getNsText();
                if(     ($page_ns == 'Mediawiki' ) ||
                        ($page_ns == 'Image' ) || 
                        ($page_ns == 'Help' ) )
                {
                        return WHITELIST_GRANT;
                }

                return WHITELIST_NOACTION;
        }


	/* Check whether the page is whitelisted.
	 * returns true if page is on whitelist, false if it is not.
	 */
	static function IsAllowed( &$title, &$wgUser, $action )
	{
		$expired = false;

		/* Get all valid database rows for the user.
		 * Throw out any results which do not give sufficient
		 * privilege for the current action.
		 */
		$dbr = wfGetDB( DB_SLAVE );

		$wl_table_name = $dbr->tableName( 'whitelist' );
		$current_date = date("Y-m-d H:i:s");
		$sql = "SELECT wl_page_title 
			FROM " . $wl_table_name . "
			WHERE wl_user_id = "     . $dbr->addQuotes($wgUser->getId()) . "
			AND ( (wl_expires_on >= " . $dbr->addQuotes($current_date)  . ") 
			 OR ( wl_expires_on = "  . $dbr->addQuotes('') . "))";
		if( $action == 'edit' ) {
			$sql .= "
                        AND wl_allow_edit = " . $dbr->addQuotes('1');
		}
		#print $sql;

                // We should also check that $title is not a redirect to a whitelisted page
                $redirecttitle = NULL;
                $article = new Article($title);
                if (is_object($article))
                {
                        $pagetext = $article->getContent();
                        $redirecttitle = Title::newFromRedirect($pagetext);
                }
                        
		/* Loop through each result returned and
		 * check for matches.
		 */
                $dbr->begin();
		$db_results = $dbr->query( $sql , __METHOD__, true);
                $dbr->commit();
		while( $db_result = $dbr->fetchObject($db_results) )
		{
			if( self::RegexCompare($title, $db_result->wl_page_title) )
			{
				$dbr->freeResult($db_results);
				#wfDebug("\n\nAccess granted based on PAGE [" . $db_result->wl_page_title . "]\n\n");
				return WHITELIST_GRANT;
			}
                        if ($redirecttitle)
                        {
                                if( self::RegexCompare($redirecttitle, $db_result->wl_page_title) )
                                {
                                        $dbr->freeResult($db_results);
                                        #wfDebug("\n\nAccess granted based on REDIRECT to PAGE [" . $db_result->wl_page_title . "]\n\n");
                                        return WHITELIST_GRANT;
                                }
                        }
		}
		$dbr->freeResult($db_results);

		return WHITELIST_NOACTION;
	}

	/* Returns true if hit, false otherwise */
	static function RegexCompare(&$title, $sql_regex)
	{
                global $wgWhitelistWildCardInsensitive;
                
		$ret_val = false;
                
		/* Convert regex to PHP format */
		$php_regex = str_replace('%', '.*', $sql_regex);
                $php_regex = str_replace('_', ' ', $php_regex);
		$php_regex = ltrim($php_regex, ":");

		/* Generate regex; use | as delimiter as it is an illegal title character. */
		$php_regex_full = '|^' . $php_regex . '$|';
                if ($wgWhitelistWildCardInsensitive)
                        $php_regex_full .= 'i';

#print( $php_regex_full . " [" . $title->getPrefixedText() . "]<br />\n");
		if (self::preg_test($php_regex_full)) {
			if( preg_match( $php_regex_full, $title->getPrefixedText() ) ) {
#print("MATCH!!");
				$ret_val = true;
			}
		}
		
		return $ret_val;
	}

	# test to see if a regular expression is valid
	function preg_test($regex)
	{
		if (sprintf("%s",@preg_match($regex,'')) == '')
		{
			$error = error_get_last();
			return false;
		}
		else
		return true;
	}
} /* End class */

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

if (!defined("WHITELIST_GRANT")) {
	define("WHITELIST_GRANT", 1);
}
if (!defined("WHITELIST_DENY")) {
	define("WHITELIST_DENY", -1);
}
if (!defined("WHITELIST_NOACTION")) {
	define("WHITELIST_NOACTION", 0);
}

class WhiteListExec
{

	/* $result value:
	 *   true=Access Granted
	 *   false=Access Denied
	 *   null=Don't know/don't care (not 'allowed' or 'denied')
	 * Return value:
	 *   true=Later functions can override.
	 *   false=Later functions not consulted.
	 */
	static function CheckWhiteList(&$title, &$wgUser, $action, &$result) {

		$override = WHITELIST_NOACTION;


		/* Bail if the user isn't restricted.... */
		if( !in_array('restricttowhitelist', $wgUser->getRights()) ) {
			$result = null; /* don't care */
			return true; /* Later functions can override */
		}

		/* Sanity Check */
		if (!$title)
			return false;

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
		global $wgWhiteListOverride;

                $allowView = $allowEdit = $denyView = $denyEdit = false;
 
                foreach( $wgWhiteListOverride['always']['read'] as $value )
                {
                        if( self::RegexCompare($title, $value) )
                        {
                                $allowView = true;
                        }
                }
 
                foreach( $wgWhiteListOverride['always']['edit'] as $value )
                {
                        if( self::RegexCompare($title, $value) )
                        {
                                $allowEdit = true;
                        }
                }

		unset($override);

		foreach( $wgWhiteListOverride['never']['read'] as $value )
                {
                        if( self::RegexCompare($title, $value) )
                        {
                                $denyView = true;
                        }
                }
 
                foreach( $wgWhiteListOverride['never']['edit'] as $value )
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
		global $wgWhiteListAllowUserPages;

		$userPage = $wgUser->getUserPage()->getPrefixedText();
		$userTalkPage = $wgUser->getTalkPage()->getPrefixedText();

		if( ($wgWhiteListAllowUserPages == true) &&
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
//wfDebug($sql);

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
//wfDebug("\n\nAccess granted based on PAGE [" . $db_result->wl_page_title . "]\n\n");
				return WHITELIST_GRANT;
			}
                        if ($redirecttitle)
                        {
                                if( self::RegexCompare($redirecttitle, $db_result->wl_page_title) )
                                {
                                        $dbr->freeResult($db_results);
//wfDebug("\n\nAccess granted based on REDIRECT to PAGE [" . $db_result->wl_page_title . "]\n\n");
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
                global $wgWhiteListWildCardInsensitive;
                
		$ret_val = false;
                
		/* Convert regex to PHP format */
		$illegal_chars = array(
			'%', 
			'_', 
			'\\', 
			'(',
			')', 
			'$', 
			'^', 
			'[', 
			']'
		);
		$escaped_chars = array(
			'.*',  
			' ', 
			'\\\\', 
			'\(', 
			'\)', 
			'\$', 
			'\^', 
			'\[', 
			'\]'
		);
		$php_regex = str_replace($illegal_chars, $escaped_chars, $sql_regex);
		$php_regex = ltrim($php_regex, ":");

		/* Generate regex; use | as delimiter as it is an illegal title character. */
		$php_regex_full = '|^' . $php_regex . '$|';
                if ($wgWhiteListWildCardInsensitive)
                        $php_regex_full .= 'i';

//print("* Comapring '" . $php_regex_full . "' to page title '" . $title->getPrefixedText() . "'\n");
		if (self::preg_test($php_regex_full)) {
			if( preg_match( $php_regex_full, $title->getPrefixedText() ) ) {
//print("** MATCH\n");
				$ret_val = true;
			} 
			else
			{
//print("** fail\n");			
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

class WhiteListHooks {
	function AddRestrictedPagesTab(&$personal_urls, $wgTitle)
	{
	    global $wgUser, $wgWhiteListRestrictedGroup;

	    $userIsRestricted = in_array( $wgWhiteListRestrictedGroup, $wgUser->getGroups() );

	    if ($wgUser->isLoggedIn() && $userIsRestricted) {
		# In older versions of MW, loading of message files was done differently than the
		# current default. So, let's work around that by forcing the load of the message file.
		WhiteList::loadMessages();
		
		$personal_urls['mypages'] = array(
		    'text' => wfMsg('mywhitelistpages'),
		    'href' => Skin::makeSpecialUrl('WhiteList')
		);
	    }
	    return true;
	}
	
	// TODO - this is missing from Siebrand's changes
	function CheckSchema()
	{
		return true;
	}
} /* End class */

<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */

$wgExtensionFunctions[] = 'wfSpecialLookupContribsFinalSetup';

$wgAvailableRights[] = 'lookupcontribsfinal';
$wgGroupPermissions['staff']['lookupcontribsfinal'] = true;

/**
 * constructor
 */
function wfSpecialLookupContribsFinalSetup() {

/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */

class LookupContribsFinalForm extends SpecialPage {
	var $mName, $mPassword, $mRetype, $mReturnto, $mCookieCheck, $mPosted;
	var $mAction, $mCreateaccount, $mCreateaccountMail, $mMailmypassword;
	var $mLoginattempt, $mRemember, $mEmail;

	function LookupContribsFinalForm() {
		global $wgLang, $wgAllowRealName;
		global $wgRequest;

		SpecialPage::SpecialPage("LookupContribsFinal");
	}

	function execute() {
	  global $wgRequest,$wgUser,$wgOut;

	  $this->mName = trim($wgRequest->getText( 'wpName' ));
	  $this->mAction = trim($wgRequest->getText( 'action' ));
	    $this->setupMessages();

	  $wgOut->setPageTitle( wfMsg( 'lookupcontribsfinalpagetitle' ) );
	  $wgOut->setRobotpolicy( 'noindex,nofollow' );
	  $wgOut->setArticleRelated( false );


	    if( $this->mPosted ) {
	      global $wgOut;
	      if (  'submit' == $this->mAction ) {
		$this->processRequest();
	      }

	    }
	    $this->mainCreateWikiForm( '' );
	    return $retval;
	  }
	/**
	 * @access private
	 */
	function processRequest() {
		global $wgUser, $wgOut;

		if ( !in_array( 'createwiki', $wgUser->getRights() ) ) {
		  return;
		}
		$wgOut->setPageTitle( wfMsg( 'lookupcontribsfinalpagetitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
 
		return htmlspecialchars( $error );
	}


	/**
	 * @access private
	 */
	function mainCreateWikiForm( $err ) {
		global $wgUser, $wgOut, $wgLang;
		global $wgDBname, $wgAllowRealName;

		$yn = wfMsg( 'yourname' );
                $cwtt = wfMsg( 'createwikititle' );
                $cwn = wfMsg( 'createwikiname' );
                $cwl = wfMsg( 'createwikilang' );
                $nvt = wfMsg( 'createwikinamevstitle' );
                $cwd = wfMsg( 'createwikidesc' );
                $cwa = wfMsg( 'createwikiaddtnl' );
                $cwt = wfMsg(($wgUser->isAllowed('createwiki'))?'createwikistafftext':'createwikitext' );
                $rcw = wfMsg( 'requestcreatewiki' );
		$ye = wfMsg( 'youremail' );

		if ( '' == $this->mName ) {
			if ( 0 != $wgUser->getID() ) {
				$this->mName = $wgUser->getName();
			} else {
				$wgOut->addHTML(wfMsg('createwikilogin'));
				return;
			}
		}

		$wgOut->setPageTitle( wfMsg( 'createwikipagetitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$q = 'action=submit';

		$titleObj = Title::makeTitle( NS_SPECIAL, 'CreateWiki' );
		$action = $titleObj->escapeLocalUrl( $q );

		$encName = htmlspecialchars( $this->mName );
		$encEmail = htmlspecialchars( $this->mEmail );

		if ($wgUser->getID() != 0) {
			$cambutton = "<input tabindex='6' type='submit' name=\"wpCreateaccountMail\" value=\"{$cam}\" />";
		} else {
			$cambutton = '';
		}

		$lcase_name = strtolower($this->mWikiName);
		$wgOut->addHTML( "
        {$cwt}
	<form name=\"createwiki\" id=\"createwiki\" method=\"post\" action=\"{$action}\">

	<table border='0'><tr>
	<td align='right'>$yn:</td>
	<td align='left'>{$encName}
	<input tabindex='1' type='hidden' name=\"wpName\" value=\"{$encName}\" size='35' />
	</td>
	
	</tr>

	<tr>
	<td align='right'>$ye:</td>
	<td align='left'>
	<input tabindex='2' type='text' name=\"wpEmail\" value=\"{$encEmail}\" size='35' />
	</td>
        </tr>
     <tr>
	<td align='right'>$cwn:</td>
	<td align='left'>
	<input tabindex='3' type='text' name=\"wpCreateWikiName\" value=\"$lcase_name\" size='35' />
	</td>

	</tr>
	<tr>
	<td align='right'>$cwtt:</td>
	<td align='left'>
	<input tabindex='4' type='text' name=\"wpCreateWikiTitle\" value=\"$this->mWikiTitle\" size='35' />
	</td>
	
	</tr>
   
<tr>
	<td align='right'>$cwl:</td>
	<td align='left'>");

		global $wgLang,$wgContLanguageCode;
		$languages = $wgLang->getLanguageNames();

		if( !array_key_exists( $wgContLanguageCode, $languages ) ) {
			$languages[$wgContLanguageCode] = $wgContLanguageCode;
		}
		ksort( $languages );
	
		$selectedLang = isset( $languages[$this->mWikiLang] ) ? $this->mWikiLang : $wgContLanguageCode;
#		$selectedLang = isset( $languages[$this->mUserLanguage] ) ? $this->mUserLanguage : $wgContLanguageCode;
		$selbox = null;
		foreach($languages as $code => $name) {
			global $IP;
			/* only add languages that have a file */
			$langfile="$IP/languages/Language".str_replace('-', '_', ucfirst($code)).".php";
			if(file_exists($langfile) || $code == $wgContLanguageCode) {
				$sel = ($code == $selectedLang)? ' selected="selected"' : '';
				$selbox .= "<option value=\"$code\"$sel>$code - $name</option>\n";
			}
		}
		$wgOut->addHTML("<select name=\"wpCreateWikiLang\">$selbox</select>");
		if($wgUser->isAllowed('createwiki')){
		  $wgOut->addHTML("        <input type=checkbox name=\"wpCreateWikiIncludeLang\"> Include language prefix in URL (for multi-language wikis)<br />");
		  $wgOut->addHTML("        <input type=checkbox name=\"wpCreateMailList\" checked=\"checked\"> Create Mailing list");
		}
$wgOut->addHTML("	</td>

	</tr>
        <tr>
	<td align='right'>$cwd:</td>
	<td align='left'>
	<textarea tabindex='6' name=\"wpCreateWikiDesc\" value=\"\" rows=\"6\" cols=\"60\" />$this->mWikiDesc</textarea>
	</td>
	
	</tr>


	<tr>
	<td align='right'>$cwa:</td>
	<td align='left'>
	<textarea tabindex='7' name=\"wpCreateWikiAddtnl\" value=\"\" rows=\"6\" cols=\"60\" />$this->mWikiAddtnl</textarea>
	</td>
        </tr>



<tr><td align='left' colspan='2'>
	<input tabindex='8' type='submit' name=\"actionRequestWiki\" value=\"{$rcw}\" />");
if(in_array( 'createwiki', $wgUser->getRights() )){
  $wgOut->addHTML("	<input tabindex='8' type='submit' name=\"actionCreateWiki\" value=\"create this wiki\" />");
  if($this->mLoadID){
    $wgOut->addHTML("	<input type='hidden' name=\"load_id\" value=\"$this->mLoadID\" />");
    $wgOut->addHTML("	<input tabindex='8' type='submit' name=\"actionChangeRequest\" value=\"save changes\" />");
    $wgOut->addHTML("	<input tabindex='8' type='submit' name=\"actionDenyRequest\" value=\"deny request\" />");
  }
}
 $wgOut->addHTML("</td></tr>");

if(in_array( 'createwiki', $wgUser->getRights() )){
  $wgOut->addHTML("	<tr><td colspan=2><select name=req_id>");
  $dbw = wfGetDB(DB_MASTER);
  $res = $dbw->select("`wikicities`.request_list",
			 array('req_id','req_name'),
			 array('req_state' => "new"));
  $wgOut->addHTML($dbw->numRows($res));
  while($obj = $dbw->fetchObject( $res )){
    
    $wgOut->addHTML("<option value = \"$obj->req_id\">$obj->req_name</option>");
  }

  $wgOut->addHTML("</select><input tabindex='8' type='submit' name=\"actionLoadRequest\" value=\"load request\" /></td></tr>");
}

  $wgOut->addHTML("<tr><td colspan='2'>
        {$nvt}
</td></tr>
");
		    
	    
		$wgOut->addHTML("</table></form>\n" );
		$wgOut->addHTML( $endText );
	}

	/**
	 * @access private
	 */
	function setupMessages() {
	  global $wgMessageCache;
	  $wgMessageCache->addMessages( array('createwiki' => 'Request a new wiki',
					      'createwikipagetitle' => 'Request a new wiki',
					      'createwikilogin' => 'Please <a href="/index.php?title=Special:Userlogin&returnto=Special:CreateWiki" class="internal" title="create an account or log in">create an account or log in</a> before requesting a wiki.',
					      'createwikistafftext' => 'You are staff, so you can create a new wiki using this page',
					      'createwikitext' => 'You can request a new wiki be created on this page.  Just fill out the form',
					      'createwikititle' => 'Title for the wiki',
					      'createwikiname' => 'Name for the wiki',
					      'createwikinamevstitle' => 'The name for the wiki differs from the title of the wiki in that the name is what will be used to determine the default url.  For instance, a name of "starwars" would be accessible as http://starwars.wikia.com/. The title of the wiki may contain spaces, the name should only contain letters and numbers.',
					      'createwikidesc' => 'Description of the wiki',
					      'createwikiaddtnl' => 'Additional Information',
					      'createwikimailsub' => 'Request for a new Wikia',
					      'requestcreatewiki' => 'Request Wiki',
					      'createwikisubmitcomplete' => 'Your submission is complete.  If you gave an email address, you will be contacted regarding the new Wiki.  Thank you for using {{SITENAME}}.',
					      'createwikicreatecomplete' => 'Your wiki creation is complete.  ',
					      'createwikichangecomplete' => 'Your changes have been saved.',
					      'createwikilang' => 'Default language for this wiki',
					      ) );
	}
	
	
	function hasSessionCookie() {
	  global $wgDisableCookieCheck;
	  return ( $wgDisableCookieCheck ) ? true : ( '' != $_COOKIE[session_name()] );
	}
	  
	/**
	 * @access private
	 */
	function cookieRedirectCheck( $type ) {
		global $wgOut, $wgLang;

		$titleObj = Title::makeTitle( NS_SPECIAL, 'Userlogin' );
		$check = $titleObj->getFullURL( 'wpCookieCheck='.$type );

		return $wgOut->redirect( $check );
	}

	/**
	 * @access private
	 */
	function onCookieRedirectCheck( $type ) {
		global $wgUser;

		if ( !$this->hasSessionCookie() ) {
			if ( $type == 'new' ) {
				return $this->mainLoginForm( wfMsg( 'nocookiesnew' ) );
			} else if ( $type == 'login' ) {
				return $this->mainLoginForm( wfMsg( 'nocookieslogin' ) );
			} else {
				# shouldn't happen
				return $this->mainLoginForm( wfMsg( 'error' ) );
			}
		} else {
			return $this->successfulLogin( wfMsg( 'loginsuccess', $wgUser->getName() ) );
		}
	}

	/**
	 * @access private
	 */
	function throttleHit( $limit ) {
		global $wgOut;

		$wgOut->addWikiText( wfMsg( 'acct_creation_throttle_hit', $limit ) );
	}
}

SpecialPage::addPage( new CreateWikiForm );
global $wgMessageCache;
$wgMessageCache->addMessage( 'createwiki', 'Create a wiki' );
}
?>

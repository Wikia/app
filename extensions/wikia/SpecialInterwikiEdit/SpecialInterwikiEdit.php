<?php
/**
 * Special:InterwikiEdit for web-based handling of interwiki links
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author: Lucas 'TOR' Garczewski <tor@wikia.com>
 * @author: Lucas 'Egon' Matysiak <egon@wikia.com>
 *
 * @copyright Copyright (C) 2007 Lucas 'TOR' Garczewski & Lucas 'Egon' Matysiak, Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 * @todo Validate link urls, automated umbrella update option, proper internationalization,
 * @todo add support for non-$wgSharedDB wikis
 */

if (!defined('MEDIAWIKI')){
    echo ('THIS IS NOT VALID ENTRY POINT.'); exit (1);
}

$wgExtensionFunctions [] = 'wfInitializeSpecialInterwikiEdit';
$wgExtensionMessagesFiles['SpecialInterwikiEdit'] = dirname(__FILE__) . '/SpecialInterwikiEdit.i18n.php';
$wgSpecialPageGroups['InterwikiEdit'] = 'wiki';

function wfInitializeSpecialInterwikiEdit(){
	global $wgExternalSharedDB;

	if( empty( $wgExternalSharedDB ) ) {
	        return true;
	}
	global $wgAvailableRights, $wgGroupPermissions, $wgMessageCache, $IP;

	require_once ($IP. '/includes/SpecialPage.php');

    # Allow group STAFF to use this extension.
    $wgAvailableRights [] = 'InterwikiEdit';
    $wgGroupPermissions ['staff']['InterwikiEdit'] = True;
    SpecialPage::AddPage (new SpecialPage ('InterwikiEdit', 'InterwikiEdit', True, 'wfSpecialInterwikiEdit', False));
}

function wfSpecialInterwikiEdit (){
	global $wgOut, $wgRequest;
	$action = $wgRequest->getVal('action', 'choose');
	//$lang_only = $wgRequest->getVal('lang_only', 1);

	wfLoadExtensionMessages('SpecialInterwikiEdit');

	if ($action != 'choose') $ret = "<p class='subpages'>&lt; <a href=''>Back to menu</a></p>";
	else $ret = "";

	switch ($action){
		case 'Change umbrella' :
		case 'change_umbrella_commit' : $ret .= wfSIWEChangeUmbrella(); break;
		case 'commit_link' : $ret .= wfSIWELinkWikisCommit (); break;
		case 'Link': $ret .= wfSIWELinkWikis(); break;
		case 'edit_interwiki' :
		case 'delete_interwiki' :
		case 'Edit interwiki': $ret .= wfSIWEEditInterwiki(); break;
	    case 'choose':
	    default : $ret .= wfSIWEChooseAction();
	}

	$wgOut->setPageTitle(wfMsg('iwedit-title'));
	$wgOut->AddHTML ($ret);
}

function wfSIWEGetWikiaData($wikia=null, $wikiaID=null){
	global $wgOut, $wgLanguageNames, $wgExternalSharedDB;

	if (!$wikia && !$wikiaID ){
	        $wgOut->addHTML("No wikia specified <br />\n<br />\n");
	        return false;
	}

	$wikiaDB = null;
	$result = null;
	$wikia = trim($wikia);
	$db =& wfGetDB (DB_SLAVE, array(), $wgExternalSharedDB);

	if (empty($wikiaID)){
		$wikiaID = 0;

	        # citydomain autocompletion -- .wikia.com is appended if:
		# (a) there's no dot in cityname we add .wikia.com
		# (b) there's one dot in cityname and the first part is a language code
		$domain = explode('.', $wikia);
		if ( count($domain) == 1 || ( count($domain) == 2 && array_key_exists($domain[0], $wgLanguageNames) ) ) {
        	    $wikia = $wikia.".wikia.com";
		}

		$oRes = $db->select( "city_domains", "city_id, city_domain",
	            array("city_domain" => $wikia), array("limit" => 1), __METHOD__);

		if ($dbobject = $db->fetchObject($oRes)){
			$wikiaID = $dbobject->city_id;
		}

	}

        $result = $db->select('city_list', 'city_id,city_dbname,city_url,city_umbrella,city_lang', "city_id = ". $db->addQuotes($wikiaID));

	if ($dbobject = $db->fetchObject($result)){
	        return array(
	        	$dbobject->city_id,
	        	$dbobject->city_dbname,
	        	$dbobject->city_url,
	        	$dbobject->city_umbrella,
	        	$dbobject->city_lang
	        );

	}else{
	        $wgOut->addHTML("Didn't manage to find wikia for url with: '". htmlspecialchars($wikia). "'<br />\n<br />\n");
	        return false;
	}
}

function wfSIWEChooseAction(){
	return "<form id='chooseaction' action='' method='POST'>
	<table>
	<tr><td>
	<label for='wikia'> Primary wiki: </label>
	</td><td>
	<input type='text' name='wikia' />
	</td><td>
	<input type='submit' value='Edit interwiki' name='action' />
	&nbsp <input type='submit' value='Change umbrella' name='action' />
	</td></tr>
	<tr><td>
	<label for='ext_wikia'> Secondary wiki: </label>
	</td><td>
	<input type='text' name='ext_wikia' />
	</td><td>
	<input type='submit' value='Link' name='action' />
	</td></tr>
	</table>
	</form>";
}

function wfSIWEChangeUmbrella(){
	global $wgRequest, $wgExternalSharedDB;

	list($wikia, $wikiaID) = wfSIWEGetRequestData();

	$db = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

	list($wikiaID, , $wikiaURL, $wikiaUmbrella) = wfSIWEGetWikiaData($wikia, $wikiaID);
	if (!isset($wikiaURL)) return false;

	if ( $wgRequest->getVal('action')=='change_umbrella_commit' ){
		$wikiaUmbrella = $wgRequest->getVal( 'wikiaUmbrella', '');

		$result = $db->update('city_list',array('city_umbrella' => $wikiaUmbrella), array('city_id ' => $wikiaID));
		list(,,,$wikiaUmbrellaNew) = wfSIWEGetWikiaData(null, $wikiaID);
		$ret .= "<p>Umbrella for ". htmlspecialchars($wikiaURL). " is now set to ".
			htmlspecialchars($wikiaUmbrellaNew). "</p>\n";

	} else {

	$ret.= "<form id='edit_form' action='' method='POST'>
		<p>Change umbrella for ". htmlspecialchars($wikiaURL). " from '". htmlspecialchars($wikiaUmbrella). "' to: </p>\n
		<input type='text' name='wikiaUmbrella' />
		<input type='hidden' name='action' value='change_umbrella_commit' />
		<input type='hidden' name='wikia_id' value='". htmlspecialchars($wikiaID). "' />
		<input type='submit' value='Change' />
	</form>";
	}

	return $ret;
}

function wfSIWEEditInterwiki(){
	global $wgOut, $wgRequest;

	$ret = '';

	list($wikia, $wikiaID) = wfSIWEGetRequestData();
	list($wikiaID, $wikiaDB, $wikiaURL) = wfSIWEGetWikiaData($wikia, $wikiaID);

	if (!$wikiaDB){
	        return wfSIWEChooseAction();
	}
	$db = wfGetDB (DB_MASTER, array(), $wikiaDB );

	$db =& wfGetDB (DB_MASTER, array(), $wikiaDB );

	global $wgLanguageNames, $IP;
#	$lang_names = array_keys($wgLanguageNames);

	$fields['iw_prefix'] = htmlspecialchars($wgRequest->getVal('iw_prefix', null));
	$fields['iw_url'] = htmlspecialchars($wgRequest->getVal('iw_url', null));
	$conf = $wgRequest->getVal('iw_local_conf',null);
	if ($conf != null) {
		$fields['iw_local'] = $conf;
	} else {
		$fields['iw_local'] = ($wgRequest->getCheck('iw_local')) ? 1 : 0;
	}
	$conf = $wgRequest->getVal('iw_trans_conf',null);
	if ($conf != null) {
		$fields['iw_trans'] = $conf;
	} else {
		$fields['iw_trans'] = ($wgRequest->getCheck('iw_trans')) ? 1 : 0;
	}

	$from = htmlspecialchars($wgRequest->getVal('from', null));

	$old_prefix = htmlspecialchars($wgRequest->getVal('old_prefix', ''));
	$old_url = htmlspecialchars($wgRequest->getVal('old_url', ''));

	$action = htmlspecialchars($wgRequest->getVal('action'));

	if ($action != 'Edit interwiki' && ($fields['iw_prefix'] == null || $fields['iw_url'] == null))
		$ret .= "<p><b>Error:</b> You didn't specify a URL and/or a prefix.</p>";

	#Edit or delete if requested...
	if ( ($action=='edit_interwiki' || $action=='delete_interwiki') && $fields['iw_prefix'] && $fields['iw_url']){

		switch ($action) {
			case 'edit_interwiki' :
#				Allow for non-language interwikis (rt#12266)
#				if (!in_array($fields['iw_prefix'], $lang_names)) {
#		        	$ret .= "<b>Error:</b> incorrect language interwiki prefix: $iw_prefix<br />\n";
#					break;
#				}
				if ( $fields['iw_prefix'] != $old_prefix ){
					$res = $db->select(
						'interwiki',
						array( '*'),
						array('iw_prefix' => $fields['iw_prefix']),
						__METHOD__
					);

					if ( $dbObject = $db->fetchObject($res) ){

						$ret .= "Prefix exists. Do you really want to change from:<br />\n";
						$ret .= "Prefix:'{$dbObject->iw_prefix}' URL:'{$dbObject->iw_url}' LOCAL:'{$dbObject->iw_local}' TRANS:'{$dbObject->iw_trans}'<br />\n";
						$ret .= "To<br />\n";
						$ret .= "Prefix:'". $fields['iw_prefix']. "' URL:'". $fields['iw_url']. "' LOCAL:'". $fields['iw_local']. "' TRANS:'". $fields['iw_trans']. "'<br />\n";
						$ret .= "<form id='same_prefix_confirmation' action='' method='POST'>
							<input type='hidden' name='iw_url' value='". $fields['iw_url']. "' />
							<input type='hidden' name='old_prefix' value='". $fields['iw_prefix']. "' />
							<input type='hidden' name='iw_prefix' value='". $fields['iw_prefix']. "' />
							<input type='hidden' name='iw_local_conf' value='". $fields['iw_local']. "' />
							<input type='hidden' name='iw_trans_conf' value='". $fields['iw_trans']. "' />
							<input type='hidden' name='action' value='edit_interwiki' />
							<input type='hidden' name='wikia_id' value='$wikiaID' />
							<input type='submit' value='".wfMsg('yes')."' />
							</form>";
					}else{
						$ret .= "<p>Changeing interwiki...<br />\n";
						$res = $db->insert( 'interwiki', $fields, __METHOD__ );

	  					if ($res){
   						$ret.= "<p>Prefix <b>". $fields['iw_prefix']. "</b> edited for <a href='$wikiaURL'>$wikiaURL</a> to:<ul>\n
  							<li>url: ". $fields['iw_url']. "</li>\n
  							<li>local: ". $fields['iw_local']. "</li>\n
  							<li>trans: ". $fields['$iw_trans']. "</li>\n
							</ul></p>\n";
  						}else{
	  		        			$ret .= "Database error: data not changed</p>\n";
	  					}
  					}
				}else{
			        	$ret .= "<p>Changing interwiki...<br />\n";
		        		$res = $db->query("INSERT INTO " .
		        				"`interwiki` (iw_prefix,iw_url,iw_local,iw_trans) " .
		        				"VALUES (". $db->addQuotes($fields['iw_prefix']). ",". $db->addQuotes($fields['iw_url']). ",".
		        				$db->addQuotes($fields['iw_local']). ",". $db->addQuotes($fields['iw_trans']). ") ".
		        				"ON DUPLICATE KEY ".
		        				"UPDATE iw_url=". $db->addQuotes($fields['iw_url']).
		        				", iw_local=". $db->addQuotes($fields['iw_local']).
		        				", iw_trans=". $db->addQuotes($fields['iw_trans']), __METHOD__ );

	  				if ($res){
  						$ret.= "Prefix <b>". $fields['iw_prefix']. "</b> edited for <a href='$wikiaURL'>$wikiaURL</a> to:<ul>\n
  							<li>url: ". $fields['iw_url']. "</li>\n
  							<li>local: ". $fields['iw_local']. "</li>\n
  							<li>trans: ". $fields['iw_trans']. "</li>\n
							</ul></p>\n";
  					}else{
	  		        		$ret .= "Database error: data not changed</p>\n";
  					}
				}
				break;
			case 'delete_interwiki' :

			    $ret .= "<p>Deleting interwiki selected interwiki...";

				$res = $db->delete('interwiki', $fields, __METHOD__ );

	  			if ($res){
  					$ret.= " Done.<br />Prefix <b>". $fields['iw_prefix']. "</b> deleted for <a href='$wikiaURL'>$wikiaURL</a></p>\n";
  				}else{
  		        	$ret .= "Database error: data not deleted</p>\n";
  				}
			break;
		}
	}



	# $limit = 10;

	# JavaScript for automated form updates
	# FIXME - should use YUI
	include_once("$IP/extensions/wikia/GetUserAgent/GetUserAgent.php");
	$agent = GetUserAgent();

	if ($agent['is_ie']) {
		$document = "document.all";
	} else {
		$document = "document";
	}

	$ret .= "

	<script type=\"text/javascript\">
	function updateForm( data ){
	        var form = {$document}.getElementById('edit_form');

	        if (form && data){
	                data = data.split('|');
	                form.iw_prefix.value = data[0];
	               	form.old_prefix.value = data[0];
	                form.iw_url.value = data[1];
	                form.old_url.value = data[1];
	                if (data[2]==1){
	                        form.iw_local.checked='checked';
	                }else {
	                        form.iw_local.checked='';
	                }
	                if (data[3]==1){
	                        form.iw_trans.checked='checked';
	                }else {
	                        form.iw_trans.checked='';
	                }

	        }else{
	                alert('JS error: didn\'t manage to get some HTML element');
	        }
	}

	function updateAction(action){
	        var form = {$document}.getElementById('edit_form');
	        if (form){
	                if (action == 'delete' ){
	                	form.action.value='delete_interwiki';
	                } else {
						form.action.value='edit_interwiki';
	                }
	                form.submit();
	        }else{
	                alert('JS error: did not manage to change edit form action');
	        }
	}
	</script>";

	$ret .= "<p>Editing interwiki table for <a href='$wikiaURL'>$wikiaURL</a><br />\n";
    $ret .= "<form id='settings' action='' method='POST'>
	<label for='from'>Show from: <label><input type='text' id='from' name='from' value= ". $db->addQuotes($from). " />
	<input type='submit' value='". wfMsg('iwedit-update') ."' />
	<input type='hidden' name='wikia_id' value='$wikiaID' />
	<input type='hidden' name='action' value='Edit interwiki' />
	</form> </p>";

#	$languages = "'".$lang_names[0]."'";
	//$lang_names = array_slice($lang_names, 1);
#	foreach ( $lang_names as $lang_name){
#	  $languages .= ", '$lang_name'";
#	}
	if ($from) $from = "WHERE iw_prefix like '". $db->escapeLike($from). "%'";
	$result = $db->query("SELECT * FROM `$wikiaDB`.`interwiki` $from;");

	$ret .= "<p><select multiple='multiple' onchange='updateForm( this.value );'>\n";
	while( $dbObject = $db->fetchObject($result)){
	        $ret .= "<option id='{$dbObject->iw_prefix}'>{$dbObject->iw_prefix}|{$dbObject->iw_url}|{$dbObject->iw_local}|{$dbObject->iw_trans}</option>\n";
	}
	$ret .= "</select></p>\n";

	$ret .= "
	<form id='edit_form' action='' method='POST'>
	<table>
		<tr>
			<td>
				<label for='iw_prefix'>Interwiki Prefix</label>
			</td>
			<td>
				<input name='iw_prefix' value='' />
			</td>
		</tr>
		<tr>
			<td>
				<label for='iw_url'>Interwiki URL</label>
			</td>
			<td>
				<input name='iw_url' value='' />
			</td>
		</tr>
		<tr>
			<td>
				<label for='iw_local'>Local?</label>
			</td>
			<td>
				<input type='checkbox' name='iw_local' value='1' />
			</td>
		</tr>
		<tr>
			<td>
				<label for='iw_trans'>Trans?</label>
			</td>
			<td>
				<input type='checkbox' name='iw_trans' value='1' />
			</td>
		</tr>
	</table>
	<input type='hidden' name='action' value='edit_interwiki' />
	<input type='hidden' name='wikia' value='$wikia' />
	<input type='hidden' name='wikia_id' value='$wikiaID' />
	<input type='hidden' name='old_prefix' value='' />
	<input type='hidden' name='old_url' value='' />
	<input type='button' onclick='updateAction(\"edit\");' value='".wfMsg('save')."' /> &nbsp
	<input type='button' onclick='updateAction(\"delete\");' value='".wfMsg('delete')."' />
	</form>";

	return $ret;
}

function wfSIWELinkWikis(){
	global $wgOut;

	list($wikia, $wikiaID, $ext_wikia, $ext_wikiaID) = wfSIWEGetRequestData();

	list($wikiaID, $wikiaDB, $wikiaURL, $wikiaUmbrella, $wikiaLang) = wfSIWEGetWikiaData($wikia, $wikiaID);
	list($ext_wikiaID, $ext_wikiaDB, $ext_wikiaURL, $ext_wikiaUmbrella, $ext_wikiaLang) = wfSIWEGetWikiaData($ext_wikia, $ext_wikiaID);

	if ($wikiaID == $ext_wikiaID) return "<p>Same wiki specified in primary and secondary fields. Refusing to link wiki to self.</p>";

	#if ($wikiaUmbrella != $ext_wikiaUmbrella) {
	#	$ret .= ("<p><b>Warning!</b> Umbrellas for $wikiaURL [<a href='". $_SERVER['PHP_SELF'].
	#	"?action=change_umbrella&amp;wikia_id=$wikiaID'>edit</a>] and $ext_wikiaURL [<a href='".
	#	$_SERVER['PHP_SELF']. "?action=change_umbrella&amp;wikia_id=$ext_wikiaID'>edit</a>] <b>do not match</b>.");
	#}

	$ret .= "<p>The following interwiki links will be added:</p>\n
    <table class='wikitable'>
    <tr>
    <th colspan='3'>wiki to process</th>
    <th colspan='4'>interwiki data</th>
    </tr>
    <tr>
    <th>wiki ID</th>
    <th>URL</th>
    <th>DB name</th>
    <th>interwiki prefix</th>
    <th>interwiki link</th>
    <th>local interwiki</th>
    <th>allow transclusion</th>
    </tr>
    <tr>
    <td>$wikiaID</td>
    <td>$wikiaURL</td>
    <td>$wikiaDB</td>
    <td>$ext_wikiaLang</td>
    <td>". wfSIWEMakeInterlanguageUrl($ext_wikiaID). "</td>
    <td>1</td>
    <td>0</td>
    </tr>
    <tr>
    <td>$ext_wikiaID</td>
    <td>$ext_wikiaURL</td>
    <td>$ext_wikiaDB</td>
    <td>$wikiaLang</td>
    <td>". wfSIWEMakeInterlanguageUrl($wikiaID). "</td>
    <td>1</td>
    <td>0</td>
    </tr>
    </table>
	<form id='chooseaction' action='' method='POST'>

	<p>If the data above is correct, press ". wfMsg('yes'). ", otherwise go to Special:WikiFactory and modify
	\$wgArticlePath and \$wgServer</p>

	<input type='submit' value='".wfMsg('yes')."' />

	<input type='hidden' name='action' value='commit_link' />
	<input type='hidden' name='wikia_id' value='$wikiaID' />
	<input type='hidden' name='ext_wikia_id' value='$ext_wikiaID' />
	</form>";

	return $ret;
}

function wfSIWELinkWikisCommit () {
	list( , $wikiaID, , $ext_wikiaID) = wfSIWEGetRequestData();

	if (wfSIWELinkWikisCommitProper ($wikiaID, $ext_wikiaID) && wfSIWELinkWikisCommitProper ($ext_wikiaID, $wikiaID)) {
		$ret = wfMsg('iwedit-success');
	} else {
		$ret = wfMsg('iwedit-error');
	}

	return $ret;
}

function wfSIWEMakeInterlanguageUrl($wikiaID) {

    $link_url = WikiFactory::getVarValueByName( 'wgServer', $wikiaID );
	$link_url .= WikiFactory::getVarValueByName( 'wgArticlePath', $wikiaID );

	return $link_url;
}

function wfSIWELinkWikisCommitProper ($linker, $linkee) {

	list( , $linkerDB) = wfSIWEGetWikiaData( '', $linker);
	list( , , , , $iw_prefix) = wfSIWEGetWikiaData( '', $linkee);

	$db =& wfGetDB( DB_MASTER, array(), $linkerDB );
	if ($db->selectDB($linkerDB)) {
		return (bool) $db->query("REPLACE INTO `$linkerDB`.`interwiki`(iw_prefix, iw_url, iw_local, iw_trans)" .
				" values('". $iw_prefix. "','". wfSIWEMakeInterlanguageUrl($linkee). "',1,0);");
	} else {
		return false;
	}

}

function wfSIWEGetRequestData() {
	global $wgRequest;

	return array(
		htmlspecialchars($wgRequest->getVal('wikia')),
		htmlspecialchars($wgRequest->getVal('wikia_id', false)),
		htmlspecialchars($wgRequest->getVal('ext_wikia')),
		htmlspecialchars($wgRequest->getVal('ext_wikia_id', false)),
	);
}
?>

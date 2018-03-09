<?php

/**
 * @package MediaWiki
 * @subpackage WikiFactory
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: 0.1
 *
 * helper classes & functions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named WikiFactory.\n";
    exit( 1 ) ;
}

/**
 * Exceptions to be thrown by AJAX request handlers
 *
 * @see PLATFORM-1476
 *
 * - WikiFactoryInvalidRequestException for requests that should be sent as POST
 * - WikiFactoryInvalidTokenException for requests with invalid token
 */
abstract class WikiFactoryRequestException extends WikiaException {}

class WikiFactoryInvalidRequestException extends WikiFactoryRequestException {
	function __construct( $message ) {
		parent::__construct( 'POST request should be made to ' . $message );
	}
}

class WikiFactoryInvalidTokenException extends WikiFactoryRequestException {
	function __construct( $message ) {
		parent::__construct( 'Token check failed for ' . $message );
	}
}

/**
 * Check given request and make sure that:
 *
 *  - it's a POST request (throws WikiFactoryInvalidRequestException otherwise)
 *  - it has a valid token (throws WikiFactoryInvalidTokenException otherwise)
 *
 * @see PLATFORM-1476
 *
 * @param WebRequest $request
 * @param User $user
 * @param string $method
 * @throws WikiFactoryRequestException
 */
function axWFactoryValidateRequest( WebRequest $request, User $user, $method ) {
	if ( !$request->wasPosted() ) {
		throw new WikiFactoryInvalidRequestException( $method );
	}

	if ( !$user->matchEditToken( $request->getVal( 'token' ) ) ) {
		throw new WikiFactoryInvalidTokenException( $method );
	}
}

############################## Ajax methods ##################################

/**
 * axWFactoryTagCheck
 *
 * Method for checking tag name and getting number of tagged wikis
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @access public
 *
 * @return json data
 */
function axWFactoryTagCheck() {
	global $wgRequest, $wgUser;

	// this request needs to be a POST and has a valid token passed (PLATFORM-1476)
	axWFactoryValidateRequest( $wgRequest, $wgUser, __METHOD__ );

	if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
		return;
	}

	$tagName = $wgRequest->getVal( "tagName" );
	if( !empty( $tagName ) ) {
		$tagsQuery = new WikiFactoryTagsQuery( $tagName );
		$wikiIds = $tagsQuery->doQuery();
		$result = array(
			'tagName' => $tagName,
			'wikiCount' => count( $wikiIds ),
			'divName' => 'wf-variable-parse'
		);
	}
	else {
		$result = array(
			'errorMsg' => 'empty tag name',
			'divName' => 'wf-variable-parse',
			'wikiCount' => 0
		);
	}

	return json_encode( $result );
}


/**
 * axWFactoryGetVariable
 *
 * Method for getting variable form via AJAX request.
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
 * @access public
 *
 * @return HTML code with variable data
 */
function axWFactoryGetVariable() {
	global $wgRequest, $wgUser, $wgOut, $wgPreWikiFactoryValues;

	if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
		$wgOut->readOnlyPage(); #--- FIXME: later change to something reasonable
		return;
	}

	$cv_id = $wgRequest->getVal("varid");
	$city_id = $wgRequest->getVal("wiki");

	$variable = WikiFactory::getVarById( $cv_id, $city_id );

        // BugId:3054
        if ( empty( $variable ) ) {
            return json_encode( array( 'error' => true, 'message' => 'No such variable.' ) );
        }

	$related = array();
	$r_pages = array();
	if (preg_match("/Related variables:(.*)$/", $variable->cv_description, $matches)) {
		$names = preg_split("/[\s,;.()]+/", $matches[1], null, PREG_SPLIT_NO_EMPTY);
		foreach ($names as $name) {
			$rel_var = WikiFactory::getVarByName( $name, $city_id );
			if (!empty($rel_var)) $related[] = $rel_var;
			else {
				if (preg_match("/^MediaWiki:.*$/", $name, $matches2)) {
					$r_pages[] = array(
									"url" => GlobalTitle::newFromText( $name, 0, $city_id )->getFullURL()
									);
				}
			}
		}
	}
	$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
	$oTmpl->set_vars( array(
		"cityid"        => $city_id,
		"variable"      => $variable,
		"groups"        => WikiFactory::getGroups(),
		"accesslevels"  => WikiFactory::$levels,
		"related"       => $related,
		"related_pages" => $r_pages,
		"preWFValues"   => $wgPreWikiFactoryValues,
		'wikiFactoryUrl' => Title::makeTitle( NS_SPECIAL, 'WikiFactory' )->getFullUrl()
	));

	$response = new AjaxResponse(json_encode( array(
		"div-body" => $oTmpl->render( "variable" ),
		"div-name" => "wk-variable-form"
	)));

	$response->setCacheDuration(0);
	$response->setContentType('application/json; charset=utf-8');
	return $response;
}

/**
 * axWFactoryChangeVariable
 *
 * Method for getting a change-variable form via AJAX request.
 * This is for changing the variable itself (discription, groups, etc.), NOT for
 * changing the values set on each wiki.
 *
 * @author Sean Colombo
 * @access public
 *
 * @return HTML code with variable-edit form
 */
function axWFactoryChangeVariable() {
	global $wgRequest, $wgUser, $wgOut;

	if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
		$wgOut->readOnlyPage(); #--- FIXME: later change to something reasonable
		return;
	}

	$cv_id = $wgRequest->getVal("varid");
	$city_id = $wgRequest->getVal("wiki");

	$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

	$variable = WikiFactory::getVarById( $cv_id, $city_id );
	$vars = array(
			"title"             => Title::makeTitle( NS_SPECIAL, 'WikiFactory' ),
			"groups"            => WikiFactory::getGroups(),
			"accesslevels"      => WikiFactory::$levels,
			"types"             => WikiFactory::$types,
			"cv_variable_id"    => $variable->cv_variable_id,
			"cv_name"           => $variable->cv_name,
			"cv_variable_type"  => $variable->cv_variable_type,
			"cv_access_level"   => $variable->cv_access_level,
			"cv_variable_group" => $variable->cv_variable_group,
			"cv_description"    => $variable->cv_description,
		);
	$oTmpl->set_vars($vars);

	return json_encode( array(
		"div-body" => $oTmpl->render( "change-variable" ),
		"div-name" => "wk-variable-form"
	));
}

/**
 * axWFactorySubmitChangeVariable
 *
 * Method for getting a change-variable form via AJAX request.
 * This is for changing the variable itself (discription, groups, etc.), NOT for
 * changing the values set on each wiki.
 *
 * @author Sean Colombo
 * @access public
 *
 * @return HTML code with variable-edit form
 */
function axWFactorySubmitChangeVariable() {
	global $wgRequest, $wgUser, $wgOut;

	// this request needs to be a POST and has a valid token passed (PLATFORM-1476)
	axWFactoryValidateRequest( $wgRequest, $wgUser, __METHOD__ );

	if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
		$wgOut->readOnlyPage(); #--- FIXME: later change to something reasonable
		return;
	}

	$cv_variable_id = $wgRequest->getVal("cv_variable_id");
	$city_id = $wgRequest->getVal("wiki");
	$cv_name = $wgRequest->getVal("cv_name");
	$cv_variable_type = $wgRequest->getVal("cv_variable_type");
	$cv_access_level = $wgRequest->getVal("cv_access_level");
	$cv_variable_group = $wgRequest->getVal("cv_variable_group");
	$cv_description = $wgRequest->getval("cv_description");

	// Verify that the form is filled out, then add the variable if it is (display an error if it isn't).
	$errMsg = "";
	if($cv_name == ""){
		$errMsg .= "<li>Please enter a name for the variable.</li>\n";
	}
	if(!in_array($cv_variable_type, WikiFactory::$types)){
		$errMsg .= "<li>The value \"$cv_variable_type\" was not recognized as a valid WikiFactory::\$type.</li>\n";
	}
	if(!in_array($cv_access_level, array_keys(WikiFactory::$levels))){
		$errMsg .= "<li>The value \"$cv_access_level\" was not recognized as a valid key from WikiFactory::\$levels.</li>\n";
	}
	if(!in_array($cv_variable_group, array_keys(WikiFactory::getGroups()))){
		$errMsg .= "<li>The value \"$cv_variable_group\" was not recognized as a valid group_id from city_variables_groups table as returned by WikiFactory::getGroups()</li>\n";
	}
	if($cv_description == ""){
		$errMsg .= "<li>Please enter a description of what the variable is used for.</li>\n";
	}
	if($errMsg == ""){
		$success = WikiFactory::changeVariable($cv_variable_id, $cv_name, $cv_variable_type, $cv_access_level, $cv_variable_group, $cv_description);
		if(!$success){
			$errMsg .= "<li>There was a database error while trying to change the variable.  Please see the logs for more info.</li>";
		}
	}

	$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
	$variable = WikiFactory::getVarById( $cv_variable_id, $city_id );
	if($errMsg != ""){
		$errHtml = "";
		$errHtml .= "<div style='border:1px #f00 solid;background-color:#faa;padding:5px'>";
		$errHtml .= "<strong>ERROR: Unable to update variable!</strong>";
		$errHtml .= "<ul>\n$errMsg</ul>\n";
		$errHtml .= "</div>";
		$vars = array(
				"error_message"     => $errHtml,
				"title"             => Title::makeTitle( NS_SPECIAL, 'WikiFactory' ),
				"groups"            => WikiFactory::getGroups(),
				"accesslevels"      => WikiFactory::$levels,
				"types"             => WikiFactory::$types,
				"cv_variable_id"    => $cv_variable_id,
				"cv_name"           => $cv_name,
				"cv_variable_type"  => $cv_variable_type,
				"cv_access_level"   => $cv_access_level,
				"cv_variable_group" => $cv_variable_group,
				"cv_description"    => $cv_description,
			);
		$oTmpl->set_vars($vars);

		return json_encode( array(
			"div-body" => $oTmpl->render( "change-variable" ),
			"div-name" => "wk-variable-form"
		));
	} else {
		// Set it back to the normal form for just setting the variable's value for the current wiki.
		$oTmpl->set_vars( array(
			"cityid"        => $city_id,
			"variable"      => WikiFactory::getVarById( $cv_variable_id, $city_id ),
			"groups"        => WikiFactory::getGroups(),
			"accesslevels"  => WikiFactory::$levels,
		));

		// Inject a success message above the form so that the user know the updates worked.
		$html = "";
		$html .= "<div style='border:1px #0f0 solid;background-color:#afa;padding:5px'>";
		$html .= "<strong>{$variable->cv_name}</strong> successfully updated.";
		$html .= "</div>";

		return json_encode( array(
			"div-body" => $html . $oTmpl->render( "variable" ),
			"div-name" => "wk-variable-form"
		));
	}
}

function axWFactoryDomainCRUD($type="add") {
    global $wgRequest, $wgUser, $wgExternalSharedDB, $wgOut;
    $sDomain = htmlspecialchars( $wgRequest->getVal("domain") );
    $city_id = $wgRequest->getVal("cityid");
    $reason  = htmlspecialchars( $wgRequest->getVal("reason") );

	// this request needs to be a POST and has a valid token passed (PLATFORM-1476)
	axWFactoryValidateRequest( $wgRequest, $wgUser, __METHOD__ );

    if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
        $wgOut->readOnlyPage(); #--- later change to something reasonable
        return;
    }
    if (empty($city_id)) {
        $wgOut->readOnlyPage(); #--- later change to something reasonable
        return;
    }
    $dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
    $aDomains = array();
    $aResponse = array();
    $sInfo = "";
    switch( $type ) {
		case "add":
			if (!preg_match("/^[\w\.\-]+$/", $sDomain)) {
				/**
				 * check if domain is valid (a im sure that there is function
				 * somewhere for such purpose
				 */
				$sInfo .= "Error: Domain <em>{$sDomain}</em> is invalid (or empty) so it's not added.";
			}
			else {
				$added = WikiFactory::addDomain( $city_id, $sDomain, $reason );
				if ( $added ) {
					$sInfo .= "Success: Domain <em>{$sDomain}</em> added.";
				}
				else {
					$sInfo .= "Error: Domain <em>{$sDomain}</em> is already used so it's not added.";
				}
			}
			break;
        case "change":
            $sNewDomain = htmlspecialchars( $wgRequest->getVal("newdomain") );
            #--- first, check if domain is not used
            $oRes = $dbw->select(
                "city_domains",
                "count(*) as count",
                array("city_domain" => $sNewDomain),
                __METHOD__
            );
            $oRow = $dbw->fetchObject( $oRes );
            $dbw->freeResult( $oRes );
            if ($oRow->count > 0) {
                #--- domain is used already
                $sInfo .= "<strong>Error: Domain <em>{$sNewDomain}</em> is already used so no change was done.</strong>";
            }
            elseif (!preg_match("/^[\w\.\-]+$/", $sNewDomain)) {
                #--- check if domain is valid (a im sure that there is function
                #--- somewhere for such purpose
                $sInfo .= "<strong>Error: Domain <em>{$sNewDomain}</em> is invalid so no change was done..</strong>";
            }
            else {
                #--- reall change domain
                $dbw->update(
                    "city_domains",
                    array("city_domain" => strtolower($sNewDomain)),
                    array(
                        "city_id" => $city_id,
                        "city_domain" => strtolower($sDomain)
                    )
                );

		$sLogMessage = "Domain <em>{$sDomain}</em> changed to <em>{$sNewDomain}</em>.";

		if ( !empty( $reason ) ) {
			$sLogMessage .= " (reason: {$reason})";
		}

		WikiFactory::log( WikiFactory::LOG_DOMAIN, $sLogMessage,  $city_id );

		$dbw->commit();
                $sInfo .= "Success: Domain <em>{$sDomain}</em> changed to <em>{$sNewDomain}</em>.";
            }
            break;
        case "remove":
		$removed = WikiFactory::removeDomain( $city_id, $sDomain, $reason );
		if ( $removed ) {
			$sInfo .= "Success: Domain <em>{$sDomain}</em> removed.";
		} else {
			$sInfo .= "Failed: Domain <em>{$sDomain}</em> was not removed.";
		}
            break;
        case "status":
            $iNewStatus = $wgRequest->getVal("status");
            if (in_array($iNewStatus, array(0,1,2))) {
                #--- updatec city_list table
                $dbw->update("city_list", array("city_public" => $iNewStatus),
                    array("city_id" => $city_id));
				$dbw->commit();
                switch ($iNewStatus) {
                    case 0:
                        $aResponse["div-body"] = "<strong>changed to disabled</strong>";
                        break;
                    case 1:
                        $aResponse["div-body"] = "<strong>changed to enabled</strong>";
                        break;
                    case 2:
                        $aResponse["div-body"] = "<strong>changed to redirected</strong>";
                        break;
                }
            }
            else {
                $aResponse["div-body"] = "wrong status number";
            }
            $aResponse["div-name"] = "wf-domain-span";
            break;
        case "cancel":
            $sInfo .= "<em>Action cancelled</em>";
            break;
        case "setmain":
						try {
							$setmain = WikiFactory::setmainDomain( $city_id, $sDomain, $reason );
							if ( $setmain ) {
								$sInfo .= "Success: Domain <em>{$sDomain}</em> set as main.";
							} else {
								$sInfo .= "Failed: Domain <em>{$sDomain}</em> was not set as main.";
							}
						} catch (WikiFactoryDuplicateWgServer $error) {
							$sInfo .= "Failed: " . $error->getMessage();
						}
            break;
    }
    #--- get actuall domain list
	 $aDomains = WikiFactory::getDomains( $city_id, true );

    #--- send response, return domain array
    $aResponse["domains"] = $aDomains;
    $aResponse["info"] = $sInfo;

    return json_encode($aResponse);
}

/**
 * clear wiki cache
 */
function axWFactoryClearCache()
{
    global $wgRequest, $wgUser, $wgOut, $wgWikiFactoryMessages;

    $city_id = $wgRequest->getVal("cityid");
    $iError = 0;
    $sError = "";

	// this request needs to be a POST and has a valid token passed (PLATFORM-1476)
	axWFactoryValidateRequest( $wgRequest, $wgUser, __METHOD__ );

    if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
        #--- no permission, do nothing
        $iError++;
        $sError = "no permission for removing";
    }
    if (empty($city_id)) {
        #--- no permission, do nothing
        $iError++;
        $sError = "city id missing";
    }

    if (empty($iError)) {
        WikiFactory::clearCache( $city_id );
        WikiFactory::clearInterwikiCache();

        #--- send response
        $aResponse = array(
            "div-body" => wfMsg("wikifactory_removeconfirm"),
            "div-name" => "wf-clear-cache"
        );
    }
    else {
        $aResponse = array(
            "div-body" => $sError,
            "div-name" => "wf-clear-cache"
        );
    }

    return json_encode($aResponse);
}

/**
 * axWFactoryDomainQuery
 *
 * used in autocompletion
 *
 * @return string JSON encoded array
 */
function axWFactoryDomainQuery() {
	global $wgRequest;

	$query = $wgRequest->getVal( "query", false );

	$return = array(
		"query"       => $query,
		"suggestions" => array(),
		"data"        => array()
	);

	$exact = array( "suggestions" => array(), "data" => array() );
	$match = array( "suggestions" => array(), "data" => array() );

	// query terms: wik, wiki, wikia take too much memory
	// and end up with fatal errors
	if ( substr("wikia",0,strlen((string)$query)) === $query ) {
		$query = false;
	}

	if( $query ) {
		/**
		 * maybe not very effective but used only by staff anyway
		 */
		$query = strtolower( $query );
		$dbr = WikiFactory::db( DB_SLAVE );
		$cityDomainLike = $dbr->buildLike( $dbr->anyString(), $query, $dbr->anyString() );

		$sth = $dbr->select(
			[ "city_domains" ],
			[ "city_id", "city_domain" ],
			[
				"city_domain not like 'www.%'",
				"city_domain not like '%.wikicities.com'",
				"city_domain {$cityDomainLike}"
			],
			__METHOD__,
			[
				'LIMIT' => 15
			]
		);

		while( $domain = $dbr->fetchObject( $sth ) ) {
			$domain->city_domain = strtolower( $domain->city_domain );
		    if( preg_match( "/^$query/", $domain->city_domain ) ) {
				$exact[ "suggestions" ][] = $domain->city_domain;
				$exact[ "data" ][] = $domain->city_id;
		    }
			elseif( preg_match( "/$query/", $domain->city_domain ) ){
				$match[ "suggestions" ][] = $domain->city_domain;
				$match[ "data" ][] = $domain->city_id;
			}
		}
		$return[ "suggestions" ] = array_merge( $exact[ "suggestions" ], $match[ "suggestions" ] );
		$return[ "data" ] = array_merge( $exact[ "data" ], $match[ "suggestions" ] );
	}

	$resp = new AjaxResponse( json_encode( $return ) );
	$resp->setContentType( 'application/json; charset=utf-8' );
	return $resp;
}

/**
 * axWFactoryFilterVariables
 *
 * Ajax call, return filtered group od variables
 *
 * @access public
 * @author eloy@wikia
 *
 * @return string: json string with array of variables
 */
function axWFactoryFilterVariables() {
	global $wgRequest, $wgUser;

	if ( !$wgUser->isAllowed('wikifactory') ) {
		return '';
	}
	$defined = wfStrToBool( $wgRequest->getVal("defined", "false") );
	$editable = wfStrToBool( $wgRequest->getVal("editable", "false") );
	$wiki_id = $wgRequest->getVal("wiki", 0);
	$group = $wgRequest->getVal("group", 0);
	$string = $wgRequest->getVal("string", false );

	#--- cache it?
	$Variables = WikiFactory::getVariables( "cv_name", $wiki_id, $group, $defined, $editable, $string );
	$selector = "";

	foreach( $Variables as $Var) {
		$selector .= Xml::element( 'option', [ 'value' => $Var->cv_id ], $Var->cv_name );
	}

	$resp = new AjaxResponse( json_encode( [ "selector" => $selector ] ) );
	$resp->setContentType( 'application/json; charset=utf-8' );
	return $resp;
}

/**
 * Provides an API for putting specific DB clusters in read-only mode (and back into R&W).
 *
 * You need to:
 *  - send an internal POST HTTP request
 *  - provide a valid Schwartz token
 *  - provide "cluster" and "readonly" request parameter
 *
 * @author macbre
 *
 * @see SUS-3873
 * @see https://wikia-inc.atlassian.net/wiki/spaces/SUS/pages/154632320/How+to+make+a+single+cluster+read-only
 */
function axWFactoryClusterSetReadOnly() : AjaxResponse {
	global $wgTheSchwartzSecretToken;
	$request = RequestContext::getMain()->getRequest();

	$resp = new AjaxResponse();

	// we only support internal requests with a proper token
	if ( !$request->wasPosted() || !$request->isWikiaInternalRequest() ) {
		$resp->setResponseCode(400); // bad request
		$resp->addText( json_encode( [
			'error' =>  'We only support internal POST requests'
		]) );
	}

	if ( !hash_equals( $wgTheSchwartzSecretToken, $request->getVal('token') ) ) {
		$resp->setResponseCode(403); // forbidden
		$resp->addText( json_encode( [
			'error' =>  'Invalid token provided'
		]) );
	}

	// which cluster do we want modify and whether to set or remove read-only flag
	$cluster = $request->getVal('cluster' );
	$readOnly = $request->getInt('readonly' ) === 1;

	$msg = sprintf( 'Putting %s cluster %s',
		$cluster,
		$readOnly ? 'into read-only mode' : 'back into write-read mode'
	);

	// perform WikiFactory changes on behalf of FANDOMbot
	global $wgUser;
	$wgUser = User::newFromName( Wikia::BOT_USER );

	if ( $readOnly ) {
		$ret = WikiFactory::setVarByName( 'wgReadOnlyCluster', Wikia::COMMUNITY_WIKI_ID, $cluster, $msg );
	} else {
		$ret = WikiFactory::removeVarByName( 'wgReadOnlyCluster', Wikia::COMMUNITY_WIKI_ID, $msg );
	}

	$resp->setResponseCode( $ret ? 200 : 500 );
	$resp->addText( json_encode( [
		'ok' => $ret,
		'msg' =>  $msg
	]) );

	$resp->setContentType( 'application/json; charset=utf-8' );
	return $resp;
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "axWFactoryGetVariable";
$wgAjaxExportList[] = "axWFactoryChangeVariable";
$wgAjaxExportList[] = "axWFactorySubmitChangeVariable";
$wgAjaxExportList[] = "axWFactoryFilterVariables";
$wgAjaxExportList[] = "axWFactoryDomainCRUD";
$wgAjaxExportList[] = "axWFactoryDomainQuery";
$wgAjaxExportList[] = "axWFactoryClearCache";
$wgAjaxExportList[] = "axWFactoryTagCheck";
$wgAjaxExportList[] = "axWFactoryClusterSetReadOnly";
